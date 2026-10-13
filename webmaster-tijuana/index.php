<?php
/**
 * Plantilla general: blog, archivos y respaldo.
 *
 * @package WebmasterTijuana
 */

get_header();

$descripcion = is_archive() ? wp_strip_all_tags( get_the_archive_description() ) : '';
wmt_page_hero( wmt_current_title(), $descripcion );
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/post-card' );
				endwhile;
				?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => wmt_icon( 'prev' ) . '<span class="screen-reader-text">' . __( 'Anterior', 'webmaster-tijuana' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Siguiente', 'webmaster-tijuana' ) . '</span>' . wmt_icon( 'next' ),
				)
			);
			?>
		<?php else : ?>
			<div class="empty">
				<h2><?php esc_html_e( 'Aún no hay publicaciones', 'webmaster-tijuana' ); ?></h2>
				<p><?php esc_html_e( 'Muy pronto compartiremos aquí consejos de marketing digital y diseño web.', 'webmaster-tijuana' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta' );
get_footer();
