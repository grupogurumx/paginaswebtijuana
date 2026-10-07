<?php
/**
 * Homepage — 3D panoramic motion hero + conversion sections.
 *
 * @package Agave
 */

get_header();
$slides = agave_slides();
?>

<section class="hero3d" aria-roledescription="carousel" aria-label="Agave Taco Shop highlights" data-hero3d>
	<div class="hero3d__stage" data-hero-stage>
		<?php foreach ( $slides as $i => $slide ) : ?>
			<article class="hero3d__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' / ' . count( $slides ) ); ?>" data-slide="<?php echo esc_attr( $i ); ?>">
				<div class="hero3d__media" data-depth="0.6">
					<img src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['title'] . ' — Agave Taco Shop San Diego' ); ?>" <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?> decoding="async" width="2400" height="1100">
				</div>
				<div class="hero3d__shade"></div>
				<div class="container hero3d__content" data-depth="-0.35">
					<p class="kicker hero3d__kicker"><?php echo esc_html( $slide['kicker'] ); ?></p>
					<?php if ( 0 === $i ) : ?>
						<h1 class="hero3d__title" data-split-hero><?php echo esc_html( $slide['title'] ); ?></h1>
					<?php else : ?>
						<h2 class="hero3d__title" data-split-hero><?php echo esc_html( $slide['title'] ); ?></h2>
					<?php endif; ?>
					<p class="hero3d__text"><?php echo esc_html( $slide['text'] ); ?></p>
					<div class="hero3d__ctas">
						<?php agave_button( $slide['cta'], $slide['cta_url'], 'primary', 0 !== strpos( $slide['cta_url'], home_url() ) ); ?>
						<a class="btn btn--ghost-light" href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><span><?php echo esc_html( agave_biz( 'phone' ) ); ?></span><?php echo agave_icon( 'phone' ); // phpcs:ignore ?></a>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>

	<div class="hero3d__float" aria-hidden="true">
		<span class="float float--a" data-depth="1.2">🌶</span>
		<span class="float float--b" data-depth="-0.9">🍋</span>
		<span class="float float--c" data-depth="0.8"><?php echo agave_icon( 'agave' ); // phpcs:ignore ?></span>
	</div>

	<div class="hero3d__ui container">
		<div class="hero3d__counter"><span data-hero-current>01</span> / <?php echo esc_html( sprintf( '%02d', count( $slides ) ) ); ?></div>
		<div class="hero3d__dots" role="tablist">
			<?php foreach ( $slides as $i => $slide ) : ?>
				<button type="button" role="tab" class="hero3d__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( $slide['kicker'] ); ?>" data-hero-dot="<?php echo esc_attr( $i ); ?>"><span></span></button>
			<?php endforeach; ?>
		</div>
		<div class="hero3d__arrows">
			<button type="button" class="hero3d__arrow" data-hero-prev aria-label="Previous slide"><?php echo agave_icon( 'arrow' ); // phpcs:ignore ?></button>
			<button type="button" class="hero3d__arrow" data-hero-next aria-label="Next slide"><?php echo agave_icon( 'arrow' ); // phpcs:ignore ?></button>
		</div>
	</div>
	<div class="hero3d__scroll" aria-hidden="true"><span></span>Scroll</div>
</section>

<div class="marquee" aria-hidden="true">
	<div class="marquee__track">
		<?php
		$words = array( 'Quesabirria', 'Consommé', 'California Burritos', 'Carne Asada', 'Breakfast from 7 AM', 'Drive-Thru', 'Aguas Frescas', 'Catering', 'Point Loma' );
		for ( $r = 0; $r < 2; $r++ ) {
			foreach ( $words as $w ) {
				echo '<span>' . esc_html( $w ) . '</span><span class="dot">✦</span>';
			}
		}
		?>
	</div>
</div>

<section class="section intro" id="story">
	<div class="container intro__grid">
		<div class="intro__media" data-tilt>
			<img src="<?php echo esc_url( agave_img( 'story-kitchen', 'agave-card' ) ); ?>" alt="Cook preparing fresh birria at Agave Taco Shop in Point Loma" loading="lazy" width="900" height="1100">
			<div class="intro__badge" data-depth="0.4"><strong>7 AM</strong><span>open every day</span></div>
		</div>
		<div class="intro__copy">
			<p class="kicker" data-reveal>Family-owned · Made from scratch</p>
			<h2 class="section-title" data-split>Slow-cooked soul. <em>Point Loma</em> pride.</h2>
			<p class="lead" data-reveal>Agave Taco Shop was born from a family birria recipe and a simple promise: no shortcuts. Our beef braises low and slow in a chile adobo built from guajillo, ancho, garlic and warm spices until it melts — then it meets a hot plancha, a crust of golden cheese and a cup of consommé made from the very same pot.</p>
			<p data-reveal>From the first breakfast burrito at 7 AM to the last quesabirria at midnight on weekends, every order is made to order, wrapped with care and handed to you with a smile — at the counter, the patio or through our drive-thru on West Point Loma Boulevard.</p>
			<ul class="stats" data-reveal>
				<li><strong data-count="7">0</strong><span>days a week, from 7 AM</span></li>
				<li><strong data-count="3">0</strong><span>ways to eat: dine, drive-thru, delivery</span></li>
				<li><strong data-count="100" data-suffix="%">0</strong><span>made-to-order, every time</span></li>
			</ul>
			<?php agave_button( 'Read our story', home_url( '/our-story/' ), 'dark' ); ?>
		</div>
	</div>
