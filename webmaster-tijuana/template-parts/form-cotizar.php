<?php
/**
 * Formulario de cotización.
 *
 * @package WebmasterTijuana
 */

$preseleccion = isset( $args['servicio'] ) ? $args['servicio'] : '';
$uid          = wp_unique_id( 'fc-' );
$volver       = ( is_ssl() ? 'https://' : 'http://' ) . ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '' ) . ( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/' );
?>
<div class="form-card" id="formulario">
	<h3 class="form-card__title"><?php esc_html_e( 'Solicita tu cotización', 'webmaster-tijuana' ); ?></h3>
	<p class="form-card__lead"><?php esc_html_e( 'Sin costo y sin compromiso. Te respondemos en menos de un día hábil.', 'webmaster-tijuana' ); ?></p>

	<?php wmt_form_notice(); ?>

	<form class="form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
		<input type="hidden" name="action" value="wmt_cotizacion">
		<input type="hidden" name="wmt_volver" value="<?php echo esc_url( $volver ); ?>">
		<?php wp_nonce_field( 'wmt_cotizacion', 'wmt_nonce' ); ?>

		<div class="form__hp" aria-hidden="true">
			<label for="<?php echo esc_attr( $uid ); ?>-web">Sitio web</label>
			<input type="text" id="<?php echo esc_attr( $uid ); ?>-web" name="wmt_sitio_web" tabindex="-1" autocomplete="off">
		</div>

		<div class="form__row">
			<div class="field">
				<label for="<?php echo esc_attr( $uid ); ?>-nombre"><?php esc_html_e( 'Nombre completo', 'webmaster-tijuana' ); ?></label>
				<input type="text" id="<?php echo esc_attr( $uid ); ?>-nombre" name="wmt_nombre" required autocomplete="name" placeholder="Juan Pérez">
			</div>
			<div class="field">
				<label for="<?php echo esc_attr( $uid ); ?>-tel"><?php esc_html_e( 'Teléfono', 'webmaster-tijuana' ); ?></label>
				<input type="tel" id="<?php echo esc_attr( $uid ); ?>-tel" name="wmt_telefono" required autocomplete="tel" placeholder="664 123 4567">
			</div>
		</div>

		<div class="form__row">
			<div class="field">
				<label for="<?php echo esc_attr( $uid ); ?>-email"><?php esc_html_e( 'Correo electrónico', 'webmaster-tijuana' ); ?></label>
				<input type="email" id="<?php echo esc_attr( $uid ); ?>-email" name="wmt_email" required autocomplete="email" placeholder="correo@empresa.com">
			</div>
			<div class="field">
				<label for="<?php echo esc_attr( $uid ); ?>-servicio"><?php esc_html_e( 'Servicio de interés', 'webmaster-tijuana' ); ?></label>
				<select id="<?php echo esc_attr( $uid ); ?>-servicio" name="wmt_servicio">
					<?php foreach ( wmt_form_servicios() as $s ) : ?>
						<option <?php selected( $preseleccion, $s ); ?>><?php echo esc_html( $s ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="field">
			<label for="<?php echo esc_attr( $uid ); ?>-mensaje"><?php esc_html_e( 'Cuéntanos de tu proyecto', 'webmaster-tijuana' ); ?></label>
			<textarea id="<?php echo esc_attr( $uid ); ?>-mensaje" name="wmt_mensaje" rows="4" required placeholder="<?php esc_attr_e( '¿Qué necesitas y para cuándo?', 'webmaster-tijuana' ); ?>"></textarea>
		</div>

		<label class="check">
			<input type="checkbox" name="wmt_privacidad" value="1" required>
			<span>
				<?php
				printf(
					/* translators: %s: enlace al aviso de privacidad */
					esc_html__( 'Acepto el %s.', 'webmaster-tijuana' ),
					'<a href="' . esc_url( wmt_page_url( 'aviso-de-privacidad' ) ) . '" target="_blank">' . esc_html__( 'aviso de privacidad', 'webmaster-tijuana' ) . '</a>'
				);
				?>
			</span>
		</label>

		<button class="btn btn--primary btn--block btn--lg" type="submit">
			<?php esc_html_e( 'Enviar solicitud', 'webmaster-tijuana' ); ?> <?php echo wmt_icon( 'send' ); // phpcs:ignore ?>
		</button>
	</form>
</div>
