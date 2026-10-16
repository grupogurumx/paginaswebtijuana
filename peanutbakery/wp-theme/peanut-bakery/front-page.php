<?php
/**
 * Página de Inicio.
 * Wireframe: Cabecera → Slider panorámico 3D → Cinta de productos → Ingeniería del pan →
 * Líneas de pan → Proceso → Mayoreo (#mayoreo) → Galería por categoría → FAQ → Contacto + mapa → CTA → Pie.
 *
 * @package PeanutBakery
 */

get_header();
$slides = pb_slides();
$video  = pb_opt( 'hero_video' );
?>

<section class="hero" data-hero aria-roledescription="carrusel" aria-label="<?php esc_attr_e( 'Destacados de Peanut Bakery', 'peanut-bakery' ); ?>">
	<div class="hero__stage" data-stage>
		<div class="hero__ring" data-ring>
			<?php foreach ( $slides as $i => $s ) : ?>
				<div class="hero__face" data-face aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
					<div class="hero__media" data-depth="18">
						<?php if ( 0 === $i && $video ) : ?>
							<video class="hero__video" src="<?php echo esc_url( $video ); ?>" autoplay muted loop playsinline poster="<?php echo esc_url( pb_img_url( $s['slot'], 'pb-panorama' ) ); ?>"></video>
						<?php else : ?>
							<?php pb_img( $s['slot'], $s['alt'], array( 'size' => 'pb-panorama', 'eager' => 0 === $i ) ); ?>
						<?php endif; ?>
					</div>
					<div class="hero__shade"></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="container hero__copy">
		<?php foreach ( $slides as $i => $s ) : ?>
			<?php
			$href = $s['cta'][1];
			$wa   = 0 === strpos( $href, 'wa:' );
			$href = $wa ? pb_wa( substr( $href, 3 ) ) : home_url( $href );
			?>
			<div class="hero__text <?php echo 0 === $i ? 'is-active' : ''; ?>" data-text role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' de ' . count( $slides ) ); ?>">
				<p class="eyebrow eyebrow--light"><?php echo esc_html( $s['eyebrow'] ); ?></p>
				<?php if ( 0 === $i ) : ?>
					<h1 class="hero__title"><?php echo wp_kses( $s['title'], array( 'em' => array() ) ); ?></h1>
				<?php else : ?>
					<h2 class="hero__title"><?php echo wp_kses( $s['title'], array( 'em' => array() ) ); ?></h2>
				<?php endif; ?>
				<p class="hero__lead"><?php echo esc_html( $s['text'] ); ?></p>
				<div class="hero__actions">
					<a class="btn <?php echo $wa ? 'btn--wa' : 'btn--primary'; ?> btn--lg" href="<?php echo esc_url( $href ); ?>" <?php echo $wa ? 'target="_blank" rel="noopener"' : ''; ?>>
						<?php echo $wa ? pb_icon( 'whatsapp' ) : ''; // phpcs:ignore ?> <?php echo esc_html( $s['cta'][0] ); ?> <?php echo $wa ? '' : pb_icon( 'arrow' ); // phpcs:ignore ?>
					</a>
					<a class="btn btn--ghost-light btn--lg" href="<?php echo esc_url( pb_wa() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Hacer pedido', 'peanut-bakery' ); ?></a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="hero__controls container">
		<p class="hero__counter"><b data-current>01</b> / <?php echo esc_html( sprintf( '%02d', count( $slides ) ) ); ?></p>
		<div class="hero__dots" role="tablist">
			<?php foreach ( $slides as $i => $s ) : ?>
				<button type="button" class="hero__dot <?php echo 0 === $i ? 'is-active' : ''; ?>" data-dot="<?php echo esc_attr( $i ); ?>" role="tab" aria-label="<?php echo esc_attr( sprintf( __( 'Ir al slide %d', 'peanut-bakery' ), $i + 1 ) ); ?>"><span></span></button>
			<?php endforeach; ?>
		</div>
		<div class="hero__arrows">
			<button type="button" class="hero__arrow hero__arrow--prev" data-prev aria-label="<?php esc_attr_e( 'Anterior', 'peanut-bakery' ); ?>"><?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></button>
			<button type="button" class="hero__arrow" data-next aria-label="<?php esc_attr_e( 'Siguiente', 'peanut-bakery' ); ?>"><?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></button>
		</div>
	</div>
	<a class="hero__scroll" href="#marquesina" aria-label="<?php esc_attr_e( 'Bajar', 'peanut-bakery' ); ?>"><span></span></a>
