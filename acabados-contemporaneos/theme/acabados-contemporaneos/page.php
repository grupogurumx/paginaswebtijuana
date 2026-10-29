<?php
/**
 * Páginas internas.
 *
 * @package Acabados
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero' );
	?>
	<article <?php post_class( 'page-body' ); ?>>
		<div class="entry-content container container--narrow">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
	if ( ! get_post_meta( get_the_ID(), '_ac_hide_cta', true ) ) {
		get_template_part( 'template-parts/cta' );
	}
endwhile;
get_footer();
