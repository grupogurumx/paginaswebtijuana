<?php
/**
 * Template Name: Agave — Contact
 *
 * @package Agave
 */

get_header();
while ( have_posts() ) :
	the_post();
	agave_page_hero( get_the_title(), 'We would love to hear from you', agave_img( 'gallery-aguas', 'agave-hero' ), has_excerpt() ? get_the_excerpt() : '' );
	agave_breadcrumbs();
	?>
	<div class="section section--tight">
		<div class="container split">
			<div class="entry">
				<?php the_content(); ?>
				<ul class="visit__list">
					<li><?php echo agave_icon( 'pin' ); // phpcs:ignore ?><div><strong>Address</strong><a href="<?php echo esc_url( agave_biz( 'maps_url' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( agave_address_line() ); ?></a></div></li>
					<li><?php echo agave_icon( 'phone' ); // phpcs:ignore ?><div><strong>Phone</strong><a href="tel:<?php echo esc_attr( agave_biz( 'phone_e164' ) ); ?>"><?php echo esc_html( agave_biz( 'phone' ) ); ?></a></div></li>
					<li><?php echo agave_icon( 'clock' ); // phpcs:ignore ?><div><strong>Hours</strong><?php agave_hours_list(); ?></div></li>
					<li><?php echo agave_icon( 'instagram' ); // phpcs:ignore ?><div><strong>Social</strong><a href="<?php echo esc_url( agave_biz( 'instagram_url' ) ); ?>" target="_blank" rel="noopener">Instagram <?php echo esc_html( agave_biz( 'instagram_handle' ) ); ?></a> · <a href="<?php echo esc_url( agave_biz( 'facebook_url' ) ); ?>" target="_blank" rel="noopener">Facebook</a></div></li>
				</ul>
			</div>
			<aside class="split__aside" id="contact-form">
				<div class="panel">
					<h2 class="panel__title">Send us a message</h2>
					<?php agave_form( 'contact' ); ?>
				</div>
			</aside>
		</div>
	</div>
	<?php
endwhile;
get_template_part( 'template-parts/visit' );
get_footer();
