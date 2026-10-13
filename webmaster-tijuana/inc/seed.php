<?php
/**
 * Contenido inicial: al activar el tema crea páginas, servicios, testimonios,
 * menús y la portada. Sólo crea lo que falta; nunca sobrescribe contenido.
 *
 * @package WebmasterTijuana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WMT_SEED_VERSION', 1 );

function wmt_seed_servicios_data() {
	return array(
		array(
			'slug'    => 'diseno-de-paginas-web',
			'titulo'  => 'Diseño de páginas web',
			'icono'   => 'monitor',
			'resumen' => 'Sitios web modernos, rápidos y optimizados para convertir visitantes en clientes.',
			'incluye' => "Diseño a la medida y 100 % responsivo\nOptimización de velocidad y SEO técnico\nFormularios, WhatsApp y llamadas a la acción\nPanel para editar tu contenido\nCertificado SSL y configuración de dominio\nCapacitación y soporte después de publicar",
			'texto'   => "Tu sitio web es tu mejor vendedor: trabaja las 24 horas y es lo primero que ven tus clientes cuando te buscan. Por eso lo diseñamos pensando en ellos, con una estructura clara, mensajes que convencen y botones que llevan a la acción.\n\nCada sitio se adapta a celulares, tabletas y computadoras, carga rápido y nace listo para posicionarse en Google. Tú decides el alcance: desde una página de lanzamiento hasta un sitio corporativo completo.",
		),
		array(
			'slug'    => 'marketing-digital',
			'titulo'  => 'Marketing digital',
			'icono'   => 'chart',
			'resumen' => 'Estrategias integrales para mejorar tu posicionamiento y aumentar tus ventas en línea.',
			'incluye' => "Diagnóstico de tu presencia digital\nPlan de marketing con objetivos medibles\nPosicionamiento SEO y contenido\nEmail marketing y automatizaciones\nAnalítica y reportes mensuales",
			'texto'   => "Unimos sitio web, buscadores, redes sociales y publicidad en una sola estrategia, para que cada peso invertido tenga un objetivo claro y se pueda medir.\n\nEmpezamos con un diagnóstico de dónde estás hoy, definimos metas realistas y te entregamos reportes claros cada mes para tomar decisiones con datos.",
		),
		array(
			'slug'    => 'publicidad-digital',
			'titulo'  => 'Publicidad digital',
			'icono'   => 'megaphone',
			'resumen' => 'Campañas efectivas en Google Ads, Bing Ads y redes sociales para maximizar tu alcance.',
			'incluye' => "Campañas de búsqueda y display en Google Ads\nCampañas en Bing Ads\nAnuncios en Facebook, Instagram y TikTok\nSegmentación por zona, intereses y palabras clave\nOptimización continua del costo por cliente",
			'texto'   => "Con el pago por clic apareces justo cuando alguien busca lo que vendes. Configuramos y optimizamos tus campañas para generar visitas cualificadas, no sólo clics.\n\nMedimos llamadas, mensajes y formularios para saber qué anuncios traen clientes y mover el presupuesto hacia lo que funciona.",
		),
		array(
			'slug'    => 'tiendas-virtuales',
			'titulo'  => 'Desarrollo de tiendas virtuales',
			'icono'   => 'cart',
			'resumen' => 'E-commerce a la medida para vender tus productos 24/7 de forma segura.',
			'incluye' => "Catálogo de productos con variantes e inventario\nPagos con tarjeta, transferencia y OXXO\nCálculo de envíos y facturación\nCarrito y proceso de compra optimizados\nIntegración con Google Shopping y Facebook",
			'texto'   => "Lleva tu negocio a internet con una tienda en línea fácil de administrar y segura para tus clientes. Nos encargamos de la parte técnica para que tú te concentres en vender.\n\nConfiguramos métodos de pago, envíos y notificaciones, y te enseñamos a dar de alta productos y gestionar pedidos desde el primer día.",
		),
		array(
			'slug'    => 'estrategias-de-publicidad',
			'titulo'  => 'Estrategias de publicidad',
			'icono'   => 'bulb',
			'resumen' => 'Planeación creativa y analítica para destacar frente a tu competencia.',
			'incluye' => "Análisis de mercado y competencia\nIdentidad corporativa y diseño publicitario\nConcepto creativo de campaña\nPlan de medios digital y tradicional\nMedición de resultados",
			'texto'   => "Una buena campaña empieza por entender a tu cliente y a tu competencia. Diseñamos estrategias que combinan creatividad y datos para que tu marca se recuerde y se elija.\n\nIncluimos diseño gráfico moderno —logotipos, identidad corporativa y piezas publicitarias— a la medida de tus necesidades.",
		),
		array(
			'slug'    => 'manejo-de-redes-sociales',
			'titulo'  => 'Manejo de redes sociales',
			'icono'   => 'share',
			'resumen' => 'Gestión profesional de tus perfiles para crear comunidad y fidelizar clientes.',
			'incluye' => "Facebook, Instagram, TikTok, LinkedIn, YouTube y X\nCalendario y diseño de publicaciones\nFotografía y video corto\nAtención de mensajes y comentarios\nReporte mensual de crecimiento",
			'texto'   => "Mantenemos tus redes activas con contenido constante y alineado a tu marca, para que tus clientes te tengan presente y confíen en ti.\n\nPlaneamos cada mes, diseñamos las publicaciones, respondemos a tu comunidad y te mostramos con números cómo crece tu audiencia.",
		),
	);
}

function wmt_seed_testimonios_data() {
	return array(
		array( 'Alejandro M.', 'Emprendedor', 'Webmaster Tijuana transformó por completo nuestra presencia en línea. El diseño web y la estrategia SEO nos trajeron clientes desde el primer mes.' ),
		array( 'Roberto S.', 'Dueño de negocio local', 'Increíble equipo. Desarrollaron nuestra tienda virtual y las ventas se dispararon gracias a sus campañas de publicidad digital.' ),
		array( 'Laura G.', 'Directora de clínica', 'La atención es de primera. Manejan nuestras redes sociales de manera profesional, reflejando exactamente lo que queremos transmitir.' ),
	);
}

function wmt_seed_paginas_data() {
	return array(
		'inicio'              => array( 'Inicio', '', '' ),
		'nosotros'            => array(
			'Nosotros',
			"<!-- wp:paragraph --><p><strong>Somos expertos en marketing digital.</strong> Un equipo comprometido con el crecimiento de tu proyecto, con resultados a corto, mediano y largo plazo.</p><!-- /wp:paragraph -->\n\n<!-- wp:paragraph --><p>En Webmaster Tijuana ofrecemos diseño de páginas web, posicionamiento SEO, tiendas virtuales, publicidad digital y gestión de redes sociales. Tenemos el conocimiento, la experiencia y las relaciones para consolidar tu negocio en internet.</p><!-- /wp:paragraph -->\n\n<!-- wp:heading --><h2>Cómo trabajamos</h2><!-- /wp:heading -->\n\n<!-- wp:paragraph --><p>Escuchamos primero. Cada proyecto empieza con un diagnóstico de tu negocio y tus metas; con eso armamos una propuesta clara, con tiempos y entregables definidos, y te acompañamos después de publicar.</p><!-- /wp:paragraph -->",
			'',
		),
		'contacto'            => array( 'Contacto', '', 'template-contacto.php' ),
		'cotizar'             => array( 'Cotizar ahora', '', 'template-cotizar.php' ),
		'blog'                => array( 'Blog', '', '' ),
		'aviso-de-privacidad' => array(
			'Aviso de privacidad',
			"<!-- wp:paragraph --><p>Webmaster Tijuana, con domicilio en Tijuana, Baja California, es responsable del tratamiento de los datos personales que nos proporcionas a través de este sitio.</p><!-- /wp:paragraph -->\n\n<!-- wp:heading --><h2>Datos que recabamos</h2><!-- /wp:heading -->\n\n<!-- wp:paragraph --><p>Nombre, correo electrónico, teléfono y la información de tu proyecto que compartas en nuestros formularios.</p><!-- /wp:paragraph -->\n\n<!-- wp:heading --><h2>Finalidad</h2><!-- /wp:heading -->\n\n<!-- wp:paragraph --><p>Usamos tus datos únicamente para responder tu solicitud, enviarte cotizaciones y dar seguimiento a los servicios contratados. No los vendemos ni compartimos con terceros.</p><!-- /wp:paragraph -->\n\n<!-- wp:heading --><h2>Derechos ARCO</h2><!-- /wp:heading -->\n\n<!-- wp:paragraph --><p>Puedes solicitar el acceso, rectificación, cancelación u oposición al tratamiento de tus datos escribiendo a contacto@webmastertijuana.com.</p><!-- /wp:paragraph -->",
			'',
		),
	);
}

/**
 * Crea lo que falte.
 */
