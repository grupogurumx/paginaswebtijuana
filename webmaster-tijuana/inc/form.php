<?php
/**
 * Formulario de cotización: guarda cada solicitud en el escritorio y avisa por correo.
 *
 * @package WebmasterTijuana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wmt_handle_cotizacion() {
	$volver = isset( $_POST['wmt_volver'] ) ? esc_url_raw( wp_unslash( $_POST['wmt_volver'] ) ) : home_url( '/' );
	$volver = wp_validate_redirect( $volver, home_url( '/' ) );
	$volver = remove_query_arg( 'wmt_estado', $volver );

	$fallar = function ( $codigo ) use ( $volver ) {
		wp_safe_redirect( add_query_arg( 'wmt_estado', $codigo, $volver ) . '#cotizar' );
		exit;
	};

	if ( ! isset( $_POST['wmt_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['wmt_nonce'] ), 'wmt_cotizacion' ) ) {
		$fallar( 'caducado' );
	}

	// Trampa para robots: un humano nunca ve ni llena este campo.
	if ( ! empty( $_POST['wmt_sitio_web'] ) ) {
		wp_safe_redirect( add_query_arg( 'wmt_estado', 'ok', $volver ) . '#cotizar' );
		exit;
	}

	$nombre   = isset( $_POST['wmt_nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['wmt_nombre'] ) ) : '';
	$email    = isset( $_POST['wmt_email'] ) ? sanitize_email( wp_unslash( $_POST['wmt_email'] ) ) : '';
	$telefono = isset( $_POST['wmt_telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['wmt_telefono'] ) ) : '';
	$servicio = isset( $_POST['wmt_servicio'] ) ? sanitize_text_field( wp_unslash( $_POST['wmt_servicio'] ) ) : '';
	$mensaje  = isset( $_POST['wmt_mensaje'] ) ? sanitize_textarea_field( wp_unslash( $_POST['wmt_mensaje'] ) ) : '';
	$acepta   = ! empty( $_POST['wmt_privacidad'] );

	if ( '' === $nombre || ! is_email( $email ) || '' === $telefono || '' === $mensaje || ! $acepta ) {
		$fallar( 'incompleto' );
	}

	// Un envío por minuto desde la misma IP.
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$clave = 'wmt_form_' . md5( $ip );
	if ( $ip && get_transient( $clave ) ) {
		$fallar( 'espera' );
	}
	set_transient( $clave, 1, MINUTE_IN_SECONDS );

	$origen = wp_get_referer() ? wp_get_referer() : $volver;

	$id = wp_insert_post(
		array(
			'post_type'    => 'solicitud',
			'post_status'  => 'private',
			'post_title'   => $nombre,
			'post_content' => $mensaje,
		)
	);

	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, '_wmt_nombre', $nombre );
		update_post_meta( $id, '_wmt_email', $email );
		update_post_meta( $id, '_wmt_telefono', $telefono );
		update_post_meta( $id, '_wmt_servicio', $servicio );
		update_post_meta( $id, '_wmt_origen', esc_url_raw( $origen ) );
	}

	$destino = wmt_opt( 'form_destino' );
	$destino = is_email( $destino ) ? $destino : get_option( 'admin_email' );

	$asunto = sprintf( '[%s] Nueva cotización: %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $servicio ? $servicio : $nombre );
	$cuerpo = implode(
		"\n",
		array(
			'Nombre: ' . $nombre,
			'Correo: ' . $email,
			'Teléfono: ' . $telefono,
			'Servicio: ' . ( $servicio ? $servicio : '—' ),
			'',
			'Mensaje:',
			$mensaje,
			'',
			'Enviado desde: ' . $origen,
		)
	);
	$headers = array( 'Reply-To: ' . $nombre . ' <' . $email . '>' );

	$enviado = wp_mail( $destino, $asunto, $cuerpo, $headers );
	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, '_wmt_correo', $enviado ? 'Enviado a ' . $destino : 'No se pudo enviar (revisa la configuración de correo)' );
	}

	// La solicitud queda guardada aunque el correo falle, así que para el
	// visitante el envío fue correcto.
	wp_safe_redirect( add_query_arg( 'wmt_estado', 'ok', $volver ) . '#cotizar' );
	exit;
}
add_action( 'admin_post_nopriv_wmt_cotizacion', 'wmt_handle_cotizacion' );
add_action( 'admin_post_wmt_cotizacion', 'wmt_handle_cotizacion' );

/**
 * Mensaje de estado tras enviar.
 */
function wmt_form_notice() {
	if ( empty( $_GET['wmt_estado'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$estado   = sanitize_key( $_GET['wmt_estado'] ); // phpcs:ignore WordPress.Security.NonceVerification
	$mensajes = array(
		'ok'         => array( 'success', __( '¡Gracias! Recibimos tu solicitud y te contactaremos en menos de un día hábil.', 'webmaster-tijuana' ) ),
		'incompleto' => array( 'error', __( 'Revisa que hayas llenado todos los campos y aceptado el aviso de privacidad.', 'webmaster-tijuana' ) ),
		'espera'     => array( 'error', __( 'Acabamos de recibir un mensaje desde tu conexión. Intenta de nuevo en un minuto.', 'webmaster-tijuana' ) ),
		'caducado'   => array( 'error', __( 'La página estuvo abierta mucho tiempo. Recárgala y vuelve a enviar el formulario.', 'webmaster-tijuana' ) ),
	);
	if ( ! isset( $mensajes[ $estado ] ) ) {
		return;
	}
	printf(
		'<div class="form-notice form-notice--%1$s" role="%2$s">%3$s</div>',
		esc_attr( $mensajes[ $estado ][0] ),
		'success' === $mensajes[ $estado ][0] ? 'status' : 'alert',
		esc_html( $mensajes[ $estado ][1] )
	);
}

/**
 * Opciones del selector de servicio.
 */
function wmt_form_servicios() {
	$titulos = get_posts(
		array(
			'post_type'      => 'servicio',
			'posts_per_page' => 20,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'fields'         => 'ids',
		)
	);
	$out = array();
	foreach ( $titulos as $id ) {
		$out[] = get_the_title( $id );
	}
	$out[] = __( 'Otro servicio', 'webmaster-tijuana' );
	return $out;
}
