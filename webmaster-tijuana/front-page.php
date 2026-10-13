<?php
/**
 * Portada.
 *
 * @package WebmasterTijuana
 */

get_header();

$slides = wmt_slides();
?>

<section class="hero" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Nuestros servicios', 'webmaster-tijuana' ); ?>" data-slider>
	<div class="hero__glow" aria-hidden="true"></div>
	<div class="container hero__inner">
		<div class="hero__copy">
			<p class="eyebrow eyebrow--light"><?php esc_html_e( 'Agencia de diseño web y marketing digital en Tijuana', 'webmaster-tijuana' ); ?></p>

			<div class="hero__slides">
				<?php foreach ( $slides as $i => $s ) : ?>
					<div class="hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( sprintf( '%d / %d', $i + 1, count( $slides ) ) ); ?>" <?php echo 0 === $i ? '' : 'aria-hidden="true"'; ?>>
						<?php if ( 0 === $i ) : ?>
							<h1 class="hero__title"><?php echo esc_html( $s['titulo'] ); ?></h1>
						<?php else : ?>
							<p class="hero__title"><?php echo esc_html( $s['titulo'] ); ?></p>
						<?php endif; ?>
						<p class="hero__text"><?php echo esc_html( $s['texto'] ); ?></p>
						<?php if ( $s['tags'] ) : ?>
							<ul class="hero__tags">
								<?php foreach ( $s['tags'] as $tag ) : ?>
									<li><?php echo wmt_icon( 'check' ); // phpcs:ignore ?><?php echo esc_html( $tag ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="hero__actions">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( wmt_cotizar_url() ); ?>"><?php esc_html_e( 'Solicitar cotización', 'webmaster-tijuana' ); ?></a>
				<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( get_post_type_archive_link( 'servicio' ) ); ?>"><?php esc_html_e( 'Ver servicios', 'webmaster-tijuana' ); ?></a>
			</div>
		</div>

		<div class="hero__visual">
			<div class="hero__frame">
				<?php foreach ( $slides as $i => $s ) : ?>
					<img class="hero__img<?php echo 0 === $i ? ' is-active' : ''; ?>" src="<?php echo esc_url( $s['imagen'] ); ?>" alt="" width="1600" height="800" <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?> decoding="async">
				<?php endforeach; ?>
			</div>

			<?php if ( count( $slides ) > 1 ) : ?>
				<div class="hero__controls">
					<button class="hero__arrow" type="button" data-prev aria-label="<?php esc_attr_e( 'Anterior', 'webmaster-tijuana' ); ?>"><?php echo wmt_icon( 'prev' ); // phpcs:ignore ?></button>
					<div class="hero__dots">
						<?php foreach ( $slides as $i => $s ) : ?>
							<button type="button" class="hero__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-go="<?php echo (int) $i; ?>" aria-label="<?php echo esc_attr( $s['titulo'] ); ?>"></button>
						<?php endforeach; ?>
					</div>
					<button class="hero__arrow" type="button" data-next aria-label="<?php esc_attr_e( 'Siguiente', 'webmaster-tijuana' ); ?>"><?php echo wmt_icon( 'next' ); // phpcs:ignore ?></button>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="container">
		<ul class="hero__strip">
			<li><?php echo wmt_icon( 'target' ); // phpcs:ignore ?><span><strong><?php esc_html_e( 'Estrategia a la medida', 'webmaster-tijuana' ); ?></strong><?php esc_html_e( 'para tu público objetivo', 'webmaster-tijuana' ); ?></span></li>
			<li><?php echo wmt_icon( 'trending' ); // phpcs:ignore ?><span><strong><?php esc_html_e( 'Resultados medibles', 'webmaster-tijuana' ); ?></strong><?php esc_html_e( 'con reportes cada mes', 'webmaster-tijuana' ); ?></span></li>
			<li><?php echo wmt_icon( 'phone' ); // phpcs:ignore ?><span><strong><?php echo esc_html( wmt_opt( 'telefono' ) ); ?></strong><a href="<?php echo esc_url( wmt_tel_href() ); ?>"><?php esc_html_e( 'Llámanos hoy', 'webmaster-tijuana' ); ?></a></span></li>
		</ul>
	</div>
</section>

