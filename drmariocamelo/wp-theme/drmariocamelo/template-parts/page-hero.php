<?php
/**
 * Inner page hero with breadcrumbs.
 */

defined( 'ABSPATH' ) || exit;

$dmc_id       = get_queried_object_id();
$dmc_subtitle = get_post_meta( $dmc_id, '_dmc_subtitle', true );
$dmc_bg       = has_post_thumbnail( $dmc_id ) ? get_the_post_thumbnail_url( $dmc_id, 'full' ) : dmc_img( 'hero-quirofano.png', 'dr-camelo-quirofano-1.jpg' );
?>
<section class="page-hero">
	<div class="page-hero__img" data-parallax style="background-image:url('<?php echo esc_url( $dmc_bg ); ?>')"></div>
	<div class="container">
		<nav class="breadcrumbs" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( dmc_home_url() ); ?>"><?php echo esc_html( dmc_t( 'nav_home' ) ); ?></a>
			<?php if ( is_single() ) : ?>
				/ <a href="<?php echo esc_url( dmc_page_url( 'blog' ) ); ?>">Blog</a>
			<?php endif; ?>
			/ <span><?php echo esc_html( wp_strip_all_tags( get_the_title( $dmc_id ) ) ); ?></span>
		</nav>
		<h1 class="reveal"><?php echo esc_html( get_the_title( $dmc_id ) ); ?></h1>
		<?php if ( $dmc_subtitle ) : ?>
			<p class="lead reveal" data-delay="1"><?php echo esc_html( $dmc_subtitle ); ?></p>
		<?php elseif ( is_single() ) : ?>
			<p class="lead reveal" data-delay="1"><?php echo esc_html( get_the_date() ); ?> · Dr. Mario Camelo</p>
		<?php endif; ?>
		<div class="hero3d__ctas reveal" data-delay="2" style="margin-top:24px">
			<a class="btn btn--gold" href="#contact-form"><?php echo esc_html( dmc_t( 'cta_schedule' ) ); ?></a>
		</div>
	</div>
</section>