</section>

<section class="section signature" id="menu">
	<div class="container">
		<div class="section-head">
			<p class="kicker" data-reveal>The signature menu</p>
			<h2 class="section-title" data-split>Made to be <em>craved.</em></h2>
			<p class="section-lede" data-reveal>Six reasons San Diego keeps coming back. Tap any dish to see the full menu.</p>
		</div>
		<div class="cards">
			<?php foreach ( agave_signature_items() as $n => $item ) : ?>
				<a class="card" href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" data-tilt data-reveal style="--d:<?php echo esc_attr( $n * 80 ); ?>ms">
					<div class="card__media"><img src="<?php echo esc_url( agave_img( $item['img'], 'agave-card' ) ); ?>" alt="<?php echo esc_attr( $item['name'] . ' at Agave Taco Shop San Diego' ); ?>" loading="lazy" width="900" height="1100"></div>
					<div class="card__body">
						<?php if ( $item['tag'] ) : ?>
							<span class="tag"><?php echo esc_html( $item['tag'] ); ?></span>
						<?php endif; ?>
						<h3 class="card__title"><?php echo esc_html( $item['name'] ); ?></h3>
						<p class="card__text"><?php echo esc_html( $item['desc'] ); ?></p>
						<span class="card__more">View menu <?php echo agave_icon( 'arrow' ); // phpcs:ignore ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="center" data-reveal><?php agave_button( 'See the full menu', home_url( '/menu/' ), 'dark' ); ?></div>
	</div>
</section>

<section class="ritual" data-parallax-root>
	<div class="ritual__bg" data-parallax="0.18" style="background-image:url('<?php echo esc_url( agave_img( 'hero-birria-night', 'agave-hero' ) ); ?>')"></div>
	<div class="ritual__veil"></div>
	<div class="container ritual__inner">
		<p class="kicker kicker--light" data-reveal>The birria ritual</p>
		<h2 class="section-title section-title--light" data-split>Four steps to <em>perfection.</em></h2>
		<ol class="steps">
			<li data-reveal style="--d:0ms"><span class="steps__n">01</span><h3>Marinate</h3><p>Beef rests overnight in a deep-red adobo of dried chiles, garlic, oregano and warm spices.</p></li>
			<li data-reveal style="--d:120ms"><span class="steps__n">02</span><h3>Slow-braise</h3><p>Hours in the pot until it falls apart, building the rich consommé as it cooks.</p></li>
			<li data-reveal style="--d:240ms"><span class="steps__n">03</span><h3>Griddle</h3><p>Tortillas dipped in the fat, crisped on the plancha and layered with melted cheese.</p></li>
			<li data-reveal style="--d:360ms"><span class="steps__n">04</span><h3>Dip</h3><p>Lime, onion, cilantro — then straight into the consommé. Repeat until happy.</p></li>
		</ol>
	</div>
</section>

