<?php
/**
 * Llamada a la acción breve.
 *
 * @package WebmasterTijuana
 */
?>
<section class="section section--tight">
	<div class="container">
		<div class="cta-band" data-reveal>
			<div>
				<h2 class="cta-band__title"><?php esc_html_e( '¿Listo para hacer crecer tu negocio en internet?', 'webmaster-tijuana' ); ?></h2>
				<p><?php esc_html_e( 'Cuéntanos de tu proyecto y recibe una cotización gratuita.', 'webmaster-tijuana' ); ?></p>
			</div>
			<div class="cta-band__actions">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( wmt_cotizar_url() ); ?>"><?php esc_html_e( 'Cotizar ahora', 'webmaster-tijuana' ); ?></a>
				<?php if ( wmt_whatsapp_url() ) : ?>
					<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( wmt_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo wmt_icon( 'whatsapp' ); // phpcs:ignore ?> WhatsApp</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
