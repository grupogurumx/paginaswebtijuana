<?php
/**
 * Formulario de búsqueda.
 *
 * @package WebmasterTijuana
 */

$uid = wp_unique_id( 'buscar-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Buscar', 'webmaster-tijuana' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $uid ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Buscar en el sitio…', 'webmaster-tijuana' ); ?>">
	<button type="submit" class="btn btn--primary"><?php echo wmt_icon( 'search' ); // phpcs:ignore ?><span class="screen-reader-text"><?php esc_html_e( 'Buscar', 'webmaster-tijuana' ); ?></span></button>
</form>
