<?php
/**
 * Bilingual (EN / ES) helpers.
 *
 * Each page or post carries `_dmc_lang` (en|es) and `_dmc_translation`
 * (the path of its counterpart in the other language). Spanish pages live
 * under the /es/ parent page.
 */

defined( 'ABSPATH' ) || exit;

/** Current language: en (default) or es. */
function dmc_lang() {
	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}
	$lang = 'en';
	$id   = get_queried_object_id();
	if ( $id && ( is_singular() || is_home() ) ) {
		$meta = get_post_meta( $id, '_dmc_lang', true );
		if ( 'es' === $meta ) {
			$lang = 'es';
		}
	} elseif ( is_category() ) {
		$term = get_queried_object();
		if ( $term && ( 'es' === get_term_meta( $term->term_id, '_dmc_lang', true ) || 0 === strpos( $term->slug, 'es-' ) ) ) {
			$lang = 'es';
		}
	}
	return $lang;
}

/** URL of the language home. */
function dmc_home_url( $lang = null ) {
	$lang = $lang ? $lang : dmc_lang();
	return 'es' === $lang ? home_url( '/es/' ) : home_url( '/' );
}

/** URL of a page in the current language, by EN slug => ES path map. */
function dmc_page_url( $key, $lang = null ) {
	$lang = $lang ? $lang : dmc_lang();
	$map  = dmc_page_map();
	if ( ! isset( $map[ $key ] ) ) {
		return dmc_home_url( $lang );
	}
	$path = $map[ $key ][ 'es' === $lang ? 1 : 0 ];
	return home_url( '/' . trailingslashit( $path ) );
}

/** Canonical page paths: key => [ en path, es path ]. */
function dmc_page_map() {
	return array(
		'about'      => array( 'about-dr-mario-camelo', 'es/sobre-el-dr-mario-camelo' ),
		'sleeve'     => array( 'gastric-sleeve-tijuana', 'es/manga-gastrica-tijuana' ),
		'bypass'     => array( 'gastric-bypass-tijuana', 'es/bypass-gastrico-tijuana' ),
		'revision'   => array( 'revision-bariatric-surgery', 'es/cirugia-de-revision' ),
		'metabolic'  => array( 'metabolic-medicine', 'es/medicina-metabolica' ),
		'financing'  => array( 'financing', 'es/financiamiento' ),
		'reviews'    => array( 'reviews', 'es/testimonios' ),
		'contact'    => array( 'contact', 'es/contacto' ),
		'blog'       => array( 'blog', 'es/blog' ),
		'privacy'    => array( 'privacy', 'es/aviso-de-privacidad' ),
	);
}

/** URL of the counterpart of the current view in the other language. */
function dmc_translation_url( $target ) {
	if ( is_front_page() ) {
		return dmc_home_url( $target );
	}
	$id = get_queried_object_id();
	if ( $id && ( is_singular() || is_home() ) ) {
		$path = get_post_meta( $id, '_dmc_translation', true );
		if ( $path ) {
			$type = get_post_type( $id );
			$post = get_page_by_path( $path, OBJECT, $type );
			if ( $post ) {
				return get_permalink( $post );
			}
		}
	}
	return dmc_home_url( $target );
}

/** Locale for <html lang>. */
add_filter(
	'language_attributes',
	function ( $output ) {
		$tag = 'es' === dmc_lang() ? 'es-MX' : 'en-US';
		return preg_replace( '/lang="[^"]*"/', 'lang="' . $tag . '"', $output );
	}
);

/** Keep the English blog index free of Spanish posts. */
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() || ! $q->is_main_query() ) {
			return;
		}
		if ( $q->is_home() || $q->is_feed() ) {
			$q->set(
				'meta_query',
				array(
					'relation' => 'OR',
					array( 'key' => '_dmc_lang', 'value' => 'en' ),
					array( 'key' => '_dmc_lang', 'compare' => 'NOT EXISTS' ),
				)
			);
		}
	}
);

/**
 * UI strings. dmc_t( 'key' ) returns the string in the current language.
 */
