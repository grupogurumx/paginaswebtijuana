<?php
/**
 * Renderiza la portada del tema SIN WordPress (funciones simuladas) para:
 *  1) probar que las plantillas PHP ejecutan sin errores, y
 *  2) generar el prototipo estático hospital-nova/prototipo/index[-en].html.
 *
 * Uso: node hospital-nova/scripts/export-posts.js && php hospital-nova/scripts/render-prototype.php es
 */
error_reporting( E_ALL );
ini_set( 'display_errors', 'stderr' );
set_error_handler( function ( $no, $str, $file, $line ) {
	fwrite( STDERR, "PHP[$no] $str @ $file:$line\n" );
	exit( 1 );
} );

$GLOBALS['NOVA_LANG'] = isset( $argv[1] ) && 'en' === $argv[1] ? 'en' : 'es';
define( 'ABSPATH', __DIR__ );
define( 'MINUTE_IN_SECONDS', 60 );
$theme = realpath( __DIR__ . '/../wp-theme/hospital-nova' );
$GLOBALS['POSTS'] = json_decode( file_get_contents( $argv[2] ), true );

// ---- Hooks ----
$GLOBALS['HOOKS'] = array();
function add_action( $h, $cb, $p = 10, $n = 1 ) { $GLOBALS['HOOKS'][ $h ][ $p ][] = array( $cb, $n ); }
function add_filter( $h, $cb, $p = 10, $n = 1 ) { add_action( $h, $cb, $p, $n ); }
function do_action( $h, ...$a ) { if ( empty( $GLOBALS['HOOKS'][ $h ] ) ) return; ksort( $GLOBALS['HOOKS'][ $h ] ); foreach ( $GLOBALS['HOOKS'][ $h ] as $cbs ) foreach ( $cbs as $c ) call_user_func_array( $c[0], array_slice( $a, 0, $c[1] ) ); }
function apply_filters( $h, $v, ...$a ) { if ( empty( $GLOBALS['HOOKS'][ $h ] ) ) return $v; ksort( $GLOBALS['HOOKS'][ $h ] ); foreach ( $GLOBALS['HOOKS'][ $h ] as $cbs ) foreach ( $cbs as $c ) $v = call_user_func_array( $c[0], array_slice( array_merge( array( $v ), $a ), 0, $c[1] ) ); return $v; }
$GLOBALS['SC'] = array();
function add_shortcode( $t, $cb ) { $GLOBALS['SC'][ $t ] = $cb; }
function do_shortcode( $s ) { return preg_replace_callback( '/\[(\w+)\]/', function ( $m ) { return isset( $GLOBALS['SC'][ $m[1] ] ) ? call_user_func( $GLOBALS['SC'][ $m[1] ], array() ) : $m[0]; }, $s ); }
function shortcode_atts( $d, $a ) { return array_merge( $d, (array) $a ); }

// ---- Escapes / utils ----
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $s ) { return esc_html( $s ); }
function esc_textarea( $s ) { return esc_html( $s ); }
function esc_url( $s ) { return esc_html( $s ); }
function esc_url_raw( $s ) { return $s; }
function wp_kses( $s, $a ) { return $s; }
function wp_kses_post( $s ) { return $s; }
function wp_strip_all_tags( $s ) { return trim( strip_tags( $s ) ); }
function __( $s, $d = '' ) { return $s; }
function absint( $n ) { return abs( (int) $n ); }
function sanitize_key( $s ) { return preg_replace( '/[^a-z0-9_\-]/', '', strtolower( $s ) ); }
function sanitize_text_field( $s ) { return trim( strip_tags( $s ) ); }
function wp_unslash( $s ) { return $s; }
function selected( $a, $b ) { echo $a === $b ? ' selected' : ''; }
function add_query_arg( $k, $v, $url ) { return $url . ( strpos( $url, '?' ) === false ? '?' : '&' ) . $k . '=' . rawurlencode( $v ); }
function wp_json_encode( $d, $f = 0 ) { return json_encode( $d, $f ); }
function wp_date( $f ) { return date( $f ); }
function wp_trim_words( $s, $n = 55, $m = '…' ) { $w = preg_split( '/\s+/', $s ); return implode( ' ', array_slice( $w, 0, $n ) ) . ( count( $w ) > $n ? $m : '' ); }
function strip_shortcodes( $s ) { return preg_replace( '/\[[^\]]+\]/', '', $s ); }

