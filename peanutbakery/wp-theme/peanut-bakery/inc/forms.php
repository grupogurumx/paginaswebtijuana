<?php
/**
 * Formulario de contacto / cotización: envía a ventas@peanutbakery.com con wp_mail().
 * El mismo formulario ofrece "Enviar por WhatsApp" (armado en assets/js/main.js).
 *
 * @package PeanutBakery
 */

defined( 'ABSPATH' ) || exit;

/**
 * Imprime el formulario.
 *
 * @param string $type contacto|mayoreo.
 */
function pb_form( $type = 'contacto' ) {
	$sent = isset( $_GET['enviado'] ) ? sanitize_key( $_GET['enviado'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<form class="form reveal" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-wa="<?php echo esc_attr( preg_replace( '/\D+/', '', pb_opt( 'whatsapp' ) ) ); ?>">
		<?php if ( '1' === $sent ) : ?>
			<p class="form__notice form__notice--ok" role="status"><?php esc_html_e( '¡Gracias! Recibimos tu mensaje y te responderemos muy pronto.', 'peanut-bakery' ); ?></p>
		<?php elseif ( '0' === $sent ) : ?>
			<p class="form__notice form__notice--err" role="alert"><?php esc_html_e( 'No pudimos enviar tu mensaje. Escríbenos por WhatsApp, por favor.', 'peanut-bakery' ); ?></p>
		<?php endif; ?>
		<input type="hidden" name="action" value="pb_form">
		<input type="hidden" name="pb_type" value="<?php echo esc_attr( $type ); ?>">
		<?php wp_nonce_field( 'pb_form', 'pb_nonce' ); ?>
		<div class="form__hp" aria-hidden="true"><label>Web <input type="text" name="pb_web" tabindex="-1" autocomplete="off"></label></div>
		<div class="form__grid">
			<label class="field"><span><?php esc_html_e( 'Nombre', 'peanut-bakery' ); ?></span><input type="text" name="pb_name" required autocomplete="name"></label>
			<label class="field"><span><?php esc_html_e( 'Teléfono / WhatsApp', 'peanut-bakery' ); ?></span><input type="tel" name="pb_phone" required autocomplete="tel"></label>
			<label class="field"><span><?php esc_html_e( 'Correo', 'peanut-bakery' ); ?></span><input type="email" name="pb_email" autocomplete="email"></label>
			<?php if ( 'mayoreo' === $type ) : ?>
				<label class="field"><span><?php esc_html_e( 'Negocio', 'peanut-bakery' ); ?></span><input type="text" name="pb_business" placeholder="<?php esc_attr_e( 'Cafetería, restaurante, hotel…', 'peanut-bakery' ); ?>"></label>
			<?php else : ?>
				<label class="field"><span><?php esc_html_e( 'Motivo', 'peanut-bakery' ); ?></span>
					<select name="pb_business">
						<option><?php esc_html_e( 'Pedido', 'peanut-bakery' ); ?></option>
						<option><?php esc_html_e( 'Cotización de mayoreo', 'peanut-bakery' ); ?></option>
						<option><?php esc_html_e( 'Pan para evento', 'peanut-bakery' ); ?></option>
						<option><?php esc_html_e( 'Otro', 'peanut-bakery' ); ?></option>
					</select>
				</label>
			<?php endif; ?>
			<label class="field field--full"><span><?php echo 'mayoreo' === $type ? esc_html__( 'Productos y volumen aproximado', 'peanut-bakery' ) : esc_html__( 'Mensaje', 'peanut-bakery' ); ?></span><textarea name="pb_message" rows="4" required></textarea></label>
		</div>
		<div class="form__actions">
			<button type="submit" class="btn btn--primary"><?php esc_html_e( 'Enviar por correo', 'peanut-bakery' ); ?> <?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></button>
			<button type="button" class="btn btn--wa" data-form-wa><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'Enviar por WhatsApp', 'peanut-bakery' ); ?></button>
		</div>
		<p class="form__legal"><?php printf( esc_html__( 'Tus datos solo se usan para responder tu solicitud. Llega directo a %s.', 'peanut-bakery' ), esc_html( pb_opt( 'email' ) ) ); ?></p>
	</form>
	<?php
}

/**
 * Procesa el envío.
 */
function pb_form_handle() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/contacto/' );
	$back = remove_query_arg( 'enviado', $back );

	if ( ! isset( $_POST['pb_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['pb_nonce'] ), 'pb_form' ) || ! empty( $_POST['pb_web'] ) ) {
		wp_safe_redirect( add_query_arg( 'enviado', '0', $back ) . '#formulario' );
		exit;
	}

	$f = array();
	foreach ( array( 'name', 'phone', 'email', 'business', 'type' ) as $k ) {
		$f[ $k ] = isset( $_POST[ 'pb_' . $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'pb_' . $k ] ) ) : '';
	}
	$f['message'] = isset( $_POST['pb_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pb_message'] ) ) : '';

	$subject = sprintf( '[%s] %s — %s', 'mayoreo' === $f['type'] ? 'Cotización mayoreo' : 'Contacto web', $f['name'], $f['business'] );
	$body    = "Nombre: {$f['name']}\nTeléfono: {$f['phone']}\nCorreo: {$f['email']}\nNegocio/Motivo: {$f['business']}\n\n{$f['message']}\n\n— Enviado desde " . home_url( '/' );
	$headers = array();
	if ( is_email( $f['email'] ) ) {
		$headers[] = 'Reply-To: ' . $f['name'] . ' <' . $f['email'] . '>';
	}

	$ok = wp_mail( pb_opt( 'email' ), $subject, $body, $headers );
	wp_safe_redirect( add_query_arg( 'enviado', $ok ? '1' : '0', $back ) . '#formulario' );
	exit;
}
add_action( 'admin_post_pb_form', 'pb_form_handle' );
add_action( 'admin_post_nopriv_pb_form', 'pb_form_handle' );
