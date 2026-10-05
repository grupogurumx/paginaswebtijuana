<?php
/**
 * SEO local integrado: títulos, meta descripción, Open Graph, Twitter y Schema.org (JSON-LD).
 * Si está activo Yoast SEO o Rank Math, se desactivan títulos/meta/OG para no duplicar,
 * pero se mantiene el Schema "Bakery" (LocalBusiness) y FAQPage.
 *
 * @package PeanutBakery
 */

defined( 'ABSPATH' ) || exit;

/**
 * ¿Hay un plugin de SEO activo?
 */
function pb_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' );
}

/**
 * Títulos y descripciones por página (slug => [title, description]).
 * Títulos ≤ 60 caracteres y descripciones ≤ 155 para que Google no los corte.
 */
function pb_seo_map() {
	return array(
		'__home'    => array(
			'Panadería artesanal en Rosarito | Peanut Bakery',
			'Pan de masa madre con 30 h de fermentación, conchas, bolillo y birote hechos a mano en Playas de Rosarito. Pedidos por WhatsApp y venta de pan al mayoreo.',
		),
		'nosotros'  => array(
			'Nosotros: la ingeniería del pan | Peanut Bakery Rosarito',
			'Conoce Peanut Bakery: panadería artesanal en Playas de Rosarito que aplica ingeniería del pan, fermentación lenta y procesos controlados en cada pieza.',
		),
		'productos' => array(
			'Pan de masa madre, pan dulce y birote | Peanut Bakery',
			'Masa madre, conchas, donas, bolillo, birote, focaccia, croissants y repostería fina hechos a mano diario en Rosarito. Pide por WhatsApp al 661 114 7744.',
		),
		'mayoreo'   => array(
			'Pan al mayoreo para restaurantes en Rosarito y Tijuana',
			'Proveedor de pan para cafeterías, restaurantes y hoteles en Rosarito y Tijuana. Entregas programadas, precio preferente y calidad constante. Cotiza hoy.',
		),
		'contacto'  => array(
			'Contacto y pedidos | Peanut Bakery Playas de Rosarito',
			'Haz tu pedido de pan artesanal en Playas de Rosarito: WhatsApp y teléfono 661 114 7744, ventas@peanutbakery.com. Cotizaciones de mayoreo en 24 h.',
		),
		'blog'      => array(
			'Blog de pan artesanal y masa madre | Peanut Bakery',
			'Guías de pan de masa madre, pan dulce mexicano y consejos para negocios de alimentos en Rosarito y Tijuana, por los panaderos de Peanut Bakery.',
		),
	);
}

/**
 * Obtiene [title, description] para la vista actual.
 */
function pb_seo_current() {
	$map = pb_seo_map();
	if ( is_front_page() ) {
		return $map['__home'];
	}
	if ( is_home() ) {
		return $map['blog'];
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		$desc = get_post_meta( $post->ID, '_pb_meta_description', true );
		if ( 'page' === $post->post_type && isset( $map[ $post->post_name ] ) ) {
			$pair = $map[ $post->post_name ];
			return array( $pair[0], $desc ? $desc : $pair[1] );
		}
		$fallback = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 26, '…' );
		$title = get_the_title( $post );
		// Google corta los títulos a ~60 caracteres: la marca solo se agrega si cabe.
		$title = mb_strlen( $title ) <= 42 ? $title . ' | Peanut Bakery Rosarito' : $title;
		return array( $title, $desc ? $desc : $fallback );
	}
	return array( '', get_bloginfo( 'description' ) );
}

/**
 * Título del documento.
 */
add_filter(
	'pre_get_document_title',
	function ( $title ) {
		if ( pb_seo_plugin_active() ) {
			return $title;
		}
		$seo = pb_seo_current();
		return $seo[0] ? $seo[0] : $title;
	}
);

/**
 * Meta etiquetas en <head>.
 */
