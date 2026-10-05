<?php
/**
 * Página genérica.
 *
 * @package PeanutBakery
 */

get_header();
while ( have_posts() ) :
	the_post();
	pb_page_hero(
		array(
			'title' => get_the_title(),
			'slot'  => 'about',
		)
	);
	?>
	<section class="section">
		<div class="container container--narrow entry"><?php the_content(); ?></div>
	</section>
	<?php
endwhile;
get_footer();
