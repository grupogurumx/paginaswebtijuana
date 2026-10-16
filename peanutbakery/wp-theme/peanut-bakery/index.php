<?php
/**
 * Blog y archivos.
 *
 * @package PeanutBakery
 */

get_header();
pb_page_hero(
	array(
		'eyebrow' => __( 'Blog', 'peanut-bakery' ),
		'title'   => is_home() ? __( 'Blog de pan artesanal', 'peanut-bakery' ) : wp_strip_all_tags( get_the_archive_title() ),
		'crumb'   => is_home() ? __( 'Blog', 'peanut-bakery' ) : wp_strip_all_tags( get_the_archive_title() ),
		'lead'    => __( 'Masa madre, pan dulce mexicano y consejos para negocios de alimentos en Rosarito y Tijuana.', 'peanut-bakery' ),
		'slot'    => 'products',
	)
);
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'post-card reveal' ); ?> style="--d:<?php echo esc_attr( ( $i++ % 3 ) * 0.08 ); ?>s">
						<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'pb-wide', array( 'loading' => 'lazy' ) );
							} else {
								pb_img( 'hero-1', get_the_title(), array( 'size' => 'pb-wide' ) );
							}
							?>
						</a>
						<div class="post-card__body">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
							<a class="line-card__more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Leer más', 'peanut-bakery' ); ?> <?php echo pb_icon( 'arrow' ); // phpcs:ignore ?></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p class="center"><?php esc_html_e( 'Pronto publicaremos nuevas recetas e historias del horno.', 'peanut-bakery' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
