<?php
/**
 * Funciones de plantilla y acceso a los datos del negocio.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Valores por defecto de los datos del consultorio.
 * Todos son editables en Apariencia → Personalizar → Cardiología: datos del consultorio.
 */
function cardio_defaults() {
	return array(
		'tel'          => '+52 (664) 416 2551',
		'tel_link'     => '+526644162551',
		'whatsapp'     => '526644162551',
		'wa_msg'       => 'Hola, quiero agendar una cita de cardiología.',
		'email'        => 'info@cardiologiatijuana.com',
		'form_email'   => 'info@cardiologiatijuana.com',
		'medico'       => 'Dr. Eduardo Canseco',
		'calle'        => 'Plaza Península, Int. D2-2, Centro Hospitalario MAC',
		'calle2'       => 'Blvd. Vía Rápida Oriente 15000, Alamar',
		'ciudad'       => 'Tijuana',
		'estado'       => 'Baja California',
		'cp'           => '22110',
		'lat'          => '32.5149',
		'lng'          => '-116.9419',
		'horario'      => 'Consulta con cita previa. Confirme su horario por teléfono o WhatsApp.',
		'facebook'     => 'https://www.facebook.com/tijuanacardiologia',
		'instagram'    => 'https://www.instagram.com/cardiologiatijuana',
		'google'       => '',
		'hero_titulo'  => 'Su corazón merece un <span class="accent">diagnóstico preciso</span>',
		'hero_texto'   => 'El <strong>Dr. Eduardo Canseco</strong> es cardiólogo en Tijuana con más de 10 años de experiencia en el cuidado del corazón. Estudios cardiovasculares completos en un solo lugar, con resultados e interpretación el mismo día.',
		'hero_badge'   => '<b>Certificado en ecocardiografía</b> · Consejo Mexicano de Cardiología',
		'anios'        => '10',
		'estudios'     => '8',
	);
}

/**
 * Devuelve un ajuste del Personalizador con su valor por defecto.
 *
 * @param string $key Clave del ajuste.
 * @return string
 */
function cardio_opt( $key ) {
	$defaults = cardio_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'cardio_' . $key, $default );
}

/**
 * Imprime un ajuste ya escapado.
 */
function cardio_e( $key ) {
	echo esc_html( cardio_opt( $key ) );
}

/**
 * Enlace de WhatsApp con el mensaje predefinido.
 */
function cardio_wa_url() {
	$num = preg_replace( '/\D/', '', cardio_opt( 'whatsapp' ) );
	if ( ! $num ) {
		return '';
	}
	return 'https://wa.me/' . $num . '?text=' . rawurlencode( cardio_opt( 'wa_msg' ) );
}

/**
 * Enlace telefónico normalizado.
 */
function cardio_tel_url() {
	$raw = cardio_opt( 'tel_link' );
	$num = preg_replace( '/[^0-9+]/', '', $raw );
	return 'tel:' . $num;
}

/**
 * Dirección completa en una línea.
 */
function cardio_direccion_linea() {
	return trim(
		sprintf(
			'%s, %s, %s %s, %s',
			cardio_opt( 'calle' ),
			cardio_opt( 'calle2' ),
			cardio_opt( 'cp' ),
			cardio_opt( 'ciudad' ),
			cardio_opt( 'estado' )
		)
	);
}

/**
 * URL de Google Maps para «Cómo llegar».
 */
function cardio_maps_url() {
	return 'https://maps.google.com/?q=' . rawurlencode( cardio_direccion_linea() );
}

/**
 * URL del mapa embebido.
 */
function cardio_maps_embed() {
	return 'https://www.google.com/maps?q=' . rawurlencode( cardio_direccion_linea() ) . '&output=embed';
}

/**
 * Símbolo del corazón para la cabecera y el menú móvil.
 *
 * En la cabecera va sólo el símbolo acompañado del nombre del consultorio;
 * el nombre del médico aparece en el logotipo completo del pie.
 *
 * @param string $class Clases CSS.
 */
