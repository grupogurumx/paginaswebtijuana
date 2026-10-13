<?php
/**
 * Pie de página.
 *
 * @package WebmasterTijuana
 */
?>
</main>

<footer class="site-footer">
	<div class="container">
		<div class="site-footer__grid">
			<div class="site-footer__brand">
				<a class="logo logo--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php wmt_logo( 'blanco' ); ?></a>
				<p><?php echo esc_html( wmt_opt( 'footer_texto' ) ); ?></p>
				<?php if ( wmt_socials() ) : ?>
					<ul class="social">
						<?php foreach ( wmt_socials() as $key => $red ) : ?>
							<li><a href="<?php echo esc_url( $red['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $red['label'] ); ?>"><?php echo wmt_icon( $key ); // phpcs:ignore ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div>
				<h2 class="site-footer__title"><?php esc_html_e( 'Enlaces rápidos', 'webmaster-tijuana' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'pie',
						'container'      => false,
						'menu_class'     => 'site-footer__links',
						'depth'          => 1,
						'fallback_cb'    => 'wmt_menu_fallback',
					)
				);
				?>
			</div>

			<div>
				<h2 class="site-footer__title"><?php esc_html_e( 'Servicios', 'webmaster-tijuana' ); ?></h2>
				<ul class="site-footer__links">
					<?php
					$servicios = get_posts( array( 'post_type' => 'servicio', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
					foreach ( $servicios as $s ) :
						?>
						<li><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h2 class="site-footer__title"><?php esc_html_e( 'Contacto', 'webmaster-tijuana' ); ?></h2>
				<ul class="site-footer__contact">
					<li><?php echo wmt_icon( 'phone' ); // phpcs:ignore ?><a href="<?php echo esc_url( wmt_tel_href() ); ?>"><?php echo esc_html( wmt_opt( 'telefono' ) ); ?></a></li>
					<li><?php echo wmt_icon( 'mail' ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( wmt_opt( 'email' ) ); ?>"><?php echo esc_html( wmt_opt( 'email' ) ); ?></a></li>
					<li><?php echo wmt_icon( 'pin' ); // phpcs:ignore ?><span><?php echo esc_html( wmt_opt( 'direccion' ) ); ?></span></li>
					<?php if ( wmt_opt( 'horario' ) ) : ?>
						<li><?php echo wmt_icon( 'clock' ); // phpcs:ignore ?><span><?php echo esc_html( wmt_opt( 'horario' ) ); ?></span></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="site-footer__bottom">
			<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos los derechos reservados.', 'webmaster-tijuana' ); ?></p>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'legal',
					'container'      => false,
					'menu_class'     => 'site-footer__legal',
					'depth'          => 1,
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
	</div>
</footer>

<?php if ( wmt_whatsapp_url() ) : ?>
	<a class="wa-float" href="<?php echo esc_url( wmt_whatsapp_url() ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Escríbenos por WhatsApp', 'webmaster-tijuana' ); ?>">
		<?php echo wmt_icon( 'whatsapp' ); // phpcs:ignore ?>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
