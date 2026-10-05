<?php
/**
 * Entrada del blog.
 *
 * @package PeanutBakery
 */

get_header();
while ( have_posts() ) :
	the_post();
	pb_page_hero(
		array(
			'eyebrow' => get_the_date(),
			'title'   => get_the_title(),
			'slot'    => 'hero-1',
		)
	);
	?>
	<article class="section">
		<div class="container container--narrow entry">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'pb-wide', array( 'class' => 'entry__cover' ) );
			}
			the_content();
			?>
			<aside class="entry__cta">
				<h2><?php esc_html_e( '¿Se te antojó?', 'peanut-bakery' ); ?></h2>
				<p><?php esc_html_e( 'Pide pan de masa madre, conchas o birote recién horneado en Playas de Rosarito.', 'peanut-bakery' ); ?></p>
				<a class="btn btn--wa" href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'Pedir por WhatsApp', 'peanut-bakery' ); ?></a>
			</aside>
		</div>
	</article>
	<?php
endwhile;
get_footer();
