<?php
/**
 * Header.
 *
 * @package sws
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#07090c">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'sws' ); ?></a>

<header class="site-header">
	<div class="wrap header-inner">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="Southwestern Solutions — Home">
				<?php echo sws_logo_mark(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<span class="brand-text">Southwestern<small>Solutions · Training</small></span>
			</a>
		<?php endif; ?>

		<nav class="main-nav" aria-label="<?php esc_attr_e( 'Primary', 'sws' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'sws_menu_fallback',
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="header-cta">
			<a class="btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Reserve a Seat</a>
			<button class="nav-toggle" type="button" aria-label="<?php esc_attr_e( 'Open menu', 'sws' ); ?>" aria-expanded="false"><span></span></button>
		</div>
	</div>
</header>

<main id="main">
