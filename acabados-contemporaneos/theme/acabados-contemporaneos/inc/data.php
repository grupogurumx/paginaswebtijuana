<?php
/**
 * Datos del negocio: sucursales, catálogos y marcas.
 *
 * Fuente: sitio actual acabadoscontemporaneos.com (sucursales y catálogos)
 * y sitios oficiales de Porcelanite (catálogos vigentes).
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sucursales agrupadas por ciudad.
 *
 * @return array ciudad => [ estado, [ [nombre, dirección, colonia, teléfonos[]], ... ] ]
 */
function ac_branches() {
	return array(
		'Tijuana'               => array(
			'Baja California',
			array(
				array( 'Acabados Contemporáneos', 'Vía Juventud #1 Oriente, esq. Privada Monterrey', 'Col. Mineral de Santa Fe', array( '(664) 683 3965', '(664) 624 9189' ) ),
				array( 'Acabados Contemporáneos', 'Ruta Matamoros #10690, esq. Camino Constitución', 'Fracc. Mariano Matamoros', array( '(664) 629 8771' ) ),
				array( 'Acabados Contemporáneos', 'Blvd. Salinas #11131', 'Fracc. Aviación', array( '(664) 681 8853', '(664) 681 8620' ) ),
				array( 'Tijuana Ceramic Tile', 'Blvd. Salinas #11294', 'Fracc. Aviación', array( '(664) 681 7159', '(664) 681 8873' ) ),
				array( 'Italica Tile', 'Blvd. Salinas #11264', 'Fracc. Aviación', array( '(664) 686 4475', '(664) 681 8087' ) ),
				array( 'Pisos y Azulejos de Tijuana', 'Ruta Independencia #5005', 'Col. Américas', array( '(664) 972 7370' ) ),
			),
		),
		'Mexicali'              => array(
			'Baja California',
			array(
				array( 'Acabados Contemporáneos', 'Blvd. Lázaro Cárdenas #1000', 'Fracc. Las Flores', array( '(686) 556 8366', '(686) 556 8367' ) ),
				array( 'Baños y Recubrimientos de Mexicali', 'Blvd. Lázaro Cárdenas #637', 'Ex-Ejido Coahuila', array( '(686) 566 0767', '(686) 566 1590' ) ),
				array( 'Mexicali Ceramic Tile', 'Calzada Justo Sierra #5, esq. Costa Rica', 'Col. Cuauhtémoc Norte', array( '(686) 582 2288' ) ),
			),
		),
		'Ensenada'              => array(
			'Baja California',
			array(
				array( 'Acabados Contemporáneos', 'Av. Juárez #2148-4, esq. Av. Reforma y Calzada Cortez', 'Col. Obrera', array( '(646) 172 4759', '(646) 172 4784' ) ),
				array( 'Ensenada Ceramic Tile', 'Carretera Transpeninsular #241', 'Fracc. Valle Dorado', array( '(646) 173 9794', '(646) 173 9796' ) ),
			),
		),
		'Tecate'                => array(
			'Baja California',
			array(
				array( 'Tecate Ceramic Tile', 'Av. Juárez #690', 'Col. Centro', array( '(665) 654 3898' ) ),
			),
		),
		'San Luis Río Colorado' => array(
			'Sonora',
			array(
				array( 'Acabados Contemporáneos', 'Av. Libertad y Calle 7, Locales 2, 3 y 4 (Plaza Bonita)', 'Col. Comercial', array( '(653) 534 4183', '(653) 534 3864' ) ),
			),
		),
		'Culiacán'              => array(
			'Sinaloa',
			array(
				array( 'Acabados Contemporáneos', 'Ignacio Ramírez #849', 'Col. Jorge Almada', array( '(667) 715 9550', '(667) 715 9573' ) ),
			),
		),
		'Ciudad Juárez'         => array(
			'Chihuahua',
			array(
				array( 'Juárez Ceramic Tile', 'Av. Ejército Nacional #5225', 'Col. Jardines de San José', array( '(656) 613 5441', '(656) 613 5442' ) ),
			),
		),
	);
}

/**
 * Número total de sucursales.
 *
 * @return int
 */
