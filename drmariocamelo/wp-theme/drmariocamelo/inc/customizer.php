<?php
/**
 * Customizer: practice contact data, integrations and tracking IDs.
 * Appearance → Customize → Dr. Camelo Settings.
 */

defined( 'ABSPATH' ) || exit;

function dmc_settings() {
	return array(
		'dmc_phone'       => array( 'Phone (display)', '' ),
		'dmc_whatsapp'    => array( 'WhatsApp number with country code (e.g. 52664XXXXXXX)', '' ),
		'dmc_email'       => array( 'Contact email (leads are sent here)', '' ),
		'dmc_address'     => array( 'Street address', 'Paseo Playas de Tijuana No. 19, Terrazas de Playas' ),
		'dmc_city'        => array( 'City', 'Tijuana' ),
		'dmc_region'      => array( 'State', 'Baja California' ),
		'dmc_zip'         => array( 'Postal code', '22504' ),
		'dmc_lat'         => array( 'Latitude (for schema)', '32.5197' ),
		'dmc_lng'         => array( 'Longitude (for schema)', '-117.1167' ),
		'dmc_reviews_url' => array( 'Google reviews link', 'https://share.google/37Q6n39XZZboHRoR1' ),
		'dmc_rating'      => array( 'Google rating (e.g. 4.9) — leave empty to hide', '' ),
		'dmc_rating_count' => array( 'Google review count — leave empty to hide', '' ),
		'dmc_typeform'    => array( 'Financing Typeform URL', 'https://mendmx.pro.typeform.com/solicitud1' ),
		'dmc_facebook'    => array( 'Facebook URL', 'https://www.facebook.com/Drmariocamelo/' ),
		'dmc_instagram'   => array( 'Instagram URL', 'https://www.instagram.com/superdrsleeve/' ),
		'dmc_youtube'     => array( 'YouTube URL', '' ),
		'dmc_tiktok'      => array( 'TikTok URL', '' ),
		'dmc_ga4'         => array( 'Google Analytics 4 ID (G-XXXX)', '' ),
		'dmc_gtm'         => array( 'Google Tag Manager ID (GTM-XXXX)', '' ),
		'dmc_pixel'       => array( 'Meta Pixel ID', '' ),
		'dmc_gsc'         => array( 'Google Search Console verification code', '' ),
	);
}

/** Read a setting with its default. */
function dmc_opt( $key ) {
	$settings = dmc_settings();
	$default  = isset( $settings[ $key ] ) ? $settings[ $key ][1] : '';
	return get_theme_mod( $key, $default );
}

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section( 'dmc_section', array( 'title' => 'Dr. Camelo Settings', 'priority' => 30 ) );
		foreach ( dmc_settings() as $key => $def ) {
			$wp_customize->add_setting( $key, array( 'default' => $def[1], 'sanitize_callback' => 'sanitize_text_field' ) );
			$wp_customize->add_control( $key, array( 'label' => $def[0], 'section' => 'dmc_section', 'type' => 'text' ) );
		}
	}
);

/** Tracking snippets (GA4, GTM, Meta Pixel). */
add_action(
	'wp_head',
	function () {
		$gsc = dmc_opt( 'dmc_gsc' );
		if ( $gsc ) {
			printf( '<meta name="google-site-verification" content="%s">' . "\n", esc_attr( $gsc ) );
		}
		$gtm = dmc_opt( 'dmc_gtm' );
		if ( $gtm ) {
			printf( "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','%s');</script>\n", esc_js( $gtm ) );
		}
		$ga4 = dmc_opt( 'dmc_ga4' );
		if ( $ga4 ) {
			printf( '<script async src="https://www.googletagmanager.com/gtag/js?id=%1$s"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","%1$s");</script>' . "\n", esc_attr( $ga4 ) );
		}
		$pixel = dmc_opt( 'dmc_pixel' );
		if ( $pixel ) {
			printf( "<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','%s');fbq('track','PageView');</script>\n", esc_js( $pixel ) );
		}
	},
	1
);
