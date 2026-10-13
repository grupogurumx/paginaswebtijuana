<?php
/**
 * Proyecto del portafolio.
 *
 * @package WebmasterTijuana
 */

get_header();

while ( have_posts() ) :
	the_post();
	$cliente = get_post_meta( get_the_ID(), '_wmt_cliente', true );
	$tipo    = get_post_meta( get_the_ID(), '_wmt_tipo', true );
	$url     = get_post_meta( get_the_ID(), '_wmt_url', true );
	wmt_page_hero( get_the_title(), get_the_excerpt(), $tipo );
	?>
	<section class="section">
		<div class="container container--narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="entry-media"><?php the_post_thumbnail( 'wmt-wide' ); ?></figure>
			<?php endif; ?>
			<?php if ( $cliente || $url ) : ?>
				<ul class="project-meta">
					<?php if ( $cliente ) : ?>
						<li><small><?php esc_html_e( 'Cliente', 'webmaster-tijuana' ); ?></small><?php echo esc_html( $cliente ); ?></li>
					<?php endif; ?>
					<?php if ( $tipo ) : ?>
						<li><small><?php esc_html_e( 'Proyecto', 'webmaster-tijuana' ); ?></small><?php echo esc_html( $tipo ); ?></li>
					<?php endif; ?>
					<?php if ( $url ) : ?>
						<li><small><?php esc_html_e( 'Sitio', 'webmaster-tijuana' ); ?></small><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( preg_replace( '#^https?://(www\.)?#', '', untrailingslashit( $url ) ) ); ?></a></li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
			<div class="entry-content"><?php the_content(); ?></div>
		</div>
	</section>
	<?php
endwhile;

get_template_part( 'template-parts/cta' );
get_footer();
