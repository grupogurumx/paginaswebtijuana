<?php
/**
 * Customizer: datos de contacto, correo de leads y slides del hero.
 *
 * @package hospital-nova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function ( $wp ) {
	$wp->add_panel( 'nova', array( 'title' => 'Hospital Nova', 'priority' => 20 ) );

	$wp->add_section( 'nova_contact', array( 'title' => __( 'Contacto y redes', 'hospital-nova' ), 'panel' => 'nova' ) );
	$fields = array(
		'email_to'   => array( 'Correo que recibe los formularios', 'email' ),
		'phone'      => array( 'Teléfono principal / citas', 'text' ),
		'whatsapp'   => array( 'WhatsApp general', 'text' ),
		'phone_onco' => array( 'WhatsApp Cirugía Oncológica', 'text' ),
		'address'    => array( 'Dirección completa', 'text' ),
		'maps_query' => array( 'Búsqueda o dirección para Google Maps', 'text' ),
		'lat'        => array( 'Latitud (Schema)', 'text' ),
		'lng'        => array( 'Longitud (Schema)', 'text' ),
		'facebook'   => array( 'URL Facebook', 'url' ),
		'instagram'  => array( 'URL Instagram', 'url' ),
	);
	$defaults = nova_defaults();
	foreach ( $fields as $key => $f ) {
		$wp->add_setting( 'nova_' . $key, array(
			'default'           => $defaults[ $key ],
			'sanitize_callback' => 'email' === $f[1] ? 'sanitize_email' : ( 'url' === $f[1] ? 'esc_url_raw' : 'sanitize_text_field' ),
		) );
		$wp->add_control( 'nova_' . $key, array( 'label' => $f[0], 'section' => 'nova_contact', 'type' => $f[1] ) );
	}

	$wp->add_section( 'nova_hero', array(
		'title'       => __( 'Hero 3D (slider panorámico)', 'hospital-nova' ),
		'panel'       => 'nova',
		'description' => 'Sube imágenes verticales 4:5 (1080×1350) generadas en Higgsfield, Magnific, Freepik o Canva. Si se dejan vacías se usan las del tema.',
	) );
	$wp->add_setting( 'nova_hero_title_es', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp->add_control( 'nova_hero_title_es', array( 'label' => 'Título hero (ES)', 'section' => 'nova_hero' ) );
	$wp->add_setting( 'nova_hero_title_en', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp->add_control( 'nova_hero_title_en', array( 'label' => 'Hero title (EN)', 'section' => 'nova_hero' ) );
	$wp->add_setting( 'nova_hero_autoplay', array( 'default' => 5000, 'sanitize_callback' => 'absint' ) );
	$wp->add_control( 'nova_hero_autoplay', array( 'label' => 'Autoplay (ms, 0 = apagado)', 'section' => 'nova_hero', 'type' => 'number' ) );

	for ( $i = 1; $i <= 5; $i++ ) {
		$wp->add_setting( "nova_slide{$i}_img", array( 'sanitize_callback' => 'esc_url_raw' ) );
		$wp->add_control( new WP_Customize_Image_Control( $wp, "nova_slide{$i}_img", array( 'label' => "Slide {$i} — imagen", 'section' => 'nova_hero' ) ) );
		foreach ( array( 'es', 'en' ) as $l ) {
			$wp->add_setting( "nova_slide{$i}_title_{$l}", array( 'sanitize_callback' => 'sanitize_text_field' ) );
			$wp->add_control( "nova_slide{$i}_title_{$l}", array( 'label' => "Slide {$i} — título " . strtoupper( $l ), 'section' => 'nova_hero' ) );
		}
	}
} );
