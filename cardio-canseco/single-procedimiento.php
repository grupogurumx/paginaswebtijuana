<?php
/**
 * Página de un procedimiento.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$cardio_id   = get_the_ID();
	$cardio_lead = get_post_meta( $cardio_id, '_cardio_lead', true );
	$cardio_dur  = get_post_meta( $cardio_id, '_cardio_duracion', true );
	$cardio_ind  = cardio_lines( $cardio_id, '_cardio_indica' );
	$cardio_como = cardio_lines( $cardio_id, '_cardio_como' );
	$cardio_prep = cardio_lines( $cardio_id, '_cardio_prep' );
	$cardio_faq  = cardio_faq_pairs( $cardio_id );
	?>

	<section class="page-hero">
		<div class="page-hero__media" style="background-image:url('<?php echo esc_url( cardio_hero_bg() ); ?>')"></div>
		<div class="wrap">
			<?php cardio_breadcrumb(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( $cardio_lead ) : ?>
				<p class="lead"><?php echo esc_html( $cardio_lead ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="section">
		<div class="wrap">

			<?php
			// Ficha rápida: se deduce de los propios campos del procedimiento.
			$cardio_ayuno = __( 'No requiere ayuno', 'cardio-canseco' );
			foreach ( $cardio_prep as $cardio_linea ) {
				$cardio_bajo = function_exists( 'mb_strtolower' ) ? mb_strtolower( $cardio_linea, 'UTF-8' ) : strtolower( $cardio_linea );
				if ( false !== strpos( $cardio_bajo, 'ayuno ligero' ) ) {
					$cardio_ayuno = __( 'Ayuno ligero de 2 a 3 h', 'cardio-canseco' );
					break;
				}
				if ( false !== strpos( $cardio_bajo, 'no requiere ayuno' ) ) {
					break;
				}
			}

			$cardio_inmediatos = array( 'ecocardiograma-doppler-color', 'electrocardiograma', 'riesgo-cardiovascular', 'revision-de-marcapasos' );
			$cardio_resultado  = in_array( get_post_field( 'post_name', $cardio_id ), $cardio_inmediatos, true )
				? __( 'En la misma consulta', 'cardio-canseco' )
				: __( 'Tras analizar el registro', 'cardio-canseco' );

			$cardio_ficha = array(
				array( 'clock', __( 'Duración', 'cardio-canseco' ), $cardio_dur ? $cardio_dur : __( 'Según el caso', 'cardio-canseco' ) ),
				array( 'shield', __( 'Molestias', 'cardio-canseco' ), __( 'Estudio no invasivo', 'cardio-canseco' ) ),
				array( 'heart', __( 'Preparación', 'cardio-canseco' ), $cardio_ayuno ),
				array( 'arrow', __( 'Resultado', 'cardio-canseco' ), $cardio_resultado ),
			);
			?>

			<div class="factsheet" data-reveal>
				<?php foreach ( $cardio_ficha as $cardio_dato ) : ?>
					<div class="factsheet__item">
						<span class="factsheet__icon" aria-hidden="true"><?php cardio_icon_e( $cardio_dato[0] ); ?></span>
						<span class="factsheet__label"><?php echo esc_html( $cardio_dato[1] ); ?></span>
						<span class="factsheet__value"><?php echo esc_html( $cardio_dato[2] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="article-layout">

				<div class="article-layout__main article-body" data-reveal>
					<?php if ( get_the_content() ) : ?>
						<p class="eyebrow"><?php esc_html_e( 'En qué consiste', 'cardio-canseco' ); ?></p>
						<?php the_content(); ?>
					<?php endif; ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="article-figure">
							<?php the_post_thumbnail( 'cardio-card', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
							<figcaption>
								<?php
								echo esc_html( sprintf(
									/* translators: 1: nombre del estudio, 2: nombre del médico. */
									__( '%1$s · Consultorio del %2$s, Centro Hospitalario MAC', 'cardio-canseco' ),
									get_the_title(),
									cardio_opt( 'medico' )
								) );
								?>
							</figcaption>
						</figure>
					<?php endif; ?>

					<?php if ( $cardio_ind ) : ?>
						<h2><?php esc_html_e( 'Cuándo se indica', 'cardio-canseco' ); ?></h2>
						<ul class="indica-grid">
							<?php foreach ( $cardio_ind as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( $cardio_como ) : ?>
						<h2><?php esc_html_e( 'Cómo se realiza', 'cardio-canseco' ); ?></h2>
						<ol class="flow">
							<?php foreach ( $cardio_como as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>

					<?php if ( $cardio_prep ) : ?>
						<div class="prep-card">
							<h2><?php esc_html_e( 'Cómo prepararse', 'cardio-canseco' ); ?></h2>
							<ul class="check-list">
								<?php foreach ( $cardio_prep as $item ) : ?>
									<li><?php echo esc_html( $item ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<?php if ( $cardio_dur ) : ?>
						<div class="note-box">
							<strong><?php esc_html_e( 'Duración estimada:', 'cardio-canseco' ); ?></strong>
							<?php echo esc_html( $cardio_dur ); ?>.
							<?php esc_html_e( 'Este tiempo es orientativo y puede variar según el caso. Al agendar le confirmamos los detalles de su estudio.', 'cardio-canseco' ); ?>
						</div>
					<?php endif; ?>
				</div>

				<aside class="article-layout__aside" data-reveal="right">
					<div class="form-card">
						<h3 class="mt-0"><?php esc_html_e( 'Agende este estudio', 'cardio-canseco' ); ?></h3>
						<p class="lead" style="font-size:var(--fs-sm)">
							<?php esc_html_e( 'Escríbanos o llame y le confirmamos disponibilidad, preparación y costo.', 'cardio-canseco' ); ?>
						</p>

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
					$cardio_otros = get_posts(
						array(
							'post_type'      => 'procedimiento',
							'posts_per_page' => 8,
							'post__not_in'   => array( $cardio_id ),
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						)
					);
					if ( $cardio_otros ) :
						?>
						<div class="form-card mt-5">
							<h3 class="mt-0" style="font-size:var(--fs-md)"><?php esc_html_e( 'Otros procedimientos', 'cardio-canseco' ); ?></h3>
							<ul class="footer__list" style="gap:0.45rem">
								<?php foreach ( $cardio_otros as $cardio_otro ) : ?>
									<li><a href="<?php echo esc_url( get_permalink( $cardio_otro ) ); ?>"><?php echo esc_html( get_the_title( $cardio_otro ) ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</aside>

			</div>
		</div>
	</section>

	<?php if ( $cardio_faq ) : ?>
		<section class="section section--alt">
			<div class="wrap">
				<div class="faq-layout">
					<div class="faq-layout__head" data-reveal="left">
						<p class="eyebrow"><?php esc_html_e( 'Dudas comunes', 'cardio-canseco' ); ?></p>
						<?php
						$cardio_titulo_faq = function_exists( 'mb_strtolower' )
							? mb_strtolower( get_the_title(), 'UTF-8' )
							: get_the_title();
						?>
						<h2><?php echo esc_html( sprintf( __( 'Preguntas sobre %s', 'cardio-canseco' ), $cardio_titulo_faq ) ); ?></h2>
						<p class="lead">
							<?php esc_html_e( 'Si su duda no está aquí, escríbanos por WhatsApp o llame al consultorio: resolvemos por teléfono lo que se pueda resolver por teléfono.', 'cardio-canseco' ); ?>
						</p>
						<?php if ( cardio_opt( 'whatsapp' ) ) : ?>
							<p class="mt-5">
								<a class="btn btn--ghost" href="<?php echo esc_url( cardio_wa_url() ); ?>" target="_blank" rel="noopener">
									<?php cardio_icon_e( 'wa' ); ?> <?php esc_html_e( 'Preguntar por WhatsApp', 'cardio-canseco' ); ?>
								</a>
							</p>
						<?php endif; ?>
					</div>

					<div class="faq" data-faq data-reveal="right">
						<?php foreach ( $cardio_faq as $cardio_pair ) : ?>
							<details class="faq__item">
								<summary class="faq__q"><?php echo esc_html( $cardio_pair['q'] ); ?></summary>
								<div class="faq__a"><p><?php echo wp_kses_post( $cardio_pair['a'] ); ?></p></div>
							</details>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/cta' ); ?>

	<?php
endwhile;

get_footer();
