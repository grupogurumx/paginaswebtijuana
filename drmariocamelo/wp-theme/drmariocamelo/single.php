<?php
/**
 * Blog post.
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero' );
	?>
	<section class="section">
		<div class="container">
			<article class="entry">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'large', array( 'class' => 'reveal' ) );
				}
				the_content();
				?>
				<p class="disclaimer"><?php echo esc_html( dmc_t( 'disclaimer' ) ); ?></p>
			</article>
		</div>
	</section>
	<?php
	$related = new WP_Query(
		array(
			'posts_per_page'      => 3,
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => true,
			'meta_query'          => array( array( 'key' => '_dmc_lang', 'value' => dmc_lang() ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	if ( $related->have_posts() ) :
		?>
	<section class="section section--soft">
		<div class="container">
			<h2 class="center" style="margin-bottom:40px"><?php echo esc_html( dmc_t( 'related' ) ); ?></h2>
			<div class="posts">
				<?php
				while ( $related->have_posts() ) {
					$related->the_post();
					get_template_part( 'template-parts/card' );
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>
	<section class="section">
		<div class="container"><?php echo dmc_cta_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	</section>
	<?php
endwhile;
get_footer();
