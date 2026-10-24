<?php
/**
 * Built-in SEO: meta description, Open Graph, Twitter, hreflang, robots.txt
 * and JSON-LD schema (Physician, MedicalClinic, MedicalProcedure, FAQPage,
 * BlogPosting, BreadcrumbList, WebSite).
 *
 * If Yoast SEO or Rank Math is active, the meta/OG tags are left to the plugin
 * (the imported pages already carry Yoast fields) and only hreflang + medical
 * schema are printed here.
 */

defined( 'ABSPATH' ) || exit;

function dmc_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' );
}

/** SEO title / description for the current view. */
function dmc_seo_title() {
	$id = get_queried_object_id();
	if ( $id && ( is_singular() || is_home() ) ) {
		$t = get_post_meta( $id, '_yoast_wpseo_title', true );
		if ( $t ) {
			return str_replace( array( '%%sep%%', '%%sitename%%' ), array( '|', get_bloginfo( 'name' ) ), $t );
		}
	}
	if ( is_front_page() ) {
		return 'es' === dmc_lang()
			? 'Cirugía Bariátrica en Tijuana | Dr. Mario Camelo #SuperDrSleeve'
			: 'Bariatric Surgery in Tijuana | Dr. Mario Camelo #SuperDrSleeve';
	}
	return '';
}

function dmc_seo_description() {
	$id = get_queried_object_id();
	if ( $id && ( is_singular() || is_home() ) ) {
		$d = get_post_meta( $id, '_yoast_wpseo_metadesc', true );
		if ( $d ) {
			return $d;
		}
		if ( has_excerpt( $id ) ) {
			return wp_strip_all_tags( get_the_excerpt( $id ) );
		}
	}
	return 'es' === dmc_lang()
		? 'Manga gástrica y bypass gástrico en Tijuana con el Dr. Mario Camelo, cirujano bariatra certificado con más de 10,000 cirugías. Valoración gratuita y financiamiento.'
		: 'Gastric sleeve and gastric bypass in Tijuana with Dr. Mario Camelo, certified bariatric surgeon with 10,000+ surgeries. Free evaluation and patient financing.';
}

add_filter(
	'pre_get_document_title',
	function ( $title ) {
		if ( dmc_seo_plugin_active() ) {
			return $title;
		}
		$custom = dmc_seo_title();
		return $custom ? $custom : $title;
	}
);

add_filter( 'document_title_separator', fn() => '|' );

/** Share image for OG. */
function dmc_og_image() {
	$id = get_queried_object_id();
	if ( $id && has_post_thumbnail( $id ) ) {
		return get_the_post_thumbnail_url( $id, 'full' );
	}
	return dmc_img( 'hero-quirofano.png', 'dr-camelo-quirofano-1.jpg' );
}

function dmc_current_url() {
	if ( is_front_page() ) {
		return dmc_home_url();
	}
	$id = get_queried_object_id();
	if ( $id && ( is_singular() || is_home() ) ) {
		return get_permalink( $id );
	}
	global $wp;
	return home_url( trailingslashit( $wp->request ) );
}

add_action(
	'wp_head',
	function () {
		$url  = dmc_current_url();
		$lang = dmc_lang();

		// hreflang alternates.
		$en = 'en' === $lang ? $url : dmc_translation_url( 'en' );
		$es = 'es' === $lang ? $url : dmc_translation_url( 'es' );
		$has_pair = is_front_page() || get_post_meta( get_queried_object_id(), '_dmc_translation', true );
		if ( $has_pair ) {
			printf( '<link rel="alternate" hreflang="en-US" href="%s">' . "\n", esc_url( $en ) );
			printf( '<link rel="alternate" hreflang="es-MX" href="%s">' . "\n", esc_url( $es ) );
			printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( $en ) );
		}

		if ( dmc_seo_plugin_active() ) {
			return;
		}

		$title = wp_get_document_title();
		$desc  = dmc_seo_description();
		$img   = dmc_og_image();

		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
		echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">' . "\n";
		if ( is_front_page() ) {
			printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
		}
		printf( '<meta property="og:locale" content="%s">' . "\n", 'es' === $lang ? 'es_MX' : 'en_US' );
		printf( '<meta property="og:type" content="%s">' . "\n", is_single() ? 'article' : 'website' );
		printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
		printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
		if ( $img ) {
			printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $img ) );
		}
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
		if ( $img ) {
			printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $img ) );
		}
	},
	2
);

