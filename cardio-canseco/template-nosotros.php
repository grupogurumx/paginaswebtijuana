<?php
/**
 * Template Name: Nosotros (consultorio)
 * Description: Página del consultorio en secciones a todo el ancho: presentación con retrato, misión y visión en tarjetas, forma de trabajo, sociedades médicas y catálogo de estudios. El contenido de la página se muestra en la sección de presentación, de modo que el texto sigue siendo editable.
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
		<div class="page-hero__media" style="background-image:url('<?php echo esc_url( cardio_hero_bg( 'consulta-cita.jpg' ) ); ?>')"></div>
		<div class="wrap">
			<?php cardio_breadcrumb(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- -------------------------------------------------------- presentación -->
	<section class="section">
		<div class="wrap">
			<div class="split">
				<?php if ( $cardio_retrato ) : ?>
					<div class="split__media split__media--retrato" data-reveal="left">
						<?php echo $cardio_retrato; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php else : ?>
					<div class="split__media" data-reveal="left">
						<img src="<?php echo esc_url( CARDIO_URI . '/assets/img/seccion-nosotros.jpg' ); ?>"
							alt="<?php esc_attr_e( 'Consulta de cardiología con atención personalizada en Tijuana', 'cardio-canseco' ); ?>"
							width="1400" height="875" loading="lazy" decoding="async">
					</div>
				<?php endif; ?>

				<div class="prose" data-reveal="right">
					<p class="eyebrow"><?php esc_html_e( 'Quiénes somos', 'cardio-canseco' ); ?></p>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>

	<!-- ------------------------------------------------------ misión y visión -->
	<section class="section section--navy">
		<div class="wrap">
			<div class="section-split" data-reveal>
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Nuestro compromiso', 'cardio-canseco' ); ?></p>
					<h2><?php esc_html_e( 'Misión y visión', 'cardio-canseco' ); ?></h2>
				</div>
				<p class="lead">
					<?php esc_html_e( 'Dos principios que ordenan la práctica diaria del consultorio: conocimiento científico actualizado y atención centrada en el paciente.', 'cardio-canseco' ); ?>
				</p>
			</div>

			<div class="cred-grid" data-reveal-group>
				<div class="cred">
					<span class="cred__label"><?php esc_html_e( 'Misión', 'cardio-canseco' ); ?></span>
					<p class="cred__meta">
						<?php esc_html_e( 'Brindar el mayor conocimiento científico actualizado en el área cardiovascular, enmarcado en principios bioéticos, para optimizar el desempeño de los profesionales de la salud, a los fines de promover la salud cardiovascular en la población.', 'cardio-canseco' ); ?>
					</p>
				</div>
				<div class="cred">
					<span class="cred__label"><?php esc_html_e( 'Visión', 'cardio-canseco' ); ?></span>
					<p class="cred__meta">
						<?php esc_html_e( 'Brindar excelente atención médica, contando siempre con conocimientos científicos consolidados como profesional en el área cardiovascular, líder en la divulgación y aplicación de la información científica actualizada, mediante la participación en el diseño de políticas de salud y en la promoción de programas de educación y líneas de investigación.', 'cardio-canseco' ); ?>
					</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ------------------------------------------------------ cómo trabajamos -->
	<section class="section">
		<div class="wrap">
			<div class="section-head" data-reveal>
				<p class="eyebrow"><?php esc_html_e( 'Cómo trabajamos', 'cardio-canseco' ); ?></p>
				<h2><?php esc_html_e( 'Cuatro compromisos con cada paciente', 'cardio-canseco' ); ?></h2>
			</div>

			<div class="steps" data-reveal-group>
				<div class="step">
					<h3><?php esc_html_e( 'El especialista realiza el estudio', 'cardio-canseco' ); ?></h3>
					<p><?php esc_html_e( 'La imagen la obtiene quien la va a interpretar. Eso elimina la pérdida de información entre quien opera el equipo y quien lee el resultado.', 'cardio-canseco' ); ?></p>
				</div>
				<div class="step">
					<h3><?php esc_html_e( 'Tiempo suficiente de consulta', 'cardio-canseco' ); ?></h3>
					<p><?php esc_html_e( 'Una valoración cardiológica requiere escuchar la historia completa. No trabajamos con agendas que obliguen a acortarla.', 'cardio-canseco' ); ?></p>
				</div>
				<div class="step">
					<h3><?php esc_html_e( 'Explicación en lenguaje claro', 'cardio-canseco' ); ?></h3>
					<p><?php esc_html_e( 'Usted sale entendiendo qué se encontró, qué significa y qué sigue. Sin tecnicismos que no aporten.', 'cardio-canseco' ); ?></p>
				</div>
				<div class="step">
					<h3><?php esc_html_e( 'Sólo los estudios necesarios', 'cardio-canseco' ); ?></h3>
					<p><?php esc_html_e( 'Se indica lo que cambia una decisión clínica. Ni un estudio de más ni uno de menos.', 'cardio-canseco' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- ------------------------------------------------------------ sociedades -->
	<section class="section section--alt">
		<div class="wrap">
			<div class="section-split" data-reveal>
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Respaldo profesional', 'cardio-canseco' ); ?></p>
					<h2><?php esc_html_e( 'Sociedades y certificación', 'cardio-canseco' ); ?></h2>
				</div>
				<p class="lead">
					<?php esc_html_e( 'El consultorio se apoya en la membresía activa de sus sociedades médicas y en la certificación del Consejo Mexicano de Cardiología.', 'cardio-canseco' ); ?>
				</p>
			</div>

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
		<section class="section">
			<div class="wrap">
				<div class="section-split" data-reveal>
					<div>
						<p class="eyebrow"><?php esc_html_e( 'En consulta', 'cardio-canseco' ); ?></p>
						<h2><?php esc_html_e( 'Estudios que realizamos', 'cardio-canseco' ); ?></h2>
					</div>
					<p class="lead">
						<?php esc_html_e( 'Ocho estudios del corazón, todos realizados e interpretados en el mismo consultorio dentro del Centro Hospitalario MAC.', 'cardio-canseco' ); ?>
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
