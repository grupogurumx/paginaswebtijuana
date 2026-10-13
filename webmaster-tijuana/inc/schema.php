<?php
/**
 * Datos estructurados (JSON-LD).
 *
 * @package WebmasterTijuana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wmt_schema() {
	$sitio = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'ProfessionalService',
		'@id'         => home_url( '/#negocio' ),
		'name'        => get_bloginfo( 'name' ),
		'description' => get_bloginfo( 'description' ),
		'url'         => home_url( '/' ),
		'logo'        => WMT_URI . '/assets/img/logo.png',
		'image'       => WMT_URI . '/assets/img/slide-diseno-web.jpg',
		'telephone'   => '+52 ' . wmt_opt( 'telefono' ),
		'email'       => wmt_opt( 'email' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => 'Tijuana',
			'addressRegion'   => 'Baja California',
			'addressCountry'  => 'MX',
		),
		'areaServed'  => array( 'Tijuana', 'Rosarito', 'Tecate', 'Ensenada', 'Mexicali' ),
		'sameAs'      => array_values( wp_list_pluck( wmt_socials(), 'url' ) ),
	);

	$servicios = get_posts( array( 'post_type' => 'servicio', 'posts_per_page' => 20, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
	if ( $servicios ) {
		$sitio['hasOfferCatalog'] = array(
			'@type'           => 'OfferCatalog',
			'name'            => __( 'Servicios', 'webmaster-tijuana' ),
			'itemListElement' => array_map(
				function ( $s ) {
					return array(
						'@type'       => 'Offer',
						'itemOffered' => array(
							'@type' => 'Service',
							'name'  => get_the_title( $s ),
							'url'   => get_permalink( $s ),
						),
					);
				},
				$servicios
			),
		);
	}

	$grafos = array();
	if ( is_front_page() ) {
		$grafos[] = $sitio;
	}

	if ( is_singular( 'servicio' ) ) {
		$grafos[] = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Service',
			'name'        => get_the_title(),
			'description' => wp_strip_all_tags( get_the_excerpt() ),
			'url'         => get_permalink(),
			'areaServed'  => 'Tijuana, Baja California',
			'provider'    => array( '@id' => home_url( '/#negocio' ), '@type' => 'ProfessionalService', 'name' => get_bloginfo( 'name' ) ),
		);
	}

	foreach ( $grafos as $g ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $g, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	}
}
add_action( 'wp_head', 'wmt_schema', 20 );

/**
 * Meta descripción básica cuando no hay un plugin de SEO activo.
 */
function wmt_meta_description() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'All_in_One_SEO_Pack' ) ) {
		return;
	}
	$desc = '';
	if ( is_front_page() ) {
		$desc = 'Webmaster Tijuana: agencia de diseño de páginas web, posicionamiento SEO, tiendas virtuales y marketing digital en Tijuana. ¡Cotiza gratis!';
	} elseif ( is_singular() ) {
		$desc = get_the_excerpt();
	} elseif ( is_post_type_archive( 'servicio' ) ) {
		$desc = 'Servicios de diseño web, marketing digital, publicidad en Google y redes sociales, y tiendas virtuales en Tijuana.';
	}
	$desc = trim( wp_strip_all_tags( $desc ) );
	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( wp_html_excerpt( $desc, 160, '…' ) ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( wp_html_excerpt( $desc, 200, '…' ) ) );
	}
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( '<meta property="og:locale" content="es_MX">' . "\n" );
	$img = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'wmt-wide' ) : WMT_URI . '/assets/img/slide-diseno-web.jpg';
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $img ) );
}
add_action( 'wp_head', 'wmt_meta_description', 2 );
