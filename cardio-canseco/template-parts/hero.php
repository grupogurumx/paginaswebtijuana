<?php
/**
 * Hero de la portada: carrusel panorámico.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Imágenes: las del Personalizador o, si están vacías, las incluidas en el tema.
$cardio_fallbacks = array( 'hero-ecocardiografia.jpg', 'hero-ecg.jpg', 'hero-ergometria.jpg' );
$cardio_slides    = array();

for ( $i = 1; $i <= 3; $i++ ) {
	$id  = (int) get_theme_mod( 'cardio_slide_' . $i, 0 );
	$url = $id ? wp_get_attachment_image_url( $id, 'cardio-hero' ) : '';
	if ( ! $url ) {
		$url = CARDIO_URI . '/assets/img/' . $cardio_fallbacks[ $i - 1 ];
	}
	$cardio_slides[] = $url;
}

$cardio_total = count( $cardio_slides );
?>

<section class="hero" data-hero tabindex="-1"
	aria-roledescription="<?php esc_attr_e( 'carrusel', 'cardio-canseco' ); ?>"
	aria-label="<?php esc_attr_e( 'Presentación del consultorio', 'cardio-canseco' ); ?>">

	<div class="hero__slides">
		<?php foreach ( $cardio_slides as $index => $url ) : ?>
			<div class="hero__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" role="group"
				aria-label="<?php echo esc_attr( sprintf( '%d / %d', $index + 1, $cardio_total ) ); ?>">
				<div class="hero__media" style="background-image:url('<?php echo esc_url( $url ); ?>')"></div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="wrap hero__inner">
		<div class="hero__content">

			<?php if ( cardio_opt( 'hero_badge' ) ) : ?>
				<p class="hero__badge">
					<span class="dot" aria-hidden="true"></span>
					<?php echo wp_kses_post( cardio_opt( 'hero_badge' ) ); ?>
				</p>
			<?php endif; ?>

			<h1 class="hero__title"><?php echo wp_kses_post( cardio_opt( 'hero_titulo' ) ); ?></h1>

			<p class="hero__text"><?php echo wp_kses_post( cardio_opt( 'hero_texto' ) ); ?></p>

			<div class="hero__actions">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( cardio_cita_url() ); ?>">
					<?php esc_html_e( 'Agenda tu cita', 'cardio-canseco' ); ?>
					<?php cardio_icon_e( 'arrow' ); ?>
				</a>
				<?php
				$cardio_archivo = get_post_type_archive_link( 'procedimiento' );
				if ( $cardio_archivo ) :
					?>
					<a class="btn btn--on-dark btn--lg" href="<?php echo esc_url( $cardio_archivo ); ?>">
						<?php esc_html_e( 'Ver procedimientos', 'cardio-canseco' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="hero__meta">
				<div class="hero__meta-item">
					<span class="hero__meta-num" data-count="<?php echo esc_attr( cardio_opt( 'anios' ) ); ?>" data-suffix="+"><?php cardio_e( 'anios' ); ?>+</span>
					<span class="hero__meta-label"><?php esc_html_e( 'Años de experiencia', 'cardio-canseco' ); ?></span>
				</div>
				<div class="hero__meta-item">
					<span class="hero__meta-num" data-count="<?php echo esc_attr( cardio_opt( 'estudios' ) ); ?>"><?php cardio_e( 'estudios' ); ?></span>
					<span class="hero__meta-label"><?php esc_html_e( 'Estudios del corazón', 'cardio-canseco' ); ?></span>
				</div>
				<div class="hero__meta-item">
					<span class="hero__meta-num">UNAM</span>
					<span class="hero__meta-label"><?php esc_html_e( 'Especialidad en cardiología', 'cardio-canseco' ); ?></span>
				</div>
			</div>
		</div>
	</div>

	<a class="hero__scroll" href="#por-que">
		<span class="hero__scroll-line" aria-hidden="true"></span>
		<?php esc_html_e( 'Descubra más', 'cardio-canseco' ); ?>
	</a>

	<div class="hero__controls">
		<div class="hero__dots" role="tablist" aria-label="<?php esc_attr_e( 'Elegir diapositiva', 'cardio-canseco' ); ?>">
			<?php for ( $i = 0; $i < $cardio_total; $i++ ) : ?>
				<button class="hero__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" type="button" role="tab"
					aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'Diapositiva %d', 'cardio-canseco' ), $i + 1 ) ); ?>"></button>
			<?php endfor; ?>
		</div>
		<button class="hero__arrow" type="button" data-hero-prev aria-label="<?php esc_attr_e( 'Diapositiva anterior', 'cardio-canseco' ); ?>">
			<?php cardio_icon_e( 'chevl' ); ?>
		</button>
		<button class="hero__arrow" type="button" data-hero-next aria-label="<?php esc_attr_e( 'Diapositiva siguiente', 'cardio-canseco' ); ?>">
			<?php cardio_icon_e( 'chevr' ); ?>
		</button>
	</div>

	<p class="sr-only" aria-live="polite" data-hero-live></p>
</section>
