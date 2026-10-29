<?php
/**
 * Bilingüe ligero ES/EN sin plugins.
 *
 * - Cada página o entrada guarda su idioma en el meta `_ac_lang` (es|en).
 * - Su equivalente en el otro idioma se guarda en `_ac_translation` (ruta/slug).
 * - Las páginas en inglés cuelgan de la página padre «en» (/en/...).
 *
 * Compatible con Polylang/WPML: si alguno está activo, se usa su idioma actual.
 *
 * @package Acabados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Idioma del contenido que se está viendo.
 *
 * @return string 'es' o 'en'.
 */
function ac_lang() {
	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}

	if ( function_exists( 'pll_current_language' ) && pll_current_language() ) {
		$lang = 'en' === pll_current_language() ? 'en' : 'es';
		return $lang;
	}
	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		$lang = 'en' === ICL_LANGUAGE_CODE ? 'en' : 'es';
		return $lang;
	}

	$lang = 'es';
	if ( is_singular() ) {
		$id = get_queried_object_id();
		if ( 'en' === get_post_meta( $id, '_ac_lang', true ) ) {
			$lang = 'en';
		}
	} elseif ( is_category() ) {
		$term = get_queried_object();
		if ( $term && 'en' === get_term_meta( $term->term_id, '_ac_lang', true ) ) {
			$lang = 'en';
		} elseif ( $term && 'blog-en' === $term->slug ) {
			$lang = 'en';
		}
	} elseif ( isset( $_GET['lang'] ) && 'en' === sanitize_key( wp_unslash( $_GET['lang'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$lang = 'en';
	}
	return $lang;
}

/**
 * URL del equivalente en el otro idioma de la vista actual.
 *
 * @return string
 */
function ac_translation_url() {
	$target = 'en' === ac_lang() ? 'es' : 'en';

	if ( is_singular() ) {
		$path = get_post_meta( get_queried_object_id(), '_ac_translation', true );
		if ( $path ) {
			$post = get_page_by_path( $path, OBJECT, array( 'page', 'post' ) );
			if ( $post ) {
				return get_permalink( $post );
			}
		}
	}
	if ( is_category() || is_home() ) {
		$cat = get_category_by_slug( 'en' === $target ? 'blog-en' : 'blog' );
		if ( $cat ) {
			return get_category_link( $cat );
		}
	}
	return ac_home_url( $target );
}

/**
 * Portada de cada idioma.
 *
 * @param string|null $lang Idioma; por defecto el actual.
 * @return string
 */
function ac_home_url( $lang = null ) {
	$lang = $lang ? $lang : ac_lang();
	if ( 'en' === $lang ) {
		$page = get_page_by_path( 'en' );
		return $page ? get_permalink( $page ) : home_url( '/en/' );
	}
	return home_url( '/' );
}

/**
 * URL de una página por su ruta en cada idioma (cae a la portada si no existe).
 *
 * @param string $es Ruta en español, p. ej. 'contacto'.
 * @param string $en Ruta en inglés, p. ej. 'en/contact'.
 * @return string
 */
function ac_page_url( $es, $en ) {
	$path = 'en' === ac_lang() ? $en : $es;
	$page = get_page_by_path( $path );
	return $page ? get_permalink( $page ) : home_url( '/' . trailingslashit( $path ) );
}

/**
 * Cadena traducida.
 *
 * @param string $key Clave del diccionario.
 * @return string
 */
function ac_t( $key ) {
	$strings = ac_strings();
	$lang    = ac_lang();
	if ( isset( $strings[ $key ][ $lang ] ) ) {
		return $strings[ $key ][ $lang ];
	}
	return isset( $strings[ $key ]['es'] ) ? $strings[ $key ]['es'] : $key;
}

/**
 * Imprime una cadena traducida escapada.
 *
 * @param string $key Clave.
 */
function ac_e( $key ) {
	echo esc_html( ac_t( $key ) );
}

/**
 * Diccionario de textos de interfaz y portada.
 *
 * @return array
 */
function ac_strings() {
	static $s = null;
	if ( null !== $s ) {
		return $s;
	}
	$s = array(
		// Navegación y UI.
		'skip'            => array( 'es' => 'Saltar al contenido', 'en' => 'Skip to content' ),
		'menu'            => array( 'es' => 'Menú', 'en' => 'Menu' ),
		'close'           => array( 'es' => 'Cerrar', 'en' => 'Close' ),
		'quote'           => array( 'es' => 'Cotizar proyecto', 'en' => 'Request a quote' ),
		'switch_lang'     => array( 'es' => 'English', 'en' => 'Español' ),
		'switch_lang_abbr'=> array( 'es' => 'EN', 'en' => 'ES' ),
		'prev'            => array( 'es' => 'Anterior', 'en' => 'Previous' ),
		'next'            => array( 'es' => 'Siguiente', 'en' => 'Next' ),
		'read_more'       => array( 'es' => 'Leer artículo', 'en' => 'Read article' ),
		'view_all'        => array( 'es' => 'Ver todo', 'en' => 'View all' ),
		'search'          => array( 'es' => 'Buscar', 'en' => 'Search' ),
		'search_ph'       => array( 'es' => 'Buscar porcelanato, mosaico, baño…', 'en' => 'Search porcelain, mosaic, bathroom…' ),
		'not_found_t'     => array( 'es' => 'Esta superficie aún no existe', 'en' => 'This surface does not exist yet' ),
		'not_found_d'     => array( 'es' => 'La página que buscas se movió o ya no está disponible. Explora nuestras colecciones o vuelve al inicio.', 'en' => 'The page you are looking for has moved or is no longer available. Explore our collections or head back home.' ),
		'back_home'       => array( 'es' => 'Volver al inicio', 'en' => 'Back to home' ),
		'nothing'         => array( 'es' => 'No encontramos resultados. Prueba con otra palabra.', 'en' => 'No results found. Try another keyword.' ),
		'results_for'     => array( 'es' => 'Resultados para', 'en' => 'Results for' ),
		'min_read'        => array( 'es' => 'min de lectura', 'en' => 'min read' ),
		'related'         => array( 'es' => 'Sigue inspirándote', 'en' => 'Keep exploring' ),
		'share'           => array( 'es' => 'Compartir', 'en' => 'Share' ),
		'whatsapp_msg'    => array( 'es' => 'Hola, me interesa cotizar recubrimientos con Acabados Contemporáneos.', 'en' => 'Hello, I would like a quote for tiles from Acabados Contemporáneos.' ),
		'whatsapp_label'  => array( 'es' => 'Escríbenos por WhatsApp', 'en' => 'Chat with us on WhatsApp' ),
		'scroll'          => array( 'es' => 'Desliza', 'en' => 'Scroll' ),

		// Pie de página.
		'footer_claim'    => array( 'es' => 'Más de 35 años vistiendo los espacios más exigentes de México con recubrimientos, cerámicas, porcelánicos y accesorios para la construcción.', 'en' => 'For over 35 years, dressing Mexico\'s most demanding spaces with tiles, ceramics, porcelain and construction accessories.' ),
		'footer_visit'    => array( 'es' => 'Visítanos', 'en' => 'Visit us' ),
		'footer_contact'  => array( 'es' => 'Contacto', 'en' => 'Contact' ),
		'footer_explore'  => array( 'es' => 'Explora', 'en' => 'Explore' ),
		'footer_follow'   => array( 'es' => 'Síguenos', 'en' => 'Follow us' ),
		'rights'          => array( 'es' => 'Todos los derechos reservados.', 'en' => 'All rights reserved.' ),
		'privacy'         => array( 'es' => 'Aviso de privacidad', 'en' => 'Privacy notice' ),
		'hours'           => array( 'es' => 'Horario', 'en' => 'Hours' ),

		// Portada: slider panorámico.
		's1_kicker'       => array( 'es' => 'Porcelánico de gran formato', 'en' => 'Large-format porcelain' ),
		's1_title'        => array( 'es' => 'El lujo comienza bajo tus pies', 'en' => 'Luxury begins beneath your feet' ),
		's1_text'         => array( 'es' => 'Porcelanatos tipo mármol de gran formato que convierten cada piso en una declaración de diseño: menos juntas, más amplitud, brillo que perdura.', 'en' => 'Marble-look large-format porcelain that turns every floor into a design statement: fewer joints, more space, a shine that lasts.' ),
		's1_cta'          => array( 'es' => 'Explorar porcelánicos', 'en' => 'Explore porcelain' ),
		's2_kicker'       => array( 'es' => 'Baños y spa en casa', 'en' => 'Bathrooms & home spa' ),
		's2_title'        => array( 'es' => 'Baños que se sienten como un spa', 'en' => 'Bathrooms that feel like a spa' ),
		's2_text'         => array( 'es' => 'Recubrimientos tipo piedra y travertino para muros y regaderas que transforman la rutina diaria en un ritual de calma.', 'en' => 'Stone and travertine-look wall tiles for showers and walls that turn your daily routine into a ritual of calm.' ),
		's2_cta'          => array( 'es' => 'Ver recubrimientos', 'en' => 'View wall tiles' ),
		's3_kicker'       => array( 'es' => 'Cocinas con carácter', 'en' => 'Kitchens with character' ),
		's3_title'        => array( 'es' => 'Superficies que resisten la vida real', 'en' => 'Surfaces built for real life' ),
		's3_text'         => array( 'es' => 'Cerámica artesanal para backsplash y porcelanato tipo madera de alto tránsito: la calidez de lo natural con la resistencia de lo técnico.', 'en' => 'Handcrafted ceramic backsplashes and high-traffic wood-look porcelain: the warmth of nature with technical-grade durability.' ),
		's3_cta'          => array( 'es' => 'Descubrir cerámica', 'en' => 'Discover ceramics' ),
		's4_kicker'       => array( 'es' => 'Exteriores y albercas', 'en' => 'Outdoors & pools' ),
		's4_title'        => array( 'es' => 'Diseñados para vivir al aire libre', 'en' => 'Designed for open-air living' ),
		's4_text'         => array( 'es' => 'Pisos para exterior antiderrapantes, resistentes a la intemperie y al sol, para terrazas, albercas y fachadas que no pierden su belleza.', 'en' => 'Anti-slip outdoor pavers that withstand sun and weather, for terraces, pools and facades that keep their beauty.' ),
		's4_cta'          => array( 'es' => 'Pisos para exterior', 'en' => 'Outdoor flooring' ),
		's5_kicker'       => array( 'es' => 'Showroom y asesoría', 'en' => 'Showroom & advice' ),
		's5_title'        => array( 'es' => 'Toca, compara y elige con expertos', 'en' => 'Touch, compare and choose with experts' ),
		's5_text'         => array( 'es' => 'Visita nuestro showroom: muestras físicas, piezas en exhibición y asesoría técnica para elegir el recubrimiento ideal para tu obra.', 'en' => 'Visit our showroom: physical samples, full-size displays and technical advice to choose the right tile for your project.' ),
		's5_cta'          => array( 'es' => 'Agenda tu visita', 'en' => 'Book your visit' ),

		// Portada: secciones.
		'intro_kicker'    => array( 'es' => 'Desde hace más de 35 años', 'en' => 'For more than 35 years' ),
		'intro_title'     => array( 'es' => 'Superficies que cuentan la historia de cada espacio', 'en' => 'Surfaces that tell the story of every space' ),
		'intro_text'      => array( 'es' => 'Acabados Contemporáneos es una empresa mexicana dedicada a la comercialización de recubrimientos, cerámicas, porcelánicos y accesorios para la construcción. Acompañamos a familias, arquitectos, diseñadores de interiores y constructoras desde la primera muestra hasta la última pieza instalada, con inventario disponible, precios competitivos y la asesoría de quienes conocen cada colección a fondo.', 'en' => 'Acabados Contemporáneos is a Mexican company dedicated to supplying tiles, ceramics, porcelain and construction accessories. We guide homeowners, architects, interior designers and builders from the first sample to the last installed piece, with stock on hand, competitive pricing and advice from people who know every collection inside out.' ),
		'intro_cta'       => array( 'es' => 'Conoce nuestra historia', 'en' => 'Our story' ),
		'stat_years'      => array( 'es' => 'años de experiencia', 'en' => 'years of experience' ),
		'stat_products'   => array( 'es' => 'líneas de producto especializadas', 'en' => 'specialized product lines' ),
		'stat_projects'   => array( 'es' => 'horas hábiles para tu cotización', 'en' => 'business hours to get your quote' ),
		'stat_brands'     => array( 'es' => 'proveedor para piso, muro y accesorios', 'en' => 'supplier for floors, walls and accessories' ),

		'cats_kicker'     => array( 'es' => 'Colecciones', 'en' => 'Collections' ),
		'cats_title'      => array( 'es' => 'Todo para pisos y muros, en un solo lugar', 'en' => 'Everything for floors and walls, in one place' ),
		'cats_text'       => array( 'es' => 'Seis líneas curadas para resolver cualquier proyecto residencial, comercial u hotelero.', 'en' => 'Six curated lines to solve any residential, commercial or hospitality project.' ),
		'cat1_t'          => array( 'es' => 'Porcelánicos', 'en' => 'Porcelain tiles' ),
		'cat1_d'          => array( 'es' => 'Gran formato, tipo mármol, cemento y piedra. Baja absorción y máxima durabilidad.', 'en' => 'Large format, marble, concrete and stone looks. Low absorption, maximum durability.' ),
		'cat2_t'          => array( 'es' => 'Cerámica', 'en' => 'Ceramic tiles' ),
		'cat2_d'          => array( 'es' => 'Azulejos para baño y cocina con esmaltes artesanales y colores que inspiran.', 'en' => 'Bathroom and kitchen wall tiles with handcrafted glazes and inspiring colors.' ),
		'cat3_t'          => array( 'es' => 'Recubrimientos de muro', 'en' => 'Wall cladding' ),
		'cat3_d'          => array( 'es' => 'Fachadas, muros 3D y paneles tipo piedra para interiores y exteriores.', 'en' => 'Facades, 3D walls and stone-look panels for interiors and exteriors.' ),
		'cat4_t'          => array( 'es' => 'Tipo madera', 'en' => 'Wood-look tile' ),
		'cat4_d'          => array( 'es' => 'La calidez de la madera con la resistencia del porcelanato. Ideal para alto tránsito.', 'en' => 'The warmth of wood with porcelain strength. Ideal for high traffic.' ),
		'cat5_t'          => array( 'es' => 'Mosaicos', 'en' => 'Mosaics' ),
		'cat5_d'          => array( 'es' => 'Vidrio, piedra y metal para muros protagonistas, albercas y detalles únicos.', 'en' => 'Glass, stone and metal for feature walls, pools and one-of-a-kind details.' ),
		'cat6_t'          => array( 'es' => 'Accesorios e instalación', 'en' => 'Accessories & installation' ),
		'cat6_d'          => array( 'es' => 'Adhesivos, boquillas, perfiles, sistemas de nivelación y herramientas profesionales.', 'en' => 'Adhesives, grouts, trims, leveling systems and professional tools.' ),
		'discover'        => array( 'es' => 'Descubrir', 'en' => 'Discover' ),

		'band_quote'      => array( 'es' => '«Un buen acabado no se nota: se siente. Es la diferencia entre construir un espacio y crear un lugar.»', 'en' => '"A great finish isn\'t noticed — it\'s felt. It is the difference between building a space and creating a place."' ),
		'band_author'     => array( 'es' => 'Filosofía Acabados Contemporáneos', 'en' => 'The Acabados Contemporáneos philosophy' ),

		'why_kicker'      => array( 'es' => 'Por qué elegirnos', 'en' => 'Why choose us' ),
		'why_title'       => array( 'es' => 'Experiencia que se instala contigo', 'en' => 'Expertise that gets installed with you' ),
		'why1_t'          => array( 'es' => 'Asesoría experta', 'en' => 'Expert guidance' ),
		'why1_d'          => array( 'es' => 'Te ayudamos a elegir formato, acabado, PEI y absorción correctos para cada área, sin pagar de más.', 'en' => 'We help you choose the right format, finish, PEI rating and absorption for every area — without overspending.' ),
		'why2_t'          => array( 'es' => 'Inventario disponible', 'en' => 'Stock on hand' ),
		'why2_d'          => array( 'es' => 'Amplio stock para entregas rápidas y continuidad de lote en obras grandes.', 'en' => 'Large stock for fast delivery and batch consistency on large projects.' ),
		'why3_t'          => array( 'es' => 'Precio de proyecto', 'en' => 'Project pricing' ),
		'why3_d'          => array( 'es' => 'Cotizaciones a la medida para arquitectos, constructoras y desarrolladores.', 'en' => 'Tailored quotes for architects, builders and developers.' ),
		'why4_t'          => array( 'es' => 'Solución completa', 'en' => 'Complete solution' ),
		'why4_d'          => array( 'es' => 'Piso, muro, adhesivo, boquilla y perfil: todo lo que tu instalación necesita en una sola compra.', 'en' => 'Floor, wall, adhesive, grout and trim: everything your installation needs in one purchase.' ),

		'amb_kicker'      => array( 'es' => 'Ambientes', 'en' => 'Spaces' ),
		'amb_title'       => array( 'es' => 'Inspiración para cada rincón', 'en' => 'Inspiration for every corner' ),
		'amb_hint'        => array( 'es' => 'Arrastra para explorar', 'en' => 'Drag to explore' ),
		'amb1'            => array( 'es' => 'Salas y estancias', 'en' => 'Living rooms' ),
		'amb2'            => array( 'es' => 'Baños', 'en' => 'Bathrooms' ),
		'amb3'            => array( 'es' => 'Cocinas', 'en' => 'Kitchens' ),
		'amb4'            => array( 'es' => 'Terrazas y albercas', 'en' => 'Terraces & pools' ),
		'amb5'            => array( 'es' => 'Hoteles y lobbies', 'en' => 'Hotels & lobbies' ),
		'amb6'            => array( 'es' => 'Comercios y oficinas', 'en' => 'Retail & offices' ),

		'pro_kicker'      => array( 'es' => 'Para profesionales', 'en' => 'For professionals' ),
		'pro_title'       => array( 'es' => 'Arquitectos, diseñadores y constructoras', 'en' => 'Architects, designers and builders' ),
		'pro_text'        => array( 'es' => 'Especificamos contigo desde el plano: fichas técnicas, muestras físicas, cálculo de metros cuadrados y desperdicio, programación de entregas por etapa y precios especiales por volumen.', 'en' => 'We specify with you from the drawings: technical data sheets, physical samples, square-meter and waste calculations, phased delivery scheduling and volume pricing.' ),
		'pro_cta'         => array( 'es' => 'Programa para profesionales', 'en' => 'Professional program' ),
		'step1_t'         => array( 'es' => 'Cuéntanos tu proyecto', 'en' => 'Tell us about your project' ),
		'step1_d'         => array( 'es' => 'Planos, medidas o una foto: con eso empezamos.', 'en' => 'Drawings, measurements or a photo: that is all we need.' ),
		'step2_t'         => array( 'es' => 'Selección con muestras', 'en' => 'Selection with samples' ),
		'step2_d'         => array( 'es' => 'Comparas colecciones reales en showroom o en obra.', 'en' => 'Compare real collections at our showroom or on site.' ),
		'step3_t'         => array( 'es' => 'Cotización detallada', 'en' => 'Detailed quote' ),
		'step3_d'         => array( 'es' => 'Material, accesorios y desperdicio calculado.', 'en' => 'Material, accessories and waste, all calculated.' ),
		'step4_t'         => array( 'es' => 'Entrega puntual', 'en' => 'On-time delivery' ),
		'step4_d'         => array( 'es' => 'Programada por etapas, directo a tu obra.', 'en' => 'Scheduled in phases, straight to your site.' ),

		'blog_kicker'     => array( 'es' => 'Blog', 'en' => 'Journal' ),
		'blog_title'      => array( 'es' => 'Ideas, tendencias y guías de experto', 'en' => 'Ideas, trends and expert guides' ),

		'faq_kicker'      => array( 'es' => 'Preguntas frecuentes', 'en' => 'FAQ' ),
		'faq_title'       => array( 'es' => 'Resolvemos tus dudas', 'en' => 'Your questions, answered' ),
		'faq1_q'          => array( 'es' => '¿Qué diferencia hay entre cerámica y porcelanato?', 'en' => 'What is the difference between ceramic and porcelain tile?' ),
		'faq1_a'          => array( 'es' => 'El porcelanato se fabrica con arcillas más finas y se cuece a mayor temperatura, por lo que absorbe menos del 0.5% de agua y es más resistente al desgaste y a las heladas. La cerámica es ideal para muros y áreas de tránsito ligero, con gran variedad de esmaltes y un costo menor.', 'en' => 'Porcelain is made from finer clays fired at higher temperatures, so it absorbs less than 0.5% water and resists wear and frost better. Ceramic is ideal for walls and light-traffic areas, with a wide range of glazes at a lower cost.' ),
		'faq2_q'          => array( 'es' => '¿Cuánto material debo comprar de más?', 'en' => 'How much extra material should I buy?' ),
		'faq2_a'          => array( 'es' => 'Recomendamos entre 5% y 10% adicional para cortes y reposiciones; en instalaciones en diagonal, espiga o gran formato, hasta 15%. Nuestro equipo lo calcula contigo sin costo.', 'en' => 'We recommend 5% to 10% extra for cuts and replacements; up to 15% for diagonal, herringbone or large-format layouts. Our team calculates it with you at no cost.' ),
		'faq3_q'          => array( 'es' => '¿Qué piso es mejor para exterior y alberca?', 'en' => 'Which tile is best for outdoors and pools?' ),
		'faq3_a'          => array( 'es' => 'Un porcelánico antiderrapante (R11 o superior) con baja absorción, resistente a rayos UV y cambios de temperatura. Para el interior de la alberca, mosaico de vidrio o porcelánico específico para inmersión.', 'en' => 'An anti-slip porcelain paver (R11 or higher) with low absorption, UV and temperature resistance. For pool interiors, glass mosaic or porcelain rated for immersion.' ),
		'faq4_q'          => array( 'es' => '¿Hacen envíos y atienden obras fuera de la ciudad?', 'en' => 'Do you deliver and serve projects outside the city?' ),
		'faq4_a'          => array( 'es' => 'Sí. Programamos entregas a obra y enviamos a distintos estados de la República Mexicana. Escríbenos con la ubicación del proyecto para cotizar el flete.', 'en' => 'Yes. We schedule site deliveries and ship to multiple states across Mexico. Send us your project location to quote shipping.' ),

		'cta_title'       => array( 'es' => '¿Listo para transformar tu espacio?', 'en' => 'Ready to transform your space?' ),
		'cta_text'        => array( 'es' => 'Recibe una cotización personalizada en menos de 24 horas hábiles. Sin compromiso, con la asesoría de especialistas en recubrimientos.', 'en' => 'Get a personalized quote within 24 business hours. No commitment, with advice from tile specialists.' ),
		'cta_btn'         => array( 'es' => 'Solicitar cotización', 'en' => 'Request a quote' ),
		'cta_btn2'        => array( 'es' => 'Hablar por WhatsApp', 'en' => 'Chat on WhatsApp' ),

		// Formulario de contacto.
		'f_name'          => array( 'es' => 'Nombre completo', 'en' => 'Full name' ),
		'f_email'         => array( 'es' => 'Correo electrónico', 'en' => 'Email' ),
		'f_phone'         => array( 'es' => 'Teléfono / WhatsApp', 'en' => 'Phone / WhatsApp' ),
		'f_type'          => array( 'es' => 'Tipo de proyecto', 'en' => 'Project type' ),
		'f_type_1'        => array( 'es' => 'Residencial', 'en' => 'Residential' ),
		'f_type_2'        => array( 'es' => 'Comercial / Oficinas', 'en' => 'Commercial / Offices' ),
		'f_type_3'        => array( 'es' => 'Hotelería / Restaurantes', 'en' => 'Hospitality / Restaurants' ),
		'f_type_4'        => array( 'es' => 'Desarrollo / Constructora', 'en' => 'Development / Builder' ),
		'f_msg'           => array( 'es' => 'Cuéntanos qué necesitas (área, m², estilo)', 'en' => 'Tell us what you need (area, m², style)' ),
		'f_privacy'       => array( 'es' => 'Acepto el aviso de privacidad.', 'en' => 'I accept the privacy notice.' ),
		'f_send'          => array( 'es' => 'Enviar solicitud', 'en' => 'Send request' ),
		'f_ok'            => array( 'es' => 'Gracias. Recibimos tu solicitud y te contactaremos muy pronto.', 'en' => 'Thank you. We received your request and will contact you shortly.' ),
		'f_err'           => array( 'es' => 'No pudimos enviar tu mensaje. Revisa los campos e inténtalo de nuevo.', 'en' => 'We could not send your message. Please check the fields and try again.' ),
	);
	return $s;
}
