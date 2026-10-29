<?php
/**
 * Secciones de la portada (ES y EN).
 *
 * @package Acabados
 */

$ac_lang = ac_lang();
$ac_cats = array(
	array( 1, 'cat-porcelanico', ac_page_url( 'productos/porcelanicos', 'en/products/porcelain-tile' ) ),
	array( 2, 'cat-ceramica', ac_page_url( 'productos/ceramica', 'en/products/ceramic-tile' ) ),
	array( 3, 'cat-recubrimientos', ac_page_url( 'productos/recubrimientos-de-muro', 'en/products/wall-cladding' ) ),
	array( 4, 'cat-madera', ac_page_url( 'productos/porcelanato-tipo-madera', 'en/products/wood-look-tile' ) ),
	array( 5, 'cat-mosaicos', ac_page_url( 'productos/mosaicos', 'en/products/mosaic-tile' ) ),
	array( 6, 'cat-accesorios', ac_page_url( 'productos/accesorios-de-instalacion', 'en/products/installation-accessories' ) ),
);
$ac_amb  = array(
	array( 'amb1', 'hero-sala' ),
	array( 'amb2', 'hero-bano' ),
	array( 'amb3', 'hero-cocina' ),
	array( 'amb4', 'hero-terraza' ),
	array( 'amb5', 'blog-gran-formato' ),
	array( 'amb6', 'cat-madera' ),
);
?>

<?php get_template_part( 'template-parts/hero' ); ?>