function cardio_marca( $class = 'brand__mark' ) {
	$id = get_theme_mod( 'custom_logo' );
	if ( $id ) {
		echo wp_get_attachment_image(
			$id,
			'full',
			false,
			array(
				'class'  => esc_attr( $class ),
				'alt'    => '',
				'width'  => 46,
				'height' => 46,
			)
		);
		return;
	}

	printf(
		'<img class="%1$s" src="%2$s" alt="" width="46" height="46">',
		esc_attr( $class ),
		esc_url( CARDIO_URI . '/assets/img/logo-mark.png' )
	);
}

/**
 * Logotipo completo del pie.
 *
 * Incluye el corazón, «Cardiología Tijuana» y «Dr. Eduardo Canseco» dentro de
 * la propia imagen, por lo que la plantilla no repite esos textos al lado.
 *
 * @param string $variante «claro» sobre fondo blanco, «oscuro» sobre fondo navy.
 * @param string $class    Clases CSS adicionales.
 */
function cardio_logo( $variante = 'claro', $class = 'brand__logo' ) {
	$alt = sprintf(
		'%s — %s',
		get_bloginfo( 'name' ),
		cardio_opt( 'medico' )
	);

	// Logotipo subido desde el Personalizador: se usa en ambos contextos.
	$id = get_theme_mod( 'custom_logo' );
	if ( $id ) {
		echo wp_get_attachment_image(
			$id,
			'full',
			false,
			array(
				'class' => esc_attr( $class ),
				'alt'   => esc_attr( $alt ),
			)
		);
		return;
	}

	$archivo = ( 'oscuro' === $variante ) ? 'logo-lockup-blanco.png' : 'logo-lockup.png';

	printf(
		'<img class="%1$s" src="%2$s" alt="%3$s" width="700" height="172">',
		esc_attr( $class ),
		esc_url( CARDIO_URI . '/assets/img/' . $archivo ),
		esc_attr( $alt )
	);
}

/**
 * Fotografía del médico.
 *
 * Primero busca la imagen subida desde el Personalizador; si no hay ninguna,
 * usa el recorte incluido en el tema; y si tampoco existe, devuelve cadena
 * vacía para que la plantilla recurra a su imagen de apoyo. Así nunca se
 * publica una imagen rota.
 *
 * @param string $variante «retrato» (3:4) o «busto» (1:1).
 * @param string $clase    Clases CSS para la etiqueta img.
 * @return string HTML de la imagen, o cadena vacía.
 */
function cardio_foto_medico( $variante = 'retrato', $clase = '' ) {
	$ajuste = ( 'busto' === $variante ) ? 'cardio_foto_busto' : 'cardio_foto_retrato';
	$id     = (int) get_theme_mod( $ajuste, 0 );

	// Si sólo se subió una foto, se reutiliza para ambas variantes.
	if ( ! $id ) {
		$id = (int) get_theme_mod( 'cardio_foto_retrato', 0 );
	}

	$alt = sprintf(
		/* translators: %s: nombre del médico. */
		__( '%s, cardiólogo en Tijuana, en su consultorio', 'cardio-canseco' ),
		cardio_opt( 'medico' )
	);

	if ( $id ) {
		return wp_get_attachment_image(
			$id,
			'large',
			false,
			array(
				'class'    => $clase,
				'alt'      => $alt,
				'loading'  => 'lazy',
				'decoding' => 'async',
			)
		);
	}

	// Recorte incluido en el tema, si el diseñador lo dejó preparado.
	$archivo = ( 'busto' === $variante ) ? 'dr-canseco-busto.jpg' : 'dr-canseco-retrato.jpg';
	if ( file_exists( CARDIO_DIR . '/assets/img/' . $archivo ) ) {
		$dim = ( 'busto' === $variante ) ? array( 1000, 1000 ) : array( 900, 1200 );
		return sprintf(
			'<img class="%1$s" src="%2$s" alt="%3$s" width="%4$d" height="%5$d" loading="lazy" decoding="async">',
			esc_attr( $clase ),
			esc_url( CARDIO_URI . '/assets/img/' . $archivo ),
			esc_attr( $alt ),
			$dim[0],
			$dim[1]
		);
	}

	return '';
}