function ac_branch_count() {
	$n = 0;
	foreach ( ac_branches() as $city ) {
		$n += count( $city[1] );
	}
	return $n;
}

/**
 * Enlace de Google Maps para una dirección.
 *
 * @param array  $b    Sucursal.
 * @param string $city Ciudad.
 * @param string $st   Estado.
 * @return string
 */
function ac_branch_map_url( $b, $city, $st ) {
	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $b[0] . ', ' . $b[1] . ', ' . $b[2] . ', ' . $city . ', ' . $st );
}

/**
 * Catálogos descargables.
 *
 * @return array [ slug-imagen, título, marca, etiqueta ES, etiqueta EN, url ver, url descargar ]
 */
function ac_catalogs() {
	$drive = function ( $id ) {
		return array( 'https://drive.google.com/file/d/' . $id . '/view', 'https://drive.google.com/uc?export=download&id=' . $id );
	};
	$p     = 'https://porcelanite.com.mx/wp-content/uploads/';
	$list  = array(
		array( 'catalogo-porcelanite-np2027', 'Nuevos Productos 2027', 'Porcelanite', 'Lanzamientos', 'New releases', array( $p . 'Catalogo-Porcelanite-NP2027-WEB-x-spreads-1.pdf', $p . 'Catalogo-Porcelanite-NP2027-WEB-x-spreads-1.pdf' ) ),
		array( 'catalogo-porcelanite-general-2026', 'Catálogo General 2026', 'Porcelanite', 'General', 'General', array( $p . 'Catalogo-General-Porcelanite-2026-30x23-cm-OK-con-BLUR-Spreads.pdf', $p . 'Catalogo-General-Porcelanite-2026-30x23-cm-OK-con-BLUR-Spreads.pdf' ) ),
		array( 'catalogo-porcelanite-porcelanato-2025', 'Porcelanato · Porcelánicos Nacionales 2025', 'Porcelanite', 'Porcelánicos', 'Porcelain', array( $p . 'Porcelanato.-Porcelanicos-Nacionales-2025_compressed.pdf', $p . 'Porcelanato.-Porcelanicos-Nacionales-2025_compressed.pdf' ) ),
		array( 'catalogo-porcelanite-2019', 'Catálogo Porcelanite 2019', 'Porcelanite', 'Archivo', 'Archive', $drive( '1ud9xKSpPdPwKTFaEtbPQKy_NRyJVjVr-' ) ),
		array( 'catalogo-porcelanite-cihac', 'Colección CIHAC 2017–2018', 'Porcelanite', 'Archivo', 'Archive', $drive( '1PdYHt7RPhfjwLva08aFIcO7TTwpOx17D' ) ),
		array( 'catalogo-tileprac', 'Pisos y Recubrimientos', 'CreaPrac', 'Instalación', 'Installation', $drive( '1hsJMnowMmDnmGyR1nCxXG4KXUgU4Z__O' ) ),
		array( 'catalogo-tiraprac', 'Tira Trim · Perfiles', 'CreaPrac', 'Perfiles', 'Trims', $drive( '1rtt6Ohuj8GP2uqTiVUmeCfWaXChZ43Of' ) ),
	);
	return $list;
}

/**
 * Marcas que distribuimos (según el sitio actual).
 *
 * @return string[]
 */
function ac_brands() {
	return array( 'Daltile', 'Porcelanite', 'Vitromex', 'American Standard', 'Cerpa Cerámica', 'CreaPrac', 'Estilker', 'ITT Ceramic', 'Kolorines', 'Carabobo', 'Formacry' );
}

/**
 * [ac_sucursales] — directorio de sucursales con filtro por ciudad.
 */
function ac_shortcode_branches() {
	ob_start();
	get_template_part( 'template-parts/branches' );
	return ob_get_clean();
}
add_shortcode( 'ac_sucursales', 'ac_shortcode_branches' );

/**
 * [ac_catalogos] — tarjetas de catálogos con Ver / Descargar.
 */
function ac_shortcode_catalogs() {
	ob_start();
	get_template_part( 'template-parts/catalogs' );
	return ob_get_clean();
}
add_shortcode( 'ac_catalogos', 'ac_shortcode_catalogs' );
