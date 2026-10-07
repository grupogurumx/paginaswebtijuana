<?php
/**
 * Template Name: Agave — Visit / Location
 *
 * @package Agave
 */

get_header();
while ( have_posts() ) :
	the_post();
	agave_page_hero( get_the_title(), 'Point Loma · San Diego', agave_img( 'hero-drive-thru', 'agave-hero' ), has_excerpt() ? get_the_excerpt() : '' );
	agave_breadcrumbs();
	get_template_part( 'template-parts/visit' );
	?>
	<div class="section section--tight">
		<div class="container entry"><?php the_content(); ?></div>
	</div>
	<?php
endwhile;
get_footer();
