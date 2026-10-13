<?php
/**
 * Personalizador: todos los datos del consultorio en un solo panel.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra los ajustes.
 *
 * @param WP_Customize_Manager $wp_customize Gestor del personalizador.
 */
function cardio_customize_register( $wp_customize ) {

	$defaults = cardio_defaults();

	$wp_customize->add_panel(
		'cardio_panel',
		array(
			'title'       => __( 'Cardiología: datos del consultorio', 'cardio-canseco' ),
			'description' => __( 'Cambie aquí el teléfono, la dirección, las redes y los textos del inicio. Se actualizan en toda la web y en los datos que lee Google.', 'cardio-canseco' ),
			'priority'    => 20,
		)
	);

	/**
	 * Helper para dar de alta un campo de texto.
	 *
	 * @param string $id      Clave sin prefijo.
	 * @param string $section Sección.
	 * @param string $label   Etiqueta.
	 * @param string $type    Tipo de control.
	 * @param string $desc    Descripción.
	 */
	$add = function ( $id, $section, $label, $type = 'text', $desc = '' ) use ( $wp_customize, $defaults ) {
		$sanitize = 'sanitize_text_field';
		if ( 'url' === $type ) {
			$sanitize = 'esc_url_raw';
		} elseif ( 'email' === $type ) {
			$sanitize = 'sanitize_email';
		} elseif ( 'textarea' === $type ) {
			$sanitize = 'wp_kses_post';
		}

		$wp_customize->add_setting(
			'cardio_' . $id,
			array(
				'default'           => isset( $defaults[ $id ] ) ? $defaults[ $id ] : '',
				'sanitize_callback' => $sanitize,
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'cardio_' . $id,
			array(
				'label'       => $label,
				'section'     => $section,
				'type'        => ( 'textarea' === $type ) ? 'textarea' : ( 'url' === $type ? 'url' : ( 'email' === $type ? 'email' : 'text' ) ),
				'description' => $desc,
			)
		);
	};

	/* --------------------------------------------------------------------
	 * Contacto
	 * ----------------------------------------------------------------- */
	$wp_customize->add_section(
		'cardio_contacto',
		array(
			'title' => __( 'Contacto', 'cardio-canseco' ),
			'panel' => 'cardio_panel',
		)
	);

	$add( 'medico', 'cardio_contacto', __( 'Nombre del médico', 'cardio-canseco' ) );
	$add( 'tel', 'cardio_contacto', __( 'Teléfono visible', 'cardio-canseco' ), 'text', __( 'Como se muestra: +52 (664) 416 2551', 'cardio-canseco' ) );
	$add( 'tel_link', 'cardio_contacto', __( 'Teléfono para marcar', 'cardio-canseco' ), 'text', __( 'Sólo dígitos con lada país: +526644162551', 'cardio-canseco' ) );
	$add( 'whatsapp', 'cardio_contacto', __( 'WhatsApp', 'cardio-canseco' ), 'text', __( 'Sólo dígitos, con lada país y sin signos: 526644162551', 'cardio-canseco' ) );
	$add( 'wa_msg', 'cardio_contacto', __( 'Mensaje predefinido de WhatsApp', 'cardio-canseco' ) );
	$add( 'email', 'cardio_contacto', __( 'Correo público', 'cardio-canseco' ), 'email' );
	$add( 'form_email', 'cardio_contacto', __( 'Correo que recibe el formulario', 'cardio-canseco' ), 'email', __( 'A esta dirección llegan las solicitudes de cita.', 'cardio-canseco' ) );

	/* --------------------------------------------------------------------
	 * Ubicación
	 * ----------------------------------------------------------------- */
	$wp_customize->add_section(
		'cardio_ubicacion',
		array(
			'title'       => __( 'Ubicación y horarios', 'cardio-canseco' ),
			'panel'       => 'cardio_panel',
			'description' => __( 'Para las coordenadas: en Google Maps, clic derecho sobre el consultorio y copie latitud y longitud.', 'cardio-canseco' ),
		)
	);

	$add( 'calle', 'cardio_ubicacion', __( 'Dirección, línea 1', 'cardio-canseco' ) );
	$add( 'calle2', 'cardio_ubicacion', __( 'Dirección, línea 2', 'cardio-canseco' ) );
	$add( 'ciudad', 'cardio_ubicacion', __( 'Ciudad', 'cardio-canseco' ) );
	$add( 'estado', 'cardio_ubicacion', __( 'Estado', 'cardio-canseco' ) );
	$add( 'cp', 'cardio_ubicacion', __( 'Código postal', 'cardio-canseco' ) );
	$add( 'lat', 'cardio_ubicacion', __( 'Latitud', 'cardio-canseco' ) );
	$add( 'lng', 'cardio_ubicacion', __( 'Longitud', 'cardio-canseco' ) );
	$add( 'horario', 'cardio_ubicacion', __( 'Horario de atención', 'cardio-canseco' ), 'textarea', __( 'Escriba aquí el horario real del consultorio. Si atiende sólo con cita, déjelo indicado así.', 'cardio-canseco' ) );

	/* --------------------------------------------------------------------
	 * Redes sociales
	 * ----------------------------------------------------------------- */
	$wp_customize->add_section(
		'cardio_redes',
		array(
			'title'       => __( 'Redes sociales', 'cardio-canseco' ),
			'panel'       => 'cardio_panel',
			'description' => __( 'Los campos vacíos no muestran icono.', 'cardio-canseco' ),
		)
	);

	$add( 'facebook', 'cardio_redes', __( 'Facebook', 'cardio-canseco' ), 'url' );
	$add( 'instagram', 'cardio_redes', __( 'Instagram', 'cardio-canseco' ), 'url' );
	$add( 'google', 'cardio_redes', __( 'Ficha de Google', 'cardio-canseco' ), 'url', __( 'Enlace a su perfil de empresa en Google, para reseñas.', 'cardio-canseco' ) );

	/* --------------------------------------------------------------------
	 * Portada
	 * ----------------------------------------------------------------- */
	$wp_customize->add_section(
		'cardio_portada',
		array(
			'title'       => __( 'Portada: textos y slides', 'cardio-canseco' ),
			'panel'       => 'cardio_panel',
			'description' => __( 'Textos del bloque principal y las tres imágenes panorámicas que rotan detrás.', 'cardio-canseco' ),
		)
	);

	$add( 'hero_badge', 'cardio_portada', __( 'Distintivo superior', 'cardio-canseco' ), 'textarea' );
	$add( 'hero_titulo', 'cardio_portada', __( 'Título principal', 'cardio-canseco' ), 'textarea', __( 'Puede envolver palabras en &lt;span class="accent"&gt;…&lt;/span&gt; para resaltarlas en degradado.', 'cardio-canseco' ) );
	$add( 'hero_texto', 'cardio_portada', __( 'Párrafo de entrada', 'cardio-canseco' ), 'textarea' );
	$add( 'anios', 'cardio_portada', __( 'Años de experiencia', 'cardio-canseco' ) );
	$add( 'estudios', 'cardio_portada', __( 'Número de estudios ofrecidos', 'cardio-canseco' ) );

	// Tres imágenes del carrusel.
	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting(
			'cardio_slide_' . $i,
			array(
				'default'           => '',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'cardio_slide_' . $i,
				array(
					'label'       => sprintf( __( 'Imagen panorámica %d', 'cardio-canseco' ), $i ),
					'section'     => 'cardio_portada',
					'mime_type'   => 'image',
					'description' => ( 1 === $i ) ? __( 'Formato recomendado: 2400 × 1030 px (21:9). Si se deja vacía se usa la imagen incluida en el tema.', 'cardio-canseco' ) : '',
				)
			)
		);
	}

	/* --------------------------------------------------------------------
	 * Fotografía del médico
	 * ----------------------------------------------------------------- */
	$wp_customize->add_section(
		'cardio_medico',
		array(
			'title'       => __( 'Fotografía del médico', 'cardio-canseco' ),
			'panel'       => 'cardio_panel',
			'description' => __( 'La foto del especialista aparece en la portada (secciones «Por qué elegirnos» y «El especialista»), en «Nosotros» y en su página personal. Si sólo sube el retrato, se usa también donde va el recorte cuadrado.', 'cardio-canseco' ),
		)
	);

	$wp_customize->add_setting(
		'cardio_foto_retrato',
		array( 'default' => '', 'sanitize_callback' => 'absint' )
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'cardio_foto_retrato',
			array(
				'label'       => __( 'Retrato vertical', 'cardio-canseco' ),
				'section'     => 'cardio_medico',
				'mime_type'   => 'image',
				'description' => __( 'Proporción 3:4, mínimo 900 × 1200 px. Encuadre de medio cuerpo.', 'cardio-canseco' ),
			)
		)
	);

	$wp_customize->add_setting(
		'cardio_foto_busto',
		array( 'default' => '', 'sanitize_callback' => 'absint' )
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'cardio_foto_busto',
			array(
				'label'       => __( 'Retrato cuadrado', 'cardio-canseco' ),
				'section'     => 'cardio_medico',
				'mime_type'   => 'image',
				'description' => __( 'Proporción 1:1, mínimo 1000 × 1000 px. Encuadre cerrado. Opcional.', 'cardio-canseco' ),
			)
		)
	);

	/* --------------------------------------------------------------------
	 * Vista previa en vivo del título
	 * ----------------------------------------------------------------- */
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'cardio_hero_titulo',
			array(
				'selector'        => '.hero__title',
				'render_callback' => function () {
					return wp_kses_post( cardio_opt( 'hero_titulo' ) );
				},
			)
		);
	}
}
add_action( 'customize_register', 'cardio_customize_register' );

/**
 * Recarga la vista previa al cambiar ajustes.
 */
function cardio_customize_preview_js() {
	wp_enqueue_script(
		'cardio-customizer',
		CARDIO_URI . '/assets/js/main.js',
		array( 'customize-preview' ),
		CARDIO_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'cardio_customize_preview_js' );
