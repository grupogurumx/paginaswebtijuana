<?php
/**
 * Resultados de búsqueda.
 *
 * @package WebmasterTijuana
 */

get_header();
wmt_page_hero( sprintf( __( 'Resultados para «%s»', 'webmaster-tijuana' ), get_search_query() ) );
?>
<section class="section">
	<div class="container container--narrow">
		<?php get_search_form(); ?>
		<?php if ( have_posts() ) : ?>
			<ul class="search-results">
				<?php
				while ( have_posts() ) :
					the_post();
					$tipo = get_post_type_object( get_post_type() );
					?>
					<li>
						<small><?php echo esc_html( $tipo ? $tipo->labels->singular_name : '' ); ?></small>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p class="lead"><?php esc_html_e( 'No encontramos resultados. Intenta con otras palabras.', 'webmaster-tijuana' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
