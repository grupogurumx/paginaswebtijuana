<?php
/**
 * Plugin Name:       Southwestern Solutions — Site Installer
 * Description:       One-click install of the Southwestern Solutions redesign: installs and activates the theme, safely moves conflicting old pages/products to the Trash (so the new pages keep the same URLs), imports the new pages, menu and course products, and configures the front page and store. Deactivate and delete after use.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Grupo Guru
 * License:           GPL-2.0-or-later
 *
 * Bundles the GPL "WordPress Importer" 0.8.2 classes (wordpress.org/plugins/wordpress-importer).
 *
 * @package sws-installer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SWSI_DIR', plugin_dir_path( __FILE__ ) );
define( 'SWSI_THEME', 'southwestern-solutions' );

/** Slugs the new site uses. Existing posts with these slugs are moved to the Trash first. */
function swsi_page_slugs() {
	return array( 'home', 'about-us', 'courses', 'chemical-agent-instructor-course', 'less-lethal-instructor-course', 'ab-48-compliance', 'training-schedule', 'host-a-course', 'faq', 'contact' );
}
function swsi_product_slugs() {
	return array( 'chemical-agent-instructor-course', 'less-lethal-instructor-course', 'chemical-agent-instructor-course-san-jose-ca', 'chemical-agent-instructor-course-san-jose', 'less-lethal-instructor-course-san-jose-ca' );
}
/** Old pages the new site replaces (removed so the theme's 301 redirects take over). */
function swsi_legacy_page_slugs() {
	return array( 'home-it-service', 'about', 'contact-us', 'schedule', 'ab48', 'blog', 'privacy-policy', 'sample-page' );
}

/** Find published/draft posts of a type whose slug is in $slugs. */
function swsi_find( $type, $slugs ) {
	$found = array();
	foreach ( $slugs as $slug ) {
		$posts = get_posts(
			array(
				'name'           => $slug,
				'post_type'      => $type,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);
		foreach ( $posts as $id ) {
			$found[ $id ] = $slug;
		}
	}
	return $found;
}

add_action(
	'admin_menu',
	function () {
		add_management_page( 'Southwestern Installer', 'Southwestern Installer', 'manage_options', 'sws-installer', 'swsi_page' );
	}
);

add_action(
	'admin_notices',
	function () {
		if ( current_user_can( 'manage_options' ) && ! get_option( 'swsi_done' ) && ( ! isset( $_GET['page'] ) || 'sws-installer' !== $_GET['page'] ) ) { // phpcs:ignore
			echo '<div class="notice notice-info"><p><strong>Southwestern Solutions:</strong> the new site is ready to install. <a class="button button-primary" href="' . esc_url( admin_url( 'tools.php?page=sws-installer' ) ) . '">Open the installer</a></p></div>';
		}
	}
);

function swsi_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="wrap"><h1>Southwestern Solutions — Site Installer</h1>';

	if ( isset( $_POST['swsi_run'] ) ) {
		check_admin_referer( 'swsi_run' );
		if ( empty( $_POST['swsi_backup'] ) ) {
			echo '<div class="notice notice-error"><p>Please confirm you have a backup before installing.</p></div>';
		} else {
			$log = swsi_run();
			echo '<div class="notice notice-success"><p><strong>Done.</strong> <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank">View the new site →</a></p></div>';
			echo '<h2>Installation log</h2><ol style="background:#fff;padding:16px 16px 16px 36px;border:1px solid #ccd0d4;max-width:900px">';
			foreach ( $log as $line ) {
				echo '<li>' . wp_kses_post( $line ) . '</li>';
			}
			echo '</ol><p>When everything looks right, deactivate and delete this plugin (Plugins → Southwestern Solutions — Site Installer).</p></div>';
			return;
		}
	}

	$wc        = class_exists( 'WooCommerce' );
	$pages     = swsi_find( 'page', swsi_page_slugs() );
	$legacy    = swsi_find( 'page', swsi_legacy_page_slugs() );
	$products  = post_type_exists( 'product' ) ? swsi_find( 'product', swsi_product_slugs() ) : array();
	$theme     = wp_get_theme();
	$done_note = get_option( 'swsi_done' ) ? '<div class="notice notice-warning"><p>The installer has already run once on ' . esc_html( get_option( 'swsi_done' ) ) . '. Running it again will trash the pages it created and import them fresh.</p></div>' : '';
	echo $done_note; // phpcs:ignore
	?>
	<p style="max-width:820px">This will set up the redesigned website on this WordPress. Everything that gets replaced is moved to the <strong>Trash</strong> (not permanently deleted), so it can be restored from Pages → Trash or Products → Trash.</p>
	<table class="widefat striped" style="max-width:900px">
		<tbody>
			<tr><td><strong>1. Theme</strong></td><td>Install &amp; activate <em>Southwestern Solutions</em> (current theme: <?php echo esc_html( $theme->get( 'Name' ) ); ?>)</td></tr>
			<tr><td><strong>2. Old pages to Trash</strong></td><td><?php echo $pages || $legacy ? esc_html( implode( ', ', array_map( 'get_the_title', array_keys( $pages + $legacy ) ) ) ) : 'None found'; ?></td></tr>
			<tr><td><strong>3. Old products to Trash</strong></td><td><?php echo $wc ? ( $products ? esc_html( implode( ', ', array_map( 'get_the_title', array_keys( $products ) ) ) ) : 'None found' ) : '—'; ?></td></tr>
			<tr><td><strong>4. Import</strong></td><td>10 pages + main menu<?php echo $wc ? ' + 2 course products (Chemical Agent Feb 8–12, 2027 · Less Lethal Dec 9–11, 2026)' : ''; ?></td></tr>
			<tr><td><strong>5. Settings</strong></td><td>Home page, pretty permalinks, menu location<?php echo $wc ? ', store (USD, Agency Invoice/PO payment, agency checkout fields)' : ''; ?></td></tr>
		</tbody>
	</table>
	<?php if ( ! $wc ) : ?>
		<div class="notice notice-warning inline" style="max-width:870px"><p><strong>WooCommerce is not active.</strong> The site will install without online course registration. To include it, install &amp; activate WooCommerce first (Plugins → Add New → “WooCommerce”), then come back here.</p></div>
	<?php endif; ?>
	<form method="post" style="margin-top:20px">
		<?php wp_nonce_field( 'swsi_run' ); ?>
		<p><label><input type="checkbox" name="swsi_backup" value="1"> I have a recent backup of this site (database + files).</label></p>
		<p><button class="button button-primary button-hero" name="swsi_run" value="1">Install the new Southwestern Solutions site</button></p>
	</form>
	</div>
	<?php
}

