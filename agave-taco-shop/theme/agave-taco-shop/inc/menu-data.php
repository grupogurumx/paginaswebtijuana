<?php
/**
 * Structured menu. Drives the Menu page, the homepage signature cards and the
 * schema.org Menu markup, so one edit here updates all three.
 *
 * Prices change often, so they are intentionally left out of the site; the
 * "Order Online" buttons always show live pricing.
 *
 * @package Agave
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return array[] Sections → items.
 */
function agave_menu() {
	$menu = array(
		array(
			'id'    => 'birria',
			'title' => 'Birria Bar',
			'lede'  => 'Our signature. Beef birria slow-braised in a guajillo-ancho adobo until it falls apart — served with a cup of consommé for dipping.',
			'items' => array(
				array( 'name' => 'Quesabirria Tacos', 'desc' => 'Griddled corn tortillas, melted cheese, birria, onion & cilantro. Consommé on the side.', 'tag' => 'Fan favorite', 'img' => 'dish-quesabirria' ),
				array( 'name' => 'Quesabirria Combo', 'desc' => 'Two quesabirria tacos with rice, refried beans and a cup of rich consommé.', 'tag' => 'Best value' ),
				array( 'name' => 'Birria Burrito', 'desc' => 'Birria, rice, onion and cilantro wrapped in a warm flour tortilla. Dip it.', 'tag' => '' ),
				array( 'name' => 'Birria Quesadilla', 'desc' => 'Flour tortilla, a blanket of melted cheese and juicy birria, crisped on the plancha.', 'tag' => '' ),
				array( 'name' => 'Birria Fries', 'desc' => 'Golden fries smothered with birria, cheese, onion, cilantro and crema.', 'tag' => 'Shareable', 'img' => 'dish-fries' ),
				array( 'name' => 'Birria Plate', 'desc' => 'A generous serving of birria with rice, beans, tortillas and consommé.', 'tag' => '' ),
			),
		),
		array(
			'id'    => 'tacos',
			'title' => 'Street Tacos',
			'lede'  => 'Built on warm corn tortillas, finished with fresh salsa, onion and cilantro.',
			'items' => array(
				array( 'name' => 'Carne Asada Taco', 'desc' => 'Charred, marinated steak, guacamole and pico de gallo.', 'tag' => '', 'img' => 'dish-street-tacos' ),
				array( 'name' => 'Carnitas Taco', 'desc' => 'Slow-cooked pork, crispy edges, salsa verde.', 'tag' => '' ),
				array( 'name' => 'Pollo Asado Taco', 'desc' => 'Citrus-marinated grilled chicken, pico de gallo.', 'tag' => '' ),
				array( 'name' => 'Hard Shell Tacos', 'desc' => 'Crunchy shells, seasoned beef, lettuce and shredded cheese.', 'tag' => 'Classic' ),
				array( 'name' => 'Rolled Tacos', 'desc' => 'Crispy taquitos topped with guacamole and cheese.', 'tag' => '' ),
			),
		),
		array(
			'id'    => 'burritos',
			'title' => 'Burritos',
			'lede'  => 'San Diego-sized and wrapped to travel — perfect for the beach, the boat or the drive-thru.',
			'items' => array(
				array( 'name' => 'California Burrito', 'desc' => 'Carne asada, crispy potatoes, cheese and sour cream. The San Diego original.', 'tag' => 'SD icon', 'img' => 'dish-california' ),
				array( 'name' => 'Carne Asada Burrito', 'desc' => 'Carne asada, guacamole and pico de gallo.', 'tag' => '' ),
				array( 'name' => 'Carnitas Burrito', 'desc' => 'Carnitas, guacamole and pico de gallo.', 'tag' => '' ),
				array( 'name' => 'Bean & Cheese Burrito', 'desc' => 'Creamy refried beans and melted cheese. Simple and perfect.', 'tag' => 'Vegetarian' ),
			),
		),
		array(
			'id'    => 'breakfast',
			'title' => 'Breakfast · from 7 AM',
			'lede'  => 'Fuel for surf sessions, early shifts and sunrise dog walks.',
			'items' => array(
				array( 'name' => 'Bacon Breakfast Burrito', 'desc' => 'Bacon, crispy potatoes, scrambled egg and cheese.', 'tag' => 'Morning hero', 'img' => 'dish-breakfast' ),
				array( 'name' => 'Chorizo & Egg Burrito', 'desc' => 'Spiced chorizo, scrambled egg, potatoes and cheese.', 'tag' => '' ),
				array( 'name' => 'Carnitas & Egg Burrito', 'desc' => 'Carnitas, scrambled egg and salsa.', 'tag' => '' ),
				array( 'name' => 'Bean, Egg & Cheese Burrito', 'desc' => 'The vegetarian sunrise classic.', 'tag' => '' ),
				array( 'name' => 'Bean & Egg Burrito', 'desc' => 'Refried beans and fluffy scrambled egg.', 'tag' => '' ),
			),
		),
		array(
			'id'    => 'more',
			'title' => 'Plates, Mulitas & More',
			'lede'  => 'Comfort food the way it is done south of the border.',
			'items' => array(
				array( 'name' => 'Mulitas', 'desc' => 'Two tortillas sandwiching melted cheese and your choice of meat, griddled crisp.', 'tag' => '' ),
				array( 'name' => 'Cheese Quesadilla', 'desc' => 'Flour tortilla with melted cheese — add any meat.', 'tag' => '' ),
				array( 'name' => 'Carne Asada Fries', 'desc' => 'Fries topped with carne asada, guacamole, sour cream and cheese.', 'tag' => '' ),
				array( 'name' => 'Combination Plates', 'desc' => 'Your favorite with rice, beans and tortillas.', 'tag' => '' ),
				array( 'name' => 'Menudo', 'desc' => 'Traditional weekend soup, served with onion, oregano, lime and tortillas.', 'tag' => 'Weekend', 'img' => 'dish-menudo' ),
			),
		),
		array(
			'id'    => 'drinks',
			'title' => 'Aguas Frescas & Drinks',
			'lede'  => 'Made to cool the salsa down.',
			'items' => array(
				array( 'name' => 'Horchata', 'desc' => 'Creamy rice and cinnamon agua fresca.', 'tag' => '', 'img' => 'dish-aguas' ),
				array( 'name' => 'Jamaica', 'desc' => 'Tart, ruby-red hibiscus agua fresca.', 'tag' => '' ),
				array( 'name' => 'Mexican Sodas', 'desc' => 'Glass-bottle classics made with cane sugar.', 'tag' => '' ),
			),
		),
	);

	return apply_filters( 'agave_menu', $menu );
}

/**
 * Items flagged with an image — used for the homepage "signature" cards.
 *
 * @return array
 */
function agave_signature_items() {
	$items = array();
	foreach ( agave_menu() as $section ) {
		foreach ( $section['items'] as $item ) {
			if ( ! empty( $item['img'] ) ) {
				$item['section'] = $section['title'];
				$items[]         = $item;
			}
		}
	}
	return array_slice( $items, 0, 6 );
}
