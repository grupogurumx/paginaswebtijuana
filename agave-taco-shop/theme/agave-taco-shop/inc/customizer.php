<?php
/**
 * Customizer: business info + 3D panoramic hero slides.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default hero slides — English copy written for conversion and local SEO.
 */
function agave_default_slides() {
	return array(
		array(
			'image'   => 'hero-ai-quesabirria',
			'kicker'  => 'Point Loma · San Diego',
			'title'   => 'Birria worth crossing town for.',
			'text'    => 'Beef slow-braised in a deep guajillo adobo, folded into crackling, cheese-crusted tortillas and served with a steaming cup of consommé. This is the quesabirria San Diego lines up for.',
			'cta'     => 'Order Quesabirria',
			'cta_url' => '#order',
		),
		array(
			'image'   => 'hero-birria-night',
			'kicker'  => 'The Consommé Ritual',
			'title'   => 'Dip. Bite. Repeat.',
			'text'    => 'One crisp taco, one rich red broth, zero regrets. Our consommé is the slow-simmered soul of every birria taco — and the reason your first order will not be your last.',
			'cta'     => 'Explore the Menu',
			'cta_url' => '/menu/',
		),
		array(
			'image'   => 'hero-sunrise',
			'kicker'  => 'Open 7 AM, every single day',
			'title'   => 'Sunrise burritos. Midnight tacos.',
			'text'    => 'Breakfast burritos before the waves, California burritos after the game and late-night tacos until midnight on weekends. Point Loma’s favorite taco shop keeps the plancha hot from dawn till late.',
			'cta'     => 'See Hours & Directions',
			'cta_url' => '/visit/',
		),
		array(
			'image'   => 'hero-catering',
			'kicker'  => 'Taco Catering in San Diego',
			'title'   => 'Your party deserves a birria bar.',
			'text'    => 'Birthdays, office lunches, graduations and backyard weddings — we bring the tacos, the salsas and the fiesta energy so you can be a guest at your own event.',
			'cta'     => 'Get a Catering Quote',
			'cta_url' => '/catering/',
		),
		array(
			'image'   => 'hero-drive-thru',
			'kicker'  => 'Drive-thru · Pickup · Delivery',
			'title'   => 'Skip the line, not the flavor.',
			'text'    => 'Order ahead online, roll through our drive-thru or get Agave delivered with DoorDash, Uber Eats and Postmates. Hot, fast and exactly the way you like it.',
			'cta'     => 'Order Online Now',
			'cta_url' => '#order',
		),
	);
}

/**
 * Get resolved hero slides (Customizer overrides merged into defaults).
 *
 * @return array
 */
function agave_slides() {
	$slides = array();
	foreach ( agave_default_slides() as $i => $slide ) {
		$n         = $i + 1;
		$image_id  = absint( get_theme_mod( "agave_slide_{$n}_image", 0 ) );
		$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'agave-hero' ) : agave_img( $slide['image'], 'agave-hero' );
		$cta_url   = get_theme_mod( "agave_slide_{$n}_cta_url", $slide['cta_url'] );
		if ( '#order' === $cta_url ) {
			$cta_url = agave_biz( 'order_url' );
		} elseif ( 0 === strpos( $cta_url, '/' ) ) {
			$cta_url = home_url( $cta_url );
		}
		$slides[] = array(
			'image'   => $image_url,
			'kicker'  => get_theme_mod( "agave_slide_{$n}_kicker", $slide['kicker'] ),
			'title'   => get_theme_mod( "agave_slide_{$n}_title", $slide['title'] ),
			'text'    => get_theme_mod( "agave_slide_{$n}_text", $slide['text'] ),
			'cta'     => get_theme_mod( "agave_slide_{$n}_cta", $slide['cta'] ),
			'cta_url' => $cta_url,
		);
	}
	return $slides;
}

/**
 * Register Customizer panels.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function agave_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'agave_panel',
		array(
			'title'    => __( 'Agave Taco Shop', 'agave' ),
			'priority' => 30,
		)
	);

	// Business info.
	$wp_customize->add_section(
		'agave_business',
		array(
			'title' => __( 'Business info & ordering links', 'agave' ),
			'panel' => 'agave_panel',
		)
	);

	$fields = array(
		'name'          => 'Business name',
		'tagline'       => 'Tagline',
		'street'        => 'Street address',
		'city'          => 'City',
		'region'        => 'State',
		'zip'           => 'ZIP',
		'phone'         => 'Phone (display)',
		'phone_e164'    => 'Phone (+1XXXXXXXXXX)',
		'email'         => 'Email (contact & catering forms)',
		'lat'           => 'Latitude',
		'lng'           => 'Longitude',
		'order_url'     => 'Order online URL (Toast)',
		'doordash_url'  => 'DoorDash URL',
		'ubereats_url'  => 'Uber Eats URL',
		'postmates_url' => 'Postmates URL',
		'yelp_url'      => 'Yelp URL',
		'facebook_url'  => 'Facebook URL',
		'instagram_url' => 'Instagram URL',
	);
	$defaults = agave_business_defaults();
	foreach ( $fields as $key => $label ) {
		$is_url = false !== strpos( $key, 'url' );
		$wp_customize->add_setting(
			'agave_' . $key,
			array(
				'default'           => $defaults[ $key ],
				'sanitize_callback' => $is_url ? 'esc_url_raw' : ( 'email' === $key ? 'sanitize_email' : 'sanitize_text_field' ),
			)
		);
		$wp_customize->add_control(
			'agave_' . $key,
			array(
				'label'   => $label,
				'section' => 'agave_business',
				'type'    => $is_url ? 'url' : ( 'email' === $key ? 'email' : 'text' ),
			)
		);
	}

	// Hero slides.
	foreach ( agave_default_slides() as $i => $slide ) {
		$n       = $i + 1;
		$section = "agave_slide_{$n}";
		$wp_customize->add_section(
			$section,
			array(
				/* translators: %d slide number */
				'title' => sprintf( __( '3D Hero — Slide %d', 'agave' ), $n ),
				'panel' => 'agave_panel',
			)
		);

		$wp_customize->add_setting( "agave_slide_{$n}_image", array( 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				"agave_slide_{$n}_image",
				array(
					'label'     => __( 'Panoramic image (min. 2400×1100)', 'agave' ),
					'section'   => $section,
					'mime_type' => 'image',
				)
			)
		);

		$text_fields = array(
			'kicker'  => array( 'Kicker', 'text', 'sanitize_text_field' ),
			'title'   => array( 'Headline', 'text', 'sanitize_text_field' ),
			'text'    => array( 'Body copy', 'textarea', 'sanitize_textarea_field' ),
			'cta'     => array( 'Button label', 'text', 'sanitize_text_field' ),
			'cta_url' => array( 'Button link (#order = online ordering)', 'text', 'sanitize_text_field' ),
		);
		foreach ( $text_fields as $field => $cfg ) {
			$wp_customize->add_setting(
				"agave_slide_{$n}_{$field}",
				array(
					'default'           => $slide[ $field ],
					'sanitize_callback' => $cfg[2],
				)
			);
			$wp_customize->add_control(
				"agave_slide_{$n}_{$field}",
				array(
					'label'   => $cfg[0],
					'section' => $section,
					'type'    => $cfg[1],
				)
			);
		}
	}
}
add_action( 'customize_register', 'agave_customize_register' );
