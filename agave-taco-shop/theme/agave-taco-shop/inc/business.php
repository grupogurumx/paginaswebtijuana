<?php
/**
 * Business facts (NAP), ordering links and the image library.
 *
 * Every value can be overridden from Appearance → Customize → Agave: Business Info.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default business facts. Keep NAP (name, address, phone) identical to the
 * Google Business Profile listing — consistency is a local-SEO ranking factor.
 */
function agave_business_defaults() {
	return array(
		'name'         => 'Agave Taco Shop',
		'legal_name'   => 'Agave Taco Shop — Point Loma',
		'tagline'      => 'Birria · Tacos · Burritos — Point Loma, San Diego',
		'street'       => '4111 W Point Loma Blvd',
		'city'         => 'San Diego',
		'region'       => 'CA',
		'zip'          => '92110',
		'country'      => 'US',
		'phone'        => '(619) 230-5282',
		'phone_e164'   => '+16192305282',
		'email'        => '',
		'lat'          => '32.7535',
		'lng'          => '-117.2187',
		'price_range'  => '$',
		'hours_human'  => array(
			'Sunday – Thursday' => '7:00 AM – 10:00 PM',
			'Friday – Saturday' => '7:00 AM – 12:00 AM',
		),
		// Schema.org openingHoursSpecification.
		'hours_schema' => array(
			array(
				'days'  => array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday' ),
				'opens' => '07:00',
				'close' => '22:00',
			),
			array(
				'days'  => array( 'Friday', 'Saturday' ),
				'opens' => '07:00',
				'close' => '23:59',
			),
		),
		'order_url'    => 'https://order.toasttab.com/online/agave-taco-shop-4111-w-point-loma-blvd',
		'doordash_url' => 'https://order.online/en-US/store/23060199',
		'ubereats_url' => 'https://www.ubereats.com/store/agave-taco-shop/8842qR-vXNek_SD1ZQxZiQ',
		'postmates_url' => 'https://postmates.com/store/agave-taco-shop/8842qR-vXNek_SD1ZQxZiQ',
		'yelp_url'     => 'https://www.yelp.com/biz/agave-taco-shop-san-diego',
		'tripadvisor_url' => 'https://www.tripadvisor.com/Restaurant_Review-g60750-d26905788-Reviews-Agave_Taco_Shop-San_Diego_La_Jolla.html',
		'facebook_url' => 'https://www.facebook.com/Agavetacoshop',
		'instagram_url' => 'https://www.instagram.com/agavetacoshop/',
		'instagram_handle' => '@agavetacoshop',
		'maps_url'     => 'https://www.google.com/maps/search/?api=1&query=Agave+Taco+Shop+4111+W+Point+Loma+Blvd+San+Diego+CA+92110',
		'sister_name'  => 'Agave Birrieria — Encinitas',
		'sister_address' => '865 Orpheus Ave, Encinitas, CA 92024',
		'sister_url'   => 'https://www.agavebirrieria.com/',
	);
}

/**
 * Read a business value (Customizer override → default).
 *
 * @param string $key Field key.
 * @return mixed
 */
function agave_biz( $key ) {
	$defaults = agave_business_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	if ( is_array( $default ) ) {
		return $default;
	}
	$value = get_theme_mod( 'agave_' . $key, $default );
	return '' === $value ? $default : $value;
}

/**
 * One-line formatted address.
 */
function agave_address_line() {
	return sprintf( '%s, %s, %s %s', agave_biz( 'street' ), agave_biz( 'city' ), agave_biz( 'region' ), agave_biz( 'zip' ) );
}

/**
 * Image library. Each key maps to an attachment slug created by the XML import
 * (Media Library) with a remote fallback (Freepik / Magnific, free licence,
 * attribution in footer credits) so the theme never shows a broken image.
 *
 * Replace any image by uploading a new one in the Media Library with the same
 * slug, or by picking it in the Customizer (hero slides).
 */
