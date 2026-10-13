<?php
/**
 * Template Name: Agenda tu cita
 * Description: Página con el formulario de solicitud de cita y los datos de contacto.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
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

	<section class="section">
		<div class="wrap">
			<div class="contact-grid">

				<div data-reveal="left">
					<?php if ( get_the_content() ) : ?>
						<div class="prose"><?php the_content(); ?></div>
					<?php else : ?>
						<p class="eyebrow"><?php esc_html_e( 'Solicitud de cita', 'cardio-canseco' ); ?></p>
						<h2><?php esc_html_e( 'Cuéntenos qué necesita', 'cardio-canseco' ); ?></h2>
						<p class="lead"><?php esc_html_e( 'Complete el formulario y nos pondremos en contacto para confirmar su cita. Si prefiere resolverlo de inmediato, llame o escriba por WhatsApp.', 'cardio-canseco' ); ?></p>
					<?php endif; ?>

					<div class="mt-6"><?php echo do_shortcode( '[cardio_contacto]' ); ?></div>

					<div class="note-box mt-6">
						<strong><?php esc_html_e( 'Urgencias.', 'cardio-canseco' ); ?></strong>
						<?php esc_html_e( 'Este formulario no es un canal de atención urgente. Si presenta dolor de pecho intenso, dificultad respiratoria grave o pérdida del conocimiento, acuda de inmediato a urgencias o llame al 911.', 'cardio-canseco' ); ?>
					</div>
				</div>

				<div data-reveal="right">
					<?php
					cardio_form_notice();
					echo do_shortcode( '[cardio_formulario_cita]' );
					?>
				</div>

			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();
