<?php
/**
 * Default page.
 *
 * @package Agave
 */

get_header();
while ( have_posts() ) :
	the_post();
	$hero = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'agave-hero' ) : agave_img( 'hero-birria-night', 'agave-hero' );
	agave_page_hero( get_the_title(), get_post_meta( get_the_ID(), '_agave_kicker', true ), $hero, has_excerpt() ? get_the_excerpt() : '' );
	agave_breadcrumbs();
	?>
	<article <?php post_class( 'section section--tight' ); ?>>
		<div class="container entry">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;
get_footer();
