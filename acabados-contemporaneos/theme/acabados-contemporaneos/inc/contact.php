<?php
/**
 * Formulario de cotización: [ac_contacto]
 *
 * Envía por wp_mail() con nonce y campo trampa antispam. Compatible con
 * cualquier plugin SMTP (WP Mail SMTP, FluentSMTP…).
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render del formulario.
 *
 * @return string
 */
function ac_contact_form() {
	$status = isset( $_GET['ac_sent'] ) ? sanitize_key( wp_unslash( $_GET['ac_sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	ob_start();
	?>
	<form class="ac-form" id="contacto" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-reveal>
		<?php if ( 'ok' === $status ) : ?>
			<p class="ac-form__notice is-ok" role="status"><?php ac_e( 'f_ok' ); ?></p>
		<?php elseif ( 'error' === $status ) : ?>
			<p class="ac-form__notice is-error" role="alert"><?php ac_e( 'f_err' ); ?></p>
		<?php endif; ?>
		<input type="hidden" name="action" value="ac_contact">
		<input type="hidden" name="ac_lang" value="<?php echo esc_attr( ac_lang() ); ?>">
		<input type="hidden" name="ac_back" value="<?php echo esc_url( get_permalink() ); ?>">
		<?php wp_nonce_field( 'ac_contact', 'ac_contact_nonce' ); ?>
		<div class="ac-form__hp" aria-hidden="true"><label>Website<input type="text" name="ac_website" tabindex="-1" autocomplete="off"></label></div>
		<div class="ac-form__grid">
			<label class="ac-field"><span><?php ac_e( 'f_name' ); ?></span><input type="text" name="ac_name" required autocomplete="name"></label>
			<label class="ac-field"><span><?php ac_e( 'f_email' ); ?></span><input type="email" name="ac_email" required autocomplete="email"></label>
			<label class="ac-field"><span><?php ac_e( 'f_phone' ); ?></span><input type="tel" name="ac_phone" autocomplete="tel"></label>
			<label class="ac-field"><span><?php ac_e( 'f_type' ); ?></span>
				<select name="ac_type">
					<?php foreach ( array( 1, 2, 3, 4 ) as $n ) : ?>
						<option><?php ac_e( 'f_type_' . $n ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<label class="ac-field ac-field--full"><span><?php ac_e( 'f_msg' ); ?></span><textarea name="ac_message" rows="5" required></textarea></label>
		</div>
		<label class="ac-check"><input type="checkbox" name="ac_privacy" value="1" required> <span><a href="<?php echo esc_url( ac_page_url( 'aviso-de-privacidad', 'en/privacy-notice' ) ); ?>"><?php ac_e( 'f_privacy' ); ?></a></span></label>
		<button type="submit" class="ac-btn ac-btn--solid"><?php ac_e( 'f_send' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ac_contacto', 'ac_contact_form' );

/**
 * Procesa el envío.
 */
function ac_contact_handle() {
	$back = isset( $_POST['ac_back'] ) ? esc_url_raw( wp_unslash( $_POST['ac_back'] ) ) : home_url( '/' );
	$back = wp_validate_redirect( $back, home_url( '/' ) );

	$valid = isset( $_POST['ac_contact_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ac_contact_nonce'] ) ), 'ac_contact' );
	$spam  = ! empty( $_POST['ac_website'] );
	$name  = isset( $_POST['ac_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ac_name'] ) ) : '';
	$email = isset( $_POST['ac_email'] ) ? sanitize_email( wp_unslash( $_POST['ac_email'] ) ) : '';
	$phone = isset( $_POST['ac_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['ac_phone'] ) ) : '';
	$type  = isset( $_POST['ac_type'] ) ? sanitize_text_field( wp_unslash( $_POST['ac_type'] ) ) : '';
	$msg   = isset( $_POST['ac_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ac_message'] ) ) : '';

	if ( $spam ) {
		wp_safe_redirect( add_query_arg( 'ac_sent', 'ok', $back ) . '#contacto' );
		exit;
	}
	if ( ! $valid || ! $name || ! is_email( $email ) || ! $msg || empty( $_POST['ac_privacy'] ) ) {
		wp_safe_redirect( add_query_arg( 'ac_sent', 'error', $back ) . '#contacto' );
		exit;
	}

	$to      = ac_opt( 'form_email' ) ? ac_opt( 'form_email' ) : get_option( 'admin_email' );
	$subject = sprintf( '[Cotización web] %s — %s', $name, $type );
	$body    = "Nombre: {$name}\nCorreo: {$email}\nTeléfono: {$phone}\nTipo de proyecto: {$type}\n\nMensaje:\n{$msg}\n\n— Enviado desde " . home_url( '/' );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );
	wp_safe_redirect( add_query_arg( 'ac_sent', $sent ? 'ok' : 'error', $back ) . '#contacto' );
	exit;
}
add_action( 'admin_post_ac_contact', 'ac_contact_handle' );
add_action( 'admin_post_nopriv_ac_contact', 'ac_contact_handle' );
