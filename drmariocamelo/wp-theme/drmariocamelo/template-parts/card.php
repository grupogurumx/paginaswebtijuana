<?php
/**
 * Blog card.
 */

defined( 'ABSPATH' ) || exit;
?>
<article class="post-card reveal">
	<a class="post-card__img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) );
		}
		?>
	</a>
	<div class="post-card__body">
		<div class="post-card__meta"><?php echo esc_html( get_the_date() ); ?></div>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
		<a class="card3d__link" href="<?php the_permalink(); ?>"><?php echo esc_html( dmc_t( 'read_more' ) ); ?></a>
	</div>
</article>