/**
 * Indica si hay foto del médico disponible.
 */
function cardio_hay_foto_medico( $variante = 'retrato' ) {
	return '' !== cardio_foto_medico( $variante );
}

/**
 * Fichas de formación y de sociedades médicas.
 *
 * @param string $tipo «formacion» o «sociedades».
 * @return string
 */
function cardio_instituciones( $tipo = 'formacion' ) {
	$formacion = array(
		array( 'unam.png', 'Universidad Nacional Autónoma de México', __( 'Especialidad en Cardiología Clínica · 2009', 'cardio-canseco' ) ),
		array( 'incmnsz.png', 'INCMN Salvador Zubirán', __( 'Certificación en Ecocardiografía Clínica · 2008', 'cardio-canseco' ) ),
		array( 'usfx.png', 'U. Mayor Real y Pontificia de San Francisco Xavier', __( 'Médico Cirujano · 2007', 'cardio-canseco' ) ),
	);

	$sociedades = array(
		array( 'aval-cardiologosdemexico.png', 'Asociación Nacional de Cardiólogos de México', 'ANCAM' ),
		array( 'aval-scbc.png', 'Sociedad de Cardiología de Baja California', __( 'Miembro', 'cardio-canseco' ) ),
		array( 'aval-consejomexicanocardiologia.png', 'Consejo Mexicano de Cardiología', __( 'Certificación', 'cardio-canseco' ) ),
		array( 'aval-esc.png', 'European Society of Cardiology', __( 'Miembro', 'cardio-canseco' ) ),
	);

	$lista = ( 'sociedades' === $tipo ) ? $sociedades : $formacion;

	$out = '<div class="instituciones">';
	foreach ( $lista as $item ) {
		list( $archivo, $nombre, $detalle ) = $item;

		$logo = '';
		if ( file_exists( CARDIO_DIR . '/assets/img/' . $archivo ) ) {
			$logo = sprintf(
				'<img src="%1$s" alt="%2$s" width="54" height="54" loading="lazy" decoding="async">',
				esc_url( CARDIO_URI . '/assets/img/' . $archivo ),
				esc_attr( $nombre )
			);
		}

		$out .= sprintf(
			'<div class="institucion">%1$s<span><b>%2$s</b><span>%3$s</span></span></div>',
			$logo,
			esc_html( $nombre ),
			esc_html( $detalle )
		);
	}
	$out .= '</div>';

	return $out;
}

/**
 * Iconos SVG del tema.
 *
 * @param string $name Nombre del icono.
 * @return string SVG en línea.
 */
function cardio_icon( $name ) {
	$icons = array(
		'pin'    => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/>',
		'mail'   => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>',
		'phone'  => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>',
		'clock'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'arrow'  => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'ext'    => '<path d="M7 17 17 7M9 7h8v8"/>',
		'heart'  => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1L12 21l7.7-7.6 1.1-1a5.5 5.5 0 0 0 0-7.8Z"/>',
		'shield' => '<path d="M12 22s8-4.5 8-10V5l-8-3-8 3v7c0 5.5 8 10 8 10Z"/><path d="M9 12l2 2 4-4"/>',
		'close'  => '<path d="M18 6 6 18M6 6l12 12"/>',
		'chevl'  => '<path d="M15 18l-6-6 6-6"/>',
		'chevr'  => '<path d="M9 18l6-6-6-6"/>',
	);

	// Iconos rellenos (no de trazo).
	$filled = array(
		'wa' => '<path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2Zm5.8 14.2c-.2.7-1.4 1.3-2 1.4-.5.1-1.1.1-1.8-.1a14 14 0 0 1-6.2-5.4c-.5-.8-.8-1.7-.8-2.6 0-.9.5-1.4.7-1.6.2-.2.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 1.9c.1.2 0 .4-.1.6l-.4.5c-.1.2-.3.3-.1.6a9.4 9.4 0 0 0 3.9 3.3c.3.1.5.1.6-.1l.7-.9c.2-.2.4-.2.6-.1l1.8.9c.2.1.4.2.4.3v.7Z"/>',
		'fb' => '<path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4v-2c0-.6.4-1 1-1Z"/>',
	);

	if ( isset( $filled[ $name ] ) ) {
		return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">' . $filled[ $name ] . '</svg>';
	}

	if ( 'ig' === $name ) {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor" stroke="none"/></svg>';
	}

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $icons[ $name ] . '</svg>';
}

