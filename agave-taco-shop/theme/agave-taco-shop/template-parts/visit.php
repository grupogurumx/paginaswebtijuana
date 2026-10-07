<?php
/**
 * Visit us: hours, address and map.
 *
 * @package Agave
 */

$map_src = 'https://www.google.com/maps?q=' . rawurlencode( agave_biz( 'name' ) . ', ' . agave_address_line() ) . '&output=embed';
?>
<section class="section visit" id="visit">
	<div class="container visit__grid">
		<div class="visit__info">
			<p class="kicker" data-reveal>Visit us in Point Loma</p>
			<h2 class="section-title" data-split>Find your new <em>taco spot.</em></h2>
			<ul class="visit__list" data-reveal>
				<li><?php echo agave_icon( 'pin' ); // phpcs:ignore ?><div><strong>Address</strong><a href="<?php echo esc_url( agave_biz( 'maps_url' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( agave_address_line() ); ?></a><small>Near Ocean Beach, Midway &amp; Loma Portal — easy parking</small></div></li>
				<li><?php echo agave_icon( 'phone' ); // phpcs:ignore ?><div><strong>Phone</strong><a href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><?php echo esc_html( agave_biz( 'phone' ) ); ?></a></div></li>
				<li><?php echo agave_icon( 'clock' ); // phpcs:ignore ?><div><strong>Hours</strong><?php agave_hours_list(); ?></div></li>
				<li><?php echo agave_icon( 'car' ); // phpcs:ignore ?><div><strong>Drive-thru</strong><span>Open during all business hours</span></div></li>
			</ul>
			<div class="visit__ctas" data-reveal>
				<?php agave_button( 'Get directions', agave_biz( 'maps_url' ), 'primary', true ); ?>
				<?php agave_button( 'Order ahead', agave_biz( 'order_url' ), 'ghost', true ); ?>
			</div>
		</div>
		<div class="visit__map" data-reveal>
			<iframe title="Map to Agave Taco Shop, Point Loma San Diego" src="<?php echo esc_url( $map_src ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
		</div>
	</div>
</section>
