<?php
/**
 * Footer.
 *
 * @package hospital-nova
 */
?>
</main>

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div>
				<span class="brand__word">NOVA</span><span class="brand__sub" style="margin-bottom:16px">HOSPITAL</span>
				<p><?php echo esc_html( nova_t( '¡Servicios Médicos de Confianza! Hospital en Tijuana abierto 24/7 con urgencias, quirófano, hospitalización y valoración por especialistas.', 'Trusted Medical Services! A 24/7 hospital in Tijuana with emergency care, surgery, inpatient care and specialist evaluation.' ) ); ?></p>
				<p>
					<a href="<?php echo esc_url( nova_opt( 'facebook' ) ); ?>" target="_blank" rel="noopener">Facebook</a> ·
					<a href="<?php echo esc_url( nova_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener">Instagram @hospital.nova</a>
				</p>
			</div>
			<div>
				<h4><?php echo esc_html( nova_t( 'Especialidades', 'Specialties' ) ); ?></h4>
				<ul>
					<?php foreach ( nova_specialties() as $s ) : ?>
						<li><a href="<?php echo esc_url( add_query_arg( 'esp', $s['key'], nova_page_url( 'contacto', 'contact' ) ) . '#cita' ); ?>"><?php echo esc_html( 'en' === nova_lang() ? $s['en'][0] : $s['es'][0] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div>
				<h4><?php echo esc_html( nova_t( 'Hospital', 'Hospital' ) ); ?></h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => 'nova_fallback_menu',
					'depth'          => 1,
				) );
				?>
			</div>
			<div>
				<h4><?php echo esc_html( nova_t( 'Contacto 24/7', '24/7 Contact' ) ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_attr( nova_tel( nova_opt( 'phone' ) ) ); ?>"><?php echo esc_html( nova_opt( 'phone' ) ); ?></a></li>
					<li><a href="<?php echo esc_url( nova_wa() ); ?>" target="_blank" rel="noopener">WhatsApp <?php echo esc_html( nova_opt( 'whatsapp' ) ); ?></a></li>
					<li><a href="mailto:<?php echo esc_attr( nova_opt( 'email_to' ) ); ?>"><?php echo esc_html( nova_opt( 'email_to' ) ); ?></a></li>
					<li><?php echo esc_html( nova_opt( 'address' ) ); ?></li>
				</ul>
			</div>
		</div>
		<div class="footer-bottom">
			<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> Hospital Nova. <?php echo esc_html( nova_t( 'Todos los derechos reservados.', 'All rights reserved.' ) ); ?></span>
			<span>
				<?php
				$privacy = get_privacy_policy_url();
				if ( $privacy ) {
					printf( '<a href="%s">%s</a>', esc_url( $privacy ), esc_html( nova_t( 'Aviso de privacidad', 'Privacy notice' ) ) );
				}
				?>
			</span>
		</div>
	</div>
</footer>

<a class="wa-float" href="<?php echo esc_url( nova_wa() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp Hospital Nova"><?php echo nova_icon( 'whatsapp' ); ?></a>
<?php wp_footer(); ?>
</body>
</html>
