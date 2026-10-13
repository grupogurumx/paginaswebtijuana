<?php
/**
 * Portada del sitio.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php get_template_part( 'template-parts/hero' ); ?>

<!-- Avales -->
<section class="trust">
	<div class="wrap trust__inner">
		<p class="trust__label"><?php esc_html_e( 'Respaldo profesional', 'cardio-canseco' ); ?></p>
		<div class="trust__logos">
			<?php
			$cardio_avales = array(
				'aval-consejomexicanocardiologia.png' => 'Consejo Mexicano de Cardiología',
				'aval-cardiologosdemexico.png'        => 'Asociación Nacional de Cardiólogos de México',
				'aval-scbc.png'                       => 'Sociedad de Cardiología de Baja California',
				'aval-esc.png'                        => 'European Society of Cardiology',
			);
			foreach ( $cardio_avales as $file => $alt ) {
				printf(
					'<img src="%s" alt="%s" width="400" height="250" loading="lazy" decoding="async">',
					esc_url( CARDIO_URI . '/assets/img/' . $file ),
					esc_attr( $alt )
				);
			}
			?>
		</div>
	</div>
</section>

<!-- Por qué elegirnos -->
<section class="section" id="por-que">
	<div class="wrap">
		<?php
		$cardio_busto = cardio_foto_medico( 'busto' );
		?>
		<div class="split">
			<div class="split__media<?php echo $cardio_busto ? ' split__media--busto' : ''; ?>" data-reveal="left">
				<?php
				if ( $cardio_busto ) {
					echo $cardio_busto; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					printf(
						'<img src="%s" alt="%s" width="1400" height="875" loading="lazy" decoding="async">',
						esc_url( CARDIO_URI . '/assets/img/seccion-porque.jpg' ),
						esc_attr__( 'Cardióloga explicando el funcionamiento del corazón sobre los resultados de un estudio', 'cardio-canseco' )
					);
				}
				?>
				<div class="float-card">
					<span class="float-card__icon" aria-hidden="true"><?php cardio_icon_e( 'heart' ); ?></span>
					<span>
						<span class="float-card__num" data-count="<?php echo esc_attr( cardio_opt( 'anios' ) ); ?>" data-suffix="+"><?php cardio_e( 'anios' ); ?>+</span>
						<span class="float-card__label">
							<?php
							printf(
								/* translators: %s: nombre del médico. */
								esc_html__( 'años del %s cuidando corazones en Tijuana', 'cardio-canseco' ),
								'<strong>' . esc_html( cardio_opt( 'medico' ) ) . '</strong>'
							);
							?>
						</span>
					</span>
				</div>
			</div>

			<div data-reveal="right">
				<p class="eyebrow"><?php esc_html_e( 'Por qué elegirnos', 'cardio-canseco' ); ?></p>
				<h2><?php esc_html_e( 'Cardiología clínica con criterio, no sólo con aparatos', 'cardio-canseco' ); ?></h2>

				<p class="firma-medico">
					<span class="firma-medico__nombre"><?php cardio_e( 'medico' ); ?></span>
					<span class="firma-medico__cargo"><?php esc_html_e( 'Médico cardiólogo · Cédula de especialidad 5907060', 'cardio-canseco' ); ?></span>
				</p>
				<p class="lead">
					<?php esc_html_e( 'Un estudio bien hecho vale por la lectura que lo acompaña. Cada ecocardiograma, Holter o prueba de esfuerzo lo realiza e interpreta directamente el Dr. Canseco, certificado en ecocardiografía clínica por el Instituto Nacional de Ciencias Médicas y Nutrición Salvador Zubirán.', 'cardio-canseco' ); ?>
				</p>
				<ul class="check-list mt-5">
					<li><strong><?php esc_html_e( 'Todo en una sola visita.', 'cardio-canseco' ); ?></strong> <?php esc_html_e( 'Consulta, estudio e interpretación sin enviarlo a otro laboratorio.', 'cardio-canseco' ); ?></li>
					<li><strong><?php esc_html_e( 'El especialista realiza el estudio.', 'cardio-canseco' ); ?></strong> <?php esc_html_e( 'No lo delega en un técnico; la imagen la obtiene quien la va a leer.', 'cardio-canseco' ); ?></li>
					<li><strong><?php esc_html_e( 'Dentro del Centro Hospitalario MAC.', 'cardio-canseco' ); ?></strong> <?php esc_html_e( 'Respaldo hospitalario si el caso requiere estudios adicionales.', 'cardio-canseco' ); ?></li>
					<li><strong><?php esc_html_e( 'Explicación en lenguaje claro.', 'cardio-canseco' ); ?></strong> <?php esc_html_e( 'Usted sale de la consulta entendiendo qué tiene y qué sigue.', 'cardio-canseco' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- Línea de ECG animada -->
<div class="wrap" aria-hidden="true">
	<svg class="ecg-divider" viewBox="0 0 1200 60" preserveAspectRatio="none" role="presentation">
		<path d="M0,30 L280,30 L300,30 L312,10 L326,50 L340,18 L352,38 L364,30 L520,30 L534,30 L546,4 L560,56 L574,14 L586,40 L598,30 L840,30 L854,30 L866,12 L880,48 L894,20 L906,36 L918,30 L1200,30"/>
	</svg>
</div>

<!-- Procedimientos -->
<?php
$cardio_procs = new WP_Query(
	array(
		'post_type'      => 'procedimiento',
		'posts_per_page' => 8,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

if ( $cardio_procs->have_posts() ) :
	?>
	<section class="section section--alt" id="procedimientos">
		<div class="wrap">
			<div class="section-head section-head--center" data-reveal>
				<p class="eyebrow"><?php esc_html_e( 'Estudios del corazón', 'cardio-canseco' ); ?></p>
				<h2><?php esc_html_e( 'Procedimientos cardiovasculares en Tijuana', 'cardio-canseco' ); ?></h2>
				<p class="lead">
					<?php esc_html_e( 'Del electrocardiograma de rutina al ecocardiograma Doppler color. Cada estudio está indicado para una pregunta clínica distinta; en la consulta definimos cuál necesita usted.', 'cardio-canseco' ); ?>
				</p>
			</div>

			<div class="proc-grid" data-reveal-group>
				<?php
				$cardio_i = 0;
				while ( $cardio_procs->have_posts() ) :
					$cardio_procs->the_post();
					get_template_part( 'template-parts/proc-card', null, array( 'feature' => ( 0 === $cardio_i ) ) );
					$cardio_i++;
				endwhile;
				?>
			</div>
		</div>
	</section>
	<?php
	wp_reset_postdata();
endif;
?>

<!-- El especialista -->
<section class="section section--navy" id="especialista">
	<div class="wrap">
		<?php
		$cardio_retrato = cardio_foto_medico( 'retrato' );
		?>
		<div class="split split--reverse">
			<div class="split__media<?php echo $cardio_retrato ? ' split__media--retrato' : ''; ?>" data-reveal="right">
				<?php
				if ( $cardio_retrato ) {
					echo $cardio_retrato; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					printf(
						'<img src="%s" alt="%s" width="1400" height="875" loading="lazy" decoding="async">',
						esc_url( CARDIO_URI . '/assets/img/seccion-especialista.jpg' ),
						esc_attr( sprintf( __( '%s, cardiólogo en Tijuana, durante una valoración clínica', 'cardio-canseco' ), cardio_opt( 'medico' ) ) )
					);
				}
				?>
			</div>

			<div data-reveal="left">
				<p class="eyebrow"><?php esc_html_e( 'El especialista', 'cardio-canseco' ); ?></p>
				<h2><?php cardio_e( 'medico' ); ?></h2>
				<p class="lead">
					<?php esc_html_e( 'Médico cardiólogo con amplia experiencia en el cuidado del corazón. Su enfoque se centra en ofrecer la mejor atención clínica y un servicio de calidad, basado en su profundo conocimiento y dedicación para su salud cardiovascular.', 'cardio-canseco' ); ?>
				</p>

				<div class="stats mt-6">
					<div class="stat">
						<span class="stat__num" data-count="<?php echo esc_attr( cardio_opt( 'anios' ) ); ?>" data-suffix="+"><?php cardio_e( 'anios' ); ?>+</span>
						<span class="stat__label"><?php esc_html_e( 'Años de práctica cardiológica', 'cardio-canseco' ); ?></span>
					</div>
					<div class="stat">
						<span class="stat__num" data-count="2">2</span>
						<span class="stat__label"><?php esc_html_e( 'Cédulas profesionales registradas', 'cardio-canseco' ); ?></span>
					</div>
					<div class="stat">
						<span class="stat__num" data-count="2">2</span>
						<span class="stat__label"><?php esc_html_e( 'Sociedades de cardiología', 'cardio-canseco' ); ?></span>
					</div>
				</div>

				<ul class="check-list mt-6">
					<li><?php esc_html_e( 'Médico Cirujano — Universidad Mayor Real y Pontificia de San Francisco Xavier (cédula 5357508)', 'cardio-canseco' ); ?></li>
					<li><?php esc_html_e( 'Especialidad en Cardiología Clínica — Universidad Nacional Autónoma de México (cédula 5907060)', 'cardio-canseco' ); ?></li>
					<li><?php esc_html_e( 'Certificación en Ecocardiografía Clínica — INCMN Salvador Zubirán, 2008', 'cardio-canseco' ); ?></li>
					<li><?php esc_html_e( 'Miembro de ANCAM y de la Sociedad de Cardiología de Baja California', 'cardio-canseco' ); ?></li>
				</ul>

				<?php
				$cardio_pagina_medico = get_page_by_path( 'dr-eduardo-canseco' );
				if ( $cardio_pagina_medico ) :
					?>
					<p class="mt-6">
						<a class="btn btn--on-dark" href="<?php echo esc_url( get_permalink( $cardio_pagina_medico ) ); ?>">
							<?php esc_html_e( 'Ver trayectoria completa', 'cardio-canseco' ); ?>
						</a>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Cómo funciona -->
<section class="section">
	<div class="wrap">
		<div class="section-head" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Cómo funciona', 'cardio-canseco' ); ?></p>
			<h2><?php esc_html_e( 'De la llamada al diagnóstico, en cuatro pasos', 'cardio-canseco' ); ?></h2>
		</div>

		<div class="steps" data-reveal-group>
			<div class="step">
				<h3><?php esc_html_e( 'Agenda su cita', 'cardio-canseco' ); ?></h3>
				<p><?php esc_html_e( 'Por teléfono, WhatsApp o el formulario del sitio. Le confirmamos horario y le decimos si el estudio requiere alguna preparación.', 'cardio-canseco' ); ?></p>
			</div>
			<div class="step">
				<h3><?php esc_html_e( 'Consulta y valoración', 'cardio-canseco' ); ?></h3>
				<p><?php esc_html_e( 'Historia clínica, exploración y revisión de estudios previos. Aquí se define qué estudio aporta la respuesta que su caso necesita.', 'cardio-canseco' ); ?></p>
			</div>
			<div class="step">
				<h3><?php esc_html_e( 'Estudio en el consultorio', 'cardio-canseco' ); ?></h3>
				<p><?php esc_html_e( 'El especialista realiza personalmente el ecocardiograma, el ECG, la prueba de esfuerzo o coloca el Holter o el MAPA.', 'cardio-canseco' ); ?></p>
			</div>
			<div class="step">
				<h3><?php esc_html_e( 'Resultado explicado', 'cardio-canseco' ); ?></h3>
				<p><?php esc_html_e( 'Recibe la interpretación y el plan a seguir en lenguaje claro, junto con su reporte impreso o digital.', 'cardio-canseco' ); ?></p>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/ubicacion' ); ?>

<?php get_template_part( 'template-parts/cta' ); ?>

<?php
get_footer();
