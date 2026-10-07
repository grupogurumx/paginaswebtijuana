<?php
/**
 * One-click site setup: runs automatically after the XML import (and on theme
 * activation). Sets the static front page, the blog page, menu locations,
 * SEO-friendly permalinks and the site tagline.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

/**
 * Configure reading settings, menus and permalinks.
 */
function agave_run_setup() {
	$home = get_page_by_path( 'home' );
	$blog = get_page_by_path( 'blog' );

	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
	}
	if ( $blog ) {
		update_option( 'page_for_posts', $blog->ID );
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$map       = array(
		'primary' => 'Main Menu',
		'footer'  => 'Footer Menu',
	);
	foreach ( $map as $location => $menu_name ) {
		$menu = wp_get_nav_menu_object( $menu_name );
		if ( $menu ) {
			$locations[ $location ] = $menu->term_id;
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );

	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	update_option( 'blogname', 'Agave Taco Shop' );
	update_option( 'blogdescription', 'Birria, quesabirria & tacos in Point Loma, San Diego' );
	update_option( 'timezone_string', 'America/Los_Angeles' );
	update_option( 'posts_per_page', 9 );
	flush_rewrite_rules( false );

	update_option( 'agave_setup_done', AGAVE_VERSION );
}
add_action( 'import_end', 'agave_run_setup' );
add_action( 'after_switch_theme', 'agave_run_setup' );

/**
 * Admin notice with a manual "Run setup" button (useful after re-imports).
 */
function agave_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'themes' !== $screen->id && 'dashboard' !== $screen->id ) {
		return;
	}
	$url = wp_nonce_url( admin_url( 'admin-post.php?action=agave_setup' ), 'agave_setup' );
	printf(
		'<div class="notice notice-info"><p><strong>Agave Taco Shop:</strong> %1$s <a class="button button-primary" href="%2$s">%3$s</a></p></div>',
		esc_html__( 'After importing the XML content, click to set the homepage, blog, menus and permalinks automatically.', 'agave' ),
		esc_url( $url ),
		esc_html__( 'Run one-click setup', 'agave' )
	);
}
add_action( 'admin_notices', 'agave_setup_notice' );

/**
 * Manual setup endpoint.
 */
function agave_setup_endpoint() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'agave_setup' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'agave' ) );
	}
	agave_run_setup();
	wp_safe_redirect( admin_url( 'themes.php?agave_setup=1' ) );
	exit;
}
add_action( 'admin_post_agave_setup', 'agave_setup_endpoint' );

/**
 * Fallback for the primary menu before any menu is assigned.
 */
function agave_menu_fallback() {
	$links = array(
		'Menu'      => home_url( '/menu/' ),
		'Our Story' => home_url( '/our-story/' ),
		'Catering'  => home_url( '/catering/' ),
		'Visit'     => home_url( '/visit/' ),
		'Blog'      => home_url( '/blog/' ),
		'Contact'   => home_url( '/contact/' ),
	);
	echo '<ul class="nav__list">';
	foreach ( $links as $label => $url ) {
		printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}
