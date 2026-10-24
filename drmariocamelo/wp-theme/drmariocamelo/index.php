<?php
/**
 * Blog index (English) and archives.
 */

get_header();
?>
<section class="page-hero">
	<div class="container">
		<span class="eyebrow"><?php echo esc_html( dmc_t( 'latest' ) ); ?></span>
		<h1><?php echo is_home() ? esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) : wp_kses_post( get_the_archive_title() ); ?></h1>
		<p class="lead"><?php echo wp_kses_post( wp_strip_all_tags( dmc_t( 'latest_title' ) ) ); ?></p>
	</div>
</section>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/card' );
				}
				?>
			</div>
			<div class="pagination"><?php echo wp_kses_post( paginate_links() ); ?></div>
		<?php else : ?>
			<p class="center"><?php echo esc_html( dmc_t( 'no_posts' ) ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
