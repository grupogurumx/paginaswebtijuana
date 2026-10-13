<?php
/**
 * Datos estructurados (JSON-LD).
 *
 * Emite MedicalClinic + Physician + WebSite en todo el sitio, y añade
 * MedicalTest y FAQPage en las páginas de procedimiento.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Imprime el grafo principal.
 */
function cardio_schema_global() {
	$home = trailingslashit( home_url() );

	$clinica = array(
		'@type'             => array( 'MedicalClinic', 'LocalBusiness' ),
		'@id'               => $home . '#clinica',
		'name'              => get_bloginfo( 'name' ),
		'description'       => get_bloginfo( 'description' ),
		'url'               => $home,
		'telephone'         => cardio_opt( 'tel' ),
		'email'             => cardio_opt( 'email' ),
		'priceRange'        => '$$',
		'currenciesAccepted' => 'MXN, USD',
		'medicalSpecialty'  => 'Cardiovascular',
		'address'           => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => trim( cardio_opt( 'calle' ) . ', ' . cardio_opt( 'calle2' ), ', ' ),
			'addressLocality' => cardio_opt( 'ciudad' ),
			'addressRegion'   => cardio_opt( 'estado' ),
			'postalCode'      => cardio_opt( 'cp' ),
			'addressCountry'  => 'MX',
		),
		'areaServed'        => array(
			array( '@type' => 'City', 'name' => 'Tijuana' ),
			array( '@type' => 'City', 'name' => 'Rosarito' ),
			array( '@type' => 'City', 'name' => 'Tecate' ),
			array( '@type' => 'City', 'name' => 'San Diego' ),
		),
	);

	$lat = cardio_opt( 'lat' );
	$lng = cardio_opt( 'lng' );
	if ( $lat && $lng ) {
		$clinica['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $lat,
			'longitude' => $lng,
		);
	}

	$logo_id = get_theme_mod( 'custom_logo' );
	$logo    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : CARDIO_URI . '/assets/img/logo-mark.png';
	$clinica['logo']  = $logo;
	$clinica['image'] = CARDIO_URI . '/assets/img/hero-ecocardiografia.jpg';

	$redes = array_filter( array( cardio_opt( 'facebook' ), cardio_opt( 'instagram' ), cardio_opt( 'google' ) ) );
	if ( $redes ) {
		$clinica['sameAs'] = array_values( $redes );
	}

	// Servicios: se toman de los procedimientos publicados.
	$procs = get_posts(
		array(
			'post_type'      => 'procedimiento',
			'posts_per_page' => 20,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);
	if ( $procs ) {
		$servicios = array();
		foreach ( $procs as $proc ) {
			$servicios[] = array(
				'@type' => 'MedicalTest',
				'name'  => $proc->post_title,
				'url'   => get_permalink( $proc ),
			);
		}
		$clinica['availableService'] = $servicios;
	}

	$medico = array(
		'@type'            => 'Physician',
		'@id'              => $home . '#medico',
		'name'             => cardio_opt( 'medico' ),
		'jobTitle'         => __( 'Médico cardiólogo', 'cardio-canseco' ),
		'medicalSpecialty' => 'Cardiovascular',
		'worksFor'         => array( '@id' => $home . '#clinica' ),
		'memberOf'         => array(
			array( '@type' => 'MedicalOrganization', 'name' => 'Asociación Nacional de Cardiólogos de México' ),
			array( '@type' => 'MedicalOrganization', 'name' => 'Sociedad de Cardiología de Baja California' ),
		),
	);

	$sitio = array(
		'@type'      => 'WebSite',
		'@id'        => $home . '#sitio',
		'url'        => $home,
		'name'       => get_bloginfo( 'name' ),
		'inLanguage' => 'es-MX',
		'publisher'  => array( '@id' => $home . '#clinica' ),
	);

	$graph = array( $clinica, $medico, $sitio );

	// Migas de pan en páginas interiores.
	if ( is_singular() && ! is_front_page() ) {
		$items = array(
			array(
				'@type'    => 'ListItem',
				'position' => 1,
				'name'     => __( 'Inicio', 'cardio-canseco' ),
				'item'     => $home,
			),
		);

		if ( is_singular( 'procedimiento' ) ) {
			$archive = get_post_type_archive_link( 'procedimiento' );
			if ( $archive ) {
				$items[] = array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => __( 'Procedimientos', 'cardio-canseco' ),
					'item'     => $archive,
				);
			}
		}

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);

		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		);
	}

	cardio_print_jsonld(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		)
	);
}
add_action( 'wp_head', 'cardio_schema_global', 5 );

/**
 * Datos estructurados de la página de procedimiento.
 */
function cardio_schema_procedimiento() {
	if ( ! is_singular( 'procedimiento' ) ) {
		return;
	}

	$id   = get_the_ID();
	$home = trailingslashit( home_url() );

	$test = array(
		'@context'          => 'https://schema.org',
		'@type'             => 'MedicalTest',
		'name'              => get_the_title(),
		'description'       => wp_strip_all_tags( get_the_excerpt() ),
		'url'               => get_permalink(),
		'availableAtOrFrom' => array( '@id' => $home . '#clinica' ),
		'performer'         => array( '@id' => $home . '#medico' ),
	);

	if ( has_post_thumbnail() ) {
		$test['image'] = get_the_post_thumbnail_url( $id, 'cardio-card' );
	}

	cardio_print_jsonld( $test );

	// Preguntas frecuentes.
	$faq = cardio_faq_pairs( $id );
	if ( $faq ) {
		$entries = array();
		foreach ( $faq as $pair ) {
			$entries[] = array(
				'@type'          => 'Question',
				'name'           => $pair['q'],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $pair['a'] ),
				),
			);
		}
		cardio_print_jsonld(
			array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $entries,
			)
		);
	}
}
add_action( 'wp_head', 'cardio_schema_procedimiento', 6 );

/**
 * Imprime un bloque JSON-LD.
 *
 * @param array $data Datos.
 */
function cardio_print_jsonld( $data ) {
	echo "\n" . '<script type="application/ld+json">' . "\n";
	echo wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	echo "\n" . '</script>' . "\n";
}

/* -------------------------------------------------------------------------
 * Etiquetas Open Graph
 * ---------------------------------------------------------------------- */

/**
 * Añade Open Graph si no hay un plugin de SEO que ya lo haga.
 */
function cardio_open_graph() {
	// Rank Math, Yoast y SEOPress ya emiten estas etiquetas.
	if ( defined( 'RANK_MATH_VERSION' ) || defined( 'WPSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) {
		return;
	}

	$title = wp_get_document_title();
	$url   = home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );

	if ( is_singular() ) {
		$desc  = wp_strip_all_tags( get_the_excerpt() );
		$image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'cardio-hero' ) : '';
	} else {
		$desc  = get_bloginfo( 'description' );
		$image = '';
	}

	if ( ! $image ) {
		$image = CARDIO_URI . '/assets/img/hero-ecocardiografia.jpg';
	}

	printf( '<meta property="og:type" content="%s">' . "\n", is_singular() ? 'article' : 'website' );
	printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( str_replace( '-', '_', get_bloginfo( 'language' ) ) ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );

	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
}
add_action( 'wp_head', 'cardio_open_graph', 4 );
