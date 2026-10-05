<?php
/**
 * Utilidades: opciones del negocio, WhatsApp, imágenes e íconos.
 *
 * @package PeanutBakery
 */

defined( 'ABSPATH' ) || exit;

/**
 * Valores por defecto de los datos del negocio (editables en Apariencia → Personalizar → Peanut Bakery).
 */
function pb_defaults() {
	return array(
		'phone'        => '661 114 7744',
		'whatsapp'     => '526611147744',
		'email'        => 'ventas@peanutbakery.com',
		'street'       => '',
		'city'         => 'Playas de Rosarito',
		'region'       => 'Baja California',
		'postal'       => '22710',
		'hours'        => 'Lunes a domingo · 7:00 a 21:00',
		'hours_schema' => 'Mo-Su 07:00-21:00',
		'lat'          => '32.3661',
		'lng'          => '-117.0618',
		'maps_embed'   => 'https://www.google.com/maps?q=Peanut+Bakery+Playas+de+Rosarito&output=embed',
		'maps_link'    => 'https://www.google.com/maps/search/?api=1&query=Peanut+Bakery+Playas+de+Rosarito',
		'instagram'    => '',
		'facebook'     => '',
		'tiktok'       => '',
		'youtube'      => '',
		'hero_video'   => '',
		'wa_message'   => 'Hola Peanut Bakery 👋 Quiero hacer un pedido.',
	);
}

/**
 * Lee una opción del negocio.
 *
 * @param string $key Clave.
 * @return string
 */
