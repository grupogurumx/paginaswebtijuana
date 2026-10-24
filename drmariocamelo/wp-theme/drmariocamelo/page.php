<?php
/**
 * Generic page.
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero' );
	?>
	<section class="section">
		<div class="container">
			<div class="entry">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php if ( ! has_shortcode( get_the_content(), 'dmc_cta' ) && ! has_shortcode( get_the_content(), 'dmc_lead_form' ) ) : ?>
	<section class="section" style="padding-top:0">
		<div class="container"><?php echo dmc_cta_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	</section>
	<?php endif; ?>
	<?php
endwhile;
get_footer();
