<?php
/**
 * Template Name: Cotizar
 *
 * @package WebmasterTijuana
 */

get_header();

while ( have_posts() ) :
	the_post();
	wmt_page_hero( get_the_title(), __( 'Llena el formulario y te enviamos una propuesta sin costo en menos de un día hábil.', 'webmaster-tijuana' ), __( 'Cotización gratuita', 'webmaster-tijuana' ) );
	if ( '' !== trim( get_the_content() ) ) :
		?>
		<section class="section section--tight">
			<div class="container container--narrow entry-content"><?php the_content(); ?></div>
		</section>
		<?php
	endif;
endwhile;

$servicio = isset( $_GET['servicio'] ) ? sanitize_text_field( wp_unslash( $_GET['servicio'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
get_template_part( 'template-parts/cotizar', null, array( 'servicio' => $servicio ) );
get_template_part( 'template-parts/testimonios' );
get_footer();
