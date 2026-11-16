<?php
/**
 * WooCommerce integration: course products (seat registrations).
 *
 * Course product meta (set by the products import):
 *   _sws_dates      Human-readable session dates, e.g. "December 14 – 18, 2026"
 *   _sws_end_date   Last day of the session (Y-m-d). After this day registration closes automatically.
 *   _sws_location   City / venue, e.g. "San Jose, CA"
 *   _sws_address    Street address of the training site
 *   _sws_hours      Course length, e.g. "40 Hours"
 *   _sws_hero       Fallback image file from the theme (when the product has no featured image)
 *   _sws_course     JSON for Course schema (see inc/seo.php)
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'woocommerce', array( 'single_image_width' => 900, 'thumbnail_image_width' => 600 ) );
	}
);

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/* ---------------------------------------------------------------------------
 * Layout: the theme renders its own hero + breadcrumbs, so drop WooCommerce's
 * wrappers, breadcrumb, sidebar and the duplicate product title (H1 is in the hero).
 * ------------------------------------------------------------------------ */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// The course facts box replaces the short description on course products.
add_action( 'woocommerce_single_product_summary', function () { global $product; if ( $product && sws_course_meta( $product->get_id(), 'dates' ) ) { remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ); } }, 1 );

/** Keep WooCommerce's layout CSS but drop its colours (the theme styles everything). */
add_filter(
	'woocommerce_enqueue_styles',
	function ( $styles ) {
		unset( $styles['woocommerce-general'] );
		return $styles;
	}
);

add_filter( 'woocommerce_output_related_products_args', function ( $args ) { $args['posts_per_page'] = 3; $args['columns'] = 3; return $args; } );
add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'woocommerce_show_page_title', '__return_false' ); // The hero already shows the title.

/* ---------------------------------------------------------------------------
 * Helpers
 * ------------------------------------------------------------------------ */
function sws_course_meta( $product_id, $key ) {
	return trim( (string) get_post_meta( $product_id, '_sws_' . $key, true ) );
}

/**
 * True when registration is closed: the session's last day is in the past, or the
 * product is a course (has _sws_dates) with no confirmed end date yet (TBA).
 * Non-course products (no _sws_dates) are never affected.
 */
function sws_session_ended( $product_id ) {
	$end = sws_course_meta( $product_id, 'end_date' );
	if ( ! $end ) {
		return '' !== sws_course_meta( $product_id, 'dates' );
	}
	$tz    = wp_timezone();
	$today = new DateTime( 'today', $tz );
	$last  = DateTime::createFromFormat( '!Y-m-d', $end, $tz );
	return $last && $last < $today;
}

/** Past sessions cannot be purchased; the page stays live for SEO and shows a notice instead. */
add_filter(
	'woocommerce_is_purchasable',
	function ( $purchasable, $product ) {
		return sws_session_ended( $product->get_id() ) ? false : $purchasable;
	},
	10,
	2
);

/* ---------------------------------------------------------------------------
 * Single product: course facts box + "registration closed" notice
 * ------------------------------------------------------------------------ */
add_action(
	'woocommerce_single_product_summary',
	function () {
		global $product;
		$id   = $product->get_id();
		$rows = array(
			array( 'clock', 'Dates', sws_course_meta( $id, 'dates' ) ),
			array( 'pin', 'Location', trim( sws_course_meta( $id, 'location' ) . ( sws_course_meta( $id, 'address' ) ? ' — ' . sws_course_meta( $id, 'address' ) : '' ) ) ),
			array( 'book', 'Length', sws_course_meta( $id, 'hours' ) ),
			array( 'badge', 'Certification', 'California POST certified · Plan IV reimbursable' ),
			array( 'scale', 'Compliance', 'Meets AB 48 (Penal Code 13652) requirements' ),
		);
		echo '<ul class="course-facts">';
		foreach ( $rows as $r ) {
			if ( '' === $r[2] ) {
				continue;
			}
			printf( '<li><span class="icon">%s</span><div><small>%s</small>%s</div></li>', sws_icon( $r[0] ), esc_html( $r[1] ), esc_html( $r[2] ) ); // phpcs:ignore
		}
		echo '</ul>';
		if ( sws_session_ended( $id ) ) {
			printf(
				'<div class="notice notice--err" role="status"><strong>Registration closed.</strong> This session has ended or its dates are not yet confirmed. <a href="%s">See upcoming dates</a> or <a href="%s">contact us</a> to reserve a seat in the next class.</div>',
				esc_url( home_url( '/training-schedule/' ) ),
				esc_url( home_url( '/contact/' ) )
			);
		}
	},
	15
);

