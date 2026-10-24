<?php
/**
 * Home page sections (shared by the EN front page and the ES home template).
 */

defined( 'ABSPATH' ) || exit;

$slides = array(
	array( 'h1', dmc_img( 'hero-quirofano.png', 'dr-camelo-quirofano-1.jpg' ), 'contact' ),
	array( 'h2', dmc_img( 'hero-vida-sana.png', 'dr-camelo-laparoscopia-2.jpg' ), 'metabolic' ),
	array( 'h3', dmc_img( 'hero-playa.png', 'dr-camelo-quirofano-1.jpg' ), 'about' ),
	array( 'h4', dmc_img( 'hero-consulta.png', 'dr-camelo-laparoscopia-2.jpg' ), 'financing' ),
);
?>

<section class="hero3d" data-hero3d data-interval="7000" aria-roledescription="carousel" aria-label="Dr. Mario Camelo">
	<canvas class="hero3d__particles" aria-hidden="true"></canvas>
	<div class="hero3d__stage">
		<?php foreach ( $slides as $i => $s ) : ?>
			<div class="hero3d__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo (int) $i + 1; ?> / <?php echo count( $slides ); ?>">
				<div class="hero3d__bg" style="background-image:url('<?php echo esc_url( $s[1] ); ?>')"></div>
				<div class="container">
					<div class="hero3d__content">
						<span class="hero3d__badge"><b>#SuperDrSleeve</b> <?php echo esc_html( dmc_t( $s[0] . '_badge' ) ); ?></span>
						<?php $tag = 0 === $i ? 'h1' : 'h2'; ?>
						<<?php echo $tag; // phpcs:ignore ?>><?php echo wp_kses_post( dmc_t( $s[0] . '_title' ) ); ?></<?php echo $tag; // phpcs:ignore ?>>
						<p><?php echo esc_html( dmc_t( $s[0] . '_text' ) ); ?></p>
						<div class="hero3d__ctas">
							<?php if ( 'financing' === $s[2] ) : ?>
								<a class="btn btn--gold" href="<?php echo esc_url( dmc_page_url( 'financing' ) ); ?>" data-magnetic><?php echo esc_html( dmc_t( 'cta_financing' ) ); ?></a>
							<?php else : ?>
								<a class="btn btn--gold" href="#contact-form" data-magnetic data-track="cta_hero"><?php echo esc_html( dmc_t( 'cta_schedule' ) ); ?></a>
							<?php endif; ?>
							<a class="btn btn--ghost" href="<?php echo esc_url( 'financing' === $s[2] ? '#contact-form' : dmc_page_url( $s[2] ) ); ?>"><?php echo esc_html( 'financing' === $s[2] ? dmc_t( 'cta_qualify' ) : dmc_t( 'cta_learn' ) ); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="hero3d__nav">
		<div class="container">
			<div class="hero3d__counter"><b data-hero-current>01</b> / 0<?php echo count( $slides ); ?></div>
			<div class="hero3d__dots">
				<?php foreach ( $slides as $i => $s ) : ?>
					<button class="hero3d__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-label="<?php echo (int) $i + 1; ?>"></button>
				<?php endforeach; ?>
			</div>
			<div class="hero3d__arrows">
				<button class="hero3d__arrow" data-hero-prev aria-label="<?php echo esc_attr( dmc_t( 'prev' ) ); ?>">←</button>
				<button class="hero3d__arrow" data-hero-next aria-label="<?php echo esc_attr( dmc_t( 'next' ) ); ?>">→</button>
			</div>
		</div>
	</div>
	<span class="hero3d__scroll" aria-hidden="true"><?php echo esc_html( dmc_t( 'scroll' ) ); ?></span>
</section>

<section class="stats">
	<div class="container">
		<div class="stats__grid reveal">
			<div class="stat"><div class="stat__num text-gold"><span data-count="10000">10,000</span>+</div><div class="stat__label"><?php echo esc_html( dmc_t( 's1_label' ) ); ?></div></div>
			<div class="stat"><div class="stat__num text-gold">25–32%</div><div class="stat__label"><?php echo esc_html( dmc_t( 's2_label' ) ); ?></div></div>
			<div class="stat"><div class="stat__num text-gold">$0</div><div class="stat__label"><?php echo esc_html( dmc_t( 's3_label' ) ); ?></div></div>
			<div class="stat"><div class="stat__num text-gold">EN · ES</div><div class="stat__label"><?php echo esc_html( dmc_t( 's4_label' ) ); ?></div></div>
		</div>
	</div>
</section>

