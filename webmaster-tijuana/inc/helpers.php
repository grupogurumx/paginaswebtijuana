<?php
/**
 * Funciones auxiliares de plantilla.
 *
 * @package WebmasterTijuana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Valores por defecto de los datos del negocio (editables en el Personalizador).
 */
function wmt_defaults() {
	return array(
		'telefono'      => '664 409 7979',
		'whatsapp'      => '526644097979',
		'email'         => 'contacto@webmastertijuana.com',
		'direccion'     => 'Tijuana, Baja California, México',
		'horario'       => 'Lunes a viernes de 9:00 a 18:00 h',
		'facebook'      => '',
		'instagram'     => '',
		'linkedin'      => '',
		'tiktok'        => '',
		'youtube'       => '',
		'form_destino'  => 'contacto@webmastertijuana.com',
		'cta_titulo'    => 'Impulsa tu negocio hoy mismo',
		'cta_texto'     => 'Cuéntanos de tu proyecto y te enviamos una cotización gratuita. Estamos listos para llevar tu presencia digital al siguiente nivel.',
		'footer_texto'  => 'Especialistas en páginas web, posicionamiento SEO y tiendas virtuales. Llevamos tu negocio al siguiente nivel.',
	);
}

/**
 * Lee una opción del tema con su valor por defecto.
 */
function wmt_opt( $key ) {
	$defaults = wmt_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'wmt_' . $key, $default );
}

function wmt_tel_href() {
	return 'tel:+52' . preg_replace( '/\D+/', '', wmt_opt( 'telefono' ) );
}

function wmt_whatsapp_url( $mensaje = '' ) {
	$numero = preg_replace( '/\D+/', '', wmt_opt( 'whatsapp' ) );
	if ( ! $numero ) {
		return '';
	}
	if ( '' === $mensaje ) {
		$mensaje = __( 'Hola, me interesa una cotización para mi proyecto.', 'webmaster-tijuana' );
	}
	return 'https://wa.me/' . $numero . '?text=' . rawurlencode( $mensaje );
}

/**
 * Redes sociales con URL configurada.
 */
function wmt_socials() {
	$redes = array(
		'facebook'  => 'Facebook',
		'instagram' => 'Instagram',
		'linkedin'  => 'LinkedIn',
		'tiktok'    => 'TikTok',
		'youtube'   => 'YouTube',
	);
	$out = array();
	foreach ( $redes as $key => $label ) {
		$url = wmt_opt( $key );
		if ( $url ) {
			$out[ $key ] = array( 'label' => $label, 'url' => $url );
		}
	}
	return $out;
}

/**
 * Slides del inicio. Texto e imagen de cada uno se editan en el Personalizador.
 */
function wmt_slide_defaults() {
	return array(
		1 => array(
			'titulo' => 'Diseño y desarrollo web responsive',
			'texto'  => 'Sitios web rápidos, modernos y pensados para convertir visitantes en clientes, en cualquier dispositivo.',
			'tags'   => 'Sitio web responsivo, Tiendas virtuales, Sitios de lanzamiento',
			'imagen' => 'slide-diseno-web.jpg',
			'enlace' => 'diseno-de-paginas-web',
		),
		2 => array(
			'titulo' => 'Diseño gráfico que comunica',
			'texto'  => 'Identidad corporativa y piezas publicitarias modernas, atractivas y a la medida de tus necesidades.',
			'tags'   => 'Identidad corporativa, Diseño publicitario, Diseño a tu criterio',
			'imagen' => 'slide-diseno-grafico.jpg',
			'enlace' => 'estrategias-de-publicidad',
		),
		3 => array(
			'titulo' => 'Manejo de redes sociales',
			'texto'  => 'Creamos comunidad alrededor de tu marca con contenido constante y una estrategia clara en cada red.',
			'tags'   => 'Facebook, Instagram, TikTok, LinkedIn, YouTube, X',
			'imagen' => 'slide-redes-sociales.jpg',
			'enlace' => 'manejo-de-redes-sociales',
		),
		4 => array(
			'titulo' => 'SEO y pago por clic',
			'texto'  => 'Hacemos que te encuentren: más visitas cualificadas con posicionamiento orgánico y campañas en Google Ads y Bing Ads.',
			'tags'   => 'Estrategia SEO, Linkbuilding, Google Ads, Tráfico orgánico y pagado',
			'imagen' => 'slide-seo-ppc.jpg',
			'enlace' => 'publicidad-digital',
		),
	);
}

