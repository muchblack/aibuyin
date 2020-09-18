<?php

defined('ABSPATH') || exit;

use \XsSocialCount\Settings;

/**
 * Class Name : xs_counter_widget;
 * Class Details : Create Widget for XS Social Login Plugin
 *
 * @params : void
 * @return : void
 *
 * @since : 1.0
 */
class xs_counter_widget extends \WP_Widget {

	public $styleArr = [];
	public $providers = [];
	private $hover_effect = [];

	public function __construct() {

		$widget_ops 	= array( 'classname' => 'xs_counter-widget', 'description' => __( 'Wp Social Login System for Facebook, Twitter, Linkedin, Dribble, Pinterest, Post, Comments counter.', 'wp-social' )  );
		parent::__construct( 'xs_counter_widget', __('WSLU Social Counter', 'wp-social'), $widget_ops, []);

		$this->styleArr = Settings::counter_styles();

		$option_key 	= 'xs_counter_providers_data';
		$xsc_options	 = get_option( $option_key ) ? get_option( $option_key ) : [];
		$counter_provider = isset($xsc_options['social']) ? $xsc_options['social'] : [];

		$this->providers = [];
		if(is_array($counter_provider) && sizeof($counter_provider) > 0){
			foreach( $counter_provider AS $k=>$v):
				if( isset($v['enable']) ){
					$this->providers[$k] = $v['label'];
				}
			endforeach;
		}
	}

	public static function register(){
		register_widget( 'xs_counter_widget' );
	}


	/**
	 *
	 * @author UnKnown
	 * @modifiedBy Md. Atiqur Rahman <atiqur.su@gmail.com>
	 *
	 * @param $args
	 * @param $instance
	 */
	public function widget( $args, $instance ) {

		extract( $args );

		$title 		= isset($instance['title']) ? $instance['title'] : '';
		$layout 	= isset($instance['layout']) ? $instance['layout'] : '';
		$hover 	    = isset($instance['hover_effect']) ? $instance['hover_effect'] : '';
		$providers 	= isset($instance['providers']) ? $instance['providers'] : '';
		$cusClass   = isset($instance['customclass']) ? $instance['customclass'] : '';
		$box_only 	= isset($instance['box_only']) ? $instance['box_only'] : false;


		$counter = New \XsSocialCount\Counter(false);

		$config = [];
		$config['class'] = $cusClass;
		$config['style'] = $layout;
		$config['hover'] = $hover;
		$providers = (is_array($providers) && !empty($providers) && !empty($providers[0])) ? $providers : 'all';

		echo $before_widget . $before_title . $title . $after_title;

		echo  $counter->get_counter_data( $providers , $config);

		echo $after_widget;
	}


	/**
	 *
	 * @author UnKnown
	 * @modifiedBy Md. Atiqur Rahman <atiqur.su@gmail.com>
	 *
	 * @param $instance
	 */
	public function form( $instance ) {

		$defaults = array( 'title' => __( 'Follow us' , 'wp-social' )  , 'layout' => 'block' , 'columns' => 'xs-3-column' , 'box_only' => false, 'providers' => '', 'customclass' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );
		$select_provider = is_array($instance['providers']) && !empty($instance['providers']) && !empty($instance['providers'][0]) ? $instance['providers'] : [];
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Counter Title :' , 'wp-social' ) ?> </label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'providers' ); ?>"><?php _e( 'Providers :' , 'wp-social' ) ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'providers' ); ?>" name="<?php echo $this->get_field_name( 'providers' ); ?>[]" multiple>
                <option value="" <?php echo empty($select_provider) ? 'selected' : '' ?>>All</option>
				<?php
				foreach($this->providers as $k=>$v):
					?>
                    <option value="<?php echo $k;?>" <?php echo (in_array($k, $select_provider)) ? 'selected' : ''; ?>> <?php _e($v, 'wp-social'); ?> </option>
				<?php endforeach;?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Style :' , 'wp-social' ) ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" >
				<?php
				foreach($this->styleArr as $k=>$v):
					?>
                    <option value="<?php echo (!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? 'wslu-pro-only' : $k;?>" <?php echo ($instance['layout'] == $k ) ? 'selected' : ''; ?>>
						<?php 
							echo esc_html($v['name']); 
							esc_html_e((!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? '(Pro Only)' : '', 'wp-social');
						?> 
					</option>
				<?php endforeach;?>
            </select>
        </p>

		<?php

		if(did_action('wslu_social_pro/plugin_loaded')):

			$this->hover_effect = \XsSocialSharePro\Inc\Admin_Settings::$counter_hover_effects;
		?>
            <p>
                <label for="<?php echo $this->get_field_id( 'hover_effect' ); ?>"><?php _e( 'Hover effect :' , 'wp-social' ) ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id( 'hover_effect' ); ?>" name="<?php echo $this->get_field_name( 'hover_effect' ); ?>" >
					<?php
					foreach($this->hover_effect as $k => $v):
						?>
                        <option value="<?php echo $k;?>" <?php echo (isset($instance['hover_effect']) && $instance['hover_effect'] == $k ) ? 'selected' : ''; ?>> <?php _e($v['name'], 'wp-social'); ?> </option>
					<?php endforeach;?>
                </select>
            </p>

			<?php

		endif; ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'customclass' ); ?>"><?php _e( 'Custom Class :' , 'wp-social' ) ?> </label>
            <input id="<?php echo $this->get_field_id( 'customclass' ); ?>" name="<?php echo $this->get_field_name( 'customclass' ); ?>" value="<?php echo $instance['customclass']; ?>" class="widefat" type="text" />
        </p>
		<?php
	}


	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['providers'] 	= $new_instance['providers'] ;
		$instance['layout'] 	= $new_instance['layout'] ;
		$instance['hover_effect'] 	= $new_instance['hover_effect'] ;
		$instance['title'] 		= $new_instance['title'] ;
		$instance['box_only'] 	= $new_instance['box_only'] ;
		$instance['customclass'] 	= $new_instance['customclass'] ;

		return $instance;
	}
}

add_action( 'widgets_init', 'xs_counter_widget::register' );