</section>

<div class="marquee" id="marquesina" aria-hidden="true">
	<div class="marquee__track">
		<?php for ( $r = 0; $r < 2; $r++ ) : ?>
			<?php foreach ( array( 'Masa madre', 'Conchas', 'Bolillo', 'Birote salado', 'Donas', 'Croissants', 'Focaccia', 'Roles de canela', 'Pan al mayoreo' ) as $w ) : ?>
				<span><?php echo esc_html( $w ); ?></span><?php echo pb_icon( 'wheat' ); // phpcs:ignore ?>
			<?php endforeach; ?>
		<?php endfor; ?>
	</div>
</div>

<section class="section intro">
	<div class="container intro__grid">
		<div class="intro__media reveal" data-tilt>
			<?php pb_img( 'intro', 'Panadero de Peanut Bakery formando pan de masa madre a mano en Rosarito', array( 'size' => 'pb-card' ) ); ?>
			<div class="intro__badge"><b data-count="30">0</b><span>horas de<br>fermentación</span></div>
		</div>
		<div class="intro__copy">
			<p class="eyebrow reveal"><?php esc_html_e( 'Nuestra compañía', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php echo wp_kses( __( 'La <em>ingeniería del pan</em>, hecha a mano en Playas de Rosarito', 'peanut-bakery' ), array( 'em' => array() ) ); ?></h2>
			<p class="reveal"><?php esc_html_e( 'En Peanut Bakery hacemos pan con propósito, técnica y corazón. Aplicamos precisión, procesos controlados y sensibilidad artesanal para ofrecer una calidad real, transparente y constante en cada pieza: de la hogaza de masa madre a la concha de la tarde.', 'peanut-bakery' ); ?></p>
			<ul class="stats reveal">
				<li><b data-count="30">0</b><span><?php esc_html_e( 'horas de fermentación lenta', 'peanut-bakery' ); ?></span></li>
				<li><b data-count="100" data-suffix="%">0</b><span><?php esc_html_e( 'hecho a mano, diario', 'peanut-bakery' ); ?></span></li>
				<li><b data-count="5">0</b><span><?php esc_html_e( 'líneas de pan artesanal', 'peanut-bakery' ); ?></span></li>
			</ul>
			<a class="btn btn--primary reveal" href="<?php echo esc_url( home_url( '/nosotros/' ) ); ?>"><?php esc_html_e( 'Conoce nuestra historia', 'peanut-bakery' ); ?> <?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>

<section class="section section--cream">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow reveal"><?php esc_html_e( 'Productos', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Nuestras líneas de pan artesanal', 'peanut-bakery' ); ?></h2>
			<p class="section__lead reveal"><?php esc_html_e( 'Pan dulce, bolillo y birote, masa madre, panes artesanales y repostería fina. Todo horneado diario en Rosarito.', 'peanut-bakery' ); ?></p>
		</header>
		<?php pb_section_lines(); ?>
	</div>
</section>

<section class="section section--dark">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow eyebrow--light reveal"><?php esc_html_e( 'Cómo lo hacemos', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Del costal de harina a tu mesa', 'peanut-bakery' ); ?></h2>
		</header>
		<?php pb_section_process(); ?>
	</div>
</section>

<section class="section wholesale" id="mayoreo">
	<div class="container wholesale__grid">
		<div class="wholesale__copy">
			<p class="eyebrow reveal"><?php esc_html_e( 'Ventas · Mayoreo', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php echo wp_kses( __( 'Tu proveedor de pan en <em>Rosarito y Tijuana</em>', 'peanut-bakery' ), array( 'em' => array() ) ); ?></h2>
			<p class="reveal"><?php esc_html_e( 'Surtimos pan fresco y constante a cafeterías, restaurantes, hoteles y tiendas, con descuentos por volumen, precio preferente y entregas programadas.', 'peanut-bakery' ); ?></p>
			<?php pb_section_wholesale_benefits(); ?>
			<div class="btn-row reveal">
				<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/mayoreo/' ) ); ?>"><?php esc_html_e( 'Ver programa de mayoreo', 'peanut-bakery' ); ?> <?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></a>
				<a class="btn btn--wa" href="<?php echo esc_url( pb_wa( 'Hola Peanut Bakery 👋 Quiero una cotización de pan al mayoreo para mi negocio.' ) ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'Cotizar por WhatsApp', 'peanut-bakery' ); ?></a>
			</div>
		</div>
		<div class="wholesale__media reveal" data-tilt>
			<?php pb_img( 'hero-4', 'Pan al mayoreo para restaurantes y cafeterías en Rosarito y Tijuana', array( 'size' => 'pb-card' ) ); ?>
		</div>
	</div>
</section>

<section class="section section--cream">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow reveal"><?php esc_html_e( 'Galería', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Recién salido del horno', 'peanut-bakery' ); ?></h2>
		</header>
		<div class="filters reveal" role="tablist" data-filters>
			<button type="button" class="filter is-active" data-filter="*"><?php esc_html_e( 'Todo', 'peanut-bakery' ); ?></button>
			<?php foreach ( pb_lines() as $line ) : ?>
				<button type="button" class="filter" data-filter="<?php echo esc_attr( $line['id'] ); ?>"><?php echo esc_html( $line['name'] ); ?></button>
			<?php endforeach; ?>
		</div>
		<div class="gallery" data-gallery>
			<?php foreach ( pb_lines() as $i => $line ) : ?>
				<figure class="gallery__item <?php echo 0 === $i % 3 ? 'gallery__item--tall' : ''; ?>" data-cat="<?php echo esc_attr( $line['id'] ); ?>">
					<?php pb_img( $line['slot'], $line['name'] . ' — Peanut Bakery Rosarito', array( 'size' => 'pb-card' ) ); ?>
					<figcaption><?php echo esc_html( $line['name'] ); ?></figcaption>
				</figure>
			<?php endforeach; ?>
			<figure class="gallery__item" data-cat="masa-madre"><?php pb_img( 'hero-1', 'Hogazas de masa madre de 30 horas de fermentación', array( 'size' => 'pb-card' ) ); ?><figcaption><?php esc_html_e( 'Masa madre', 'peanut-bakery' ); ?></figcaption></figure>
		</div>
		<?php if ( pb_opt( 'instagram' ) ) : ?>
			<p class="center reveal"><a class="btn btn--outline" href="<?php echo esc_url( pb_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'instagram' ); // phpcs:ignore ?> <?php esc_html_e( 'Síguenos en Instagram', 'peanut-bakery' ); ?></a></p>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="container faq-wrap">
		<header class="section__head section__head--left">
			<p class="eyebrow reveal"><?php esc_html_e( 'Preguntas frecuentes', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Todo sobre nuestro pan', 'peanut-bakery' ); ?></h2>
			<p class="reveal"><?php esc_html_e( '¿Tienes otra duda? Escríbenos y te contestamos en minutos.', 'peanut-bakery' ); ?></p>
			<a class="btn btn--wa reveal" href="<?php echo esc_url( pb_wa( 'Hola Peanut Bakery 👋 Tengo una pregunta.' ) ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'Preguntar por WhatsApp', 'peanut-bakery' ); ?></a>
		</header>
		<?php pb_section_faq(); ?>
	</div>
</section>

<section class="section section--cream" id="contacto">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow reveal"><?php esc_html_e( 'Visítanos', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Panadería en Playas de Rosarito', 'peanut-bakery' ); ?></h2>
		</header>
		<?php pb_section_contact_cards(); ?>
		<?php pb_section_map(); ?>
	</div>
</section>

<?php
get_footer();
