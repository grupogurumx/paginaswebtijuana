<?php
/**
 * Blog index, archives and search.
 *
 * @package Agave
 */

get_header();

if ( is_home() ) {
	$blog_id = get_option( 'page_for_posts' );
	agave_page_hero( $blog_id ? get_the_title( $blog_id ) : 'The Agave Journal', 'Taco talk · San Diego food guides', agave_img( 'gallery-board', 'agave-hero' ), 'Birria deep-dives, burrito history, catering tips and the best of Point Loma — from the team behind the plancha.' );
} elseif ( is_search() ) {
	/* translators: %s search term */
	agave_page_hero( sprintf( __( 'Results for “%s”', 'agave' ), get_search_query() ), 'Search', agave_img( 'gallery-street', 'agave-hero' ) );
} else {
	agave_page_hero( wp_strip_all_tags( get_the_archive_title() ), 'The Agave Journal', agave_img( 'gallery-street', 'agave-hero' ), wp_strip_all_tags( get_the_archive_description() ) );
}
agave_breadcrumbs();
?>
<div class="section section--tight">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card', 'post' );
				endwhile;
				?>
			</div>
			<div class="pagination">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => '←',
						'next_text' => '→',
					)
				);
				?>
			</div>
		<?php else : ?>
			<p class="lead">Nothing here yet — but the birria is always ready. <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>">See the menu</a>.</p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
