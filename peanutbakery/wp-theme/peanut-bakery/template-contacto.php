<?php
/**
 * Template Name: Contacto
 *
 * @package PeanutBakery
 */

get_header();
pb_page_hero(
	array(
		'eyebrow' => __( 'Pedidos y cotizaciones', 'peanut-bakery' ),
		'title'   => __( 'Contacto', 'peanut-bakery' ),
		'lead'    => __( 'Haz tu pedido de pan artesanal en Playas de Rosarito. WhatsApp, teléfono o formulario: tú eliges.', 'peanut-bakery' ),
		'slot'    => 'contact',
		'alt'     => __( 'Pan artesanal de Peanut Bakery — contacto y pedidos en Rosarito', 'peanut-bakery' ),
	)
);
?>

<section class="section">
	<div class="container">
		<?php pb_section_contact_cards(); ?>
	</div>
</section>

<section class="section section--cream" id="formulario">
	<div class="container form-wrap">
		<div>
			<p class="eyebrow reveal"><?php esc_html_e( 'Escríbenos', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Envíanos tu pedido o cotización', 'peanut-bakery' ); ?></h2>
			<p class="reveal"><?php printf( esc_html__( 'Tu mensaje llega a %s. Para pedidos del día, WhatsApp es lo más rápido.', 'peanut-bakery' ), '<strong>' . esc_html( pb_opt( 'email' ) ) . '</strong>' ); // phpcs:ignore ?></p>
		</div>
		<?php pb_form( 'contacto' ); ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow reveal"><?php esc_html_e( 'Ubicación', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Encuéntranos en Playas de Rosarito', 'peanut-bakery' ); ?></h2>
		</header>
		<?php pb_section_map(); ?>
	</div>
</section>

<?php
get_footer();
