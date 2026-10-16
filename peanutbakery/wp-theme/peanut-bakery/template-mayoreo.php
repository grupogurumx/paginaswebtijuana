<?php
/**
 * Template Name: Mayoreo (Ventas)
 *
 * @package PeanutBakery
 */

get_header();
pb_page_hero(
	array(
		'eyebrow' => __( 'Ventas · Mayoreo', 'peanut-bakery' ),
		'title'   => __( 'Pan al mayoreo para <em>restaurantes, cafés y hoteles</em>', 'peanut-bakery' ),
		'lead'    => __( 'Proveedor de pan artesanal en Rosarito y Tijuana: entregas programadas, precio preferente y calidad constante.', 'peanut-bakery' ),
		'slot'    => 'wholesale',
		'alt'     => __( 'Pan al mayoreo de Peanut Bakery listo para entrega a restaurantes', 'peanut-bakery' ),
	)
);
?>

<section class="section">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow reveal"><?php esc_html_e( 'Por qué Peanut Bakery', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Un proveedor de pan en el que puedes confiar', 'peanut-bakery' ); ?></h2>
		</header>
		<?php pb_section_wholesale_benefits(); ?>
	</div>
</section>

<section class="section section--cream">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow reveal"><?php esc_html_e( 'A quién surtimos', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Pan para cada tipo de negocio', 'peanut-bakery' ); ?></h2>
		</header>
		<div class="segments">
			<?php
			$segments = array(
				array( 'cup', __( 'Cafeterías', 'peanut-bakery' ), __( 'Croissants, roles, conchas y pan de masa madre para toast y sándwiches.', 'peanut-bakery' ) ),
				array( 'fire', __( 'Restaurantes y taquerías', 'peanut-bakery' ), __( 'Birote, bolillo, telera, pan para hamburguesa y focaccia para tu carta.', 'peanut-bakery' ) ),
				array( 'star', __( 'Hoteles y eventos', 'peanut-bakery' ), __( 'Canasta de pan para desayunos, buffets, bodas y banquetes.', 'peanut-bakery' ) ),
				array( 'shield', __( 'Tiendas y minisúper', 'peanut-bakery' ), __( 'Pan de caja, pan dulce y bolillo empacado con rotación diaria.', 'peanut-bakery' ) ),
			);
			foreach ( $segments as $i => $s ) :
				?>
				<article class="segment reveal" style="--d:<?php echo esc_attr( $i * 0.1 ); ?>s" data-tilt>
					<span class="value__icon"><?php echo pb_icon( $s[0] ); // phpcs:ignore ?></span>
					<h3 class="value__title"><?php echo esc_html( $s[1] ); ?></h3>
					<p><?php echo esc_html( $s[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--dark">
	<div class="container">
		<header class="section__head">
			<p class="eyebrow eyebrow--light reveal"><?php esc_html_e( 'Cómo empezar', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Tu primer pedido en 4 pasos', 'peanut-bakery' ); ?></h2>
		</header>
		<ol class="process">
			<?php
			$steps = array(
				array( '01', __( 'Cotiza', 'peanut-bakery' ), __( 'Cuéntanos qué panes y qué volumen necesitas.', 'peanut-bakery' ) ),
				array( '02', __( 'Prueba', 'peanut-bakery' ), __( 'Te enviamos muestras para tu equipo de cocina.', 'peanut-bakery' ) ),
				array( '03', __( 'Programa', 'peanut-bakery' ), __( 'Definimos días, horarios y ruta de entrega.', 'peanut-bakery' ) ),
				array( '04', __( 'Recibe', 'peanut-bakery' ), __( 'Pan fresco y constante, con precio preferente.', 'peanut-bakery' ) ),
			);
			foreach ( $steps as $i => $st ) :
				?>
				<li class="process__step reveal" style="--d:<?php echo esc_attr( $i * 0.12 ); ?>s">
					<span class="process__num"><?php echo esc_html( $st[0] ); ?></span>
					<h3 class="process__title"><?php echo esc_html( $st[1] ); ?></h3>
					<p><?php echo esc_html( $st[2] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="section" id="formulario">
	<div class="container form-wrap">
		<div>
			<p class="eyebrow reveal"><?php esc_html_e( 'Cotización', 'peanut-bakery' ); ?></p>
			<h2 class="section__title reveal"><?php esc_html_e( 'Solicita tu cotización de mayoreo', 'peanut-bakery' ); ?></h2>
			<p class="reveal"><?php esc_html_e( 'Respondemos en menos de 24 horas. Si prefieres, envíalo directo por WhatsApp con un clic.', 'peanut-bakery' ); ?></p>
		</div>
		<?php pb_form( 'mayoreo' ); ?>
	</div>
</section>

<?php
get_footer();
