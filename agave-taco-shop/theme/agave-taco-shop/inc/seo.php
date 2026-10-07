<?php
/**
 * Built-in SEO layer.
 *
 * - Always: Restaurant / LocalBusiness, WebSite, Menu, FAQ, BlogPosting and
 *   BreadcrumbList JSON-LD (rich results + Google Maps relevance).
 * - Only when no SEO plugin is active: meta description, robots, canonical
 *   fallbacks, Open Graph and Twitter cards. Yoast / Rank Math / AIOSEO take
 *   over automatically and read the same meta imported from the XML.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is a dedicated SEO plugin handling meta tags?
 */
function agave_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || class_exists( 'The_SEO_Framework\Load' );
}

/**
 * Meta description for the current request.
 */
function agave_meta_description() {
	$fallback = 'Agave Taco Shop in Point Loma, San Diego: famous quesabirria and birria tacos with consommé, California burritos, breakfast burritos from 7 AM, drive-thru, catering and delivery.';

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		foreach ( array( '_yoast_wpseo_metadesc', 'rank_math_description', '_agave_meta_description' ) as $key ) {
			$value = get_post_meta( $post_id, $key, true );
			if ( $value ) {
				return $value;
			}
		}
		if ( has_excerpt( $post_id ) ) {
			return wp_strip_all_tags( get_the_excerpt( $post_id ) );
		}
		$content = wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post_id ) ) );
		if ( $content ) {
			return wp_trim_words( $content, 28, '…' );
		}
	}
	if ( is_category() || is_tag() ) {
		$desc = term_description();
		if ( $desc ) {
			return wp_strip_all_tags( $desc );
		}
	}
	return $fallback;
}

/**
 * SEO title override (imported _yoast_wpseo_title) when no SEO plugin is active.
 *
 * @param array $parts Title parts.
 * @return array
 */
function agave_document_title_parts( $parts ) {
	if ( agave_seo_plugin_active() ) {
		return $parts;
	}
	if ( is_front_page() ) {
		$parts['title']   = 'Agave Taco Shop | Best Birria Tacos & Quesabirria in Point Loma, San Diego';
		unset( $parts['tagline'], $parts['site'] );
		return $parts;
	}
	if ( is_singular() ) {
		$custom = get_post_meta( get_queried_object_id(), '_yoast_wpseo_title', true );
		if ( $custom && false === strpos( $custom, '%%' ) ) {
			$parts['title'] = $custom;
			unset( $parts['site'] );
		}
	}
	return $parts;
}
add_filter( 'document_title_parts', 'agave_document_title_parts' );
add_filter(
	'document_title_separator',
	static function () {
		return '|';
	}
);

/**
 * Meta tags (only when no SEO plugin).
 */
function agave_meta_tags() {
	if ( agave_seo_plugin_active() ) {
		return;
	}

	$desc  = agave_meta_description();
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ? '/' . $GLOBALS['wp']->request . '/' : '/' ) );
	$image = agave_img( 'hero-quesabirria', 'agave-wide' );
	$type  = is_singular( 'post' ) ? 'article' : ( is_front_page() ? 'restaurant.restaurant' : 'website' );

	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'agave-wide' );
	}

	echo "\n<!-- Agave SEO -->\n";
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );

	if ( is_search() || is_404() || is_paged() && ! is_home() ) {
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	} else {
		echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">' . "\n";
	}

	if ( ! is_singular() && ( is_front_page() || is_home() || is_archive() ) ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
	}

	$og = array(
		'og:locale'      => 'en_US',
		'og:type'        => $type,
		'og:title'       => $title,
		'og:description' => $desc,
		'og:url'         => $url,
		'og:site_name'   => agave_biz( 'name' ),
		'og:image'       => $image,
		'og:image:alt'   => 'Quesabirria tacos with consommé at Agave Taco Shop, Point Loma San Diego',
	);
	foreach ( $og as $property => $content ) {
		printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $property ), esc_attr( $content ) );
	}
	if ( is_front_page() ) {
		printf( '<meta property="restaurant:contact_info:street_address" content="%s">' . "\n", esc_attr( agave_biz( 'street' ) ) );
		printf( '<meta property="restaurant:contact_info:locality" content="%s">' . "\n", esc_attr( agave_biz( 'city' ) ) );
		printf( '<meta property="restaurant:contact_info:region" content="%s">' . "\n", esc_attr( agave_biz( 'region' ) ) );
		printf( '<meta property="restaurant:contact_info:postal_code" content="%s">' . "\n", esc_attr( agave_biz( 'zip' ) ) );
		printf( '<meta property="restaurant:contact_info:phone_number" content="%s">' . "\n", esc_attr( agave_biz( 'phone' ) ) );
	}
	if ( is_singular( 'post' ) ) {
		printf( '<meta property="article:published_time" content="%s">' . "\n", esc_attr( get_the_date( 'c' ) ) );
		printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );
		printf( '<meta property="article:publisher" content="%s">' . "\n", esc_attr( agave_biz( 'facebook_url' ) ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );
	echo '<meta name="geo.region" content="US-CA">' . "\n";
	echo '<meta name="geo.placename" content="Point Loma, San Diego">' . "\n";
	printf( '<meta name="geo.position" content="%s;%s">' . "\n", esc_attr( agave_biz( 'lat' ) ), esc_attr( agave_biz( 'lng' ) ) );
	printf( '<meta name="ICBM" content="%s, %s">' . "\n", esc_attr( agave_biz( 'lat' ) ), esc_attr( agave_biz( 'lng' ) ) );
	echo '<meta name="theme-color" content="#0d1f1a">' . "\n";
	echo "<!-- /Agave SEO -->\n";
}
add_action( 'wp_head', 'agave_meta_tags', 1 );

