<?php
/**
 * Personalizador: datos de contacto, redes, video del hero y fotos de cada sección.
 *
 * @package PeanutBakery
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra paneles y controles.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function pb_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'pb_panel',
		array(
			'title'    => __( 'Peanut Bakery', 'peanut-bakery' ),
			'priority' => 20,
		)
	);

	$sections = array(
		'pb_contact' => array(
			'title'  => __( 'Datos de contacto', 'peanut-bakery' ),
			'fields' => array(
				'phone'        => array( 'Teléfono visible', 'text' ),
				'whatsapp'     => array( 'WhatsApp (con lada país, solo números: 52…)', 'text' ),
				'wa_message'   => array( 'Mensaje predeterminado de WhatsApp', 'text' ),
				'email'        => array( 'Correo de ventas', 'email' ),
				'street'       => array( 'Calle y número', 'text' ),
				'city'         => array( 'Ciudad', 'text' ),
				'postal'       => array( 'Código postal', 'text' ),
				'hours'        => array( 'Horario visible', 'text' ),
				'hours_schema' => array( 'Horario para Google (ej. Mo-Su 07:00-21:00)', 'text' ),
				'lat'          => array( 'Latitud (Google Maps)', 'text' ),
				'lng'          => array( 'Longitud (Google Maps)', 'text' ),
				'maps_embed'   => array( 'URL de mapa embebido (Google Maps → Compartir → Insertar)', 'url' ),
				'maps_link'    => array( 'Enlace a ficha de Google Maps', 'url' ),
			),
		),
		'pb_social'  => array(
			'title'  => __( 'Redes sociales', 'peanut-bakery' ),
			'fields' => array(
				'instagram' => array( 'Instagram', 'url' ),
				'facebook'  => array( 'Facebook', 'url' ),
				'tiktok'    => array( 'TikTok', 'url' ),
				'youtube'   => array( 'YouTube', 'url' ),
			),
		),
		'pb_hero'    => array(
			'title'  => __( 'Slider panorámico', 'peanut-bakery' ),
			'fields' => array(
				'hero_video' => array( 'Video de fondo del slide 1 (URL .mp4 de la Biblioteca de Medios, opcional)', 'url' ),
			),
		),
	);

	$defaults = pb_defaults();
	foreach ( $sections as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => $section['title'],
				'panel' => 'pb_panel',
			)
		);
		foreach ( $section['fields'] as $key => $field ) {
			$wp_customize->add_setting(
				'pb_' . $key,
				array(
					'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
					'sanitize_callback' => 'url' === $field[1] ? 'esc_url_raw' : ( 'email' === $field[1] ? 'sanitize_email' : 'sanitize_text_field' ),
				)
			);
			$wp_customize->add_control(
				'pb_' . $key,
				array(
					'label'   => $field[0],
					'section' => $section_id,
					'type'    => 'url' === $field[1] ? 'url' : ( 'email' === $field[1] ? 'email' : 'text' ),
				)
			);
		}
	}

	// Fotos: cada espacio puede tomar una imagen de la Biblioteca de Medios actual del sitio.
	$wp_customize->add_section(
		'pb_images',
		array(
			'title'       => __( 'Fotos del sitio', 'peanut-bakery' ),
			'panel'       => 'pb_panel',
			'description' => __( 'Por defecto el tema toma automáticamente las fotos reales que ya están en la Biblioteca de Medios de peanutbakery.com (por nombre: concha, birote, masa madre, etc.). Aquí puedes fijar manualmente la foto de cada sección.', 'peanut-bakery' ),
		)
	);
	foreach ( pb_image_slots() as $slot => $info ) {
		$wp_customize->add_setting(
			'pb_img_' . $slot,
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'pb_img_' . $slot,
				array(
					'label'     => $info['label'],
					'section'   => 'pb_images',
					'mime_type' => 'image',
				)
			)
		);
	}
}
add_action( 'customize_register', 'pb_customize_register' );
