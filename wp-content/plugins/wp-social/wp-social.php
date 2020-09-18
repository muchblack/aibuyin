<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
 * Plugin Name: Wp Social
 * Plugin URI: https://wpmet.com/
 * Description: Wp Social Login / Social Sharing / Social Counter System for Facebook, Google, Twitter, Linkedin, Dribble, Pinterest, Wordpress, Instagram, GitHub, Vkontakte, Reddit and more providers.
 * Author: Wpmet
 * Version: 1.4.0
 * Author URI: https://wpmet.com/
 * Text Domain: wp-social
 * License: GPL2+
 * Domain Path: /languages/
**/

define('WSLU_VERSION', '1.4.0');
define('WSLU_VERSION_PREVIOUS_STABLE_VERSION', '1.3.11');

define("WSLU_LOGIN_PLUGIN", plugin_dir_path(__FILE__));
define("WSLU_LOGIN_PLUGIN_URL", plugin_dir_url(__FILE__));


require(WSLU_LOGIN_PLUGIN . 'autoload.php');

/**
 * Load Text Domain
 */
if( ! function_exists('wslu_social_init')) :
	function wslu_social_init() {
		load_plugin_textdomain('wp-social', false, dirname(plugin_basename(__FILE__)) . '/languages');

		if(file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
			WpSocialXs\Elementor\Elements::instance()->_init();
		}

		do_action('wslu_social/plugin_loaded');
	}


	add_action('plugins_loaded', 'wslu_social_init', 118);
endif;


/**
 * Active Plugin
 */
if( ! function_exists('xs_social_plugin_activate')) :
	function xs_social_plugin_activate() {
		$counter = New \XsSocialCount\Counter(false);
		$counter->xs_counter_defalut_providers();
	}

	register_activation_hook(__FILE__, 'xs_social_plugin_activate');

	// custom function added
	if(file_exists(WSLU_LOGIN_PLUGIN . 'inc/custom-function.php')) {
		include(WSLU_LOGIN_PLUGIN . 'inc/custom-function.php');
	}
endif;


if(!function_exists('wp_social_admin_enqueue')) {

	function wp_social_admin_enqueue() {

		$screen = get_current_screen();

		wp_register_script( 'wp_social_footer', WSLU_LOGIN_PLUGIN_URL. 'assets/js/hearbeat_all.js', ['jquery', 'heartbeat'], '1.1.1', true );
		wp_enqueue_script('wp_social_footer');

		if($screen->id == 'wp-social_page_wslu_data_migration') {
			wp_register_script( 'wp_social_footer2', WSLU_LOGIN_PLUGIN_URL. 'assets/js/heartbeat_data_conversion.js', ['jquery', 'heartbeat'], '1.1.1', true );
			wp_enqueue_script('wp_social_footer2');
		}
	}
}

function xs_heartbeat_settings( $settings ) {

	$settings['interval'] = 15; //Anything between 15-120
	//$settings['autostart'] = false;

	return $settings;
}


function xs_social_heartbeat_received($response, $data) {

	$response['client_push']['log'][] = 'heartbeat received...';

	if(isset($data['global'])) {

		$response['client_push']['global'][] = 'global data received and processed.... global = '.$data['global'];
	}

	if(isset($data['gd_client'])) {

		$response['client_push']['global'][] = 'global data received and processed.... gd_client = '.$data['gd_client'];
	}

	if(isset($data['pd_client'])) {

		$response['client_push']['page'][] = 'page data received and processed.... pd_client = '.$data['pd_client'];
	}


	if(isset($data['requesting_page']) && $data['requesting_page'] == 'wp-social_page_wslu_data_migration') {

		$response['client_push']['page'][] = '.............................................................';

		if(isset($data['page']['wp-social_page_wslu_data_migration'])) {

			$response['client_push']['page'][] = 'Data received from specific page and processing ...... == '.$data['page']['wp-social_page_wslu_data_migration'];

		} else {

			$response['client_push']['page'][] = 'Supposed to have some data from specific page!!!';
		}

	}

	$response['client_push']['log'][] = $data;


	return $response;
}

function send_data_to_heartbeat( $data, $screen_id ) {

	$data['server_push'][] = 'Some notification from heartbeat send';

	return $data;
}


add_filter( 'heartbeat_settings', 'xs_heartbeat_settings' );

add_action("admin_enqueue_scripts", "wp_social_admin_enqueue");
add_filter('heartbeat_received', 'xs_social_heartbeat_received', 10, 2);
//add_filter( 'heartbeat_send', 'send_data_to_heartbeat', 10, 2 );

WP_Social\Login::instance()->init();
\WP_Social\App\Avatar::instance()->init();