/**
 * Restaurant entity (re-used by other graphs via @id).
 */
function agave_schema_restaurant() {
	$home  = home_url( '/' );
	$hours = array();
	foreach ( agave_biz( 'hours_schema' ) as $row ) {
		$hours[] = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => $row['days'],
			'opens'     => $row['opens'],
			'closes'    => $row['close'],
		);
	}
	$menu_page = get_page_by_path( 'menu' );
	$logo_id   = get_theme_mod( 'custom_logo' );

	$schema = array(
		'@type'                     => array( 'Restaurant', 'LocalBusiness' ),
		'@id'                       => $home . '#restaurant',
		'name'                      => agave_biz( 'name' ),
		'alternateName'             => array( 'Agave Taco Shop Point Loma', 'Agave Tacos San Diego' ),
		'description'               => 'Mexican taco shop in Point Loma, San Diego, famous for slow-braised birria, quesabirria tacos with consommé, California burritos, breakfast burritos and aguas frescas. Drive-thru, takeout, delivery and catering.',
		'url'                       => $home,
		'telephone'                 => agave_biz( 'phone_e164' ),
		'priceRange'                => agave_biz( 'price_range' ),
		'servesCuisine'             => array( 'Mexican', 'Tacos', 'Birria', 'Tex-Mex', 'Breakfast' ),
		'acceptsReservations'       => 'False',
		'image'                     => array( agave_img( 'hero-quesabirria', 'agave-wide' ), agave_img( 'dish-quesabirria', 'large' ) ),
		'address'                   => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => agave_biz( 'street' ),
			'addressLocality' => agave_biz( 'city' ),
			'addressRegion'   => agave_biz( 'region' ),
			'postalCode'      => agave_biz( 'zip' ),
			'addressCountry'  => agave_biz( 'country' ),
		),
		'geo'                       => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) agave_biz( 'lat' ),
			'longitude' => (float) agave_biz( 'lng' ),
		),
		'areaServed'                => array( 'Point Loma', 'Ocean Beach', 'Midway District', 'Loma Portal', 'Liberty Station', 'Mission Hills', 'Old Town', 'San Diego' ),
		'hasMap'                    => agave_biz( 'maps_url' ),
		'openingHoursSpecification' => $hours,
		'sameAs'                    => array_values(
			array_filter(
				array(
					agave_biz( 'facebook_url' ),
					agave_biz( 'instagram_url' ),
					agave_biz( 'yelp_url' ),
					agave_biz( 'tripadvisor_url' ),
				)
			)
		),
		'potentialAction'           => array(
			'@type'  => 'OrderAction',
			'target' => array(
				'@type'          => 'EntryPoint',
				'urlTemplate'    => agave_biz( 'order_url' ),
				'actionPlatform' => array( 'http://schema.org/DesktopWebPlatform', 'http://schema.org/MobileWebPlatform' ),
			),
			'deliveryMethod' => array( 'http://purl.org/goodrelations/v1#DeliveryModePickUp', 'http://purl.org/goodrelations/v1#DeliveryModeOwnFleet' ),
		),
		'amenityFeature'            => array(
			array( '@type' => 'LocationFeatureSpecification', 'name' => 'Drive-thru', 'value' => true ),
			array( '@type' => 'LocationFeatureSpecification', 'name' => 'Outdoor seating', 'value' => true ),
			array( '@type' => 'LocationFeatureSpecification', 'name' => 'Takeout', 'value' => true ),
			array( '@type' => 'LocationFeatureSpecification', 'name' => 'Delivery', 'value' => true ),
			array( '@type' => 'LocationFeatureSpecification', 'name' => 'Catering', 'value' => true ),
		),
	);
	if ( $menu_page ) {
		$schema['hasMenu'] = get_permalink( $menu_page );
	}
	if ( $logo_id ) {
		$schema['logo'] = wp_get_attachment_image_url( $logo_id, 'full' );
	}
	return $schema;
}

/**
 * Menu graph for the Menu page.
 */
