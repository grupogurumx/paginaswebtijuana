<?php
/**
 * Lightweight contact & catering forms (no plugin required).
 * Submissions are emailed to the address set in the Customizer
 * (falls back to the WordPress admin email). Spam protection: nonce + honeypot + timing.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render a form.
 *
 * @param string $type contact|catering.
 */
function agave_form( $type = 'contact' ) {
	$status = isset( $_GET['agave_form'] ) ? sanitize_key( wp_unslash( $_GET['agave_form'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	?>
	<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-reveal>
		<?php if ( 'sent' === $status ) : ?>
			<p class="form__notice form__notice--ok" role="status"><?php esc_html_e( '¡Gracias! Thank you — we received your message and will get back to you shortly.', 'agave' ); ?></p>
		<?php elseif ( 'error' === $status ) : ?>
			<p class="form__notice form__notice--error" role="alert"><?php esc_html_e( 'Something went wrong. Please call us or try again.', 'agave' ); ?></p>
		<?php endif; ?>

		<input type="hidden" name="action" value="agave_form">
		<input type="hidden" name="form_type" value="<?php echo esc_attr( $type ); ?>">
		<input type="hidden" name="ts" value="<?php echo esc_attr( time() ); ?>">
		<?php wp_nonce_field( 'agave_form', 'agave_nonce' ); ?>
		<p class="form__hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>

		<div class="form__grid">
			<label class="field"><span>Name *</span><input type="text" name="name" required autocomplete="name"></label>
			<label class="field"><span>Email *</span><input type="email" name="email" required autocomplete="email"></label>
			<label class="field"><span>Phone</span><input type="tel" name="phone" autocomplete="tel"></label>
			<?php if ( 'catering' === $type ) : ?>
				<label class="field"><span>Event date *</span><input type="date" name="event_date" required></label>
				<label class="field"><span>Guests *</span><input type="number" name="guests" min="10" step="1" required placeholder="25"></label>
				<label class="field"><span>Event type</span>
					<select name="event_type">
						<option>Birthday / Family party</option>
						<option>Office lunch / Corporate</option>
						<option>Wedding / Rehearsal</option>
						<option>Graduation / Quinceañera</option>
						<option>Game day / Other</option>
					</select>
				</label>
			<?php else : ?>
				<label class="field"><span>Subject</span>
					<select name="subject">
						<option>General question</option>
						<option>Large pickup order</option>
						<option>Feedback</option>
						<option>Press / Partnerships</option>
						<option>Jobs</option>
					</select>
				</label>
			<?php endif; ?>
			<label class="field field--full"><span><?php echo 'catering' === $type ? 'Tell us about your event *' : 'Message *'; ?></span><textarea name="message" rows="5" required></textarea></label>
		</div>
		<button class="btn btn--primary" type="submit" data-magnetic><span><?php echo 'catering' === $type ? 'Request my catering quote' : 'Send message'; ?></span><?php echo agave_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
		<p class="form__fine">We reply within one business day. For same-day orders call <a href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><?php echo esc_html( agave_biz( 'phone' ) ); ?></a>.</p>
	</form>
	<?php
}

/**
 * Handle submissions.
 */
function agave_handle_form() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'agave_form', $back );

	$valid = isset( $_POST['agave_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['agave_nonce'] ) ), 'agave_form' );
	$human = empty( $_POST['website'] ) && isset( $_POST['ts'] ) && ( time() - absint( $_POST['ts'] ) ) > 3;

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $valid || ! $human || ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'agave_form', 'error', $back ) . '#contact-form' );
		exit;
	}

	$type   = isset( $_POST['form_type'] ) && 'catering' === $_POST['form_type'] ? 'catering' : 'contact';
	$fields = array( 'phone', 'subject', 'event_date', 'guests', 'event_type' );
	$lines  = array( "Name: {$name}", "Email: {$email}" );
	foreach ( $fields as $field ) {
		if ( ! empty( $_POST[ $field ] ) ) {
			$lines[] = ucwords( str_replace( '_', ' ', $field ) ) . ': ' . sanitize_text_field( wp_unslash( $_POST[ $field ] ) );
		}
	}
	$lines[] = "\n" . $message;

	$to      = agave_biz( 'email' ) ? agave_biz( 'email' ) : get_option( 'admin_email' );
	$subject = 'catering' === $type ? '[Agave] New catering request from ' . $name : '[Agave] New message from ' . $name;
	$sent    = wp_mail( $to, $subject, implode( "\n", $lines ), array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	wp_safe_redirect( add_query_arg( 'agave_form', $sent ? 'sent' : 'error', $back ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_agave_form', 'agave_handle_form' );
add_action( 'admin_post_agave_form', 'agave_handle_form' );
