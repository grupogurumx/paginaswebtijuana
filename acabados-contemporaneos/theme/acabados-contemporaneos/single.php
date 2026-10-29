<?php
/**
 * Entrada individual del blog.
 *
 * @package Acabados
 */

get_header();
while ( have_posts() ) :
	the_post();
	$ac_slug = get_post_meta( get_the_ID(), '_ac_image', true );
	?>
	<article <?php post_class( 'single-post' ); ?>>
		<header class="post-hero">
			<div class="post-hero__inner container container--narrow">
				<nav class="breadcrumbs breadcrumbs--dark" aria-label="Breadcrumb">
					<ol>
						<?php $ac_crumbs = ac_breadcrumbs(); ?>
						<?php foreach ( $ac_crumbs as $i => $crumb ) : ?>
							<li><?php if ( $i < count( $ac_crumbs ) - 1 ) : ?><a href="<?php echo esc_url( $crumb[1] ); ?>"><?php echo esc_html( $crumb[0] ); ?></a><?php else : ?><span aria-current="page"><?php echo esc_html( wp_trim_words( $crumb[0], 6 ) ); ?></span><?php endif; ?></li>
						<?php endforeach; ?>
					</ol>
				</nav>
				<p class="post-card__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time> · <?php echo esc_html( ac_reading_time() . ' ' . ac_t( 'min_read' ) ); ?></p>
				<h1 class="post-hero__title" data-split><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
			<figure class="post-hero__media container" data-reveal>
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'full', array( 'fetchpriority' => 'high', 'loading' => 'eager' ) );
				} elseif ( $ac_slug ) {
					echo ac_img( $ac_slug, array( 'size' => 'full', 'loading' => 'eager', 'fetchpriority' => 'high' ) ); // phpcs:ignore
				}
				?>
			</figure>
		</header>
		<div class="entry-content container container--narrow">
			<?php the_content(); ?>
		</div>
		<footer class="post-share container container--narrow">
			<span><?php ac_e( 'share' ); ?>:</span>
			<a href="https://wa.me/?text=<?php echo rawurlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener">WhatsApp</a>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener">Facebook</a>
			<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener">LinkedIn</a>
			<a href="https://pinterest.com/pin/create/button/?url=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener">Pinterest</a>
		</footer>
	</article>
	<?php
	$ac_cats    = wp_get_post_categories( get_the_ID() );
	$ac_related = new WP_Query(
		array(
			'posts_per_page'      => 3,
			'post__not_in'        => array( get_the_ID() ),
			'category__in'        => $ac_cats,
			'ignore_sticky_posts' => true,
		)
	);
	if ( $ac_related->have_posts() ) :
		?>
		<section class="section journal">
			<div class="container">
				<header class="section-head"><h2 class="display"><?php ac_e( 'related' ); ?></h2></header>
				<div class="posts-grid">
					<?php
					while ( $ac_related->have_posts() ) :
						$ac_related->the_post();
						get_template_part( 'template-parts/post-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
	get_template_part( 'template-parts/cta' );
endwhile;
get_footer();
