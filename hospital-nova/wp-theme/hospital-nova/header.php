<?php
/**
 * Header.
 *
 * @package hospital-nova
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#0e2a3f">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php echo esc_html( nova_t( 'Saltar al contenido', 'Skip to content' ) ); ?></a>

<div class="topbar">
	<div class="container">
		<span class="topbar__live"><i class="pulse" aria-hidden="true"></i><?php echo esc_html( nova_t( 'Urgencias abiertas 24/7', 'ER open 24/7' ) ); ?></span>
		<div class="topbar__links">
			<a class="hide-sm" href="mailto:<?php echo esc_attr( nova_opt( 'email_to' ) ); ?>"><?php echo esc_html( nova_opt( 'email_to' ) ); ?></a>
			<a href="<?php echo esc_attr( nova_tel( nova_opt( 'phone' ) ) ); ?>"><?php echo esc_html( nova_opt( 'phone' ) ); ?></a>
		</div>
	</div>
</div>

<header class="site-header">
	<div class="container">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Hospital Nova — <?php echo esc_attr( nova_t( 'Inicio', 'Home' ) ); ?>">
			<?php
			$logo_id = get_theme_mod( 'custom_logo' );
			if ( $logo_id ) {
				echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'custom-logo', 'alt' => 'Hospital Nova' ) );
			} else {
				echo '<span><span class="brand__word">NOVA</span><span class="brand__sub">HOSPITAL</span></span>';
			}
			?>
		</a>

		<nav class="main-nav" id="main-nav" aria-label="<?php echo esc_attr( nova_t( 'Principal', 'Main' ) ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'fallback_cb'    => 'nova_fallback_menu',
				'depth'          => 1,
			) );
			?>
		</nav>

		<div class="header-actions">
			<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
				<ul class="lang-switch"><?php pll_the_languages( array( 'display_names_as' => 'slug', 'hide_if_no_translation' => 0 ) ); ?></ul>
			<?php endif; ?>
			<a class="btn btn--primary" href="<?php echo esc_url( nova_page_url( 'contacto', 'contact' ) ); ?>#cita" data-magnetic><?php echo nova_icon( 'calendar' ); ?><?php echo esc_html( nova_t( 'Agendar cita', 'Book now' ) ); ?></a>
			<button class="nav-toggle" aria-controls="main-nav" aria-expanded="false" aria-label="<?php echo esc_attr( nova_t( 'Abrir menú', 'Open menu' ) ); ?>"><span></span><span></span><span></span></button>
		</div>
	</div>
</header>
<main id="main">
