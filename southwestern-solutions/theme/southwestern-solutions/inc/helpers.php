<?php
/**
 * Helper functions.
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** URL of an image bundled with the theme. */
function sws_img( $file ) {
	return SWS_URI . '/assets/img/' . ltrim( $file, '/' );
}

/**
 * <picture> with WebP + JPG fallback for a bundled image (name without extension).
 */
function sws_picture( $name, $alt = '', $attrs = array() ) {
	$name    = preg_replace( '/\.(jpe?g|webp|png)$/i', '', $name );
	$defaults = array( 'loading' => 'lazy', 'decoding' => 'async', 'width' => 1400, 'height' => 900 );
	$attrs   = array_merge( $defaults, $attrs );
	$html    = '';
	foreach ( $attrs as $k => $v ) {
		$html .= sprintf( ' %s="%s"', esc_attr( $k ), esc_attr( $v ) );
	}
	return sprintf(
		'<picture><source srcset="%1$s" type="image/webp"><img src="%2$s" alt="%3$s"%4$s></picture>',
		esc_url( sws_img( $name . '.webp' ) ),
		esc_url( sws_img( $name . '.jpg' ) ),
		esc_attr( $alt ),
		$html
	);
}

/** Business data (editable in Customizer → Business Info). */
function sws_opt( $key ) {
	$defaults = array(
		'phone'    => '+1 (928) 614-0964',
		'email'    => 'info@southwesternsolutions.org',
		'city'     => 'San Diego',
		'region'   => 'CA',
		'country'  => 'US',
		'hours'    => 'Monday – Friday, 8:00 AM – 5:00 PM (PT)',
		'facebook' => '',
		'instagram'=> '',
		'linkedin' => '',
		'youtube'  => '',
	);
	$val = get_theme_mod( 'sws_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
	return '' === $val && isset( $defaults[ $key ] ) ? $defaults[ $key ] : $val;
}

function sws_tel( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/** Hero image for a post/page: featured image → _sws_hero meta → default. */
function sws_hero_url( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( $post_id && has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, 'sws-hero' );
	}
	$meta = $post_id ? get_post_meta( $post_id, '_sws_hero', true ) : '';
	return sws_img( $meta ? $meta : 'hero-1.webp' );
}

/** Inline SVG brand mark (shield + chevrons). */
function sws_logo_mark() {
	return '<svg viewBox="0 0 42 48" aria-hidden="true" focusable="false"><defs><linearGradient id="swsg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#f5c96e"/><stop offset="1" stop-color="#c9862a"/></linearGradient></defs><path d="M21 1 40 8v15c0 12-8.2 20.6-19 24C10.2 43.6 2 35 2 23V8z" fill="none" stroke="url(#swsg)" stroke-width="2.4"/><path d="M11 19l10 7 10-7M11 27l10 7 10-7" fill="none" stroke="url(#swsg)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="21" cy="12" r="2.4" fill="#f5c96e"/></svg>';
}

/** Small inline icon set. */
function sws_icon( $name ) {
	$p = array(
		'shield'  => '<path d="M12 2 4 5v6c0 5 3.4 9.4 8 11 4.6-1.6 8-6 8-11V5z"/><path d="m9 12 2 2 4-4"/>',
		'mask'    => '<path d="M4 9c0-3 3.6-5 8-5s8 2 8 5v3c0 4-3.6 8-8 8s-8-4-8-8z"/><circle cx="9" cy="11" r="2"/><circle cx="15" cy="11" r="2"/><path d="M10 17h4"/>',
		'target'  => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>',
		'scale'   => '<path d="M12 3v18M5 21h14M6 7h12M6 7l-3 7a3 3 0 0 0 6 0zM18 7l-3 7a3 3 0 0 0 6 0z"/>',
		'badge'   => '<circle cx="12" cy="9" r="6"/><path d="m8.5 14-1.5 8 5-3 5 3-1.5-8"/>',
		'users'   => '<circle cx="9" cy="8" r="4"/><path d="M2 21c0-4 3-7 7-7s7 3 7 7"/><path d="M16 4a4 4 0 0 1 0 8M22 21c0-3-1.5-5.5-4-6.5"/>',
		'dollar'  => '<path d="M12 2v20M17 6H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
		'clock'   => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>',
		'phone'   => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/>',
		'mail'    => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>',
		'pin'     => '<path d="M12 22s8-6 8-13a8 8 0 0 0-16 0c0 7 8 13 8 13z"/><circle cx="12" cy="9" r="3"/>',
		'book'    => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5z"/><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20v-5"/>',
		'arrow'   => '<path d="M5 12h14M13 6l6 6-6 6"/>',
	);
	$d = isset( $p[ $name ] ) ? $p[ $name ] : $p['shield'];
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $d . '</svg>';
}

/** Breadcrumb trail (markup; JSON-LD is printed by inc/seo.php). */
function sws_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	$crumbs = sws_breadcrumb_items();
	echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
	$last = count( $crumbs ) - 1;
	foreach ( $crumbs as $i => $c ) {
		if ( $i === $last ) {
			echo '<span aria-current="page">' . esc_html( $c['name'] ) . '</span>';
		} else {
			echo '<a href="' . esc_url( $c['url'] ) . '">' . esc_html( $c['name'] ) . '</a><span aria-hidden="true">/</span>';
		}
	}
	echo '</nav>';
}

function sws_breadcrumb_items() {
	$items = array( array( 'name' => 'Home', 'url' => home_url( '/' ) ) );
	if ( is_singular( 'post' ) ) {
		$blog = (int) get_option( 'page_for_posts' );
		$items[] = array( 'name' => $blog ? get_the_title( $blog ) : 'Blog', 'url' => $blog ? get_permalink( $blog ) : home_url( '/blog/' ) );
		$items[] = array( 'name' => get_the_title(), 'url' => get_permalink() );
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $anc ) {
			$items[] = array( 'name' => get_the_title( $anc ), 'url' => get_permalink( $anc ) );
		}
		$items[] = array( 'name' => get_the_title(), 'url' => get_permalink() );
	} elseif ( is_home() ) {
		$blog = (int) get_option( 'page_for_posts' );
		$items[] = array( 'name' => $blog ? get_the_title( $blog ) : 'Blog', 'url' => $blog ? get_permalink( $blog ) : home_url( '/blog/' ) );
	} elseif ( is_category() || is_tag() ) {
		$items[] = array( 'name' => single_term_title( '', false ), 'url' => get_term_link( get_queried_object() ) );
	} elseif ( is_search() ) {
		$items[] = array( 'name' => 'Search', 'url' => get_search_link() );
	}
	return $items;
}
