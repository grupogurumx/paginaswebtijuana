<?php
/**
 * Secciones reutilizables. Cada una está disponible como shortcode para
 * insertarla en cualquier página desde el editor de bloques:
 * [nova_specialties] [nova_partners] [nova_doctors] [nova_stats]
 * [nova_maternity] [nova_faq] [nova_latest_posts] [nova_contact] [nova_contact_form]
 *
 * @package hospital-nova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nova_section_head( $eyebrow, $title, $lead = '', $center = false ) {
	$out  = '<div class="section-head reveal' . ( $center ? ' section-head--center' : '' ) . '">';
	$out .= '<span class="eyebrow">' . esc_html( $eyebrow ) . '</span>';
	$out .= '<h2>' . wp_kses_post( $title ) . '</h2>';
	if ( $lead ) {
		$out .= '<p class="lead">' . esc_html( $lead ) . '</p>';
	}
	return $out . '</div>';
}

function nova_section_specialties( $with_head = true ) {
	$contact = nova_page_url( 'contacto', 'contact' );
	$out     = '<section class="section" id="especialidades"><div class="container">';
	if ( $with_head ) {
		$out .= nova_section_head( nova_t( 'Especialidades', 'Specialties' ), nova_t( 'Especialistas que te atienden de forma integral', 'Specialists who care for you as a whole' ), nova_t( 'Valoración por especialistas, consulta médica, quirófano y hospitalización en un mismo lugar en Tijuana.', 'Specialist evaluation, consultations, surgery and inpatient care under one roof in Tijuana.' ) );
	}
	$out .= '<div class="grid grid--3">';
	foreach ( nova_specialties() as $i => $s ) {
		$d    = 'en' === nova_lang() ? $s['en'] : $s['es'];
		$out .= sprintf(
			'<article class="card reveal" style="--d:%1$dms" data-tilt><div class="card__icon">%2$s</div><h3>%3$s</h3><p>%4$s</p><a class="card__link" href="%5$s">%6$s</a></article>',
			$i * 80,
			nova_icon( $s['icon'] ),
			esc_html( $d[0] ),
			esc_html( $d[1] ),
			esc_url( add_query_arg( 'esp', $s['key'], $contact ) . '#cita' ),
			esc_html( nova_t( 'Agendar valoración', 'Book evaluation' ) )
		);
	}
	return $out . '</div></div></section>';
}

function nova_section_partners() {
	$out  = '<section class="section section--navy"><div class="container">';
	$out .= nova_section_head( nova_t( 'Diagnóstico 24/7', '24/7 Diagnostics' ), nova_t( 'Resultados cuando los necesitas', 'Results when you need them' ), nova_t( 'Laboratorio, imagen y banco de sangre dentro del hospital para decisiones médicas rápidas y seguras.', 'Laboratory, imaging and blood bank on site for fast, safe medical decisions.' ), true );
	$out .= '<div class="grid grid--3">';
	foreach ( nova_partners() as $i => $p ) {
		$out .= sprintf(
			'<div class="card partner reveal" style="--d:%dms;background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.1)"><div class="card__icon" style="margin:0 auto 16px">%s</div><b>%s</b><span>%s</span></div>',
			$i * 100,
			nova_icon( $p['icon'] ),
			esc_html( $p['name'] ),
			esc_html( 'en' === nova_lang() ? $p['en'] : $p['es'] )
		);
	}
	return $out . '</div></div></section>';
}

function nova_section_doctors() {
	$out  = '<section class="section section--white" id="medicos"><div class="container">';
	$out .= nova_section_head( nova_t( 'Cuerpo médico', 'Medical staff' ), nova_t( 'Médicos especialistas en Tijuana', 'Specialist doctors in Tijuana' ), nova_t( 'Conoce a algunos de los especialistas que consultan en Hospital Nova.', 'Meet some of the specialists who practice at Hospital Nova.' ) );
	$out .= '<div class="grid grid--4">';
	foreach ( nova_doctors() as $i => $doc ) {
		$wa   = $doc['wa'] ? $doc['wa'] : nova_opt( 'whatsapp' );
		$msg  = nova_t( 'Hola, quiero una cita con ', 'Hello, I would like an appointment with ' ) . $doc['name'];
		$out .= sprintf(
			'<article class="card doctor reveal" style="--d:%1$dms"><div class="card__icon">%2$s</div><span class="doctor__spec">%3$s</span><h3>%4$s</h3><span class="doctor__meta">%5$s</span><a class="btn btn--outline" href="%6$s" target="_blank" rel="noopener">%7$s %8$s</a></article>',
			$i * 80,
			nova_icon( 'stetho' ),
			esc_html( 'en' === nova_lang() ? $doc['en'] : $doc['es'] ),
			esc_html( $doc['name'] ),
			esc_html( 'en' === nova_lang() ? $doc['meta_en'] : $doc['meta_es'] ),
			esc_url( nova_wa( $wa, $msg ) ),
			nova_icon( 'whatsapp' ),
			esc_html( nova_t( 'Agendar', 'Book' ) )
		);
	}
	return $out . '</div></div></section>';
}

function nova_section_stats() {
	$items = array(
		array( 24, '/7', nova_t( 'Urgencias y hospitalización', 'Emergency & inpatient care' ) ),
		array( 365, '', nova_t( 'Días al año abiertos', 'Days a year open' ) ),
		array( 3, '', nova_t( 'Servicios de diagnóstico en sitio', 'On-site diagnostic services' ) ),
		array( 2, '', nova_t( 'Idiomas de atención', 'Languages spoken' ) ),
	);
	$out = '<section class="section section--white" style="padding-top:0"><div class="container"><div class="stats" data-counters>';
	foreach ( $items as $it ) {
		$out .= sprintf( '<div class="stat"><strong data-count="%1$d" data-suffix="%2$s">%1$d%2$s</strong><span>%3$s</span></div>', $it[0], esc_attr( $it[1] ), esc_html( $it[2] ) );
	}
	return $out . '</div></div></section>';
}

function nova_section_maternity() {
	$items = 'en' === nova_lang()
		? array( 'Hospital quote', 'Admission requirements', 'Recommendations', 'Birth certificate', 'Major medical insurance', 'OB-GYN referral' )
		: array( 'Presupuesto hospital', 'Requisitos de ingreso', 'Recomendaciones', 'Certificado de nacimiento', 'Gastos médicos mayores', 'Recomendación de ginecólogo/a' );
	$li = '';
	foreach ( $items as $i ) {
		$li .= '<li>' . esc_html( $i ) . '</li>';
	}
	return sprintf(
		'<section class="section"><div class="container"><div class="band-pink reveal reveal--zoom"><div><span class="eyebrow" style="color:#fff">%1$s</span><h2>%2$s</h2><p>%3$s</p><ul>%4$s</ul><a class="btn btn--primary" style="background:#fff;color:var(--nova-pink)" href="%5$s" target="_blank" rel="noopener" data-magnetic>%6$s %7$s</a></div><img src="%8$s" alt="%9$s" loading="lazy" width="1080" height="1350"></div></div></section>',
		esc_html( nova_t( 'Maternidad', 'Maternity' ) ),
		esc_html( nova_t( '¿Parto o cesárea? Te acompañamos', 'Vaginal birth or C-section? We are with you' ) ),
		esc_html( nova_t( 'Recibe toda la información para el nacimiento de tu bebé en Hospital Nova.', 'Get all the information you need for your baby’s birth at Hospital Nova.' ) ),
		$li,
		esc_url( nova_wa( null, nova_t( 'Hola, quiero información de parto/cesárea.', 'Hello, I would like information about birth/C-section.' ) ) ),
		nova_icon( 'whatsapp' ),
		esc_html( nova_t( 'Pedir información', 'Get information' ) ),
		esc_url( nova_img( 'parto-cesarea-tijuana.webp' ) ),
		esc_attr( nova_t( 'Parto y cesárea en Hospital Nova Tijuana', 'Birth and C-section at Hospital Nova Tijuana' ) )
	);
}

function nova_section_faq() {
	$out  = '<section class="section faq" id="faq"><div class="container" style="max-width:860px">';
	$out .= nova_section_head( 'FAQ', nova_t( 'Preguntas frecuentes', 'Frequently asked questions' ), '', true );
	foreach ( nova_faqs() as $i => $f ) {
		$out .= sprintf( '<details class="reveal" style="--d:%dms"%s><summary>%s</summary><p>%s</p></details>', $i * 60, 0 === $i ? ' open' : '', esc_html( $f[0] ), esc_html( $f[1] ) );
	}
	return $out . '</div></section>';
}

function nova_section_posts( $count = 3 ) {
	$q = new WP_Query( array( 'posts_per_page' => $count, 'ignore_sticky_posts' => true, 'no_found_rows' => true, 'lang' => function_exists( 'pll_current_language' ) ? pll_current_language() : '' ) );
	if ( ! $q->have_posts() ) {
		return '';
	}
	$out  = '<section class="section section--white"><div class="container">';
	$out .= nova_section_head( 'Blog', nova_t( 'Salud y bienestar', 'Health & wellness' ), nova_t( 'Información médica clara, escrita para pacientes y sus familias.', 'Clear medical information written for patients and families.' ) );
	$out .= '<div class="grid grid--3">';
	ob_start();
	while ( $q->have_posts() ) {
		$q->the_post();
		get_template_part( 'template-parts/post-card' );
	}
	wp_reset_postdata();
	$out .= ob_get_clean();
	return $out . '</div></div></section>';
}

function nova_section_contact() {
	$maps = 'https://www.google.com/maps?q=' . rawurlencode( nova_opt( 'maps_query' ) ) . '&output=embed';
	ob_start();
	?>
	<section class="section" id="contacto"><div class="container contact-wrap">
		<div class="contact-info reveal">
			<span class="eyebrow"><?php echo esc_html( nova_t( 'Contacto', 'Contact' ) ); ?></span>
			<h2><?php echo esc_html( nova_t( 'Estamos para ti, a cualquier hora', 'We are here for you, any time' ) ); ?></h2>
			<ul>
				<li><?php echo nova_icon( 'phone' ); ?><div><strong><?php echo esc_html( nova_t( 'Citas y urgencias', 'Appointments & ER' ) ); ?></strong><br><a href="<?php echo esc_attr( nova_tel( nova_opt( 'phone' ) ) ); ?>"><?php echo esc_html( nova_opt( 'phone' ) ); ?></a></div></li>
				<li><?php echo nova_icon( 'whatsapp' ); ?><div><strong>WhatsApp</strong><br><a href="<?php echo esc_url( nova_wa() ); ?>" target="_blank" rel="noopener"><?php echo esc_html( nova_opt( 'whatsapp' ) ); ?></a></div></li>
				<li><?php echo nova_icon( 'mail' ); ?><div><strong><?php echo esc_html( nova_t( 'Correo', 'Email' ) ); ?></strong><br><a href="mailto:<?php echo esc_attr( nova_opt( 'email_to' ) ); ?>"><?php echo esc_html( nova_opt( 'email_to' ) ); ?></a></div></li>
				<li><?php echo nova_icon( 'pin' ); ?><div><strong><?php echo esc_html( nova_t( 'Ubicación', 'Location' ) ); ?></strong><br><?php echo esc_html( nova_opt( 'address' ) ); ?></div></li>
				<li><?php echo nova_icon( 'clock' ); ?><div><strong><?php echo esc_html( nova_t( 'Horario', 'Hours' ) ); ?></strong><br><?php echo esc_html( nova_t( 'Abierto 24 horas, 7 días', 'Open 24 hours, 7 days' ) ); ?></div></li>
			</ul>
			<iframe class="map-embed" src="<?php echo esc_url( $maps ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php echo esc_attr( nova_t( 'Mapa Hospital Nova', 'Hospital Nova map' ) ); ?>"></iframe>
		</div>
		<?php echo do_shortcode( '[nova_contact_form]' ); ?>
	</div></section>
	<?php
	return ob_get_clean();
}

add_shortcode( 'nova_specialties', function () {
	return nova_section_specialties( false );
} );
add_shortcode( 'nova_partners', 'nova_section_partners' );
add_shortcode( 'nova_doctors', 'nova_section_doctors' );
add_shortcode( 'nova_stats', 'nova_section_stats' );
add_shortcode( 'nova_maternity', 'nova_section_maternity' );
add_shortcode( 'nova_faq', 'nova_section_faq' );
add_shortcode( 'nova_latest_posts', function ( $atts ) {
	$a = shortcode_atts( array( 'count' => 3 ), $atts );
	return nova_section_posts( absint( $a['count'] ) );
} );
add_shortcode( 'nova_contact', 'nova_section_contact' );
