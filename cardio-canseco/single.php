<?php
/**
 * Entrada individual del blog.
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
		<div class="page-hero__media" style="background-image:url('<?php echo esc_url( cardio_hero_bg( 'hero-ecg.jpg' ) ); ?>')"></div>
		<div class="wrap">
			<?php cardio_breadcrumb(); ?>
			<h1><?php the_title(); ?></h1>
			<p class="lead">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</p>
		</div>
	</section>

	<section class="section">
		<div class="wrap wrap--narrow prose" data-reveal>
			<?php the_content(); ?>

			<div class="note-box mt-7">
				<?php esc_html_e( 'Este contenido es informativo y no sustituye la valoración médica individual. Consulte a su cardiólogo antes de tomar decisiones sobre su tratamiento.', 'cardio-canseco' ); ?>
			</div>

			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="pill">' . esc_html__( 'Anterior', 'cardio-canseco' ) . '</span> %title',
					'next_text' => '<span class="pill">' . esc_html__( 'Siguiente', 'cardio-canseco' ) . '</span> %title',
					'class'     => 'mt-7',
				)
			);

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/cta' ); ?>

	<?php
endwhile;

get_footer();
