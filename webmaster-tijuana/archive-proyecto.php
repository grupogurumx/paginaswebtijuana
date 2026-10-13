<?php
/**
 * Portafolio.
 *
 * @package WebmasterTijuana
 */

get_header();
wmt_page_hero(
	__( 'Portafolio', 'webmaster-tijuana' ),
	__( 'Algunos de los proyectos que hemos desarrollado para negocios como el tuyo.', 'webmaster-tijuana' ),
	__( 'Casos de éxito', 'webmaster-tijuana' )
);
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3" data-reveal-group>
				<?php
				while ( have_posts() ) :
					the_post();
					$tipo = get_post_meta( get_the_ID(), '_wmt_tipo', true );
					?>
					<article <?php post_class( 'project-card' ); ?>>
						<a class="project-card__media" href="<?php the_permalink(); ?>">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'wmt-card' );
							} else {
								echo '<span class="post-card__placeholder">' . wmt_icon( 'monitor' ) . '</span>'; // phpcs:ignore
							}
							?>
						</a>
						<div class="project-card__body">
							<?php if ( $tipo ) : ?>
								<p class="project-card__type"><?php echo esc_html( $tipo ); ?></p>
							<?php endif; ?>
							<h2 class="project-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<div class="empty">
				<span class="empty__icon"><?php echo wmt_icon( 'rocket' ); // phpcs:ignore ?></span>
				<h2><?php esc_html_e( 'Estamos preparando nuestro portafolio', 'webmaster-tijuana' ); ?></h2>
				<p><?php esc_html_e( 'Pídenos ejemplos de proyectos similares al tuyo y te los compartimos al cotizar.', 'webmaster-tijuana' ); ?></p>
				<a class="btn btn--primary" href="<?php echo esc_url( wmt_cotizar_url() ); ?>"><?php esc_html_e( 'Solicitar ejemplos', 'webmaster-tijuana' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta' );
get_footer();
