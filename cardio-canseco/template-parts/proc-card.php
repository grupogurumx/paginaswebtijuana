<?php
/**
 * Tarjeta de procedimiento.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cardio_feature = ! empty( $args['feature'] );
$cardio_lead    = get_post_meta( get_the_ID(), '_cardio_lead', true );
if ( ! $cardio_lead ) {
	$cardio_lead = get_the_excerpt();
}
?>
<a class="proc-card<?php echo $cardio_feature ? ' proc-card--feature' : ''; ?>" href="<?php the_permalink(); ?>">
	<span class="proc-card__media">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail(
				'cardio-card',
				array(
					'alt'      => esc_attr( get_the_title() ),
					'loading'  => 'lazy',
					'decoding' => 'async',
				)
			);
		} else {
			// Sin imagen destacada se recurre al archivo que el propio
			// procedimiento declara. Usar una sola imagen de respaldo dejaría
			// las ocho tarjetas idénticas.
			$cardio_archivo = get_post_meta( get_the_ID(), '_cardio_imagen', true );

			if ( ! $cardio_archivo || ! file_exists( CARDIO_DIR . '/assets/img/' . $cardio_archivo ) ) {
				$cardio_mapa = array();
				if ( function_exists( 'cardio_seed_data' ) ) {
					foreach ( cardio_seed_data() as $cardio_item ) {
						$cardio_mapa[ $cardio_item['slug'] ] = $cardio_item['imagen'];
					}
				}
				$cardio_slug    = get_post_field( 'post_name', get_the_ID() );
				$cardio_archivo = isset( $cardio_mapa[ $cardio_slug ] ) ? $cardio_mapa[ $cardio_slug ] : 'proc-ecocardiograma.jpg';
			}

			printf(
				'<img src="%s" alt="%s" width="1400" height="875" loading="lazy" decoding="async">',
				esc_url( CARDIO_URI . '/assets/img/' . $cardio_archivo ),
				esc_attr( get_the_title() )
			);
		}
		?>
		<span class="proc-card__icon" aria-hidden="true"><?php cardio_icon_e( 'heart' ); ?></span>
	</span>
	<span class="proc-card__body">
		<?php if ( $cardio_feature ) : ?>
			<span class="pill pill--accent"><?php esc_html_e( 'Estudio principal', 'cardio-canseco' ); ?></span>
		<?php endif; ?>
		<h3 class="proc-card__title"><?php the_title(); ?></h3>
		<p class="proc-card__text"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $cardio_lead ), $cardio_feature ? 46 : 30, '…' ) ); ?></p>
		<span class="proc-card__more">
			<?php esc_html_e( 'Ver detalle', 'cardio-canseco' ); ?>
			<?php cardio_icon_e( 'arrow' ); ?>
		</span>
	</span>
</a>
