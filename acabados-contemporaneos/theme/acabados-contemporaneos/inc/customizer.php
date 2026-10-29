<?php
/**
 * Personalizador: datos de contacto, NAP para SEO local y redes.
 *
 * Apariencia → Personalizar → Acabados Contemporáneos.
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Campos configurables del negocio.
 *
 * @return array clave => [etiqueta, tipo, por defecto]
 */
function ac_customizer_fields() {
	return array(
		'phone'      => array( 'Teléfono principal (ej. +52 33 1234 5678)', 'text', '' ),
		'whatsapp'   => array( 'WhatsApp (solo números con lada, ej. 5213312345678)', 'text', '' ),
		'email'      => array( 'Correo de ventas', 'email', '' ),
		'form_email' => array( 'Correo que recibe el formulario (vacío = correo del administrador)', 'email', '' ),
		'street'     => array( 'Calle y número', 'text', '' ),
		'locality'   => array( 'Colonia', 'text', '' ),
		'city'       => array( 'Ciudad', 'text', '' ),
		'region'     => array( 'Estado', 'text', '' ),
		'postal'     => array( 'Código postal', 'text', '' ),
		'maps_url'   => array( 'Enlace de Google Maps', 'url', '' ),
		'lat'        => array( 'Latitud (Schema)', 'text', '' ),
		'lng'        => array( 'Longitud (Schema)', 'text', '' ),
		'hours_es'   => array( 'Horario (español)', 'text', '' ),
		'hours_en'   => array( 'Horario (inglés)', 'text', '' ),
		'founded'    => array( 'Año de fundación (Schema, ej. 1989)', 'text', '' ),
		'years'      => array( 'Años de experiencia (cifra)', 'text', '35' ),
		'instagram'  => array( 'Instagram URL', 'url', '' ),
		'facebook'   => array( 'Facebook URL', 'url', '' ),
		'pinterest'  => array( 'Pinterest URL', 'url', '' ),
		'linkedin'   => array( 'LinkedIn URL', 'url', '' ),
		'youtube'    => array( 'YouTube URL', 'url', '' ),
		'tiktok'     => array( 'TikTok URL', 'url', '' ),
		'gsc'        => array( 'Código de verificación Google Search Console', 'text', '' ),
		'ga4'        => array( 'ID de Google Analytics 4 (G-XXXXXXX)', 'text', '' ),
	);
}

/**
 * Registro de la sección y controles.
 *
 * @param WP_Customize_Manager $wp_customize Gestor.
 */
function ac_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'ac_business',
		array(
			'title'       => 'Acabados Contemporáneos',
			'description' => 'Datos del negocio usados en el encabezado, pie de página, botón de WhatsApp y datos estructurados (SEO local). Los campos vacíos no se muestran.',
			'priority'    => 30,
		)
	);

	foreach ( ac_customizer_fields() as $key => $field ) {
		list( $label, $type, $default ) = $field;
		$sanitize = 'url' === $type ? 'esc_url_raw' : ( 'email' === $type ? 'sanitize_email' : 'sanitize_text_field' );
		$wp_customize->add_setting(
			'ac_' . $key,
			array(
				'default'           => $default,
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			'ac_' . $key,
			array(
				'label'   => $label,
				'section' => 'ac_business',
				'type'    => 'url' === $type ? 'url' : ( 'email' === $type ? 'email' : 'text' ),
			)
		);
	}
}
add_action( 'customize_register', 'ac_customize_register' );

/**
 * Dirección completa en una línea.
 *
 * @return string
 */
function ac_address_line() {
	$parts = array_filter(
		array(
			ac_opt( 'street' ),
			ac_opt( 'locality' ),
			trim( ac_opt( 'postal' ) . ' ' . ac_opt( 'city' ) ),
			ac_opt( 'region' ),
		)
	);
	return implode( ', ', $parts );
}

/**
 * Redes configuradas.
 *
 * @return array red => url
 */
function ac_socials() {
	$out = array();
	foreach ( array( 'instagram', 'facebook', 'pinterest', 'linkedin', 'youtube', 'tiktok' ) as $net ) {
		$url = ac_opt( $net );
		if ( $url ) {
			$out[ $net ] = $url;
		}
	}
	return $out;
}
