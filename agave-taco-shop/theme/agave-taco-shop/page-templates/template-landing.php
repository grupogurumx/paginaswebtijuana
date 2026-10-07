<?php
/**
 * Template Name: Agave — Story (wide, image-rich)
 *
 * @package Agave
 */

get_header();
while ( have_posts() ) :
	the_post();
	agave_page_hero( get_the_title(), get_post_meta( get_the_ID(), '_agave_kicker', true ) ? get_post_meta( get_the_ID(), '_agave_kicker', true ) : 'Our story', agave_img( 'story-grill', 'agave-hero' ), has_excerpt() ? get_the_excerpt() : '' );
	agave_breadcrumbs();
	?>
	<article class="section section--tight">
		<div class="container entry entry--wide"><?php the_content(); ?></div>
	</article>
	<?php
endwhile;
get_footer();
