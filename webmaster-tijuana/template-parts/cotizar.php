<?php
/**
 * Sección de cotización: datos de contacto y formulario.
 *
 * @package WebmasterTijuana
 */

$servicio = isset( $args['servicio'] ) ? $args['servicio'] : '';
?>
<section class="section section--brand" id="cotizar">
	<div class="container contact-split">
		<div class="contact-split__info" data-reveal>
			<p class="eyebrow eyebrow--light"><?php esc_html_e( 'Cotización gratuita', 'webmaster-tijuana' ); ?></p>
			<h2 class="section__title section__title--light"><?php echo esc_html( wmt_opt( 'cta_titulo' ) ); ?></h2>
			<p class="contact-split__lead"><?php echo esc_html( wmt_opt( 'cta_texto' ) ); ?></p>

			<ul class="contact-list">
				<li>
					<span class="contact-list__icon"><?php echo wmt_icon( 'mail' ); // phpcs:ignore ?></span>
					<span><small><?php esc_html_e( 'Correo', 'webmaster-tijuana' ); ?></small>
					<a href="mailto:<?php echo esc_attr( wmt_opt( 'email' ) ); ?>"><?php echo esc_html( wmt_opt( 'email' ) ); ?></a></span>
				</li>
				<li>
					<span class="contact-list__icon"><?php echo wmt_icon( 'phone' ); // phpcs:ignore ?></span>
					<span><small><?php esc_html_e( 'Teléfono', 'webmaster-tijuana' ); ?></small>
					<a href="<?php echo esc_url( wmt_tel_href() ); ?>"><?php echo esc_html( wmt_opt( 'telefono' ) ); ?></a></span>
				</li>
				<?php if ( wmt_whatsapp_url() ) : ?>
					<li>
						<span class="contact-list__icon"><?php echo wmt_icon( 'whatsapp' ); // phpcs:ignore ?></span>
						<span><small>WhatsApp</small>
						<a href="<?php echo esc_url( wmt_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Escríbenos ahora', 'webmaster-tijuana' ); ?></a></span>
					</li>
				<?php endif; ?>
				<li>
					<span class="contact-list__icon"><?php echo wmt_icon( 'pin' ); // phpcs:ignore ?></span>
					<span><small><?php esc_html_e( 'Ubicación', 'webmaster-tijuana' ); ?></small>
					<?php echo esc_html( wmt_opt( 'direccion' ) ); ?></span>
				</li>
			</ul>
		</div>

		<div class="contact-split__form" data-reveal>
			<?php get_template_part( 'template-parts/form-cotizar', null, array( 'servicio' => $servicio ) ); ?>
		</div>
	</div>
</section>
