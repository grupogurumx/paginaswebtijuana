<?php
/**
 * Hospital Nova 2026 — functions.
 *
 * @package hospital-nova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NOVA_VERSION', '1.0.0' );
define( 'NOVA_DIR', get_template_directory() );
define( 'NOVA_URI', get_template_directory_uri() );

require NOVA_DIR . '/inc/helpers.php';
require NOVA_DIR . '/inc/customizer.php';
require NOVA_DIR . '/inc/contact-form.php';
require NOVA_DIR . '/inc/shortcodes.php';
require NOVA_DIR . '/inc/seo.php';

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'hospital-nova', NOVA_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 104, 'width' => 280, 'flex-width' => true, 'flex-height' => true ) );
	add_image_size( 'nova-card', 800, 500, true );

	register_nav_menus( array(
		'primary' => __( 'Menú principal', 'hospital-nova' ),
		'footer'  => __( 'Menú pie de página', 'hospital-nova' ),
	) );

	// Paleta del editor de bloques = colores del logotipo.
	add_theme_support( 'editor-color-palette', array(
		array( 'name' => 'Nova Teal', 'slug' => 'nova-teal', 'color' => '#16a394' ),
		array( 'name' => 'Nova Mint', 'slug' => 'nova-mint', 'color' => '#8edbcd' ),
		array( 'name' => 'Nova Navy', 'slug' => 'nova-navy', 'color' => '#0e2a3f' ),
		array( 'name' => 'Nova Pink', 'slug' => 'nova-pink', 'color' => '#e8467c' ),
		array( 'name' => 'Blanco', 'slug' => 'white', 'color' => '#ffffff' ),
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'nova-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'nova-main', NOVA_URI . '/assets/css/main.css', array(), NOVA_VERSION );
	wp_enqueue_script( 'nova-main', NOVA_URI . '/assets/js/main.js', array(), NOVA_VERSION, true );
} );

// Preconnect a Google Fonts para mejorar LCP.
add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

// Precarga de la primera imagen del slider (LCP).
add_action( 'wp_head', function () {
	if ( is_front_page() ) {
		$slides = nova_slides();
		if ( ! empty( $slides[0]['img'] ) ) {
			printf( '<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n", esc_url( $slides[0]['img'] ) );
		}
	}
}, 2 );

add_filter( 'excerpt_length', function () {
	return 24;
} );
add_filter( 'excerpt_more', function () {
	return '…';
} );

// Menú de respaldo si aún no se asigna uno en Apariencia > Menús.
function nova_fallback_menu() {
	$items = array(
		array( nova_t( 'Inicio', 'Home' ), home_url( '/' ) ),
		array( nova_t( 'Especialidades', 'Specialties' ), nova_page_url( 'especialidades', 'specialties' ) ),
		array( nova_t( 'Servicios 24/7', '24/7 Services' ), nova_page_url( 'servicios', 'services' ) ),
		array( nova_t( 'Médicos', 'Doctors' ), nova_page_url( 'medicos', 'doctors' ) ),
		array( 'Blog', nova_page_url( 'blog', 'blog-en' ) ),
		array( nova_t( 'Contacto', 'Contact' ), nova_page_url( 'contacto', 'contact' ) ),
	);
	echo '<ul>';
	foreach ( $items as $it ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $it[1] ), esc_html( $it[0] ) );
	}
	echo '</ul>';
}
