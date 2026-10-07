<?php
/**
 * Blog card.
 *
 * @package Agave
 */

$cats = get_the_category();
?>
<article <?php post_class( 'post-card' ); ?> data-reveal>
	<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'agave-wide', array( 'loading' => 'lazy' ) );
		} else {
			printf( '<img src="%s" alt="" loading="lazy" width="1600" height="900">', esc_url( agave_img( 'gallery-board', 'agave-wide' ) ) );
		}
		?>
	</a>
	<div class="post-card__body">
		<p class="post-card__meta">
			<?php if ( $cats ) : ?>
				<span class="tag"><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</p>
		<h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<a class="link-arrow" href="<?php the_permalink(); ?>">Read article <?php echo agave_icon( 'arrow' ); // phpcs:ignore ?></a>
	</div>
</article>
