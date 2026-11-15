<?php
/**
 * Helpers: idioma, opciones, íconos y datos de la marca.
 *
 * @package hospital-nova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Idioma actual: Polylang > WPML > locale. Español por defecto. */
function nova_lang() {
	if ( function_exists( 'pll_current_language' ) ) {
		$l = pll_current_language( 'slug' );
		if ( $l ) {
			return 'en' === $l ? 'en' : 'es';
		}
	}
	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		return 'en' === ICL_LANGUAGE_CODE ? 'en' : 'es';
	}
	return 0 === strpos( get_locale(), 'en' ) ? 'en' : 'es';
}

/** Texto bilingüe. */
function nova_t( $es, $en ) {
	return 'en' === nova_lang() ? $en : $es;
}

/** Opción del Customizer con valor por defecto. */
function nova_opt( $key ) {
	$defaults = nova_defaults();
	$val      = get_theme_mod( 'nova_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
	return '' === $val && isset( $defaults[ $key ] ) ? $defaults[ $key ] : $val;
}

function nova_defaults() {
	return array(
		'email_to'      => 'info@hospitalnova.com',
		'phone'         => '664 688 99 32',
		'whatsapp'      => '664 464 93 91',
		'phone_onco'    => '664 204 72 81',
		'address'       => 'Tijuana, Baja California, México',
		'maps_query'    => 'Hospital Nova Tijuana',
		'facebook'      => 'https://www.facebook.com/HospitalNova',
		'instagram'     => 'https://www.instagram.com/hospital.nova/',
		'hours'         => '24/7',
		'lat'           => '',
		'lng'           => '',
	);
}

/** Número limpio para enlaces tel: y wa.me (prefijo México 52). */
function nova_digits( $num ) {
	$d = preg_replace( '/\D+/', '', (string) $num );
	return strlen( $d ) === 10 ? '52' . $d : $d;
}
function nova_tel( $num ) {
	return 'tel:+' . nova_digits( $num );
}
function nova_wa( $num = null, $msg = '' ) {
	$num = $num ? $num : nova_opt( 'whatsapp' );
	if ( '' === $msg ) {
		$msg = nova_t( 'Hola Hospital Nova, quiero agendar una cita.', 'Hello Hospital Nova, I would like to book an appointment.' );
	}
	return 'https://wa.me/' . nova_digits( $num ) . '?text=' . rawurlencode( $msg );
}

/** URL de una página por slug (es/en), con respaldo a "/slug/". */
function nova_page_url( $slug_es, $slug_en ) {
	$slug = 'en' === nova_lang() ? $slug_en : $slug_es;
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

function nova_img( $file ) {
	return NOVA_URI . '/assets/img/' . $file;
}

/** Íconos SVG inline (trazo, heredan currentColor). */
function nova_icon( $name ) {
	$p = array(
		'heart'    => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/><path d="M3.5 12h4l2-3 3 6 2-3h6"/>',
		'brain'    => '<path d="M9.5 2A2.5 2.5 0 0 0 7 4.5v.1A3 3 0 0 0 4.5 9a3 3 0 0 0 .3 5.2A3 3 0 0 0 9 18.5V20a2 2 0 0 0 3 1.7V4.5A2.5 2.5 0 0 0 9.5 2z"/><path d="M14.5 2A2.5 2.5 0 0 1 17 4.5v.1A3 3 0 0 1 19.5 9a3 3 0 0 1-.3 5.2 3 3 0 0 1-4.2 4.3V20a2 2 0 0 1-3 1.7"/>',
		'scalpel'  => '<path d="M3 21l7.5-7.5"/><path d="M14 3l7 7-6.5 6.5-7-7z"/><path d="M10.5 13.5l-2 2"/>',
		'baby'     => '<circle cx="12" cy="7" r="4"/><path d="M5.5 21a6.5 6.5 0 0 1 13 0"/><path d="M10 7h.01M14 7h.01"/>',
		'siren'    => '<path d="M7 18v-6a5 5 0 0 1 10 0v6"/><path d="M5 21h14v-3H5z"/><path d="M12 2v2M4.2 5.2l1.4 1.4M19.8 5.2l-1.4 1.4"/>',
		'bed'      => '<path d="M2 4v16M2 8h18a2 2 0 0 1 2 2v10M2 17h20"/><circle cx="7" cy="12" r="2"/>',
		'flask'    => '<path d="M9 3h6M10 3v6L4.5 18.5A1.7 1.7 0 0 0 6 21h12a1.7 1.7 0 0 0 1.5-2.5L14 9V3"/><path d="M7 15h10"/>',
		'xray'     => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M12 6v12M8 9h8M8 12h8M9 15h6"/>',
		'drop'     => '<path d="M12 2.7s-6 6.4-6 11a6 6 0 0 0 12 0c0-4.6-6-11-6-11z"/>',
		'stetho'   => '<path d="M5 3v6a5 5 0 0 0 10 0V3"/><path d="M10 14v2a5 5 0 0 0 10 0v-3"/><circle cx="20" cy="11" r="2"/>',
		'phone'    => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>',
		'pin'      => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
		'mail'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/>',
		'clock'    => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'arrow'    => '<path d="M5 12h14M13 5l7 7-7 7"/>',
		'left'     => '<path d="M15 18l-6-6 6-6"/>',
		'right'    => '<path d="M9 18l6-6-6-6"/>',
		'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
		'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/>',
		'globe'    => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20z"/>',
	);
	if ( 'whatsapp' === $name ) {
		return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.1-1.8-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.1-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6l.4-.5c.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.2-.3-.3-.6-.4zM12 21.8c-1.8 0-3.5-.5-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4A9.8 9.8 0 1 1 12 21.8zm8.4-18.2A11.8 11.8 0 0 0 1.7 17.8L0 24l6.3-1.7a11.8 11.8 0 0 0 5.7 1.4c6.5 0 11.8-5.3 11.8-11.8 0-3.2-1.2-6.1-3.4-8.3z"/></svg>';
	}
	$path = isset( $p[ $name ] ) ? $p[ $name ] : $p['heart'];
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

/** Especialidades y servicios (bilingüe). */
function nova_specialties() {
	return array(
		array( 'icon' => 'stetho', 'key' => 'medicina-interna', 'es' => array( 'Medicina Interna', 'Atención integral del adulto: diabetes, hipertensión, enfermedades infecciosas, autoinmunes y circulatorias, sin cirugía.' ), 'en' => array( 'Internal Medicine', 'Comprehensive adult care: diabetes, hypertension, infectious, autoimmune and circulatory diseases, without surgery.' ) ),
		array( 'icon' => 'brain', 'key' => 'neurologia', 'es' => array( 'Neurología', 'Diagnóstico y tratamiento de migraña, vértigo, epilepsia, problemas de memoria y trastornos del sueño.' ), 'en' => array( 'Neurology', 'Diagnosis and treatment of migraine, vertigo, epilepsy, memory problems and sleep disorders.' ) ),
		array( 'icon' => 'scalpel', 'key' => 'cirugia-oncologica', 'es' => array( 'Cirugía Oncológica', 'Cirujanos oncólogos para el tratamiento quirúrgico del cáncer con quirófano y hospitalización 24 horas.' ), 'en' => array( 'Surgical Oncology', 'Surgical oncologists for cancer surgery, backed by a 24-hour operating room and inpatient care.' ) ),
		array( 'icon' => 'baby', 'key' => 'maternidad', 'es' => array( 'Maternidad: Parto y Cesárea', 'Presupuesto hospitalario, requisitos de ingreso, certificado de nacimiento y gastos médicos mayores.' ), 'en' => array( 'Maternity: Birth & C-Section', 'Hospital quotes, admission requirements, birth certificate and major medical insurance support.' ) ),
		array( 'icon' => 'siren', 'key' => 'urgencias', 'es' => array( 'Urgencias 24/7', 'Siempre abierto. Valoración inmediata por médicos y especialistas a cualquier hora, todos los días.' ), 'en' => array( '24/7 Emergency Room', 'Always open. Immediate evaluation by physicians and specialists at any hour, every day.' ) ),
		array( 'icon' => 'bed', 'key' => 'hospitalizacion', 'es' => array( 'Quirófano y Hospitalización', 'Quirófanos equipados y habitaciones para tu recuperación con vigilancia médica continua.' ), 'en' => array( 'Surgery & Inpatient Care', 'Equipped operating rooms and patient rooms for recovery with round-the-clock monitoring.' ) ),
	);
}

function nova_partners() {
	return array(
		array( 'icon' => 'flask', 'name' => 'NovaLab', 'es' => 'Laboratorio clínico 24/7', 'en' => '24/7 clinical laboratory' ),
		array( 'icon' => 'xray', 'name' => 'Intedia', 'es' => 'Rayos X e imagen médica', 'en' => 'X-ray & medical imaging' ),
		array( 'icon' => 'drop', 'name' => 'Haima', 'es' => 'Banco de sangre', 'en' => 'Blood bank' ),
	);
}

/** Directorio médico (editar aquí o desde la página "Médicos"). */
function nova_doctors() {
	return array(
		array( 'name' => 'Dr. César Ornelas', 'es' => 'Medicina Interna', 'en' => 'Internal Medicine', 'meta_es' => 'Consultorio 201', 'meta_en' => 'Office 201', 'wa' => '663 592 51 71' ),
		array( 'name' => 'Dr. Alexis Miranda Hernández', 'es' => 'Neurología Clínica', 'en' => 'Clinical Neurology', 'meta_es' => 'Céd. Prof. 15822914', 'meta_en' => 'License 15822914', 'wa' => '' ),
		array( 'name' => 'Dr. Alfredo Ornelas', 'es' => 'Cirugía Oncológica', 'en' => 'Surgical Oncology', 'meta_es' => 'Citas por WhatsApp', 'meta_en' => 'Appointments via WhatsApp', 'wa' => '664 204 72 81' ),
		array( 'name' => 'Dr. Eder Quevedo', 'es' => 'Cirugía Oncológica', 'en' => 'Surgical Oncology', 'meta_es' => 'Citas por WhatsApp', 'meta_en' => 'Appointments via WhatsApp', 'wa' => '664 204 72 81' ),
	);
}

/** Preguntas frecuentes (se usan también para Schema FAQPage). */
function nova_faqs() {
	$es = array(
		array( '¿Hospital Nova atiende urgencias las 24 horas?', 'Sí. Hospital Nova está siempre abierto, 24 horas los 7 días de la semana, con consulta médica, quirófano, hospitalización y valoración por especialistas.' ),
		array( '¿Cómo agendo una cita con un especialista?', 'Puedes llamar al ' . nova_opt( 'phone' ) . ', escribirnos por WhatsApp o llenar el formulario de contacto. Te respondemos para confirmar día y hora.' ),
		array( '¿Tienen laboratorio, rayos X y banco de sangre?', 'Sí. Contamos con servicios de diagnóstico 24/7: laboratorio clínico NovaLab, estudios de imagen y rayos X con Intedia y banco de sangre Haima.' ),
		array( '¿Puedo pedir presupuesto de parto o cesárea?', 'Sí. Te compartimos presupuesto hospitalario, requisitos de ingreso, recomendaciones, trámite de certificado de nacimiento y opciones con gastos médicos mayores.' ),
		array( '¿Atienden pacientes de Estados Unidos?', 'Sí. Recibimos pacientes de San Diego y del sur de California que buscan atención de especialidad en Tijuana. Escríbenos y te orientamos en español o inglés.' ),
	);
	$en = array(
		array( 'Is Hospital Nova open 24 hours for emergencies?', 'Yes. Hospital Nova is always open, 24 hours a day, 7 days a week, with medical consultations, operating rooms, inpatient care and specialist evaluation.' ),
		array( 'How do I book an appointment with a specialist?', 'Call ' . nova_opt( 'phone' ) . ', message us on WhatsApp or fill out the contact form. We will reply to confirm the date and time.' ),
		array( 'Do you have a lab, X-ray and blood bank?', 'Yes. We offer 24/7 diagnostic services: NovaLab clinical laboratory, Intedia X-ray and imaging, and Haima blood bank.' ),
		array( 'Can I get a quote for a vaginal birth or C-section?', 'Yes. We share the hospital quote, admission requirements, recommendations, birth certificate paperwork and major medical insurance options.' ),
		array( 'Do you treat patients from the United States?', 'Yes. We welcome patients from San Diego and Southern California seeking specialist care in Tijuana. Message us and we will guide you in English or Spanish.' ),
	);
	return 'en' === nova_lang() ? $en : $es;
}

/** Slides del hero (editables en Apariencia > Personalizar > Hero 3D). */
function nova_slides() {
	$defaults = array(
		1 => array( 'hospital-24-horas-tijuana.webp', 'Siempre abierto 24/7', 'Always open 24/7', 'Hospital' ),
		2 => array( 'medicina-interna-tijuana.webp', 'Medicina Interna', 'Internal Medicine', nova_t( 'Especialidad', 'Specialty' ) ),
		3 => array( 'neurologia-tijuana.webp', 'Neurología Clínica', 'Clinical Neurology', nova_t( 'Especialidad', 'Specialty' ) ),
		4 => array( 'cirugia-oncologica-tijuana.webp', 'Cirugía Oncológica', 'Surgical Oncology', nova_t( 'Quirófano 24 h', '24h Surgery' ) ),
		5 => array( 'parto-cesarea-tijuana.webp', '¿Parto o cesárea?', 'Birth or C-section?', nova_t( 'Maternidad', 'Maternity' ) ),
	);
	$out = array();
	foreach ( $defaults as $i => $d ) {
		$img   = get_theme_mod( "nova_slide{$i}_img" );
		$title = get_theme_mod( 'en' === nova_lang() ? "nova_slide{$i}_title_en" : "nova_slide{$i}_title_es" );
		$out[] = array(
			'img'   => $img ? $img : nova_img( $d[0] ),
			'title' => $title ? $title : nova_t( $d[1], $d[2] ),
			'tag'   => $d[3],
		);
	}
	return $out;
}