function wmt_seed() {
	if ( (int) get_option( 'wmt_seed_version' ) >= WMT_SEED_VERSION ) {
		return;
	}
	// El tipo de contenido debe existir antes de insertar.
	if ( ! post_type_exists( 'servicio' ) ) {
		wmt_register_cpts();
	}

	/* Páginas */
	$ids = array();
	foreach ( wmt_seed_paginas_data() as $slug => $p ) {
		$existe = get_page_by_path( $slug );
		if ( $existe ) {
			$ids[ $slug ] = $existe->ID;
			continue;
		}
		$ids[ $slug ] = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $p[0],
				'post_content' => $p[1],
			)
		);
		if ( $p[2] && $ids[ $slug ] ) {
			update_post_meta( $ids[ $slug ], '_wp_page_template', $p[2] );
		}
	}

	/* Servicios */
	foreach ( wmt_seed_servicios_data() as $orden => $s ) {
		if ( get_page_by_path( $s['slug'], OBJECT, 'servicio' ) ) {
			continue;
		}
		$contenido = '';
		foreach ( explode( "\n\n", $s['texto'] ) as $parrafo ) {
			$contenido .= '<!-- wp:paragraph --><p>' . esc_html( $parrafo ) . "</p><!-- /wp:paragraph -->\n\n";
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'servicio',
				'post_status'  => 'publish',
				'post_name'    => $s['slug'],
				'post_title'   => $s['titulo'],
				'post_excerpt' => $s['resumen'],
				'post_content' => trim( $contenido ),
				'menu_order'   => $orden,
			)
		);
		if ( $id ) {
			update_post_meta( $id, '_wmt_icono', $s['icono'] );
			update_post_meta( $id, '_wmt_incluye', $s['incluye'] );
		}
	}

	/* Testimonios */
	if ( ! get_posts( array( 'post_type' => 'testimonio', 'posts_per_page' => 1, 'post_status' => 'any' ) ) ) {
		foreach ( wmt_seed_testimonios_data() as $orden => $t ) {
			$id = wp_insert_post(
				array(
					'post_type'    => 'testimonio',
					'post_status'  => 'publish',
					'post_title'   => $t[0],
					'post_content' => $t[2],
					'menu_order'   => $orden,
				)
			);
			if ( $id ) {
				update_post_meta( $id, '_wmt_cargo', $t[1] );
				update_post_meta( $id, '_wmt_estrellas', 5 );
			}
		}
	}

	/* Portada y blog */
	if ( 'page' !== get_option( 'show_on_front' ) && ! empty( $ids['inicio'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['inicio'] );
		if ( ! empty( $ids['blog'] ) ) {
			update_option( 'page_for_posts', $ids['blog'] );
		}
	}

	/* Enlaces permanentes legibles */
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	/* Menús */
	wmt_seed_menus( $ids );

	update_option( 'wmt_seed_version', WMT_SEED_VERSION );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'wmt_seed' );
