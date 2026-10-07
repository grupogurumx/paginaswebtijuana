<?php
/**
 * Agave Taco Shop theme bootstrap.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

define( 'AGAVE_VERSION', '1.0.0' );
define( 'AGAVE_DIR', get_template_directory() );
define( 'AGAVE_URI', get_template_directory_uri() );

require AGAVE_DIR . '/inc/business.php';
require AGAVE_DIR . '/inc/menu-data.php';
require AGAVE_DIR . '/inc/customizer.php';
require AGAVE_DIR . '/inc/template-tags.php';
require AGAVE_DIR . '/inc/seo.php';
require AGAVE_DIR . '/inc/forms.php';
require AGAVE_DIR . '/inc/setup.php';

/**
 * Theme supports, menus and image sizes.
 */
function agave_setup() {
	load_theme_textdomain( 'agave', AGAVE_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 160,
			'width'       => 480,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_editor_style( array( agave_fonts_url(), 'assets/css/editor.css' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'agave' ),
			'footer'  => __( 'Footer menu', 'agave' ),
		)
	);

	add_image_size( 'agave-hero', 2400, 1100, true );
	add_image_size( 'agave-card', 900, 1100, true );
	add_image_size( 'agave-wide', 1600, 900, true );

	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => 'Agave Night', 'slug' => 'agave-night', 'color' => '#0d1f1a' ),
			array( 'name' => 'Agave Green', 'slug' => 'agave-green', 'color' => '#1f5c4a' ),
			array( 'name' => 'Blue Agave', 'slug' => 'blue-agave', 'color' => '#6fa89a' ),
			array( 'name' => 'Chile Red', 'slug' => 'chile-red', 'color' => '#c8372d' ),
			array( 'name' => 'Marigold', 'slug' => 'marigold', 'color' => '#f2a33a' ),
			array( 'name' => 'Masa Cream', 'slug' => 'masa-cream', 'color' => '#fbf4e6' ),
			array( 'name' => 'Charcoal', 'slug' => 'charcoal', 'color' => '#151311' ),
		)
	);
}
add_action( 'after_setup_theme', 'agave_setup' );

/**
 * Google Fonts: Fraunces (display), Manrope (UI/body), Caveat (hand-written accents).
 */
function agave_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;0,9..144,900;1,9..144,500&family=Manrope:wght@400;500;600;700;800&family=Caveat:wght@600&display=swap';
}

/**
 * Front-end assets.
 */
function agave_assets() {
	wp_enqueue_style( 'agave-fonts', agave_fonts_url(), array(), null );
	wp_enqueue_style( 'agave-main', AGAVE_URI . '/assets/css/main.css', array(), AGAVE_VERSION );
	wp_enqueue_script( 'agave-main', AGAVE_URI . '/assets/js/main.js', array(), AGAVE_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'agave_assets' );

/**
 * Preconnect to font hosts for faster first paint.
 */
function agave_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'agave_resource_hints', 10, 2 );

/**
 * Widget area for the blog sidebar.
 */
function agave_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'Blog sidebar', 'agave' ),
			'id'            => 'blog-sidebar',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'agave_widgets' );

/**
 * Body classes used by the motion layer.
 */
function agave_body_classes( $classes ) {
	$classes[] = 'agave';
	// Every template opens with a dark, full-bleed hero, so the header floats over it.
	$classes[] = 'has-hero';
	if ( is_front_page() ) {
		$classes[] = 'is-home';
	}
	return $classes;
}
add_filter( 'body_class', 'agave_body_classes' );

/**
 * Shorter, punchier excerpts.
 */
add_filter(
	'excerpt_length',
	static function () {
		return 26;
	}
);
add_filter(
	'excerpt_more',
	static function () {
		return '…';
	}
);
