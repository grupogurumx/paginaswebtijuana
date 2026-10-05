<?php
/**
 * Pie de página + botón flotante de WhatsApp.
 *
 * @package PeanutBakery
 */

?>
</main>

<section class="cta-band">
	<div class="container cta-band__inner reveal">
		<div>
			<p class="eyebrow eyebrow--light"><?php esc_html_e( 'Recién salido del horno', 'peanut-bakery' ); ?></p>
			<h2 class="cta-band__title"><?php esc_html_e( '¿Se te antojó? Haz tu pedido en un mensaje.', 'peanut-bakery' ); ?></h2>
		</div>
		<div class="cta-band__actions">
			<a class="btn btn--wa btn--lg" href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'WhatsApp', 'peanut-bakery' ); ?> <?php echo esc_html( pb_opt( 'phone' ) ); ?></a>
			<a class="btn btn--ghost-light btn--lg" href="<?php echo esc_url( home_url( '/mayoreo/' ) ); ?>"><?php esc_html_e( 'Cotizar mayoreo', 'peanut-bakery' ); ?></a>
		</div>
	</div>
</section>

<footer class="site-footer">
	<div class="container site-footer__grid">
		<div class="site-footer__brand">
			<a class="brand brand--light" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="brand__mark"><?php echo pb_icon( 'wheat' ); // phpcs:ignore ?></span><span class="brand__name">Peanut<b>Bakery</b></span></a>
			<p><?php esc_html_e( 'Panadería artesanal en Playas de Rosarito. Ingeniería del pan: masa madre con 30 horas de fermentación, pan dulce, bolillo, birote y repostería fina hechos a mano cada día.', 'peanut-bakery' ); ?></p>
			<div class="socials">
				<?php foreach ( pb_socials() as $net => $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( ucfirst( $net ) ); ?>"><?php echo pb_icon( $net ); // phpcs:ignore ?></a>
				<?php endforeach; ?>
			</div>
		</div>

		<div>
			<h3 class="site-footer__title"><?php esc_html_e( 'Navegación', 'peanut-bakery' ); ?></h3>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'site-footer__links',
					'fallback_cb'    => 'pb_fallback_menu',
					'depth'          => 1,
				)
			);
			?>
		</div>

		<div>
			<h3 class="site-footer__title"><?php esc_html_e( 'Productos', 'peanut-bakery' ); ?></h3>
			<ul class="site-footer__links">
				<?php foreach ( pb_lines() as $line ) : ?>
					<li><a href="<?php echo esc_url( home_url( '/productos/#' . $line['id'] ) ); ?>"><?php echo esc_html( $line['name'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h3 class="site-footer__title"><?php esc_html_e( 'Contacto', 'peanut-bakery' ); ?></h3>
			<ul class="contact-list">
				<li><?php echo pb_icon( 'pin' ); // phpcs:ignore ?> <a href="<?php echo esc_url( pb_opt( 'maps_link' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( pb_address() ); ?></a></li>
				<li><?php echo pb_icon( 'phone' ); // phpcs:ignore ?> <a href="<?php echo esc_url( pb_tel() ); ?>"><?php echo esc_html( pb_opt( 'phone' ) ); ?></a></li>
				<li><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <a href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener">WhatsApp <?php echo esc_html( pb_opt( 'phone' ) ); ?></a></li>
				<li><?php echo pb_icon( 'mail' ); // phpcs:ignore ?> <a href="mailto:<?php echo esc_attr( pb_opt( 'email' ) ); ?>"><?php echo esc_html( pb_opt( 'email' ) ); ?></a></li>
				<li><?php echo pb_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( pb_opt( 'hours' ) ); ?></li>
			</ul>
		</div>
	</div>
	<div class="container site-footer__bottom">
		<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Peanut Bakery · <?php esc_html_e( 'Panadería artesanal en Playas de Rosarito, Baja California.', 'peanut-bakery' ); ?></p>
		<p><?php esc_html_e( 'Pan de masa madre · Pan dulce · Bolillo y birote · Pan al mayoreo en Rosarito y Tijuana', 'peanut-bakery' ); ?></p>
	</div>
</footer>

<a class="wa-float" href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Pedir por WhatsApp', 'peanut-bakery' ); ?>">
	<?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?>
	<span class="wa-float__label"><?php esc_html_e( '¿Pedimos pan?', 'peanut-bakery' ); ?></span>
</a>

<?php wp_footer(); ?>
</body>
</html>
