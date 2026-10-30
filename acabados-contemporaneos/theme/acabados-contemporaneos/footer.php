<?php
/**
 * Pie de página.
 *
 * @package Acabados
 */

$ac_lang  = ac_lang();
$ac_wa    = ac_whatsapp_url();
$ac_hours = ac_opt( 'en' === $ac_lang ? 'hours_en' : 'hours_es' );
$ac_addr  = ac_address_line();
?>
</main>

<footer class="site-footer">
	<div class="site-footer__marquee" aria-hidden="true">
		<div class="marquee__track">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<span><?php ac_e( 'cat1_t' ); ?></span><i>✦</i><span><?php ac_e( 'cat2_t' ); ?></span><i>✦</i><span><?php ac_e( 'cat3_t' ); ?></span><i>✦</i><span><?php ac_e( 'cat4_t' ); ?></span><i>✦</i><span><?php ac_e( 'cat5_t' ); ?></span><i>✦</i><span><?php ac_e( 'cat6_t' ); ?></span><i>✦</i>
			<?php endfor; ?>
		</div>
	</div>

	<div class="site-footer__grid container">
		<div class="site-footer__brand">
			<a class="brand brand--footer" href="<?php echo esc_url( ac_home_url() ); ?>">
				<span class="brand__text"><strong>Acabados</strong><em>Contemporáneos</em></span>
			</a>
			<p><?php ac_e( 'footer_claim' ); ?></p>
			<?php $ac_socials = ac_socials(); ?>
			<?php if ( $ac_socials ) : ?>
				<ul class="socials" aria-label="<?php ac_e( 'footer_follow' ); ?>">
					<?php foreach ( $ac_socials as $net => $url ) : ?>
						<li><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( ucfirst( $net ) ); ?>"><?php echo ac_icon( $net ); // phpcs:ignore ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="site-footer__col">
			<h2 class="site-footer__title"><?php ac_e( 'footer_explore' ); ?></h2>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'en' === $ac_lang ? 'footer_en' : 'footer_es',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'depth'          => 1,
					'fallback_cb'    => 'ac_fallback_menu',
				)
			);
			?>
		</div>

		<div class="site-footer__col">
			<h2 class="site-footer__title"><?php ac_e( 'footer_contact' ); ?></h2>
			<ul class="contact-list">
				<?php if ( ac_opt( 'phone' ) ) : ?>
					<li><?php echo ac_icon( 'phone' ); // phpcs:ignore ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', ac_opt( 'phone' ) ) ); ?>"><?php echo esc_html( ac_opt( 'phone' ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( ac_opt( 'email' ) ) : ?>
					<li><?php echo ac_icon( 'mail' ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( antispambot( ac_opt( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( ac_opt( 'email' ) ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( $ac_wa ) : ?>
					<li><?php echo ac_icon( 'whatsapp' ); // phpcs:ignore ?><a href="<?php echo esc_url( $ac_wa ); ?>" target="_blank" rel="noopener">WhatsApp</a></li>
				<?php endif; ?>
				<li><?php echo ac_icon( 'arrow' ); // phpcs:ignore ?><a href="<?php echo esc_url( ac_contact_url() ); ?>"><?php ac_e( 'quote' ); ?></a></li>
			</ul>
		</div>

		<div class="site-footer__col">
			<h2 class="site-footer__title"><?php ac_e( 'footer_visit' ); ?></h2>
			<ul class="contact-list">
				<?php if ( $ac_addr ) : ?>
					<li><?php echo ac_icon( 'pin' ); // phpcs:ignore ?>
						<?php if ( ac_opt( 'maps_url' ) ) : ?>
							<a href="<?php echo esc_url( ac_opt( 'maps_url' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $ac_addr ); ?></a>
						<?php else : ?>
							<span><?php echo esc_html( $ac_addr ); ?></span>
						<?php endif; ?>
					</li>
				<?php endif; ?>
				<?php if ( $ac_hours ) : ?>
					<li><?php echo ac_icon( 'clock' ); // phpcs:ignore ?><span><?php echo esc_html( $ac_hours ); ?></span></li>
				<?php endif; ?>
				<li><?php echo ac_icon( 'spark' ); // phpcs:ignore ?><span><?php echo esc_html( 'en' === $ac_lang ? 'Showroom with expert advice' : 'Showroom con asesoría experta' ); ?></span></li>
			</ul>
			<form class="footer-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="footer-s"><?php ac_e( 'search' ); ?></label>
				<input id="footer-s" type="search" name="s" placeholder="<?php echo esc_attr( ac_t( 'search_ph' ) ); ?>">
				<?php if ( 'en' === $ac_lang ) : ?><input type="hidden" name="lang" value="en"><?php endif; ?>
				<button type="submit" aria-label="<?php ac_e( 'search' ); ?>"><?php echo ac_icon( 'search' ); // phpcs:ignore ?></button>
			</form>
		</div>
	</div>

	<div class="site-footer__bottom container">
		<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Acabados Contemporáneos. <?php ac_e( 'rights' ); ?></p>
		<p><a href="<?php echo esc_url( ac_page_url( 'aviso-de-privacidad', 'en/privacy-notice' ) ); ?>"><?php ac_e( 'privacy' ); ?></a> · <a href="<?php echo esc_url( ac_translation_url() ); ?>"><?php ac_e( 'switch_lang' ); ?></a></p>
	</div>
</footer>

<?php if ( $ac_wa ) : ?>
	<a class="wa-float" href="<?php echo esc_url( $ac_wa ); ?>" target="_blank" rel="noopener" aria-label="<?php ac_e( 'whatsapp_label' ); ?>" data-magnetic>
		<?php echo ac_icon( 'whatsapp' ); // phpcs:ignore ?>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