function pb_opt( $key ) {
	$defaults = pb_defaults();
	$value    = get_theme_mod( 'pb_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
	return is_string( $value ) ? trim( $value ) : $value;
}

/**
 * Enlace de WhatsApp con mensaje pre-llenado.
 *
 * @param string $message Mensaje.
 * @return string
 */
function pb_wa( $message = '' ) {
	$number  = preg_replace( '/\D+/', '', pb_opt( 'whatsapp' ) );
	$message = $message ? $message : pb_opt( 'wa_message' );
	return 'https://wa.me/' . $number . '?text=' . rawurlencode( $message );
}

/**
 * Teléfono en formato tel:.
 */
function pb_tel() {
	return 'tel:+52' . preg_replace( '/\D+/', '', pb_opt( 'phone' ) );
}

/**
 * Dirección legible.
 */
function pb_address() {
	return implode( ', ', array_filter( array( pb_opt( 'street' ), pb_opt( 'city' ), 'B.C.', pb_opt( 'postal' ) ) ) );
}

/**
 * Espacios de imagen del sitio. Cada uno usa (en orden):
 * 1) la imagen elegida en el Personalizador,
 * 2) una foto REAL de la Biblioteca de Medios actual de peanutbakery.com, elegida automáticamente
 *    por palabras clave en su nombre/título/texto alternativo (ej. "concha", "birote", "masa"),
 * 3) la foto incluida en assets/img/ (PB_01.jpg … PB_05.jpg de la sesión fotográfica de Peanut Bakery),
 * 4) cualquier otra foto de la Biblioteca de Medios, para no dejar huecos,
 * 5) un degradado de marca si el sitio no tiene ninguna imagen.
 */
function pb_image_slots() {
	return array(
		'hero-1'      => array( 'label' => 'Slide 1 · Masa madre', 'file' => 'PB_01.jpg', 'keys' => array( 'masa', 'sourdough', 'hogaza', 'hero', 'slide', 'banner', 'portada' ) ),
		'hero-2'      => array( 'label' => 'Slide 2 · Pan dulce', 'file' => 'PB_02.jpg', 'keys' => array( 'concha', 'pan-dulce', 'pan_dulce', 'dona', 'donut', 'dulce' ) ),
		'hero-3'      => array( 'label' => 'Slide 3 · Bolillo y birote', 'file' => 'PB_03.jpg', 'keys' => array( 'birote', 'bolillo', 'telera', 'salado' ) ),
		'hero-4'      => array( 'label' => 'Slide 4 · Mayoreo', 'file' => 'PB_04.jpg', 'keys' => array( 'mayoreo', 'ventas', 'entrega', 'reparto', 'horno', 'oven' ) ),
		'intro'       => array( 'label' => 'Inicio · Ingeniería del pan', 'file' => 'PB_05.jpg', 'keys' => array( 'panadero', 'baker', 'manos', 'ingenieria', 'proceso', 'amasado' ) ),
		'line-dulce'  => array( 'label' => 'Línea · Pan dulce', 'file' => 'PB_02.jpg', 'keys' => array( 'concha', 'pan-dulce', 'dulce', 'dona', 'donut', 'cuerno' ) ),
		'line-salado' => array( 'label' => 'Línea · Bolillo y birote', 'file' => 'PB_03.jpg', 'keys' => array( 'birote', 'bolillo', 'telera' ) ),
		'line-madre'  => array( 'label' => 'Línea · Masa madre', 'file' => 'PB_01.jpg', 'keys' => array( 'masa-madre', 'masa_madre', 'masa', 'sourdough', 'hogaza' ) ),
		'line-artes'  => array( 'label' => 'Línea · Panes artesanales', 'file' => 'PB_05.jpg', 'keys' => array( 'artesanal', 'baguette', 'focaccia', 'ciabatta', 'brioche' ) ),
		'line-repos'  => array( 'label' => 'Línea · Repostería fina', 'file' => 'PB_04.jpg', 'keys' => array( 'reposteria', 'croissant', 'pastel', 'galleta', 'rol', 'canela' ) ),
		'about'       => array( 'label' => 'Nosotros · Encabezado', 'file' => 'PB_05.jpg', 'keys' => array( 'nosotros', 'equipo', 'team', 'panadero', 'compania' ) ),
		'space'       => array( 'label' => 'Nosotros · El espacio', 'file' => 'PB_04.jpg', 'keys' => array( 'local', 'tienda', 'espacio', 'interior', 'fachada', 'store' ) ),
		'products'    => array( 'label' => 'Productos · Encabezado', 'file' => 'PB_02.jpg', 'keys' => array( 'productos', 'variedad', 'surtido', 'galeria' ) ),
		'wholesale'   => array( 'label' => 'Mayoreo · Encabezado', 'file' => 'PB_04.jpg', 'keys' => array( 'mayoreo', 'ventas', 'entrega', 'charola', 'horno' ) ),
		'contact'     => array( 'label' => 'Contacto · Encabezado', 'file' => 'PB_01.jpg', 'keys' => array( 'contacto', 'fachada', 'local', 'mostrador' ) ),
		'og'          => array( 'label' => 'Imagen para compartir (Open Graph)', 'file' => 'PB_01.jpg', 'keys' => array( 'masa', 'hero', 'portada', 'logo' ) ),
	);
}

/**
 * Fotos de la Biblioteca de Medios del sitio (las que ya usa peanutbakery.com).
 * Devuelve [id => texto buscable], ordenadas de la más reciente a la más antigua. Se guarda en caché 12 h.
 *
 * @return array
 */
function pb_library_images() {
	static $images = null;
	if ( null !== $images ) {
		return $images;
	}
	$images = get_transient( 'pb_library_images' );
	if ( is_array( $images ) ) {
		return $images;
	}
	$images = array();
	$ids    = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_mime_type' => array( 'image/jpeg', 'image/png', 'image/webp' ),
			'post_status'    => 'inherit',
			'posts_per_page' => 300,
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);
	foreach ( $ids as $id ) {
		$meta = wp_get_attachment_metadata( $id );
		// Descarta logos, íconos y miniaturas: solo fotos de al menos 900 px de ancho.
		if ( empty( $meta['width'] ) || $meta['width'] < 900 ) {
			continue;
		}
		$text          = strtolower( remove_accents( implode( ' ', array( get_the_title( $id ), basename( (string) get_attached_file( $id ) ), get_post_meta( $id, '_wp_attachment_image_alt', true ) ) ) ) );
		$images[ $id ] = $text;
	}
	set_transient( 'pb_library_images', $images, 12 * HOUR_IN_SECONDS );
	return $images;
}

/**
 * Limpia la caché de fotos cuando se suben, editan o borran imágenes.
 */
function pb_flush_library_images() {
	delete_transient( 'pb_library_images' );
}
add_action( 'add_attachment', 'pb_flush_library_images' );
add_action( 'edit_attachment', 'pb_flush_library_images' );
add_action( 'delete_attachment', 'pb_flush_library_images' );

/**
 * Asigna automáticamente una foto real de la Biblioteca de Medios a cada espacio.
 * Primero por palabra clave; después reparte las fotos restantes para no repetir.
 *
 * @return array slot => attachment ID.
 */
