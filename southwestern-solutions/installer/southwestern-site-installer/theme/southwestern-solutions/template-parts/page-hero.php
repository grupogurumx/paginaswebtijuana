<?php
/**
 * Inner-page hero with parallax background.
 *
 * @package sws
 */
$sws_title = isset( $args['title'] ) ? $args['title'] : get_the_title();
$sws_sub   = isset( $args['subtitle'] ) ? $args['subtitle'] : ( is_singular() ? get_post_meta( get_the_ID(), '_sws_subtitle', true ) : '' );
$sws_bg    = isset( $args['bg'] ) ? $args['bg'] : sws_hero_url();
$sws_eye   = isset( $args['eyebrow'] ) ? $args['eyebrow'] : ( is_singular() ? get_post_meta( get_the_ID(), '_sws_eyebrow', true ) : '' );
?>
<section class="page-hero">
	<div class="page-hero__bg" style="background-image:url('<?php echo esc_url( $sws_bg ); ?>')" aria-hidden="true"></div>
	<div class="wrap">
		<?php sws_breadcrumbs(); ?>
		<?php if ( $sws_eye ) : ?><span class="eyebrow" data-reveal><?php echo esc_html( $sws_eye ); ?></span><?php endif; ?>
		<h1 data-reveal><?php echo wp_kses( $sws_title, array( 'em' => array(), 'br' => array() ) ); ?></h1>
		<?php if ( $sws_sub ) : ?><p class="lead" data-reveal style="--d:.15s"><?php echo esc_html( $sws_sub ); ?></p><?php endif; ?>
		<?php if ( is_singular( 'post' ) ) : ?>
			<p class="post-card__meta" data-reveal style="--d:.2s"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) ) ); ?> min read</p>
		<?php endif; ?>
	</div>
</section>
