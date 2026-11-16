<?php
/**
 * Single blog post.
 *
 * @package sws
 */
get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page', 'hero' );
	?>
	<article <?php post_class( 'entry' ); ?>>
		<div class="wrap">
			<div class="entry-content">
				<?php the_content(); ?>
				<p class="disclaimer">This article is provided for general training and educational purposes and is not legal advice. Always consult your agency’s policies and legal counsel.</p>
				<?php the_tags( '<p class="post-card__meta">Tags: ', ', ', '</p>' ); ?>
			</div>
		</div>
	</article>
	<?php
	echo do_shortcode( '[sws_section class="section--steel" eyebrow="Keep Reading" title="More Training Insights"][sws_latest_posts count="3"][/sws_section][sws_section][sws_cta][/sws_section]' ); // phpcs:ignore
endwhile;

get_footer();