function agave_schema_menu() {
	$sections = array();
	foreach ( agave_menu() as $section ) {
		$items = array();
		foreach ( $section['items'] as $item ) {
			$items[] = array(
				'@type'       => 'MenuItem',
				'name'        => $item['name'],
				'description' => $item['desc'],
			);
		}
		$sections[] = array(
			'@type'       => 'MenuSection',
			'name'        => $section['title'],
			'description' => $section['lede'],
			'hasMenuItem' => $items,
		);
	}
	return array(
		'@type'          => 'Menu',
		'@id'            => get_permalink() . '#menu',
		'name'           => 'Agave Taco Shop Menu',
		'inLanguage'     => 'en-US',
		'hasMenuSection' => $sections,
	);
}

/**
 * FAQ graph — parsed from <details class="faq"> blocks in page content.
 *
 * @param string $content Post content.
 * @return array|null
 */
function agave_schema_faq( $content ) {
	if ( false === strpos( $content, 'faq' ) ) {
		return null;
	}
	preg_match_all( '#<details[^>]*class="[^"]*faq[^"]*"[^>]*>\s*<summary>(.*?)</summary>(.*?)</details>#si', $content, $matches, PREG_SET_ORDER );
	if ( ! $matches ) {
		return null;
	}
	$entities = array();
	foreach ( $matches as $m ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $m[1] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => trim( wp_strip_all_tags( $m[2] ) ),
			),
		);
	}
	return array(
		'@type'      => 'FAQPage',
		'@id'        => get_permalink() . '#faq',
		'mainEntity' => $entities,
	);
}

/**
 * Print the JSON-LD @graph.
 */
function agave_print_schema() {
	$home  = home_url( '/' );
	$graph = array(
		agave_schema_restaurant(),
		array(
			'@type'           => 'WebSite',
			'@id'             => $home . '#website',
			'url'             => $home,
			'name'            => agave_biz( 'name' ),
			'inLanguage'      => 'en-US',
			'publisher'       => array( '@id' => $home . '#restaurant' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => $home . '?s={search_term_string}',
				'query-input' => 'required name=search_term_string',
			),
		),
	);

	if ( ! is_front_page() ) {
		$items = array();
		foreach ( agave_breadcrumb_trail() as $i => $crumb ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $i + 1,
				'name'     => $crumb['name'],
				'item'     => $crumb['url'],
			);
		}
		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'@id'             => ( is_singular() ? get_permalink() : $home ) . '#breadcrumb',
			'itemListElement' => $items,
		);
	}

	if ( is_page_template( 'page-templates/template-menu.php' ) || is_page( 'menu' ) ) {
		$graph[] = agave_schema_menu();
	}

	if ( is_singular() ) {
		$faq = agave_schema_faq( get_post_field( 'post_content', get_queried_object_id() ) );
		if ( $faq ) {
			$graph[] = $faq;
		}
	}

	if ( is_singular( 'post' ) ) {
		$post    = get_queried_object();
		$graph[] = array(
			'@type'            => 'BlogPosting',
			'@id'              => get_permalink() . '#article',
			'headline'         => get_the_title(),
			'description'      => agave_meta_description(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'mainEntityOfPage' => get_permalink(),
			'image'            => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'agave-wide' ) : agave_img( 'hero-quesabirria', 'agave-wide' ),
			'author'           => array(
				'@type' => 'Organization',
				'name'  => agave_biz( 'name' ),
				'url'   => $home,
			),
			'publisher'        => array( '@id' => $home . '#restaurant' ),
			'keywords'         => implode( ', ', wp_list_pluck( (array) get_the_tags( $post->ID ), 'name' ) ),
			'inLanguage'       => 'en-US',
		);
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}
add_action( 'wp_head', 'agave_print_schema', 20 );

/**
 * Add descriptive alt text to featured images that have none.
 *
 * @param array   $attr       Attributes.
 * @param WP_Post $attachment Attachment.
 * @return array
 */
function agave_image_alt_fallback( $attr, $attachment ) {
	if ( empty( $attr['alt'] ) ) {
		$attr['alt'] = trim( get_the_title( $attachment->post_parent ) . ' — Agave Taco Shop, Point Loma San Diego', ' —' );
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'agave_image_alt_fallback', 10, 2 );

/**
 * Keep low-value archives out of the index when no SEO plugin is active.
 */
function agave_robots( $robots ) {
	if ( agave_seo_plugin_active() ) {
		return $robots;
	}
	if ( is_author() || is_date() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'agave_robots' );

/**
 * Robots.txt additions (WordPress core already adds the sitemap line).
 *
 * @param string $output Robots output.
 * @param bool   $public Blog public.
 * @return string
 */
function agave_robots_txt( $output, $public ) {
	if ( ! $public ) {
		return $output;
	}
	// Keep internal search results out of the crawl budget (inside the User-agent group).
	$rules = "Disallow: /?s=\nDisallow: /search/\n";
	if ( false !== strpos( $output, "Allow: /wp-admin/admin-ajax.php\n" ) ) {
		return str_replace( "Allow: /wp-admin/admin-ajax.php\n", "Allow: /wp-admin/admin-ajax.php\n" . $rules, $output );
	}
	return $output . $rules;
}
add_filter( 'robots_txt', 'agave_robots_txt', 10, 2 );
