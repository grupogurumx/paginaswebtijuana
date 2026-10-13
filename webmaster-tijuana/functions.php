<?php
/**
 * Webmaster Tijuana — funciones del tema.
 *
 * @package WebmasterTijuana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WMT_VERSION', '1.0.0' );
define( 'WMT_DIR', get_template_directory() );
define( 'WMT_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 * 1. Soporte del tema
 * ---------------------------------------------------------------------- */
function wmt_setup() {
	load_theme_textdomain( 'webmaster-tijuana', WMT_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 380,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'principal' => __( 'Menú principal', 'webmaster-tijuana' ),
			'pie'       => __( 'Menú del pie', 'webmaster-tijuana' ),
			'legal'     => __( 'Menú legal', 'webmaster-tijuana' ),
		)
	);

	add_image_size( 'wmt-card', 960, 600, true );
	add_image_size( 'wmt-wide', 1600, 800, true );
}
add_action( 'after_setup_theme', 'wmt_setup' );

function wmt_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'wmt_content_width', 0 );

/* -------------------------------------------------------------------------
 * 2. Estilos y scripts
 * ---------------------------------------------------------------------- */
function wmt_assets() {
	wp_enqueue_style(
		'wmt-fonts',
		'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'wmt-main', WMT_URI . '/assets/css/main.css', array(), WMT_VERSION );
	wp_enqueue_style( 'wmt-theme', get_stylesheet_uri(), array( 'wmt-main' ), WMT_VERSION );

	wp_enqueue_script( 'wmt-main', WMT_URI . '/assets/js/main.js', array(), WMT_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wmt_assets' );

function wmt_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'wmt_resource_hints', 10, 2 );

/**
 * Icono del sitio por defecto mientras no se suba uno en el Personalizador.
 */
function wmt_default_site_icon() {
	if ( has_site_icon() ) {
		return;
	}
	printf( '<link rel="icon" href="%s" sizes="512x512">' . "\n", esc_url( WMT_URI . '/assets/img/icono-512.png' ) );
	printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( WMT_URI . '/assets/img/icono-512.png' ) );
}
add_action( 'wp_head', 'wmt_default_site_icon', 5 );

/* -------------------------------------------------------------------------
 * 3. Archivos incluidos
 * ---------------------------------------------------------------------- */
require_once WMT_DIR . '/inc/helpers.php';
require_once WMT_DIR . '/inc/customizer.php';
require_once WMT_DIR . '/inc/cpt.php';
require_once WMT_DIR . '/inc/form.php';
require_once WMT_DIR . '/inc/schema.php';
require_once WMT_DIR . '/inc/seed.php';

/* -------------------------------------------------------------------------
 * 4. Widgets
 * ---------------------------------------------------------------------- */
function wmt_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'Barra lateral del blog', 'webmaster-tijuana' ),
			'id'            => 'sidebar-blog',
			'before_widget' => '<section id="%1$s" class="card widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget__title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'wmt_widgets' );

/* -------------------------------------------------------------------------
 * 5. Limpieza y rendimiento
 * ---------------------------------------------------------------------- */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

function wmt_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'wmt_disable_emojis' );

function wmt_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( is_front_page() ) {
		$classes[] = 'is-front';
	}
	return $classes;
}
add_filter( 'body_class', 'wmt_body_classes' );

add_filter( 'excerpt_length', function () { return 26; } );
add_filter( 'excerpt_more', function () { return '…'; } );
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
