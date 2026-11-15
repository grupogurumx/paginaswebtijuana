<?php
/**
 * [sws_contact_form] — seat request / contact form with nonce + honeypot, sent via wp_mail().
 * Compatible with any SMTP plugin (WP Mail SMTP, FluentSMTP…).
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sws_sc_contact_form() {
	$status = isset( $_GET['sws_sent'] ) ? sanitize_key( wp_unslash( $_GET['sws_sent'] ) ) : '';
	$course = isset( $_GET['course'] ) ? sanitize_text_field( wp_unslash( $_GET['course'] ) ) : '';
	$opts   = array( 'Chemical Agent Instructor Course', 'Less Lethal Instructor Course', 'Both courses', 'Host a course at my agency', 'Other / general question' );
	ob_start();
	if ( 'ok' === $status ) {
		echo '<div class="notice notice--ok" role="status">Thank you — your request was received. Our team will reply within one business day.</div>';
	} elseif ( 'err' === $status ) {
		echo '<div class="notice notice--err" role="alert">Something went wrong. Please check the required fields or email us directly at ' . esc_html( sws_opt( 'email' ) ) . '.</div>';
	}
	?>
	<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="sws_contact">
		<?php wp_nonce_field( 'sws_contact', 'sws_nonce' ); ?>
		<input type="hidden" name="sws_return" value="<?php echo esc_url( get_permalink() ); ?>">
		<div class="hp" aria-hidden="true"><label for="sws_website">Website</label><input type="text" id="sws_website" name="sws_website" tabindex="-1" autocomplete="off"></div>
		<div class="row">
			<div><label for="sws_name">Full Name *</label><input id="sws_name" name="sws_name" required autocomplete="name"></div>
			<div><label for="sws_agency">Agency / Department *</label><input id="sws_agency" name="sws_agency" required autocomplete="organization"></div>
		</div>
		<div class="row">
			<div><label for="sws_email">Work Email *</label><input id="sws_email" type="email" name="sws_email" required autocomplete="email"></div>
			<div><label for="sws_phone">Phone</label><input id="sws_phone" type="tel" name="sws_phone" autocomplete="tel"></div>
		</div>
		<div class="row">
			<div><label for="sws_course">Course of Interest</label>
				<select id="sws_course" name="sws_course">
					<?php foreach ( $opts as $o ) : ?>
						<option <?php selected( stripos( $o, $course ) !== false && '' !== $course ); ?>><?php echo esc_html( $o ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div><label for="sws_seats">Number of Seats</label><input id="sws_seats" type="number" min="1" max="60" name="sws_seats" value="1"></div>
		</div>
		<div><label for="sws_msg">Message</label><textarea id="sws_msg" name="sws_msg" rows="5" placeholder="Preferred dates, Plan IV questions, hosting details…"></textarea></div>
		<div><button class="btn" type="submit">Send Request <span class="arrow">→</span></button></div>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'sws_contact_form', 'sws_sc_contact_form' );

function sws_handle_contact() {
	$back = isset( $_POST['sws_return'] ) ? esc_url_raw( wp_unslash( $_POST['sws_return'] ) ) : home_url( '/contact/' );
	$back = wp_validate_redirect( $back, home_url( '/contact/' ) );

	if ( ! isset( $_POST['sws_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sws_nonce'] ) ), 'sws_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sws_sent', 'err', $back ) . '#contact-form' );
		exit;
	}
	// Honeypot: silently accept bots.
	if ( ! empty( $_POST['sws_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sws_sent', 'ok', $back ) . '#contact-form' );
		exit;
	}
	$f = array();
	foreach ( array( 'name', 'agency', 'email', 'phone', 'course', 'seats' ) as $k ) {
		$f[ $k ] = isset( $_POST[ 'sws_' . $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'sws_' . $k ] ) ) : '';
	}
	$f['msg'] = isset( $_POST['sws_msg'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sws_msg'] ) ) : '';

	if ( ! $f['name'] || ! $f['agency'] || ! is_email( $f['email'] ) ) {
		wp_safe_redirect( add_query_arg( 'sws_sent', 'err', $back ) . '#contact-form' );
		exit;
	}

	$to      = apply_filters( 'sws_contact_to', sws_opt( 'email' ) );
	$subject = sprintf( '[Seat Request] %s — %s', $f['course'], $f['agency'] );
	$body    = "Name: {$f['name']}\nAgency: {$f['agency']}\nEmail: {$f['email']}\nPhone: {$f['phone']}\nCourse: {$f['course']}\nSeats: {$f['seats']}\n\nMessage:\n{$f['msg']}\n";
	$headers = array( 'Reply-To: ' . $f['name'] . ' <' . $f['email'] . '>' );
	$ok      = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'sws_sent', $ok ? 'ok' : 'err', $back ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_sws_contact', 'sws_handle_contact' );
add_action( 'admin_post_sws_contact', 'sws_handle_contact' );