function wmt_slides() {
	$slides = array();
	foreach ( wmt_slide_defaults() as $i => $d ) {
		$imagen_id = absint( get_theme_mod( "wmt_slide{$i}_imagen", 0 ) );
		$imagen    = $imagen_id ? wp_get_attachment_image_url( $imagen_id, 'wmt-wide' ) : '';

		$servicio = get_page_by_path( $d['enlace'], OBJECT, 'servicio' );
		$slides[] = array(
			'titulo' => get_theme_mod( "wmt_slide{$i}_titulo", $d['titulo'] ),
			'texto'  => get_theme_mod( "wmt_slide{$i}_texto", $d['texto'] ),
			'tags'   => array_filter( array_map( 'trim', explode( ',', get_theme_mod( "wmt_slide{$i}_tags", $d['tags'] ) ) ) ),
			'imagen' => $imagen ? $imagen : WMT_URI . '/assets/img/' . $d['imagen'],
			'enlace' => $servicio ? get_permalink( $servicio ) : get_post_type_archive_link( 'servicio' ),
		);
	}
	return array_values( array_filter( $slides, function ( $s ) { return '' !== trim( $s['titulo'] ); } ) );
}

/**
 * Logo: el personalizado si existe; si no, el del tema.
 *
 * @param string $variante 'color' o 'blanco'.
 */
function wmt_logo( $variante = 'color' ) {
	$nombre = get_bloginfo( 'name' );
	if ( 'color' === $variante && has_custom_logo() ) {
		$id = get_theme_mod( 'custom_logo' );
		echo wp_get_attachment_image( $id, 'full', false, array( 'class' => 'logo__img', 'alt' => $nombre ) );
		return;
	}
	$archivo = 'blanco' === $variante ? 'logo-blanco.png' : 'logo.png';
	printf(
		'<img class="logo__img" src="%s" alt="%s" width="640" height="207">',
		esc_url( WMT_URI . '/assets/img/' . $archivo ),
		esc_attr( $nombre )
	);
}

/**
 * URL de una página por su slug, con respaldo.
 */
function wmt_page_url( $slug, $fallback = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}
	return $fallback ? $fallback : home_url( '/' . $slug . '/' );
}

function wmt_cotizar_url() {
	return wmt_page_url( 'cotizar', home_url( '/#cotizar' ) );
}

/**
 * Iconos SVG en línea (trazos de 24 × 24).
 */
