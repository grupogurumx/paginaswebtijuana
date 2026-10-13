<?php
/**
 * Página no encontrada.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="section" style="text-align:center;padding-block:8rem">
	<div class="wrap wrap--narrow">
		<p class="eyebrow" style="justify-content:center"><?php esc_html_e( 'Error 404', 'cardio-canseco' ); ?></p>
		<h1><?php esc_html_e( 'No encontramos esa página', 'cardio-canseco' ); ?></h1>
		<p class="lead">
			<?php esc_html_e( 'Es posible que la dirección haya cambiado. Puede volver al inicio, revisar los procedimientos o buscar lo que necesita.', 'cardio-canseco' ); ?>
		</p>

		<div class="mt-6" style="max-width:420px;margin-inline:auto">
			<?php get_search_form(); ?>
		</div>

		<p class="mt-6" style="display:flex;gap:0.85rem;justify-content:center;flex-wrap:wrap">
			<a class="btn btn--accent" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ir al inicio', 'cardio-canseco' ); ?></a>
			<?php
			$cardio_archivo = get_post_type_archive_link( 'procedimiento' );
			if ( $cardio_archivo ) :
				?>
				<a class="btn btn--ghost" href="<?php echo esc_url( $cardio_archivo ); ?>"><?php esc_html_e( 'Ver procedimientos', 'cardio-canseco' ); ?></a>
			<?php endif; ?>
		</p>
	</div>
</section>

<?php
get_footer();
