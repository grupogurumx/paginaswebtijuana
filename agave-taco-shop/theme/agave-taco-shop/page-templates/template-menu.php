<?php
/**
 * Template Name: Agave — Menu
 *
 * @package Agave
 */

get_header();
while ( have_posts() ) :
	the_post();
	agave_page_hero( get_the_title(), 'Birria · Tacos · Burritos · Breakfast', agave_img( 'dish-quesabirria', 'agave-hero' ), has_excerpt() ? get_the_excerpt() : '' );
	agave_breadcrumbs();
	$menu = agave_menu();
	?>
	<nav class="menu-tabs" aria-label="Menu sections" data-menu-tabs>
		<div class="container menu-tabs__inner">
			<?php foreach ( $menu as $section ) : ?>
				<a href="#<?php echo esc_attr( $section['id'] ); ?>"><?php echo esc_html( $section['title'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</nav>

	<div class="section section--tight">
		<div class="container">
			<?php if ( get_the_content() ) : ?>
				<div class="entry entry--intro"><?php the_content(); ?></div>
			<?php endif; ?>

			<?php foreach ( $menu as $s => $section ) : ?>
				<section class="menu-section" id="<?php echo esc_attr( $section['id'] ); ?>">
					<header class="menu-section__head">
						<span class="menu-section__n"><?php echo esc_html( sprintf( '%02d', $s + 1 ) ); ?></span>
						<div>
							<h2 class="menu-section__title" data-split><?php echo esc_html( $section['title'] ); ?></h2>
							<p class="menu-section__lede" data-reveal><?php echo esc_html( $section['lede'] ); ?></p>
						</div>
					</header>
					<ul class="menu-list">
						<?php foreach ( $section['items'] as $i => $item ) : ?>
							<li class="menu-item-row" data-reveal style="--d:<?php echo esc_attr( $i * 50 ); ?>ms">
								<?php if ( ! empty( $item['img'] ) ) : ?>
									<img class="menu-item-row__img" src="<?php echo esc_url( agave_img( $item['img'], 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" width="150" height="150">
								<?php else : ?>
									<span class="menu-item-row__icon"><?php echo agave_icon( 'flame' ); // phpcs:ignore ?></span>
								<?php endif; ?>
								<div class="menu-item-row__body">
									<h3><?php echo esc_html( $item['name'] ); ?>
										<?php if ( $item['tag'] ) : ?>
											<span class="tag"><?php echo esc_html( $item['tag'] ); ?></span>
										<?php endif; ?>
									</h3>
									<p><?php echo esc_html( $item['desc'] ); ?></p>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endforeach; ?>

			<div class="menu-note" data-reveal>
				<p><strong>Live prices &amp; availability:</strong> our menu evolves with the seasons. See current prices and daily specials when you order online.</p>
				<?php agave_button( 'Order Online', agave_biz( 'order_url' ), 'primary', true ); ?>
			</div>
		</div>
	</div>
	<?php
endwhile;
get_footer();