/**
 * Imprime un icono.
 *
 * El SVG procede de la constante de arriba, no de datos del usuario, y se
 * imprime tal cual: pasarlo por wp_kses convertiría «viewBox» a minúsculas.
 */
function cardio_icon_e( $name ) {
	echo cardio_icon( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Etiquetas SVG permitidas por wp_kses.
 */
function cardio_svg_allowed() {
	return array(
		'svg'      => array( 'viewbox' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'aria-hidden' => true, 'class' => true, 'role' => true, 'preserveaspectratio' => true, 'xmlns' => true ),
		'path'     => array( 'd' => true, 'fill' => true, 'stroke' => true ),
		'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true ),
		'rect'     => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true ),
		'polyline' => array( 'points' => true ),
	);
}

/**
 * Botón de llamada a la acción con enlace a la página de cita.
 */
function cardio_cita_url() {
	$page = get_page_by_path( 'cita' );
	if ( ! $page ) {
		$page = get_page_by_path( 'agenda-tu-cita' );
	}
	return $page ? get_permalink( $page ) : home_url( '/cita/' );
}

/**
 * Migas de pan accesibles.
 */
function cardio_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}

	echo '<ul class="breadcrumb">';
	printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' ) ), esc_html__( 'Inicio', 'cardio-canseco' ) );

	if ( is_singular( 'procedimiento' ) ) {
		$archive = get_post_type_archive_link( 'procedimiento' );
		if ( $archive ) {
			printf( '<li><a href="%s">%s</a></li>', esc_url( $archive ), esc_html__( 'Procedimientos', 'cardio-canseco' ) );
		}
		printf( '<li><span aria-current="page">%s</span></li>', esc_html( get_the_title() ) );
	} elseif ( is_post_type_archive( 'procedimiento' ) ) {
		printf( '<li><span aria-current="page">%s</span></li>', esc_html__( 'Procedimientos', 'cardio-canseco' ) );
	} elseif ( is_singular() ) {
		$parent = wp_get_post_parent_id( get_the_ID() );
		if ( $parent ) {
			printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $parent ) ), esc_html( get_the_title( $parent ) ) );
		}
		printf( '<li><span aria-current="page">%s</span></li>', esc_html( get_the_title() ) );
	} elseif ( is_search() ) {
		printf( '<li><span aria-current="page">%s</span></li>', esc_html__( 'Resultados de búsqueda', 'cardio-canseco' ) );
	} elseif ( is_404() ) {
		printf( '<li><span aria-current="page">%s</span></li>', esc_html__( 'Página no encontrada', 'cardio-canseco' ) );
	} else {
		printf( '<li><span aria-current="page">%s</span></li>', esc_html( wp_strip_all_tags( get_the_archive_title() ) ) );
	}

	echo '</ul>';
}

/**
 * Imagen de cabecera de una página interior: destacada o la del tema.
 */
function cardio_hero_bg( $fallback = 'hero-ecocardiografia.jpg' ) {
	if ( is_singular() && has_post_thumbnail() ) {
		$url = get_the_post_thumbnail_url( get_the_ID(), 'cardio-hero' );
		if ( $url ) {
			return $url;
		}
	}
	return CARDIO_URI . '/assets/img/' . $fallback;
}

