<?php
/**
 * Plantilla de respaldo: listado de entradas.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="page-hero">
	<div class="page-hero__media" style="background-image:url('<?php echo esc_url( CARDIO_URI . '/assets/img/hero-ecg.jpg' ); ?>')"></div>
	<div class="wrap">
		<?php cardio_breadcrumb(); ?>
		<h1>
			<?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				esc_html_e( 'Salud cardiovascular', 'cardio-canseco' );
			}
			?>
		</h1>
		<?php if ( is_archive() && get_the_archive_description() ) : ?>
			<p class="lead"><?php echo wp_kses_post( get_the_archive_description() ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="proc-grid" data-reveal-group>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<a class="proc-card" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<span class="proc-card__media">
								<?php the_post_thumbnail( 'cardio-card', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
							</span>
						<?php endif; ?>
						<span class="proc-card__body">
							<span class="pill"><?php echo esc_html( get_the_date() ); ?></span>
							<h2 class="proc-card__title"><?php the_title(); ?></h2>
							<p class="proc-card__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<span class="proc-card__more">
								<?php esc_html_e( 'Leer', 'cardio-canseco' ); ?>
								<?php cardio_icon_e( 'arrow' ); ?>
							</span>
						</span>
					</a>
					<?php
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
			<p><?php esc_html_e( 'No hay contenido publicado todavía.', 'cardio-canseco' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