function dmc_t( $key, $lang = null ) {
	$lang    = $lang ? $lang : dmc_lang();
	$strings = dmc_strings();
	if ( ! isset( $strings[ $key ] ) ) {
		return $key;
	}
	return $strings[ $key ][ 'es' === $lang ? 1 : 0 ];
}

function dmc_strings() {
	return array(
		// Navigation.
		'nav_home'        => array( 'Home', 'Inicio' ),
		'nav_about'       => array( 'Dr. Camelo', 'Dr. Camelo' ),
		'nav_procedures'  => array( 'Procedures', 'Procedimientos' ),
		'nav_sleeve'      => array( 'Gastric Sleeve', 'Manga Gástrica' ),
		'nav_bypass'      => array( 'Gastric Bypass', 'Bypass Gástrico' ),
		'nav_revision'    => array( 'Revision Surgery', 'Cirugía de Revisión' ),
		'nav_metabolic'   => array( 'Metabolic Medicine', 'Medicina Metabólica' ),
		'nav_financing'   => array( 'Financing', 'Financiamiento' ),
		'nav_reviews'     => array( 'Reviews', 'Testimonios' ),
		'nav_blog'        => array( 'Blog', 'Blog' ),
		'nav_contact'     => array( 'Contact', 'Contacto' ),
		'nav_privacy'     => array( 'Privacy Policy', 'Aviso de Privacidad' ),
		'cta_free'        => array( 'Free Consultation', 'Valoración Gratis' ),
		'cta_schedule'    => array( 'Schedule your free appointment', 'Agenda tu cita gratuita' ),
		'cta_qualify'     => array( 'Do I qualify?', '¿Soy candidato?' ),
		'cta_financing'   => array( 'Apply for financing', 'Solicitar financiamiento' ),
		'cta_learn'       => array( 'Learn more', 'Conocer más' ),
		'cta_whatsapp'    => array( 'Chat on WhatsApp', 'Escríbenos por WhatsApp' ),
		'tagline'         => array( 'Bariatric Surgery & Metabolic Medicine', 'Cirugía Bariátrica y Medicina Metabólica' ),
		'brand_tag'       => array( 'Certified Bariatric Surgeon', 'Cirujano Bariatra Certificado' ),
		'scroll'          => array( 'SCROLL', 'DESLIZA' ),
		'prev'            => array( 'Previous slide', 'Diapositiva anterior' ),
		'next'            => array( 'Next slide', 'Siguiente diapositiva' ),

		// Hero slides (4 headline sets).
		'h1_badge'        => array( '10,000+ surgeries performed', '+10,000 cirugías realizadas' ),
		'h1_title'        => array( 'Your new life begins with <span class="text-gold">one decision.</span>', 'Tu nueva vida comienza con <span class="text-gold">una decisión.</span>' ),
		'h1_text'         => array( 'Gastric sleeve and gastric bypass by Dr. Mario Camelo — the certified bariatric surgeon known as #SuperDrSleeve. Precision, safety and a team that walks every step with you.', 'Manga gástrica y bypass gástrico con el Dr. Mario Camelo, el cirujano bariatra certificado conocido como #SuperDrSleeve. Precisión, seguridad y un equipo que te acompaña en cada paso.' ),
		'h2_badge'        => array( 'Metabolic medicine', 'Medicina metabólica' ),
		'h2_title'        => array( 'Beat obesity. <span class="text-gold">Reclaim your health.</span>', 'Vence la obesidad. <span class="text-gold">Recupera tu salud.</span>' ),
		'h2_text'         => array( 'We treat obesity as the disease it is — together with type 2 diabetes, hypertension, sleep apnea and joint pain — through a multidisciplinary team built around you.', 'Tratamos la obesidad como la enfermedad que es, junto con la diabetes tipo 2, la hipertensión, la apnea del sueño y el dolor articular, con un equipo multidisciplinario diseñado para ti.' ),
		'h3_badge'        => array( 'Tijuana · minutes from San Diego', 'Tijuana · a minutos de San Diego' ),
		'h3_title'        => array( 'World-class surgery, <span class="text-gold">just across the border.</span>', 'Cirugía de clase mundial, <span class="text-gold">al otro lado de la frontera.</span>' ),
		'h3_text'         => array( 'Advanced laparoscopic surgery in Playas de Tijuana with bilingual care, coordinated logistics and a fraction of U.S. costs — without compromising on safety.', 'Cirugía laparoscópica avanzada en Playas de Tijuana con atención bilingüe, logística coordinada y costos accesibles, sin comprometer tu seguridad.' ),
		'h4_badge'        => array( 'Flexible financing', 'Financiamiento flexible' ),
		'h4_title'        => array( 'Invest in yourself. <span class="text-gold">Pay at your pace.</span>', 'Invierte en ti. <span class="text-gold">Paga a tu ritmo.</span>' ),
		'h4_text'         => array( 'Apply for patient financing in minutes and start your transformation with a plan that fits your budget.', 'Solicita tu financiamiento en minutos y comienza tu transformación con un plan que se adapta a tu presupuesto.' ),

		// Stats.
		's1_label'        => array( 'Bariatric surgeries performed', 'Cirugías bariátricas realizadas' ),
		's2_label'        => array( 'Avg. total body weight loss*', 'Pérdida de peso corporal total*' ),
		's3_label'        => array( 'Free initial evaluation', 'Valoración inicial gratuita' ),
		's4_label'        => array( 'Bilingual care, EN / ES', 'Atención bilingüe, ES / EN' ),

		// About.
		'about_eyebrow'   => array( 'Meet your surgeon', 'Conoce a tu cirujano' ),
		'about_title'     => array( 'Dr. Mario Camelo, <span class="text-gold">#SuperDrSleeve</span>', 'Dr. Mario Camelo, <span class="text-gold">#SuperDrSleeve</span>' ),
		'about_text'      => array( 'Certified bariatric surgeon with more than 10,000 procedures performed. Dr. Camelo combines advanced laparoscopic technique with metabolic medicine to treat obesity and the diseases that come with it — and he does it with a multidisciplinary team that designs a plan for every patient.', 'Cirujano bariatra certificado con más de 10,000 procedimientos realizados. El Dr. Camelo combina técnica laparoscópica avanzada con medicina metabólica para tratar la obesidad y las enfermedades que conlleva, con un equipo multidisciplinario que diseña un plan para cada paciente.' ),
		'about_li1'       => array( 'Certified bariatric surgeon', 'Cirujano bariatra certificado' ),
		'about_li2'       => array( 'Multidisciplinary team: nutrition, psychology, internal medicine', 'Equipo multidisciplinario: nutrición, psicología y medicina interna' ),
		'about_li3'       => array( 'Personalized pre- and post-op follow-up', 'Seguimiento personalizado antes y después de la cirugía' ),
		'about_li4'       => array( 'Care in English and Spanish', 'Atención en español e inglés' ),
		'about_badge'     => array( 'surgeries<br>performed', 'cirugías<br>realizadas' ),

		// Procedures.
		'proc_eyebrow'    => array( 'Procedures', 'Procedimientos' ),
		'proc_title'      => array( 'Surgery designed around <span class="text-gold">your body</span>', 'Cirugía diseñada para <span class="text-gold">tu cuerpo</span>' ),
		'proc_lead'       => array( 'Every patient is evaluated individually. These are the procedures Dr. Camelo performs most often.', 'Cada paciente se valora de forma individual. Estos son los procedimientos que el Dr. Camelo realiza con mayor frecuencia.' ),
		'sleeve_text'     => array( 'Removes about 80% of the stomach to reduce capacity and hunger hormones. The most performed bariatric procedure in the world.', 'Retira cerca del 80% del estómago para reducir la capacidad y las hormonas del hambre. El procedimiento bariátrico más realizado del mundo.' ),
		'bypass_text'     => array( 'Creates a small pouch and reroutes the intestine. Ideal for type 2 diabetes, severe reflux and higher BMI.', 'Crea un pequeño reservorio y redirige el intestino. Ideal para diabetes tipo 2, reflujo severo e IMC elevado.' ),
		'revision_text'   => array( 'Weight regain or reflux after a previous surgery? We evaluate and convert sleeve or band to bypass safely.', '¿Reganancia de peso o reflujo tras una cirugía previa? Valoramos y convertimos manga o banda a bypass con seguridad.' ),
		'metabolic_text'  => array( 'Medical treatment of obesity, diabetes and metabolic syndrome — including supervised GLP-1 therapy when indicated.', 'Tratamiento médico de la obesidad, diabetes y síndrome metabólico, incluyendo terapia GLP-1 supervisada cuando está indicada.' ),
		'meta_loss'       => array( 'Weight loss*', 'Pérdida de peso*' ),
		'meta_stay'        => array( 'Technique', 'Técnica' ),
		'meta_lap'         => array( 'Laparoscopic', 'Laparoscópica' ),
		'meta_ideal'      => array( 'Ideal for', 'Ideal para' ),
		'meta_regain'     => array( 'Regain / GERD', 'Reganancia / ERGE' ),
		'meta_eval'       => array( 'Evaluation', 'Valoración' ),
		'meta_individual' => array( 'Individual', 'Individual' ),
		'meta_approach'   => array( 'Approach', 'Enfoque' ),
		'meta_medical'    => array( 'Medical', 'Médico' ),

		// Marquee.
		'marquee'         => array( 'Gastric Sleeve · Gastric Bypass · Revision Surgery · Metabolic Medicine · #SuperDrSleeve · ', 'Manga Gástrica · Bypass Gástrico · Cirugía de Revisión · Medicina Metabólica · #SuperDrSleeve · ' ),

		// Panoramic band.
		'pano_eyebrow'    => array( 'Beyond the scale', 'Más allá de la báscula' ),
		'pano_title'      => array( 'It is not about a number. It is about <span class="text-gold">living fully again.</span>', 'No se trata de un número. Se trata de <span class="text-gold">volver a vivir plenamente.</span>' ),
		'pano_text'       => array( 'Play with your kids. Get off the medication. Sleep through the night. That is the goal.', 'Jugar con tus hijos. Dejar los medicamentos. Dormir toda la noche. Ese es el objetivo.' ),

		// Process.
		'proc2_eyebrow'   => array( 'Your journey', 'Tu proceso' ),
		'proc2_title'     => array( 'Four steps to your <span class="text-gold">transformation</span>', 'Cuatro pasos hacia tu <span class="text-gold">transformación</span>' ),
		'step1_t'         => array( 'Free evaluation', 'Valoración gratuita' ),
		'step1_d'         => array( 'Send your information and get a personalized assessment from our team.', 'Envía tu información y recibe una valoración personalizada de nuestro equipo.' ),
		'step2_t'         => array( 'Pre-op plan', 'Plan preoperatorio' ),
		'step2_d'         => array( 'Lab work, nutrition plan and coordinated travel from San Diego.', 'Estudios, plan nutricional y logística coordinada de tu llegada.' ),
		'step3_t'         => array( 'Surgery', 'Cirugía' ),
		'step3_d'         => array( 'Laparoscopic procedure with a dedicated team and close monitoring.', 'Procedimiento laparoscópico con un equipo dedicado y monitoreo estrecho.' ),
		'step4_t'         => array( 'Long-term follow-up', 'Seguimiento a largo plazo' ),
		'step4_d'         => array( 'Nutrition, check-ins and support so your results last.', 'Nutrición, revisiones y acompañamiento para que tus resultados perduren.' ),

		// Reviews.
		'rev_eyebrow'     => array( 'Real patients', 'Pacientes reales' ),
		'rev_title'       => array( 'Stories that <span class="text-gold">inspire</span>', 'Historias que <span class="text-gold">inspiran</span>' ),
		'rev_lead'        => array( 'Read what our patients say about their experience with Dr. Camelo and his team.', 'Lee lo que nuestros pacientes dicen sobre su experiencia con el Dr. Camelo y su equipo.' ),
		'rev_google'      => array( 'Read our reviews on Google', 'Lee nuestras reseñas en Google' ),

		// Financing.
		'fin_eyebrow'     => array( 'Financing', 'Financiamiento' ),
		'fin_title'       => array( 'Your surgery, <span class="text-gold">with payments that fit</span>', 'Tu cirugía, <span class="text-gold">con pagos a tu medida</span>' ),
		'fin_lead'        => array( 'Do not let cost delay your health. Complete the secure application and our team will contact you with options.', 'Que el costo no retrase tu salud. Completa la solicitud segura y nuestro equipo te contactará con opciones.' ),
		'fin_p1_t'        => array( 'Fast application', 'Solicitud rápida' ),
		'fin_p1_d'        => array( 'Takes only a few minutes from your phone.', 'Toma solo unos minutos desde tu celular.' ),
		'fin_p2_t'        => array( 'Flexible plans', 'Planes flexibles' ),
		'fin_p2_d'        => array( 'Monthly payments adapted to your budget.', 'Pagos mensuales adaptados a tu presupuesto.' ),
		'fin_p3_t'        => array( 'Confidential', 'Confidencial' ),
		'fin_p3_d'        => array( 'Your information is handled securely.', 'Tu información se maneja de forma segura.' ),
		'fin_form_head'   => array( 'Financing application', 'Solicitud de financiamiento' ),
		'fin_open'        => array( 'Open in full screen', 'Abrir en pantalla completa' ),

		// FAQ.
		'faq_eyebrow'     => array( 'FAQ', 'Preguntas frecuentes' ),
		'faq_title'       => array( 'Answers before you <span class="text-gold">decide</span>', 'Respuestas antes de <span class="text-gold">decidir</span>' ),
		'faq1_q'          => array( 'Am I a candidate for bariatric surgery?', '¿Soy candidato a cirugía bariátrica?' ),
		'faq1_a'          => array( 'Generally, adults with a BMI of 35 or more, or 30–35 with obesity-related conditions such as type 2 diabetes or hypertension, may be candidates. Final eligibility is decided after a medical evaluation.', 'En general, adultos con IMC de 35 o más, o de 30 a 35 con enfermedades asociadas como diabetes tipo 2 o hipertensión, pueden ser candidatos. La decisión final se toma tras una valoración médica.' ),
		'faq2_q'          => array( 'How much weight can I expect to lose?', '¿Cuánto peso puedo perder?' ),
		'faq2_a'          => array( 'On average, gastric sleeve patients lose about 25–30% of total body weight and gastric bypass patients about 30–32%. Results vary with each patient and their commitment to follow-up.', 'En promedio, los pacientes de manga gástrica pierden entre 25 y 30% de su peso corporal total y los de bypass gástrico entre 30 y 32%. Los resultados varían según cada paciente y su compromiso con el seguimiento.' ),
		'faq3_q'          => array( 'Is it safe to have surgery in Tijuana?', '¿Es seguro operarse en Tijuana?' ),
		'faq3_a'          => array( 'Safety depends on the surgeon, the team and the hospital. Dr. Camelo is a certified bariatric surgeon with more than 10,000 surgeries, operates with a multidisciplinary team and provides structured follow-up after you return home.', 'La seguridad depende del cirujano, el equipo y el hospital. El Dr. Camelo es cirujano bariatra certificado con más de 10,000 cirugías, opera con un equipo multidisciplinario y brinda seguimiento estructurado después de tu regreso a casa.' ),
		'faq4_q'          => array( 'Can the gallbladder be removed during bariatric surgery?', '¿Se puede operar la vesícula junto con la cirugía bariátrica?' ),
		'faq4_a'          => array( 'In some patients it can be evaluated, but every case must be individualized. Rapid weight loss can favor gallstone formation, so we assess it before surgery.', 'En algunos pacientes puede valorarse, pero cada caso debe individualizarse. La pérdida rápida de peso puede favorecer la formación de piedras, por eso lo evaluamos antes de la cirugía.' ),
		'faq5_q'          => array( 'Do you offer financing?', '¿Ofrecen financiamiento?' ),
		'faq5_a'          => array( 'Yes. You can apply online in a few minutes through our secure financing form and our team will contact you with the available options.', 'Sí. Puedes solicitarlo en línea en pocos minutos a través de nuestro formulario seguro y nuestro equipo te contactará con las opciones disponibles.' ),

		// CTA / form.
		'cta_eyebrow'     => array( 'Take the first step', 'Da el primer paso' ),
		'cta_title'       => array( 'Your free evaluation <span class="text-gold">starts here</span>', 'Tu valoración gratuita <span class="text-gold">empieza aquí</span>' ),
		'cta_text'        => array( 'Leave your details and a member of Dr. Camelo’s team will contact you shortly.', 'Déjanos tus datos y un miembro del equipo del Dr. Camelo te contactará a la brevedad.' ),
		'f_name'          => array( 'Full name', 'Nombre completo' ),
		'f_email'         => array( 'Email', 'Correo electrónico' ),
		'f_phone'         => array( 'Phone / WhatsApp', 'Teléfono / WhatsApp' ),
		'f_proc'          => array( 'Procedure of interest', 'Procedimiento de interés' ),
		'f_proc_unsure'   => array( 'Not sure yet', 'Aún no lo sé' ),
		'f_height'        => array( 'Height (ft/in or cm)', 'Estatura (cm)' ),
		'f_weight'        => array( 'Weight (lb or kg)', 'Peso (kg)' ),
		'f_msg'           => array( 'Tell us about your goals', 'Cuéntanos tus objetivos' ),
		'f_send'          => array( 'Send my free evaluation', 'Enviar mi valoración gratuita' ),
		'f_consent'       => array( 'By submitting you agree to be contacted and accept our privacy policy.', 'Al enviar aceptas ser contactado y nuestro aviso de privacidad.' ),
		'f_ok'            => array( 'Thank you! We received your information and will contact you soon.', '¡Gracias! Recibimos tu información y te contactaremos pronto.' ),
		'f_err'           => array( 'Something went wrong. Please try again or contact us on WhatsApp.', 'Algo salió mal. Intenta de nuevo o contáctanos por WhatsApp.' ),

		// Footer / misc.
		'footer_about'    => array( 'Bariatric surgery and metabolic medicine in Tijuana. Fighting obesity and its comorbidities with a multidisciplinary team for every patient.', 'Cirugía bariátrica y medicina metabólica en Tijuana. Combatimos la obesidad y sus comorbilidades con un equipo multidisciplinario para cada paciente.' ),
		'footer_visit'    => array( 'Visit us', 'Visítanos' ),
		'footer_pages'    => array( 'Explore', 'Explora' ),
		'footer_hours'    => array( 'Mon–Fri 9:00–18:00', 'Lun–Vie 9:00–18:00' ),
		'disclaimer'      => array( '*Results vary from patient to patient. The information on this site is educational and does not replace a medical consultation.', '*Los resultados varían en cada paciente. La información de este sitio es educativa y no sustituye una consulta médica.' ),
		'rights'          => array( 'All rights reserved.', 'Todos los derechos reservados.' ),
		'read_more'       => array( 'Read article', 'Leer artículo' ),
		'latest'          => array( 'From the blog', 'Del blog' ),
		'latest_title'    => array( 'Learn before you <span class="text-gold">decide</span>', 'Infórmate antes de <span class="text-gold">decidir</span>' ),
		'not_found'       => array( 'Page not found', 'Página no encontrada' ),
		'not_found_text'  => array( 'The page you are looking for does not exist or has moved.', 'La página que buscas no existe o cambió de lugar.' ),
		'back_home'       => array( 'Back to home', 'Volver al inicio' ),
		'no_posts'        => array( 'No articles yet.', 'Aún no hay artículos.' ),
		'related'         => array( 'Keep reading', 'Sigue leyendo' ),
	);
}
