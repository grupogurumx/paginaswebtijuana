<?php
/**
 * Slider panorámico 3D con efectos motion.
 *
 * Las diapositivas se disponen en un cilindro 3D (perspective + rotateY +
 * translateZ). Incluye zoom Ken Burns, paralaje con el puntero/giroscopio,
 * revelado de títulos palabra por palabra, arrastre táctil, teclado,
 * autoplay con barra de progreso y miniaturas panorámicas.
 *
 * @package Acabados
 */

$ac_slides = array(
	array( 'hero-sala', 1, ac_page_url( 'productos/porcelanicos', 'en/products/porcelain-tile' ) ),
	array( 'hero-bano', 2, ac_page_url( 'productos/recubrimientos-de-muro', 'en/products/wall-cladding' ) ),
	array( 'hero-cocina', 3, ac_page_url( 'productos/ceramica', 'en/products/ceramic-tile' ) ),
	array( 'hero-terraza', 4, ac_page_url( 'productos/porcelanicos', 'en/products/porcelain-tile' ) ),
	array( 'hero-showroom', 5, ac_contact_url() ),
);
$ac_total = count( $ac_slides );
?>
<section class="hero" data-hero aria-roledescription="carousel" aria-label="<?php echo esc_attr( 'en' === ac_lang() ? 'Featured collections' : 'Colecciones destacadas' ); ?>">
	<div class="hero__stage" data-hero-stage>
		<div class="hero__track" data-hero-track>
			<?php foreach ( $ac_slides as $i => $slide ) : ?>
				<?php list( $img, $n, $link ) = $slide; ?>
				<article class="hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" data-hero-slide role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' / ' . $ac_total ); ?>"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>>
					<div class="hero__media" data-depth="0.6">
						<?php
						echo ac_img( // phpcs:ignore
							$img,
							array(
								'size'          => 'full',
								'loading'       => 0 === $i ? 'eager' : 'lazy',
								'fetchpriority' => 0 === $i ? 'high' : '',
								'class'         => 'hero__img',
							)
						);
						?>
					</div>
					<div class="hero__shade" aria-hidden="true"></div>
					<div class="hero__content container" data-depth="-0.25">
						<p class="hero__kicker"><span class="hero__index"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><?php ac_e( 's' . $n . '_kicker' ); ?></p>
						<?php
						$ac_tag   = 0 === $i ? 'h1' : 'h2';
						$ac_words = explode( ' ', ac_t( 's' . $n . '_title' ) );
						?>
						<<?php echo esc_html( $ac_tag ); ?> class="hero__title" aria-label="<?php echo esc_attr( ac_t( 's' . $n . '_title' ) ); ?>">
							<?php foreach ( $ac_words as $w => $word ) : ?>
								<span class="word" aria-hidden="true"><span style="--w:<?php echo (int) $w; ?>"><?php echo esc_html( $word ); ?></span></span>
							<?php endforeach; ?>
						</<?php echo esc_html( $ac_tag ); ?>>
						<p class="hero__text"><?php ac_e( 's' . $n . '_text' ); ?></p>
						<div class="hero__actions">
							<a class="ac-btn ac-btn--light" href="<?php echo esc_url( $link ); ?>" data-magnetic<?php echo 0 === $i ? '' : ' tabindex="-1"'; ?>><?php ac_e( 's' . $n . '_cta' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
							<a class="ac-btn ac-btn--ghost" href="<?php echo esc_url( ac_contact_url() ); ?>"<?php echo 0 === $i ? '' : ' tabindex="-1"'; ?>><?php ac_e( 'quote' ); ?></a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="hero__ui container">
		<div class="hero__counter" aria-live="polite"><span data-hero-current>01</span><i></i><span><?php echo esc_html( sprintf( '%02d', $ac_total ) ); ?></span></div>
		<ol class="hero__thumbs" data-hero-thumbs>
			<?php foreach ( $ac_slides as $i => $slide ) : ?>
				<li>
					<button type="button" class="hero__thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" data-hero-go="<?php echo (int) $i; ?>" aria-label="<?php echo esc_attr( ac_t( 's' . $slide[1] . '_title' ) ); ?>">
						<span class="hero__thumb-img" style="background-image:url('<?php echo esc_url( ac_img_url( $slide[0], 'medium' ) ); ?>')"></span>
						<span class="hero__thumb-label"><?php ac_e( 's' . $slide[1] . '_kicker' ); ?></span>
						<span class="hero__bar"><span></span></span>
					</button>
				</li>
			<?php endforeach; ?>
		</ol>
		<div class="hero__arrows">
			<button type="button" class="hero__arrow" data-hero-prev aria-label="<?php ac_e( 'prev' ); ?>"><?php echo ac_icon( 'arrow-l' ); // phpcs:ignore ?></button>
			<button type="button" class="hero__arrow" data-hero-next aria-label="<?php ac_e( 'next' ); ?>"><?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></button>
		</div>
	</div>

	<a class="hero__scroll" href="#intro"><span><?php ac_e( 'scroll' ); ?></span><i aria-hidden="true"></i></a>
</section>