function agave_image_library() {
	$fp = 'https://img.magnific.com/free-photo/';
	return array(
		'hero-ai-quesabirria' => $fp . 'banner-delicious-tacos_23-2150831065.jpg?w=2000',
		'hero-quesabirria'  => $fp . 'banner-delicious-tacos_23-2150831065.jpg?w=2000',
		'hero-birria-night' => $fp . 'hand-reaching-fresh-tacos-wooden-board-candlelight_1308-189504.jpg?w=2000',
		'hero-sunrise'      => $fp . 'perfect-burrito_23-2147640348.jpg?w=2000',
		'hero-catering'     => $fp . 'high-angle-delicious-taco-mexican-party_23-2149362784.jpg?w=2000',
		'hero-drive-thru'   => $fp . 'banner-delicious-tacos_23-2150831069.jpg?w=2000',
		'dish-quesabirria'  => $fp . 'delicious-tacos-arrangement_23-2150878147.jpg?w=1200',
		'dish-street-tacos' => $fp . 'closeup-mexican-tasty-tacos-de-pastor-plate_181624-42045.jpg?w=1200',
		'dish-california'   => $fp . 'mexican-burrito-with-rice_1147-395.jpg?w=1200',
		'dish-breakfast'    => $fp . 'burrito-with-rice_1147-391.jpg?w=1200',
		'dish-fries'        => $fp . 'garnished-delicious-mexican-nachos-plate-with-tacos_23-2148042533.jpg?w=1200',
		'dish-aguas'        => $fp . 'glasses-refreshing-hibiscus-ice-tea_23-2149893654.jpg?w=1200',
		'dish-menudo'       => $fp . 'top-view-appetizing-pozole-bowl_23-2149248554.jpg?w=1200',
		'story-kitchen'     => $fp . 'man-preparing-delicious-food-side-view_23-2149661343.jpg?w=1400',
		'story-grill'       => $fp . 'close-up-hand-cooking-delicious-meat_23-2148723235.jpg?w=1400',
		'catering-spread'   => $fp . 'people-enjoying-mexican-barbecue_23-2151000341.jpg?w=1600',
		'catering-table'    => $fp . 'top-view-delicious-mexican-food-with-guacamole_23-2148614474.jpg?w=1400',
		'gallery-hands'     => $fp . 'hands-holding-delicious-tacos_23-2150878219.jpg?w=900',
		'gallery-taco'      => $fp . 'front-view-hands-holding-delicious-taco_23-2151048006.jpg?w=900',
		'gallery-board'     => $fp . 'high-angle-delicious-tacos-arrangement_23-2150799473.jpg?w=900',
		'gallery-street'    => $fp . 'delicious-street-food-still-life_23-2151535327.jpg?w=900',
		'gallery-salsa'     => $fp . 'traditional-mexican-tacos-salsa-sauce-with-meat-vegetables-cutting-board_23-2148042498.jpg?w=900',
		'gallery-aguas'     => $fp . 'person-pouring-refreshing-hibiscus-ice-tea-clear-glass-container_23-2149893698.jpg?w=900',
	);
}

/**
 * Resolve an image key to a URL: local Media Library first, remote fallback second.
 *
 * @param string $key  Library key (also the attachment slug "agave-{key}").
 * @param string $size Registered image size.
 * @return string
 */
function agave_img( $key, $size = 'large' ) {
	static $cache = array();
	$cache_key    = $key . '|' . $size;
	if ( isset( $cache[ $cache_key ] ) ) {
		return $cache[ $cache_key ];
	}

	$url         = '';
	$attachments = get_posts(
		array(
			'post_type'      => 'attachment',
			'name'           => 'agave-' . $key,
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	if ( $attachments ) {
		$url = wp_get_attachment_image_url( $attachments[0], $size );
	}
	if ( ! $url ) {
		$library = agave_image_library();
		$url     = isset( $library[ $key ] ) ? $library[ $key ] : '';
	}

	$cache[ $cache_key ] = $url;
	return $url;
}
