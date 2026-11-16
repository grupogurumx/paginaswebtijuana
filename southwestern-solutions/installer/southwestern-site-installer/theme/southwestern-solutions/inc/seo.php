<?php
/**
 * Built-in SEO: titles, meta description, canonical, Open Graph, Twitter cards
 * and JSON-LD structured data.
 *
 * Reads the post meta written by the XML import:
 *   _sws_seo_title, _sws_seo_desc, _sws_focus_kw, _sws_robots, _sws_course (JSON), _sws_faq_schema
 * The import also writes Yoast (_yoast_wpseo_*) and Rank Math (rank_math_*) keys, so if
 * either plugin is active this module steps aside for titles/meta and keeps only the
 * Course + FAQ schema (which those plugins do not generate from content).
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sws_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

function sws_seo_field( $key, $post_id = null ) {
	$post_id = $post_id ? $post_id : get_queried_object_id();
	return $post_id ? trim( (string) get_post_meta( $post_id, '_sws_' . $key, true ) ) : '';
}

/** <title> */
add_filter(
	'pre_get_document_title',
	function ( $title ) {
		if ( sws_seo_plugin_active() ) {
			return $title;
		}
		if ( is_singular() || ( is_home() && get_option( 'page_for_posts' ) ) ) {
			$custom = sws_seo_field( 'seo_title' );
			if ( $custom ) {
				return $custom;
			}
		}
		return $title;
	},
	20
);
add_filter( 'document_title_separator', function () { return '|'; } );

function sws_meta_description() {
	if ( is_singular() || is_home() ) {
		$d = sws_seo_field( 'seo_desc' );
		if ( $d ) {
			return $d;
		}
		if ( is_singular() ) {
			$p = get_post( get_queried_object_id() );
			if ( $p ) {
				return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $p->post_excerpt ? $p->post_excerpt : $p->post_content ) ), 28, '…' );
			}
		}
	}
	if ( is_category() || is_tag() ) {
		$d = term_description();
		if ( $d ) {
			return wp_strip_all_tags( $d );
		}
	}
	return get_bloginfo( 'description' );
}

function sws_canonical() {
	if ( is_singular() ) {
		return get_permalink( get_queried_object_id() );
	}
	if ( is_front_page() ) {
		return home_url( '/' );
	}
	if ( is_home() ) {
		$id = (int) get_option( 'page_for_posts' );
		return $id ? get_permalink( $id ) : home_url( '/' );
	}
	if ( is_category() || is_tag() || is_tax() ) {
		return get_term_link( get_queried_object() );
	}
	return '';
}

/** Meta tags in <head>. */
function sws_seo_head() {
	if ( sws_seo_plugin_active() ) {
		return;
	}
	$desc  = sws_meta_description();
	$canon = sws_canonical();
	$title = wp_get_document_title();
	$img   = is_singular() ? sws_hero_url( get_queried_object_id() ) : sws_img( 'training-launcher.jpg' );
	$img   = preg_replace( '/\.webp$/', '.jpg', $img );
	$robots = sws_seo_field( 'robots' );
	if ( is_search() || is_404() ) {
		$robots = 'noindex, follow';
	}

	echo "\n<!-- Southwestern Solutions SEO -->\n";
	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta name="robots" content="%s">' . "\n", esc_attr( $robots ? $robots : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' ) );
	if ( $canon && ! is_wp_error( $canon ) ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canon ) );
	}
	$og = array(
		'og:locale'      => 'en_US',
		'og:type'        => is_singular( 'post' ) ? 'article' : 'website',
		'og:title'       => $title,
		'og:description' => $desc,
		'og:url'         => $canon && ! is_wp_error( $canon ) ? $canon : home_url( add_query_arg( array() ) ),
		'og:site_name'   => get_bloginfo( 'name' ),
		'og:image'       => $img,
		'og:image:width' => '2400',
		'og:image:height'=> '1350',
	);
	foreach ( $og as $k => $v ) {
		printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $k ), esc_attr( $v ) );
	}
	if ( is_singular( 'post' ) ) {
		printf( '<meta property="article:published_time" content="%s">' . "\n", esc_attr( get_the_date( 'c' ) ) );
		printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $img ) );
	echo '<meta name="geo.region" content="US-CA">' . "\n" . '<meta name="geo.placename" content="San Diego">' . "\n";
}
add_action( 'wp_head', 'sws_seo_head', 2 );

