<?php
/**
 * Template Name: Agave — Catering
 *
 * @package Agave
 */

get_header();
while ( have_posts() ) :
	the_post();
	agave_page_hero( get_the_title(), 'Taco catering in San Diego', agave_img( 'catering-spread', 'agave-hero' ), has_excerpt() ? get_the_excerpt() : '' );
	agave_breadcrumbs();
	?>
	<div class="section section--tight">
		<div class="container split">
			<div class="entry"><?php the_content(); ?></div>
			<aside class="split__aside" id="contact-form">
				<div class="panel">
					<h2 class="panel__title">Request a catering quote</h2>
					<p>Tell us the date, headcount and vibe — we will build a menu and send pricing within one business day.</p>
					<?php agave_form( 'catering' ); ?>
				</div>
			</aside>
		</div>
	</div>
	<?php
endwhile;
get_footer();
