<?php
/**
 * Template Name: Nosotros
 *
 * @package PeanutBakery
 */

get_header();
pb_page_hero(
	array(
		'eyebrow' => __( 'Nuestra compañía', 'peanut-bakery' ),
		'title'   => __( 'Nosotros: la <em>ingeniería del pan</em>', 'peanut-bakery' ),
		'lead'    => __( 'Una panadería artesanal en Playas de Rosarito donde la técnica y el corazón trabajan juntos.', 'peanut-bakery' ),
		'slot'    => 'about',
		'alt'     => __( 'Equipo de Peanut Bakery horneando pan artesanal en Rosarito', 'peanut-bakery' ),
	)
);
?>

<section class="section">
	<div class="container story">
		<div class="story__copy">
			<p class="eyebrow reveal"><?php esc_html_e( 'Nuestra historia', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Hacemos pan con propósito, técnica y corazón', 'peanut-bakery' ); ?></h2>
			<p class="reveal"><?php esc_html_e( 'Peanut Bakery nació en Playas de Rosarito con una idea simple: el buen pan no se improvisa. Por eso aplicamos lo que llamamos ingeniería del pan: precisión en cada gramo, temperaturas controladas y tiempos medidos, sin perder la sensibilidad del oficio artesanal.', 'peanut-bakery' ); ?></p>
			<p class="reveal"><?php esc_html_e( 'Todos nuestros productos se elaboran a mano cada día desde el inicio, con recetas artesanales y fermentación lenta de hasta 30 horas. El resultado es un pan con corteza caramelizada, sabor profundo y una calidad real, transparente y constante en cada pieza.', 'peanut-bakery' ); ?></p>
		</div>
		<div class="story__media reveal" data-tilt>
			<?php pb_img( 'intro', __( 'Manos de panadero formando pan de masa madre en Peanut Bakery', 'peanut-bakery' ), array( 'size' => 'pb-card' ) ); ?>
			<div class="intro__badge"><b data-count="30">0</b><span><?php echo wp_kses( __( 'horas de<br>fermentación', 'peanut-bakery' ), array( 'br' => array() ) ); ?></span></div>
		</div>
	</div>
</section>

<section class="section section--cream">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow reveal"><?php esc_html_e( 'Valores', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Lo que nos define', 'peanut-bakery' ); ?></h2>
		</header>
		<?php pb_section_values(); ?>
	</div>
</section>

<section class="section section--dark">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow eyebrow--light reveal"><?php esc_html_e( 'Proceso', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Así se hace un pan de 30 horas', 'peanut-bakery' ); ?></h2>
		</header>
		<?php pb_section_process(); ?>
	</div>
</section>

<section class="section">
	<div class="container space">
		<div class="space__media reveal" data-parallax-wrap>
			<div data-parallax="0.12"><?php pb_img( 'space', __( 'Interior de la panadería Peanut Bakery en Playas de Rosarito', 'peanut-bakery' ), array( 'size' => 'pb-wide' ) ); ?></div>
		</div>
		<div class="space__card reveal">
			<p class="eyebrow"><?php esc_html_e( 'El espacio', 'peanut-bakery' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Ven por pan recién horneado', 'peanut-bakery' ); ?></h2>
			<p><?php esc_html_e( 'Nuestra panadería en Playas de Rosarito huele a pan desde temprano. Pasa por tu hogaza de masa madre, tus conchas de la tarde o tu pedido de mayoreo.', 'peanut-bakery' ); ?></p>
			<ul class="contact-list contact-list--dark">
				<li><?php echo pb_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( pb_address() ); ?></li>
				<li><?php echo pb_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( pb_opt( 'hours' ) ); ?></li>
			</ul>
			<a class="btn btn--primary" href="<?php echo esc_url( pb_opt( 'maps_link' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Cómo llegar', 'peanut-bakery' ); ?> <?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
