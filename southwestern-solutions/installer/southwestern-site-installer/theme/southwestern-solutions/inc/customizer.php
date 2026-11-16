<?php
/**
 * Customizer → Business Info (phone, email, city, hours, social profiles).
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section( 'sws_business', array( 'title' => __( 'Business Info', 'sws' ), 'priority' => 30 ) );
		$fields = array(
			'phone'     => 'Phone',
			'email'     => 'Email',
			'city'      => 'City',
			'zip'       => 'ZIP code',
			'region'    => 'State (2 letters)',
			'hours'     => 'Office hours',
			'facebook'  => 'Facebook URL',
			'instagram' => 'Instagram URL',
			'linkedin'  => 'LinkedIn URL',
			'youtube'   => 'YouTube URL',
		);
		foreach ( $fields as $key => $label ) {
			$wp_customize->add_setting( 'sws_' . $key, array( 'default' => sws_opt( $key ), 'sanitize_callback' => in_array( $key, array( 'facebook', 'instagram', 'linkedin', 'youtube' ), true ) ? 'esc_url_raw' : 'sanitize_text_field' ) );
			$wp_customize->add_control( 'sws_' . $key, array( 'label' => $label, 'section' => 'sws_business', 'type' => 'text' ) );
		}
	}
);
