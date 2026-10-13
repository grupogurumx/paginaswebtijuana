<?php
/**
 * Formulario de búsqueda.
 *
 * @package CardioCanseco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="field" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="flex-direction:row;gap:0.6rem;align-items:stretch">
	<label class="sr-only" for="s-<?php echo esc_attr( uniqid() ); ?>"><?php esc_html_e( 'Buscar en el sitio', 'cardio-canseco' ); ?></label>
	<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="<?php esc_attr_e( 'Buscar…', 'cardio-canseco' ); ?>" required>
	<button class="btn btn--accent" type="submit"><?php esc_html_e( 'Buscar', 'cardio-canseco' ); ?></button>
</form>
