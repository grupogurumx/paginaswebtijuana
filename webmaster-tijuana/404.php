<?php
/**
 * Página no encontrada.
 *
 * @package WebmasterTijuana
 */

get_header();
?>
<section class="section notfound">
	<div class="container container--narrow">
		<p class="notfound__code">404</p>
		<h1 class="section__title"><?php esc_html_e( 'No encontramos esta página', 'webmaster-tijuana' ); ?></h1>
		<p class="lead"><?php esc_html_e( 'Puede que el enlace haya cambiado. Prueba con una búsqueda o vuelve al inicio.', 'webmaster-tijuana' ); ?></p>
		<?php get_search_form(); ?>
		<p class="notfound__actions">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ir al inicio', 'webmaster-tijuana' ); ?></a>
			<a class="btn btn--outline" href="<?php echo esc_url( get_post_type_archive_link( 'servicio' ) ); ?>"><?php esc_html_e( 'Ver servicios', 'webmaster-tijuana' ); ?></a>
		</p>
	</div>
</section>
<?php
get_footer();
