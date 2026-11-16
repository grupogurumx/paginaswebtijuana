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
			'product/chemical-agent-instructor-course-san-jose-ca' => '/product/chemical-agent-instructor-course/',
			'product/chemical-agent-instructor-course-san-jose'    => '/product/chemical-agent-instructor-course/',
			'product/less-lethal-instructor-course-san-jose-ca'    => '/product/less-lethal-instructor-course/',
			'product/less-lethal-instructor-course'            => '/less-lethal-instructor-course/',
			'shop'                                             => '/courses/',
			'cart'                                             => '/contact/',
			'checkout'                                         => '/contact/',
			'about'                                            => '/about-us/',
			'contact-us'                                       => '/contact/',
			'schedule'                                         => '/training-schedule/',
			'ab48'                                             => '/ab-48-compliance/',
			// Blog removed (Nov 2026): send any old article/blog URL to the closest page.
			'blog'                                             => '/',
			'ab-48-penal-code-13652-explained'                 => '/ab-48-compliance/',
			'chemical-agent-instructor-certification-guide'    => '/chemical-agent-instructor-course/',
			'less-lethal-instructor-training-kinetic-energy-projectiles' => '/less-lethal-instructor-course/',
			'post-plan-iv-reimbursement-instructor-courses'    => '/faq/',
			'chemical-agent-decontamination-best-practices'    => '/chemical-agent-instructor-course/',
			'train-the-trainer-in-house-instructors'           => '/courses/',
			'privacy-policy'                                   => '/',
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
