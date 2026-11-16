<?php
/**
 * WooCommerce wrapper (shop, product category and single product pages).
 *
 * @package sws
 */
get_header();

if ( is_singular( 'product' ) ) {
	$sws_id = get_queried_object_id();
	$sws_eye = trim( get_post_meta( $sws_id, '_sws_dates', true ) . ' · ' . get_post_meta( $sws_id, '_sws_location', true ), ' ·' );
	get_template_part(
		'template-parts/page',
		'hero',
		array(
			'title'    => get_the_title( $sws_id ),
			'subtitle' => get_post_meta( $sws_id, '_sws_hours', true ) ? 'Instructor-level · ' . get_post_meta( $sws_id, '_sws_hours', true ) . ' · POST certified · AB 48 compliant' : '',
			'bg'       => sws_hero_url( $sws_id ),
			'eyebrow'  => $sws_eye,
		)
	);
} else {
	$sws_shop = (int) wc_get_page_id( 'shop' );
	get_template_part(
		'template-parts/page',
		'hero',
		array(
			'title'    => is_shop() ? 'Register for a Course' : wp_strip_all_tags( woocommerce_page_title( false ) ),
			'subtitle' => is_shop() ? 'Secure seats in POST-certified Chemical Agent and Less Lethal Instructor courses. Plan IV reimbursable.' : '',
			'bg'       => sws_img( 'hero-3.webp' ),
			'eyebrow'  => 'Online Registration',
		)
	);
}
?>
<section class="section wc-section">
	<div class="wrap">
		<?php woocommerce_content(); ?>
	</div>
</section>
<?php
get_footer();