/** Copy a directory recursively. */
function swsi_copy_dir( $src, $dst ) {
	wp_mkdir_p( $dst );
	$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $src, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::SELF_FIRST );
	foreach ( $it as $item ) {
		$target = $dst . '/' . $it->getSubPathName();
		if ( $item->isDir() ) {
			wp_mkdir_p( $target );
		} else {
			copy( $item->getPathname(), $target );
		}
	}
}

function swsi_load_importer() {
	if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
		define( 'WP_LOAD_IMPORTERS', true );
	}
	require_once ABSPATH . 'wp-admin/includes/import.php';
	if ( ! class_exists( 'WP_Importer' ) ) {
		require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	}
	if ( ! class_exists( 'WP_Import' ) ) {
		$v = SWSI_DIR . 'vendor/wordpress-importer/';
		require_once $v . 'compat.php';
		if ( ! class_exists( 'WXR_Parser' ) ) {
			require_once $v . 'parsers/class-wxr-parser.php';
			require_once $v . 'parsers/class-wxr-parser-simplexml.php';
			require_once $v . 'parsers/class-wxr-parser-xml.php';
			require_once $v . 'parsers/class-wxr-parser-regex.php';
		}
		require_once $v . 'class-wp-import.php';
	}
}

function swsi_import( $file ) {
	swsi_load_importer();
	$importer                    = new WP_Import();
	$importer->fetch_attachments = false;
	ob_start();
	$importer->import( $file );
	$out = ob_get_clean();
	return false !== strpos( $out, 'All done' ) ? 'OK' : wp_strip_all_tags( substr( $out, 0, 300 ) );
}