<section class="section" id="about">
	<div class="container split">
		<div class="photo-stack reveal reveal--left" data-parallax-tilt>
			<img src="<?php echo esc_url( dmc_img( 'dr-camelo-quirofano-1.jpg' ) ); ?>" alt="<?php echo esc_attr( 'es' === dmc_lang() ? 'Dr. Mario Camelo en quirófano durante una cirugía bariátrica laparoscópica en Tijuana' : 'Dr. Mario Camelo in the operating room during laparoscopic bariatric surgery in Tijuana' ); ?>" loading="lazy" width="1440" height="959">
			<img src="<?php echo esc_url( dmc_img( 'dr-camelo-laparoscopia-2.jpg' ) ); ?>" alt="<?php echo esc_attr( 'es' === dmc_lang() ? 'Equipo multidisciplinario del Dr. Camelo realizando manga gástrica' : 'Dr. Camelo and his multidisciplinary team performing a gastric sleeve' ); ?>" loading="lazy" width="1440" height="959">
			<div class="photo-stack__badge"><strong>10K+</strong><span><?php echo wp_kses_post( dmc_t( 'about_badge' ) ); ?></span></div>
		</div>
		<div class="reveal reveal--right">
			<span class="eyebrow"><?php echo esc_html( dmc_t( 'about_eyebrow' ) ); ?></span>
			<h2><?php echo wp_kses_post( dmc_t( 'about_title' ) ); ?></h2>
			<p class="lead"><?php echo esc_html( dmc_t( 'about_text' ) ); ?></p>
			<ul class="checklist">
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<li><?php echo esc_html( dmc_t( 'about_li' . $i ) ); ?></li>
				<?php endfor; ?>
			</ul>
			<a class="btn btn--navy" href="<?php echo esc_url( dmc_page_url( 'about' ) ); ?>"><?php echo esc_html( dmc_t( 'cta_learn' ) ); ?></a>
		</div>
	</div>
</section>

<div class="marquee" aria-hidden="true">
	<div class="marquee__track">
		<?php
		$words = array_filter( array_map( 'trim', explode( '·', dmc_t( 'marquee' ) ) ) );
		for ( $r = 0; $r < 4; $r++ ) {
			foreach ( $words as $w ) {
				echo '<span>' . esc_html( $w ) . '</span>';
			}
		}
		?>
	</div>
</div>

<section class="section section--dark" id="procedures">
	<div class="container">
		<div class="center reveal">
			<span class="eyebrow"><?php echo esc_html( dmc_t( 'proc_eyebrow' ) ); ?></span>
			<h2><?php echo wp_kses_post( dmc_t( 'proc_title' ) ); ?></h2>
			<p class="lead"><?php echo esc_html( dmc_t( 'proc_lead' ) ); ?></p>
		</div>
		<?php echo dmc_procedures_html( true ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>

<section class="pano">
	<div class="pano__img" data-parallax style="background-image:url('<?php echo esc_url( dmc_img( 'hero-playa.png', 'dr-camelo-laparoscopia-2.jpg' ) ); ?>')"></div>
	<div class="container reveal">
		<span class="eyebrow"><?php echo esc_html( dmc_t( 'pano_eyebrow' ) ); ?></span>
		<h2><?php echo wp_kses_post( dmc_t( 'pano_title' ) ); ?></h2>
		<p class="lead" style="color:#d4ddf3"><?php echo esc_html( dmc_t( 'pano_text' ) ); ?></p>
	</div>
</section>

<section class="section section--soft" id="process">
	<div class="container">
		<div class="center reveal">
			<span class="eyebrow"><?php echo esc_html( dmc_t( 'proc2_eyebrow' ) ); ?></span>
			<h2><?php echo wp_kses_post( dmc_t( 'proc2_title' ) ); ?></h2>
		</div>
		<div class="timeline">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<div class="step reveal" data-delay="<?php echo (int) $i; ?>">
					<div class="step__num"></div>
					<h3><?php echo esc_html( dmc_t( "step{$i}_t" ) ); ?></h3>
					<p><?php echo esc_html( dmc_t( "step{$i}_d" ) ); ?></p>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<section class="section section--dark" id="reviews">
	<div class="container">
		<div class="center reveal">
			<span class="eyebrow"><?php echo esc_html( dmc_t( 'rev_eyebrow' ) ); ?></span>
			<h2><?php echo wp_kses_post( dmc_t( 'rev_title' ) ); ?></h2>
			<p class="lead"><?php echo esc_html( dmc_t( 'rev_lead' ) ); ?></p>
		</div>
		<?php echo dmc_reviews_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<?php echo dmc_logos_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>

<section class="section section--soft">
	<div class="container">
		<?php echo dmc_financing_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>

<?php
$posts = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'meta_query'          => array( array( 'key' => '_dmc_lang', 'value' => dmc_lang() ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
	)
);
if ( $posts->have_posts() ) :
	?>
<section class="section" id="blog">
	<div class="container">
		<div class="center reveal" style="margin-bottom:50px">
			<span class="eyebrow"><?php echo esc_html( dmc_t( 'latest' ) ); ?></span>
			<h2><?php echo wp_kses_post( dmc_t( 'latest_title' ) ); ?></h2>
		</div>
		<div class="posts">
			<?php
			while ( $posts->have_posts() ) {
				$posts->the_post();
				get_template_part( 'template-parts/card' );
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section section--soft" id="faq">
	<div class="container">
		<div class="center reveal">
			<span class="eyebrow"><?php echo esc_html( dmc_t( 'faq_eyebrow' ) ); ?></span>
			<h2><?php echo wp_kses_post( dmc_t( 'faq_title' ) ); ?></h2>
		</div>
		<?php echo dmc_faq_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>

<section class="section" style="padding-top:0;background:var(--paper-2)">
	<div class="container">
		<?php echo dmc_cta_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<p class="disclaimer"><?php echo esc_html( dmc_t( 'disclaimer' ) ); ?></p>
	</div>
</section>