function pb_seo_head() {
	if ( ! pb_seo_plugin_active() ) {
		$seo   = pb_seo_current();
		$title = $seo[0] ? $seo[0] : wp_get_document_title();
		$desc  = wp_strip_all_tags( $seo[1] );
		$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
		$img   = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'pb-wide' ) : pb_img_url( 'og', 'pb-wide' );

		printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
		echo "<meta name=\"robots\" content=\"index, follow, max-image-preview:large\">\n";
		// WordPress ya imprime rel=canonical en vistas singulares; aquí cubrimos el listado del blog.
		if ( is_home() && ! is_front_page() ) {
			printf( "<link rel=\"canonical\" href=\"%s\">\n", esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) );
		}
		echo "<meta property=\"og:locale\" content=\"es_MX\">\n";
		printf( "<meta property=\"og:type\" content=\"%s\">\n", is_single() ? 'article' : 'website' );
		printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );
		printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
		printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
		printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
		if ( $img ) {
			printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $img ) );
		}
		echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
		printf( "<meta name=\"geo.region\" content=\"MX-BCN\">\n<meta name=\"geo.placename\" content=\"%s\">\n", esc_attr( pb_opt( 'city' ) ) );
		printf( "<meta name=\"geo.position\" content=\"%s;%s\">\n", esc_attr( pb_opt( 'lat' ) ), esc_attr( pb_opt( 'lng' ) ) );
	}
	echo '<meta name="theme-color" content="#2a1a12">' . "\n";
	pb_schema();
}
add_action( 'wp_head', 'pb_seo_head', 1 );

/**
 * Schema.org: Bakery (LocalBusiness), WebSite, FAQPage y Breadcrumbs.
 */
function pb_schema() {
	$home   = home_url( '/' );
	$graph  = array();
	$social = array_values( pb_socials() );

	$hours = array();
	if ( preg_match( '/^([A-Za-z,\-]+)\s+(\d{2}:\d{2})-(\d{2}:\d{2})$/', pb_opt( 'hours_schema' ), $m ) ) {
		$map  = array( 'Mo' => 'Monday', 'Tu' => 'Tuesday', 'We' => 'Wednesday', 'Th' => 'Thursday', 'Fr' => 'Friday', 'Sa' => 'Saturday', 'Su' => 'Sunday' );
		$keys = array_keys( $map );
		$days = array();
		foreach ( explode( ',', $m[1] ) as $chunk ) {
			$range = explode( '-', $chunk );
			$from  = array_search( $range[0], $keys, true );
			$to    = isset( $range[1] ) ? array_search( $range[1], $keys, true ) : $from;
			if ( false !== $from && false !== $to ) {
				for ( $i = $from; $i <= $to; $i++ ) {
					$days[] = $map[ $keys[ $i ] ];
				}
			}
		}
		if ( $days ) {
			$hours[] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => $days,
				'opens'     => $m[2],
				'closes'    => $m[3],
			);
		}
	}

	$catalog = array();
	foreach ( pb_lines() as $line ) {
		$offers = array();
		foreach ( $line['items'] as $item ) {
			$offers[] = array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type' => 'Product',
					'name'  => $item,
				),
			);
		}
		$catalog[] = array(
			'@type'           => 'OfferCatalog',
			'name'            => $line['name'],
			'itemListElement' => $offers,
		);
	}

	$bakery = array_filter(
		array(
			'@type'                     => 'Bakery',
			'@id'                       => $home . '#bakery',
			'name'                      => 'Peanut Bakery',
			'description'               => 'Panadería artesanal en Playas de Rosarito: pan de masa madre con 30 horas de fermentación, pan dulce, bolillo, birote y repostería fina. Venta al mayoreo para restaurantes, cafeterías y hoteles.',
			'url'                       => $home,
			'telephone'                 => '+52 ' . pb_opt( 'phone' ),
			'email'                     => pb_opt( 'email' ),
			'image'                     => pb_img_url( 'og', 'pb-wide' ),
			'logo'                      => has_custom_logo() ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '',
			'priceRange'                => '$$',
			'servesCuisine'             => array( 'Panadería mexicana', 'Pan de masa madre', 'Repostería' ),
			'address'                   => array_filter(
				array(
					'@type'           => 'PostalAddress',
					'streetAddress'   => pb_opt( 'street' ),
					'addressLocality' => pb_opt( 'city' ),
					'addressRegion'   => 'B.C.',
					'postalCode'      => pb_opt( 'postal' ),
					'addressCountry'  => 'MX',
				)
			),
			'geo'                       => array(
				'@type'     => 'GeoCoordinates',
				'latitude'  => (float) pb_opt( 'lat' ),
				'longitude' => (float) pb_opt( 'lng' ),
			),
			'areaServed'                => array( 'Playas de Rosarito', 'Tijuana', 'Ensenada', 'Baja California' ),
			'hasMap'                    => pb_opt( 'maps_link' ),
			'openingHoursSpecification' => $hours,
			'sameAs'                    => $social,
			'hasOfferCatalog'           => array(
				'@type'           => 'OfferCatalog',
				'name'            => 'Pan artesanal Peanut Bakery',
				'itemListElement' => $catalog,
			),
			'potentialAction'           => array(
				'@type'  => 'OrderAction',
				'target' => pb_wa(),
			),
		)
	);
	$graph[] = $bakery;

	$graph[] = array(
		'@type'      => 'WebSite',
		'@id'        => $home . '#website',
		'url'        => $home,
		'name'       => 'Peanut Bakery',
		'inLanguage' => 'es-MX',
		'publisher'  => array( '@id' => $home . '#bakery' ),
	);

	if ( is_front_page() ) {
		$faq = array();
		foreach ( pb_faqs() as $qa ) {
			$faq[] = array(
				'@type'          => 'Question',
				'name'           => $qa[0],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $qa[1],
				),
			);
		}
		$graph[] = array(
			'@type'      => 'FAQPage',
			'mainEntity' => $faq,
		);
	}

	if ( is_singular() && ! is_front_page() ) {
		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => 'Inicio',
					'item'     => $home,
				),
				array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => get_the_title(),
					'item'     => get_permalink(),
				),
			),
		);
	}

	if ( is_single() ) {
		$graph[] = array(
			'@type'         => 'BlogPosting',
			'headline'      => get_the_title(),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
			'author'        => array( '@id' => $home . '#bakery' ),
			'publisher'     => array( '@id' => $home . '#bakery' ),
			'image'         => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'pb-wide' ) : pb_img_url( 'og', 'pb-wide' ),
			'mainEntityOfPage' => get_permalink(),
			'inLanguage'    => 'es-MX',
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	) . "</script>\n";
}