<section class="section order" id="order">
	<div class="container order__grid">
		<div>
			<p class="kicker" data-reveal>Pickup · Drive-thru · Delivery</p>
			<h2 class="section-title" data-split>Order your way, <em>right now.</em></h2>
			<p class="lead" data-reveal>Order direct for the fastest pickup and the best price, swing through the drive-thru, or have Agave delivered to your door anywhere from Ocean Beach to Old Town by our delivery partners.</p>
			<div class="order__ctas" data-reveal>
				<?php agave_button( 'Order Pickup Online', agave_biz( 'order_url' ), 'primary', true ); ?>
				<a class="btn btn--ghost" href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><span>Call <?php echo esc_html( agave_biz( 'phone' ) ); ?></span><?php echo agave_icon( 'phone' ); // phpcs:ignore ?></a>
			</div>
		</div>
		<ul class="partners" aria-label="Order and review partners">
			<?php foreach ( agave_partners() as $n => $partner ) : ?>
				<li data-reveal style="--d:<?php echo esc_attr( $n * 70 ); ?>ms">
					<a class="partner partner--<?php echo esc_attr( $partner['class'] ); ?>" href="<?php echo esc_url( $partner['url'] ); ?>" target="_blank" rel="noopener" data-tilt>
						<span class="partner__name"><?php echo esc_html( $partner['name'] ); ?></span>
						<span class="partner__note"><?php echo esc_html( $partner['note'] ); ?></span>
						<?php echo agave_icon( 'arrow' ); // phpcs:ignore ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section catering-teaser">
	<div class="container catering-teaser__grid">
		<div class="catering-teaser__media" data-tilt>
			<img src="<?php echo esc_url( agave_img( 'catering-spread', 'agave-wide' ) ); ?>" alt="Taco and birria catering spread for a party in San Diego" loading="lazy" width="1600" height="900">
		</div>
		<div class="catering-teaser__copy">
			<p class="kicker" data-reveal>Taco catering · San Diego</p>
			<h2 class="section-title" data-split>Be the hero of <em>every party.</em></h2>
			<p class="lead" data-reveal>From office lunches for 15 to backyard celebrations for 150, Agave brings the birria, the street tacos, the salsas and the aguas frescas — hot, on time and ready to wow.</p>
			<ul class="checks" data-reveal>
				<li>Birria &amp; quesabirria bars with consommé</li>
				<li>Street taco bars: asada, carnitas, pollo</li>
				<li>Burrito boxes for meetings and game days</li>
				<li>Horchata &amp; jamaica by the gallon</li>
			</ul>
			<?php agave_button( 'Plan my catering', home_url( '/catering/' ), 'primary' ); ?>
		</div>
	</div>
</section>

<section class="section love">
	<div class="container">
		<div class="section-head">
			<p class="kicker" data-reveal>Why San Diego keeps coming back</p>
			<h2 class="section-title" data-split>The things our guests <em>rave about.</em></h2>
			<p class="section-lede" data-reveal>What guests mention most in public reviews on Yelp, Google and Tripadvisor.</p>
		</div>
		<div class="love__grid">
			<figure class="quote" data-reveal style="--d:0ms"><div class="quote__stars"><?php echo str_repeat( agave_icon( 'star' ), 5 ); // phpcs:ignore ?></div><blockquote>Generous portions that actually fill you up — the burritos are serious.</blockquote><figcaption>Generous portions</figcaption></figure>
			<figure class="quote" data-reveal style="--d:120ms"><div class="quote__stars"><?php echo str_repeat( agave_icon( 'star' ), 5 ); // phpcs:ignore ?></div><blockquote>Friendly, fast service whether you walk in or roll through the drive-thru.</blockquote><figcaption>Friendly service</figcaption></figure>
			<figure class="quote" data-reveal style="--d:240ms"><div class="quote__stars"><?php echo str_repeat( agave_icon( 'star' ), 5 ); // phpcs:ignore ?></div><blockquote>That birria and consommé — and the aguas frescas to wash it all down.</blockquote><figcaption>Famous birria</figcaption></figure>
		</div>
		<div class="center" data-reveal>
			<?php agave_button( 'Read reviews on Yelp', agave_biz( 'yelp_url' ), 'ghost', true ); ?>
		</div>
	</div>
</section>

<section class="section gram">
	<div class="container">
		<div class="section-head section-head--row">
			<div>
				<p class="kicker" data-reveal>Follow the flavor</p>
				<h2 class="section-title" data-split><?php echo esc_html( agave_biz( 'instagram_handle' ) ); ?></h2>
			</div>
			<?php agave_button( 'Follow on Instagram', agave_biz( 'instagram_url' ), 'dark', true ); ?>
		</div>
		<div class="gram__grid">
			<?php
			$gram = array( 'gallery-hands', 'gallery-board', 'gallery-aguas', 'gallery-taco', 'gallery-salsa', 'gallery-street' );
			foreach ( $gram as $n => $key ) :
				?>
				<a class="gram__item" href="<?php echo esc_url( agave_biz( 'instagram_url' ) ); ?>" target="_blank" rel="noopener" data-reveal style="--d:<?php echo esc_attr( $n * 60 ); ?>ms" aria-label="Agave Taco Shop on Instagram">
					<img src="<?php echo esc_url( agave_img( $key, 'medium_large' ) ); ?>" alt="Tacos and birria from Agave Taco Shop Point Loma" loading="lazy" width="600" height="600">
					<span class="gram__icon"><?php echo agave_icon( 'instagram' ); // phpcs:ignore ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$latest = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
if ( $latest->have_posts() ) :
	?>
	<section class="section journal">
		<div class="container">
			<div class="section-head section-head--row">
				<div>
					<p class="kicker" data-reveal>The Agave Journal</p>
					<h2 class="section-title" data-split>Taco talk &amp; <em>local guides.</em></h2>
				</div>
				<?php agave_button( 'All articles', get_permalink( get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' ), 'ghost' ); ?>
			</div>
			<div class="posts">
				<?php
				while ( $latest->have_posts() ) :
					$latest->the_post();
					get_template_part( 'template-parts/card', 'post' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/visit' ); ?>

<?php
get_footer();
