<?php
/**
 * 404.
 *
 * @package Agave
 */

get_header();
agave_page_hero( 'This taco fell off the plate.', 'Error 404', agave_img( 'gallery-street', 'agave-hero' ), 'The page you are looking for has moved — but the birria has not.' );
?>
<div class="section section--tight">
	<div class="container center">
		<?php agave_button( 'Back to home', home_url( '/' ), 'primary' ); ?>
		<?php agave_button( 'See the menu', home_url( '/menu/' ), 'ghost' ); ?>
	</div>
</div>
<?php
get_footer();
