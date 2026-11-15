<?php
/**
 * SEO técnico: meta description, Open Graph, Twitter Cards, hreflang y Schema.org.
 * Si Rank Math, Yoast o SEOPress están activos, el tema les cede las metas
 * y sólo imprime el Schema médico (Hospital/FAQ) que esos plugins no generan.
 *
 * @package hospital-nova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nova_seo_plugin_active() {
	return defined( 'RANK_MATH_VERSION' ) || defined( 'WPSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

function nova_meta_description() {
	if ( is_front_page() ) {
		return nova_t(
			'Hospital Nova en Tijuana: urgencias 24/7, especialistas en medicina interna, neurología, cirugía oncológica y maternidad. Laboratorio, rayos X y banco de sangre. ¡Agenda tu cita!',
			'Hospital Nova in Tijuana: 24/7 emergency care, specialists in internal medicine, neurology, surgical oncology and maternity. On-site lab, X-ray and blood bank. Book now!'
		);
	}
	if ( is_singular() ) {
		$p    = get_queried_object();
		$desc = get_post_meta( $p->ID, '_nova_meta_description', true );
		if ( ! $desc ) {
			$desc = has_excerpt( $p ) ? get_the_excerpt( $p ) : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $p->post_content ) ), 28, '…' );
		}
		return $desc;
	}
	if ( is_category() || is_tag() ) {
		$d = term_description();
		return $d ? wp_strip_all_tags( $d ) : single_term_title( '', false ) . ' — Blog Hospital Nova Tijuana';
	}
	return get_bloginfo( 'description' );
}

add_action( 'wp_head', function () {
	if ( nova_seo_plugin_active() ) {
		return;
	}
	$desc  = esc_attr( wp_strip_all_tags( nova_meta_description() ) );
	$title = esc_attr( wp_get_document_title() );
	if ( is_front_page() ) {
		$url = home_url( '/' );
	} elseif ( is_singular() ) {
		$url = get_permalink();
	} else {
		$url = get_pagenum_link( max( 1, (int) get_query_var( 'paged' ) ) );
	}
	$url   = esc_url( $url );
	$img   = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : nova_img( 'og-hospital-nova.jpg' );
	$type  = is_single() ? 'article' : 'website';
	$loc   = 'en' === nova_lang() ? 'en_US' : 'es_MX';

	echo "\n<!-- Hospital Nova SEO -->\n";
	echo '<meta name="description" content="' . $desc . '">' . "\n";
	echo '<link rel="canonical" href="' . $url . '">' . "\n";
	echo '<meta name="robots" content="' . ( is_search() || is_404() ? 'noindex,follow' : 'index,follow,max-image-preview:large' ) . '">' . "\n";
	echo '<meta property="og:locale" content="' . $loc . '">' . "\n";
	echo '<meta property="og:type" content="' . $type . '">' . "\n";
	echo '<meta property="og:site_name" content="Hospital Nova">' . "\n";
	echo '<meta property="og:title" content="' . $title . '">' . "\n";
	echo '<meta property="og:description" content="' . $desc . '">' . "\n";
	echo '<meta property="og:url" content="' . $url . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="geo.region" content="MX-BCN">' . "\n";
	echo '<meta name="geo.placename" content="Tijuana">' . "\n";
	if ( nova_opt( 'lat' ) && nova_opt( 'lng' ) ) {
		echo '<meta name="geo.position" content="' . esc_attr( nova_opt( 'lat' ) . ';' . nova_opt( 'lng' ) ) . '">' . "\n";
	}
	// hreflang: Polylang ya lo imprime; respaldo si no está activo.
	if ( ! function_exists( 'pll_the_languages' ) ) {
		echo '<link rel="alternate" hreflang="es-MX" href="' . $url . '">' . "\n";
		echo '<link rel="alternate" hreflang="x-default" href="' . $url . '">' . "\n";
	}
}, 1 );

/** Título optimizado para la portada. */
add_filter( 'pre_get_document_title', function ( $t ) {
	if ( is_front_page() && ! nova_seo_plugin_active() ) {
		return nova_t( 'Hospital en Tijuana 24 Horas | Especialistas y Urgencias | Hospital Nova', '24-Hour Hospital in Tijuana | Specialists & ER | Hospital Nova' );
	}
	return $t;
} );

