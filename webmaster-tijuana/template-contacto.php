<?php
/**
 * Template Name: Contacto
 *
 * @package WebmasterTijuana
 */

get_header();

while ( have_posts() ) :
	the_post();
	wmt_page_hero( get_the_title(), __( 'Llámanos, escríbenos por WhatsApp o déjanos un mensaje. Respondemos en menos de un día hábil.', 'webmaster-tijuana' ), __( 'Hablemos', 'webmaster-tijuana' ) );
	?>
	<section class="section section--tight">
		<div class="container">
			<ul class="contact-cards" data-reveal-group>
				<li class="contact-card">
					<span class="contact-card__icon"><?php echo wmt_icon( 'phone' ); // phpcs:ignore ?></span>
					<h2><?php esc_html_e( 'Teléfono', 'webmaster-tijuana' ); ?></h2>
					<a href="<?php echo esc_url( wmt_tel_href() ); ?>"><?php echo esc_html( wmt_opt( 'telefono' ) ); ?></a>
				</li>
				<?php if ( wmt_whatsapp_url() ) : ?>
					<li class="contact-card">
						<span class="contact-card__icon"><?php echo wmt_icon( 'whatsapp' ); // phpcs:ignore ?></span>
						<h2>WhatsApp</h2>
						<a href="<?php echo esc_url( wmt_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Enviar mensaje', 'webmaster-tijuana' ); ?></a>
					</li>
				<?php endif; ?>
				<li class="contact-card">
					<span class="contact-card__icon"><?php echo wmt_icon( 'mail' ); // phpcs:ignore ?></span>
					<h2><?php esc_html_e( 'Correo', 'webmaster-tijuana' ); ?></h2>
					<a href="mailto:<?php echo esc_attr( wmt_opt( 'email' ) ); ?>"><?php echo esc_html( wmt_opt( 'email' ) ); ?></a>
				</li>
				<li class="contact-card">
					<span class="contact-card__icon"><?php echo wmt_icon( 'clock' ); // phpcs:ignore ?></span>
					<h2><?php esc_html_e( 'Horario', 'webmaster-tijuana' ); ?></h2>
					<span><?php echo esc_html( wmt_opt( 'horario' ) ); ?></span>
				</li>
			</ul>
			<?php if ( '' !== trim( get_the_content() ) ) : ?>
				<div class="entry-content container--narrow"><?php the_content(); ?></div>
			<?php endif; ?>
		</div>
	</section>
	<?php
endwhile;

get_template_part( 'template-parts/cotizar' );
get_footer();
