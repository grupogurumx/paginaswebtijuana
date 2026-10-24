<?php
/**
 * Not found.
 */

get_header();
?>
<section class="page-hero" style="min-height:80vh;display:flex;align-items:center">
	<div class="container center">
		<p class="text-gold" style="font-family:var(--font-display);font-size:8rem;line-height:1;margin:0">404</p>
		<h1><?php echo esc_html( dmc_t( 'not_found' ) ); ?></h1>
		<p class="lead"><?php echo esc_html( dmc_t( 'not_found_text' ) ); ?></p>
		<a class="btn btn--gold" href="<?php echo esc_url( dmc_home_url() ); ?>"><?php echo esc_html( dmc_t( 'back_home' ) ); ?></a>
	</div>
</section>
<?php
get_footer();