<section class="section" id="nosotros">
	<div class="container split">
		<div class="split__media" data-reveal>
			<img src="<?php echo esc_url( WMT_URI . '/assets/img/slide-seo-ppc.jpg' ); ?>" alt="<?php esc_attr_e( 'Equipo de Webmaster Tijuana en sesión de estrategia', 'webmaster-tijuana' ); ?>" width="1600" height="800" loading="lazy" decoding="async">
			<div class="split__badge">
				<?php echo wmt_icon( 'rocket' ); // phpcs:ignore ?>
				<span><strong><?php esc_html_e( 'Top en Google', 'webmaster-tijuana' ); ?></strong><?php esc_html_e( 'planes de SEO mensual', 'webmaster-tijuana' ); ?></span>
			</div>
		</div>
		<div class="split__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Por qué elegirnos', 'webmaster-tijuana' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Agencia de marketing y desarrollo de sitios web', 'webmaster-tijuana' ); ?></h2>
			<p class="lead"><strong><?php esc_html_e( 'Somos expertos en marketing digital.', 'webmaster-tijuana' ); ?></strong> <?php esc_html_e( 'Un equipo comprometido con el crecimiento de tu proyecto, con retorno de inversión a corto, mediano y largo plazo. Tenemos el conocimiento, la experiencia y las relaciones para consolidar tu negocio.', 'webmaster-tijuana' ); ?></p>
			<ul class="features">
				<li>
					<span class="features__icon"><?php echo wmt_icon( 'target' ); // phpcs:ignore ?></span>
					<span><strong><?php esc_html_e( 'Estrategia personalizada', 'webmaster-tijuana' ); ?></strong><?php esc_html_e( 'Planes a la medida para alcanzar a tu público objetivo.', 'webmaster-tijuana' ); ?></span>
				</li>
				<li>
					<span class="features__icon"><?php echo wmt_icon( 'trending' ); // phpcs:ignore ?></span>
					<span><strong><?php esc_html_e( 'Retorno de inversión', 'webmaster-tijuana' ); ?></strong><?php esc_html_e( 'Resultados tangibles a corto, mediano y largo plazo.', 'webmaster-tijuana' ); ?></span>
				</li>
				<li>
					<span class="features__icon"><?php echo wmt_icon( 'users' ); // phpcs:ignore ?></span>
					<span><strong><?php esc_html_e( 'Expertos comprometidos', 'webmaster-tijuana' ); ?></strong><?php esc_html_e( 'Profesionales dedicados al crecimiento de tu proyecto.', 'webmaster-tijuana' ); ?></span>
				</li>
			</ul>
		</div>
	</div>
</section>

<?php
$servicios = new WP_Query(
	array(
		'post_type'      => 'servicio',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);
if ( $servicios->have_posts() ) :
	?>
	<section class="section section--alt" id="servicios">
		<div class="container">
			<div class="section__head" data-reveal>
				<p class="eyebrow"><?php esc_html_e( 'Qué hacemos', 'webmaster-tijuana' ); ?></p>
				<h2 class="section__title"><?php esc_html_e( 'Servicios destacados', 'webmaster-tijuana' ); ?></h2>
				<p class="section__lead"><?php esc_html_e( 'Todo lo que tu negocio necesita para vender en internet, con un solo equipo.', 'webmaster-tijuana' ); ?></p>
			</div>
			<div class="grid grid--3" data-reveal-group>
				<?php
				while ( $servicios->have_posts() ) :
					$servicios->the_post();
					get_template_part( 'template-parts/servicio-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section" id="proceso">
	<div class="container">
		<div class="section__head" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Cómo trabajamos', 'webmaster-tijuana' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'De la idea a los resultados en cuatro pasos', 'webmaster-tijuana' ); ?></h2>
		</div>
		<ol class="steps" data-reveal-group>
			<li class="step">
				<span class="step__num">01</span>
				<h3><?php esc_html_e( 'Diagnóstico', 'webmaster-tijuana' ); ?></h3>
				<p><?php esc_html_e( 'Conocemos tu negocio, tu competencia y lo que quieres lograr.', 'webmaster-tijuana' ); ?></p>
			</li>
			<li class="step">
				<span class="step__num">02</span>
				<h3><?php esc_html_e( 'Propuesta', 'webmaster-tijuana' ); ?></h3>
				<p><?php esc_html_e( 'Te enviamos un plan claro, con alcance, tiempos y costo.', 'webmaster-tijuana' ); ?></p>
			</li>
			<li class="step">
				<span class="step__num">03</span>
				<h3><?php esc_html_e( 'Desarrollo', 'webmaster-tijuana' ); ?></h3>
				<p><?php esc_html_e( 'Diseñamos, construimos y lanzamos con tu aprobación en cada etapa.', 'webmaster-tijuana' ); ?></p>
			</li>
			<li class="step">
				<span class="step__num">04</span>
				<h3><?php esc_html_e( 'Crecimiento', 'webmaster-tijuana' ); ?></h3>
				<p><?php esc_html_e( 'Medimos, optimizamos y te reportamos los avances cada mes.', 'webmaster-tijuana' ); ?></p>
			</li>
		</ol>
	</div>
</section>

<?php
get_template_part( 'template-parts/testimonios' );
get_template_part( 'template-parts/cotizar' );

get_footer();