/**
 * Campo "Meta descripción" en el editor de páginas y entradas.
 */
add_action(
	'init',
	function () {
		foreach ( array( 'post', 'page' ) as $type ) {
			register_post_meta(
				$type,
				'_pb_meta_description',
				array(
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
);

add_action(
	'add_meta_boxes',
	function () {
		if ( pb_seo_plugin_active() ) {
			return;
		}
		add_meta_box(
			'pb_seo',
			__( 'SEO · Meta descripción', 'peanut-bakery' ),
			function ( $post ) {
				wp_nonce_field( 'pb_seo_save', 'pb_seo_nonce' );
				printf(
					'<textarea name="pb_meta_description" rows="3" style="width:100%%" maxlength="160" placeholder="%s">%s</textarea><p class="description">%s</p>',
					esc_attr__( 'Máx. 155 caracteres. Incluye la palabra clave principal y "Rosarito".', 'peanut-bakery' ),
					esc_textarea( get_post_meta( $post->ID, '_pb_meta_description', true ) ),
					esc_html__( 'Si lo dejas vacío se usa la descripción optimizada del tema.', 'peanut-bakery' )
				);
			},
			array( 'post', 'page' ),
			'side'
		);
	}
);

add_action(
	'save_post',
	function ( $post_id ) {
		if ( ! isset( $_POST['pb_seo_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['pb_seo_nonce'] ), 'pb_seo_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$value = isset( $_POST['pb_meta_description'] ) ? sanitize_text_field( wp_unslash( $_POST['pb_meta_description'] ) ) : '';
		update_post_meta( $post_id, '_pb_meta_description', $value );
	}
);
