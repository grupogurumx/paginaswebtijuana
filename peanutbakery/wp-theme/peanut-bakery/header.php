<?php
/**
 * Cabecera: barra superior de contacto + header fijo con efecto vidrio.
 *
 * @package PeanutBakery
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#contenido"><?php esc_html_e( 'Saltar al contenido', 'peanut-bakery' ); ?></a>

<div class="topbar">
	<div class="container topbar__inner">
		<p class="topbar__item"><?php echo pb_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( pb_opt( 'city' ) ); ?>, B.C.</p>
		<p class="topbar__item topbar__item--hide"><?php echo pb_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( pb_opt( 'hours' ) ); ?></p>
		<div class="topbar__right">
			<a class="topbar__item" href="<?php echo esc_url( pb_tel() ); ?>"><?php echo pb_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( pb_opt( 'phone' ) ); ?></a>
			<a class="topbar__item topbar__item--hide" href="mailto:<?php echo esc_attr( pb_opt( 'email' ) ); ?>"><?php echo pb_icon( 'mail' ); // phpcs:ignore ?> <?php echo esc_html( pb_opt( 'email' ) ); ?></a>
			<?php foreach ( pb_socials() as $net => $url ) : ?>
				<a class="topbar__social" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( ucfirst( $net ) ); ?>"><?php echo pb_icon( $net ); // phpcs:ignore ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<header class="site-header" data-header>
	<div class="container site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="Peanut Bakery — Inicio">
			<?php
			if ( has_custom_logo() ) {
				echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'brand__logo', 'alt' => 'Peanut Bakery' ) );
			} else {
				echo '<span class="brand__mark">' . pb_icon( 'wheat' ) . '</span><span class="brand__name">Peanut<b>Bakery</b></span>'; // phpcs:ignore
			}
			?>
		</a>

		<nav class="nav" id="menu-principal" aria-label="<?php esc_attr_e( 'Principal', 'peanut-bakery' ); ?>" data-nav>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'principal',
					'container'      => false,
					'menu_class'     => 'nav__list',
					'fallback_cb'    => 'pb_fallback_menu',
					'depth'          => 2,
				)
			);
			?>
			<a class="btn btn--wa nav__cta-mobile" href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'Pedir por WhatsApp', 'peanut-bakery' ); ?></a>
		</nav>

		<a class="btn btn--wa site-header__cta" href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <span><?php esc_html_e( 'Pedir ahora', 'peanut-bakery' ); ?></span></a>

		<button class="burger" type="button" aria-controls="menu-principal" aria-expanded="false" data-burger>
			<span class="screen-reader-text"><?php esc_html_e( 'Abrir menú', 'peanut-bakery' ); ?></span>
			<span></span><span></span><span></span>
		</button>
	</div>
</header>

<main id="contenido" class="site-main">
