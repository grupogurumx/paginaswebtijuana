<?php
/**
 * Plantilla de página.
 *
 * El contenido se dispone a dos columnas: el texto con una medida de lectura
 * cómoda y una columna lateral que acompaña el desplazamiento con los datos
 * de contacto y los estudios. Una sola columna estrecha centrada bajo un hero
 * a todo el ancho deja franjas vacías y se lee como una página sin terminar.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<section class="page-hero">
		<div class="page-hero__media" style="background-image:url('<?php echo esc_url( cardio_hero_bg() ); ?>')"></div>
		<div class="wrap">
			<?php cardio_breadcrumb(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="section">
		<div class="wrap">
			<div class="doc-layout">

				<div class="doc-layout__main prose" data-reveal>
					<?php
					cardio_form_notice();
					the_content();

					wp_link_pages(
						array(
							'before' => '<nav class="mt-6">' . esc_html__( 'Páginas:', 'cardio-canseco' ) . ' ',
							'after'  => '</nav>',
						)
					);
					?>
				</div>

				<aside class="doc-aside" data-reveal="right">

					<?php
					// Retrato del especialista, si está disponible.
					$cardio_retrato = cardio_foto_medico( 'retrato', 'retrato-aside' );
					if ( $cardio_retrato ) :
						?>
						<div class="form-card">
							<?php echo $cardio_retrato; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<p class="retrato-pie" style="margin-top:0">
								<strong><?php cardio_e( 'medico' ); ?></strong>
								<span><?php esc_html_e( 'Médico cardiólogo', 'cardio-canseco' ); ?></span>
							</p>
						</div>
					<?php endif; ?>

					<div class="form-card">
						<h2 class="mt-0" style="font-size:var(--fs-md)"><?php esc_html_e( 'Contacto directo', 'cardio-canseco' ); ?></h2>
						<ul class="info-list mt-5">
							<li>
								<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'phone' ); ?></span>
								<span>
									<span class="info-list__label"><?php esc_html_e( 'Teléfono', 'cardio-canseco' ); ?></span>
									<span class="info-list__value"><a href="<?php echo esc_url( cardio_tel_url() ); ?>"><?php cardio_e( 'tel' ); ?></a></span>
								</span>
							</li>
							<li>
								<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'pin' ); ?></span>
								<span>
									<span class="info-list__label"><?php esc_html_e( 'Consultorio', 'cardio-canseco' ); ?></span>
									<span class="info-list__value">
										<?php echo esc_html( cardio_opt( 'calle' ) ); ?><br>
										<?php echo esc_html( cardio_opt( 'calle2' ) ); ?><br>
										<?php echo esc_html( cardio_opt( 'cp' ) . ' ' . cardio_opt( 'ciudad' ) ); ?>
									</span>
								</span>
							</li>
						</ul>

						<p class="mt-5">
							<a class="btn btn--accent btn--block" href="<?php echo esc_url( cardio_cita_url() ); ?>">
								<?php esc_html_e( 'Agendar cita', 'cardio-canseco' ); ?>
							</a>
						</p>
						<?php if ( cardio_opt( 'whatsapp' ) ) : ?>
							<p class="mt-5" style="margin-bottom:0">
								<a class="btn btn--ghost btn--block" href="<?php echo esc_url( cardio_wa_url() ); ?>" target="_blank" rel="noopener">
									<?php cardio_icon_e( 'wa' ); ?> WhatsApp
								</a>
							</p>
						<?php endif; ?>
					</div>

					<?php
					$cardio_procs = get_posts(
						array(
							'post_type'      => 'procedimiento',
							'posts_per_page' => 8,
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						)
					);
					if ( $cardio_procs ) :
						?>
						<div class="form-card">
							<h2 class="mt-0" style="font-size:var(--fs-md)"><?php esc_html_e( 'Estudios del corazón', 'cardio-canseco' ); ?></h2>
							<ul class="footer__list" style="gap:0.45rem">
								<?php foreach ( $cardio_procs as $cardio_proc ) : ?>
									<li><a href="<?php echo esc_url( get_permalink( $cardio_proc ) ); ?>"><?php echo esc_html( get_the_title( $cardio_proc ) ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

				</aside>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/cta' ); ?>

	<?php
endwhile;

get_footer();
