<?php
/**
 * Hero con slider panorámico 3D.
 *
 * @package hospital-nova
 */

$title  = get_theme_mod( 'en' === nova_lang() ? 'nova_hero_title_en' : 'nova_hero_title_es' );
$title  = $title ? esc_html( $title ) : nova_t( 'Tu hospital en Tijuana, <span class="text-gradient">abierto 24/7</span>', 'Your hospital in Tijuana, <span class="text-gradient">open 24/7</span>' );
$slides = nova_slides();
?>
<section class="hero" aria-label="<?php echo esc_attr( nova_t( 'Presentación', 'Introduction' ) ); ?>">
	<div class="hero__mesh" aria-hidden="true"><i></i><i></i><i></i></div>
	<div class="hero__grid" aria-hidden="true"></div>
	<div class="container">
		<div>
			<span class="hero__badge"><i class="pulse" aria-hidden="true"></i><?php echo esc_html( nova_t( '¡Servicios Médicos de Confianza!', 'Trusted Medical Services!' ) ); ?></span>
			<h1 data-split><?php echo wp_kses( $title, array( 'span' => array( 'class' => true ) ) ); ?></h1>
			<p class="hero__lead reveal" style="--d:500ms"><?php echo esc_html( nova_t( 'Urgencias, quirófano, hospitalización y valoración por especialistas en un solo lugar. Laboratorio, rayos X y banco de sangre disponibles día y noche.', 'Emergency care, surgery, inpatient care and specialist evaluation in one place. Lab, X-ray and blood bank available day and night.' ) ); ?></p>
			<div class="hero__ctas reveal" style="--d:650ms">
				<a class="btn btn--primary" href="<?php echo esc_url( nova_page_url( 'contacto', 'contact' ) ); ?>#cita" data-magnetic><?php echo nova_icon( 'calendar' ); ?><?php echo esc_html( nova_t( 'Agendar cita', 'Book appointment' ) ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_attr( nova_tel( nova_opt( 'phone' ) ) ); ?>" data-magnetic><?php echo nova_icon( 'phone' ); ?><?php echo esc_html( nova_t( 'Urgencias: ', 'ER: ' ) . nova_opt( 'phone' ) ); ?></a>
			</div>
			<ul class="hero__facts reveal" style="--d:800ms">
				<li><strong>24/7</strong><span><?php echo esc_html( nova_t( 'Siempre abierto', 'Always open' ) ); ?></span></li>
				<li><strong>+6</strong><span><?php echo esc_html( nova_t( 'Especialidades', 'Specialties' ) ); ?></span></li>
				<li><strong>ES / EN</strong><span><?php echo esc_html( nova_t( 'Atención bilingüe', 'Bilingual care' ) ); ?></span></li>
			</ul>
		</div>

		<div class="pano reveal reveal--zoom" style="--d:300ms" data-pano data-autoplay="<?php echo esc_attr( absint( get_theme_mod( 'nova_hero_autoplay', 5000 ) ) ); ?>" tabindex="0" role="region" aria-roledescription="carousel" aria-label="<?php echo esc_attr( nova_t( 'Servicios destacados', 'Featured services' ) ); ?>">
			<div class="pano__tilt">
				<div class="pano__ring">
					<?php foreach ( $slides as $i => $s ) : ?>
						<figure class="pano__card" data-label="<?php echo esc_attr( $s['title'] ); ?>" role="group" aria-roledescription="slide">
							<img src="<?php echo esc_url( $s['img'] ); ?>" alt="<?php echo esc_attr( $s['title'] . ' — Hospital Nova Tijuana' ); ?>" width="1080" height="1350" <?php echo 0 === $i ? 'fetchpriority="high"' : ''; ?> decoding="async" draggable="false">
							<figcaption class="pano__cap"><small><?php echo esc_html( $s['tag'] ); ?></small><b><?php echo esc_html( $s['title'] ); ?></b></figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="pano__floor" aria-hidden="true"></div>
			<div class="pano__nav">
				<button class="pano__btn" type="button" data-prev aria-label="<?php echo esc_attr( nova_t( 'Anterior', 'Previous' ) ); ?>"><?php echo nova_icon( 'left' ); ?></button>
				<div class="pano__dots"></div>
				<button class="pano__btn" type="button" data-next aria-label="<?php echo esc_attr( nova_t( 'Siguiente', 'Next' ) ); ?>"><?php echo nova_icon( 'right' ); ?></button>
				<div class="pano__progress" aria-hidden="true"><i></i></div>
			</div>
		</div>
	</div>
</section>

<div class="trust" aria-hidden="true">
	<div class="marquee">
		<?php
		$items = 'en' === nova_lang()
			? array( '24/7 Emergency', 'Operating rooms', 'Inpatient care', 'Clinical lab', 'X-ray & imaging', 'Blood bank', 'Maternity', 'Specialists' )
			: array( 'Urgencias 24/7', 'Quirófano', 'Hospitalización', 'Laboratorio clínico', 'Rayos X e imagen', 'Banco de sangre', 'Maternidad', 'Especialistas' );
		for ( $k = 0; $k < 2; $k++ ) {
			foreach ( $items as $it ) {
				echo '<span class="marquee__item">' . esc_html( $it ) . '</span>';
			}
		}
		?>
	</div>
</div>
