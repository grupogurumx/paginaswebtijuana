<?php
/**
 * Tipos de contenido: servicios, portafolio, testimonios y solicitudes.
 *
 * @package WebmasterTijuana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wmt_register_cpts() {
	register_post_type(
		'servicio',
		array(
			'labels'        => array(
				'name'          => __( 'Servicios', 'webmaster-tijuana' ),
				'singular_name' => __( 'Servicio', 'webmaster-tijuana' ),
				'add_new_item'  => __( 'Añadir servicio', 'webmaster-tijuana' ),
				'edit_item'     => __( 'Editar servicio', 'webmaster-tijuana' ),
				'all_items'     => __( 'Todos los servicios', 'webmaster-tijuana' ),
			),
			'public'        => true,
			'has_archive'   => 'servicios',
			'rewrite'       => array( 'slug' => 'servicios', 'with_front' => false ),
			'menu_icon'     => 'dashicons-admin-tools',
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'show_in_rest'  => true,
		)
	);

	register_post_type(
		'proyecto',
		array(
			'labels'        => array(
				'name'          => __( 'Portafolio', 'webmaster-tijuana' ),
				'singular_name' => __( 'Proyecto', 'webmaster-tijuana' ),
				'add_new_item'  => __( 'Añadir proyecto', 'webmaster-tijuana' ),
				'edit_item'     => __( 'Editar proyecto', 'webmaster-tijuana' ),
				'all_items'     => __( 'Todos los proyectos', 'webmaster-tijuana' ),
			),
			'public'        => true,
			'has_archive'   => 'portafolio',
			'rewrite'       => array( 'slug' => 'portafolio', 'with_front' => false ),
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 21,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'show_in_rest'  => true,
		)
	);

	register_post_type(
		'testimonio',
		array(
			'labels'              => array(
				'name'          => __( 'Testimonios', 'webmaster-tijuana' ),
				'singular_name' => __( 'Testimonio', 'webmaster-tijuana' ),
				'add_new_item'  => __( 'Añadir testimonio', 'webmaster-tijuana' ),
				'edit_item'     => __( 'Editar testimonio', 'webmaster-tijuana' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-format-quote',
			'menu_position'       => 22,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);

	register_post_type(
		'solicitud',
		array(
			'labels'              => array(
				'name'          => __( 'Cotizaciones', 'webmaster-tijuana' ),
				'singular_name' => __( 'Cotización', 'webmaster-tijuana' ),
				'edit_item'     => __( 'Ver cotización', 'webmaster-tijuana' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 23,
			'supports'            => array( 'title', 'editor' ),
			'capability_type'     => 'post',
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', 'wmt_register_cpts' );

/* -------------------------------------------------------------------------
 * Campos adicionales
 * ---------------------------------------------------------------------- */