/** Schema.org JSON-LD. */
add_action( 'wp_head', function () {
	$graph = array();
	$id    = home_url( '/#hospital' );
	$same  = array_values( array_filter( array( nova_opt( 'facebook' ), nova_opt( 'instagram' ) ) ) );

	$hospital = array(
		'@type'                     => array( 'Hospital', 'MedicalOrganization' ),
		'@id'                       => $id,
		'name'                      => 'Hospital Nova',
		'slogan'                    => '¡Servicios Médicos de Confianza!',
		'url'                       => home_url( '/' ),
		'logo'                      => nova_img( 'og-hospital-nova.jpg' ),
		'image'                     => nova_img( 'og-hospital-nova.jpg' ),
		'telephone'                 => '+' . nova_digits( nova_opt( 'phone' ) ),
		'email'                     => nova_opt( 'email_to' ),
		'priceRange'                => '$$',
		'currenciesAccepted'        => 'MXN, USD',
		'availableLanguage'         => array( 'es', 'en' ),
		'address'                   => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => nova_opt( 'address' ),
			'addressLocality' => 'Tijuana',
			'addressRegion'   => 'Baja California',
			'addressCountry'  => 'MX',
		),
		'openingHoursSpecification' => array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
			'opens'     => '00:00',
			'closes'    => '23:59',
		),
		'medicalSpecialty'          => array( 'Emergency', 'InternalMedicine', 'Neurologic', 'Oncologic', 'Obstetric', 'Surgical' ),
		'availableService'          => array(
			array( '@type' => 'MedicalProcedure', 'name' => nova_t( 'Cirugía oncológica', 'Surgical oncology' ) ),
			array( '@type' => 'MedicalProcedure', 'name' => nova_t( 'Parto y cesárea', 'Vaginal birth and C-section' ) ),
			array( '@type' => 'MedicalTest', 'name' => nova_t( 'Laboratorio clínico 24/7', '24/7 clinical laboratory' ) ),
			array( '@type' => 'MedicalTest', 'name' => nova_t( 'Rayos X e imagen', 'X-ray and imaging' ) ),
		),
		'areaServed'                => array( 'Tijuana', 'Rosarito', 'Tecate', 'San Diego' ),
		'sameAs'                    => $same,
		'emergencyService'          => true,
	);
	if ( nova_opt( 'lat' ) && nova_opt( 'lng' ) ) {
		$hospital['geo'] = array( '@type' => 'GeoCoordinates', 'latitude' => nova_opt( 'lat' ), 'longitude' => nova_opt( 'lng' ) );
	}
	$graph[] = $hospital;

	if ( is_front_page() ) {
		$faq = array( '@type' => 'FAQPage', 'mainEntity' => array() );
		foreach ( nova_faqs() as $f ) {
			$faq['mainEntity'][] = array( '@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $f[1] ) );
		}
		$graph[] = $faq;
	}

	if ( is_single() && ! nova_seo_plugin_active() ) {
		$graph[] = array(
			'@type'            => 'MedicalWebPage',
			'headline'         => get_the_title(),
			'description'      => wp_strip_all_tags( nova_meta_description() ),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'inLanguage'       => 'en' === nova_lang() ? 'en-US' : 'es-MX',
			'mainEntityOfPage' => get_permalink(),
			'image'            => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : nova_img( 'og-hospital-nova.jpg' ),
			'author'           => array( '@type' => 'Organization', 'name' => 'Hospital Nova', '@id' => $id ),
			'publisher'        => array( '@id' => $id ),
			'lastReviewed'     => get_the_modified_date( 'c' ),
		);
	}

	if ( ! is_front_page() && ( is_singular() || is_archive() ) ) {
		$crumbs = array( array( '@type' => 'ListItem', 'position' => 1, 'name' => nova_t( 'Inicio', 'Home' ), 'item' => home_url( '/' ) ) );
		if ( is_single() ) {
			$crumbs[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => get_permalink( get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' ) );
		}
		$crumbs[] = array( '@type' => 'ListItem', 'position' => count( $crumbs ) + 1, 'name' => wp_strip_all_tags( is_singular() ? get_the_title() : get_the_archive_title() ) );
		$graph[]  = array( '@type' => 'BreadcrumbList', 'itemListElement' => $crumbs );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}, 5 );

/** Campo "Meta description" en el editor de entradas y páginas. */
add_action( 'add_meta_boxes', function () {
	if ( nova_seo_plugin_active() ) {
		return;
	}
	add_meta_box( 'nova_seo', 'SEO — Meta description', function ( $post ) {
		wp_nonce_field( 'nova_seo', 'nova_seo_nonce' );
		$v = get_post_meta( $post->ID, '_nova_meta_description', true );
		echo '<textarea name="nova_meta_description" rows="3" style="width:100%" maxlength="170">' . esc_textarea( $v ) . '</textarea><p class="description">140–160 caracteres con la palabra clave principal.</p>';
	}, array( 'post', 'page' ), 'normal', 'high' );
} );
add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['nova_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nova_seo_nonce'] ) ), 'nova_seo' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['nova_meta_description'] ) ) {
		update_post_meta( $post_id, '_nova_meta_description', sanitize_textarea_field( wp_unslash( $_POST['nova_meta_description'] ) ) );
	}
} );
