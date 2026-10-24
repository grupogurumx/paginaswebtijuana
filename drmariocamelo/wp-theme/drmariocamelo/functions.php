<?php
/**
 * Dr. Mario Camelo theme bootstrap.
 */

defined( 'ABSPATH' ) || exit;

define( 'DMC_VERSION', '1.0.0' );
define( 'DMC_DIR', get_template_directory() );
define( 'DMC_URI', get_template_directory_uri() );

require DMC_DIR . '/inc/i18n.php';
require DMC_DIR . '/inc/customizer.php';
require DMC_DIR . '/inc/seo.php';
require DMC_DIR . '/inc/shortcodes.php';
require DMC_DIR . '/inc/setup.php';

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'drmariocamelo', DMC_DIR . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 360, 'flex-width' => true, 'flex-height' => true ) );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_post_type_support( 'page', 'excerpt' );
		set_post_thumbnail_size( 1200, 750, true );
		register_nav_menus(
			array(
				'primary_en' => 'Primary menu (English)',
				'primary_es' => 'Menú principal (Español)',
				'footer_en'  => 'Footer menu (English)',
				'footer_es'  => 'Menú pie (Español)',
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'dmc-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap', array(), null );
		wp_enqueue_style( 'dmc-style', get_stylesheet_uri(), array( 'dmc-fonts' ), DMC_VERSION );
		wp_enqueue_script( 'dmc-main', DMC_URI . '/assets/js/main.js', array(), DMC_VERSION, true );
		wp_script_add_data( 'dmc-main', 'strategy', 'defer' );
	}
);

add_filter(
	'wp_resource_hints',
	function ( $urls, $relation ) {
		if ( 'preconnect' === $relation ) {
			$urls[] = 'https://fonts.googleapis.com';
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		}
		return $urls;
	},
	10,
	2
);

/**
 * Theme image URL. Prefers the generated Magnific/Higgsfield file when it has
 * been uploaded to assets/img, otherwise falls back to a bundled photo.
 */
function dmc_img( $file, $fallback = '' ) {
	foreach ( array( $file, preg_replace( '/\.png$/', '.jpg', $file ), preg_replace( '/\.png$/', '.webp', $file ) ) as $candidate ) {
		if ( $candidate && file_exists( DMC_DIR . '/assets/img/' . $candidate ) ) {
			return DMC_URI . '/assets/img/' . $candidate;
		}
	}
	return $fallback ? DMC_URI . '/assets/img/' . $fallback : '';
}

/** Primary navigation with a bilingual fallback when no menu is assigned. */
function dmc_nav( $location ) {
	$lang = dmc_lang();
	$loc  = $location . '_' . $lang;
	if ( has_nav_menu( $loc ) ) {
		wp_nav_menu( array( 'theme_location' => $loc, 'container' => false, 'depth' => 2 ) );
		return;
	}
	$items = 'primary' === $location
		? array( 'about', 'sleeve', 'bypass', 'financing', 'reviews', 'blog', 'contact' )
		: array( 'about', 'sleeve', 'bypass', 'revision', 'metabolic', 'financing', 'reviews', 'blog', 'contact', 'privacy' );
	echo '<ul>';
	foreach ( $items as $key ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( dmc_page_url( $key ) ), esc_html( dmc_t( 'nav_' . $key ) ) );
	}
	echo '</ul>';
}

/** Inline SVG logo used when no custom logo is uploaded. */
function dmc_logo_svg() {
	return '<svg viewBox="0 0 64 64" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="dmcg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#f3dd97"/><stop offset=".5" stop-color="#d4af37"/><stop offset="1" stop-color="#a8831c"/></linearGradient></defs><circle cx="32" cy="32" r="30" fill="#0a1733" stroke="url(#dmcg)" stroke-width="3"/><path d="M27 14c0 6 2 9 6 11 7 3 11 8 11 15 0 7-6 12-13 12-6 0-10-3-12-7 3 2 6 3 9 3 5 0 8-3 8-7 0-5-4-8-9-10-5-2-7-6-7-12z" fill="url(#dmcg)"/></svg>';
}

/** Whether the WhatsApp number has been configured. */
function dmc_whatsapp_url( $text = '' ) {
	$num = preg_replace( '/\D/', '', (string) get_theme_mod( 'dmc_whatsapp', '' ) );
	if ( ! $num ) {
		return '';
	}
	return 'https://wa.me/' . $num . ( $text ? '?text=' . rawurlencode( $text ) : '' );
}

/** Excerpt length for cards. */
add_filter( 'excerpt_length', fn() => 26 );
add_filter( 'excerpt_more', fn() => '…' );
