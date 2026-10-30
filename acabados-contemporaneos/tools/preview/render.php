<?php
/**
 * Renderiza las plantillas reales del tema a HTML estático, sin WordPress,
 * con un stub mínimo de funciones. Solo para vista previa y QA visual.
 *
 * Uso: php tools/preview/render.php <vista> > salida.html
 *   vistas: home-es | home-en | page-es | post-es | 404
 */

$view = isset( $argv[1] ) ? $argv[1] : 'home-es';
define( 'ABSPATH', __DIR__ . '/' );
$THEME = realpath( __DIR__ . '/../../theme/acabados-contemporaneos' );

/* ---------------- Datos falsos ---------------- */
$GLOBALS['ac_pages'] = array(
	'inicio' => 'Inicio', 'nosotros' => 'Nosotros', 'productos' => 'Productos',
	'productos/porcelanicos' => 'Porcelánicos', 'productos/ceramica' => 'Cerámica', 'productos/recubrimientos-de-muro' => 'Recubrimientos de muro',
	'productos/porcelanato-tipo-madera' => 'Porcelanato tipo madera', 'productos/mosaicos' => 'Mosaicos', 'productos/accesorios-de-instalacion' => 'Accesorios de instalación',
	'ambientes' => 'Ambientes', 'profesionales' => 'Profesionales', 'blog' => 'Blog', 'contacto' => 'Contacto', 'aviso-de-privacidad' => 'Aviso de privacidad',
	'en' => 'Home', 'en/about' => 'About', 'en/products' => 'Products', 'en/products/porcelain-tile' => 'Porcelain tile', 'en/products/ceramic-tile' => 'Ceramic tile',
	'en/products/wall-cladding' => 'Wall cladding', 'en/products/wood-look-tile' => 'Wood-look tile', 'en/products/mosaic-tile' => 'Mosaic tile',
	'en/products/installation-accessories' => 'Installation accessories', 'en/spaces' => 'Spaces', 'en/professionals' => 'Professionals', 'en/blog' => 'Blog', 'en/contact' => 'Contact', 'en/privacy-notice' => 'Privacy notice',
);
$GLOBALS['ac_view'] = $view;
$GLOBALS['ac_lang_meta'] = in_array( $view, array( 'home-en' ), true ) ? 'en' : 'es';
$GLOBALS['ac_posts'] = array(
	array( 'Cerámica vs. porcelanato: cómo elegir el piso ideal para cada espacio', 'blog-ceramica-vs-porcelanato', 'Diferencias reales en absorción, resistencia y precio para que inviertas en el recubrimiento correcto.' ),
	array( 'Tendencias en recubrimientos 2026: lo que verás en las casas más elegantes', 'blog-tendencias', 'Tonos tierra, gran formato y texturas naturales dominan el diseño de interiores este año.' ),
	array( 'Guía de instalación de porcelanato de gran formato sin errores', 'blog-instalacion', 'Adhesivo, nivelación y juntas: los pasos que garantizan un acabado perfecto y duradero.' ),
);
$GLOBALS['ac_loop'] = -1;
$GLOBALS['ac_post_idx'] = 0;

