<?php
/**
 * Renderiza UNA página o entrada del sitio a HTML estático usando las
 * plantillas reales del tema y un stub mínimo de WordPress.
 *
 * Lo invoca tools/build_static.py (un proceso por página, porque el tema
 * guarda el idioma en una variable estática).
 *
 * Uso: php render-page.php <index.json> <ruta|__404__>
 */

define( 'ABSPATH', __DIR__ . '/' );
define( 'OBJECT', 'OBJECT' );
$THEME = realpath( __DIR__ . '/../../theme/acabados-contemporaneos' );

$GLOBALS['IDX']   = json_decode( file_get_contents( $argv[1] ), true );
$GLOBALS['BY_ID'] = array();
$GLOBALS['BY_PATH'] = array();
foreach ( $GLOBALS['IDX'] as $it ) {
	$GLOBALS['BY_ID'][ $it['id'] ]     = $it;
	$GLOBALS['BY_PATH'][ $it['path'] ] = $it;
}
$target          = $argv[2];
$GLOBALS['CUR']  = '__404__' === $target ? null : $GLOBALS['BY_PATH'][ $target ];
$GLOBALS['LOOP'] = null;   // Entrada del bucle secundario (WP_Query) en curso.
$GLOBALS['MAIN_DONE'] = false;
$GLOBALS['wp'] = (object) array( 'request' => '' );

/* ---------------- Utilidades del stub ---------------- */
function ac_s_item( $x = null ) {
	if ( is_object( $x ) ) {
		return $GLOBALS['BY_ID'][ $x->ID ];
	}
	if ( is_numeric( $x ) && isset( $GLOBALS['BY_ID'][ (int) $x ] ) ) {
		return $GLOBALS['BY_ID'][ (int) $x ];
	}
	return $GLOBALS['LOOP'] ? $GLOBALS['LOOP'] : $GLOBALS['CUR'];
}
function ac_s_url( $it ) {
	if ( 'inicio' === $it['path'] ) {
		return '/';
	}
	return '/' . $it['path'] . '/';
}
function ac_s_lang() {
	return $GLOBALS['CUR'] ? $GLOBALS['CUR']['lang'] : 'es';
}

