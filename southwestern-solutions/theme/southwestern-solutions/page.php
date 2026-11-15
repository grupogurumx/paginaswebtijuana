<?php
/**
 * Default page template.
 * Pages whose meta _sws_layout = "sections" render their content edge-to-edge
 * (section shortcodes handle their own containers); all other pages use the prose layout.
 *
 * @package sws
 */
get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page', 'hero' );
	if ( 'sections' === get_post_meta( get_the_ID(), '_sws_layout', true ) ) {
		the_content();
	} else {
		$sws_wide = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
		echo '<div class="entry"><div class="wrap"><div class="entry-content' . ( $sws_wide ? ' wide wc-page' : '' ) . '">';
		the_content();
		echo '</div></div></div>';
	}
endwhile;

get_footer();
