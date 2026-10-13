<?php
/**
 * Template Name: Contacto
 * Description: Página de contacto con datos, mapa y accesos directos.
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
		<div class="page-hero__media" style="background-image:url('<?php echo esc_url( cardio_hero_bg() ); ?>')"></div>
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
					<p class="eyebrow"><?php esc_html_e( 'Datos de contacto', 'cardio-canseco' ); ?></p>
					<h2><?php esc_html_e( 'Cómo comunicarse con nosotros', 'cardio-canseco' ); ?></h2>

					<div class="mt-6"><?php echo do_shortcode( '[cardio_contacto]' ); ?></div>

					<div class="social mt-6">
						<?php if ( cardio_opt( 'facebook' ) ) : ?>
							<a href="<?php echo esc_url( cardio_opt( 'facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook" style="background:var(--blue-050);color:var(--blue-600)"><?php cardio_icon_e( 'fb' ); ?></a>
						<?php endif; ?>
						<?php if ( cardio_opt( 'instagram' ) ) : ?>
							<a href="<?php echo esc_url( cardio_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram" style="background:var(--blue-050);color:var(--blue-600)"><?php cardio_icon_e( 'ig' ); ?></a>
						<?php endif; ?>
					</div>

					<?php if ( get_the_content() ) : ?>
						<div class="prose mt-6"><?php the_content(); ?></div>
					<?php endif; ?>

					<p class="mt-6">
						<a class="btn btn--accent" href="<?php echo esc_url( cardio_cita_url() ); ?>"><?php esc_html_e( 'Agendar una cita', 'cardio-canseco' ); ?></a>
					</p>
				</div>

				<div data-reveal="right">
					<?php echo do_shortcode( '[cardio_mapa]' ); ?>

					<div class="note-box mt-6">
						<strong><?php esc_html_e( '¿Viene desde San Diego?', 'cardio-canseco' ); ?></strong>
						<?php esc_html_e( 'El consultorio está sobre la Vía Rápida, a pocos minutos de las garitas de San Ysidro y Otay, dentro del complejo del Centro Hospitalario MAC, con estacionamiento en el mismo lugar.', 'cardio-canseco' ); ?>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/cta' ); ?>

	<?php
endwhile;

get_footer();
