<?php
/**
 * Template Name: Dr. Eduardo Canseco (perfil del médico)
 * Description: Perfil del especialista en secciones a todo el ancho: retrato con cifras, formación académica, credenciales verificables, trayectoria, membresías y estudios. El contenido de la página se muestra en la sección «Trayectoria profesional», de modo que el texto sigue siendo editable.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$cardio_retrato = cardio_foto_medico( 'retrato' );
	?>

	<section class="page-hero">
		<div class="page-hero__media" style="background-image:url('<?php echo esc_url( cardio_hero_bg() ); ?>')"></div>
		<div class="wrap">
			<?php cardio_breadcrumb(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- ------------------------------------------------------------ retrato -->
	<section class="section">
		<div class="wrap">
			<div class="split">
				<?php if ( $cardio_retrato ) : ?>
					<div class="split__media split__media--retrato" data-reveal="left">
						<?php echo $cardio_retrato; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php else : ?>
					<div class="split__media" data-reveal="left">
						<img src="<?php echo esc_url( CARDIO_URI . '/assets/img/consulta-cita.jpg' ); ?>"
							alt="<?php esc_attr_e( 'Valoración clínica cardiológica en el consultorio', 'cardio-canseco' ); ?>"
							width="1400" height="875" loading="lazy" decoding="async">
					</div>
				<?php endif; ?>

				<div data-reveal="right">
					<p class="eyebrow"><?php esc_html_e( 'El especialista', 'cardio-canseco' ); ?></p>
					<h2><?php esc_html_e( 'Un cardiólogo que hace y lee sus propios estudios', 'cardio-canseco' ); ?></h2>
					<p class="lead">
						<?php
						echo esc_html( sprintf(
							/* translators: %s: nombre del médico. */
							__( 'El %s es médico cardiólogo con más de 10 años de experiencia en el cuidado del corazón. Realiza personalmente cada ecocardiograma, Holter y prueba de esfuerzo, y los interpreta él mismo: la imagen la obtiene quien la va a leer.', 'cardio-canseco' ),
							cardio_opt( 'medico' )
						) );
						?>
					</p>
					<p>
						<?php esc_html_e( 'Su práctica combina la cardiología clínica con la ecocardiografía, certificada en el Instituto Nacional de Ciencias Médicas y Nutrición Salvador Zubirán, uno de los institutos nacionales de salud de referencia en México.', 'cardio-canseco' ); ?>
					</p>

					<div class="stats mt-6">
						<div class="stat">
							<span class="stat__num" data-count="<?php echo esc_attr( cardio_opt( 'anios' ) ); ?>" data-suffix="+"><?php cardio_e( 'anios' ); ?>+</span>
							<span class="stat__label"><?php esc_html_e( 'Años de práctica cardiológica', 'cardio-canseco' ); ?></span>
						</div>
						<div class="stat">
							<span class="stat__num" data-count="<?php echo esc_attr( cardio_opt( 'estudios' ) ); ?>"><?php cardio_e( 'estudios' ); ?></span>
							<span class="stat__label"><?php esc_html_e( 'Estudios del corazón', 'cardio-canseco' ); ?></span>
						</div>
						<div class="stat">
							<span class="stat__num" data-count="2">2</span>
							<span class="stat__label"><?php esc_html_e( 'Cédulas profesionales', 'cardio-canseco' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ------------------------------------------------- formación académica -->
	<section class="section section--alt">
		<div class="wrap">
			<div class="section-split" data-reveal>
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Trayectoria', 'cardio-canseco' ); ?></p>
					<h2><?php esc_html_e( 'Formación académica', 'cardio-canseco' ); ?></h2>
				</div>
				<p class="lead">
					<?php esc_html_e( 'Tres instituciones respaldan su ejercicio: la universidad donde se tituló como médico cirujano, la UNAM donde concluyó la especialidad en cardiología clínica y el instituto nacional donde obtuvo la certificación en ecocardiografía.', 'cardio-canseco' ); ?>
				</p>
			</div>

			<div data-reveal-group>
				<?php echo cardio_instituciones( 'formacion' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>

	<!-- ---------------------------------------------------------- credenciales -->
	<section class="section section--navy">
		<div class="wrap">
			<div class="section-split" data-reveal>
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Verificable', 'cardio-canseco' ); ?></p>
					<h2><?php esc_html_e( 'Credenciales profesionales', 'cardio-canseco' ); ?></h2>
				</div>
				<p class="lead">
					<?php esc_html_e( 'Ambas cédulas están registradas ante la Dirección General de Profesiones y pueden consultarse en el Registro Nacional de Profesionistas.', 'cardio-canseco' ); ?>
				</p>
			</div>

			<div class="cred-grid" data-reveal-group>
				<?php
				$cardio_credenciales = array(
					array( 'shield', __( 'Cédula 5357508', 'cardio-canseco' ), __( 'Médico Cirujano', 'cardio-canseco' ), __( 'Universidad Mayor Real y Pontificia de San Francisco Xavier · 2007', 'cardio-canseco' ) ),
					array( 'shield', __( 'Cédula 5907060', 'cardio-canseco' ), __( 'Especialidad en Cardiología Clínica', 'cardio-canseco' ), __( 'Universidad Nacional Autónoma de México · 2009', 'cardio-canseco' ) ),
					array( 'heart', __( 'Certificación 2008', 'cardio-canseco' ), __( 'Ecocardiografía Clínica', 'cardio-canseco' ), __( 'Instituto Nacional de Ciencias Médicas y Nutrición Salvador Zubirán', 'cardio-canseco' ) ),
				);
				foreach ( $cardio_credenciales as $cardio_c ) :
					?>
					<div class="cred">
						<span class="cred__icon" aria-hidden="true"><?php cardio_icon_e( $cardio_c[0] ); ?></span>
						<span class="cred__label"><?php echo esc_html( $cardio_c[1] ); ?></span>
						<h3 class="cred__title"><?php echo esc_html( $cardio_c[2] ); ?></h3>
						<p class="cred__meta"><?php echo esc_html( $cardio_c[3] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ------------------------------------------- trayectoria y membresías -->
	<section class="section">
		<div class="wrap">
			<div class="section-split" data-reveal>
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Experiencia', 'cardio-canseco' ); ?></p>
					<h2><?php esc_html_e( 'Trayectoria profesional', 'cardio-canseco' ); ?></h2>
				</div>
				<p class="lead">
					<?php esc_html_e( 'Más de una década ejerciendo entre el sector público, el hospital privado y la consulta propia en Tijuana.', 'cardio-canseco' ); ?>
				</p>
			</div>

			<?php // El contenido de la página se edita en el escritorio y aparece aquí. ?>
			<div class="cols-2" data-reveal>
				<?php the_content(); ?>
			</div>

			<h2 class="mt-7" data-reveal><?php esc_html_e( 'Membresías y certificación', 'cardio-canseco' ); ?></h2>
			<div data-reveal-group>
				<?php echo cardio_instituciones( 'sociedades' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>

	<!-- -------------------------------------------------------------- estudios -->
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
		<section class="section section--alt">
			<div class="wrap">
				<div class="section-split" data-reveal>
					<div>
						<p class="eyebrow"><?php esc_html_e( 'En consulta', 'cardio-canseco' ); ?></p>
						<h2><?php esc_html_e( 'Estudios que realiza', 'cardio-canseco' ); ?></h2>
					</div>
					<p class="lead">
						<?php esc_html_e( 'Los ocho estudios se hacen e interpretan en el mismo consultorio, sin enviarle a otro laboratorio.', 'cardio-canseco' ); ?>
					</p>
				</div>

				<div class="proc-grid" data-reveal-group>
					<?php
					while ( $cardio_procs->have_posts() ) :
						$cardio_procs->the_post();
						get_template_part( 'template-parts/proc-card' );
					endwhile;
					?>
				</div>
			</div>
		</section>
		<?php
		wp_reset_postdata();
	endif;
	?>

	<?php get_template_part( 'template-parts/cta' ); ?>

	<?php
endwhile;

get_footer();
