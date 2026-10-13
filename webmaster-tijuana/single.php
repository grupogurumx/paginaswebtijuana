<?php
/**
 * Entrada del blog.
 *
 * @package WebmasterTijuana
 */

get_header();

while ( have_posts() ) :
	the_post();
	wmt_page_hero( get_the_title(), sprintf( __( 'Publicado el %s', 'webmaster-tijuana' ), get_the_date() ) );
	?>
	<article class="section">
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
			<?php
			the_post_navigation(
				array(
					'prev_text' => '<small>' . __( 'Anterior', 'webmaster-tijuana' ) . '</small>%title',
					'next_text' => '<small>' . __( 'Siguiente', 'webmaster-tijuana' ) . '</small>%title',
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

get_template_part( 'template-parts/cta' );
get_footer();
