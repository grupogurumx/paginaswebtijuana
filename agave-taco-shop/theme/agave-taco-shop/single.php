<?php
/**
 * Single blog post.
 *
 * @package Agave
 */

get_header();
while ( have_posts() ) :
	the_post();
	$hero = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'agave-hero' ) : agave_img( 'gallery-board', 'agave-hero' );
	$cats = get_the_category();
	agave_page_hero( get_the_title(), $cats ? $cats[0]->name : 'The Agave Journal', $hero );
	agave_breadcrumbs();
	?>
	<article <?php post_class( 'section section--tight' ); ?>>
		<div class="container entry entry--post">
			<p class="entry__meta">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				· <?php echo esc_html( max( 1, (int) round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 220 ) ) ); ?> min read
			</p>
			<?php the_content(); ?>

			<aside class="entry__cta">
				<h2>Craving it now?</h2>
				<p>Order quesabirria, burritos and tacos for pickup or delivery from Agave Taco Shop in Point Loma.</p>
				<div class="entry__cta-actions">
					<?php agave_button( 'Order Online', agave_biz( 'order_url' ), 'primary', true ); ?>
					<?php agave_button( 'View Menu', home_url( '/menu/' ), 'ghost' ); ?>
				</div>
			</aside>

			<?php
			the_tags( '<p class="entry__tags">', '', '</p>' );
			the_post_navigation(
				array(
					'prev_text' => '<span>Previous</span>%title',
					'next_text' => '<span>Next</span>%title',
				)
			);
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;
get_footer();
