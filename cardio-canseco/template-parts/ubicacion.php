<?php
/**
 * Bloque de ubicación con mapa y datos de contacto.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section section--alt" id="ubicacion">
	<div class="wrap">
		<div class="contact-grid">

			<div data-reveal="left">
				<p class="eyebrow"><?php esc_html_e( 'Dónde estamos', 'cardio-canseco' ); ?></p>
				<h2><?php esc_html_e( 'Dentro del Centro Hospitalario MAC, Alamar', 'cardio-canseco' ); ?></h2>
				<p class="lead">
					<?php esc_html_e( 'El consultorio se encuentra en Plaza Península, sobre el Blvd. Vía Rápida Oriente, con acceso directo desde la Vía Rápida y estacionamiento del complejo hospitalario. Atendemos pacientes de todo Tijuana, Rosarito, Tecate y del área de San Diego.', 'cardio-canseco' ); ?>
				</p>

				<ul class="info-list mt-6">
					<li>
						<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'pin' ); ?></span>
						<span>
							<span class="info-list__label"><?php esc_html_e( 'Dirección', 'cardio-canseco' ); ?></span>
							<span class="info-list__value">
								<?php echo esc_html( cardio_opt( 'calle' ) ); ?><br>
								<?php echo esc_html( cardio_opt( 'calle2' ) ); ?><br>
								<?php echo esc_html( cardio_opt( 'cp' ) . ' ' . cardio_opt( 'ciudad' ) . ', ' . cardio_opt( 'estado' ) ); ?>
							</span>
						</span>
					</li>
					<li>
						<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'phone' ); ?></span>
						<span>
							<span class="info-list__label"><?php esc_html_e( 'Teléfono y WhatsApp', 'cardio-canseco' ); ?></span>
							<span class="info-list__value">
								<a href="<?php echo esc_url( cardio_tel_url() ); ?>"><?php cardio_e( 'tel' ); ?></a>
								<?php if ( cardio_opt( 'whatsapp' ) ) : ?>
									<br><a href="<?php echo esc_url( cardio_wa_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Escribir por WhatsApp', 'cardio-canseco' ); ?></a>
								<?php endif; ?>
							</span>
						</span>
					</li>
					<?php if ( cardio_opt( 'email' ) ) : ?>
						<li>
							<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'mail' ); ?></span>
							<span>
								<span class="info-list__label"><?php esc_html_e( 'Correo', 'cardio-canseco' ); ?></span>
								<span class="info-list__value"><a href="mailto:<?php echo esc_attr( cardio_opt( 'email' ) ); ?>"><?php cardio_e( 'email' ); ?></a></span>
							</span>
						</li>
					<?php endif; ?>
					<?php if ( cardio_opt( 'horario' ) ) : ?>
						<li>
							<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'clock' ); ?></span>
							<span>
								<span class="info-list__label"><?php esc_html_e( 'Atención', 'cardio-canseco' ); ?></span>
								<span class="info-list__value"><?php echo esc_html( cardio_opt( 'horario' ) ); ?></span>
							</span>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			<div data-reveal="right">
				<div class="map-embed">
					<iframe
						title="<?php esc_attr_e( 'Ubicación del consultorio en Google Maps', 'cardio-canseco' ); ?>"
						src="<?php echo esc_url( cardio_maps_embed() ); ?>"
						loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
				</div>
				<p class="mt-5">
					<a class="btn btn--ghost btn--block" href="<?php echo esc_url( cardio_maps_url() ); ?>" target="_blank" rel="noopener">
						<?php esc_html_e( 'Cómo llegar', 'cardio-canseco' ); ?>
						<?php cardio_icon_e( 'ext' ); ?>
					</a>
				</p>
			</div>

		</div>
	</div>
</section>
