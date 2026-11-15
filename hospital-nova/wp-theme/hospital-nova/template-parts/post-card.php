<?php
/**
 * Tarjeta de artículo del blog.
 *
 * @package hospital-nova
 */

$cat = get_the_category();
?>
<article class="post-card reveal">
	<a class="post-card__img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'nova-card', array( 'loading' => 'lazy' ) );
		} else {
			$fallback = get_post_meta( get_the_ID(), '_nova_fallback_img', true );
			if ( $fallback ) {
				printf( '<img src="%s" alt="" loading="lazy" width="800" height="500">', esc_url( nova_img( $fallback ) ) );
			}
		}
		?>
	</a>
	<div class="post-card__body">
		<?php if ( $cat ) : ?><span class="post-card__cat"><?php echo esc_html( $cat[0]->name ); ?></span><?php endif; ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<a class="card__link" href="<?php the_permalink(); ?>"><?php echo esc_html( nova_t( 'Leer artículo', 'Read article' ) ); ?></a>
	</div>
</article>
