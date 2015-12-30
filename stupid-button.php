<?php
/*
 * Plugin Name: Stupid Button
 * Plugin URI:
 * Description: Stupid button. Widget + Ajax
 * Version:
 * Author: Kailey Lampert
 * Author URI: kaileylampert.com
 * License: GPLv2 or later
 * TextDomain: stupid-button
 * DomainPath:
 * Network:
 */

require( plugin_dir_path( __FILE__ ) .'class.widget-stupid-button.php');

function stupid_button_ajax_increment() {
	$new_total = intval( get_option( 'stupid_button_counter' ) ) + 1;
	update_option( 'stupid_button_counter', $new_total );

	wp_send_json_success( stupid_button_status_text( $new_total ) );
}
add_action( 'wp_ajax_stupid-button-increment', 'stupid_button_ajax_increment' );
add_action( 'wp_ajax_nopriv_stupid-button-increment', 'stupid_button_ajax_increment' );

function stupid_button_ajax_reset() {
	update_option( 'stupid_button_counter', 0 );

	wp_send_json_success( stupid_button_status_text( 0 ) );
}
add_action( 'wp_ajax_stupid-button-reset', 'stupid_button_ajax_reset' );
add_action( 'wp_ajax_nopriv_stupid-button-reset', 'stupid_button_ajax_reset' );


function stupid_button_status_text( $total ) {
	return sprintf(
			_n(
				'This button has been clicked %d time since last reset',
				'This button has been clicked %d times since last reset',
				$total,
				'stupid-button'
			), $total );
}
/**
 * Widget registration
 */
function register_widget_stupid_button() {
	register_widget( 'Widget_Stupid_Button' );
}
add_action( 'widgets_init', 'register_widget_stupid_button' );
