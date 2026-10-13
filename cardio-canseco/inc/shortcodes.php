<?php
/**
 * Shortcodes del tema.
 *
 * Permiten insertar el formulario de cita, los datos de contacto y el mapa
 * dentro del contenido de cualquier página desde el editor de WordPress.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [cardio_formulario_cita]
 * Formulario de solicitud de cita.
 */
function cardio_sc_formulario() {
	$procs = get_posts(
		array(
			'post_type'      => 'procedimiento',
			'posts_per_page' => 20,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);

	ob_start();
	?>
	<form class="form-card" method="post" data-form novalidate>
		<?php wp_nonce_field( 'cardio_cita', 'cardio_nonce' ); ?>
		<input type="hidden" name="cardio_form" value="1">

		<p style="position:absolute;left:-9999px" aria-hidden="true">
			<label for="cardio_website"><?php esc_html_e( 'No rellene este campo', 'cardio-canseco' ); ?></label>
			<input type="text" id="cardio_website" name="cardio_website" tabindex="-1" autocomplete="off">
		</p>

		<div class="form-row">
			<div class="field">
				<label for="cardio-nombre"><?php esc_html_e( 'Nombre completo', 'cardio-canseco' ); ?> <span class="req">*</span></label>
				<input type="text" id="cardio-nombre" name="nombre" autocomplete="name" required>
			</div>
			<div class="field">
				<label for="cardio-telefono"><?php esc_html_e( 'Teléfono', 'cardio-canseco' ); ?> <span class="req">*</span></label>
				<input type="tel" id="cardio-telefono" name="telefono" autocomplete="tel" required>
			</div>
		</div>

		<div class="field">
			<label for="cardio-email"><?php esc_html_e( 'Correo electrónico', 'cardio-canseco' ); ?></label>
			<input type="email" id="cardio-email" name="email" autocomplete="email">
		</div>

		<div class="field">
			<label for="cardio-estudio"><?php esc_html_e( 'Motivo o estudio de interés', 'cardio-canseco' ); ?></label>
			<select id="cardio-estudio" name="estudio">
				<option value="<?php esc_attr_e( 'Consulta cardiológica general', 'cardio-canseco' ); ?>"><?php esc_html_e( 'Consulta cardiológica general', 'cardio-canseco' ); ?></option>
				<?php foreach ( $procs as $proc ) : ?>
					<option value="<?php echo esc_attr( get_the_title( $proc ) ); ?>"><?php echo esc_html( get_the_title( $proc ) ); ?></option>
				<?php endforeach; ?>
				<option value="<?php esc_attr_e( 'No estoy seguro', 'cardio-canseco' ); ?>"><?php esc_html_e( 'No estoy seguro, necesito orientación', 'cardio-canseco' ); ?></option>
			</select>
		</div>

		<div class="field">
			<label for="cardio-fecha"><?php esc_html_e( 'Fecha preferida', 'cardio-canseco' ); ?></label>
			<input type="date" id="cardio-fecha" name="fecha">
		</div>

		<div class="field">
			<label for="cardio-mensaje"><?php esc_html_e( 'Cuéntenos brevemente su caso', 'cardio-canseco' ); ?></label>
			<textarea id="cardio-mensaje" name="mensaje" rows="5" placeholder="<?php esc_attr_e( 'Síntomas, desde cuándo, estudios previos…', 'cardio-canseco' ); ?>"></textarea>
		</div>

		<label class="field-consent">
			<input type="checkbox" name="consent" required>
			<span>
				<?php
				$aviso = get_page_by_path( 'aviso-de-privacidad' );
				if ( $aviso ) {
					printf(
						/* translators: %s: enlace al aviso de privacidad. */
						esc_html__( 'He leído y acepto el %s y autorizo el tratamiento de mis datos para ser contactado.', 'cardio-canseco' ),
						'<a href="' . esc_url( get_permalink( $aviso ) ) . '">' . esc_html__( 'aviso de privacidad', 'cardio-canseco' ) . '</a>'
					);
				} else {
					esc_html_e( 'Autorizo el tratamiento de mis datos para ser contactado.', 'cardio-canseco' );
				}
				?>
				<span class="req">*</span>
			</span>
		</label>

		<button class="btn btn--accent btn--block btn--lg" type="submit"><?php esc_html_e( 'Enviar solicitud', 'cardio-canseco' ); ?></button>

		<p class="form-note">
			<?php esc_html_e( 'No comparta información médica sensible por este medio. Los datos se usan únicamente para contactarle y agendar su cita.', 'cardio-canseco' ); ?>
		</p>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cardio_formulario_cita', 'cardio_sc_formulario' );

/**
 * [cardio_contacto]
 * Lista con los datos de contacto del consultorio.
 */
function cardio_sc_contacto() {
	ob_start();
	?>
	<ul class="info-list">
		<li>
			<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'pin' ); ?></span>
			<span>
				<span class="info-list__label"><?php esc_html_e( 'Dirección', 'cardio-canseco' ); ?></span>
				<span class="info-list__value">
					<?php echo esc_html( cardio_opt( 'calle' ) ); ?><br>
					<?php echo esc_html( cardio_opt( 'calle2' ) ); ?><br>
					<?php echo esc_html( cardio_opt( 'cp' ) . ' ' . cardio_opt( 'ciudad' ) . ', ' . cardio_opt( 'estado' ) ); ?>
				</span>
			</span>
		</li>
		<li>
			<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'phone' ); ?></span>
			<span>
				<span class="info-list__label"><?php esc_html_e( 'Teléfono', 'cardio-canseco' ); ?></span>
				<span class="info-list__value"><a href="<?php echo esc_url( cardio_tel_url() ); ?>"><?php cardio_e( 'tel' ); ?></a></span>
			</span>
		</li>
		<?php if ( cardio_opt( 'whatsapp' ) ) : ?>
			<li>
				<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'wa' ); ?></span>
				<span>
					<span class="info-list__label">WhatsApp</span>
					<span class="info-list__value"><a href="<?php echo esc_url( cardio_wa_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Enviar mensaje', 'cardio-canseco' ); ?></a></span>
				</span>
			</li>
		<?php endif; ?>
		<?php if ( cardio_opt( 'email' ) ) : ?>
			<li>
				<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'mail' ); ?></span>
				<span>
					<span class="info-list__label"><?php esc_html_e( 'Correo', 'cardio-canseco' ); ?></span>
					<span class="info-list__value"><a href="mailto:<?php echo esc_attr( cardio_opt( 'email' ) ); ?>"><?php cardio_e( 'email' ); ?></a></span>
				</span>
			</li>
		<?php endif; ?>
		<?php if ( cardio_opt( 'horario' ) ) : ?>
			<li>
				<span class="info-list__icon" aria-hidden="true"><?php cardio_icon_e( 'clock' ); ?></span>
				<span>
					<span class="info-list__label"><?php esc_html_e( 'Atención', 'cardio-canseco' ); ?></span>
					<span class="info-list__value"><?php echo esc_html( cardio_opt( 'horario' ) ); ?></span>
				</span>
			</li>
		<?php endif; ?>
	</ul>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cardio_contacto', 'cardio_sc_contacto' );

