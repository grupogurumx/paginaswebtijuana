<?php
/**
 * Resultados de búsqueda.
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
		<h1><?php echo esc_html( sprintf( __( 'Resultados para «%s»', 'cardio-canseco' ), get_search_query() ) ); ?></h1>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div style="max-width:520px;margin-bottom:3rem"><?php get_search_form(); ?></div>

		<?php if ( have_posts() ) : ?>
			<div class="proc-grid" data-reveal-group>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<a class="proc-card" href="<?php the_permalink(); ?>">
						<span class="proc-card__body">
							<h2 class="proc-card__title"><?php the_title(); ?></h2>
							<p class="proc-card__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26, '…' ) ); ?></p>
							<span class="proc-card__more"><?php esc_html_e( 'Ver', 'cardio-canseco' ); ?> <?php cardio_icon_e( 'arrow' ); ?></span>
						</span>
					</a>
					<?php
				endwhile;
				?>
			</div>
			<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
		<?php else : ?>
			<p class="lead"><?php esc_html_e( 'No encontramos resultados. Pruebe con otras palabras o consulte el listado de procedimientos.', 'cardio-canseco' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
