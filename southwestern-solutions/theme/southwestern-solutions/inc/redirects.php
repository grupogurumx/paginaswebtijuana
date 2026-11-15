<?php
/**
 * 301 redirects from the legacy site's URLs to the new structure,
 * so existing Google rankings and backlinks are preserved.
 * Runs only when the requested URL would otherwise 404.
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sws_legacy_redirects() {
	return apply_filters(
		'sws_legacy_redirects',
		array(
			'home-it-service'                                  => '/',
			'product/chemical-agent-instructor-course'         => '/chemical-agent-instructor-course/',
			'product/chemical-agent-instructor-course-san-jose-ca' => '/chemical-agent-instructor-course/',
			'product/less-lethal-instructor-course'            => '/less-lethal-instructor-course/',
			'shop'                                             => '/courses/',
			'cart'                                             => '/contact/',
			'checkout'                                         => '/contact/',
			'about'                                            => '/about-us/',
			'contact-us'                                       => '/contact/',
			'schedule'                                         => '/training-schedule/',
			'ab48'                                             => '/ab-48-compliance/',
		)
	);
}

add_action(
	'template_redirect',
	function () {
		if ( ! is_404() ) {
			return;
		}
		$path = isset( $_SERVER['REQUEST_URI'] ) ? trim( wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ), '/' ) : '';
		$map  = sws_legacy_redirects();
		if ( $path && isset( $map[ $path ] ) ) {
			wp_safe_redirect( home_url( $map[ $path ] ), 301 );
			exit;
		}
	},
	1
);
