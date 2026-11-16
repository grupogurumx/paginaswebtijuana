<?php
/**
 * Blog card.
 *
 * @package sws
 */
?>
<article class="post-card" data-reveal>
	<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'sws-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<img src="<?php echo esc_url( sws_hero_url() ); ?>" alt="" loading="lazy" width="900" height="560">
		<?php endif; ?>
	</a>
	<div class="post-card__body">
		<div class="post-card__meta"><?php echo esc_html( get_the_date() ); ?><?php $c = get_the_category(); echo $c ? ' · ' . esc_html( $c[0]->name ) : ''; ?></div>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<a href="<?php the_permalink(); ?>">Read article →</a>
	</div>
</article>
