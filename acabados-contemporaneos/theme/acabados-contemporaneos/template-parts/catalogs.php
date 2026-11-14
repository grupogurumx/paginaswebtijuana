<?php
/**
 * Tarjetas de catálogos con «Ver» y «Descargar».
 *
 * Variable opcional $args['limit'] (get_template_part con args).
 *
 * @package Acabados
 */

$ac_en    = 'en' === ac_lang();
$ac_limit = isset( $args['limit'] ) ? (int) $args['limit'] : 0;
$ac_cats  = ac_catalogs();
if ( $ac_limit ) {
	$ac_cats = array_slice( $ac_cats, 0, $ac_limit );
}
?>
<div class="catalogs">
	<?php foreach ( $ac_cats as $k => $c ) : ?>
		<?php list( $img, $title, $brand, $tag_es, $tag_en, $urls ) = $c; ?>
		<article class="catalog-card" data-reveal style="--d:<?php echo (int) $k; ?>">
			<a class="catalog-card__cover" href="<?php echo esc_url( $urls[0] ); ?>" target="_blank" rel="noopener" tabindex="-1" aria-hidden="true">
				<?php echo ac_img( $img, array( 'size' => 'ac-card', 'sizes' => '(min-width: 1000px) 25vw, 50vw', 'alt' => $title ) ); // phpcs:ignore ?>
			</a>
			<div class="catalog-card__body">
				<p class="catalog-card__meta"><span><?php echo esc_html( $brand ); ?></span><span><?php echo esc_html( $ac_en ? $tag_en : $tag_es ); ?></span></p>
				<h3 class="catalog-card__title"><?php echo esc_html( $title ); ?></h3>
				<div class="catalog-card__actions">
					<a class="ac-btn ac-btn--solid ac-btn--sm" href="<?php echo esc_url( $urls[0] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $ac_en ? 'View' : 'Ver' ); ?></a>
					<a class="ac-btn ac-btn--sm ac-btn--outline" href="<?php echo esc_url( $urls[1] ); ?>" target="_blank" rel="noopener" download><?php echo esc_html( $ac_en ? 'Download' : 'Descargar' ); ?></a>
				</div>
			</div>
		</article>
	<?php endforeach; ?>
</div>
