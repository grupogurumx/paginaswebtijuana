<?php
/**
 * Servicio individual.
 *
 * @package WebmasterTijuana
 */

get_header();

while ( have_posts() ) :
	the_post();
	$incluye = array_filter( array_map( 'trim', explode( "\n", (string) get_post_meta( get_the_ID(), '_wmt_incluye', true ) ) ) );
	$icono   = get_post_meta( get_the_ID(), '_wmt_icono', true );
	$titulo  = get_the_title();

	wmt_page_hero( $titulo, get_the_excerpt(), __( 'Servicio', 'webmaster-tijuana' ) );
	?>
	<section class="section">
		<div class="container service-layout">
			<div class="service-layout__main">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-media"><?php the_post_thumbnail( 'wmt-wide' ); ?></figure>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<?php if ( $incluye ) : ?>
					<div class="includes">
						<h2 class="includes__title"><?php esc_html_e( 'Qué incluye', 'webmaster-tijuana' ); ?></h2>
						<ul class="includes__list">
							<?php foreach ( $incluye as $item ) : ?>
								<li><?php echo wmt_icon( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $item ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>

			<aside class="service-layout__aside">
				<div class="aside-card aside-card--brand">
					<span class="aside-card__icon"><?php echo wmt_icon( $icono ? $icono : 'monitor' ); // phpcs:ignore ?></span>
					<h2 class="aside-card__title"><?php esc_html_e( 'Cotiza este servicio', 'webmaster-tijuana' ); ?></h2>
					<p><?php esc_html_e( 'Te enviamos una propuesta sin costo en menos de un día hábil.', 'webmaster-tijuana' ); ?></p>
					<a class="btn btn--accent btn--block" href="#cotizar"><?php esc_html_e( 'Solicitar cotización', 'webmaster-tijuana' ); ?></a>
					<?php if ( wmt_whatsapp_url() ) : ?>
						<a class="btn btn--ghost btn--block" href="<?php echo esc_url( wmt_whatsapp_url( sprintf( __( 'Hola, me interesa el servicio de %s.', 'webmaster-tijuana' ), $titulo ) ) ); ?>" target="_blank" rel="noopener"><?php echo wmt_icon( 'whatsapp' ); // phpcs:ignore ?> WhatsApp</a>
					<?php endif; ?>
					<a class="aside-card__tel" href="<?php echo esc_url( wmt_tel_href() ); ?>"><?php echo wmt_icon( 'phone' ); // phpcs:ignore ?><?php echo esc_html( wmt_opt( 'telefono' ) ); ?></a>
				</div>

				<?php
				$otros = get_posts(
					array(
						'post_type'      => 'servicio',
						'posts_per_page' => 8,
						'post__not_in'   => array( get_the_ID() ),
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
					)
				);
				if ( $otros ) :
					?>
					<nav class="aside-card" aria-label="<?php esc_attr_e( 'Otros servicios', 'webmaster-tijuana' ); ?>">
						<h2 class="aside-card__title"><?php esc_html_e( 'Otros servicios', 'webmaster-tijuana' ); ?></h2>
						<ul class="aside-links">
							<?php foreach ( $otros as $o ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $o ) ); ?>"><?php echo esc_html( get_the_title( $o ) ); ?><?php echo wmt_icon( 'arrow' ); // phpcs:ignore ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endif; ?>
			</aside>
		</div>
	</section>
	<?php
	get_template_part( 'template-parts/cotizar', null, array( 'servicio' => $titulo ) );
endwhile;

get_footer();
