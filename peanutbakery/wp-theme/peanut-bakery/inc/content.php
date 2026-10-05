<?php
/**
 * Contenido estructurado del sitio (líneas de pan, FAQ, proceso, slides).
 * Centralizado aquí para que las plantillas y el Schema usen exactamente los mismos textos.
 *
 * @package PeanutBakery
 */

defined( 'ABSPATH' ) || exit;

/**
 * Slides del encabezado panorámico 3D de Inicio.
 */
function pb_slides() {
	return array(
		array(
			'slot'    => 'hero-1',
			'eyebrow' => 'Panadería artesanal en Playas de Rosarito',
			'title'   => 'Pan de masa madre con <em>30 horas</em> de fermentación',
			'text'    => 'Corteza caramelizada, miga abierta y sabor profundo. Ingeniería del pan, hecha a mano todos los días desde cero.',
			'cta'     => array( 'Ver productos', '/productos/' ),
			'alt'     => 'Pan de masa madre artesanal de Peanut Bakery en Playas de Rosarito',
		),
		array(
			'slot'    => 'hero-2',
			'eyebrow' => 'Pan dulce tradicional',
			'title'   => 'Conchas, donas y pan dulce <em>recién horneado</em>',
			'text'    => 'Recetas mexicanas de siempre con técnica de panadería fina. El antojo de la mañana y de la tarde en Rosarito.',
			'cta'     => array( 'Pedir por WhatsApp', 'wa:Hola Peanut Bakery 👋 Quiero pedir pan dulce.' ),
			'alt'     => 'Conchas y pan dulce mexicano recién horneado en Rosarito',
		),
		array(
			'slot'    => 'hero-3',
			'eyebrow' => 'Bolillo y birote',
			'title'   => 'El birote salado que tu <em>torta</em> merece',
			'text'    => 'Corteza crujiente, interior suave. Bolillo y birote horneados diario para casa, taquerías y negocios.',
			'cta'     => array( 'Conocer la línea', '/productos/#bolillo-y-birote' ),
			'alt'     => 'Bolillo y birote salado artesanal de Peanut Bakery',
		),
		array(
			'slot'    => 'hero-4',
			'eyebrow' => 'Ventas de mayoreo',
			'title'   => 'Pan para <em>restaurantes, cafés y hoteles</em>',
			'text'    => 'Entregas programadas, precio preferente y calidad constante en Rosarito, Tijuana y la zona costa.',
			'cta'     => array( 'Cotizar mayoreo', '/mayoreo/' ),
			'alt'     => 'Pan al mayoreo para restaurantes y cafeterías en Rosarito y Tijuana',
		),
	);
}

/**
 * Líneas de producto. 'id' se usa como ancla (#) en /productos/.
 */
function pb_lines() {
	return array(
		array(
			'id'    => 'masa-madre',
			'slot'  => 'line-madre',
			'name'  => 'Masa madre',
			'tag'   => '30 h de fermentación',
			'desc'  => 'Hogazas y panes de fermentación lenta con levadura natural. Más digeribles, con corteza caramelizada y miga abierta.',
			'items' => array( 'Hogaza clásica de masa madre', 'Masa madre integral', 'Masa madre con semillas', 'Baguette de masa madre', 'Pan de caja de masa madre' ),
		),
		array(
			'id'    => 'pan-dulce',
			'slot'  => 'line-dulce',
			'name'  => 'Pan dulce',
			'tag'   => 'Tradición mexicana',
			'desc'  => 'Conchas, donas, cuernos y clásicos de la panadería mexicana con mantequilla real y receta artesanal.',
			'items' => array( 'Conchas de vainilla y chocolate', 'Donas glaseadas', 'Cuernos', 'Orejas', 'Roles de canela', 'Pan de temporada (rosca, pan de muerto)' ),
		),
		array(
			'id'    => 'bolillo-y-birote',
			'slot'  => 'line-salado',
			'name'  => 'Bolillo y birote',
			'tag'   => 'Horneado diario',
			'desc'  => 'El pan salado de todos los días: crujiente por fuera, suave por dentro. Ideal para tortas, lonches y mesa.',
			'items' => array( 'Bolillo tradicional', 'Birote salado', 'Telera', 'Pan para hamburguesa', 'Pan para hot dog' ),
		),
		array(
			'id'    => 'panes-artesanales',
			'slot'  => 'line-artes',
			'name'  => 'Panes artesanales',
			'tag'   => 'Especialidad',
			'desc'  => 'Panes de especialidad para restaurantes y mesas exigentes: focaccia, brioche, ciabatta y más.',
			'items' => array( 'Focaccia de romero', 'Brioche', 'Ciabatta', 'Pan de centeno', 'Baguette francesa' ),
		),
		array(
			'id'    => 'reposteria-fina',
			'slot'  => 'line-repos',
			'name'  => 'Repostería fina',
			'tag'   => 'Mantequilla real',
			'desc'  => 'Hojaldres laminados, croissants y postres para acompañar el café o celebrar.',
			'items' => array( 'Croissant de mantequilla', 'Pain au chocolat', 'Danesas', 'Galletas artesanales', 'Pasteles por pedido' ),
		),
	);
}

