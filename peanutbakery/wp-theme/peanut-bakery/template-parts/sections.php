<?php
/**
 * Secciones reutilizables entre plantillas.
 *
 * @package PeanutBakery
 */

defined( 'ABSPATH' ) || exit;

/**
 * Tarjetas 3D de líneas de producto.
 *
 * @param string $heading_tag h2|h3.
 */
function pb_section_lines( $heading_tag = 'h3' ) {
	?>
	<div class="lines">
		<?php foreach ( pb_lines() as $i => $line ) : ?>
			<a class="line-card reveal" style="--d:<?php echo esc_attr( $i * 0.08 ); ?>s" href="<?php echo esc_url( home_url( '/productos/#' . $line['id'] ) ); ?>" data-tilt>
				<div class="line-card__media"><?php pb_img( $line['slot'], $line['name'] . ' artesanal en Rosarito — Peanut Bakery', array( 'size' => 'pb-card' ) ); ?></div>
				<div class="line-card__body">
					<span class="chip"><?php echo esc_html( $line['tag'] ); ?></span>
					<<?php echo esc_html( $heading_tag ); ?> class="line-card__title"><?php echo esc_html( $line['name'] ); ?></<?php echo esc_html( $heading_tag ); ?>>
					<p><?php echo esc_html( $line['desc'] ); ?></p>
					<span class="line-card__more"><?php esc_html_e( 'Ver línea', 'peanut-bakery' ); ?> <?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></span>
				</div>
			</a>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Valores / pilares.
 */
function pb_section_values() {
	?>
	<div class="values">
		<?php foreach ( pb_values() as $i => $v ) : ?>
			<article class="value reveal" style="--d:<?php echo esc_attr( $i * 0.1 ); ?>s">
				<span class="value__icon"><?php echo pb_icon( $v[0] ); // phpcs:ignore ?></span>
				<h3 class="value__title"><?php echo esc_html( $v[1] ); ?></h3>
				<p><?php echo esc_html( $v[2] ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Proceso de 4 pasos con línea animada.
 */
function pb_section_process() {
	?>
	<ol class="process" data-process>
		<?php foreach ( pb_process() as $i => $step ) : ?>
			<li class="process__step reveal" style="--d:<?php echo esc_attr( $i * 0.12 ); ?>s">
				<span class="process__num"><?php echo esc_html( $step[0] ); ?></span>
				<h3 class="process__title"><?php echo esc_html( $step[1] ); ?></h3>
				<p><?php echo esc_html( $step[2] ); ?></p>
			</li>
		<?php endforeach; ?>
	</ol>
	<?php
}

/**
 * Preguntas frecuentes (acordeón nativo <details>).
 */
function pb_section_faq() {
	?>
	<div class="faq">
		<?php foreach ( pb_faqs() as $i => $qa ) : ?>
			<details class="faq__item reveal" style="--d:<?php echo esc_attr( $i * 0.05 ); ?>s" <?php echo 0 === $i ? 'open' : ''; ?>>
				<summary><h3 class="faq__q"><?php echo esc_html( $qa[0] ); ?></h3><?php echo pb_icon( 'chevron' ); // phpcs:ignore ?></summary>
				<p class="faq__a"><?php echo esc_html( $qa[1] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Bloque de beneficios de mayoreo.
 */
function pb_section_wholesale_benefits() {
	?>
	<div class="benefits">
		<?php foreach ( pb_wholesale_benefits() as $i => $b ) : ?>
			<article class="benefit reveal" style="--d:<?php echo esc_attr( $i * 0.1 ); ?>s">
				<span class="benefit__icon"><?php echo pb_icon( $b[0] ); // phpcs:ignore ?></span>
				<div>
					<h3 class="benefit__title"><?php echo esc_html( $b[1] ); ?></h3>
					<p><?php echo esc_html( $b[2] ); ?></p>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Tarjetas de contacto.
 */
function pb_section_contact_cards() {
	$cards = array(
		array( 'whatsapp', 'WhatsApp', pb_opt( 'phone' ), pb_wa(), true ),
		array( 'phone', __( 'Teléfono', 'peanut-bakery' ), pb_opt( 'phone' ), pb_tel(), false ),
		array( 'mail', __( 'Correo de ventas', 'peanut-bakery' ), pb_opt( 'email' ), 'mailto:' . pb_opt( 'email' ), false ),
		array( 'pin', __( 'Ubicación', 'peanut-bakery' ), pb_address(), pb_opt( 'maps_link' ), true ),
		array( 'clock', __( 'Horario', 'peanut-bakery' ), pb_opt( 'hours' ), '', false ),
	);
	?>
	<div class="contact-cards">
		<?php foreach ( $cards as $i => $c ) : ?>
			<?php $tag = $c[3] ? 'a' : 'div'; ?>
			<<?php echo esc_html( $tag ); ?> class="contact-card reveal" style="--d:<?php echo esc_attr( $i * 0.07 ); ?>s" <?php echo $c[3] ? 'href="' . esc_url( $c[3] ) . '"' . ( $c[4] ? ' target="_blank" rel="noopener"' : '' ) : ''; ?>>
				<span class="contact-card__icon contact-card__icon--<?php echo esc_attr( $c[0] ); ?>"><?php echo pb_icon( $c[0] ); // phpcs:ignore ?></span>
				<span class="contact-card__label"><?php echo esc_html( $c[1] ); ?></span>
				<strong class="contact-card__value"><?php echo esc_html( $c[2] ); ?></strong>
			</<?php echo esc_html( $tag ); ?>>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Mapa de Google (carga diferida).
 */
function pb_section_map() {
	?>
	<div class="map reveal">
		<iframe title="<?php esc_attr_e( 'Mapa de Peanut Bakery en Playas de Rosarito', 'peanut-bakery' ); ?>" src="<?php echo esc_url( pb_opt( 'maps_embed' ) ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
	</div>
	<?php
}
