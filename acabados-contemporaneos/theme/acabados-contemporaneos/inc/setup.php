<?php
/**
 * Asistente de configuración: Apariencia → Configurar Acabados.
 *
 * 1. Importa las imágenes del sitio (descarga el ZIP o lo subes a mano).
 * 2. Asigna imágenes destacadas a las entradas del blog importadas.
 * 3. Crea menús ES/EN, fija la portada y los enlaces permanentes.
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Estructura de navegación (ruta de página => hijos).
 *
 * @param string $lang Idioma.
 * @return array
 */
function ac_nav_structure( $lang ) {
	if ( 'en' === $lang ) {
		return array(
			'en'               => array(),
			'en/about'         => array(),
			'en/products'      => array( 'en/products/porcelain-tile', 'en/products/ceramic-tile', 'en/products/wall-cladding', 'en/products/wood-look-tile', 'en/products/mosaic-tile', 'en/products/installation-accessories' ),
			'en/spaces'        => array(),
			'en/professionals' => array(),
			'en/blog'          => array(),
			'en/contact'       => array(),
		);
	}
	return array(
		'inicio'        => array(),
		'nosotros'      => array(),
		'productos'     => array( 'productos/porcelanicos', 'productos/ceramica', 'productos/recubrimientos-de-muro', 'productos/porcelanato-tipo-madera', 'productos/mosaicos', 'productos/accesorios-de-instalacion' ),
		'ambientes'     => array(),
		'profesionales' => array(),
		'blog'          => array(),
		'contacto'      => array(),
	);
}

/**
 * Menú de respaldo mientras no se crean los menús reales.
 *
 * @param array $args Argumentos de wp_nav_menu.
 */