/**
 * Walker del menú principal: añade las clases que espera el CSS.
 */
class Cardio_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Apertura del submenú.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="sub-menu">';
	}

	/**
	 * Elemento del menú.
	 *
	 * @param string   $output Acumulador de salida.
	 * @param WP_Post  $item   Elemento del menú.
	 * @param int      $depth  Nivel de anidación.
	 * @param stdClass $args   Argumentos de wp_nav_menu().
	 * @param int      $id     Identificador.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		if ( in_array( 'menu-item-has-children', $classes, true ) && 0 === $depth ) {
			$classes[] = 'has-sub';
		}

		$classes    = array_filter( array_unique( $classes ) );
		$class_attr = $classes ? ' class="' . esc_attr( implode( ' ', $classes ) ) . '"' : '';

		$link_class = ( 0 === $depth ) ? 'nav__link' : '';

		// La página actual se marca con aria-current; si estamos en una hija,
		// el padre se resalta con una clase para no mentir sobre cuál es la página.
		$es_actual = in_array( 'current-menu-item', $classes, true )
			|| in_array( 'current_page_item', $classes, true );

		$es_ancestro = in_array( 'current-menu-ancestor', $classes, true )
			|| in_array( 'current-menu-parent', $classes, true )
			|| in_array( 'current_page_parent', $classes, true );

		if ( $es_ancestro && ! $es_actual ) {
			$link_class = trim( $link_class . ' is-ancestor' );
		}

		$attrs = '';
		if ( $link_class ) {
			$attrs .= ' class="' . esc_attr( $link_class ) . '"';
		}
		if ( $es_actual ) {
			$attrs .= ' aria-current="page"';
		}

		// Atributos que el cliente puede fijar en Apariencia → Menús.
		if ( ! empty( $item->attr_title ) ) {
			$attrs .= ' title="' . esc_attr( $item->attr_title ) . '"';
		}
		if ( ! empty( $item->target ) ) {
			$attrs .= ' target="' . esc_attr( $item->target ) . '"';
			// Sin rel="noopener" una pestaña nueva puede manipular la original.
			$rel     = ! empty( $item->xfn ) ? $item->xfn . ' ' : '';
			$attrs  .= ' rel="' . esc_attr( trim( $rel . 'noopener' ) ) . '"';
		} elseif ( ! empty( $item->xfn ) ) {
			$attrs .= ' rel="' . esc_attr( $item->xfn ) . '"';
		}

		/** Filtro de WordPress para el título del elemento. */
		$titulo = apply_filters( 'the_title', $item->title, $item->ID );
		$titulo = apply_filters( 'nav_menu_item_title', $titulo, $item, $args, $depth );

		// En el submenú, la descripción del elemento se pinta bajo el título.
		// Se rellena en Apariencia → Menús (active «Descripción» en Opciones
		// de pantalla). El .xml de importación ya la trae escrita.
		$output .= '<li' . $class_attr . '>';
		$output .= '<a href="' . esc_url( $item->url ) . '"' . $attrs . '>' . $titulo . '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}
}

/**
 * Menú de respaldo cuando no se ha asignado ninguno.
 */
function cardio_fallback_menu() {
	echo '<ul class="nav__list">';
	printf( '<li><a class="nav__link" href="%s">%s</a></li>', esc_url( home_url( '/' ) ), esc_html__( 'Inicio', 'cardio-canseco' ) );

	$archive = get_post_type_archive_link( 'procedimiento' );
	if ( $archive ) {
		printf( '<li><a class="nav__link" href="%s">%s</a></li>', esc_url( $archive ), esc_html__( 'Procedimientos', 'cardio-canseco' ) );
	}

	$pages = get_pages( array( 'sort_column' => 'menu_order', 'number' => 4 ) );
	foreach ( $pages as $page ) {
		printf( '<li><a class="nav__link" href="%s">%s</a></li>', esc_url( get_permalink( $page ) ), esc_html( $page->post_title ) );
	}
	echo '</ul>';
}
