<?php
/**
 * Tipo de contenido «Procedimiento» y sus campos.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra el tipo de contenido.
 */
function cardio_register_cpt() {
	register_post_type(
		'procedimiento',
		array(
			'labels'        => array(
				'name'               => __( 'Procedimientos', 'cardio-canseco' ),
				'singular_name'      => __( 'Procedimiento', 'cardio-canseco' ),
				'add_new'            => __( 'Añadir procedimiento', 'cardio-canseco' ),
				'add_new_item'       => __( 'Añadir nuevo procedimiento', 'cardio-canseco' ),
				'edit_item'          => __( 'Editar procedimiento', 'cardio-canseco' ),
				'new_item'           => __( 'Nuevo procedimiento', 'cardio-canseco' ),
				'view_item'          => __( 'Ver procedimiento', 'cardio-canseco' ),
				'search_items'       => __( 'Buscar procedimientos', 'cardio-canseco' ),
				'not_found'          => __( 'No hay procedimientos', 'cardio-canseco' ),
				'not_found_in_trash' => __( 'No hay procedimientos en la papelera', 'cardio-canseco' ),
				'all_items'          => __( 'Todos los procedimientos', 'cardio-canseco' ),
				'menu_name'          => __( 'Procedimientos', 'cardio-canseco' ),
			),
			'public'        => true,
			'has_archive'   => 'procedimientos',
			'rewrite'       => array( 'slug' => 'procedimientos', 'with_front' => false ),
			'menu_icon'     => 'dashicons-heart',
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'custom-fields' ),
			'show_in_rest'  => true,
			'hierarchical'  => false,
		)
	);
}
add_action( 'init', 'cardio_register_cpt' );

/**
 * Refresca los enlaces permanentes una sola vez tras activar el tema.
 */
function cardio_flush_rewrite() {
	if ( ! get_option( 'cardio_rewrite_flushed' ) ) {
		cardio_register_cpt();
		flush_rewrite_rules();
		update_option( 'cardio_rewrite_flushed', 1 );
	}
}
add_action( 'after_switch_theme', 'cardio_flush_rewrite' );

/* -------------------------------------------------------------------------
 * Campos adicionales del procedimiento
 * ---------------------------------------------------------------------- */

/**
 * Definición de los campos.
 */
function cardio_proc_fields() {
	return array(
		'_cardio_lead'       => array(
			'label' => __( 'Frase de entrada', 'cardio-canseco' ),
			'type'  => 'textarea',
			'desc'  => __( 'Aparece bajo el título, en la cabecera de la página y en la tarjeta del listado.', 'cardio-canseco' ),
		),
		'_cardio_duracion'   => array(
			'label' => __( 'Duración estimada', 'cardio-canseco' ),
			'type'  => 'text',
			'desc'  => __( 'Por ejemplo: 20 a 40 minutos.', 'cardio-canseco' ),
		),
		'_cardio_indica'     => array(
			'label' => __( 'Cuándo se indica', 'cardio-canseco' ),
			'type'  => 'textarea',
			'desc'  => __( 'Un motivo por línea.', 'cardio-canseco' ),
		),
		'_cardio_como'       => array(
			'label' => __( 'Cómo se realiza', 'cardio-canseco' ),
			'type'  => 'textarea',
			'desc'  => __( 'Un paso por línea. Se muestran numerados.', 'cardio-canseco' ),
		),
		'_cardio_prep'       => array(
			'label' => __( 'Cómo prepararse', 'cardio-canseco' ),
			'type'  => 'textarea',
			'desc'  => __( 'Una indicación por línea.', 'cardio-canseco' ),
		),
		'_cardio_faq'        => array(
			'label' => __( 'Preguntas frecuentes', 'cardio-canseco' ),
			'type'  => 'textarea',
			'desc'  => __( 'Formato: la pregunta en una línea y la respuesta en la siguiente, separando cada par con una línea en blanco.', 'cardio-canseco' ),
		),
	);
}