function wmt_icon( $name, $class = '' ) {
	$paths = array(
		'code'      => '<path d="m16 18 6-6-6-6"/><path d="m8 6-6 6 6 6"/>',
		'monitor'   => '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>',
		'chart'     => '<path d="M21 12A9 9 0 1 1 12 3v9z"/><path d="M21 12a9 9 0 0 0-9-9"/>',
		'megaphone' => '<path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
		'cart'      => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2 2h3l2.7 12.4a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L22 7H6"/>',
		'bulb'      => '<path d="M9 18h6M10 22h4"/><path d="M15.1 14c.2-1 .7-1.7 1.4-2.5A6 6 0 1 0 6 8c0 1.3.3 2.3 1.5 3.5.7.7 1.2 1.5 1.4 2.5"/>',
		'share'     => '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.6 13.5 6.8 4M15.4 6.5l-6.8 4"/>',
		'target'    => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
		'trending'  => '<path d="m22 7-8.5 8.5-5-5L2 17"/><path d="M16 7h6v6"/>',
		'users'     => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>',
		'search'    => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
		'pen'       => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
		'rocket'    => '<path d="M4.5 16.5c-1.5 1.3-2 5-2 5s3.7-.5 5-2c.7-.8.7-2.1-.1-2.9a2.2 2.2 0 0 0-2.9-.1z"/><path d="m12 15-3-3a22 22 0 0 1 2-4A13 13 0 0 1 22 2c0 2.7-.8 7.5-6 11a22 22 0 0 1-4 2z"/><path d="M9 12H4s.6-3 2-4c1.6-1.1 5 0 5 0M12 15v5s3-.6 4-2c1.1-1.6 0-5 0-5"/>',
		'phone'     => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>',
		'mail'      => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>',
		'pin'       => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
		'clock'     => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'arrow'     => '<path d="M5 12h14M12 5l7 7-7 7"/>',
		'check'     => '<path d="M20 6 9 17l-5-5"/>',
		'menu'      => '<path d="M4 6h16M4 12h16M4 18h16"/>',
		'close'     => '<path d="M18 6 6 18M6 6l12 12"/>',
		'prev'      => '<path d="m15 18-6-6 6-6"/>',
		'next'      => '<path d="m9 18 6-6-6-6"/>',
		'send'      => '<path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/>',
		'quote'     => '<path d="M3 21c3 0 7-1 7-8V5c0-1.3-.8-2-2-2H4c-1.3 0-2 .7-2 2v6c0 1.3.7 2 2 2h3c0 3-1 5-4 5zM15 21c3 0 7-1 7-8V5c0-1.3-.8-2-2-2h-4c-1.3 0-2 .7-2 2v6c0 1.3.7 2 2 2h3c0 3-1 5-4 5z"/>',
	);

	$fill = array(
		'star'      => '<path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/>',
		'whatsapp'  => '<path d="M17.5 14.4c-.3-.1-1.8-.9-2-1s-.5-.1-.7.1-.8 1-1 1.2-.4.2-.7.1a8.2 8.2 0 0 1-4-3.5c-.3-.5.3-.5.9-1.6.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6a1.2 1.2 0 0 0-.8.4 3.5 3.5 0 0 0-1.1 2.6 6 6 0 0 0 1.3 3.2 13.8 13.8 0 0 0 5.3 4.7c2 .8 2.7.9 3.7.8a3.1 3.1 0 0 0 2-1.4 2.5 2.5 0 0 0 .2-1.4c-.1-.2-.3-.3-.6-.4zM12 21.8a9.8 9.8 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4A9.8 9.8 0 1 1 12 21.8zm8.4-18.2A11.8 11.8 0 0 0 1.8 17.9L.1 24l6.3-1.6A11.8 11.8 0 0 0 23.8 12a11.7 11.7 0 0 0-3.4-8.4z"/>',
		'facebook'  => '<path d="M14 8V6c0-.9.6-1 1-1h3V1h-4c-4 0-5 3-5 5v2H6v4h3v11h5V12h3.5l.5-4z"/>',
		'instagram' => '<path d="M12 2.2c3.2 0 3.6 0 4.8.1 3.3.1 4.8 1.7 4.9 4.9.1 1.3.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 3.2-1.7 4.8-4.9 4.9-1.3.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-3.3-.1-4.8-1.7-4.9-4.9C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8C2.4 3.9 3.9 2.4 7.2 2.3 8.4 2.2 8.8 2.2 12 2.2zM12 0C8.7 0 8.3 0 7.1.1 2.7.3.3 2.7.1 7.1 0 8.3 0 8.7 0 12s0 3.7.1 4.9c.2 4.4 2.6 6.8 7 7 1.2.1 1.6.1 4.9.1s3.7 0 4.9-.1c4.4-.2 6.8-2.6 7-7 .1-1.2.1-1.6.1-4.9s0-3.7-.1-4.9c-.2-4.4-2.6-6.8-7-7C15.7 0 15.3 0 12 0zm0 5.8a6.2 6.2 0 1 0 0 12.4 6.2 6.2 0 0 0 0-12.4zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.4-11.8a1.4 1.4 0 1 0 0 2.9 1.4 1.4 0 0 0 0-2.9z"/>',
		'linkedin'  => '<path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9.5h4V21H3zM9.5 9.5h3.8v1.6h.1c.5-1 1.8-2 3.8-2 4 0 4.8 2.6 4.8 6V21h-4v-5.2c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7V21h-4z"/>',
		'tiktok'    => '<path d="M19.6 6.7a4.8 4.8 0 0 1-3.8-4.2V2h-3.4v13.7a2.9 2.9 0 0 1-5.2 1.7 2.9 2.9 0 0 1 3.2-4.5V9.4a6.3 6.3 0 0 0-5.4 10.7 6.3 6.3 0 0 0 10.8-4.4V8.7a8.2 8.2 0 0 0 4.8 1.5V6.8a4.9 4.9 0 0 1-1-.1z"/>',
		'youtube'   => '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8zM9.6 15.6V8.4l6.3 3.6z"/>',
	);

	$class = trim( 'icon icon--' . $name . ' ' . $class );

	if ( isset( $fill[ $name ] ) ) {
		return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">' . $fill[ $name ] . '</svg>';
	}
	if ( ! isset( $paths[ $name ] ) ) {
		$name = 'check';
	}
	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}

