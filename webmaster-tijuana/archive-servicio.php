<?php
/**
 * Listado de servicios.
 *
 * @package WebmasterTijuana
 */

get_header();
wmt_page_hero(
	__( 'Servicios de diseño web y marketing digital en Tijuana', 'webmaster-tijuana' ),
	__( 'Todo lo que tu negocio necesita para vender en internet, con un solo equipo.', 'webmaster-tijuana' ),
	__( 'Servicios', 'webmaster-tijuana' )
);
?>
<section class="section section--alt">
	<div class="container">
		<div class="grid grid--3" data-reveal-group>
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/servicio-card' );
			endwhile;
			?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/testimonios' );
get_template_part( 'template-parts/cotizar' );
get_footer();
