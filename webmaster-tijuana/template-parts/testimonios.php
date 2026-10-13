<?php
/**
 * Testimonios de clientes.
 *
 * @package WebmasterTijuana
 */

$testimonios = get_posts(
	array(
		'post_type'      => 'testimonio',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);
if ( ! $testimonios ) {
	return;
}
?>
<section class="section" id="testimonios">
	<div class="container">
		<div class="section__head" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Testimonios', 'webmaster-tijuana' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Lo que dicen nuestros clientes', 'webmaster-tijuana' ); ?></h2>
		</div>
		<div class="grid grid--3" data-reveal-group>
			<?php
			foreach ( $testimonios as $t ) :
				$estrellas = (int) get_post_meta( $t->ID, '_wmt_estrellas', true );
				$estrellas = $estrellas ? $estrellas : 5;
				?>
				<figure class="testimonial">
					<?php echo wmt_icon( 'quote', 'testimonial__quote' ); // phpcs:ignore ?>
					<div class="testimonial__stars" role="img" aria-label="<?php echo esc_attr( sprintf( __( '%d de 5 estrellas', 'webmaster-tijuana' ), $estrellas ) ); ?>">
						<?php for ( $i = 0; $i < $estrellas; $i++ ) { echo wmt_icon( 'star' ); } // phpcs:ignore ?>
					</div>
					<blockquote class="testimonial__text"><?php echo wp_kses_post( wpautop( $t->post_content ) ); ?></blockquote>
					<figcaption class="testimonial__author">
						<?php if ( has_post_thumbnail( $t ) ) : ?>
							<?php echo get_the_post_thumbnail( $t, 'thumbnail', array( 'class' => 'testimonial__avatar' ) ); ?>
						<?php else : ?>
							<span class="testimonial__avatar testimonial__avatar--initials" aria-hidden="true"><?php echo esc_html( wmt_initials( $t->post_title ) ); ?></span>
						<?php endif; ?>
						<span>
							<strong><?php echo esc_html( $t->post_title ); ?></strong>
							<span><?php echo esc_html( get_post_meta( $t->ID, '_wmt_cargo', true ) ); ?></span>
						</span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
