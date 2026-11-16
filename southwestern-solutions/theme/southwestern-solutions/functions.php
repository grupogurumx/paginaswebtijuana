<?php
/**
 * Southwestern Solutions theme bootstrap.
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SWS_VERSION', '1.0.0' );
define( 'SWS_DIR', get_template_directory() );
define( 'SWS_URI', get_template_directory_uri() );

require SWS_DIR . '/inc/helpers.php';
require SWS_DIR . '/inc/seo.php';
require SWS_DIR . '/inc/shortcodes.php';
require SWS_DIR . '/inc/contact.php';
require SWS_DIR . '/inc/redirects.php';
require SWS_DIR . '/inc/customizer.php';
require SWS_DIR . '/inc/woocommerce.php';

/**
 * Theme supports & menus.
 */
function sws_setup() {
	load_theme_textdomain( 'sws', SWS_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 400, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_image_size( 'sws-card', 900, 560, true );
	add_image_size( 'sws-hero', 2400, 1200, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'sws' ),
			'footer'  => __( 'Footer Menu', 'sws' ),
		)
	);
}
add_action( 'after_setup_theme', 'sws_setup' );

/**
 * Assets.
 */
function sws_assets() {
	wp_enqueue_style( 'sws-fonts', 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'sws-main', SWS_URI . '/assets/css/main.css', array(), SWS_VERSION );
	wp_enqueue_script( 'sws-main', SWS_URI . '/assets/js/main.js', array(), SWS_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sws_assets' );

/** Preconnect to Google Fonts + preload the first hero image for LCP. */
function sws_resource_hints() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	if ( is_front_page() ) {
		echo '<link rel="preload" as="image" href="' . esc_url( sws_img( 'training-launcher.webp' ) ) . '" type="image/webp" fetchpriority="high">' . "\n";
	}
}
add_action( 'wp_head', 'sws_resource_hints', 1 );

/** Editor styles so Gutenberg looks close to the front end. */
function sws_editor_assets() {
	add_editor_style( array( 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Inter:wght@400;600&display=swap' ) );
}
add_action( 'after_setup_theme', 'sws_editor_assets', 20 );

/** Excerpt tweaks. */
add_filter( 'excerpt_length', function () { return 26; } );
add_filter( 'excerpt_more', function () { return '…'; } );

/** Remove emoji bloat for speed. */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * One-time auto setup after the XML import: static front page ("home"),
 * posts page ("blog"), primary menu location and pretty permalinks.
 */
function sws_auto_setup() {
	if ( get_option( 'sws_setup_done' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$home = get_page_by_path( 'home' );
	$blog = get_page_by_path( 'blog' );
	if ( ! $home || ! $blog ) {
		return; // Import not run yet.
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home->ID );
	update_option( 'page_for_posts', $blog->ID );
	update_option( 'blogdescription', 'POST-Certified Law Enforcement Instructor Training in San Diego' );
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
		flush_rewrite_rules();
	}
	$menu = wp_get_nav_menu_object( 'main-menu' );
	if ( $menu ) {
		$locs = get_theme_mod( 'nav_menu_locations', array() );
		if ( empty( $locs['primary'] ) ) {
			$locs['primary'] = $menu->term_id;
			set_theme_mod( 'nav_menu_locations', $locs );
		}
	}
	update_option( 'sws_setup_done', 1 );
}
add_action( 'admin_init', 'sws_auto_setup' );

/**
 * One-time WooCommerce store setup for course registrations: USD, California,
 * no shipping/taxes, and classic (shortcode) cart + checkout so the theme's
 * "Agency / Department" and attendee fields apply.
 */
function sws_wc_auto_setup() {
	if ( get_option( 'sws_wc_setup_done' ) || ! class_exists( 'WooCommerce' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	update_option( 'woocommerce_currency', 'USD' );
	update_option( 'woocommerce_default_country', 'US:CA' );
	update_option( 'woocommerce_calc_taxes', 'no' );
	update_option( 'woocommerce_ship_to_countries', 'disabled' );
	update_option( 'woocommerce_enable_guest_checkout', 'yes' );
	// Agencies usually pay by PO / invoice: enable the offline "cheque" gateway, relabelled.
	// Add card payments (WooPayments, Stripe or PayPal) with the client's own account.
	update_option(
		'woocommerce_cheque_settings',
		array(
			'enabled'      => 'yes',
			'title'        => 'Agency Invoice / Purchase Order',
			'description'  => 'Reserve your seats now. We will email an invoice payable by agency check, purchase order or card. POST Plan IV paperwork included.',
			'instructions' => 'Your seats are reserved. An invoice and POST Plan IV paperwork will be emailed within one business day.',
		)
	);
	foreach ( array( 'cart' => '[woocommerce_cart]', 'checkout' => '[woocommerce_checkout]' ) as $key => $sc ) {
		$pid = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( $key ) : 0;
		if ( $pid > 0 ) {
			wp_update_post( array( 'ID' => $pid, 'post_content' => "<!-- wp:shortcode -->\n{$sc}\n<!-- /wp:shortcode -->" ) );
			update_post_meta( $pid, '_sws_hero', 'instructor-scope.webp' );
		}
	}
	update_option( 'sws_wc_setup_done', 1 );
}
add_action( 'admin_init', 'sws_wc_auto_setup', 20 );

/** Menu fallback when no menu is assigned yet. */
function sws_menu_fallback() {
	$items = array(
		'/'                                => 'Home',
		'/about-us/'                       => 'About',
		'/courses/'                        => 'Courses',
		'/ab-48-compliance/'               => 'AB 48',
		'/training-schedule/'              => 'Schedule',
		'/blog/'                           => 'Insights',
		'/contact/'                        => 'Contact',
	);
	echo '<ul>';
	foreach ( $items as $url => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $url ) ), esc_html( $label ) );
	}
	echo '</ul>';
}
