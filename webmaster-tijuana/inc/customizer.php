<?php
/**
 * Personalizador: datos del negocio, slider del inicio y formulario.
 *
 * @package WebmasterTijuana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wmt_customize_register( $wp_customize ) {
	$defaults = wmt_defaults();

	$wp_customize->add_panel(
		'wmt_panel',
		array(
			'title'    => __( 'Webmaster Tijuana', 'webmaster-tijuana' ),
			'priority' => 30,
		)
	);

	/* --- Contacto --- */
	$wp_customize->add_section( 'wmt_contacto', array( 'title' => __( 'Datos de contacto', 'webmaster-tijuana' ), 'panel' => 'wmt_panel' ) );

	$campos = array(
		'telefono'  => array( __( 'Teléfono', 'webmaster-tijuana' ), 'text', 'sanitize_text_field' ),
		'whatsapp'  => array( __( 'WhatsApp (con lada de país, sólo números)', 'webmaster-tijuana' ), 'text', 'wmt_sanitize_digits' ),
		'email'     => array( __( 'Correo visible', 'webmaster-tijuana' ), 'email', 'sanitize_email' ),
		'direccion' => array( __( 'Dirección', 'webmaster-tijuana' ), 'text', 'sanitize_text_field' ),
		'horario'   => array( __( 'Horario', 'webmaster-tijuana' ), 'text', 'sanitize_text_field' ),
	);
	foreach ( $campos as $key => $c ) {
		wmt_add_setting( $wp_customize, $key, $defaults[ $key ], $c[2] );
		$wp_customize->add_control( 'wmt_' . $key, array( 'label' => $c[0], 'type' => $c[1], 'section' => 'wmt_contacto' ) );
	}

	/* --- Redes --- */
	$wp_customize->add_section( 'wmt_redes', array( 'title' => __( 'Redes sociales', 'webmaster-tijuana' ), 'panel' => 'wmt_panel', 'description' => __( 'Deja vacío lo que no uses; no se mostrará.', 'webmaster-tijuana' ) ) );
	foreach ( array( 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'tiktok' => 'TikTok', 'youtube' => 'YouTube' ) as $key => $label ) {
		wmt_add_setting( $wp_customize, $key, '', 'esc_url_raw' );
		$wp_customize->add_control( 'wmt_' . $key, array( 'label' => $label, 'type' => 'url', 'section' => 'wmt_redes' ) );
	}

	/* --- Slider --- */
	$wp_customize->add_section( 'wmt_slider', array( 'title' => __( 'Slider del inicio', 'webmaster-tijuana' ), 'panel' => 'wmt_panel', 'description' => __( 'Deja el título vacío para ocultar un slide.', 'webmaster-tijuana' ) ) );
	foreach ( wmt_slide_defaults() as $i => $d ) {
		wmt_add_setting( $wp_customize, "slide{$i}_titulo", $d['titulo'], 'sanitize_text_field' );
		$wp_customize->add_control( "wmt_slide{$i}_titulo", array( 'label' => sprintf( __( 'Slide %d — título', 'webmaster-tijuana' ), $i ), 'section' => 'wmt_slider' ) );

		wmt_add_setting( $wp_customize, "slide{$i}_texto", $d['texto'], 'sanitize_textarea_field' );
		$wp_customize->add_control( "wmt_slide{$i}_texto", array( 'label' => sprintf( __( 'Slide %d — texto', 'webmaster-tijuana' ), $i ), 'type' => 'textarea', 'section' => 'wmt_slider' ) );

		wmt_add_setting( $wp_customize, "slide{$i}_tags", $d['tags'], 'sanitize_text_field' );
		$wp_customize->add_control( "wmt_slide{$i}_tags", array( 'label' => sprintf( __( 'Slide %d — etiquetas (separadas por coma)', 'webmaster-tijuana' ), $i ), 'section' => 'wmt_slider' ) );

		wmt_add_setting( $wp_customize, "slide{$i}_imagen", 0, 'absint' );
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				"wmt_slide{$i}_imagen",
				array(
					'label'     => sprintf( __( 'Slide %d — imagen (2:1)', 'webmaster-tijuana' ), $i ),
					'section'   => 'wmt_slider',
					'mime_type' => 'image',
				)
			)
		);
	}

	/* --- Formulario y textos --- */
	$wp_customize->add_section( 'wmt_textos', array( 'title' => __( 'Formulario y textos', 'webmaster-tijuana' ), 'panel' => 'wmt_panel' ) );

	wmt_add_setting( $wp_customize, 'form_destino', $defaults['form_destino'], 'sanitize_email' );
	$wp_customize->add_control( 'wmt_form_destino', array( 'label' => __( 'Correo que recibe las cotizaciones', 'webmaster-tijuana' ), 'type' => 'email', 'section' => 'wmt_textos' ) );

	wmt_add_setting( $wp_customize, 'cta_titulo', $defaults['cta_titulo'], 'sanitize_text_field' );
	$wp_customize->add_control( 'wmt_cta_titulo', array( 'label' => __( 'Título de la sección de cotización', 'webmaster-tijuana' ), 'section' => 'wmt_textos' ) );

	wmt_add_setting( $wp_customize, 'cta_texto', $defaults['cta_texto'], 'sanitize_textarea_field' );
	$wp_customize->add_control( 'wmt_cta_texto', array( 'label' => __( 'Texto de la sección de cotización', 'webmaster-tijuana' ), 'type' => 'textarea', 'section' => 'wmt_textos' ) );

	wmt_add_setting( $wp_customize, 'footer_texto', $defaults['footer_texto'], 'sanitize_textarea_field' );
	$wp_customize->add_control( 'wmt_footer_texto', array( 'label' => __( 'Texto del pie de página', 'webmaster-tijuana' ), 'type' => 'textarea', 'section' => 'wmt_textos' ) );
}
add_action( 'customize_register', 'wmt_customize_register' );

function wmt_add_setting( $wp_customize, $key, $default, $sanitize ) {
	$wp_customize->add_setting(
		'wmt_' . $key,
		array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		)
	);
}

function wmt_sanitize_digits( $value ) {
	return preg_replace( '/\D+/', '', (string) $value );
}
