<?php
/**
 Plugin Name: MarketPress Features
 Plugin URI:http://xpeedstudio.com
 Description: MarketPress Features is a plugin for our FundPress Theme.
 Author: xpeedstudio
 Author URI: http://xpeedstudio.com
 Version:1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define("XS_PLUGIN_DIR", plugin_dir_path(__FILE__ ));

class Xs_Main{

	/**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     */
    
	public static $_instance;

	/**
     * Plugin Name
     *
     * @since 1.0.0
     *
     */

	public $plugin_name = 'Finances Assistance';

	/**
     * Plugin Version
     *
     * @since 1.0.0
     *
     */

	public $plugin_version = '1.0.0';

	/**
     * Plugin File
     *
     * @since 1.0.0
     *
     */

	public $file = __FILE__;

	/**
     * Load Construct
     * 
     * @since 1.0.0
     */

	public function __construct(){
		$this->xs_plugin_init();
		$this->xs_file_include();
	}

	/**
     * Plugin Initialization
     *
     * @since 1.0.0
     *
     */

	public function xs_plugin_init(){

		require_once (plugin_dir_path($this->file). 'post-type/xs-post-class.php');
        add_action( 'wp_enqueue_scripts', array( $this, 'xs_enque_script'));
		
	}
	public function xs_file_include(){

		require_once (plugin_dir_path($this->file). 'init.php');
     
		
	}
    public function xs_enque_script(){

        $translations_array = array(
            'marketo_script' => plugin_dir_url($this->file).'api/tweet.php',
        );
        wp_localize_script('marketo-tweetie', 'marketo_path', $translations_array);

    }
	public static function xs_get_instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Xs_Main();
        }
        return self::$_instance;
    }

}
$Xs_Main = Xs_Main::xs_get_instance();