/* ---------------- Stub WordPress ---------------- */
define( 'OBJECT', 'OBJECT' );
function add_query_arg( $a, $u = '' ) { return $u; }
$GLOBALS['wp'] = (object) array( 'request' => '' );
class WP_Query {
	public $posts; public $i = -1; public $max_num_pages = 1;
	function __construct( $a = array() ) { $this->posts = $GLOBALS['ac_posts']; }
	function have_posts() { return $this->i + 1 < count( $this->posts ); }
	function the_post() { $this->i++; $GLOBALS['ac_post_idx'] = $this->i; }
}
function add_action() {} function add_filter() {} function add_shortcode() {} function add_theme_support() {} function register_nav_menus() {}
function add_image_size() {} function load_theme_textdomain() {} function add_meta_box() {} function add_theme_page() {}
function __( $s ) { return $s; }
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $s ) { return esc_html( $s ); }
function esc_url( $s ) { return esc_html( $s ); }
function esc_textarea( $s ) { return esc_html( $s ); }
function wp_kses_post( $s ) { return $s; }
function get_template_directory() { return $GLOBALS['THEME']; }
function get_template_directory_uri() { return '../theme/acabados-contemporaneos'; }
function apply_filters( $tag, $v ) { if ( 'ac_img_fallback_url' === $tag ) { $a = func_get_args(); return '../theme/acabados-contemporaneos/assets/img/' . $a[2] . '.webp'; } return $v; }
function trailingslashit( $s ) { return rtrim( $s, '/' ) . '/'; }
function home_url( $p = '/' ) { return 'https://acabadoscontemporaneos.com' . $p; }
function admin_url( $p = '' ) { return 'https://acabadoscontemporaneos.com/wp-admin/' . $p; }
function get_option( $k, $d = false ) { return 'ac_image_map' === $k ? array() : $d; }
function get_theme_mod( $k, $d = '' ) {
	$demo = array( 'ac_whatsapp' => '5210000000000', 'ac_phone' => '+52 (000) 000 0000', 'ac_email' => 'ventas@acabadoscontemporaneos.com', 'ac_city' => 'Ciudad', 'ac_street' => 'Dirección del showroom', 'ac_hours_es' => 'Lun a Vie · Sáb', 'ac_instagram' => '#', 'ac_facebook' => '#', 'ac_pinterest' => '#' );
	return isset( $demo[ $k ] ) ? $demo[ $k ] : $d;
}
function wp_parse_args( $a, $d ) { return array_merge( $d, $a ); }
function sanitize_key( $s ) { return strtolower( preg_replace( '/[^a-z0-9_\-]/i', '', $s ) ); }
function sanitize_text_field( $s ) { return trim( $s ); }
function wp_unslash( $s ) { return $s; }
function antispambot( $s ) { return $s; }
function wp_json_encode( $d, $f = 0 ) { return json_encode( $d, $f ); }
function get_bloginfo( $k = '' ) { return 'Acabados Contemporáneos'; }
function bloginfo( $k ) { echo 'charset' === $k ? 'UTF-8' : 'Acabados Contemporáneos'; }
function wp_get_document_title() { return 'Acabados Contemporáneos | Recubrimientos, cerámica y porcelanato en México'; }
function language_attributes() { echo ac_language_attributes( '' ); }
function body_class() { echo 'class="' . esc_attr( implode( ' ', ac_body_classes( array( 'preview' ) ) ) ) . '"'; }
function wp_body_open() {}
function has_custom_logo() { return false; }
function is_front_page() { return 'home-es' === $GLOBALS['ac_view']; }
function is_home() { return false; }
function is_page() { return in_array( $GLOBALS['ac_view'], array( 'home-en', 'page-es' ), true ); }
function is_singular( $t = null ) { $v = $GLOBALS['ac_view']; if ( 'post' === $t ) { return 'post-es' === $v; } if ( 'page' === $t ) { return in_array( $v, array( 'home-es', 'home-en', 'page-es' ), true ); } return '404' !== $v; }
function is_category() { return false; } function is_search() { return false; } function is_404() { return '404' === $GLOBALS['ac_view']; } function is_archive() { return false; }
function is_user_logged_in() { return false; } function current_user_can() { return false; } function wp_doing_ajax() { return false; }
function get_queried_object_id() { return 1; }
function get_queried_object() { return null; }
function get_page_template_slug() { return 'home-en' === $GLOBALS['ac_view'] ? 'page-templates/home.php' : ''; }
function get_post_meta( $id, $k, $s = false ) {
	if ( '_ac_lang' === $k ) { return $GLOBALS['ac_lang_meta']; }
	if ( '_ac_translation' === $k ) { return 'es' === $GLOBALS['ac_lang_meta'] ? 'en' : 'inicio'; }
	if ( '_ac_image' === $k ) { return 'post-es' === $GLOBALS['ac_view'] && $GLOBALS['ac_loop'] < 0 ? 'blog-ceramica-vs-porcelanato' : ( 'page-es' === $GLOBALS['ac_view'] && $GLOBALS['ac_loop'] < 0 ? 'cat-porcelanico' : $GLOBALS['ac_posts'][ $GLOBALS['ac_post_idx'] ][1] ); }
	if ( '_ac_subtitle' === $k ) { return 'Gran formato, baja absorción y belleza que perdura: porcelanato tipo mármol, piedra y cemento para pisos y muros.'; }
	return '';
}
function get_term_meta() { return ''; }
function get_page_by_path( $p ) { return isset( $GLOBALS['ac_pages'][ $p ] ) ? (object) array( 'path' => $p ) : null; }
function get_permalink( $p = null ) { if ( is_object( $p ) ) { return 'inicio' === $p->path ? home_url( '/' ) : home_url( '/' . $p->path . '/' ); } return home_url( '/' ); }
function get_the_title( $p = null ) { if ( is_object( $p ) ) { return $GLOBALS['ac_pages'][ $p->path ]; } return 'page-es' === $GLOBALS['ac_view'] ? 'Porcelánicos' : $GLOBALS['ac_posts'][0][0]; }
function get_category_by_slug( $s ) { return (object) array( 'term_id' => 1, 'name' => 'Blog', 'slug' => $s ); }
function get_category_link() { return home_url( '/blog/' ); }
function get_post_ancestors() { return array(); }
function get_post_field() { return str_repeat( 'palabra ', 1400 ); }
function wp_strip_all_tags( $s ) { return strip_tags( $s ); }
function has_excerpt() { return true; }
function get_the_excerpt() { return $GLOBALS['ac_posts'][ $GLOBALS['ac_post_idx'] ][2]; }
function category_description() { return ''; }
function wp_get_attachment_image() { return ''; }
function wp_get_attachment_image_url() { return ''; }
function wp_nav_menu( $a ) { ac_fallback_menu( $a ); }
function get_header() { include $GLOBALS['THEME'] . '/header.php'; }
function get_footer() { include $GLOBALS['THEME'] . '/footer.php'; }
function get_template_part( $s ) { include $GLOBALS['THEME'] . '/' . $s . '.php'; }
function wp_head() {
	echo '<title>' . esc_html( wp_get_document_title() ) . "</title>\n";
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Manrope:wght@300;400;500;600;700&display=swap">' . "\n";
	echo '<link rel="stylesheet" href="../theme/acabados-contemporaneos/assets/css/main.css">' . "\n";
	ac_head_meta();
	ac_schema_output();
}
function wp_footer() { echo '<script src="../theme/acabados-contemporaneos/assets/js/main.js" defer></script>'; }
function post_class( $c = '' ) { echo 'class="' . esc_attr( $c ) . '"'; }
function the_permalink() { echo esc_url( home_url( '/blog/articulo/' ) ); }
function the_title() { echo esc_html( $GLOBALS['ac_posts'][ $GLOBALS['ac_post_idx'] ][0] ); }
function has_post_thumbnail() { return false; }
function get_the_ID() { return 1; }
function get_the_date( $f = '' ) { return 'c' === $f ? '2026-10-20T10:00:00-06:00' : '20 de octubre de 2026'; }
function get_the_modified_date( $f = '' ) { return get_the_date( $f ); }
function wp_reset_postdata() {}
function have_posts() { return $GLOBALS['ac_loop'] < 0; }
function the_post() { $GLOBALS['ac_loop'] = 0; }
function the_content() { echo $GLOBALS['ac_content']; }
function get_the_content() { return ''; }
function wp_get_post_categories() { return array( 1 ); }
function wp_nonce_field() {}
function get_search_query() { return ''; }
function wp_trim_words( $s, $n ) { return implode( ' ', array_slice( explode( ' ', $s ), 0, $n ) ) . '…'; }
function ac_shortcode_stub( $c ) { return preg_replace_callback( '/\[ac_img slug="([^"]+)"[^\]]*\]/', function ( $m ) { return ac_shortcode_img( array( 'slug' => $m[1] ) ); }, $c ); }
function shortcode_atts( $d, $a ) { return array_merge( $d, $a ); }
function get_the_post_thumbnail_url() { return ''; }

require $THEME . '/functions.php';

$GLOBALS['ac_content'] = '';
if ( 'page-es' === $view || 'post-es' === $view ) {
	$src = getenv( 'AC_PREVIEW_CONTENT' );
	$GLOBALS['ac_content'] = $src && file_exists( $src ) ? ac_shortcode_stub( preg_replace( '/<!--.*?-->/s', '', file_get_contents( $src ) ) ) : '<p>Contenido de ejemplo.</p>';
}

ob_start();
switch ( $view ) {
	case 'home-es':
		include $THEME . '/front-page.php';
		break;
	case 'home-en':
		include $THEME . '/page-templates/home.php';
		break;
	case 'page-es':
		include $THEME . '/page.php';
		break;
	case 'post-es':
		include $THEME . '/single.php';
		break;
	default:
		include $THEME . '/404.php';
}
$html = ob_get_clean();
echo $html;
