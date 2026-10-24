<?php defined( 'ABSPATH' ) || exit; ?>
</main>

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div>
				<a class="brand" href="<?php echo esc_url( dmc_home_url() ); ?>">
					<?php echo dmc_logo_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					<span class="brand__text"><span class="brand__name">Dr. Mario Camelo</span><span class="brand__tag">#SuperDrSleeve</span></span>
				</a>
				<p style="margin-top:20px"><?php echo esc_html( dmc_t( 'footer_about' ) ); ?></p>
				<div class="socials">
					<?php
					$socials = array( 'dmc_facebook' => 'f', 'dmc_instagram' => 'IG', 'dmc_youtube' => 'YT', 'dmc_tiktok' => 'TT' );
					foreach ( $socials as $key => $label ) {
						$url = dmc_opt( $key );
						if ( $url ) {
							printf( '<a href="%s" target="_blank" rel="noopener" aria-label="%s">%s</a>', esc_url( $url ), esc_attr( ucfirst( str_replace( 'dmc_', '', $key ) ) ), esc_html( $label ) );
						}
					}
					?>
				</div>
			</div>
			<div>
				<h4><?php echo esc_html( dmc_t( 'nav_procedures' ) ); ?></h4>
				<ul>
					<?php foreach ( array( 'sleeve', 'bypass', 'revision', 'metabolic' ) as $k ) : ?>
						<li><a href="<?php echo esc_url( dmc_page_url( $k ) ); ?>"><?php echo esc_html( dmc_t( 'nav_' . $k ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div>
				<h4><?php echo esc_html( dmc_t( 'footer_pages' ) ); ?></h4>
				<?php dmc_nav( 'footer' ); ?>
			</div>
			<div>
				<h4><?php echo esc_html( dmc_t( 'footer_visit' ) ); ?></h4>
				<p>
					<?php echo esc_html( dmc_opt( 'dmc_address' ) ); ?><br>
					<?php echo esc_html( dmc_opt( 'dmc_city' ) . ', ' . dmc_opt( 'dmc_region' ) . ' ' . dmc_opt( 'dmc_zip' ) ); ?><br>
					<?php echo esc_html( dmc_t( 'footer_hours' ) ); ?>
				</p>
				<?php if ( dmc_opt( 'dmc_phone' ) ) : ?>
					<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', dmc_opt( 'dmc_phone' ) ) ); ?>" data-track="call_click"><?php echo esc_html( dmc_opt( 'dmc_phone' ) ); ?></a></p>
				<?php endif; ?>
				<?php if ( dmc_opt( 'dmc_email' ) ) : ?>
					<p><a href="mailto:<?php echo esc_attr( dmc_opt( 'dmc_email' ) ); ?>"><?php echo esc_html( dmc_opt( 'dmc_email' ) ); ?></a></p>
				<?php endif; ?>
				<a class="btn btn--gold" href="<?php echo esc_url( dmc_page_url( 'financing' ) ); ?>"><?php echo esc_html( dmc_t( 'cta_financing' ) ); ?></a>
			</div>
		</div>
		<p class="disclaimer" style="color:#7f8fb5;border-color:rgba(255,255,255,.08)"><?php echo esc_html( dmc_t( 'disclaimer' ) ); ?></p>
		<div class="footer-bottom">
			<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Dr. Mario Camelo. <?php echo esc_html( dmc_t( 'rights' ) ); ?></span>
			<a href="<?php echo esc_url( dmc_page_url( 'privacy' ) ); ?>"><?php echo esc_html( dmc_t( 'nav_privacy' ) ); ?></a>
		</div>
	</div>
</footer>

<?php $wa = dmc_whatsapp_url( dmc_t( 'cta_schedule' ) ); ?>
<?php if ( $wa ) : ?>
<div class="float-cta">
	<a class="wa" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( dmc_t( 'cta_whatsapp' ) ); ?>" data-track="whatsapp_click">
		<svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8c1.9 1 4 1.6 6.2 1.6 7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.6c-2 0-3.9-.5-5.6-1.5l-.4-.2-4 1.1 1.1-3.9-.3-.4C5.8 20 5.2 18 5.2 16 5.2 10 10 5.2 16 5.2S26.8 10 26.8 16 22 26.6 16 26.6zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-1 1.2-.2.2-.4.2-.7.1-.3-.2-1.4-.5-2.6-1.6-1-.9-1.6-1.9-1.8-2.2-.2-.3 0-.5.1-.7l.5-.6c.2-.2.2-.3.3-.6.1-.2 0-.4 0-.6l-1-2.4c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.6c.2.2 2.4 3.6 5.7 5 .8.3 1.4.5 1.9.7.8.3 1.5.2 2.1.1.6-.1 1.9-.8 2.2-1.5.3-.8.3-1.4.2-1.5-.1-.2-.3-.3-.6-.4z"/></svg>
	</a>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
