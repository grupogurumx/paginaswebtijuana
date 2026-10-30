<?php
/**
 * Formulario de búsqueda.
 *
 * @package Acabados
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s-main"><?php ac_e( 'search' ); ?></label>
	<input id="s-main" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( ac_t( 'search_ph' ) ); ?>">
	<?php if ( 'en' === ac_lang() ) : ?><input type="hidden" name="lang" value="en"><?php endif; ?>
	<button type="submit" class="ac-btn ac-btn--solid"><?php ac_e( 'search' ); ?></button>
</form>
