<?php
/**
 * One-time site configuration after the XML import, and the lead handler.
 */

defined( 'ABSPATH' ) || exit;

/**
 * After the import, set the static front page, blog page and pretty
 * permalinks. Runs once on the first admin load where the pages exist.
 */
add_action(
	'admin_init',
	function () {
		if ( get_option( 'dmc_setup_done' ) ) {
			return;
		}
		$home = get_page_by_path( 'home' );
		$blog = get_page_by_path( 'blog' );
		if ( ! $home || ! $blog ) {
			return;
		}
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
		update_option( 'page_for_posts', $blog->ID );
		update_option( 'posts_per_page', 9 );
		if ( ! get_option( 'permalink_structure' ) ) {
			update_option( 'permalink_structure', '/%postname%/' );
		}
		update_option( 'blogdescription', 'Bariatric Surgery & Metabolic Medicine in Tijuana' );
		flush_rewrite_rules();
		update_option( 'dmc_setup_done', 1 );
	}
);

/** Private store for leads, so none are lost if email delivery fails. */
add_action(
	'init',
	function () {
		register_post_type(
			'dmc_lead',
			array(
				'labels'          => array( 'name' => 'Patient Leads', 'singular_name' => 'Patient Lead' ),
				'public'          => false,
				'show_ui'         => true,
				'menu_icon'       => 'dashicons-groups',
				'supports'        => array( 'title', 'editor' ),
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
			)
		);
	}
);

/** Lead form handler. */
function dmc_handle_lead() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'dmc_lead', $back );

	$valid = isset( $_POST['dmc_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dmc_nonce'] ) ), 'dmc_lead' );
	if ( ! $valid || ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'dmc_lead', 'error', $back ) . '#contact-form' );
		exit;
	}

	$fields = array();
	foreach ( array( 'name', 'email', 'phone', 'procedure', 'height', 'weight', 'message', 'lang', 'source' ) as $k ) {
		$raw          = isset( $_POST[ $k ] ) ? wp_unslash( $_POST[ $k ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$fields[ $k ] = 'message' === $k ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
	}
	if ( ! $fields['name'] || ! is_email( $fields['email'] ) || ! $fields['phone'] ) {
		wp_safe_redirect( add_query_arg( 'dmc_lead', 'error', $back ) . '#contact-form' );
		exit;
	}

	$to   = dmc_opt( 'dmc_email' ) ? dmc_opt( 'dmc_email' ) : get_option( 'admin_email' );
	$body = '';
	foreach ( $fields as $k => $v ) {
		$body .= ucfirst( $k ) . ': ' . $v . "\n";
	}
	$sent = wp_mail(
		$to,
		'New patient lead — ' . $fields['name'] . ' (' . ( $fields['procedure'] ? $fields['procedure'] : 'general' ) . ')',
		$body,
		array( 'Reply-To: ' . $fields['name'] . ' <' . $fields['email'] . '>' )
	);

	$saved = wp_insert_post(
		array(
			'post_type'    => 'dmc_lead',
			'post_status'  => 'private',
			'post_title'   => $fields['name'] . ' — ' . ( $fields['procedure'] ? $fields['procedure'] : 'general' ),
			'post_content' => $body,
		)
	);

	wp_safe_redirect( add_query_arg( 'dmc_lead', ( $sent || $saved ) ? 'ok' : 'error', $back ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_dmc_lead', 'dmc_handle_lead' );
add_action( 'admin_post_dmc_lead', 'dmc_handle_lead' );
