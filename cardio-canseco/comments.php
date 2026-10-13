<?php
/**
 * Comentarios.
 *
 * El consultorio no usa comentarios y el tipo de contenido «procedimiento» los
 * registra cerrados. Este archivo existe para que `comments_template()` no
 * recurra al respaldo obsoleto de wp-includes, que emite un aviso con WP_DEBUG.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No mostrar nada si la entrada está protegida con contraseña.
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="mt-7">
	<?php if ( have_comments() ) : ?>
		<h2 style="font-size:var(--fs-lg)">
			<?php
			printf(
				esc_html( _n( '%s comentario', '%s comentarios', get_comments_number(), 'cardio-canseco' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>

		<ol class="footer__list" style="list-style:none;padding:0">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'avatar_size' => 44,
					'short_ping'  => true,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="note-box"><?php esc_html_e( 'Los comentarios están cerrados.', 'cardio-canseco' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit' => 'btn btn--accent',
			'title_reply'  => __( 'Deje un comentario', 'cardio-canseco' ),
		)
	);
	?>
</div>