/**
 * Iconos disponibles para los servicios (selector del editor).
 */
function wmt_service_icons() {
	return array(
		'monitor'   => 'Monitor',
		'code'      => 'Código',
		'chart'     => 'Gráfica',
		'megaphone' => 'Megáfono',
		'cart'      => 'Carrito',
		'bulb'      => 'Idea',
		'share'     => 'Redes',
		'search'    => 'Búsqueda',
		'pen'       => 'Diseño',
		'rocket'    => 'Cohete',
		'target'    => 'Objetivo',
		'trending'  => 'Crecimiento',
	);
}

/**
 * Cabecera de página interior.
 */
function wmt_page_hero( $titulo, $subtitulo = '', $eyebrow = '' ) {
	?>
	<section class="page-hero">
		<div class="container">
			<?php wmt_breadcrumbs(); ?>
			<?php if ( $eyebrow ) : ?>
				<p class="eyebrow eyebrow--light"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<h1 class="page-hero__title"><?php echo esc_html( $titulo ); ?></h1>
			<?php if ( $subtitulo ) : ?>
				<p class="page-hero__lead"><?php echo esc_html( $subtitulo ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Migas de pan sencillas.
 */
function wmt_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	$items = array( array( __( 'Inicio', 'webmaster-tijuana' ), home_url( '/' ) ) );

	if ( is_singular( 'servicio' ) ) {
		$items[] = array( __( 'Servicios', 'webmaster-tijuana' ), get_post_type_archive_link( 'servicio' ) );
	} elseif ( is_singular( 'proyecto' ) ) {
		$items[] = array( __( 'Portafolio', 'webmaster-tijuana' ), get_post_type_archive_link( 'proyecto' ) );
	} elseif ( is_singular( 'post' ) && get_option( 'page_for_posts' ) ) {
		$items[] = array( get_the_title( get_option( 'page_for_posts' ) ), get_permalink( get_option( 'page_for_posts' ) ) );
	}

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Migas de pan', 'webmaster-tijuana' ) . '"><ol>';
	foreach ( $items as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item[1] ), esc_html( $item[0] ) );
	}
	echo '<li aria-current="page">' . esc_html( wp_strip_all_tags( wmt_current_title() ) ) . '</li>';
	echo '</ol></nav>';
}

function wmt_current_title() {
	if ( is_home() ) {
		return get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'Blog', 'webmaster-tijuana' );
	}
	if ( is_search() ) {
		return __( 'Búsqueda', 'webmaster-tijuana' );
	}
	if ( is_404() ) {
		return __( 'Página no encontrada', 'webmaster-tijuana' );
	}
	if ( is_archive() ) {
		return get_the_archive_title();
	}
	return get_the_title();
}

/**
 * Iniciales para el avatar de un testimonio.
 */
function wmt_initials( $nombre ) {
	$partes = preg_split( '/\s+/', trim( wp_strip_all_tags( $nombre ) ) );
	$ini    = '';
	foreach ( array_slice( $partes, 0, 2 ) as $p ) {
		$ini .= mb_strtoupper( mb_substr( $p, 0, 1 ) );
	}
	return $ini;
}

/**
 * Menú de respaldo mientras no se asigne uno.
 */
function wmt_menu_fallback( $args ) {
	$items = array(
		array( __( 'Inicio', 'webmaster-tijuana' ), home_url( '/' ) ),
		array( __( 'Servicios', 'webmaster-tijuana' ), get_post_type_archive_link( 'servicio' ) ),
		array( __( 'Portafolio', 'webmaster-tijuana' ), get_post_type_archive_link( 'proyecto' ) ),
		array( __( 'Nosotros', 'webmaster-tijuana' ), wmt_page_url( 'nosotros' ) ),
		array( __( 'Contacto', 'webmaster-tijuana' ), wmt_page_url( 'contacto' ) ),
	);
	echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
	foreach ( $items as $item ) {
		printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $item[1] ), esc_html( $item[0] ) );
	}
	echo '</ul>';
}
