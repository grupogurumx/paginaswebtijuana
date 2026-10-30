<?php
/**
 * SEO técnico integrado.
 *
 * - Título y meta descripción por página (metas `_ac_seo_title` / `_ac_meta_description`).
 * - Open Graph y Twitter Cards.
 * - hreflang es-MX / en-US / x-default.
 * - Datos estructurados JSON-LD: HomeAndConstructionBusiness (SEO local),
 *   WebSite, BreadcrumbList, BlogPosting y FAQPage.
 * - noindex en búsquedas internas y 404.
 * - Google Search Console y GA4 desde el personalizador.
 *
 * Si Yoast SEO o Rank Math están activos, el tema les cede título, descripción,
 * Open Graph y Schema genérico, y solo conserva hreflang y el negocio local.
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

/**
 * ¿Hay un plugin SEO que ya se encarga de las metas?
 *
 * @return bool
 */
function ac_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || class_exists( 'The_SEO_Framework\Load' );
}

/**
 * Descripción por defecto del sitio en cada idioma.
 *
 * @return string
 */
function ac_default_description() {
	return 'en' === ac_lang()
		? 'Porcelain tiles, ceramics, wall cladding, mosaics and installation accessories in Mexico. Over 35 years of expert advice, stock on hand and project pricing.'
		: 'Porcelanato, cerámica, recubrimientos para pisos y muros, mosaicos y accesorios para la construcción en México. Más de 35 años de asesoría experta, inventario y precios de proyecto.';
}

/**
 * Meta descripción de la vista actual.
 *
 * @return string
 */
function ac_meta_description() {
	if ( is_singular() ) {
		$id   = get_queried_object_id();
		$desc = get_post_meta( $id, '_ac_meta_description', true );
		if ( ! $desc && has_excerpt( $id ) ) {
			$desc = get_the_excerpt( $id );
		}
		if ( $desc ) {
			return wp_strip_all_tags( $desc );
		}
	}
	if ( is_category() && category_description() ) {
		return wp_strip_all_tags( category_description() );
	}
	return ac_default_description();
}

/**
 * Título SEO personalizado.
 */
function ac_document_title( $title ) {
	if ( ac_seo_plugin_active() ) {
		return $title;
	}
	if ( is_singular() ) {
		$custom = get_post_meta( get_queried_object_id(), '_ac_seo_title', true );
		if ( $custom ) {
			return $custom;
		}
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'ac_document_title' );

/**
 * Separador del título.
 */
add_filter(
	'document_title_separator',
	function () {
		return '|';
	}
);

/**
 * Imagen para compartir.
 *
 * @return string
 */
function ac_share_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return get_the_post_thumbnail_url( get_queried_object_id(), 'ac-wide' );
	}
	if ( is_singular() ) {
		$slug = get_post_meta( get_queried_object_id(), '_ac_image', true );
		if ( $slug && ac_img_url( $slug ) ) {
			return ac_img_url( $slug, 'ac-wide' );
		}
	}
	return ac_img_url( 'hero-sala', 'ac-wide' );
}

/**
 * URL canónica de la vista actual (para OG y hreflang).
 *
 * @return string
 */
function ac_current_url() {
	if ( is_singular() ) {
		return get_permalink( get_queried_object_id() );
	}
	if ( is_category() ) {
		return get_category_link( get_queried_object_id() );
	}
	if ( is_front_page() || is_home() ) {
		return home_url( '/' );
	}
	global $wp;
	return home_url( add_query_arg( array(), $wp->request ) );
}

/**
 * Metas en <head>.
 */