/** JSON-LD graph. */
add_action(
	'wp_head',
	function () {
		$home  = home_url( '/' );
		$lang  = dmc_lang();
		$logo  = DMC_URI . '/assets/img/logo.svg';
		$custom_logo = get_theme_mod( 'custom_logo' );
		if ( $custom_logo ) {
			$logo = wp_get_attachment_image_url( $custom_logo, 'full' );
		}
		$same_as = array_values( array_filter( array( dmc_opt( 'dmc_facebook' ), dmc_opt( 'dmc_instagram' ), dmc_opt( 'dmc_youtube' ), dmc_opt( 'dmc_tiktok' ) ) ) );

		$address = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => dmc_opt( 'dmc_address' ),
			'addressLocality' => dmc_opt( 'dmc_city' ),
			'addressRegion'   => dmc_opt( 'dmc_region' ),
			'postalCode'      => dmc_opt( 'dmc_zip' ),
			'addressCountry'  => 'MX',
		);

		$clinic = array(
			'@type'              => array( 'MedicalClinic', 'MedicalBusiness' ),
			'@id'                => $home . '#clinic',
			'name'               => 'Dr. Mario Camelo — Bariatric Surgery',
			'alternateName'      => array( 'Dr. Mario Camelo Cirugía Bariátrica', 'SuperDrSleeve' ),
			'url'                => $home,
			'logo'               => $logo,
			'image'              => dmc_og_image(),
			'description'        => dmc_seo_description(),
			'medicalSpecialty'   => array( 'Surgical', 'Gastroenterologic', 'Endocrine', 'DietNutrition' ),
			'address'            => $address,
			'geo'                => array( '@type' => 'GeoCoordinates', 'latitude' => (float) dmc_opt( 'dmc_lat' ), 'longitude' => (float) dmc_opt( 'dmc_lng' ) ),
			'areaServed'         => array( 'Tijuana', 'San Diego', 'Los Angeles', 'California', 'Arizona', 'Texas', 'United States', 'Mexico' ),
			'availableLanguage'  => array( 'English', 'Spanish' ),
			'openingHoursSpecification' => array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
				'opens'     => '09:00',
				'closes'    => '18:00',
			),
			'sameAs'             => $same_as,
			'availableService'   => array(
				array( '@type' => 'MedicalProcedure', 'name' => 'Gastric Sleeve (Sleeve Gastrectomy)', 'procedureType' => 'https://schema.org/SurgicalProcedure', 'url' => dmc_page_url( 'sleeve', 'en' ) ),
				array( '@type' => 'MedicalProcedure', 'name' => 'Roux-en-Y Gastric Bypass', 'procedureType' => 'https://schema.org/SurgicalProcedure', 'url' => dmc_page_url( 'bypass', 'en' ) ),
				array( '@type' => 'MedicalProcedure', 'name' => 'Revision Bariatric Surgery', 'procedureType' => 'https://schema.org/SurgicalProcedure', 'url' => dmc_page_url( 'revision', 'en' ) ),
				array( '@type' => 'MedicalTherapy', 'name' => 'Metabolic Medicine', 'url' => dmc_page_url( 'metabolic', 'en' ) ),
			),
		);
		if ( dmc_opt( 'dmc_phone' ) ) {
			$clinic['telephone'] = dmc_opt( 'dmc_phone' );
		}
		if ( dmc_opt( 'dmc_email' ) ) {
			$clinic['email'] = dmc_opt( 'dmc_email' );
		}
		if ( dmc_opt( 'dmc_rating' ) && dmc_opt( 'dmc_rating_count' ) ) {
			$clinic['aggregateRating'] = array(
				'@type'       => 'AggregateRating',
				'ratingValue' => dmc_opt( 'dmc_rating' ),
				'reviewCount' => dmc_opt( 'dmc_rating_count' ),
				'bestRating'  => '5',
			);
		}

		$graph = array(
			$clinic,
			array(
				'@type'            => 'Physician',
				'@id'              => $home . '#physician',
				'name'             => 'Dr. Mario Camelo',
				'url'              => dmc_page_url( 'about', 'en' ),
				'image'            => dmc_img( 'dr-camelo-quirofano-1.jpg' ),
				'medicalSpecialty' => array( 'Surgical', 'Gastroenterologic' ),
				'description'      => 'Certified bariatric surgeon (#SuperDrSleeve) with more than 10,000 bariatric surgeries performed.',
				'address'          => $address,
				'worksFor'         => array( '@id' => $home . '#clinic' ),
				'sameAs'           => $same_as,
				'knowsLanguage'    => array( 'es', 'en' ),
			),
			array(
				'@type'      => 'WebSite',
				'@id'        => $home . '#website',
				'url'        => $home,
				'name'       => get_bloginfo( 'name' ),
				'inLanguage' => array( 'en-US', 'es-MX' ),
				'publisher'  => array( '@id' => $home . '#clinic' ),
			),
		);

		// FAQ on the home pages.
		if ( is_front_page() || is_page_template( 'template-home-es.php' ) ) {
			$faq = array();
			for ( $i = 1; $i <= 5; $i++ ) {
				$faq[] = array(
					'@type'          => 'Question',
					'name'           => dmc_t( "faq{$i}_q" ),
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => dmc_t( "faq{$i}_a" ) ),
				);
			}
			$graph[] = array( '@type' => 'FAQPage', 'mainEntity' => $faq, 'inLanguage' => 'es' === $lang ? 'es-MX' : 'en-US' );
		}

		// Procedure pages.
		if ( is_page() ) {
			$schema = get_post_meta( get_queried_object_id(), '_dmc_schema', true );
			if ( $schema ) {
				$graph[] = array(
					'@type'         => 'MedicalProcedure',
					'name'          => $schema,
					'url'           => get_permalink(),
					'procedureType' => 'https://schema.org/SurgicalProcedure',
					'bodyLocation'  => 'Stomach',
					'description'   => dmc_seo_description(),
					'howPerformed'  => 'Laparoscopic (minimally invasive) surgery',
					'provider'      => array( '@id' => $home . '#physician' ),
				);
			}
		}

		// Blog posts.
		if ( is_single() ) {
			$graph[] = array(
				'@type'            => 'BlogPosting',
				'headline'         => get_the_title(),
				'description'      => dmc_seo_description(),
				'image'            => dmc_og_image(),
				'datePublished'    => get_the_date( 'c' ),
				'dateModified'     => get_the_modified_date( 'c' ),
				'inLanguage'       => 'es' === $lang ? 'es-MX' : 'en-US',
				'mainEntityOfPage' => get_permalink(),
				'author'           => array( '@id' => $home . '#physician' ),
				'publisher'        => array( '@id' => $home . '#clinic' ),
				'reviewedBy'       => array( '@id' => $home . '#physician' ),
			);
		}

		// Breadcrumbs.
		if ( ! is_front_page() && ( is_singular() || is_home() ) ) {
			$crumbs = array(
				array( '@type' => 'ListItem', 'position' => 1, 'name' => dmc_t( 'nav_home' ), 'item' => dmc_home_url() ),
			);
			if ( is_single() ) {
				$crumbs[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => dmc_page_url( 'blog' ) );
			}
			$crumbs[] = array( '@type' => 'ListItem', 'position' => count( $crumbs ) + 1, 'name' => wp_strip_all_tags( get_the_title( get_queried_object_id() ) ), 'item' => dmc_current_url() );
			$graph[]  = array( '@type' => 'BreadcrumbList', 'itemListElement' => $crumbs );
		}

		echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	},
	5
);

/** robots.txt: keep internal search out of the index. */
add_filter(
	'robots_txt',
	function ( $output, $public ) {
		if ( ! $public ) {
			return $output;
		}
		// Core (or the SEO plugin) already adds wp-admin rules and the sitemap.
		return preg_replace( '/(Allow: \/wp-admin\/admin-ajax\.php\n)/', "$1Disallow: /?s=\nDisallow: /search/\n", $output, 1 );
	},
	10,
	2
);

/** Remove core sitemap noise (users). */
add_filter(
	'wp_sitemaps_add_provider',
	function ( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	},
	10,
	2
);
