<?php
/**
 * Reusable sections, available as shortcodes inside imported pages:
 * [dmc_financing] [dmc_lead_form] [dmc_reviews] [dmc_faq] [dmc_cta] [dmc_procedures] [dmc_logos]
 */

defined( 'ABSPATH' ) || exit;

/** Procedure cards. $dark toggles the card style. */
function dmc_procedures_html( $dark = true ) {
	$cards = array(
		array( 'sleeve', '◐', dmc_t( 'nav_sleeve' ), dmc_t( 'sleeve_text' ), dmc_t( 'meta_loss' ), '25–30%', dmc_t( 'meta_stay' ), dmc_t( 'meta_lap' ) ),
		array( 'bypass', '⟲', dmc_t( 'nav_bypass' ), dmc_t( 'bypass_text' ), dmc_t( 'meta_loss' ), '30–32%', dmc_t( 'meta_stay' ), dmc_t( 'meta_lap' ) ),
		array( 'revision', '↻', dmc_t( 'nav_revision' ), dmc_t( 'revision_text' ), dmc_t( 'meta_ideal' ), dmc_t( 'meta_regain' ), dmc_t( 'meta_eval' ), dmc_t( 'meta_individual' ) ),
		array( 'metabolic', '✚', dmc_t( 'nav_metabolic' ), dmc_t( 'metabolic_text' ), dmc_t( 'meta_approach' ), dmc_t( 'meta_medical' ), dmc_t( 'meta_eval' ), dmc_t( 'meta_individual' ) ),
	);
	$out = '<div class="cards">';
	foreach ( $cards as $i => $c ) {
		$out .= sprintf(
			'<a href="%1$s" class="card3d%9$s reveal" data-delay="%10$d" data-tilt><span class="card3d__icon" aria-hidden="true">%2$s</span><h3>%3$s</h3><p>%4$s</p><div class="card3d__meta"><span>%5$s<b>%6$s</b></span><span>%7$s<b>%8$s</b></span></div><span class="card3d__link">%11$s</span></a>',
			esc_url( dmc_page_url( $c[0] ) ),
			esc_html( $c[1] ),
			esc_html( $c[2] ),
			esc_html( $c[3] ),
			esc_html( $c[4] ),
			esc_html( $c[5] ),
			esc_html( $c[6] ),
			esc_html( $c[7] ),
			$dark ? '' : ' card3d--light',
			$i + 1,
			esc_html( dmc_t( 'cta_learn' ) )
		);
	}
	return $out . '</div>';
}