add_action( 'admin_init', 'wmt_seed' );

function wmt_seed_menus( $ids ) {
	$locations = get_theme_mod( 'nav_menu_locations', array() );

	$menus = array(
		'principal' => array(
			'nombre' => 'Menú principal',
			'items'  => array(
				array( 'page', 'inicio' ),
				array( 'archive', 'servicio', 'Servicios' ),
				array( 'archive', 'proyecto', 'Portafolio' ),
				array( 'page', 'nosotros' ),
				array( 'page', 'blog' ),
				array( 'page', 'contacto' ),
			),
		),
		'pie'       => array(
			'nombre' => 'Pie: enlaces rápidos',
			'items'  => array(
				array( 'page', 'inicio' ),
				array( 'archive', 'servicio', 'Servicios' ),
				array( 'archive', 'proyecto', 'Portafolio' ),
				array( 'page', 'nosotros' ),
				array( 'page', 'contacto' ),
				array( 'page', 'cotizar' ),
			),
		),
		'legal'     => array(
			'nombre' => 'Legal',
			'items'  => array( array( 'page', 'aviso-de-privacidad' ) ),
		),
	);

	foreach ( $menus as $ubicacion => $m ) {
		if ( ! empty( $locations[ $ubicacion ] ) && wp_get_nav_menu_object( $locations[ $ubicacion ] ) ) {
			continue;
		}
		$menu = wp_get_nav_menu_object( $m['nombre'] );
		$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( $m['nombre'] );
		if ( is_wp_error( $menu_id ) ) {
			continue;
		}
		if ( ! $menu ) {
			foreach ( $m['items'] as $pos => $item ) {
				$args = array( 'menu-item-status' => 'publish', 'menu-item-position' => $pos + 1 );
				if ( 'page' === $item[0] ) {
					if ( empty( $ids[ $item[1] ] ) ) {
						continue;
					}
					$args += array(
						'menu-item-object-id' => $ids[ $item[1] ],
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
					);
				} else {
					$args += array(
						'menu-item-title'  => $item[2],
						'menu-item-object' => $item[1],
						'menu-item-type'   => 'post_type_archive',
					);
				}
				wp_update_nav_menu_item( $menu_id, 0, $args );
			}
		}
		$locations[ $ubicacion ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $locations );
}
