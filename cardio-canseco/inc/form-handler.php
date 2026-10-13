<?php
/**
 * Procesamiento del formulario de solicitud de cita.
 *
 * No guarda datos clínicos: sólo envía por correo la solicitud de contacto.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Atiende el envío del formulario.
 */
function cardio_handle_form() {
	if ( ! isset( $_POST['cardio_form'] ) ) {
		return;
	}

	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	// Verificación de origen.
	if ( ! isset( $_POST['cardio_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cardio_nonce'] ) ), 'cardio_cita' ) ) {
		wp_safe_redirect( add_query_arg( 'cita', 'error', $redirect ) );
		exit;
	}

	// Trampa antispam: campo oculto que un humano deja vacío.
	if ( ! empty( $_POST['cardio_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'cita', 'ok', $redirect ) );
		exit;
	}

	$nombre   = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$telefono = isset( $_POST['telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) ) : '';
	$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$estudio  = isset( $_POST['estudio'] ) ? sanitize_text_field( wp_unslash( $_POST['estudio'] ) ) : '';
	$fecha    = isset( $_POST['fecha'] ) ? sanitize_text_field( wp_unslash( $_POST['fecha'] ) ) : '';
	$mensaje  = isset( $_POST['mensaje'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensaje'] ) ) : '';
	$consent  = ! empty( $_POST['consent'] );

	if ( '' === $nombre || '' === $telefono || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'cita', 'incompleto', $redirect ) );
		exit;
	}

	$destino = cardio_opt( 'form_email' );
	if ( ! is_email( $destino ) ) {
		$destino = get_option( 'admin_email' );
	}

	$asunto = sprintf(
		/* translators: %s: nombre del paciente. */
		__( 'Solicitud de cita — %s', 'cardio-canseco' ),
		$nombre
	);

	$cuerpo  = __( 'Nueva solicitud de cita desde el sitio web.', 'cardio-canseco' ) . "\n\n";
	$cuerpo .= __( 'Nombre:', 'cardio-canseco' ) . ' ' . $nombre . "\n";
	$cuerpo .= __( 'Teléfono:', 'cardio-canseco' ) . ' ' . $telefono . "\n";
	if ( $email ) {
		$cuerpo .= __( 'Correo:', 'cardio-canseco' ) . ' ' . $email . "\n";
	}
	if ( $estudio ) {
		$cuerpo .= __( 'Estudio de interés:', 'cardio-canseco' ) . ' ' . $estudio . "\n";
	}
	if ( $fecha ) {
		$cuerpo .= __( 'Fecha preferida:', 'cardio-canseco' ) . ' ' . $fecha . "\n";
	}
	if ( $mensaje ) {
		$cuerpo .= "\n" . __( 'Mensaje:', 'cardio-canseco' ) . "\n" . $mensaje . "\n";
	}
	$cuerpo .= "\n---\n" . __( 'Enviado desde', 'cardio-canseco' ) . ' ' . home_url( '/' ) . "\n";
	$cuerpo .= __( 'Fecha de envío:', 'cardio-canseco' ) . ' ' . current_time( 'd/m/Y H:i' ) . "\n";

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $email ) {
		$headers[] = 'Reply-To: ' . $nombre . ' <' . $email . '>';
	}

	$enviado = wp_mail( $destino, $asunto, $cuerpo, $headers );

	wp_safe_redirect( add_query_arg( 'cita', $enviado ? 'ok' : 'error', $redirect ) );
	exit;
}
add_action( 'template_redirect', 'cardio_handle_form' );

/**
 * Mensaje de resultado que se muestra sobre el formulario.
 */
function cardio_form_notice() {
	if ( ! isset( $_GET['cita'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	$estado = sanitize_key( wp_unslash( $_GET['cita'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	$mensajes = array(
		'ok'         => array( 'ok', __( 'Gracias. Recibimos su solicitud y nos comunicaremos con usted para confirmar la cita. Si necesita atención inmediata, llame al consultorio.', 'cardio-canseco' ) ),
		'incompleto' => array( 'error', __( 'Faltan datos obligatorios. Complete su nombre, su teléfono y acepte el aviso de privacidad.', 'cardio-canseco' ) ),
		'error'      => array( 'error', __( 'No fue posible enviar la solicitud. Por favor llámenos o escríbanos por WhatsApp.', 'cardio-canseco' ) ),
	);

	if ( ! isset( $mensajes[ $estado ] ) ) {
		return;
	}

	list( $tipo, $texto ) = $mensajes[ $estado ];
	$borde = ( 'ok' === $tipo ) ? 'var(--blue-500)' : 'var(--crimson-500)';

	printf(
		'<p class="note-box" role="status" tabindex="-1" style="border-left-color:%s;margin-bottom:1.5rem">%s</p>',
		esc_attr( $borde ),
		esc_html( $texto )
	);
}
