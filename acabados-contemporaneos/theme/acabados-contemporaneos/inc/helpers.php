<?php
/**
 * Utilidades del tema: imágenes, opciones, WhatsApp y shortcodes.
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

/**
 * ¿Estamos en una portada (ES o EN)?
 *
 * @return bool
 */
function ac_is_home_view() {
	if ( is_front_page() ) {
		return true;
	}
	return is_page() && 'page-templates/home.php' === get_page_template_slug( get_queried_object_id() );
}

/**
 * Catálogo de imágenes del tema (slug => texto alternativo ES/EN).
 *
 * @return array
 */
function ac_image_catalog() {
	return array(
		'hero-sala'                    => array( 'Sala contemporánea con piso porcelánico de gran formato tipo mármol Calacatta', 'Contemporary living room with large-format Calacatta marble-look porcelain floor' ),
		'hero-bano'                    => array( 'Baño estilo spa con recubrimiento porcelánico tipo travertino oscuro y tina exenta', 'Spa-style bathroom with dark travertine-look porcelain wall tiles and freestanding tub' ),
		'hero-cocina'                  => array( 'Cocina moderna con piso porcelánico tipo madera y backsplash de cerámica artesanal verde', 'Modern kitchen with wood-look porcelain floor and green handcrafted ceramic backsplash' ),
		'hero-terraza'                 => array( 'Terraza y alberca con piso porcelánico antiderrapante para exterior tipo piedra caliza', 'Terrace and pool with anti-slip limestone-look outdoor porcelain pavers' ),
		'hero-showroom'                => array( 'Showroom de recubrimientos con placas porcelánicas de gran formato en exhibición', 'Tile showroom displaying large-format porcelain slabs' ),
		'cat-ceramica'                 => array( 'Azulejo cerámico esmaltado en patrón espiga color salvia', 'Glazed sage ceramic wall tile in herringbone pattern' ),
		'cat-porcelanico'              => array( 'Pasillo con placas porcelánicas de gran formato tipo mármol gris en piso y muro', 'Hallway with grey marble-look large-format porcelain slabs on floor and wall' ),
		'cat-recubrimientos'           => array( 'Fachada con recubrimiento de muro 3D acanalado tipo piedra', 'Facade with fluted 3D stone-look wall cladding' ),
		'cat-accesorios'               => array( 'Accesorios de instalación: perfiles, niveladores, llana y muestras de boquilla', 'Installation accessories: trims, leveling clips, trowel and grout samples' ),
		'cat-mosaicos'                 => array( 'Muro de mosaico de vidrio verde esmeralda y oro en tocador de lujo', 'Emerald and gold glass mosaic feature wall in a luxury powder room' ),
		'cat-madera'                   => array( 'Lobby con porcelanato tipo madera nogal instalado en chevron', 'Lobby with walnut wood-look porcelain installed in chevron' ),
		'nosotros-asesoria'            => array( 'Asesora de Acabados Contemporáneos revisando muestras de porcelanato con un arquitecto', 'Acabados Contemporáneos advisor reviewing porcelain samples with an architect' ),
		'textura-marmol'               => array( 'Textura de porcelánico tipo mármol Nero Marquina con vetas doradas', 'Nero Marquina marble-look porcelain texture with gold veins' ),
		'blog-ceramica-vs-porcelanato' => array( 'Comparativa de piso cerámico y piso porcelánico en un mismo espacio', 'Ceramic vs porcelain floor comparison in the same room' ),
		'blog-tendencias'              => array( 'Tendencias en recubrimientos: tonos tierra y porcelanato tipo microcemento', 'Tile trends: earth tones and micro-cement-look porcelain' ),
		'blog-instalacion'             => array( 'Instalador colocando porcelanato con adhesivo y sistema de nivelación', 'Installer laying porcelain tile with adhesive and leveling system' ),
		'blog-gran-formato'            => array( 'Lobby de hotel con muro de porcelánico tipo ónix en gran formato', 'Hotel lobby with large-format onyx-look porcelain feature wall' ),
	);
}

/**
 * ID de adjunto de una imagen del catálogo (importada con el asistente).
 *
 * @param string $slug Slug de la imagen.
 * @return int
 */
function ac_image_id( $slug ) {
	$map = get_option( 'ac_image_map', array() );
	return isset( $map[ $slug ] ) ? (int) $map[ $slug ] : 0;
}

