<?php
/**
 * Template Name: Página ancha (sin barra lateral)
 * Description: Para páginas de presentación como «Nosotros» o la del médico. El contenido ocupa todo el ancho: los párrafos conservan una medida de lectura cómoda y las rejillas de tarjetas y logotipos se extienden de lado a lado.
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

	<?php
	// Retrato del especialista junto a la entradilla, si hay foto disponible.
	$cardio_retrato = cardio_foto_medico( 'retrato' );
	if ( $cardio_retrato ) :
		?>
		<section class="section">
			<div class="wrap">
				<div class="split">
					<div class="split__media split__media--retrato" data-reveal="left">
						<?php echo $cardio_retrato; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div data-reveal="right">
						<p class="eyebrow"><?php esc_html_e( 'El especialista', 'cardio-canseco' ); ?></p>
						<h2><?php cardio_e( 'medico' ); ?></h2>
						<p class="lead">
							<?php esc_html_e( 'Médico cardiólogo con amplia experiencia en el cuidado del corazón. Realiza personalmente cada estudio y lo interpreta él mismo: la imagen la obtiene quien la va a leer.', 'cardio-canseco' ); ?>
						</p>

						<div class="stats mt-6">
							<div class="stat">
								<span class="stat__num" data-count="<?php echo esc_attr( cardio_opt( 'anios' ) ); ?>" data-suffix="+"><?php cardio_e( 'anios' ); ?>+</span>
								<span class="stat__label"><?php esc_html_e( 'Años de práctica', 'cardio-canseco' ); ?></span>
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
	<?php endif; ?>

	<section class="section<?php echo $cardio_retrato ? ' section--alt' : ''; ?>">
		<div class="wrap">
			<div class="prose prose-wide" data-reveal>
				<?php
				cardio_form_notice();
				the_content();

				wp_link_pages(
					array(
						'before' => '<nav class="mt-6">' . esc_html__( 'Páginas:', 'cardio-canseco' ) . ' ',
						'after'  => '</nav>',
					)
				);
				?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/cta' ); ?>

	<?php
endwhile;

get_footer();