// ---- Contexto WP ----
function get_template_directory() { return $GLOBALS['theme']; }
function get_template_directory_uri() { return '../wp-theme/hospital-nova'; }
function get_locale() { return 'en' === $GLOBALS['NOVA_LANG'] ? 'en_US' : 'es_MX'; }
function home_url( $p = '/' ) { return 'en' === $GLOBALS['NOVA_LANG'] ? 'index-en.html' : 'index.html'; }
function admin_url( $p ) { return '#'; }
function get_page_by_path( $s ) { return null; }
function get_theme_mod( $k, $d = false ) { return $d; }
function get_option( $k ) { return 0; }
function get_bloginfo( $k ) { return 'Hospital Nova'; }
function bloginfo( $k ) { echo 'UTF-8'; }
function language_attributes() { echo 'en' === $GLOBALS['NOVA_LANG'] ? 'lang="en-US"' : 'lang="es-MX"'; }
function body_class() { echo 'class="home"'; }
function wp_body_open() {}
function is_front_page() { return true; }
function is_home() { return false; }
function is_singular() { return false; }
function is_single() { return false; }
function is_search() { return false; }
function is_404() { return false; }
function is_archive() { return false; }
function is_category() { return false; }
function is_tag() { return false; }
function wp_get_document_title() { return apply_filters( 'pre_get_document_title', 'Hospital Nova' ); }
function get_permalink( $p = null ) { return $GLOBALS['CUR'] ? '#' . $GLOBALS['CUR']['slug'] : 'index.html'; }
function get_privacy_policy_url() { return '#privacidad'; }
function wp_nonce_field() { echo '<input type="hidden" name="nova_nonce" value="demo">'; }
function wp_nav_menu( $a ) { call_user_func( $a['fallback_cb'] ); }
function wp_get_attachment_image() { return ''; }
function register_nav_menus() {}
function add_theme_support() {}
function add_image_size() {}
function load_theme_textdomain() {}
function register_post_type() {}
$GLOBALS['ENQ'] = array( 'css' => array(), 'js' => array() );
function wp_enqueue_style( $h, $src ) { $GLOBALS['ENQ']['css'][] = $src; }
function wp_enqueue_script( $h, $src ) { $GLOBALS['ENQ']['js'][] = $src; }
function wp_head() {
	do_action( 'wp_enqueue_scripts' );
	echo "<title>" . esc_html( wp_get_document_title() ) . "</title>\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	foreach ( $GLOBALS['ENQ']['css'] as $c ) echo '<link rel="stylesheet" href="' . esc_attr( $c ) . '">' . "\n";
	do_action( 'wp_head' );
}
function wp_footer() { foreach ( $GLOBALS['ENQ']['js'] as $j ) echo '<script src="' . esc_attr( $j ) . '"></script>' . "\n"; }
function get_header() { require $GLOBALS['theme'] . '/header.php'; }
function get_footer() { require $GLOBALS['theme'] . '/footer.php'; }
function get_template_part( $slug, $name = null, $args = array() ) { require $GLOBALS['theme'] . '/' . $slug . '.php'; }

// Bucle principal (página "Inicio" vacía) y WP_Query para el blog.
$GLOBALS['MAIN'] = 1;
$GLOBALS['CUR']  = null;
function have_posts() { return $GLOBALS['MAIN']-- > 0; }
function the_post() {}
function get_the_content() { return ''; }
class WP_Query {
	private $i = 0; private $items;
	function __construct( $a ) { $this->items = array_slice( $GLOBALS['POSTS'][ $GLOBALS['NOVA_LANG'] ], 0, $a['posts_per_page'] ); }
	function have_posts() { return $this->i < count( $this->items ); }
	function the_post() { $GLOBALS['CUR'] = $this->items[ $this->i++ ]; }
}
function wp_reset_postdata() { $GLOBALS['CUR'] = null; }
function the_permalink() { echo esc_url( get_permalink() ); }
function the_title() { echo esc_html( $GLOBALS['CUR']['title'] ); }
function get_the_excerpt() { return $GLOBALS['CUR']['excerpt']; }
function has_post_thumbnail() { return false; }
function get_the_ID() { return 1; }
function get_post_meta( $id, $k, $s ) { return '_nova_fallback_img' === $k ? $GLOBALS['CUR']['img'] : ''; }
function get_the_category() { return array( (object) array( 'name' => $GLOBALS['CUR']['category'] ) ); }

require $theme . '/functions.php';
ob_start();
require $theme . '/front-page.php';
$html = ob_get_clean();
$out  = __DIR__ . '/../prototipo/' . ( 'en' === $GLOBALS['NOVA_LANG'] ? 'index-en.html' : 'index.html' );
file_put_contents( $out, "<!-- Prototipo generado desde el tema WordPress (scripts/render-prototype.php). -->\n" . $html );
fwrite( STDERR, 'OK ' . realpath( $out ) . ' (' . strlen( $html ) . " bytes)\n" );
