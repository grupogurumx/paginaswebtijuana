<?php
/**
 * Encabezado.
 *
 * @package Acabados
 */

$ac_lang = ac_lang();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#contenido"><?php ac_e( 'skip' ); ?></a>

<header class="site-header" data-header>
	<div class="site-header__inner">
		<a class="brand" href="<?php echo esc_url( ac_home_url() ); ?>" aria-label="Acabados Contemporáneos — <?php ac_e( 'back_home' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'brand__logo', 'alt' => 'Acabados Contemporáneos' ) ); ?>
			<?php else : ?>
				<span class="brand__mark" aria-hidden="true">
					<svg viewBox="0 0 40 40" width="38" height="38"><rect x="1" y="1" width="17" height="17" fill="currentColor" opacity=".9"/><rect x="22" y="1" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.5"/><rect x="1" y="22" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.5"/><rect x="22" y="22" width="17" height="17" fill="var(--ac-accent)"/></svg>
				</span>
				<span class="brand__text"><strong>Acabados</strong><em>Contemporáneos</em></span>
			<?php endif; ?>
		</a>

		<nav class="primary-nav" id="primary-nav" aria-label="<?php echo esc_attr( ac_t( 'menu' ) ); ?>" data-nav>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'en' === $ac_lang ? 'primary_en' : 'primary_es',
					'container'      => false,
					'menu_class'     => 'menu',
					'depth'          => 2,
					'fallback_cb'    => 'ac_fallback_menu',
				)
			);
			?>
			<div class="primary-nav__extra">
				<a class="lang-switch" href="<?php echo esc_url( ac_translation_url() ); ?>" hreflang="<?php echo 'en' === $ac_lang ? 'es' : 'en'; ?>" lang="<?php echo 'en' === $ac_lang ? 'es' : 'en'; ?>">
					<span aria-hidden="true"><?php ac_e( 'switch_lang_abbr' ); ?></span><span class="screen-reader-text"><?php ac_e( 'switch_lang' ); ?></span>
				</a>
				<a class="ac-btn ac-btn--solid ac-btn--sm" href="<?php echo esc_url( ac_contact_url() ); ?>" data-magnetic><?php ac_e( 'quote' ); ?></a>
			</div>
		</nav>

		<button class="nav-toggle" type="button" aria-controls="primary-nav" aria-expanded="false" data-nav-toggle>
			<span class="nav-toggle__bars" aria-hidden="true"><span></span><span></span></span>
			<span class="screen-reader-text"><?php ac_e( 'menu' ); ?></span>
		</button>
	</div>
</header>

<main id="contenido" class="site-main" tabindex="-1">
