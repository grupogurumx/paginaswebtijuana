<?php
/**
 * 404.
 *
 * @package sws
 */
get_header();
get_template_part( 'template-parts/page', 'hero', array( 'title' => 'Off <em>Target</em>', 'subtitle' => 'The page you were looking for has moved or no longer exists.', 'bg' => sws_img( 'hero-3.webp' ), 'eyebrow' => 'Error 404' ) );
?>
<section class="section"><div class="wrap center">
	<div class="btn-row" style="justify-content:center">
		<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to Home <span class="arrow">→</span></a>
		<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/courses/' ) ); ?>">View Courses</a>
	</div>
</div></section>
<?php
get_footer();
