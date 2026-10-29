<?php
/**
 * Tarjeta de entrada del blog.
 *
 * @package Acabados
 */

$ac_slug = get_post_meta( get_the_ID(), '_ac_image', true );
?>
<article <?php post_class( 'post-card' ); ?> data-reveal data-tilt>
	<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'ac-wide', array( 'sizes' => '(min-width: 1000px) 33vw, 100vw' ) );
		} elseif ( $ac_slug ) {
			echo ac_img( $ac_slug, array( 'size' => 'ac-wide', 'sizes' => '(min-width: 1000px) 33vw, 100vw' ) ); // phpcs:ignore
		}
		?>
	</a>
	<div class="post-card__body">
		<p class="post-card__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time> · <?php echo esc_html( ac_reading_time() . ' ' . ac_t( 'min_read' ) ); ?></p>
		<h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<a class="ac-link" href="<?php the_permalink(); ?>"><?php ac_e( 'read_more' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
	</div>
</article>