function swsi_run() {
	@set_time_limit( 300 ); // phpcs:ignore
	$log = array();

	// 1. Theme.
	$dest = get_theme_root() . '/' . SWSI_THEME;
	swsi_copy_dir( SWSI_DIR . 'theme/' . SWSI_THEME, $dest );
	wp_clean_themes_cache();
	switch_theme( SWSI_THEME );
	$log[] = 'Theme installed and activated: <strong>' . esc_html( wp_get_theme()->get( 'Name' ) ) . '</strong>';
	if ( ! function_exists( 'sws_auto_setup' ) ) {
		require_once $dest . '/functions.php';
	}

	// 2/3. Move conflicting content to the Trash (WordPress frees the slug when trashing).
	$trash = swsi_find( 'page', array_merge( swsi_page_slugs(), swsi_legacy_page_slugs() ) );
	if ( post_type_exists( 'product' ) ) {
		$trash += swsi_find( 'product', swsi_product_slugs() );
	}
	foreach ( $trash as $id => $slug ) {
		$title = get_the_title( $id );
		$type  = get_post_type( $id );
		if ( (int) get_option( 'page_on_front' ) === $id ) {
			update_option( 'show_on_front', 'posts' );
		}
		wp_trash_post( $id );
		$log[] = 'Moved to Trash: ' . esc_html( $type . ' “' . $title . '” (/' . $slug . '/)' );
	}

	// Keep an existing "Main Menu" from merging with the imported one.
	$old_menu = get_term_by( 'slug', 'main-menu', 'nav_menu' );
	if ( $old_menu ) {
		wp_update_term( $old_menu->term_id, 'nav_menu', array( 'name' => 'Main Menu (old)', 'slug' => 'main-menu-old' ) );
		$log[] = 'Renamed existing menu “Main Menu” to “Main Menu (old)”.';
	}

	// 4. Import.
	$log[] = 'Pages + menu import: ' . esc_html( swsi_import( SWSI_DIR . 'data/southwestern-solutions.WordPress.xml' ) );
	if ( class_exists( 'WooCommerce' ) ) {
		$log[] = 'Course products import: ' . esc_html( swsi_import( SWSI_DIR . 'data/southwestern-solutions-products.WordPress.xml' ) );
	} else {
		$log[] = 'Course products skipped (WooCommerce not active).';
	}

	// 5. Settings.
	delete_option( 'sws_setup_done' );
	delete_option( 'sws_wc_setup_done' );
	if ( function_exists( 'sws_auto_setup' ) ) {
		sws_auto_setup();
	}
	if ( function_exists( 'sws_wc_auto_setup' ) && class_exists( 'WooCommerce' ) ) {
		sws_wc_auto_setup();
	}
	$menu = wp_get_nav_menu_object( 'main-menu' );
	if ( $menu ) {
		$locs            = get_theme_mod( 'nav_menu_locations', array() );
		$locs['primary'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locs );
	}
	if ( '/%postname%/' !== get_option( 'permalink_structure' ) ) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	}
	flush_rewrite_rules();
	$front = (int) get_option( 'page_on_front' );
	$log[] = 'Home page: ' . ( $front ? '“' . esc_html( get_the_title( $front ) ) . '”' : 'not set' ) . ' · Permalinks: ' . esc_html( get_option( 'permalink_structure' ) ) . ' · Menu: ' . ( $menu ? 'Main Menu → Primary' : 'not found' );

	// Verify URLs.
	foreach ( array( 'about-us', 'courses', 'chemical-agent-instructor-course', 'less-lethal-instructor-course', 'ab-48-compliance', 'training-schedule', 'host-a-course', 'faq', 'contact' ) as $slug ) {
		$p = get_page_by_path( $slug );
		$log[] = ( $p ? '✅ ' : '❌ ' ) . '/' . $slug . '/' . ( $p ? '' : ' — missing' );
	}
	if ( post_type_exists( 'product' ) ) {
		foreach ( array( 'chemical-agent-instructor-course', 'less-lethal-instructor-course' ) as $slug ) {
			$p = get_page_by_path( $slug, OBJECT, 'product' );
			$log[] = ( $p ? '✅ ' : '❌ ' ) . '/product/' . $slug . '/' . ( $p ? '' : ' — missing' );
		}
	}

	update_option( 'swsi_done', current_time( 'mysql' ) );
	return $log;
}
