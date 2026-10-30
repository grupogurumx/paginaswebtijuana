<?php
/**
 * Página no encontrada.
 *
 * @package Acabados
 */

get_header();
?>
<section class="notfound">
	<div class="notfound__bg" style="background-image:url('<?php echo esc_url( ac_img_url( 'textura-marmol', 'full' ) ); ?>')" aria-hidden="true"></div>
	<div class="notfound__inner container">
		<p class="notfound__code" aria-hidden="true">404</p>
		<h1 class="display display--light"><?php ac_e( 'not_found_t' ); ?></h1>
		<p class="lead lead--light"><?php ac_e( 'not_found_d' ); ?></p>
		<a class="ac-btn ac-btn--light" href="<?php echo esc_url( ac_home_url() ); ?>"><?php ac_e( 'back_home' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
	</div>
</section>
<?php
get_footer();
