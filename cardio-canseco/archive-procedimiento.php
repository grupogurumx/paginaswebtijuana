<?php
/**
 * Listado de procedimientos.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="page-hero">
	<div class="page-hero__media" style="background-image:url('<?php echo esc_url( CARDIO_URI . '/assets/img/proc-ecocardiograma.jpg' ); ?>')"></div>
	<div class="wrap">
		<?php cardio_breadcrumb(); ?>
		<h1><?php esc_html_e( 'Procedimientos cardiológicos', 'cardio-canseco' ); ?></h1>
		<p class="lead">
			<?php echo esc_html( sprintf( __( 'Estudios del corazón realizados e interpretados por %s, en un solo consultorio dentro del Centro Hospitalario MAC.', 'cardio-canseco' ), cardio_opt( 'medico' ) ) ); ?>
		</p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section-head" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Catálogo de estudios', 'cardio-canseco' ); ?></p>
			<h2><?php esc_html_e( 'Cada estudio responde a una pregunta distinta', 'cardio-canseco' ); ?></h2>
			<p class="lead">
				<?php esc_html_e( 'No se trata de hacerse todos los estudios, sino el que corresponde. En la consulta definimos cuál aporta la respuesta que su caso necesita y, cuando es posible, se realiza el mismo día.', 'cardio-canseco' ); ?>
			</p>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="proc-grid" data-reveal-group>
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/proc-card' );
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => __( 'Anterior', 'cardio-canseco' ),
					'next_text' => __( 'Siguiente', 'cardio-canseco' ),
				)
			);
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'Todavía no se han publicado procedimientos.', 'cardio-canseco' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_template_part( 'template-parts/cta' ); ?>

<?php
get_footer();
