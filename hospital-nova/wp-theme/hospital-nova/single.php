<?php
/**
 * Artículo del blog.
 *
 * @package hospital-nova
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero' );
	?>
	<section class="section section--white">
		<article class="container entry">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'large', array( 'style' => 'border-radius:var(--radius-l);margin-bottom:32px' ) );
			}
			the_content();
			?>
			<div class="entry-cta">
				<h3><?php echo esc_html( nova_t( '¿Necesitas valoración médica?', 'Need a medical evaluation?' ) ); ?></h3>
				<p><?php echo esc_html( nova_t( 'Nuestros especialistas te atienden en Tijuana, 24 horas los 7 días.', 'Our specialists see you in Tijuana, 24 hours a day, 7 days a week.' ) ); ?></p>
				<a class="btn btn--primary" href="<?php echo esc_url( nova_page_url( 'contacto', 'contact' ) ); ?>#cita" data-magnetic><?php echo nova_icon( 'calendar' ); ?><?php echo esc_html( nova_t( 'Agendar cita', 'Book appointment' ) ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( nova_wa() ); ?>" target="_blank" rel="noopener"><?php echo nova_icon( 'whatsapp' ); ?>WhatsApp</a>
			</div>
			<p class="disclaimer"><?php echo esc_html( nova_t( 'Este contenido es informativo y no sustituye la consulta con un profesional de la salud. Ante una urgencia, acude de inmediato a Hospital Nova o llama al ', 'This content is for information only and does not replace a consultation with a health professional. In an emergency, come to Hospital Nova right away or call ' ) . nova_opt( 'phone' ) . '.' ); ?></p>
		</article>
	</section>
	<?php
	echo nova_section_posts( 3 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
endwhile;
get_footer();
