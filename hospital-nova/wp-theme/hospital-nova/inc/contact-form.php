<?php
/**
 * Formulario de captación de pacientes.
 * - Envía cada solicitud por wp_mail() al correo configurado (por defecto info@hospitalnova.com).
 * - Guarda una copia como "Solicitud" en el admin (respaldo si el correo falla).
 * - Protección: nonce, honeypot, tiempo mínimo de llenado y límite por IP.
 * Recomendado: instalar un plugin SMTP (WP Mail SMTP / FluentSMTP) para asegurar la entrega.
 *
 * @package hospital-nova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_post_type( 'nova_lead', array(
		'labels'          => array( 'name' => 'Solicitudes', 'singular_name' => 'Solicitud', 'menu_name' => 'Solicitudes / Leads' ),
		'public'          => false,
		'show_ui'         => true,
		'menu_icon'       => 'dashicons-email-alt',
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

function nova_form_services() {
	$list = array();
	foreach ( nova_specialties() as $s ) {
		$list[ $s['key'] ] = 'en' === nova_lang() ? $s['en'][0] : $s['es'][0];
	}
	$list['laboratorio'] = nova_t( 'Laboratorio / Rayos X', 'Lab / X-ray' );
	$list['otro']        = nova_t( 'Otro / No estoy seguro', 'Other / Not sure' );
	return $list;
}

add_shortcode( 'nova_contact_form', function () {
	$status = isset( $_GET['nova_form'] ) ? sanitize_key( wp_unslash( $_GET['nova_form'] ) ) : '';
	$pre    = isset( $_GET['esp'] ) ? sanitize_key( wp_unslash( $_GET['esp'] ) ) : '';
	ob_start();
	?>
	<form class="nova-form reveal" id="cita" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<h3><?php echo esc_html( nova_t( 'Agenda tu cita', 'Book your appointment' ) ); ?></h3>
		<p class="lead" style="font-size:1rem"><?php echo esc_html( nova_t( 'Déjanos tus datos y un asesor de Hospital Nova te contactará muy pronto para confirmar tu cita.', 'Leave your details and we will contact you shortly.' ) ); ?></p>
		<?php if ( 'ok' === $status ) : ?>
			<div class="form-msg form-msg--ok" role="status"><?php echo esc_html( nova_t( '¡Gracias! Recibimos tu solicitud y te contactaremos muy pronto.', 'Thank you! We received your request and will contact you very soon.' ) ); ?></div>
		<?php elseif ( 'error' === $status ) : ?>
			<div class="form-msg form-msg--err" role="alert"><?php echo esc_html( nova_t( 'No pudimos enviar tu solicitud. Revisa los campos o escríbenos por WhatsApp.', 'We could not send your request. Please check the fields or message us on WhatsApp.' ) ); ?></div>
		<?php endif; ?>
		<input type="hidden" name="action" value="nova_contact">
		<input type="hidden" name="nova_lang" value="<?php echo esc_attr( nova_lang() ); ?>">
		<input type="hidden" name="nova_ts" value="<?php echo esc_attr( time() ); ?>">
		<input type="hidden" name="nova_ref" value="<?php echo esc_url( get_permalink() ? get_permalink() : home_url( '/' ) ); ?>">
		<?php wp_nonce_field( 'nova_contact', 'nova_nonce' ); ?>
		<div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
		<div class="row">
			<div class="field"><label for="nf-name"><?php echo esc_html( nova_t( 'Nombre completo', 'Full name' ) ); ?> *</label><input id="nf-name" name="name" required autocomplete="name" maxlength="120"></div>
			<div class="field"><label for="nf-phone"><?php echo esc_html( nova_t( 'Teléfono / WhatsApp', 'Phone / WhatsApp' ) ); ?> *</label><input id="nf-phone" name="phone" type="tel" required autocomplete="tel" maxlength="30"></div>
		</div>
		<div class="row">
			<div class="field"><label for="nf-email"><?php echo esc_html( nova_t( 'Correo electrónico', 'Email' ) ); ?></label><input id="nf-email" name="email" type="email" autocomplete="email" maxlength="120"></div>
			<div class="field"><label for="nf-service"><?php echo esc_html( nova_t( 'Servicio de interés', 'Service of interest' ) ); ?></label>
				<select id="nf-service" name="service">
					<?php foreach ( nova_form_services() as $k => $label ) : ?>
						<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $pre, $k ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="field"><label for="nf-msg"><?php echo esc_html( nova_t( '¿Cómo podemos ayudarte?', 'How can we help you?' ) ); ?></label><textarea id="nf-msg" name="message" maxlength="2000"></textarea></div>
		<label class="consent"><input type="checkbox" name="consent" value="1" required> <span><?php echo esc_html( nova_t( 'Acepto el aviso de privacidad y que Hospital Nova me contacte sobre mi solicitud.', 'I accept the privacy notice and agree to be contacted by Hospital Nova about my request.' ) ); ?></span></label>
		<button class="btn btn--primary" type="submit" data-magnetic><?php echo nova_icon( 'calendar' ); ?><?php echo esc_html( nova_t( 'Solicitar cita', 'Request appointment' ) ); ?></button>
	</form>
	<?php
	return ob_get_clean();
} );

add_action( 'admin_post_nopriv_nova_contact', 'nova_handle_contact' );
add_action( 'admin_post_nova_contact', 'nova_handle_contact' );

function nova_handle_contact() {
	$ref  = isset( $_POST['nova_ref'] ) ? esc_url_raw( wp_unslash( $_POST['nova_ref'] ) ) : home_url( '/' );
	$ref  = wp_validate_redirect( $ref, home_url( '/' ) );
	$back = function ( $s ) use ( $ref ) {
		wp_safe_redirect( add_query_arg( 'nova_form', $s, $ref ) . '#cita' );
		exit;
	};

	if ( ! isset( $_POST['nova_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nova_nonce'] ) ), 'nova_contact' ) ) {
		$back( 'error' );
	}
	// Honeypot y tiempo mínimo (bots).
	if ( ! empty( $_POST['website'] ) || ( time() - absint( isset( $_POST['nova_ts'] ) ? $_POST['nova_ts'] : 0 ) ) < 3 ) {
		$back( 'ok' );
	}
	// Límite: 5 envíos por IP cada 10 minutos.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key = 'nova_rl_' . md5( $ip );
	$n   = (int) get_transient( $key );
	if ( $n >= 5 ) {
		$back( 'error' );
	}
	set_transient( $key, $n + 1, 10 * MINUTE_IN_SECONDS );

	$name    = sanitize_text_field( wp_unslash( isset( $_POST['name'] ) ? $_POST['name'] : '' ) );
	$phone   = sanitize_text_field( wp_unslash( isset( $_POST['phone'] ) ? $_POST['phone'] : '' ) );
	$email   = sanitize_email( wp_unslash( isset( $_POST['email'] ) ? $_POST['email'] : '' ) );
	$service = sanitize_key( wp_unslash( isset( $_POST['service'] ) ? $_POST['service'] : '' ) );
	$msg     = sanitize_textarea_field( wp_unslash( isset( $_POST['message'] ) ? $_POST['message'] : '' ) );
	$lang    = sanitize_key( wp_unslash( isset( $_POST['nova_lang'] ) ? $_POST['nova_lang'] : 'es' ) );
	$consent = ! empty( $_POST['consent'] );

	if ( '' === $name || strlen( preg_replace( '/\D/', '', $phone ) ) < 7 || ! $consent ) {
		$back( 'error' );
	}

	$services = nova_form_services();
	$svc      = isset( $services[ $service ] ) ? $services[ $service ] : $service;
	$body     = "Nueva solicitud desde el sitio web de Hospital Nova\n\n"
		. "Nombre: {$name}\nTeléfono: {$phone}\nCorreo: {$email}\nServicio: {$svc}\nIdioma: " . strtoupper( $lang ) . "\nPágina: {$ref}\n\nMensaje:\n{$msg}\n\n"
		. 'Fecha: ' . wp_date( 'Y-m-d H:i' ) . "\n";

	$to      = nova_opt( 'email_to' );
	$subject = sprintf( '[Hospital Nova] Nueva cita: %s — %s', $svc, $name );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $email ) {
		$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	}
	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_insert_post( array(
		'post_type'    => 'nova_lead',
		'post_status'  => 'private',
		'post_title'   => $name . ' — ' . $svc . ( $sent ? '' : ' (correo NO enviado)' ),
		'post_content' => $body,
	) );

	$back( 'ok' );
}
