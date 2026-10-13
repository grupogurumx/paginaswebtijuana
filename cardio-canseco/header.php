<?php
/**
 * Cabecera del sitio.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#061B34">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#contenido"><?php esc_html_e( 'Saltar al contenido principal', 'cardio-canseco' ); ?></a>

<!-- Barra superior -->
<div class="topbar">
	<div class="wrap topbar__inner">
		<ul class="topbar__list">
			<li>
				<a href="<?php echo esc_url( cardio_maps_url() ); ?>" target="_blank" rel="noopener">
					<?php cardio_icon_e( 'pin' ); ?>
					<?php echo esc_html( cardio_opt( 'calle2' ) ); ?>
				</a>
			</li>
			<?php if ( cardio_opt( 'email' ) ) : ?>
				<li>
					<a href="mailto:<?php echo esc_attr( cardio_opt( 'email' ) ); ?>">
						<?php cardio_icon_e( 'mail' ); ?>
						<?php cardio_e( 'email' ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>
		<ul class="topbar__list">
			<li class="topbar__phone">
				<a href="<?php echo esc_url( cardio_tel_url() ); ?>">
					<?php cardio_icon_e( 'phone' ); ?>
					<b style="color:#fff"><?php cardio_e( 'tel' ); ?></b>
				</a>
			</li>
		</ul>
	</div>
</div>

<!-- Cabecera -->
<header class="site-header">
	<div class="wrap header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ', ' . __( 'inicio', 'cardio-canseco' ) ); ?>">
			<?php cardio_marca(); ?>
			<span class="brand__text">
				<span class="brand__name"><?php bloginfo( 'name' ); ?></span>
				<span class="brand__sub"><?php cardio_e( 'medico' ); ?></span>
			</span>
		</a>

		<nav class="nav" aria-label="<?php esc_attr_e( 'Navegación principal', 'cardio-canseco' ); ?>">
			<?php
			if ( has_nav_menu( 'principal' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'principal',
						'container'      => false,
						'menu_class'     => 'nav__list',
						'depth'          => 2,
						'walker'         => new Cardio_Nav_Walker(),
					)
				);
			} else {
				cardio_fallback_menu();
			}
			?>

			<div class="header__cta">
				<a class="btn btn--ghost" href="<?php echo esc_url( cardio_tel_url() ); ?>">
					<?php cardio_icon_e( 'phone' ); ?>
					<?php esc_html_e( 'Llamar', 'cardio-canseco' ); ?>
				</a>
				<a class="btn btn--accent" href="<?php echo esc_url( cardio_cita_url() ); ?>">
					<?php esc_html_e( 'Agenda tu cita', 'cardio-canseco' ); ?>
				</a>
			</div>

			<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu-movil" aria-label="<?php esc_attr_e( 'Abrir menú', 'cardio-canseco' ); ?>">
				<span class="nav-toggle__bars" aria-hidden="true"><span></span><span></span><span></span></span>
			</button>
		</nav>
	</div>
	<span class="scroll-progress" aria-hidden="true"></span>
</header>

<!-- Menú móvil -->
<div class="mobile-nav" id="menu-movil" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menú de navegación', 'cardio-canseco' ); ?>">
	<div class="mobile-nav__head">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ', ' . __( 'inicio', 'cardio-canseco' ) ); ?>">
			<?php cardio_marca(); ?>
			<span class="brand__text">
				<span class="brand__name brand__name--claro"><?php bloginfo( 'name' ); ?></span>
				<span class="brand__sub brand__sub--claro"><?php cardio_e( 'medico' ); ?></span>
			</span>
		</a>
		<button class="mobile-nav__close" type="button" aria-label="<?php esc_attr_e( 'Cerrar menú', 'cardio-canseco' ); ?>">
			<?php cardio_icon_e( 'close' ); ?>
		</button>
	</div>

	<?php
	if ( has_nav_menu( 'principal' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'principal',
				'container'      => false,
				'menu_class'     => 'mobile-nav__list',
				'depth'          => 2,
			)
		);
	}
	?>

	<div class="mobile-nav__foot">
		<a class="btn btn--accent btn--block" href="<?php echo esc_url( cardio_cita_url() ); ?>">
			<?php esc_html_e( 'Agenda tu cita', 'cardio-canseco' ); ?>
		</a>
		<a class="btn btn--on-dark btn--block" href="<?php echo esc_url( cardio_tel_url() ); ?>">
			<?php echo esc_html( sprintf( __( 'Llamar %s', 'cardio-canseco' ), cardio_opt( 'tel' ) ) ); ?>
		</a>
	</div>
</div>

<main id="contenido">