function ac_fallback_menu( $args ) {
	$location  = isset( $args['theme_location'] ) ? $args['theme_location'] : '';
	$lang      = false !== strpos( $location, '_en' ) ? 'en' : 'es';
	$structure = ac_nav_structure( $lang );
	if ( 0 === strpos( $location, 'footer' ) ) {
		// En el pie: líneas de producto y aviso de privacidad, sin submenús.
		$products  = 'en' === $lang ? $structure['en/products'] : $structure['productos'];
		$structure = array_fill_keys( array_merge( $products, array( 'en' === $lang ? 'en/privacy-notice' : 'aviso-de-privacidad' ) ), array() );
	}
	echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
	foreach ( $structure as $path => $children ) {
		$page = get_page_by_path( $path );
		if ( ! $page ) {
			continue;
		}
		$has = $children ? ' menu-item-has-children' : '';
		echo '<li class="menu-item' . esc_attr( $has ) . '"><a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( get_the_title( $page ) ) . '</a>';
		if ( $children ) {
			echo '<ul class="sub-menu">';
			foreach ( $children as $child_path ) {
				$child = get_page_by_path( $child_path );
				if ( $child ) {
					echo '<li class="menu-item"><a href="' . esc_url( get_permalink( $child ) ) . '">' . esc_html( get_the_title( $child ) ) . '</a></li>';
				}
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Página del asistente.
 */
function ac_setup_menu() {
	add_theme_page( 'Configurar Acabados', 'Configurar Acabados', 'manage_options', 'ac-setup', 'ac_setup_page' );
}
add_action( 'admin_menu', 'ac_setup_menu' );

/**
 * Aviso mientras falte importar imágenes.
 */
function ac_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) || get_option( 'ac_image_map' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_ac-setup' === $screen->id ) {
		return;
	}
	echo '<div class="notice notice-info"><p><strong>Acabados Contemporáneos:</strong> termina la instalación en <a href="' . esc_url( admin_url( 'themes.php?page=ac-setup' ) ) . '">Apariencia → Configurar Acabados</a> para importar imágenes, menús y portada.</p></div>';
}
add_action( 'admin_notices', 'ac_setup_notice' );

/**
 * Render del asistente.
 */
function ac_setup_page() {
	$map    = get_option( 'ac_image_map', array() );
	$msg    = get_transient( 'ac_setup_msg' );
	delete_transient( 'ac_setup_msg' );
	$action = admin_url( 'admin-post.php' );
	?>
	<div class="wrap">
		<h1>Configurar Acabados Contemporáneos</h1>
		<?php if ( $msg ) : ?>
			<div class="notice notice-<?php echo esc_attr( $msg[0] ); ?>"><p><?php echo wp_kses_post( $msg[1] ); ?></p></div>
		<?php endif; ?>
		<p>Primero importa el archivo <code>wordpress-import/acabados-contemporaneos-wxr.xml</code> en <a href="<?php echo esc_url( admin_url( 'import.php' ) ); ?>">Herramientas → Importar → WordPress</a>. Después ejecuta estos pasos.</p>

		<h2>1. Imágenes del sitio</h2>
		<p>Estado: <strong><?php echo $map ? count( $map ) . ' imágenes importadas' : 'pendiente'; ?></strong> de <?php echo count( ac_image_catalog() ); ?>.</p>
		<form method="post" action="<?php echo esc_url( $action ); ?>" enctype="multipart/form-data">
			<?php wp_nonce_field( 'ac_setup' ); ?>
			<input type="hidden" name="action" value="ac_setup_images">
			<p><button class="button button-primary">Descargar e importar imágenes automáticamente</button></p>
			<p class="description">Si tu hosting bloquea descargas externas, sube aquí el ZIP de imágenes (<code>acabados-imagenes.zip</code>):</p>
			<p><input type="file" name="ac_zip" accept=".zip"> <button class="button" name="ac_manual" value="1">Subir ZIP e importar</button></p>
		</form>

		<h2>2. Menús, portada y enlaces permanentes</h2>
		<form method="post" action="<?php echo esc_url( $action ); ?>">
			<?php wp_nonce_field( 'ac_setup' ); ?>
			<input type="hidden" name="action" value="ac_setup_site">
			<p><button class="button button-primary">Configurar sitio</button></p>
			<p class="description">Crea los menús en español e inglés, fija «Inicio» como portada estática y usa enlaces permanentes <code>/%postname%/</code>.</p>
		</form>

		<h2>3. Datos del negocio</h2>
		<p>Completa teléfono, WhatsApp, dirección, horario y redes en <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=ac_business' ) ); ?>">Apariencia → Personalizar → Acabados Contemporáneos</a>. Se usan en el sitio y en los datos estructurados para Google.</p>
	</div>
	<?php
}

/**
 * Importa las imágenes del ZIP a la Biblioteca de medios.
 */
function ac_setup_images() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Sin permisos.' );
	}
	check_admin_referer( 'ac_setup' );

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	if ( ! empty( $_POST['ac_manual'] ) && ! empty( $_FILES['ac_zip']['tmp_name'] ) ) {
		$tmp = sanitize_text_field( $_FILES['ac_zip']['tmp_name'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	} else {
		$tmp = download_url( AC_IMAGES_ZIP, 180 );
	}
	if ( is_wp_error( $tmp ) ) {
		ac_setup_redirect( 'error', 'No se pudo descargar el ZIP: ' . esc_html( $tmp->get_error_message() ) . '. Súbelo manualmente.' );
	}

	WP_Filesystem();
	$uploads = wp_upload_dir();
	$dest    = trailingslashit( $uploads['basedir'] ) . 'acabados-contemporaneos';
	$result  = unzip_file( $tmp, $dest );
	if ( empty( $_POST['ac_manual'] ) ) {
		wp_delete_file( $tmp );
	}
	if ( is_wp_error( $result ) ) {
		ac_setup_redirect( 'error', 'No se pudo descomprimir: ' . esc_html( $result->get_error_message() ) );
	}

	$map   = get_option( 'ac_image_map', array() );
	$count = 0;
	foreach ( ac_image_catalog() as $slug => $alts ) {
		if ( ! empty( $map[ $slug ] ) && get_post( $map[ $slug ] ) ) {
			continue;
		}
		$file = $dest . '/webp/' . $slug . '.webp';
		if ( ! file_exists( $file ) ) {
			continue;
		}
		$id = wp_insert_attachment(
			array(
				'post_mime_type' => 'image/webp',
				'post_title'     => $alts[0],
				'post_name'      => 'ac-' . $slug,
				'post_status'    => 'inherit',
			),
			$file
		);
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		$meta = wp_generate_attachment_metadata( $id, $file );
		if ( $meta ) {
			wp_update_attachment_metadata( $id, $meta );
		}
		update_post_meta( $id, '_wp_attachment_image_alt', $alts[0] );
		$map[ $slug ] = $id;
		++$count;
	}
	update_option( 'ac_image_map', $map, false );

	$featured = ac_assign_featured_images();
	ac_setup_redirect( 'success', sprintf( 'Listo: %d imágenes nuevas en la Biblioteca de medios y %d imágenes destacadas asignadas.', $count, $featured ) );
}
add_action( 'admin_post_ac_setup_images', 'ac_setup_images' );

/**
 * Asigna la imagen destacada a las entradas que traen el meta `_ac_image`.
 *
 * @return int Entradas actualizadas.
 */
function ac_assign_featured_images() {
	$updated = 0;
	$posts   = get_posts(
		array(
			'post_type'      => array( 'post', 'page' ),
			'posts_per_page' => -1,
			'meta_key'       => '_ac_image', // phpcs:ignore WordPress.DB.SlowDBQuery
			'post_status'    => 'any',
		)
	);
	foreach ( $posts as $post ) {
		$id = ac_image_id( get_post_meta( $post->ID, '_ac_image', true ) );
		if ( $id && ! has_post_thumbnail( $post ) ) {
			set_post_thumbnail( $post, $id );
			++$updated;
		}
	}
	return $updated;
}

/**
 * Menús, portada y enlaces permanentes.
 */
function ac_setup_site() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Sin permisos.' );
	}
	check_admin_referer( 'ac_setup' );

	$front = get_page_by_path( 'inicio' );
	if ( $front ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front->ID );
	}

	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	update_option( 'blogdescription', 'Recubrimientos, cerámica y porcelanato en México' );

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$menus     = array(
		'primary_es' => array( 'Principal (ES)', ac_nav_structure( 'es' ) ),
		'primary_en' => array( 'Main (EN)', ac_nav_structure( 'en' ) ),
		'footer_es'  => array( 'Pie (ES)', array_fill_keys( array_merge( ac_nav_structure( 'es' )['productos'], array( 'aviso-de-privacidad' ) ), array() ) ),
		'footer_en'  => array( 'Footer (EN)', array_fill_keys( array_merge( ac_nav_structure( 'en' )['en/products'], array( 'en/privacy-notice' ) ), array() ) ),
	);
	foreach ( $menus as $location => $menu ) {
		list( $name, $structure ) = $menu;
		$existing = wp_get_nav_menu_object( $name );
		if ( $existing ) {
			wp_delete_nav_menu( $existing->term_id );
		}
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			continue;
		}
		foreach ( $structure as $path => $children ) {
			$page = get_page_by_path( $path );
			if ( ! $page ) {
				continue;
			}
			$parent_item = wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-object-id' => $page->ID,
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);
			foreach ( $children as $child_path ) {
				$child = get_page_by_path( $child_path );
				if ( $child ) {
					wp_update_nav_menu_item(
						$menu_id,
						0,
						array(
							'menu-item-object-id' => $child->ID,
							'menu-item-object'    => 'page',
							'menu-item-type'      => 'post_type',
							'menu-item-parent-id' => $parent_item,
							'menu-item-status'    => 'publish',
						)
					);
				}
			}
		}
		$locations[ $location ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $locations );
	flush_rewrite_rules();

	ac_setup_redirect( 'success', 'Sitio configurado: portada, menús ES/EN y enlaces permanentes listos.' );
}
add_action( 'admin_post_ac_setup_site', 'ac_setup_site' );

/**
 * Redirección con mensaje.
 *
 * @param string $type success|error.
 * @param string $text Mensaje.
 */
function ac_setup_redirect( $type, $text ) {
	set_transient( 'ac_setup_msg', array( $type, $text ), 60 );
	wp_safe_redirect( admin_url( 'themes.php?page=ac-setup' ) );
	exit;
}

/**
 * Al activar el tema, llevar al asistente.
 */
function ac_after_switch_theme() {
	set_transient( 'ac_setup_redirect', 1, 30 );
}
add_action( 'after_switch_theme', 'ac_after_switch_theme' );

/**
 * Redirección única al asistente tras activar.
 */
function ac_maybe_redirect_setup() {
	if ( get_transient( 'ac_setup_redirect' ) && current_user_can( 'manage_options' ) && ! wp_doing_ajax() ) {
		delete_transient( 'ac_setup_redirect' );
		wp_safe_redirect( admin_url( 'themes.php?page=ac-setup' ) );
		exit;
	}
}
add_action( 'admin_init', 'ac_maybe_redirect_setup' );
