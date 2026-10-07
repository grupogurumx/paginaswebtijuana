<?php
/**
 * Small rendering helpers.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

/**
 * Inline SVG icon set (no icon font requests).
 *
 * @param string $name Icon name.
 * @return string
 */
function agave_icon( $name ) {
	$icons = array(
		'agave'     => '<svg viewBox="0 0 64 64" aria-hidden="true"><path d="M32 60c-1-14-1-30 0-56 1 26 1 42 0 56Z"/><path d="M32 60C26 46 18 32 6 20c14 8 22 22 26 40Z"/><path d="M32 60c6-14 14-28 26-40-14 8-22 22-26 40Z"/><path d="M32 60C24 52 12 46 2 44c12-1 24 5 30 16Z"/><path d="M32 60c8-8 20-14 30-16-12-1-24 5-30 16Z"/><path d="M32 60c-3-12-5-26-14-40 10 10 14 26 14 40Z"/><path d="M32 60c3-12 5-26 14-40-10 10-14 26-14 40Z"/></svg>',
		'arrow'     => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'phone'     => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1Z" fill="currentColor"/></svg>',
		'pin'       => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z" fill="currentColor"/></svg>',
		'clock'     => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
		'car'       => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 11l1.5-4.5A2 2 0 0 1 8.4 5h7.2a2 2 0 0 1 1.9 1.5L19 11m-14 0h14a2 2 0 0 1 2 2v4h-2v2h-3v-2H8v2H5v-2H3v-4a2 2 0 0 1 2-2Zm2.5 3.5h.01m9 0h.01" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'flame'     => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22c4 0 7-2.7 7-6.6 0-3.7-2.6-6-4.2-8.4-.4 2-1.4 3.2-2.6 3.8.2-3.3-1.2-6.4-4.2-8.8.3 3.6-3 6.5-3 11.2C5 19 8 22 12 22Z" fill="currentColor"/></svg>',
		'bag'       => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 7h12l1 14H5L6 7Zm3 0a3 3 0 0 1 6 0" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
		'star'      => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1 6.2L12 17.3 6.5 20.2l1-6.2L3 9.6l6.2-.9L12 3Z" fill="currentColor"/></svg>',
		'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/></svg>',
		'facebook'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3a4 4 0 0 0-4 4v2H7v4h3v8h4v-8h3l1-4h-4V8Z" fill="currentColor"/></svg>',
		'yelp'      => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.3 2.2c-.5-.3-4.2.8-4.9 1.4-.3.3-.3.7-.2 1l3.9 6.6c.5.8 1.7.5 1.7-.5V2.9c0-.3-.2-.6-.5-.7Zm-1.9 11.4-5.3-1.7c-.7-.2-1.3.4-1.2 1.1.2 1.6.9 3.1 2 4.3.5.5 1.3.3 1.5-.3l1.6-2.4c.4-.5.1-.9-.6-1Zm2.6 2.5v5.6c0 .7.7 1.2 1.4.9 1.4-.6 2.6-1.6 3.4-2.9.3-.6 0-1.3-.6-1.5l-3.4-1.4c-.4-.2-.8.1-.8.5v-1.2Zm1-3.4 5.3-1.4c.7-.2 1-.9.7-1.5-.6-1.4-1.6-2.6-2.9-3.4-.6-.3-1.3 0-1.5.6l-2.3 4.5c-.3.6.2 1.3.7 1.2Z" fill="currentColor"/></svg>',
		'menu'      => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
		'close'     => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Site logo: custom logo if uploaded, otherwise the animated agave wordmark.
 */
function agave_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	printf(
		'<a class="wordmark" href="%1$s" rel="home" aria-label="%2$s"><span class="wordmark__mark">%3$s</span><span class="wordmark__text"><strong>Agave</strong><em>Taco Shop</em></span></a>',
		esc_url( home_url( '/' ) ),
		esc_attr( agave_biz( 'name' ) ),
		agave_icon( 'agave' ) // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG.
	);
}

/**
 * Primary CTA button.
 *
 * @param string $label Label.
 * @param string $url   URL.
 * @param string $style Modifier.
 * @param bool   $external Open in new tab.
 */
function agave_button( $label, $url, $style = 'primary', $external = false ) {
	printf(
		'<a class="btn btn--%1$s" href="%2$s"%3$s data-magnetic><span>%4$s</span>%5$s</a>',
		esc_attr( $style ),
		esc_url( $url ),
		$external ? ' target="_blank" rel="noopener"' : '',
		esc_html( $label ),
		agave_icon( 'arrow' ) // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG.
	);
}

/**
 * Delivery / ordering partners ("our partners" logo strip).
 *
 * @return array
 */
function agave_partners() {
	return array(
		array( 'name' => 'Order Direct', 'note' => 'Pickup · best price', 'url' => agave_biz( 'order_url' ), 'class' => 'direct' ),
		array( 'name' => 'DoorDash', 'note' => 'Delivery', 'url' => agave_biz( 'doordash_url' ), 'class' => 'doordash' ),
		array( 'name' => 'Uber Eats', 'note' => 'Delivery', 'url' => agave_biz( 'ubereats_url' ), 'class' => 'ubereats' ),
		array( 'name' => 'Postmates', 'note' => 'Delivery', 'url' => agave_biz( 'postmates_url' ), 'class' => 'postmates' ),
		array( 'name' => 'Yelp', 'note' => 'Reviews', 'url' => agave_biz( 'yelp_url' ), 'class' => 'yelp' ),
	);
}

/**
 * Hours table.
 */
function agave_hours_list() {
	echo '<dl class="hours">';
	foreach ( agave_biz( 'hours_human' ) as $days => $time ) {
		printf( '<div><dt>%s</dt><dd>%s</dd></div>', esc_html( $days ), esc_html( $time ) );
	}
	echo '</dl>';
}

/**
 * Page hero for interior pages.
 *
 * @param string $title   Title.
 * @param string $kicker  Small label above.
 * @param string $image   Image URL.
 * @param string $lede    Optional intro line.
 */
function agave_page_hero( $title, $kicker = '', $image = '', $lede = '' ) {
	?>
	<header class="page-hero" data-parallax-root>
		<?php if ( $image ) : ?>
			<div class="page-hero__media" data-parallax="0.25" style="background-image:url('<?php echo esc_url( $image ); ?>')"></div>
		<?php endif; ?>
		<div class="page-hero__veil"></div>
		<div class="container page-hero__inner">
			<?php if ( $kicker ) : ?>
				<p class="kicker" data-reveal><?php echo esc_html( $kicker ); ?></p>
			<?php endif; ?>
			<h1 class="page-hero__title" data-split><?php echo esc_html( $title ); ?></h1>
			<?php if ( $lede ) : ?>
				<p class="page-hero__lede" data-reveal><?php echo esc_html( $lede ); ?></p>
			<?php endif; ?>
		</div>
	</header>
	<?php
}

/**
 * Breadcrumbs (visual; the matching BreadcrumbList schema lives in seo.php).
 */
function agave_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	$crumbs = agave_breadcrumb_trail();
	echo '<nav class="breadcrumbs container" aria-label="Breadcrumb"><ol>';
	$last = count( $crumbs ) - 1;
	foreach ( $crumbs as $i => $crumb ) {
		if ( $i === $last ) {
			printf( '<li aria-current="page">%s</li>', esc_html( $crumb['name'] ) );
		} else {
			printf( '<li><a href="%s">%s</a></li>', esc_url( $crumb['url'] ), esc_html( $crumb['name'] ) );
		}
	}
	echo '</ol></nav>';
}

/**
 * Build the breadcrumb trail for the current request.
 *
 * @return array
 */
function agave_breadcrumb_trail() {
	$trail = array(
		array(
			'name' => 'Home',
			'url'  => home_url( '/' ),
		),
	);
	if ( is_home() ) {
		$trail[] = array(
			'name' => get_the_title( get_option( 'page_for_posts' ) ) ? get_the_title( get_option( 'page_for_posts' ) ) : 'Blog',
			'url'  => get_permalink( get_option( 'page_for_posts' ) ),
		);
	} elseif ( is_singular( 'post' ) ) {
		$blog = get_option( 'page_for_posts' );
		if ( $blog ) {
			$trail[] = array(
				'name' => get_the_title( $blog ),
				'url'  => get_permalink( $blog ),
			);
		}
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) {
			$trail[] = array(
				'name' => get_the_title( $ancestor ),
				'url'  => get_permalink( $ancestor ),
			);
		}
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_category() || is_tag() ) {
		$trail[] = array(
			'name' => single_term_title( '', false ),
			'url'  => get_term_link( get_queried_object() ),
		);
	} elseif ( is_search() ) {
		$trail[] = array(
			'name' => 'Search',
			'url'  => get_search_link(),
		);
	}
	return $trail;
}
