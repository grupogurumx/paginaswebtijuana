<?php
/**
 * Template Name: Productos
 *
 * @package PeanutBakery
 */

get_header();
pb_page_hero(
	array(
		'eyebrow' => __( 'Hecho a mano, todos los días', 'peanut-bakery' ),
		'title'   => __( 'Pan de <em>masa madre</em>, pan dulce y birote', 'peanut-bakery' ),
		'lead'    => __( 'Cinco líneas de pan artesanal horneadas diario en Playas de Rosarito. Pide por WhatsApp o cotiza mayoreo.', 'peanut-bakery' ),
		'slot'    => 'products',
		'alt'     => __( 'Pan dulce, masa madre y birote de Peanut Bakery', 'peanut-bakery' ),
	)
);
$lines = pb_lines();
?>

<nav class="subnav" aria-label="<?php esc_attr_e( 'Líneas de producto', 'peanut-bakery' ); ?>" data-subnav>
	<div class="container subnav__inner">
		<?php foreach ( $lines as $line ) : ?>
			<a href="#<?php echo esc_attr( $line['id'] ); ?>"><?php echo esc_html( $line['name'] ); ?></a>
		<?php endforeach; ?>
	</div>
</nav>

<?php foreach ( $lines as $i => $line ) : ?>
	<section class="section product-line <?php echo $i % 2 ? 'product-line--alt section--cream' : ''; ?>" id="<?php echo esc_attr( $line['id'] ); ?>">
		<div class="container product-line__grid">
			<div class="product-line__media reveal" data-tilt>
				<?php pb_img( $line['slot'], $line['name'] . ' artesanal en Playas de Rosarito — Peanut Bakery', array( 'size' => 'pb-card' ) ); ?>
				<span class="product-line__index"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
			</div>
			<div class="product-line__copy">
				<span class="chip reveal"><?php echo esc_html( $line['tag'] ); ?></span>
				<h2 class="section__title reveal"><?php echo esc_html( $line['name'] ); ?> <?php esc_html_e( 'en Rosarito', 'peanut-bakery' ); ?></h2>
				<p class="reveal"><?php echo esc_html( $line['desc'] ); ?></p>
				<ul class="menu-list">
					<?php foreach ( $line['items'] as $j => $item ) : ?>
						<li class="reveal" style="--d:<?php echo esc_attr( $j * 0.05 ); ?>s">
							<span><?php echo esc_html( $item ); ?></span>
							<a href="<?php echo esc_url( pb_wa( 'Hola Peanut Bakery 👋 Quiero pedir: ' . $item ) ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( 'Pedir ' . $item . ' por WhatsApp' ); ?>"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'Pedir', 'peanut-bakery' ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="btn-row reveal">
					<a class="btn btn--wa" href="<?php echo esc_url( pb_wa( 'Hola Peanut Bakery 👋 Quiero pedir de la línea ' . $line['name'] . '.' ) ); ?>" target="_blank" rel="noopener"><?php echo pb_icon( 'whatsapp' ); // phpcs:ignore ?> <?php esc_html_e( 'Pedir esta línea', 'peanut-bakery' ); ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/mayoreo/' ) ); ?>"><?php esc_html_e( 'Precio de mayoreo', 'peanut-bakery' ); ?></a>
				</div>
			</div>
		</div>
	</section>
<?php endforeach; ?>

<?php
get_footer();