/**
 * Pilares / valores (Nosotros + Inicio).
 */
function pb_values() {
	return array(
		array( 'flask', 'Ingeniería del pan', 'Precisión en temperaturas, tiempos e hidratación. Procesos controlados para que cada pieza salga igual de buena.' ),
		array( 'hand', 'Hecho a mano', 'Cada pan se forma a mano, todos los días, desde cero. Sin atajos ni masas congeladas.' ),
		array( 'fire', 'Fermentación lenta', 'Hasta 30 horas de fermentación para lograr más sabor, mejor textura y un pan más digerible.' ),
		array( 'shield', 'Calidad transparente', 'Ingredientes reales y consistencia en cada entrega. Sabes lo que comes.' ),
	);
}

/**
 * Proceso (línea de tiempo animada).
 */
function pb_process() {
	return array(
		array( '01', 'Masa madre viva', 'Alimentamos nuestra levadura natural cada día para que esté activa y estable.' ),
		array( '02', 'Amasado y formado', 'Hidratación medida y formado a mano para la estructura correcta de cada pan.' ),
		array( '03', 'Fermentación de 30 h', 'Fermentación lenta en frío: aquí nace el sabor profundo y la corteza caramelizada.' ),
		array( '04', 'Horneado del día', 'Horneamos diario y entregamos fresco a tu mesa o a tu negocio.' ),
	);
}

/**
 * Beneficios de mayoreo.
 */
function pb_wholesale_benefits() {
	return array(
		array( 'truck', 'Entregas programadas', 'Rutas fijas en Rosarito y zona Tijuana–costa. Tu pan llega a tiempo, todos los días.' ),
		array( 'star', 'Precio preferente', 'Descuentos por volumen y precios especiales para clientes recurrentes.' ),
		array( 'shield', 'Calidad constante', 'Mismo tamaño, mismo sabor, misma corteza. Procesos controlados en cada lote.' ),
		array( 'cup', 'Menú a la medida', 'Desarrollamos panes a la medida de tu carta: tamaños, gramajes y recetas especiales.' ),
	);
}

/**
 * Preguntas frecuentes (se imprimen en la página y en Schema FAQPage).
 */
function pb_faqs() {
	return array(
		array( '¿Dónde está Peanut Bakery?', 'Estamos en Playas de Rosarito, Baja California. Escríbenos por WhatsApp al 661 114 7744 y te compartimos la ubicación exacta en Google Maps.' ),
		array( '¿Qué es el pan de masa madre y por qué fermentan 30 horas?', 'La masa madre es una levadura natural de harina y agua. Al fermentar lentamente durante 30 horas el pan desarrolla más sabor, una corteza caramelizada y es más fácil de digerir.' ),
		array( '¿Hacen pedidos por WhatsApp?', 'Sí. Envíanos tu pedido por WhatsApp al 661 114 7744 indicando producto, cantidad y hora de recolección o entrega.' ),
		array( '¿Venden pan al mayoreo para restaurantes y cafeterías?', 'Sí. Surtimos a cafeterías, restaurantes, hoteles y tiendas con entregas programadas, descuentos por volumen y precio preferente. Solicita tu cotización en la sección de Mayoreo.' ),
		array( '¿Hacen entregas a Tijuana?', 'Contamos con rutas de entrega para clientes de mayoreo en Rosarito y la zona Tijuana–costa. Consulta disponibilidad para tu colonia por WhatsApp.' ),
		array( '¿Puedo encargar pan para eventos?', 'Claro. Preparamos pan dulce, bolillo, birote y repostería para eventos, desayunos y reuniones. Te recomendamos pedir con 48 horas de anticipación.' ),
	);
}
