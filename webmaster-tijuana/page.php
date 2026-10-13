<?php
/**
 * Página.
 *
 * @package WebmasterTijuana
 */

get_header();

while ( have_posts() ) :
	the_post();
	wmt_page_hero( get_the_title(), has_excerpt() ? get_the_excerpt() : '' );
	?>
	<section class="section">
		<div class="container container--narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="entry-media"><?php the_post_thumbnail( 'wmt-wide' ); ?></figure>
			<?php endif; ?>
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>
		</div>
	</section>
	<?php
	if ( comments_open() || get_comments_number() ) {
		echo '<section class="section section--tight"><div class="container container--narrow">';
		comments_template();
		echo '</div></section>';
	}
endwhile;

get_template_part( 'template-parts/cta' );
get_footer();