/** When this module handles SEO, drop core's duplicate canonical and robots tags. */
add_action(
	'wp',
	function () {
		if ( sws_seo_plugin_active() ) {
			return;
		}
		remove_action( 'wp_head', 'rel_canonical' );
		remove_action( 'wp_head', 'wp_robots', 1 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
	}
);

/** JSON-LD structured data. */
function sws_schema() {
	$graph = array();
	$org_id = home_url( '/#organization' );

	if ( ! sws_seo_plugin_active() ) {
		$same = array_values( array_filter( array( sws_opt( 'facebook' ), sws_opt( 'instagram' ), sws_opt( 'linkedin' ), sws_opt( 'youtube' ) ) ) );
		$org  = array(
			'@type'       => array( 'EducationalOrganization', 'LocalBusiness' ),
			'@id'         => $org_id,
			'name'        => 'Southwestern Solutions',
			'url'         => home_url( '/' ),
			'logo'        => sws_img( 'logo.png' ),
			'image'       => sws_img( 'training-launcher.jpg' ),
			'description' => 'POST-certified law enforcement instructor training in San Diego, taught by former and current tactical operators with over 50 years of experience: Chemical Agent Instructor and Less Lethal Instructor courses that meet AB 48 (Penal Code 13652) requirements.',
			'email'       => sws_opt( 'email' ),
			'telephone'   => sws_opt( 'phone' ),
			'address'     => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => sws_opt( 'city' ),
				'postalCode'      => sws_opt( 'zip' ),
				'addressRegion'   => sws_opt( 'region' ),
				'addressCountry'  => sws_opt( 'country' ),
			),
			'openingHours'=> 'Mo-Fr 08:00-17:00',
			'knowsAbout'  => array( 'Chemical agent instructor training', 'Less lethal instructor training', 'AB 48 compliance', 'Penal Code 13652', 'Crowd management', 'Kinetic energy projectiles', 'Decontamination' ),
		);
		if ( $same ) {
			$org['sameAs'] = $same;
		}
		$graph[] = $org;
		$graph[] = array(
			'@type'     => 'WebSite',
			'@id'       => home_url( '/#website' ),
			'url'       => home_url( '/' ),
			'name'      => get_bloginfo( 'name' ),
			'publisher' => array( '@id' => $org_id ),
			'inLanguage'=> 'en-US',
		);

		if ( ! is_front_page() ) {
			$list = array();
			foreach ( sws_breadcrumb_items() as $i => $c ) {
				$list[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'name' => $c['name'], 'item' => is_wp_error( $c['url'] ) ? home_url( '/' ) : $c['url'] );
			}
			$graph[] = array( '@type' => 'BreadcrumbList', 'itemListElement' => $list );
		}

		if ( is_singular( 'post' ) ) {
			$graph[] = array(
				'@type'            => 'BlogPosting',
				'headline'         => get_the_title(),
				'description'      => sws_meta_description(),
				'image'            => preg_replace( '/\.webp$/', '.jpg', sws_hero_url() ),
				'datePublished'    => get_the_date( 'c' ),
				'dateModified'     => get_the_modified_date( 'c' ),
				'author'           => array( '@type' => 'Organization', 'name' => 'Southwestern Solutions', 'url' => home_url( '/' ) ),
				'publisher'        => array( '@id' => $org_id ),
				'mainEntityOfPage' => get_permalink(),
				'keywords'         => sws_seo_field( 'focus_kw' ),
			);
		}
	}

	if ( is_singular() ) {
		$id = get_queried_object_id();

		// Course schema from _sws_course JSON.
		$course = json_decode( (string) get_post_meta( $id, '_sws_course', true ), true );
		if ( is_array( $course ) && ! empty( $course['name'] ) ) {
			$c = array(
				'@type'       => 'Course',
				'name'        => $course['name'],
				'description' => isset( $course['description'] ) ? $course['description'] : sws_meta_description(),
				'url'         => get_permalink( $id ),
				'provider'    => array( '@type' => 'Organization', 'name' => 'Southwestern Solutions', 'sameAs' => home_url( '/' ) ),
				'educationalCredentialAwarded' => isset( $course['credential'] ) ? $course['credential'] : 'Certificate of completion',
				'inLanguage'  => 'en-US',
				'hasCourseInstance' => array(
					'@type'          => 'CourseInstance',
					'courseMode'     => 'Onsite',
					'courseWorkload' => isset( $course['workload'] ) ? $course['workload'] : '',
					'location'       => array( '@type' => 'Place', 'name' => isset( $course['location'] ) ? $course['location'] : 'San Diego, CA', 'address' => array( '@type' => 'PostalAddress', 'addressLocality' => 'San Diego', 'addressRegion' => 'CA', 'addressCountry' => 'US' ) ),
				),
			);
			if ( ! empty( $course['start'] ) ) {
				$c['hasCourseInstance']['startDate'] = $course['start'];
			}
			if ( ! empty( $course['end'] ) ) {
				$c['hasCourseInstance']['endDate'] = $course['end'];
			}
			if ( ! empty( $course['address'] ) ) {
				$c['hasCourseInstance']['location']['address']['streetAddress'] = $course['address'];
			}
			if ( ! empty( $course['city'] ) ) {
				$c['hasCourseInstance']['location']['address']['addressLocality'] = $course['city'];
			}
			if ( ! empty( $course['price'] ) ) {
				$c['offers'] = array( '@type' => 'Offer', 'category' => 'Paid', 'price' => (string) $course['price'], 'priceCurrency' => 'USD', 'url' => get_permalink( $id ) );
			}
			$graph[] = $c;
		}

		// FAQPage schema built from <details><summary> blocks in the content.
		if ( get_post_meta( $id, '_sws_faq_schema', true ) ) {
			$content = get_post_field( 'post_content', $id );
			if ( preg_match_all( '#<details[^>]*>\s*<summary[^>]*>(.*?)</summary>(.*?)</details>#si', $content, $m, PREG_SET_ORDER ) ) {
				$qa = array();
				foreach ( $m as $row ) {
					$qa[] = array(
						'@type'          => 'Question',
						'name'           => wp_strip_all_tags( $row[1] ),
						'acceptedAnswer' => array( '@type' => 'Answer', 'text' => trim( wp_strip_all_tags( $row[2] ) ) ),
					);
				}
				$graph[] = array( '@type' => 'FAQPage', 'mainEntity' => $qa );
			}
		}
	}

	if ( $graph ) {
		echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'sws_schema', 30 );

/** Keep attachment pages out of the index; disable author archives (single-org site). */
add_action(
	'template_redirect',
	function () {
		if ( is_attachment() ) {
			$parent = wp_get_post_parent_id( get_the_ID() );
			wp_safe_redirect( $parent ? get_permalink( $parent ) : home_url( '/' ), 301 );
			exit;
		}
		if ( is_author() ) {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}
);

/** Remove the users sitemap from the core XML sitemap (wp-sitemap.xml). */
add_filter(
	'wp_sitemaps_add_provider',
	function ( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	},
	10,
	2
);

/** robots.txt additions. */
add_filter(
	'robots_txt',
	function ( $out, $public ) {
		if ( $public ) {
			$out .= "Disallow: /?s=\nDisallow: /search/\n";
			$out .= 'Sitemap: ' . home_url( '/wp-sitemap.xml' ) . "\n";
		}
		return $out;
	},
	10,
	2
);