<section class="section intro" id="intro">
	<div class="container intro__grid">
		<div class="intro__copy">
			<p class="kicker" data-reveal><?php ac_e( 'intro_kicker' ); ?></p>
			<h2 class="display" data-reveal data-split><?php ac_e( 'intro_title' ); ?></h2>
			<p class="lead" data-reveal><?php ac_e( 'intro_text' ); ?></p>
			<a class="ac-link" href="<?php echo esc_url( ac_page_url( 'nosotros', 'en/about' ) ); ?>" data-reveal><?php ac_e( 'intro_cta' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
		<figure class="intro__media" data-reveal data-parallax="0.12">
			<?php echo ac_img( 'nosotros-asesoria', array( 'size' => 'large', 'sizes' => '(min-width: 1000px) 45vw, 100vw' ) ); // phpcs:ignore ?>
			<figcaption class="intro__badge"><strong data-count="<?php echo esc_attr( ac_opt( 'years', '35' ) ); ?>">0</strong><span>+ <?php ac_e( 'stat_years' ); ?></span></figcaption>
		</figure>
	</div>
	<div class="container">
		<dl class="stats" data-reveal>
			<div class="stat"><dt><span data-count="<?php echo esc_attr( ac_opt( 'years', '35' ) ); ?>">0</span>+</dt><dd><?php ac_e( 'stat_years' ); ?></dd></div>
			<div class="stat"><dt><span data-count="6">0</span></dt><dd><?php ac_e( 'stat_products' ); ?></dd></div>
			<div class="stat"><dt><span data-count="24">0</span>h</dt><dd><?php ac_e( 'stat_projects' ); ?></dd></div>
			<div class="stat"><dt><span data-count="1">0</span></dt><dd><?php ac_e( 'stat_brands' ); ?></dd></div>
		</dl>
	</div>
</section>

<section class="section cats" id="colecciones">
	<div class="container">
		<header class="section-head">
			<p class="kicker" data-reveal><?php ac_e( 'cats_kicker' ); ?></p>
			<h2 class="display" data-reveal data-split><?php ac_e( 'cats_title' ); ?></h2>
			<p class="section-head__text" data-reveal><?php ac_e( 'cats_text' ); ?></p>
		</header>
		<div class="cats__grid">
			<?php foreach ( $ac_cats as $k => $cat ) : ?>
				<?php list( $n, $img, $link ) = $cat; ?>
				<a class="cat-card" href="<?php echo esc_url( $link ); ?>" data-reveal data-tilt style="--d:<?php echo (int) $k; ?>">
					<span class="cat-card__media"><?php echo ac_img( $img, array( 'size' => 'ac-card', 'sizes' => '(min-width: 1000px) 33vw, (min-width: 600px) 50vw, 100vw' ) ); // phpcs:ignore ?></span>
					<span class="cat-card__shine" aria-hidden="true"></span>
					<span class="cat-card__body">
						<span class="cat-card__num"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
						<span class="cat-card__title"><?php ac_e( 'cat' . $n . '_t' ); ?></span>
						<span class="cat-card__text"><?php ac_e( 'cat' . $n . '_d' ); ?></span>
						<span class="cat-card__cta"><?php ac_e( 'discover' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="band" aria-label="<?php echo esc_attr( ac_t( 'band_author' ) ); ?>">
	<div class="band__bg" data-parallax="0.25" style="background-image:url('<?php echo esc_url( ac_img_url( 'textura-marmol', 'full' ) ); ?>')"></div>
	<blockquote class="band__quote container" data-reveal>
		<p data-split><?php ac_e( 'band_quote' ); ?></p>
		<footer>— <?php ac_e( 'band_author' ); ?></footer>
	</blockquote>
</section>

<section class="section why">
	<div class="container">
		<header class="section-head section-head--split">
			<div>
				<p class="kicker" data-reveal><?php ac_e( 'why_kicker' ); ?></p>
				<h2 class="display" data-reveal data-split><?php ac_e( 'why_title' ); ?></h2>
			</div>
		</header>
		<div class="why__grid">
			<?php foreach ( array( 'spark', 'box', 'tag', 'layers' ) as $k => $icon ) : ?>
				<article class="why-card" data-reveal style="--d:<?php echo (int) $k; ?>">
					<span class="why-card__icon"><?php echo ac_icon( $icon ); // phpcs:ignore ?></span>
					<h3><?php ac_e( 'why' . ( $k + 1 ) . '_t' ); ?></h3>
					<p><?php ac_e( 'why' . ( $k + 1 ) . '_d' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section amb">
	<div class="container">
		<header class="section-head section-head--split">
			<div>
				<p class="kicker" data-reveal><?php ac_e( 'amb_kicker' ); ?></p>
				<h2 class="display" data-reveal data-split><?php ac_e( 'amb_title' ); ?></h2>
			</div>
			<p class="amb__hint" data-reveal><?php ac_e( 'amb_hint' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></p>
		</header>
	</div>
	<div class="amb__rail" data-drag-rail tabindex="0" aria-label="<?php ac_e( 'amb_title' ); ?>">
		<?php foreach ( $ac_amb as $k => $item ) : ?>
			<a class="amb-card" href="<?php echo esc_url( ac_page_url( 'ambientes', 'en/spaces' ) ); ?>" draggable="false">
				<span class="amb-card__media"><?php echo ac_img( $item[1], array( 'size' => 'ac-wide', 'sizes' => '(min-width: 1000px) 40vw, 85vw' ) ); // phpcs:ignore ?></span>
				<span class="amb-card__label"><em><?php echo esc_html( sprintf( '%02d', $k + 1 ) ); ?></em><?php ac_e( $item[0] ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<section class="section pro">
	<div class="container pro__grid">
		<div class="pro__copy">
			<p class="kicker kicker--light" data-reveal><?php ac_e( 'pro_kicker' ); ?></p>
			<h2 class="display display--light" data-reveal data-split><?php ac_e( 'pro_title' ); ?></h2>
			<p class="lead lead--light" data-reveal><?php ac_e( 'pro_text' ); ?></p>
			<a class="ac-btn ac-btn--light" href="<?php echo esc_url( ac_page_url( 'profesionales', 'en/professionals' ) ); ?>" data-reveal data-magnetic><?php ac_e( 'pro_cta' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
		<ol class="steps">
			<?php foreach ( array( 1, 2, 3, 4 ) as $n ) : ?>
				<li class="step" data-reveal style="--d:<?php echo (int) $n; ?>">
					<span class="step__num"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
					<h3><?php ac_e( 'step' . $n . '_t' ); ?></h3>
					<p><?php ac_e( 'step' . $n . '_d' ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<?php
$ac_cat   = get_category_by_slug( 'en' === $ac_lang ? 'blog-en' : 'blog' );
$ac_posts = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'cat'                 => $ac_cat ? $ac_cat->term_id : 0,
	)
);
if ( $ac_posts->have_posts() ) :
	?>
	<section class="section journal">
		<div class="container">
			<header class="section-head section-head--split">
				<div>
					<p class="kicker" data-reveal><?php ac_e( 'blog_kicker' ); ?></p>
					<h2 class="display" data-reveal data-split><?php ac_e( 'blog_title' ); ?></h2>
				</div>
				<a class="ac-link" href="<?php echo esc_url( ac_page_url( 'blog', 'en/blog' ) ); ?>" data-reveal><?php ac_e( 'view_all' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
			</header>
			<div class="posts-grid">
				<?php
				while ( $ac_posts->have_posts() ) :
					$ac_posts->the_post();
					get_template_part( 'template-parts/post-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section faq">
	<div class="container faq__grid">
		<header class="section-head">
			<p class="kicker" data-reveal><?php ac_e( 'faq_kicker' ); ?></p>
			<h2 class="display" data-reveal data-split><?php ac_e( 'faq_title' ); ?></h2>
		</header>
		<div class="faq__list">
			<?php foreach ( array( 1, 2, 3, 4 ) as $n ) : ?>
				<details class="faq-item" data-reveal<?php echo 1 === $n ? ' open' : ''; ?>>
					<summary><?php ac_e( 'faq' . $n . '_q' ); ?><i aria-hidden="true"></i></summary>
					<p><?php ac_e( 'faq' . $n . '_a' ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/cta' ); ?>