/* ---------------- Stub WordPress ---------------- */
class WP_Query {
	public $posts = array();
	public $i = -1;
	public $max_num_pages = 1;
	function __construct( $a = array() ) {
		$lang    = ac_s_lang();
		$exclude = isset( $a['post__not_in'] ) ? $a['post__not_in'] : array();
		foreach ( $GLOBALS['IDX'] as $it ) {
			if ( 'post' === $it['type'] && $it['lang'] === $lang && ! in_array( $it['id'], $exclude, true ) ) {
				$this->posts[] = $it;
			}
		}
		usort( $this->posts, function ( $x, $y ) { return strcmp( $y['date'], $x['date'] ); } );
		$n = isset( $a['posts_per_page'] ) ? (int) $a['posts_per_page'] : 10;
		$this->posts = array_slice( $this->posts, 0, $n );
	}
	function have_posts() {
		$more = $this->i + 1 < count( $this->posts );
		if ( ! $more ) {
			$GLOBALS['LOOP'] = null;
		}
		return $more;
	}
	function the_post() {
		$this->i++;
		$GLOBALS['LOOP'] = $this->posts[ $this->i ];
	}
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
function get_template_directory_uri() { return ''; }
function apply_filters( $tag, $v ) {
	if ( 'ac_img_fallback_url' === $tag ) {
		$a = func_get_args();
		return '/img/' . $a[2] . '.webp';
	}
	return $v;
}
function add_query_arg( $a, $u = '' ) { return $u; }
function trailingslashit( $s ) { return rtrim( $s, '/' ) . '/'; }
function home_url( $p = '/' ) { return $p; }
function admin_url( $p = '' ) { return '#'; }
function get_option( $k, $d = false ) { return 'ac_image_map' === $k ? array() : $d; }
function get_theme_mod( $k, $d = '' ) { return $d; }
function wp_parse_args( $a, $d ) { return array_merge( $d, $a ); }
function sanitize_key( $s ) { return strtolower( preg_replace( '/[^a-z0-9_\-]/i', '', $s ) ); }
function sanitize_text_field( $s ) { return trim( $s ); }
function wp_unslash( $s ) { return $s; }
function antispambot( $s ) { return $s; }
function wp_json_encode( $d, $f = 0 ) { return json_encode( $d, $f ); }
function get_bloginfo( $k = '' ) { return 'Acabados Contemporáneos'; }
function bloginfo( $k ) { echo 'charset' === $k ? 'UTF-8' : 'Acabados Contemporáneos'; }
function wp_get_document_title() {
	$c = $GLOBALS['CUR'];
	if ( ! $c ) {
		return '404 | Acabados Contemporáneos';
	}
	return $c['seo_title'] ? $c['seo_title'] : $c['title'] . ' | Acabados Contemporáneos';
}
function language_attributes() { echo ac_language_attributes( '' ); }
function body_class() { echo 'class="' . esc_attr( implode( ' ', ac_body_classes( array( 'static' ) ) ) ) . '"'; }
function wp_body_open() {}
function has_custom_logo() { return false; }
function is_front_page() { return $GLOBALS['CUR'] && 'inicio' === $GLOBALS['CUR']['path']; }
function is_home() { return false; }
function is_page() { return $GLOBALS['CUR'] && 'page' === $GLOBALS['CUR']['type']; }
function is_singular( $t = null ) {
	$c = $GLOBALS['CUR'];
	if ( ! $c ) {
		return false;
	}
	return null === $t || ( is_array( $t ) ? in_array( $c['type'], $t, true ) : $c['type'] === $t );
}
function is_category() { return false; } function is_search() { return false; } function is_archive() { return false; }
function is_404() { return null === $GLOBALS['CUR']; }
function is_user_logged_in() { return false; } function current_user_can() { return false; } function wp_doing_ajax() { return false; }
function get_queried_object_id() { return $GLOBALS['CUR'] ? $GLOBALS['CUR']['id'] : 0; }
function get_queried_object() { return null; }
function get_page_template_slug( $id = 0 ) { $it = ac_s_item( $id ); return $it ? $it['template'] : ''; }
function get_post_meta( $id, $k, $s = false ) {
	$it = isset( $GLOBALS['BY_ID'][ $id ] ) ? $GLOBALS['BY_ID'][ $id ] : null;
	if ( ! $it ) {
		return '';
	}
	return isset( $it['meta'][ $k ] ) ? $it['meta'][ $k ] : '';
}
function get_term_meta() { return ''; }
function get_page_by_path( $p ) { return isset( $GLOBALS['BY_PATH'][ $p ] ) ? (object) array( 'ID' => $GLOBALS['BY_PATH'][ $p ]['id'] ) : null; }
function get_permalink( $p = null ) { $it = ac_s_item( $p ); return $it ? ac_s_url( $it ) : '/'; }
function get_the_title( $p = null ) { $it = ac_s_item( $p ); return $it ? $it['title'] : ''; }
function get_category_by_slug( $s ) { return (object) array( 'term_id' => 1, 'name' => 'blog-en' === $s ? 'Blog (EN)' : 'Blog', 'slug' => $s ); }
function get_category_link( $c ) { return is_object( $c ) && 'blog-en' === $c->slug ? '/en/blog/' : '/blog/'; }
function get_post_ancestors( $id ) {
	$out = array();
	$it  = $GLOBALS['BY_ID'][ $id ];
	while ( $it['parent_id'] ) {
		$out[] = $it['parent_id'];
		$it    = $GLOBALS['BY_ID'][ $it['parent_id'] ];
	}
	return $out;
}
function get_post_field( $f, $id = null ) {
	$it = ac_s_item( $id );
	if ( 'post_name' === $f ) {
		return $it['slug'];
	}
	return $it['body'];
}
function wp_strip_all_tags( $s ) { return trim( strip_tags( $s ) ); }
function has_excerpt( $id = null ) { $it = ac_s_item( $id ); return ! empty( $it['excerpt'] ); }
function get_the_excerpt( $id = null ) { $it = ac_s_item( $id ); return $it['excerpt']; }
function category_description() { return ''; }
function wp_get_attachment_image() { return ''; }
function wp_get_attachment_image_url() { return ''; }
function wp_nav_menu( $a ) { ac_fallback_menu( $a ); }
function get_header() { include $GLOBALS['THEME'] . '/header.php'; }
function get_footer() { include $GLOBALS['THEME'] . '/footer.php'; }
function get_template_part( $s ) { include $GLOBALS['THEME'] . '/' . $s . '.php'; }
function wp_head() {
	echo '<title>' . esc_html( wp_get_document_title() ) . "</title>\n";
	echo '<link rel="icon" href="/favicon.svg" type="image/svg+xml">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Manrope:wght@300;400;500;600;700&display=swap">' . "\n";
	echo '<link rel="stylesheet" href="/assets/css/main.css">' . "\n";
	ac_head_meta();
	ac_schema_output();
}
function wp_footer() {
	echo '<script src="/assets/js/main.js" defer></script>' . "\n";
	// Versión estática: el formulario se activa al instalar el tema en WordPress.
	echo '<script>document.addEventListener("submit",function(e){var f=e.target;if(!f.classList.contains("ac-form"))return;e.preventDefault();var p=document.createElement("p");p.className="ac-form__notice is-ok";p.textContent=document.documentElement.lang.indexOf("en")===0?"Demo version: the quote form is activated once the theme is installed in WordPress.":"Versión demo: el formulario de cotización se activa al instalar el tema en WordPress.";f.prepend(p);});</script>' . "\n";
}
function post_class( $c = '' ) { echo 'class="' . esc_attr( $c ) . '"'; }
function the_permalink() { echo esc_url( get_permalink() ); }
function the_title() { echo esc_html( get_the_title() ); }
function has_post_thumbnail() { return false; }
function get_the_ID() { $it = ac_s_item(); return $it ? $it['id'] : 0; }
function get_the_date( $f = '', $id = null ) {
	$it = ac_s_item( $id );
	$ts = strtotime( $it['date'] );
	if ( 'c' === $f ) {
		return date( 'Y-m-d\TH:i:s', $ts ) . '-06:00';
	}
	$m = 'en' === $it['lang']
		? array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' )
		: array( 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' );
	$month = $m[ (int) date( 'n', $ts ) - 1 ];
	return 'en' === $it['lang'] ? $month . ' ' . date( 'j, Y', $ts ) : date( 'j', $ts ) . ' de ' . $month . ' de ' . date( 'Y', $ts );
}
function get_the_modified_date( $f = '', $id = null ) { return get_the_date( $f, $id ); }
function wp_reset_postdata() { $GLOBALS['LOOP'] = null; }
function have_posts() { return ! $GLOBALS['MAIN_DONE']; }
function the_post() { $GLOBALS['MAIN_DONE'] = true; }
function the_content() { echo ac_s_shortcodes( $GLOBALS['CUR']['body'] ); }
function get_the_content() { return trim( strip_tags( $GLOBALS['CUR']['body'] ) ); }
function wp_get_post_categories() { return array( 1 ); }
function wp_nonce_field() {}
function get_search_query() { return ''; }
function get_search_form() {}
function paginate_links() { return ""; }
function get_query_var() { return 0; }
function wp_trim_words( $s, $n ) { $w = explode( ' ', $s ); return count( $w ) > $n ? implode( ' ', array_slice( $w, 0, $n ) ) . '…' : $s; }
function shortcode_atts( $d, $a ) { return array_merge( $d, array_intersect_key( (array) $a, $d ) ); }
function get_the_post_thumbnail_url() { return ''; }
function get_the_archive_title() { return ''; }
function the_archive_description() {}

/** Shortcodes del tema dentro del contenido. */
function ac_s_shortcodes( $html ) {
	return preg_replace_callback(
		'/\[(ac_img|ac_contacto|ac_cta)([^\]]*)\]/',
		function ( $m ) {
			preg_match_all( '/(\w+)="([^"]*)"/', $m[2], $pairs, PREG_SET_ORDER );
			$atts = array();
			foreach ( $pairs as $p ) {
				$atts[ $p[1] ] = $p[2];
			}
			if ( 'ac_img' === $m[1] ) {
				return ac_shortcode_img( $atts );
			}
			if ( 'ac_contacto' === $m[1] ) {
				return ac_contact_form();
			}
			return ac_shortcode_cta();
		},
		$html
	);
}

require $THEME . '/functions.php';

ob_start();
$c = $GLOBALS['CUR'];
if ( ! $c ) {
	include $THEME . '/404.php';
} elseif ( 'inicio' === $c['path'] ) {
	include $THEME . '/front-page.php';
} elseif ( 'post' === $c['type'] ) {
	include $THEME . '/single.php';
} elseif ( $c['template'] && 'default' !== $c['template'] ) {
	include $THEME . '/' . $c['template'];
} else {
	include $THEME . '/page.php';
}
echo ob_get_clean();
