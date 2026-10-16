<?php
/**
 * 404.
 *
 * @package PeanutBakery
 */

get_header();
?>
<section class="section notfound">
	<div class="container center">
		<p class="notfound__code">404</p>
		<h1 class="section__title"><?php esc_html_e( 'Este pan ya se vendió', 'peanut-bakery' ); ?></h1>
		<p><?php esc_html_e( 'La página que buscas no existe, pero el horno sigue encendido.', 'peanut-bakery' ); ?></p>
		<div class="btn-row btn-row--center">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/productos/' ) ); ?>"><?php esc_html_e( 'Ver productos', 'peanut-bakery' ); ?></a>
			<a class="btn btn--wa" href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> WhatsApp</a>
		</div>
	</div>
</section>
<?php
get_footer();