function ac_head_meta() {
	$gsc = ac_opt( 'gsc' );
	if ( $gsc ) {
		printf( '<meta name="google-site-verification" content="%s">' . "\n", esc_attr( $gsc ) );
	}
	echo '<meta name="theme-color" content="#020380">' . "\n";

	// hreflang: siempre, porque los plugins SEO no conocen nuestro bilingüe ligero.
	if ( ! function_exists( 'pll_current_language' ) && ! defined( 'ICL_LANGUAGE_CODE' ) && ( is_singular() || is_front_page() || is_category() ) ) {
		$here  = ac_current_url();
		$other = ac_translation_url();
		$es    = 'en' === ac_lang() ? $other : $here;
		$en    = 'en' === ac_lang() ? $here : $other;
		printf( '<link rel="alternate" hreflang="es-MX" href="%s">' . "\n", esc_url( $es ) );
		printf( '<link rel="alternate" hreflang="en-US" href="%s">' . "\n", esc_url( $en ) );
		printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( $es ) );
	}

	// Precarga de la primera imagen del slider (mejora LCP).
	if ( ac_is_home_view() ) {
		$hero = ac_img_url( 'hero-sala', 'full' );
		if ( $hero ) {
			printf( '<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n", esc_url( $hero ) );
		}
	}

	if ( ac_seo_plugin_active() ) {
		return;
	}

	$desc  = ac_meta_description();
	$title = wp_get_document_title();
	$url   = ac_current_url();
	$img   = ac_share_image();
	$type  = is_singular( 'post' ) ? 'article' : 'website';

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	if ( ! is_singular() && ! is_search() && ! is_404() ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
	}
	printf( '<meta property="og:locale" content="%s">' . "\n", 'en' === ac_lang() ? 'en_US' : 'es_MX' );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	if ( $img ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $img ) );
		printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $img ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
	if ( is_singular( 'post' ) ) {
		printf( '<meta property="article:published_time" content="%s">' . "\n", esc_attr( get_the_date( 'c' ) ) );
		printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );
	}
}
add_action( 'wp_head', 'ac_head_meta', 2 );

/**
 * noindex en búsquedas y 404.
 */
function ac_robots( $robots ) {
	if ( is_search() || is_404() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	} else {
		$robots['max-image-preview'] = 'large';
	}
	return $robots;
}
add_filter( 'wp_robots', 'ac_robots' );

/**
 * Nodo del negocio local.
 *
 * @return array
 */
function ac_schema_business() {
	$logo_id = get_theme_mod( 'custom_logo' );
	$node    = array(
		'@type'       => array( 'HomeAndConstructionBusiness', 'Store' ),
		'@id'         => home_url( '/#business' ),
		'name'        => 'Acabados Contemporáneos',
		'url'         => home_url( '/' ),
		'description' => ac_default_description(),
		'slogan'      => 'en' === ac_lang() ? 'Surfaces that tell the story of every space' : 'Superficies que cuentan la historia de cada espacio',
		'image'       => ac_img_url( 'hero-showroom', 'ac-wide' ),
		'priceRange'  => '$$',
		'areaServed'  => array( '@type' => 'Country', 'name' => 'México' ),
		'knowsAbout'  => array( 'Porcelanato', 'Cerámica', 'Recubrimientos para pisos y muros', 'Mosaicos', 'Porcelánico de gran formato', 'Adhesivos y boquillas para cerámica', 'Perfiles para recubrimientos' ),
		'currenciesAccepted' => 'MXN',
		'hasOfferCatalog'    => array(
			'@type'           => 'OfferCatalog',
			'name'            => 'en' === ac_lang() ? 'Tiles and construction accessories' : 'Recubrimientos y accesorios para la construcción',
			'itemListElement' => array_map(
				function ( $name ) {
					return array(
						'@type'       => 'OfferCatalog',
						'name'        => $name,
					);
				},
				array( ac_t( 'cat1_t' ), ac_t( 'cat2_t' ), ac_t( 'cat3_t' ), ac_t( 'cat4_t' ), ac_t( 'cat5_t' ), ac_t( 'cat6_t' ) )
			),
		),
	);
	if ( $logo_id ) {
		$node['logo'] = wp_get_attachment_image_url( $logo_id, 'full' );
	}
	if ( ac_opt( 'phone' ) ) {
		$node['telephone'] = ac_opt( 'phone' );
	}
	if ( ac_opt( 'email' ) ) {
		$node['email'] = ac_opt( 'email' );
	}
	if ( ac_opt( 'founded' ) ) {
		$node['foundingDate'] = ac_opt( 'founded' );
	}
	if ( ac_opt( 'street' ) || ac_opt( 'city' ) ) {
		$node['address'] = array_filter(
			array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => trim( ac_opt( 'street' ) . ' ' . ac_opt( 'locality' ) ),
				'addressLocality' => ac_opt( 'city' ),
				'addressRegion'   => ac_opt( 'region' ),
				'postalCode'      => ac_opt( 'postal' ),
				'addressCountry'  => 'MX',
			)
		);
	}
	if ( ac_opt( 'lat' ) && ac_opt( 'lng' ) ) {
		$node['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => ac_opt( 'lat' ),
			'longitude' => ac_opt( 'lng' ),
		);
	}
	if ( ac_opt( 'maps_url' ) ) {
		$node['hasMap'] = ac_opt( 'maps_url' );
	}
	$socials = array_values( ac_socials() );
	if ( $socials ) {
		$node['sameAs'] = $socials;
	}
	return $node;
}

