<?php
/**
 * Acabados Contemporáneos — funciones del tema.
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

define( 'AC_VERSION', '1.0.0' );
define( 'AC_DIR', get_template_directory() );
define( 'AC_URI', get_template_directory_uri() );

/*
 * URL pública del paquete de imágenes (generadas con Magnific / Freepik AI).
 * El importador del tema lo descarga en el servidor y registra cada imagen
 * en la Biblioteca de medios.
 */
define( 'AC_IMAGES_ZIP', 'https://d2ol7oe51mr4n9.cloudfront.net/user_39X9oUM6mjMuWX1gzCztnOmmGzI/f080e1db-c8f3-47ba-aa12-875448352dd3.zip' );

require AC_DIR . '/inc/i18n.php';
require AC_DIR . '/inc/helpers.php';
require AC_DIR . '/inc/customizer.php';
require AC_DIR . '/inc/seo.php';
require AC_DIR . '/inc/contact.php';
require AC_DIR . '/inc/setup.php';

/**
 * Soportes del tema y menús.
 */
function ac_theme_setup() {
	load_theme_textdomain( 'acabados', AC_DIR . '/languages' );

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
			'height'      => 120,
			'width'       => 420,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'ac-card', 900, 1125, true );
	add_image_size( 'ac-wide', 1600, 900, true );

	register_nav_menus(
		array(
			'primary_es' => __( 'Menú principal (Español)', 'acabados' ),
			'primary_en' => __( 'Main menu (English)', 'acabados' ),
			'footer_es'  => __( 'Pie de página (Español)', 'acabados' ),
			'footer_en'  => __( 'Footer (English)', 'acabados' ),
		)
	);
}
add_action( 'after_setup_theme', 'ac_theme_setup' );

/**
 * Hojas de estilo y scripts.
 */
function ac_enqueue_assets() {
	wp_enqueue_style(
		'ac-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'ac-main', AC_URI . '/assets/css/main.css', array( 'ac-fonts' ), AC_VERSION );
	wp_enqueue_script( 'ac-main', AC_URI . '/assets/js/main.js', array(), AC_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
}
add_action( 'wp_enqueue_scripts', 'ac_enqueue_assets' );

/**
 * Preconnect a Google Fonts.
 */
function ac_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'ac_resource_hints', 10, 2 );

/**
 * Clases de body: idioma y página de inicio.
 */
function ac_body_classes( $classes ) {
	$classes[] = 'lang-' . ac_lang();
	if ( ac_is_home_view() ) {
		$classes[] = 'is-home';
	}
	return $classes;
}
add_filter( 'body_class', 'ac_body_classes' );

/**
 * Favicon de marca mientras no se configure un ícono del sitio.
 */
function ac_brand_favicon() {
	if ( ! has_site_icon() ) {
		printf( '<link rel="icon" type="image/png" href="%s">' . "\n", esc_url( AC_URI . '/assets/brand/icon.png' ) );
	}
}
add_action( 'wp_head', 'ac_brand_favicon', 3 );

/**
 * Atributo lang del documento según el idioma del contenido.
 */
function ac_language_attributes( $output ) {
	return 'en' === ac_lang() ? 'lang="en-US"' : 'lang="es-MX"';
}
add_filter( 'language_attributes', 'ac_language_attributes' );

/**
 * Extracto más corto y elegante.
 */
add_filter(
	'excerpt_length',
	function () {
		return 26;
	}
);
add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);
