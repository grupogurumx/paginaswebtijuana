<?php
/**
 * Blog, categorías, búsquedas y respaldo general.
 *
 * @package hospital-nova
 */

get_header();

if ( is_home() ) {
	$title = get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : 'Blog';
	$lead  = nova_t( 'Artículos de salud escritos por el equipo médico de Hospital Nova en Tijuana.', 'Health articles written by the Hospital Nova medical team in Tijuana.' );
} elseif ( is_search() ) {
	$title = nova_t( 'Resultados para: ', 'Results for: ' ) . get_search_query();
	$lead  = '';
} else {
	$title = wp_strip_all_tags( get_the_archive_title() );
	$lead  = wp_strip_all_tags( get_the_archive_description() );
}
get_template_part( 'template-parts/page-hero', null, array( 'title' => $title, 'lead' => $lead ) );
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/post-card' );
				endwhile;
				?>
			</div>
			<div class="pagination"><?php echo wp_kses_post( paginate_links() ); ?></div>
		<?php else : ?>
			<p class="lead"><?php echo esc_html( nova_t( 'No encontramos artículos.', 'No articles found.' ) ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
