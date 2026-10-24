<?php defined( 'ABSPATH' ) || exit; ?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0a1733">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php echo 'es' === dmc_lang() ? 'Saltar al contenido' : 'Skip to content'; ?></a>

<header class="site-header" id="top">
	<div class="container">
		<a class="brand" href="<?php echo esc_url( dmc_home_url() ); ?>" aria-label="Dr. Mario Camelo">
			<?php
			$logo_id = get_theme_mod( 'custom_logo' );
			if ( $logo_id ) {
				echo wp_get_attachment_image( $logo_id, 'full', false, array( 'alt' => 'Dr. Mario Camelo' ) );
			} else {
				echo dmc_logo_svg(); // phpcs:ignore WordPress.Security.EscapeOutput
				?>
				<span class="brand__text"><span class="brand__name">Dr. Mario Camelo</span><span class="brand__tag"><?php echo esc_html( dmc_t( 'brand_tag' ) ); ?></span></span>
			<?php } ?>
		</a>

		<nav class="main-nav" id="main-nav" aria-label="<?php echo esc_attr( dmc_t( 'nav_procedures' ) ); ?>">
			<?php dmc_nav( 'primary' ); ?>
		</nav>

		<div class="header-actions">
			<div class="lang-switch" role="group" aria-label="Language">
				<a href="<?php echo esc_url( 'en' === dmc_lang() ? dmc_current_url() : dmc_translation_url( 'en' ) ); ?>" class="<?php echo 'en' === dmc_lang() ? 'is-active' : ''; ?>" hreflang="en" lang="en">EN</a>
				<a href="<?php echo esc_url( 'es' === dmc_lang() ? dmc_current_url() : dmc_translation_url( 'es' ) ); ?>" class="<?php echo 'es' === dmc_lang() ? 'is-active' : ''; ?>" hreflang="es" lang="es">ES</a>
			</div>
			<a class="btn btn--gold" href="<?php echo esc_url( dmc_page_url( 'contact' ) . '#contact-form' ); ?>" data-magnetic data-track="cta_header"><?php echo esc_html( dmc_t( 'cta_free' ) ); ?></a>
			<button class="nav-toggle" aria-controls="main-nav" aria-expanded="false" aria-label="Menu"><span></span><span></span><span></span></button>
		</div>
	</div>
</header>
<main id="main">
