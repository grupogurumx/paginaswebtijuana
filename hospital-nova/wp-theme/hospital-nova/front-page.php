<?php
/**
 * Portada. Las secciones se arman con funciones del tema; el contenido
 * que escribas en la página "Inicio" aparece después del hero.
 *
 * @package hospital-nova
 */

get_header();
get_template_part( 'template-parts/hero-pano' );

// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- las secciones escapan internamente.
echo nova_section_specialties();
echo nova_section_stats();
echo nova_section_partners();

while ( have_posts() ) :
	the_post();
	if ( trim( get_the_content() ) ) :
		?>
		<section class="section section--white"><div class="container entry"><?php the_content(); ?></div></section>
		<?php
	endif;
endwhile;

echo nova_section_maternity();
echo nova_section_doctors();
echo nova_section_faq();
echo nova_section_posts( 3 );
echo nova_section_contact();

get_footer();
