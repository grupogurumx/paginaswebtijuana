<?php
/**
 * 404.
 *
 * @package hospital-nova
 */

get_header();
get_template_part( 'template-parts/page-hero', null, array(
	'title' => nova_t( 'Página no encontrada', 'Page not found' ),
	'lead'  => nova_t( 'La página que buscas no existe, pero nuestro equipo sí está disponible 24/7.', 'The page you are looking for does not exist, but our team is available 24/7.' ),
) );
?>
<section class="section"><div class="container" style="display:flex;gap:12px;flex-wrap:wrap">
	<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( nova_t( 'Ir al inicio', 'Go home' ) ); ?></a>
	<a class="btn btn--outline" href="<?php echo esc_url( nova_page_url( 'contacto', 'contact' ) ); ?>#cita"><?php echo esc_html( nova_t( 'Agendar cita', 'Book appointment' ) ); ?></a>
</div></section>
<?php
get_footer();
