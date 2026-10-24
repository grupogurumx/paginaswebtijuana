<?php
/**
 * Template Name: Blog (Español)
 *
 * Spanish blog index at /es/blog/.
 */

get_header();
$dmc_paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$dmc_posts = new WP_Query(
	array(
		'posts_per_page' => 9,
		'paged'          => $dmc_paged,
		'meta_query'     => array( array( 'key' => '_dmc_lang', 'value' => 'es' ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
	)
);
?>
<section class="page-hero">
	<div class="container">
		<span class="eyebrow"><?php echo esc_html( dmc_t( 'latest' ) ); ?></span>
		<h1><?php the_title(); ?></h1>
		<p class="lead"><?php echo esc_html( wp_strip_all_tags( dmc_t( 'latest_title' ) ) ); ?></p>
	</div>
</section>
<section class="section">
	<div class="container">
		<?php if ( $dmc_posts->have_posts() ) : ?>
			<div class="posts">
				<?php
				while ( $dmc_posts->have_posts() ) {
					$dmc_posts->the_post();
					get_template_part( 'template-parts/card' );
				}
				wp_reset_postdata();
				?>
			</div>
			<div class="pagination"><?php echo wp_kses_post( paginate_links( array( 'total' => $dmc_posts->max_num_pages, 'current' => $dmc_paged ) ) ); ?></div>
		<?php else : ?>
			<p class="center"><?php echo esc_html( dmc_t( 'no_posts' ) ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
