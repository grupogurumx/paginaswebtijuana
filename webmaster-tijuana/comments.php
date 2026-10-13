<?php
/**
 * Comentarios.
 *
 * @package WebmasterTijuana
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments__title"><?php echo esc_html( sprintf( _n( '%s comentario', '%s comentarios', get_comments_number(), 'webmaster-tijuana' ), number_format_i18n( get_comments_number() ) ) ); ?></h2>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>
