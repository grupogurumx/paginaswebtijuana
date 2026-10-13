<?php
/**
 * Pie del sitio.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="site-footer footer">
	<div class="wrap">
		<div class="footer__grid">

			<div>
				<a class="footer__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php cardio_logo( 'oscuro', 'brand__logo brand__logo--pie' ); ?>
				</a>
				<p>
					<?php
					$desc = get_bloginfo( 'description' );
					echo esc_html( $desc ? $desc : __( 'Cardiología clínica y ecocardiografía en Tijuana, Baja California. Diagnóstico cardiovascular con criterio médico y equipo especializado.', 'cardio-canseco' ) );
					?>
				</p>

				<div class="social">
					<?php if ( cardio_opt( 'facebook' ) ) : ?>
						<a href="<?php echo esc_url( cardio_opt( 'facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php cardio_icon_e( 'fb' ); ?></a>
					<?php endif; ?>
					<?php if ( cardio_opt( 'instagram' ) ) : ?>
						<a href="<?php echo esc_url( cardio_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php cardio_icon_e( 'ig' ); ?></a>
					<?php endif; ?>
					<?php if ( cardio_opt( 'whatsapp' ) ) : ?>
						<a href="<?php echo esc_url( cardio_wa_url() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?php cardio_icon_e( 'wa' ); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Procedimientos', 'cardio-canseco' ); ?></h4>
				<ul class="footer__list">
					<?php
					$procs = get_posts(
						array(
							'post_type'      => 'procedimiento',
							'posts_per_page' => 6,
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						)
					);
					foreach ( $procs as $proc ) :
						?>
						<li><a href="<?php echo esc_url( get_permalink( $proc ) ); ?>"><?php echo esc_html( get_the_title( $proc ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h4><?php esc_html_e( 'El consultorio', 'cardio-canseco' ); ?></h4>
				<?php
				if ( has_nav_menu( 'pie' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'pie',
							'container'      => false,
							'menu_class'     => 'footer__list',
							'depth'          => 1,
						)
					);
				} else {
					echo '<ul class="footer__list">';
					wp_list_pages( array( 'title_li' => '', 'depth' => 1, 'number' => 6 ) );
					echo '</ul>';
				}
				?>
			</div>

			<div>
				<h4><?php esc_html_e( 'Contacto', 'cardio-canseco' ); ?></h4>
				<ul class="footer__list">
					<li>
						<?php echo esc_html( cardio_opt( 'calle' ) ); ?><br>
						<?php echo esc_html( cardio_opt( 'calle2' ) ); ?><br>
						<?php echo esc_html( cardio_opt( 'cp' ) . ' ' . cardio_opt( 'ciudad' ) . ', ' . cardio_opt( 'estado' ) ); ?>
					</li>
					<li><a href="<?php echo esc_url( cardio_tel_url() ); ?>"><?php cardio_e( 'tel' ); ?></a></li>
					<?php if ( cardio_opt( 'email' ) ) : ?>
						<li><a href="mailto:<?php echo esc_attr( cardio_opt( 'email' ) ); ?>"><?php cardio_e( 'email' ); ?></a></li>
					<?php endif; ?>
					<?php if ( cardio_opt( 'horario' ) ) : ?>
						<li><?php echo esc_html( cardio_opt( 'horario' ) ); ?></li>
					<?php endif; ?>
				</ul>
			</div>

		</div>

		<p class="med-disclaimer">
			<?php esc_html_e( 'La información publicada en este sitio tiene fines informativos y no sustituye la consulta, el diagnóstico ni el tratamiento médico individualizado. Ante una urgencia cardiológica acuda de inmediato al servicio de urgencias más cercano o llame al 911.', 'cardio-canseco' ); ?>
		</p>

		<div class="footer__bottom">
			<p>
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php bloginfo( 'name' ); ?> &middot; <?php cardio_e( 'medico' ); ?>.
				<?php esc_html_e( 'Todos los derechos reservados.', 'cardio-canseco' ); ?>
			</p>
			<?php
			if ( has_nav_menu( 'legal' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'legal',
						'container'      => false,
						'menu_class'     => 'footer__legal',
						'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
						'depth'          => 1,
					)
				);
			}
			?>
		</div>
	</div>
</footer>

<!-- Botón flotante de WhatsApp -->
<?php if ( cardio_opt( 'whatsapp' ) ) : ?>
	<div class="floating">
		<a class="floating__wa" href="<?php echo esc_url( cardio_wa_url() ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Escribir por WhatsApp', 'cardio-canseco' ); ?>">
			<?php cardio_icon_e( 'wa' ); ?>
		</a>
	</div>
<?php endif; ?>

<!-- Barra de acción en móvil -->
<div class="mobile-bar">
	<a class="btn btn--ghost" href="<?php echo esc_url( cardio_tel_url() ); ?>"><?php esc_html_e( 'Llamar', 'cardio-canseco' ); ?></a>
	<a class="btn btn--accent" href="<?php echo esc_url( cardio_cita_url() ); ?>"><?php esc_html_e( 'Agendar cita', 'cardio-canseco' ); ?></a>
</div>

<?php wp_footer(); ?>
</body>
</html>