/** Structured data: closed sessions are not offered for sale. */
add_filter(
	'woocommerce_structured_data_product_offer',
	function ( $offer, $product ) {
		if ( sws_session_ended( $product->get_id() ) ) {
			$offer['availability'] = 'https://schema.org/SoldOut';
		}
		return $offer;
	},
	10,
	2
);

/** "Related products" → course wording. */
add_filter( 'woocommerce_product_related_products_heading', function () { return 'Other Course Sessions'; } );

/** Add-to-cart button copy. */
add_filter( 'woocommerce_product_single_add_to_cart_text', function () { return 'Register Now'; } );
add_filter(
	'woocommerce_product_add_to_cart_text',
	function ( $text, $product ) {
		return $product->is_purchasable() && $product->is_in_stock() ? 'Register' : 'View Course';
	},
	10,
	2
);

/** Quantity = number of seats. */
add_action(
	'woocommerce_before_add_to_cart_quantity',
	function () {
		echo '<label class="qty-label" for="quantity_seats">Seats</label>';
	}
);

/* ---------------------------------------------------------------------------
 * Images: fall back to the theme's course photos when a product has no image.
 * ------------------------------------------------------------------------ */
add_filter(
	'woocommerce_single_product_image_thumbnail_html',
	function ( $html, $attachment_id = 0 ) {
		global $product;
		if ( $product && ! $product->get_image_id() ) {
			$img = sws_course_meta( $product->get_id(), 'hero' );
			if ( $img ) {
				return '<div class="woocommerce-product-gallery__image frame">' . sws_picture( $img, $product->get_name() . ' — Southwestern Solutions', array( 'loading' => 'eager', 'width' => 900, 'height' => 700 ) ) . '</div>';
			}
		}
		return $html;
	},
	10,
	2
);

add_filter(
	'woocommerce_product_get_image',
	function ( $image, $product, $size = '', $attr = array(), $placeholder = true ) {
		if ( ! $product->get_image_id() ) {
			$img = sws_course_meta( $product->get_id(), 'hero' );
			if ( $img ) {
				return sws_picture( $img, $product->get_name(), array( 'width' => 600, 'height' => 400 ) );
			}
		}
		return $image;
	},
	10,
	5
);

/** Loop cards: show date + location under the title. */
add_action(
	'woocommerce_after_shop_loop_item_title',
	function () {
		global $product;
		$d = sws_course_meta( $product->get_id(), 'dates' );
		$l = sws_course_meta( $product->get_id(), 'location' );
		if ( $d || $l ) {
			echo '<p class="loop-meta">' . esc_html( trim( $d . ( $d && $l ? ' · ' : '' ) . $l ) ) . '</p>';
		}
		if ( sws_session_ended( $product->get_id() ) ) {
			echo '<p class="loop-closed">Registration closed</p>';
		}
	},
	6
);

/* ---------------------------------------------------------------------------
 * Checkout: agency + attendee details for course registrations.
 * ------------------------------------------------------------------------ */
add_filter(
	'woocommerce_checkout_fields',
	function ( $fields ) {
		if ( isset( $fields['billing']['billing_company'] ) ) {
			$fields['billing']['billing_company']['label']    = 'Agency / Department';
			$fields['billing']['billing_company']['required'] = true;
		}
		if ( isset( $fields['order']['order_comments'] ) ) {
			$fields['order']['order_comments']['label']       = 'Attendee name(s), rank and POST ID';
			$fields['order']['order_comments']['placeholder'] = 'One attendee per line — e.g. Ofc. Jane Doe, POST ID 123456';
		}
		return $fields;
	}
);

/** Order received: next steps. */
add_action(
	'woocommerce_thankyou',
	function () {
		echo '<div class="notice notice--ok"><strong>Seat request received.</strong> Our team will email confirmation, the equipment list and POST Plan IV paperwork within one business day.</div>';
	},
	5
);
