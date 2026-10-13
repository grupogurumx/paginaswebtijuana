<?php
/**
 * Cabecera.
 *
 * @package WebmasterTijuana
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0d1257">
	<script>document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#contenido"><?php esc_html_e( 'Saltar al contenido', 'webmaster-tijuana' ); ?></a>

<div class="topbar">
	<div class="container topbar__inner">
		<ul class="topbar__info">
			<li><a href="<?php echo esc_url( wmt_tel_href() ); ?>"><?php echo wmt_icon( 'phone' ); // phpcs:ignore ?><?php echo esc_html( wmt_opt( 'telefono' ) ); ?></a></li>
			<li><a href="mailto:<?php echo esc_attr( wmt_opt( 'email' ) ); ?>"><?php echo wmt_icon( 'mail' ); // phpcs:ignore ?><?php echo esc_html( wmt_opt( 'email' ) ); ?></a></li>
			<?php if ( wmt_opt( 'horario' ) ) : ?>
				<li class="topbar__hide-sm"><?php echo wmt_icon( 'clock' ); // phpcs:ignore ?><?php echo esc_html( wmt_opt( 'horario' ) ); ?></li>
			<?php endif; ?>
		</ul>
		<?php if ( wmt_socials() ) : ?>
			<ul class="topbar__social">
				<?php foreach ( wmt_socials() as $key => $red ) : ?>
					<li><a href="<?php echo esc_url( $red['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $red['label'] ); ?>"><?php echo wmt_icon( $key ); // phpcs:ignore ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>

<header class="site-header" id="cabecera">
	<div class="container site-header__inner">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php wmt_logo( 'color' ); ?>
		</a>

		<nav class="main-nav" id="menu-principal" aria-label="<?php esc_attr_e( 'Menú principal', 'webmaster-tijuana' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'principal',
					'container'      => false,
					'menu_class'     => 'main-nav__list',
					'depth'          => 2,
					'fallback_cb'    => 'wmt_menu_fallback',
				)
			);
			?>
			<div class="main-nav__extra">
				<a class="btn btn--primary btn--block" href="<?php echo esc_url( wmt_cotizar_url() ); ?>"><?php esc_html_e( 'Cotizar ahora', 'webmaster-tijuana' ); ?></a>
				<a class="main-nav__tel" href="<?php echo esc_url( wmt_tel_href() ); ?>"><?php echo wmt_icon( 'phone' ); // phpcs:ignore ?><?php echo esc_html( wmt_opt( 'telefono' ) ); ?></a>
			</div>
		</nav>

		<div class="site-header__actions">
			<a class="btn btn--primary site-header__cta" href="<?php echo esc_url( wmt_cotizar_url() ); ?>"><?php esc_html_e( 'Cotizar ahora', 'webmaster-tijuana' ); ?></a>
			<button class="nav-toggle" type="button" aria-controls="menu-principal" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'Abrir menú', 'webmaster-tijuana' ); ?></span>
				<?php echo wmt_icon( 'menu', 'nav-toggle__open' ); // phpcs:ignore ?>
				<?php echo wmt_icon( 'close', 'nav-toggle__close' ); // phpcs:ignore ?>
			</button>
		</div>
	</div>
</header>

<main id="contenido" class="site-main">