/** Financing block with the embedded Typeform. */
function dmc_financing_html() {
	$url  = dmc_opt( 'dmc_typeform' );
	$lang = dmc_lang();
	$src  = add_query_arg( array( 'typeform-embed' => 'embed-widget', 'embed-hide-headers' => 'true', 'lang' => $lang ), $url );
	ob_start();
	?>
	<div class="financing" id="financing">
		<div class="reveal reveal--left">
			<span class="eyebrow"><?php echo esc_html( dmc_t( 'fin_eyebrow' ) ); ?></span>
			<h2><?php echo wp_kses_post( dmc_t( 'fin_title' ) ); ?></h2>
			<p class="lead"><?php echo esc_html( dmc_t( 'fin_lead' ) ); ?></p>
			<div class="financing__perks">
				<?php foreach ( array( array( '⚡', 1 ), array( '◷', 2 ), array( '🔒', 3 ) ) as $p ) : ?>
					<div class="perk"><span class="perk__icon" aria-hidden="true"><?php echo esc_html( $p[0] ); ?></span><div><h4><?php echo esc_html( dmc_t( 'fin_p' . $p[1] . '_t' ) ); ?></h4><p><?php echo esc_html( dmc_t( 'fin_p' . $p[1] . '_d' ) ); ?></p></div></div>
				<?php endforeach; ?>
			</div>
			<a class="btn btn--gold" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" data-track="financing_click"><?php echo esc_html( dmc_t( 'cta_financing' ) ); ?></a>
		</div>
		<div class="typeform-frame reveal reveal--right">
			<div class="typeform-frame__head"><span><b>●</b> <?php echo esc_html( dmc_t( 'fin_form_head' ) ); ?></span><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" style="color:#fff;font-size:.85rem"><?php echo esc_html( dmc_t( 'fin_open' ) ); ?> ↗</a></div>
			<iframe src="<?php echo esc_url( $src ); ?>" title="<?php echo esc_attr( dmc_t( 'fin_form_head' ) ); ?>" loading="lazy" allow="camera; microphone; autoplay; encrypted-media; fullscreen"></iframe>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/** Lead form (posts to admin-post.php, handled in inc/setup.php). */
function dmc_lead_form_html() {
	$status = isset( $_GET['dmc_lead'] ) ? sanitize_key( wp_unslash( $_GET['dmc_lead'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	ob_start();
	if ( 'ok' === $status ) {
		echo '<div class="form-notice form-notice--ok" role="status">' . esc_html( dmc_t( 'f_ok' ) ) . '</div>';
	} elseif ( 'error' === $status ) {
		echo '<div class="form-notice form-notice--err" role="alert">' . esc_html( dmc_t( 'f_err' ) ) . '</div>';
	}
	?>
	<form class="lead-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-track="lead_submit">
		<input type="hidden" name="action" value="dmc_lead">
		<input type="hidden" name="lang" value="<?php echo esc_attr( dmc_lang() ); ?>">
		<input type="hidden" name="source" value="<?php echo esc_url( dmc_current_url() ); ?>">
		<?php wp_nonce_field( 'dmc_lead', 'dmc_nonce' ); ?>
		<label class="hp" aria-hidden="true">Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
		<label class="screen-reader-text" for="dmc-name"><?php echo esc_html( dmc_t( 'f_name' ) ); ?></label>
		<input id="dmc-name" name="name" required placeholder="<?php echo esc_attr( dmc_t( 'f_name' ) ); ?>" autocomplete="name">
		<label class="screen-reader-text" for="dmc-email"><?php echo esc_html( dmc_t( 'f_email' ) ); ?></label>
		<input id="dmc-email" type="email" name="email" required placeholder="<?php echo esc_attr( dmc_t( 'f_email' ) ); ?>" autocomplete="email">
		<label class="screen-reader-text" for="dmc-phone"><?php echo esc_html( dmc_t( 'f_phone' ) ); ?></label>
		<input id="dmc-phone" type="tel" name="phone" required placeholder="<?php echo esc_attr( dmc_t( 'f_phone' ) ); ?>" autocomplete="tel">
		<label class="screen-reader-text" for="dmc-proc"><?php echo esc_html( dmc_t( 'f_proc' ) ); ?></label>
		<select id="dmc-proc" name="procedure">
			<option value=""><?php echo esc_html( dmc_t( 'f_proc' ) ); ?></option>
			<?php foreach ( array( 'sleeve', 'bypass', 'revision', 'metabolic' ) as $k ) : ?>
				<option><?php echo esc_html( dmc_t( 'nav_' . $k ) ); ?></option>
			<?php endforeach; ?>
			<option><?php echo esc_html( dmc_t( 'f_proc_unsure' ) ); ?></option>
		</select>
		<label class="screen-reader-text" for="dmc-height"><?php echo esc_html( dmc_t( 'f_height' ) ); ?></label>
		<input id="dmc-height" name="height" placeholder="<?php echo esc_attr( dmc_t( 'f_height' ) ); ?>">
		<label class="screen-reader-text" for="dmc-weight"><?php echo esc_html( dmc_t( 'f_weight' ) ); ?></label>
		<input id="dmc-weight" name="weight" placeholder="<?php echo esc_attr( dmc_t( 'f_weight' ) ); ?>">
		<label class="screen-reader-text" for="dmc-msg"><?php echo esc_html( dmc_t( 'f_msg' ) ); ?></label>
		<textarea id="dmc-msg" class="full" name="message" rows="3" placeholder="<?php echo esc_attr( dmc_t( 'f_msg' ) ); ?>"></textarea>
		<div class="full"><button class="btn btn--gold" type="submit"><?php echo esc_html( dmc_t( 'f_send' ) ); ?></button></div>
		<p class="full lead-form__note"><?php echo esc_html( dmc_t( 'f_consent' ) ); ?> <a href="<?php echo esc_url( dmc_page_url( 'privacy' ) ); ?>"><?php echo esc_html( dmc_t( 'nav_privacy' ) ); ?></a></p>
	</form>
	<?php
	return ob_get_clean();
}

/** Contact CTA band with the lead form. */
function dmc_cta_html() {
	$wa = dmc_whatsapp_url( dmc_t( 'cta_schedule' ) );
	ob_start();
	?>
	<div class="cta-band reveal reveal--zoom" id="contact-form">
		<div class="split" style="align-items:start">
			<div>
				<span class="eyebrow"><?php echo esc_html( dmc_t( 'cta_eyebrow' ) ); ?></span>
				<h2><?php echo wp_kses_post( dmc_t( 'cta_title' ) ); ?></h2>
				<p style="color:#b9c5e0"><?php echo esc_html( dmc_t( 'cta_text' ) ); ?></p>
				<?php if ( $wa ) : ?>
					<a class="btn btn--ghost" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" data-track="whatsapp_click"><?php echo esc_html( dmc_t( 'cta_whatsapp' ) ); ?></a>
				<?php endif; ?>
			</div>
			<div><?php echo dmc_lead_form_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/** Reviews: Google link plus any reviews pasted into reviews.json. */
function dmc_reviews_html() {
	$lang    = dmc_lang();
	$reviews = array();
	$file    = DMC_DIR . '/reviews.json';
	if ( file_exists( $file ) ) {
		$data = json_decode( (string) file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( is_array( $data ) ) {
			$reviews = array_filter(
				$data,
				function ( $r ) use ( $lang ) {
					return ! empty( $r['text'] ) && ( empty( $r['lang'] ) || $r['lang'] === $lang || 'any' === $r['lang'] );
				}
			);
		}
	}
	$rating = dmc_opt( 'dmc_rating' );
	$count  = dmc_opt( 'dmc_rating_count' );
	ob_start();
	?>
	<div class="center">
		<a class="google-badge reveal" href="<?php echo esc_url( dmc_opt( 'dmc_reviews_url' ) ); ?>" target="_blank" rel="noopener">
			<svg width="34" height="34" viewBox="0 0 48 48" aria-hidden="true"><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/><path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/><path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-7.9l-6.5 5C9.5 39.6 16.2 44 24 44z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C37 39.2 44 34 44 24c0-1.3-.1-2.4-.4-3.5z"/></svg>
			<?php if ( $rating ) : ?>
				<strong><?php echo esc_html( $rating ); ?></strong>
				<span><span class="review__stars">★★★★★</span><br><?php echo esc_html( $count ? $count . ' reviews' : '' ); ?></span>
			<?php else : ?>
				<span style="font-weight:700"><?php echo esc_html( dmc_t( 'rev_google' ) ); ?> →</span>
			<?php endif; ?>
		</a>
	</div>
	<?php if ( $reviews ) : ?>
		<div class="reviews">
			<?php foreach ( array_slice( $reviews, 0, 6 ) as $i => $r ) : ?>
				<figure class="review reveal" data-delay="<?php echo (int) ( $i % 3 ) + 1; ?>">
					<div class="review__stars" aria-label="<?php echo (int) ( $r['rating'] ?? 5 ); ?>/5"><?php echo esc_html( str_repeat( '★', (int) ( $r['rating'] ?? 5 ) ) ); ?></div>
					<blockquote class="review__text"><?php echo esc_html( $r['text'] ); ?></blockquote>
					<figcaption class="review__author"><?php echo esc_html( $r['name'] ?? '' ); ?></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}

/** FAQ accordion. */
function dmc_faq_html() {
	$out = '<div class="faq">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$out .= sprintf( '<details class="reveal"%s><summary>%s</summary><p>%s</p></details>', 1 === $i ? ' open' : '', esc_html( dmc_t( "faq{$i}_q" ) ), esc_html( dmc_t( "faq{$i}_a" ) ) );
	}
	return $out . '</div>';
}

/** Partner / hospital / insurer logos dropped into assets/img/logos/. */
function dmc_logos_html() {
	$files = glob( DMC_DIR . '/assets/img/logos/*.{png,jpg,jpeg,svg,webp}', GLOB_BRACE );
	if ( ! $files ) {
		return '';
	}
	$out = '<div class="logos">';
	foreach ( $files as $f ) {
		$name = ucwords( str_replace( array( '-', '_' ), ' ', pathinfo( $f, PATHINFO_FILENAME ) ) );
		$out .= sprintf( '<img src="%s" alt="%s" loading="lazy">', esc_url( DMC_URI . '/assets/img/logos/' . basename( $f ) ), esc_attr( $name ) );
	}
	return $out . '</div>';
}

add_shortcode( 'dmc_financing', 'dmc_financing_html' );
add_shortcode( 'dmc_lead_form', 'dmc_lead_form_html' );
add_shortcode( 'dmc_cta', 'dmc_cta_html' );
add_shortcode( 'dmc_reviews', 'dmc_reviews_html' );
add_shortcode( 'dmc_faq', 'dmc_faq_html' );
add_shortcode( 'dmc_logos', 'dmc_logos_html' );
add_shortcode( 'dmc_procedures', fn() => dmc_procedures_html( false ) );
