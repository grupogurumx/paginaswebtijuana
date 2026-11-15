<?php
/**
 * Página genérica. Usa shortcodes [nova_*] para insertar secciones.
 *
 * @package hospital-nova
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero', null, array( 'lead' => has_excerpt() ? get_the_excerpt() : '' ) );
	?>
	<div class="page-content">
		<?php
		// Si la página contiene secciones [nova_*] se muestran a ancho completo.
		if ( false !== strpos( get_the_content(), '[nova_' ) ) {
			the_content();
		} else {
			echo '<section class="section section--white"><div class="container entry">';
			the_content();
			echo '</div></section>';
		}
		?>
	</div>
	<?php
endwhile;
get_footer();