/**
 * Migas de pan de la vista actual.
 *
 * @return array Lista de [nombre, url].
 */
function ac_breadcrumbs() {
	$items = array( array( 'en' === ac_lang() ? 'Home' : 'Inicio', ac_home_url() ) );
	if ( is_singular( 'page' ) && ! ac_is_home_view() ) {
		$id        = get_queried_object_id();
		$ancestors = array_reverse( get_post_ancestors( $id ) );
		foreach ( $ancestors as $anc ) {
			if ( 'en' === get_post_field( 'post_name', $anc ) ) {
				continue;
			}
			$items[] = array( get_the_title( $anc ), get_permalink( $anc ) );
		}
		$items[] = array( get_the_title( $id ), get_permalink( $id ) );
	} elseif ( is_singular( 'post' ) ) {
		$cat = get_category_by_slug( 'en' === ac_lang() ? 'blog-en' : 'blog' );
		if ( $cat ) {
			$items[] = array( $cat->name, get_category_link( $cat ) );
		}
		$items[] = array( get_the_title(), get_permalink() );
	} elseif ( is_category() ) {
		$items[] = array( single_cat_title( '', false ), get_category_link( get_queried_object_id() ) );
	}
	return $items;
}

/**
 * Grafo JSON-LD.
 */
function ac_schema_output() {
	$graph   = array( ac_schema_business() );
	$plugin  = ac_seo_plugin_active();

	if ( ! $plugin ) {
		$graph[] = array(
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => get_bloginfo( 'name' ),
			'inLanguage'      => array( 'es-MX', 'en-US' ),
			'publisher'       => array( '@id' => home_url( '/#business' ) ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);

		if ( ! ac_is_home_view() && ( is_singular() || is_category() ) ) {
			$list = array();
			foreach ( ac_breadcrumbs() as $i => $crumb ) {
				$list[] = array(
					'@type'    => 'ListItem',
					'position' => $i + 1,
					'name'     => wp_strip_all_tags( $crumb[0] ),
					'item'     => $crumb[1],
				);
			}
			$graph[] = array(
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $list,
			);
		}

		if ( is_singular( 'post' ) ) {
			$id      = get_queried_object_id();
			$graph[] = array(
				'@type'            => 'BlogPosting',
				'headline'         => get_the_title( $id ),
				'description'      => ac_meta_description(),
				'image'            => ac_share_image(),
				'datePublished'    => get_the_date( 'c', $id ),
				'dateModified'     => get_the_modified_date( 'c', $id ),
				'inLanguage'       => 'en' === ac_lang() ? 'en-US' : 'es-MX',
				'mainEntityOfPage' => get_permalink( $id ),
				'author'           => array(
					'@type' => 'Organization',
					'name'  => 'Acabados Contemporáneos',
					'url'   => home_url( '/' ),
				),
				'publisher'        => array( '@id' => home_url( '/#business' ) ),
			);
		}
	}

	if ( ac_is_home_view() ) {
		$faq = array();
		foreach ( array( 1, 2, 3, 4 ) as $n ) {
			$faq[] = array(
				'@type'          => 'Question',
				'name'           => ac_t( 'faq' . $n . '_q' ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => ac_t( 'faq' . $n . '_a' ),
				),
			);
		}
		$graph[] = array(
			'@type'      => 'FAQPage',
			'mainEntity' => $faq,
		);
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'ac_schema_output', 20 );

/**
 * Google Analytics 4.
 */
function ac_ga4() {
	$id = ac_opt( 'ga4' );
	if ( ! $id || is_user_logged_in() ) {
		return;
	}
	printf(
		'<script async src="https://www.googletagmanager.com/gtag/js?id=%1$s"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","%1$s");</script>' . "\n",
		esc_attr( $id )
	);
}
add_action( 'wp_head', 'ac_ga4', 30 );

/**
 * Meta box sencilla para título y descripción SEO cuando no hay plugin SEO.
 */
function ac_seo_metabox() {
	if ( ac_seo_plugin_active() ) {
		return;
	}
	foreach ( array( 'post', 'page' ) as $type ) {
		add_meta_box( 'ac_seo', 'SEO · Acabados', 'ac_seo_metabox_render', $type, 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'ac_seo_metabox' );

/**
 * Render de la meta box.
 *
 * @param WP_Post $post Entrada.
 */
function ac_seo_metabox_render( $post ) {
	wp_nonce_field( 'ac_seo_save', 'ac_seo_nonce' );
	$title = get_post_meta( $post->ID, '_ac_seo_title', true );
	$desc  = get_post_meta( $post->ID, '_ac_meta_description', true );
	$lang  = get_post_meta( $post->ID, '_ac_lang', true );
	$tr    = get_post_meta( $post->ID, '_ac_translation', true );
	?>
	<p><label for="ac_seo_title"><strong>Título SEO</strong> (50–60 caracteres)</label><br>
	<input type="text" id="ac_seo_title" name="ac_seo_title" value="<?php echo esc_attr( $title ); ?>" class="widefat" maxlength="70"></p>
	<p><label for="ac_meta_description"><strong>Meta descripción</strong> (140–160 caracteres)</label><br>
	<textarea id="ac_meta_description" name="ac_meta_description" class="widefat" rows="3" maxlength="170"><?php echo esc_textarea( $desc ); ?></textarea></p>
	<p><label for="ac_lang"><strong>Idioma</strong></label>
	<select id="ac_lang" name="ac_lang"><option value="es" <?php selected( $lang, 'es' ); ?>>Español</option><option value="en" <?php selected( $lang, 'en' ); ?>>English</option></select>
	&nbsp; <label for="ac_translation"><strong>Ruta de la traducción</strong></label>
	<input type="text" id="ac_translation" name="ac_translation" value="<?php echo esc_attr( $tr ); ?>" placeholder="en/about"></p>
	<?php
}

/**
 * Guardado de la meta box.
 *
 * @param int $post_id Entrada.
 */
function ac_seo_metabox_save( $post_id ) {
	if ( ! isset( $_POST['ac_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ac_seo_nonce'] ) ), 'ac_seo_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$map = array(
		'ac_seo_title'        => '_ac_seo_title',
		'ac_meta_description' => '_ac_meta_description',
		'ac_lang'             => '_ac_lang',
		'ac_translation'      => '_ac_translation',
	);
	foreach ( $map as $field => $meta ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
}
add_action( 'save_post', 'ac_seo_metabox_save' );
