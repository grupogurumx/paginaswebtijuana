<?php
/**
 * Tarjeta de servicio. Se usa dentro del Loop.
 *
 * @package WebmasterTijuana
 */

$icono = get_post_meta( get_the_ID(), '_wmt_icono', true );
?>
<article <?php post_class( 'service-card' ); ?>>
	<span class="service-card__icon"><?php echo wmt_icon( $icono ? $icono : 'monitor' ); // phpcs:ignore ?></span>
	<h3 class="service-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p class="service-card__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
	<span class="service-card__more" aria-hidden="true"><?php esc_html_e( 'Saber más', 'webmaster-tijuana' ); ?> <?php echo wmt_icon( 'arrow' ); // phpcs:ignore ?></span>
</article>
