<?php
/**
 * Comments.
 *
 * @package Agave
 */

if ( post_password_required() ) {
	return;
}
?>
<section class="comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments__title"><?php echo esc_html( get_comments_number() ); ?> comments</h2>
		<ol class="comment-list"><?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?></ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>