function pb_auto_images() {
	static $map = null;
	if ( null !== $map ) {
		return $map;
	}
	$map    = array();
	$images = pb_library_images();
	if ( ! $images ) {
		return $map;
	}
	$used = array();
	foreach ( pb_image_slots() as $slot => $info ) {
		// 1.ª pasada: foto con palabra clave aún sin usar; 2.ª: la misma foto aunque ya se use en otra sección.
		foreach ( array( false, true ) as $allow_repeat ) {
			foreach ( $info['keys'] as $key ) {
				foreach ( $images as $id => $text ) {
					if ( ( $allow_repeat || ! isset( $used[ $id ] ) ) && false !== strpos( $text, $key ) ) {
						$map[ $slot ] = $id;
						$used[ $id ]  = true;
						continue 4;
					}
				}
			}
		}
	}
	$pool = array_values( array_diff( array_keys( $images ), array_keys( $used ) ) );
	if ( ! $pool ) {
		$pool = array_keys( $images );
	}
	$i = 0;
	foreach ( array_keys( pb_image_slots() ) as $slot ) {
		if ( ! isset( $map[ $slot ] ) ) {
			$map[ $slot ] = $pool[ $i % count( $pool ) ];
			$i++;
		}
	}
	return $map;
}

/**
 * URL de imagen para un espacio.
 *
 * @param string $slot Espacio.
 * @param string $size Tamaño registrado.
 * @return string
 */
function pb_img_url( $slot, $size = 'full' ) {
	$id = absint( get_theme_mod( 'pb_img_' . $slot ) );
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, $size );
		if ( $url ) {
			return $url;
		}
	}
	// Foto real del sitio actual, elegida automáticamente de la Biblioteca de Medios.
	$auto = pb_auto_images();
	if ( isset( $auto[ $slot ] ) ) {
		$url = wp_get_attachment_image_url( $auto[ $slot ], $size );
		if ( $url ) {
			return $url;
		}
	}
	$slots = pb_image_slots();
	if ( isset( $slots[ $slot ] ) ) {
		$file = 'assets/img/' . $slots[ $slot ]['file'];
		if ( file_exists( PB_DIR . '/' . $file ) ) {
			return PB_URI . '/' . $file;
		}
	}
	return '';
}

/**
 * Imagen <img> optimizada (lazy, decoding async) o marcador de marca.
 *
 * @param string $slot  Espacio.
 * @param string $alt   Texto alternativo SEO.
 * @param array  $args  size, class, eager.
 */
function pb_img( $slot, $alt, $args = array() ) {
	$args  = wp_parse_args(
		$args,
		array(
			'size'  => 'full',
			'class' => '',
			'eager' => false,
		)
	);
	$url = pb_img_url( $slot, $args['size'] );
	if ( ! $url ) {
		printf( '<span class="pb-ph %s" role="img" aria-label="%s"></span>', esc_attr( $args['class'] ), esc_attr( $alt ) );
		return;
	}
	printf(
		'<img src="%s" alt="%s" class="%s" %s decoding="async">',
		esc_url( $url ),
		esc_attr( $alt ),
		esc_attr( $args['class'] ),
		$args['eager'] ? 'fetchpriority="high"' : 'loading="lazy"'
	);
}

/**
 * Íconos SVG en línea (sin dependencias externas).
 *
 * @param string $name Nombre.
 * @return string
 */
