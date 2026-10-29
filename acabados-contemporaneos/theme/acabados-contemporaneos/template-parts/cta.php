<?php
/**
 * Llamada a la acción final.
 *
 * @package Acabados
 */

$ac_wa = ac_whatsapp_url();
?>
<section class="cta" id="cotizar">
	<div class="cta__bg" aria-hidden="true" data-parallax="0.15" style="background-image:url('<?php echo esc_url( ac_img_url( 'hero-showroom', 'full' ) ); ?>')"></div>
	<div class="cta__inner container" data-reveal>
		<h2 class="display display--light" data-split><?php ac_e( 'cta_title' ); ?></h2>
		<p class="lead lead--light"><?php ac_e( 'cta_text' ); ?></p>
		<div class="cta__actions">
			<a class="ac-btn ac-btn--light" href="<?php echo esc_url( ac_contact_url() ); ?>" data-magnetic><?php ac_e( 'cta_btn' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php if ( $ac_wa ) : ?>
				<a class="ac-btn ac-btn--ghost" href="<?php echo esc_url( $ac_wa ); ?>" target="_blank" rel="noopener"><?php echo ac_icon( 'whatsapp' ); // phpcs:ignore ?> <?php ac_e( 'cta_btn2' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