/**
 * [cardio_mapa]
 * Mapa embebido con botón «Cómo llegar».
 */
function cardio_sc_mapa() {
	ob_start();
	?>
	<div class="map-embed">
		<iframe
			title="<?php esc_attr_e( 'Ubicación del consultorio en Google Maps', 'cardio-canseco' ); ?>"
			src="<?php echo esc_url( cardio_maps_embed() ); ?>"
			loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
	</div>
	<p class="mt-5">
		<a class="btn btn--ghost btn--block" href="<?php echo esc_url( cardio_maps_url() ); ?>" target="_blank" rel="noopener">
			<?php esc_html_e( 'Cómo llegar', 'cardio-canseco' ); ?>
			<?php cardio_icon_e( 'ext' ); ?>
		</a>
	</p>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cardio_mapa', 'cardio_sc_mapa' );

/**
 * [cardio_procedimientos]
 * Parrilla con todos los procedimientos publicados.
 */
function cardio_sc_procedimientos( $atts ) {
	$atts = shortcode_atts( array( 'cantidad' => 8 ), $atts, 'cardio_procedimientos' );

	$q = new WP_Query(
		array(
			'post_type'      => 'procedimiento',
			'posts_per_page' => (int) $atts['cantidad'],
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);

	if ( ! $q->have_posts() ) {
		return '';
	}

	ob_start();
	echo '<div class="proc-grid" data-reveal-group>';
	while ( $q->have_posts() ) {
		$q->the_post();
		get_template_part( 'template-parts/proc-card' );
	}
	echo '</div>';
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'cardio_procedimientos', 'cardio_sc_procedimientos' );

/**
 * [cardio_formacion] · [cardio_sociedades]
 * Fichas con los logotipos de las instituciones donde se formó el médico
 * y de las sociedades a las que pertenece.
 */
function cardio_sc_formacion() {
	return cardio_instituciones( 'formacion' );
}
add_shortcode( 'cardio_formacion', 'cardio_sc_formacion' );

function cardio_sc_sociedades() {
	return cardio_instituciones( 'sociedades' );
}
add_shortcode( 'cardio_sociedades', 'cardio_sc_sociedades' );

/**
 * [cardio_foto_medico variante="retrato"]
 * Inserta la fotografía del especialista dentro del contenido.
 */
function cardio_sc_foto_medico( $atts ) {
	$atts = shortcode_atts( array( 'variante' => 'retrato' ), $atts, 'cardio_foto_medico' );

	$img = cardio_foto_medico( $atts['variante'], 'retrato-aside' );
	if ( ! $img ) {
		return '';
	}

	return '<figure class="retrato-marco">' . $img . '</figure>';
}
add_shortcode( 'cardio_foto_medico', 'cardio_sc_foto_medico' );

/**
 * [cardio_avales]
 * Franja con los logotipos de las sociedades médicas.
 */
function cardio_sc_avales() {
	$avales = array(
		'aval-consejomexicanocardiologia.png' => 'Consejo Mexicano de Cardiología',
		'aval-cardiologosdemexico.png'        => 'Asociación Nacional de Cardiólogos de México',
		'aval-scbc.png'                       => 'Sociedad de Cardiología de Baja California',
		'aval-esc.png'                        => 'European Society of Cardiology',
	);

	$out = '<div class="trust__logos" style="justify-content:center;margin-block:2rem">';
	foreach ( $avales as $file => $alt ) {
		$out .= sprintf(
			'<img src="%s" alt="%s" width="400" height="250" loading="lazy" decoding="async">',
			esc_url( CARDIO_URI . '/assets/img/' . $file ),
			esc_attr( $alt )
		);
	}
	$out .= '</div>';

	return $out;
}
add_shortcode( 'cardio_avales', 'cardio_sc_avales' );
