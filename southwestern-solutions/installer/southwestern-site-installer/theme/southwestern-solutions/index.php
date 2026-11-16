<?php
/**
 * Blog index, archives and search results.
 *
 * @package sws
 */
get_header();

$sws_blog_id = (int) get_option( 'page_for_posts' );
if ( is_home() && $sws_blog_id ) {
	$sws_title = get_the_title( $sws_blog_id );
	$sws_sub   = get_post_meta( $sws_blog_id, '_sws_subtitle', true );
} elseif ( is_search() ) {
	/* translators: %s search query */
	$sws_title = sprintf( 'Search: %s', esc_html( get_search_query() ) );
	$sws_sub   = '';
} elseif ( is_archive() ) {
	$sws_title = wp_strip_all_tags( get_the_archive_title() );
	$sws_sub   = wp_strip_all_tags( get_the_archive_description() );
} else {
	$sws_title = 'Training Insights';
	$sws_sub   = '';
}
get_template_part( 'template-parts/page', 'hero', array( 'title' => $sws_title, 'subtitle' => $sws_sub, 'bg' => sws_img( 'hero-2.webp' ), 'eyebrow' => 'Insights & Updates' ) );
?>
<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card', 'post' );
				endwhile;
				?>
			</div>
			<div class="pagination"><?php echo paginate_links(); // phpcs:ignore ?></div>
		<?php else : ?>
			<p class="lead">No articles found yet. Check back soon.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
