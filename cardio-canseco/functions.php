<?php
/**
 * Cardio Canseco — funciones del tema.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CARDIO_VERSION', '1.1.0' );
define( 'CARDIO_DIR', get_template_directory() );
define( 'CARDIO_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 * 1. Soporte del tema
 * ---------------------------------------------------------------------- */
function cardio_setup() {
	load_theme_textdomain( 'cardio-canseco', CARDIO_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 96,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'principal' => __( 'Menú principal', 'cardio-canseco' ),
			'pie'       => __( 'Menú del pie', 'cardio-canseco' ),
			'legal'     => __( 'Menú legal', 'cardio-canseco' ),
		)
	);

	// Tamaños de imagen usados por las plantillas.
	add_image_size( 'cardio-hero', 2400, 1028, true );
	add_image_size( 'cardio-card', 1400, 875, true );
}
add_action( 'after_setup_theme', 'cardio_setup' );

/**
 * Ancho de contenido.
 */
function cardio_content_width() {
	$GLOBALS['content_width'] = 1240;
}
add_action( 'after_setup_theme', 'cardio_content_width', 0 );

/* -------------------------------------------------------------------------
 * 2. Estilos y scripts
 * ---------------------------------------------------------------------- */
function cardio_assets() {
	// Tipografías de Google.
	wp_enqueue_style(
		'cardio-fonts',
		'https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'cardio-main', CARDIO_URI . '/assets/css/style.css', array(), CARDIO_VERSION );
	wp_enqueue_style( 'cardio-theme', get_stylesheet_uri(), array( 'cardio-main' ), CARDIO_VERSION );

	wp_enqueue_script( 'cardio-main', CARDIO_URI . '/assets/js/main.js', array(), CARDIO_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cardio_assets' );

/**
 * Preconexión a Google Fonts.
 */
function cardio_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'cardio_resource_hints', 10, 2 );

/* -------------------------------------------------------------------------
 * 3. Archivos incluidos
 * ---------------------------------------------------------------------- */
require_once CARDIO_DIR . '/inc/template-tags.php';
require_once CARDIO_DIR . '/inc/customizer.php';
require_once CARDIO_DIR . '/inc/cpt.php';
require_once CARDIO_DIR . '/inc/schema.php';
require_once CARDIO_DIR . '/inc/form-handler.php';
require_once CARDIO_DIR . '/inc/shortcodes.php';
require_once CARDIO_DIR . '/inc/defaults.php';

/* -------------------------------------------------------------------------
 * 4. Widgets
 * ---------------------------------------------------------------------- */
function cardio_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'Barra lateral del blog', 'cardio-canseco' ),
			'id'            => 'sidebar-blog',
			'description'   => __( 'Se muestra junto a las entradas del blog.', 'cardio-canseco' ),
			'before_widget' => '<section id="%1$s" class="form-card widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="mt-0" style="font-size:var(--fs-md)">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'cardio_widgets' );

/* -------------------------------------------------------------------------
 * 5. Limpieza y rendimiento
 * ---------------------------------------------------------------------- */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/**
 * Quita los emojis: no se usan y añaden peso.
 */
function cardio_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'cardio_disable_emojis' );

/**
 * Carga diferida nativa y decodificación asíncrona en las imágenes del contenido.
 */
function cardio_img_attrs( $attr ) {
	if ( ! isset( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}
	if ( ! isset( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'cardio_img_attrs' );

/**
 * Clases útiles en el body.
 */
function cardio_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( is_front_page() ) {
		$classes[] = 'is-front';
	}
	return $classes;
}
add_filter( 'body_class', 'cardio_body_classes' );

/**
 * Extracto: longitud y terminación.
 */
add_filter( 'excerpt_length', function () { return 28; } );
add_filter( 'excerpt_more', function () { return '…'; } );

/**
 * Título del archivo sin el prefijo «Categoría:».
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