function pb_icon( $name ) {
	$p = array(
		'whatsapp'  => '<path d="M16 3a13 13 0 0 0-11.2 19.6L3 29l6.6-1.7A13 13 0 1 0 16 3Zm0 23.6a10.6 10.6 0 0 1-5.4-1.5l-.4-.2-3.9 1 1-3.8-.2-.4A10.6 10.6 0 1 1 16 26.6Zm5.8-7.9c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7 0a8.7 8.7 0 0 1-4.3-3.8c-.3-.6.3-.5 1-1.7.1-.2 0-.4 0-.6l-1-2.3c-.3-.6-.5-.5-.7-.5h-.6a1.2 1.2 0 0 0-.9.4 3.7 3.7 0 0 0-1.1 2.7 6.4 6.4 0 0 0 1.3 3.4 14.7 14.7 0 0 0 5.7 5c2.1.9 2.9 1 4 .8a3.4 3.4 0 0 0 2.2-1.6 2.8 2.8 0 0 0 .2-1.6c-.1-.1-.3-.2-.6-.4Z" fill="currentColor"/>',
		'phone'     => '<path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1Z" fill="currentColor"/>',
		'mail'      => '<path d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm9 7.2L4.4 7H4v.6l8 5.6 8-5.6V7h-.4Z" fill="currentColor"/>',
		'pin'       => '<path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z" fill="currentColor"/>',
		'clock'     => '<path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 10.4 3.5 2.1-.8 1.3L11 13V7h2Z" fill="currentColor"/>',
		'arrow'     => '<path d="M5 12h12m-5-6 6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>',
		'chevron'   => '<path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/>',
		'facebook'  => '<path d="M14 8h3V4h-3a4 4 0 0 0-4 4v2H7v4h3v8h4v-8h3l1-4h-4V8.5a.5.5 0 0 1 .5-.5Z" fill="currentColor"/>',
		'tiktok'    => '<path d="M16 3c.4 2.3 1.8 3.8 4 4v3.2a7.4 7.4 0 0 1-4-1.2v6.6A5.6 5.6 0 1 1 10.4 10v3.3a2.4 2.4 0 1 0 2.4 2.4V3Z" fill="currentColor"/>',
		'youtube'   => '<path d="M22 8.2a3 3 0 0 0-2.1-2.1C18 5.6 12 5.6 12 5.6s-6 0-7.9.5A3 3 0 0 0 2 8.2 31 31 0 0 0 1.6 12 31 31 0 0 0 2 15.8a3 3 0 0 0 2.1 2.1c1.9.5 7.9.5 7.9.5s6 0 7.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .4-3.8 31 31 0 0 0-.4-3.8ZM10 15V9l5.2 3Z" fill="currentColor"/>',
		'wheat'     => '<path d="M12 22V9m0 4c-2.5 0-4-1.5-4-4 2.5 0 4 1.5 4 4Zm0 0c2.5 0 4-1.5 4-4-2.5 0-4 1.5-4 4Zm0-4c-2.5 0-4-1.5-4-4 2.5 0 4 1.5 4 4Zm0 0c2.5 0 4-1.5 4-4-2.5 0-4 1.5-4 4Zm0-4V2" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/>',
		'flask'     => '<path d="M9 3h6M10 3v6l-5 9a2 2 0 0 0 1.7 3h10.6a2 2 0 0 0 1.7-3l-5-9V3M7.5 14h9" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>',
		'hand'      => '<path d="M8 13V5.5a1.5 1.5 0 0 1 3 0V12m0-1V4.5a1.5 1.5 0 0 1 3 0V12m0-6.5a1.5 1.5 0 0 1 3 0V13m0-4.5a1.5 1.5 0 0 1 3 0V15a7 7 0 0 1-7 7h-1a7 7 0 0 1-6-3.4L3.3 15a1.5 1.5 0 0 1 2.6-1.5L8 16" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>',
		'truck'     => '<path d="M2 6h12v10H2zM14 10h4l3 3v3h-7M6.5 19a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm11 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/>',
		'shield'    => '<path d="M12 3 4 6v6c0 4.5 3.4 8.3 8 9 4.6-.7 8-4.5 8-9V6Zm-3.5 9 2.5 2.5 4.5-5" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>',
		'star'      => '<path d="m12 3 2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1-4.4-4.3 6.1-.9Z" fill="currentColor"/>',
		'fire'      => '<path d="M12 22a7 7 0 0 0 7-7c0-4-3-6-4-10-1.5 2-2 3.5-2 5-1.5-1-2.5-3-2.5-5C7 7 5 10.5 5 15a7 7 0 0 0 7 7Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/>',
		'cup'       => '<path d="M4 8h13v5a6 6 0 0 1-6 6h-1a6 6 0 0 1-6-6Zm13 1h1.5a2.5 2.5 0 0 1 0 5H17M8 3v2m4-2v2" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/>',
	);
	if ( ! isset( $p[ $name ] ) ) {
		return '';
	}
	$box = in_array( $name, array( 'whatsapp' ), true ) ? '0 0 32 32' : '0 0 24 24';
	return '<svg class="icon icon--' . esc_attr( $name ) . '" viewBox="' . $box . '" aria-hidden="true" focusable="false">' . $p[ $name ] . '</svg>';
}

/**
 * Enlaces a redes sociales configurados.
 */
function pb_socials() {
	$out = array();
	foreach ( array( 'instagram', 'facebook', 'tiktok', 'youtube' ) as $net ) {
		$url = pb_opt( $net );
		if ( $url ) {
			$out[ $net ] = $url;
		}
	}
	return $out;
}

/**
 * Encabezado de página interior (header top con imagen panorámica).
 *
 * @param array $args eyebrow, title, lead, slot, alt.
 */
function pb_page_hero( $args ) {
	get_template_part( 'template-parts/page-hero', null, $args );
}
