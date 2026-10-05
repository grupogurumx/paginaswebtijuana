<?php
/**
 * Peanut Bakery — funciones del tema.
 *
 * @package PeanutBakery
 */

defined( 'ABSPATH' ) || exit;

define( 'PB_VERSION', '2.0.0' );
define( 'PB_DIR', get_template_directory() );
define( 'PB_URI', get_template_directory_uri() );

require PB_DIR . '/inc/helpers.php';
require PB_DIR . '/inc/content.php';
require PB_DIR . '/inc/customizer.php';
require PB_DIR . '/inc/seo.php';
require PB_DIR . '/inc/forms.php';
require PB_DIR . '/template-parts/sections.php';

/**
 * Soportes del tema y menús.
 */
function pb_setup() {
	load_theme_textdomain( 'peanut-bakery', PB_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'pb-panorama', 2400, 1030, true );
	add_image_size( 'pb-card', 900, 1200, true );
	add_image_size( 'pb-wide', 1600, 900, true );

	register_nav_menus(
		array(
			'principal' => __( 'Menú principal', 'peanut-bakery' ),
			'footer'    => __( 'Menú del pie de página', 'peanut-bakery' ),
		)
	);
}
add_action( 'after_setup_theme', 'pb_setup' );

/**
 * Estilos y scripts.
 */
function pb_assets() {
	wp_enqueue_style(
		'pb-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,800&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'pb-main', PB_URI . '/assets/css/main.css', array( 'pb-fonts' ), PB_VERSION );
	wp_enqueue_script( 'pb-main', PB_URI . '/assets/js/main.js', array(), PB_VERSION, true );
	wp_script_add_data( 'pb-main', 'strategy', 'defer' );
}
add_action( 'wp_enqueue_scripts', 'pb_assets' );

/**
 * Marca <html class="js"> antes de pintar, para que las animaciones de entrada no parpadeen.
 */
add_action(
	'wp_head',
	function () {
		echo "<script>document.documentElement.classList.add('js');</script>\n";
	},
	0
);

/**
 * Pre-conexión a Google Fonts para mejorar LCP.
 */
function pb_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'pb_resource_hints', 10, 2 );

/**
 * Menú de respaldo cuando aún no se asigna uno en Apariencia → Menús.
 */
function pb_fallback_menu() {
	$items = array(
		home_url( '/' )           => __( 'Inicio', 'peanut-bakery' ),
		home_url( '/nosotros/' )  => __( 'Nosotros', 'peanut-bakery' ),
		home_url( '/productos/' ) => __( 'Productos', 'peanut-bakery' ),
		home_url( '/mayoreo/' )   => __( 'Ventas', 'peanut-bakery' ),
		home_url( '/blog/' )      => __( 'Blog', 'peanut-bakery' ),
		home_url( '/contacto/' )  => __( 'Contacto', 'peanut-bakery' ),
	);
	echo '<ul class="nav__list">';
	foreach ( $items as $url => $label ) {
		printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Extracto corto para tarjetas del blog.
 */
add_filter(
	'excerpt_length',
	function () {
		return 22;
	}
);