/**
 * Añade la caja de campos.
 */
function cardio_proc_metabox() {
	add_meta_box(
		'cardio_proc_detalle',
		__( 'Detalle del procedimiento', 'cardio-canseco' ),
		'cardio_proc_metabox_render',
		'procedimiento',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cardio_proc_metabox' );

/**
 * Dibuja la caja.
 *
 * @param WP_Post $post Entrada actual.
 */
function cardio_proc_metabox_render( $post ) {
	wp_nonce_field( 'cardio_proc_save', 'cardio_proc_nonce' );
	echo '<style>.cardio-field{margin:0 0 18px}.cardio-field label{display:block;font-weight:600;margin-bottom:4px}.cardio-field .description{margin:4px 0 0}.cardio-field input,.cardio-field textarea{width:100%}</style>';

	foreach ( cardio_proc_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<div class="cardio-field">';
		printf( '<label for="%1$s">%2$s</label>', esc_attr( $key ), esc_html( $field['label'] ) );

		if ( 'textarea' === $field['type'] ) {
			printf(
				'<textarea id="%1$s" name="%1$s" rows="6">%2$s</textarea>',
				esc_attr( $key ),
				esc_textarea( $value )
			);
		} else {
			printf(
				'<input type="text" id="%1$s" name="%1$s" value="%2$s">',
				esc_attr( $key ),
				esc_attr( $value )
			);
		}

		if ( ! empty( $field['desc'] ) ) {
			printf( '<p class="description">%s</p>', esc_html( $field['desc'] ) );
		}
		echo '</div>';
	}
}

/**
 * Guarda los campos.
 *
 * @param int $post_id Identificador.
 */
function cardio_proc_save( $post_id ) {
	if ( ! isset( $_POST['cardio_proc_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cardio_proc_nonce'] ) ), 'cardio_proc_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( cardio_proc_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $key ] );
		$val = ( 'textarea' === $field['type'] )
			? sanitize_textarea_field( $raw )
			: sanitize_text_field( $raw );

		if ( '' === $val ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $val );
		}
	}
}
add_action( 'save_post_procedimiento', 'cardio_proc_save' );

/**
 * Convierte un campo de líneas en un array limpio.
 *
 * @param int    $post_id Identificador.
 * @param string $key     Clave del metadato.
 * @return array
 */
function cardio_lines( $post_id, $key ) {
	$raw = get_post_meta( $post_id, $key, true );
	if ( ! $raw ) {
		return array();
	}
	$lines = preg_split( '/\r\n|\r|\n/', $raw );
	return array_values( array_filter( array_map( 'trim', $lines ) ) );
}

/**
 * Interpreta el campo de preguntas frecuentes.
 *
 * @param int $post_id Identificador.
 * @return array Lista de arrays con «q» y «a».
 */
function cardio_faq_pairs( $post_id ) {
	$raw = get_post_meta( $post_id, '_cardio_faq', true );
	if ( ! $raw ) {
		return array();
	}

	$blocks = preg_split( '/\n\s*\n/', trim( str_replace( "\r\n", "\n", $raw ) ) );
	$out    = array();

	foreach ( $blocks as $block ) {
		$lines = array_values( array_filter( array_map( 'trim', explode( "\n", $block ) ) ) );
		if ( count( $lines ) < 2 ) {
			continue;
		}
		$out[] = array(
			'q' => array_shift( $lines ),
			'a' => implode( ' ', $lines ),
		);
	}

	return $out;
}

/**
 * Ordena el archivo de procedimientos por el orden que fije el cliente.
 *
 * @param WP_Query $query Consulta.
 */
function cardio_proc_order( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'procedimiento' ) ) {
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
		$query->set( 'posts_per_page', 20 );
	}
}
add_action( 'pre_get_posts', 'cardio_proc_order' );