/**
 * URL de una imagen del catálogo.
 *
 * Orden: Biblioteca de medios (importador) → assets/img del tema → vacío.
 *
 * @param string $slug Slug.
 * @param string $size Tamaño registrado.
 * @return string
 */
function ac_img_url( $slug, $size = 'full' ) {
	$id = ac_image_id( $slug );
	if ( $id ) {
		$src = wp_get_attachment_image_url( $id, $size );
		if ( $src ) {
			return $src;
		}
	}
	if ( file_exists( AC_DIR . '/assets/img/' . $slug . '.webp' ) ) {
		return AC_URI . '/assets/img/' . $slug . '.webp';
	}
	/**
	 * URL alternativa (p. ej. un CDN) cuando la imagen no está en el sitio.
	 *
	 * @param string $url  URL vacía por defecto.
	 * @param string $slug Slug de la imagen.
	 * @param string $size Tamaño pedido.
	 */
	return apply_filters( 'ac_img_fallback_url', '', $slug, $size );
}

/**
 * Texto alternativo de una imagen del catálogo en el idioma actual.
 *
 * @param string $slug Slug.
 * @return string
 */
function ac_img_alt( $slug ) {
	$cat = ac_image_catalog();
	if ( ! isset( $cat[ $slug ] ) ) {
		return '';
	}
	return 'en' === ac_lang() ? $cat[ $slug ][1] : $cat[ $slug ][0];
}

/**
 * Etiqueta <img> responsiva de una imagen del catálogo.
 *
 * @param string $slug  Slug.
 * @param array  $args  size, class, loading, sizes, fetchpriority.
 * @return string HTML.
 */
function ac_img( $slug, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'size'          => 'large',
			'class'         => '',
			'loading'       => 'lazy',
			'sizes'         => '100vw',
			'fetchpriority' => '',
			'alt'           => ac_img_alt( $slug ),
		)
	);
	$id = ac_image_id( $slug );
	if ( $id ) {
		$attr = array(
			'class'   => $args['class'],
			'loading' => $args['loading'],
			'sizes'   => $args['sizes'],
			'alt'     => $args['alt'],
		);
		if ( $args['fetchpriority'] ) {
			$attr['fetchpriority'] = $args['fetchpriority'];
		}
		return wp_get_attachment_image( $id, $args['size'], false, $attr );
	}
	$src = ac_img_url( $slug );
	if ( ! $src ) {
		return '<span class="ac-img-placeholder ' . esc_attr( $args['class'] ) . '" role="img" aria-label="' . esc_attr( $args['alt'] ) . '"></span>';
	}
	return sprintf(
		'<img src="%1$s" alt="%2$s" class="%3$s" loading="%4$s" decoding="async"%5$s>',
		esc_url( $src ),
		esc_attr( $args['alt'] ),
		esc_attr( $args['class'] ),
		esc_attr( $args['loading'] ),
		$args['fetchpriority'] ? ' fetchpriority="' . esc_attr( $args['fetchpriority'] ) . '"' : ''
	);
}

/**
 * Opción del personalizador con valor por defecto.
 *
 * @param string $key     Clave sin prefijo.
 * @param string $default Valor por defecto.
 * @return string
 */
function ac_opt( $key, $default = '' ) {
	$value = get_theme_mod( 'ac_' . $key, $default );
	return is_string( $value ) ? trim( $value ) : $value;
}

/**
 * Enlace de WhatsApp con mensaje predefinido, o vacío si no hay número.
 *
 * @return string
 */
function ac_whatsapp_url() {
	$number = preg_replace( '/\D+/', '', ac_opt( 'whatsapp' ) );
	if ( ! $number ) {
		return '';
	}
	return 'https://wa.me/' . $number . '?text=' . rawurlencode( ac_t( 'whatsapp_msg' ) );
}

/**
 * URL de la página de contacto / cotización en el idioma actual.
 *
 * @return string
 */
function ac_contact_url() {
	return ac_page_url( 'contacto', 'en/contact' );
}

/**
 * Minutos de lectura estimados.
 *
 * @param int|null $post_id Entrada.
 * @return int
 */
function ac_reading_time( $post_id = null ) {
	$words = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
	return max( 1, (int) ceil( $words / 220 ) );
}

