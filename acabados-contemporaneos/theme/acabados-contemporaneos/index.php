<?php
/**
 * Archivo genérico, categorías y búsqueda.
 *
 * @package Acabados
 */

get_header();
?>
<header class="post-hero post-hero--archive">
	<div class="post-hero__inner container">
		<?php if ( is_search() ) : ?>
			<p class="kicker"><?php ac_e( 'results_for' ); ?></p>
			<h1 class="post-hero__title">«<?php echo esc_html( get_search_query() ); ?>»</h1>
		<?php elseif ( is_archive() ) : ?>
			<p class="kicker"><?php ac_e( 'blog_kicker' ); ?></p>
			<h1 class="post-hero__title"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
			<?php the_archive_description( '<div class="lead">', '</div>' ); ?>
		<?php else : ?>
			<p class="kicker"><?php ac_e( 'blog_kicker' ); ?></p>
			<h1 class="post-hero__title"><?php ac_e( 'blog_title' ); ?></h1>
		<?php endif; ?>
	</div>
</header>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="posts-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					if ( 'post' === get_post_type() ) {
						get_template_part( 'template-parts/post-card' );
					} else {
						?>
						<article class="post-card post-card--text" data-reveal>
							<div class="post-card__body">
								<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
								<a class="ac-link" href="<?php the_permalink(); ?>"><?php ac_e( 'discover' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
							</div>
						</article>
						<?php
					}
				endwhile;
				?>
			</div>
			<nav class="pagination"><?php echo paginate_links( array( 'prev_text' => ac_icon( 'arrow-l' ), 'next_text' => ac_icon( 'arrow' ) ) ); // phpcs:ignore ?></nav>
		<?php else : ?>
			<p class="lead"><?php ac_e( 'nothing' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
