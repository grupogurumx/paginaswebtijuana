<?php
/**
 * Banda de llamada a la acción.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cardio_titulo = isset( $args['titulo'] ) ? $args['titulo'] : __( 'El corazón no avisa dos veces', 'cardio-canseco' );
$cardio_texto  = isset( $args['texto'] ) ? $args['texto'] : __( 'Una valoración cardiológica a tiempo cambia el pronóstico. Reserve su cita y salga de la consulta con un diagnóstico claro.', 'cardio-canseco' );
?>

<section class="section section--tight">
	<div class="wrap">
		<div class="cta-band" data-reveal="zoom">
			<div class="cta-band__inner">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Agende hoy', 'cardio-canseco' ); ?></p>
					<h2><?php echo esc_html( $cardio_titulo ); ?></h2>
					<p class="lead"><?php echo esc_html( $cardio_texto ); ?></p>
				</div>
				<div class="cta-band__actions">
					<a class="btn btn--accent btn--lg" href="<?php echo esc_url( cardio_cita_url() ); ?>">
						<?php esc_html_e( 'Agendar mi cita', 'cardio-canseco' ); ?>
					</a>
					<?php if ( cardio_opt( 'whatsapp' ) ) : ?>
						<a class="btn btn--on-dark btn--lg" href="<?php echo esc_url( cardio_wa_url() ); ?>" target="_blank" rel="noopener">
							<?php cardio_icon_e( 'wa' ); ?>
							WhatsApp
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