/**
 * Icono SVG en línea.
 *
 * @param string $name Nombre.
 * @return string
 */
function ac_icon( $name ) {
	$icons = array(
		'arrow'     => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'arrow-l'   => '<path d="M19 12H5M11 6l-6 6 6 6"/>',
		'phone'     => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/>',
		'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'pin'       => '<path d="M12 22s7-6.2 7-12a7 7 0 1 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/>',
		'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'search'    => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'spark'     => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M5.6 18.4l2.8-2.8M15.6 8.4l2.8-2.8"/>',
		'layers'    => '<path d="m12 3 9 5-9 5-9-5 9-5z"/><path d="m3 13 9 5 9-5"/>',
		'tag'       => '<path d="M20.6 13.4 13.4 20.6a2 2 0 0 1-2.8 0L3 13V3h10l7.6 7.6a2 2 0 0 1 0 2.8z"/><circle cx="7.5" cy="7.5" r="1.5"/>',
		'box'       => '<path d="M21 8 12 3 3 8v8l9 5 9-5V8z"/><path d="m3 8 9 5 9-5M12 13v8"/>',
		'whatsapp'  => '<path d="M20.5 3.5A11.8 11.8 0 0 0 1.9 17.8L.3 23.7l6-1.6A11.8 11.8 0 0 0 20.5 3.5zM12 21.6a9.7 9.7 0 0 1-5-1.4l-.4-.2-3.6.9 1-3.5-.2-.4A9.7 9.7 0 1 1 12 21.6zm5.3-7.3c-.3-.1-1.7-.9-2-1s-.5-.1-.7.2-.8 1-.9 1.1-.4.2-.6.1a8 8 0 0 1-4-3.5c-.3-.5.3-.5.9-1.6.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6a1.1 1.1 0 0 0-.8.4 3.4 3.4 0 0 0-1.1 2.5 5.9 5.9 0 0 0 1.2 3.1 13.5 13.5 0 0 0 5.2 4.6c1.9.8 2.7.9 3.6.7a3.1 3.1 0 0 0 2-1.4 2.5 2.5 0 0 0 .2-1.4c-.1-.1-.3-.2-.6-.3z" fill="currentColor" stroke="none"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>',
		'facebook'  => '<path d="M15 3h-2.5A4.5 4.5 0 0 0 8 7.5V10H5v4h3v7h4v-7h3l1-4h-4V7.5c0-.3.2-.5.5-.5H15z"/>',
		'pinterest' => '<circle cx="12" cy="12" r="9"/><path d="M10.5 8.5c3-1.5 6 0 5.5 3s-3 3.5-4 2.5m.5-4L10 20"/>',
		'linkedin'  => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 10v7M8 7v.01M12 17v-4a2 2 0 0 1 4 0v4M12 10v7"/>',
		'youtube'   => '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="m10 9 5 3-5 3z" fill="currentColor"/>',
		'tiktok'    => '<path d="M14 3v11.5a3.5 3.5 0 1 1-3-3.5M14 3c.5 2.5 2.3 4 5 4"/>',
	);
	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}
	return '<svg class="ac-icon ac-icon--' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $name ] . '</svg>';
}

/**
 * [ac_img slug="cat-ceramica" class="" caption=""]
 */
function ac_shortcode_img( $atts ) {
	$atts = shortcode_atts(
		array(
			'slug'    => '',
			'class'   => '',
			'caption' => '',
		),
		$atts,
		'ac_img'
	);
	if ( ! $atts['slug'] ) {
		return '';
	}
	$html = ac_img( sanitize_key( $atts['slug'] ), array( 'size' => 'large', 'sizes' => '(min-width: 1100px) 1100px, 100vw' ) );
	$out  = '<figure class="ac-figure ' . esc_attr( $atts['class'] ) . '" data-reveal>' . $html;
	if ( $atts['caption'] ) {
		$out .= '<figcaption>' . esc_html( $atts['caption'] ) . '</figcaption>';
	}
	return $out . '</figure>';
}
add_shortcode( 'ac_img', 'ac_shortcode_img' );

/**
 * [ac_cta] — bloque de llamada a la acción en el idioma actual.
 */
function ac_shortcode_cta() {
	ob_start();
	get_template_part( 'template-parts/cta' );
	return ob_get_clean();
}
add_shortcode( 'ac_cta', 'ac_shortcode_cta' );