function wmt_meta_boxes() {
	add_meta_box( 'wmt_servicio', __( 'Datos del servicio', 'webmaster-tijuana' ), 'wmt_servicio_box', 'servicio', 'normal', 'high' );
	add_meta_box( 'wmt_proyecto', __( 'Datos del proyecto', 'webmaster-tijuana' ), 'wmt_proyecto_box', 'proyecto', 'side' );
	add_meta_box( 'wmt_testimonio', __( 'Datos del cliente', 'webmaster-tijuana' ), 'wmt_testimonio_box', 'testimonio', 'side' );
	add_meta_box( 'wmt_solicitud', __( 'Datos de contacto', 'webmaster-tijuana' ), 'wmt_solicitud_box', 'solicitud', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'wmt_meta_boxes' );

function wmt_servicio_box( $post ) {
	wp_nonce_field( 'wmt_meta', 'wmt_meta_nonce' );
	$icono   = get_post_meta( $post->ID, '_wmt_icono', true );
	$incluye = get_post_meta( $post->ID, '_wmt_incluye', true );
	?>
	<p>
		<label for="wmt_icono"><strong><?php esc_html_e( 'Icono', 'webmaster-tijuana' ); ?></strong></label><br>
		<select name="wmt_icono" id="wmt_icono">
			<?php foreach ( wmt_service_icons() as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $icono, $key ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="wmt_incluye"><strong><?php esc_html_e( 'Qué incluye (uno por línea)', 'webmaster-tijuana' ); ?></strong></label>
		<textarea name="wmt_incluye" id="wmt_incluye" rows="7" class="widefat"><?php echo esc_textarea( $incluye ); ?></textarea>
	</p>
	<p class="description"><?php esc_html_e( 'El extracto se usa como descripción corta en las tarjetas.', 'webmaster-tijuana' ); ?></p>
	<?php
}

function wmt_proyecto_box( $post ) {
	wp_nonce_field( 'wmt_meta', 'wmt_meta_nonce' );
	?>
	<p><label><?php esc_html_e( 'Cliente', 'webmaster-tijuana' ); ?><br>
		<input type="text" class="widefat" name="wmt_cliente" value="<?php echo esc_attr( get_post_meta( $post->ID, '_wmt_cliente', true ) ); ?>"></label></p>
	<p><label><?php esc_html_e( 'Tipo de proyecto', 'webmaster-tijuana' ); ?><br>
		<input type="text" class="widefat" name="wmt_tipo" value="<?php echo esc_attr( get_post_meta( $post->ID, '_wmt_tipo', true ) ); ?>" placeholder="Sitio web, tienda virtual…"></label></p>
	<p><label><?php esc_html_e( 'URL del sitio', 'webmaster-tijuana' ); ?><br>
		<input type="url" class="widefat" name="wmt_url" value="<?php echo esc_attr( get_post_meta( $post->ID, '_wmt_url', true ) ); ?>"></label></p>
	<?php
}

function wmt_testimonio_box( $post ) {
	wp_nonce_field( 'wmt_meta', 'wmt_meta_nonce' );
	$estrellas = get_post_meta( $post->ID, '_wmt_estrellas', true );
	$estrellas = $estrellas ? (int) $estrellas : 5;
	?>
	<p><label><?php esc_html_e( 'Cargo o negocio', 'webmaster-tijuana' ); ?><br>
		<input type="text" class="widefat" name="wmt_cargo" value="<?php echo esc_attr( get_post_meta( $post->ID, '_wmt_cargo', true ) ); ?>"></label></p>
	<p><label><?php esc_html_e( 'Calificación', 'webmaster-tijuana' ); ?><br>
		<select name="wmt_estrellas">
			<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
				<option value="<?php echo (int) $i; ?>" <?php selected( $estrellas, $i ); ?>><?php echo esc_html( str_repeat( '★', $i ) ); ?></option>
			<?php endfor; ?>
		</select></label></p>
	<p class="description"><?php esc_html_e( 'El título es el nombre del cliente y el contenido, su opinión. La imagen destacada es su foto (opcional).', 'webmaster-tijuana' ); ?></p>
	<?php
}

function wmt_solicitud_box( $post ) {
	$campos = array(
		'_wmt_nombre'   => __( 'Nombre', 'webmaster-tijuana' ),
		'_wmt_email'    => __( 'Correo', 'webmaster-tijuana' ),
		'_wmt_telefono' => __( 'Teléfono', 'webmaster-tijuana' ),
		'_wmt_servicio' => __( 'Servicio', 'webmaster-tijuana' ),
		'_wmt_origen'   => __( 'Enviada desde', 'webmaster-tijuana' ),
		'_wmt_correo'   => __( 'Aviso por correo', 'webmaster-tijuana' ),
	);
	echo '<dl>';
	foreach ( $campos as $key => $label ) {
		$valor = get_post_meta( $post->ID, $key, true );
		if ( '_wmt_email' === $key && $valor ) {
			$valor = '<a href="mailto:' . esc_attr( $valor ) . '">' . esc_html( $valor ) . '</a>';
		} elseif ( '_wmt_telefono' === $key && $valor ) {
			$valor = '<a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $valor ) ) . '">' . esc_html( $valor ) . '</a>';
		} else {
			$valor = esc_html( $valor );
		}
		printf( '<dt><strong>%s</strong></dt><dd style="margin:0 0 .6em">%s</dd>', esc_html( $label ), $valor ? $valor : '—' ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
	echo '</dl>';
}

function wmt_save_meta( $post_id ) {
	if ( ! isset( $_POST['wmt_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['wmt_meta_nonce'] ), 'wmt_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$map = array(
		'wmt_icono'     => array( '_wmt_icono', 'sanitize_key' ),
		'wmt_incluye'   => array( '_wmt_incluye', 'sanitize_textarea_field' ),
		'wmt_cliente'   => array( '_wmt_cliente', 'sanitize_text_field' ),
		'wmt_tipo'      => array( '_wmt_tipo', 'sanitize_text_field' ),
		'wmt_url'       => array( '_wmt_url', 'esc_url_raw' ),
		'wmt_cargo'     => array( '_wmt_cargo', 'sanitize_text_field' ),
		'wmt_estrellas' => array( '_wmt_estrellas', 'absint' ),
	);
	foreach ( $map as $field => $cfg ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $cfg[0], call_user_func( $cfg[1], wp_unslash( $_POST[ $field ] ) ) );
		}
	}
}
add_action( 'save_post', 'wmt_save_meta' );

/* -------------------------------------------------------------------------
 * Columnas del listado de cotizaciones
 * ---------------------------------------------------------------------- */
function wmt_solicitud_columns( $cols ) {
	return array(
		'cb'           => $cols['cb'],
		'title'        => __( 'Nombre', 'webmaster-tijuana' ),
		'wmt_contacto' => __( 'Contacto', 'webmaster-tijuana' ),
		'wmt_servicio' => __( 'Servicio', 'webmaster-tijuana' ),
		'date'         => $cols['date'],
	);
}
add_filter( 'manage_solicitud_posts_columns', 'wmt_solicitud_columns' );

function wmt_solicitud_column( $col, $post_id ) {
	if ( 'wmt_contacto' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_wmt_email', true ) ) . '<br>' . esc_html( get_post_meta( $post_id, '_wmt_telefono', true ) );
	} elseif ( 'wmt_servicio' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_wmt_servicio', true ) );
	}
}
add_action( 'manage_solicitud_posts_custom_column', 'wmt_solicitud_column', 10, 2 );

/**
 * Orden manual (campo «Orden») en servicios, portafolio y testimonios.
 */
function wmt_archive_order( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( array( 'servicio', 'proyecto' ) ) ) {
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'DESC' ) );
		$query->set( 'posts_per_page', 24 );
	}
}
add_action( 'pre_get_posts', 'wmt_archive_order' );
