<?php
/**
 * Footer.
 *
 * @package Agave
 */

?>
</main>

<section class="cta-band" aria-label="<?php esc_attr_e( 'Order now', 'agave' ); ?>">
	<div class="cta-band__marquee" aria-hidden="true">
		<div class="marquee__track">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<span>Hungry yet?</span><span class="dot">✦</span><span>Hungry yet?</span><span class="dot">✦</span><span>Hungry yet?</span><span class="dot">✦</span><span>Hungry yet?</span><span class="dot">✦</span>
			<?php endfor; ?>
		</div>
	</div>
	<div class="container cta-band__inner">
		<p class="cta-band__text" data-reveal>Hot birria is <em>just minutes</em> away.</p>
		<div class="cta-band__actions" data-reveal>
			<?php agave_button( 'Order Pickup', agave_biz( 'order_url' ), 'light', true ); ?>
			<?php agave_button( 'Get Directions', agave_biz( 'maps_url' ), 'ghost-light', true ); ?>
		</div>
	</div>
</section>

<footer class="site-footer">
	<div class="container site-footer__grid">
		<div class="site-footer__brand">
			<?php agave_logo(); ?>
			<p>Point Loma’s home of slow-braised birria, cheesy quesabirria and San Diego-sized burritos. Family-owned, made from scratch, served with love since day one.</p>
			<div class="social">
				<a href="<?php echo esc_url( agave_biz( 'instagram_url' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo agave_icon( 'instagram' ); // phpcs:ignore ?></a>
				<a href="<?php echo esc_url( agave_biz( 'facebook_url' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo agave_icon( 'facebook' ); // phpcs:ignore ?></a>
				<a href="<?php echo esc_url( agave_biz( 'yelp_url' ) ); ?>" target="_blank" rel="noopener" aria-label="Yelp"><?php echo agave_icon( 'yelp' ); // phpcs:ignore ?></a>
			</div>
		</div>

		<div>
			<h3 class="site-footer__title">Visit</h3>
			<address>
				<a href="<?php echo esc_url( agave_biz( 'maps_url' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( agave_biz( 'street' ) ); ?><br><?php echo esc_html( agave_biz( 'city' ) . ', ' . agave_biz( 'region' ) . ' ' . agave_biz( 'zip' ) ); ?></a><br>
				<a href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><?php echo esc_html( agave_biz( 'phone' ) ); ?></a>
			</address>
			<p class="site-footer__small">Drive-thru · Takeout · Outdoor seating</p>
		</div>

		<div>
			<h3 class="site-footer__title">Hours</h3>
			<?php agave_hours_list(); ?>
		</div>

		<div>
			<h3 class="site-footer__title">Explore</h3>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'site-footer__menu',
					'depth'          => 1,
					'fallback_cb'    => 'agave_menu_fallback',
				)
			);
			?>
		</div>
	</div>

	<div class="container site-footer__bottom">
		<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( agave_biz( 'name' ) ); ?> · Point Loma, San Diego, CA. All rights reserved.</p>
		<p>Sister restaurant: <a href="<?php echo esc_url( agave_biz( 'sister_url' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( agave_biz( 'sister_name' ) ); ?></a> · Photos: Freepik / Magnific · Website by <a href="https://webmastertijuana.com/" target="_blank" rel="noopener">Webmaster Tijuana</a></p>
	</div>
</footer>

<a class="sticky-order" href="<?php echo esc_url( agave_biz( 'order_url' ) ); ?>" target="_blank" rel="noopener"><?php echo agave_icon( 'bag' ); // phpcs:ignore ?> Order Online</a>
<div class="cursor-glow" aria-hidden="true"></div>

<?php wp_footer(); ?>
</body>
</html>
