<?php
/**
 * Front page: content is built from section shortcodes (see the imported "Home" page).
 * If the page is empty, a default layout is rendered so the theme looks complete on activation.
 *
 * @package sws
 */
get_header();

if ( have_posts() ) {
	the_post();
	$sws_content = trim( get_the_content() );
}

if ( ! empty( $sws_content ) ) {
	the_content();
} else {
	echo do_shortcode( '[sws_slider][sws_trustbar][sws_section eyebrow="Instructor Courses" title="Certify the Instructors Your Agency Depends On" center="1"][sws_courses][/sws_section][sws_section class="section--steel" eyebrow="Why Southwestern" title="Built by Operators. Proven in the Field."][sws_features][/sws_section][sws_section][sws_cta][/sws_section]' ); // phpcs:ignore
}

get_footer();
