<?php
/**
 * Header top de páginas interiores: imagen panorámica con parallax, migas y H1.
 *
 * @package PeanutBakery
 */

$a = wp_parse_args(
	$args,
	array(
		'eyebrow' => '',
		'title'   => get_the_title(),
		'crumb'   => get_the_title(),
		'lead'    => '',
		'slot'    => 'about',
		'alt'     => get_the_title(),
	)
);
?>
<section class="page-hero" data-parallax-wrap>
	<div class="page-hero__media" data-parallax="0.25">
		<?php pb_img( $a['slot'], $a['alt'], array( 'size' => 'pb-panorama', 'eager' => true ) ); ?>
	</div>
	<div class="page-hero__shade"></div>
	<div class="container page-hero__content">
		<nav class="crumbs" aria-label="<?php esc_attr_e( 'Migas de pan', 'peanut-bakery' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'peanut-bakery' ); ?></a>
			<span aria-hidden="true">/</span>
			<span aria-current="page"><?php echo esc_html( wp_strip_all_tags( $a['crumb'] ) ); ?></span>
		</nav>
		<?php if ( $a['eyebrow'] ) : ?>
			<p class="eyebrow eyebrow--light anim-up"><?php echo esc_html( $a['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1 class="page-hero__title anim-up" style="--d:.1s"><?php echo wp_kses( $a['title'], array( 'em' => array() ) ); ?></h1>
		<?php if ( $a['lead'] ) : ?>
			<p class="page-hero__lead anim-up" style="--d:.2s"><?php echo esc_html( $a['lead'] ); ?></p>
		<?php endif; ?>
	</div>
	<div class="page-hero__wave" aria-hidden="true">
		<svg viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 40c240 40 480 40 720 0s480-40 720 0v40H0Z" fill="currentColor"/></svg>
	</div>
</section>
