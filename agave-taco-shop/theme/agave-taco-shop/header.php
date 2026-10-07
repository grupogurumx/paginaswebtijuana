<?php
/**
 * Header.
 *
 * @package Agave
 */

?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'agave' ); ?></a>

<div class="preloader" aria-hidden="true">
	<div class="preloader__mark"><?php echo agave_icon( 'agave' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	<div class="preloader__word">Agave</div>
</div>

<div class="topbar">
	<div class="container topbar__inner">
		<span class="topbar__item"><?php echo agave_icon( 'clock' ); // phpcs:ignore ?> Open daily from 7 AM · Fri &amp; Sat until midnight</span>
		<a class="topbar__item" href="<?php echo esc_url( agave_biz( 'maps_url' ) ); ?>" target="_blank" rel="noopener"><?php echo agave_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( agave_address_line() ); ?></a>
		<a class="topbar__item topbar__phone" href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><?php echo agave_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( agave_biz( 'phone' ) ); ?></a>
	</div>
</div>

<header class="site-header" data-header>
	<div class="container site-header__inner">
		<div class="site-header__brand"><?php agave_logo(); ?></div>

		<nav class="nav" id="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'agave' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav__list',
					'depth'          => 2,
					'fallback_cb'    => 'agave_menu_fallback',
				)
			);
			?>
			<div class="nav__mobile-extra">
				<?php agave_button( 'Order Online', agave_biz( 'order_url' ), 'primary', true ); ?>
				<a class="nav__phone" href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><?php echo esc_html( agave_biz( 'phone' ) ); ?></a>
			</div>
		</nav>

		<div class="site-header__actions">
			<a class="btn btn--primary btn--sm site-header__order" href="<?php echo esc_url( agave_biz( 'order_url' ) ); ?>" target="_blank" rel="noopener" data-magnetic><span><?php esc_html_e( 'Order Online', 'agave' ); ?></span><?php echo agave_icon( 'bag' ); // phpcs:ignore ?></a>
			<button class="burger" type="button" aria-controls="site-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'agave' ); ?>" data-burger>
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<main id="main" class="site-main">
