<?php
/**
 * Dokan functions and definitions
 *
 * @package Dokan
 * @since Dokan 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Dokan 1.0
 */

if ( !isset( $content_width ) ) {
    $content_width = 640;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since Dokan 1.0
 */
class WeDevs_Dokan_Theme {

    function __construct() {

        //includes file
        $this->includes();

        // init actions and filter
        $this->init_filters();
        $this->init_actions();

        // initialize classes
        $this->init_classes();
    }

    /**
     * Initialize filters
     *
     * @return void
     */
    function init_filters() {
        add_filter( 'wp_title', array( $this, 'wp_title' ), 10, 2 );
        add_filter( 'dokan_ls_theme_tags', array( $this, 'live_search_support' ), 10, 2 );
    }

    /**
     * Init action hooks
     *
     * @return void
     */
    function init_actions() {
        add_action( 'after_setup_theme', array( $this, 'setup' ) );
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
        add_action( 'dokan_admin_menu', array( $this, 'slider_page' ) );
    }

    public function init_classes() {
        Dokan_Slider::init();
    }


    function includes() {
        $lib_dir     = dirname( __FILE__ ) . '/lib/';   
        $inc_dir     = dirname( __FILE__ ) . '/includes/';
        $classes_dir = dirname( __FILE__ ) . '/classes/';

        require_once $classes_dir . 'slider.php';

        require_once $inc_dir . 'wc-functions.php';
        require_once $inc_dir . 'wc-template.php';

        // 線上點餐串接
        require_once $inc_dir . 'SMEConnect.php';
        //GOGOVAN串接
        require_once $inc_dir . 'DeliveryGOGOVAN.php';

        if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/classes/customizer.php' ) ) {
            require_once get_stylesheet_directory() . '/classes/customizer.php';
        } else {
            require_once $classes_dir . 'customizer.php';
        }

        if ( is_admin() ) {

        } else {
            require_once $lib_dir . 'bootstrap-walker.php';
            require_once $inc_dir . 'template-tags.php';
        }
    }

    /**
     * Setup dokan
     *
     * @uses `after_setup_theme` hook
     */
    function setup() {

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         */
        load_theme_textdomain( 'dokan-theme', get_template_directory() . '/languages' );

        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Enable support for Post Thumbnails
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus( array(
            'primary'  => __( 'Primary Menu', 'dokan-theme' ),
            'top-left' => __( 'Top Left', 'dokan-theme' ),
            'footer'   => __( 'Footer Menu', 'dokan-theme' ),
        ) );

        add_theme_support( 'woocommerce' );

        // Support gallery image for single product page
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        /*
         * This theme supports custom background color and image,
         * and here we also set up the default background color.
         */
        add_theme_support( 'custom-background', array(
            'default-color' => 'F7F7F7',
        ) );

        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
    }

    /**
    * Live search module on support
    *
    * @since 2.3.1
    *
    * @return void
    **/
    public function live_search_support( $themes ) {
        $themes['dokan-theme'] = '#primary';
        return $themes;
    }

    /**
     * Register widgetized area and update sidebar with default widgets
     *
     * @since Dokan 1.0
     */
    function widgets_init() {

        $sidebars = array(
            array( 'name' => __( 'General Sidebar', 'dokan-theme' ), 'id' => 'sidebar-1' ),
            array( 'name' => __( 'Home Sidebar', 'dokan-theme' ), 'id' => 'sidebar-home' ),
            array( 'name' => __( 'Blog Sidebar', 'dokan-theme' ), 'id' => 'sidebar-blog' ),
            array( 'name' => __( 'Header Sidebar', 'dokan-theme' ), 'id' => 'sidebar-header' ),
            array( 'name' => __( 'Shop Archive', 'dokan-theme' ), 'id' => 'sidebar-shop' ),
            array( 'name' => __( 'Single Product', 'dokan-theme' ), 'id' => 'sidebar-single-product' ),
            array( 'name' => __( 'Footer Sidebar - 1', 'dokan-theme' ), 'id' => 'footer-1' ),
            array( 'name' => __( 'Footer Sidebar - 2', 'dokan-theme' ), 'id' => 'footer-2' ),
            array( 'name' => __( 'Footer Sidebar - 3', 'dokan-theme' ), 'id' => 'footer-3' ),
            array( 'name' => __( 'Footer Sidebar - 4', 'dokan-theme' ), 'id' => 'footer-4' ),
        );

        $args = apply_filters( 'dokan_widget_args', array(
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );

        foreach ( $sidebars as $sidebar ) {

            $args['name'] = $sidebar['name'];
            $args['id'] = $sidebar['id'];

            register_sidebar( $args );
        }
    }

    /**
     * Enqueue scripts and styles
     *
     * @since Dokan 1.0
     */
    function scripts() {

        $protocol           = is_ssl() ? 'https' : 'http';
        $template_directory = get_template_directory_uri();
        $skin               = get_theme_mod( 'color_skin', 'orange.css' );

        wp_register_style( 'dokan-fontawesome', $template_directory . '/assets/css/font-awesome.min.css', false, null );

        // register styles
        wp_enqueue_style( 'bootstrap', $template_directory . '/assets/css/bootstrap.css', false, null );
        wp_enqueue_style( 'flexslider', $template_directory . '/assets/css/flexslider.css', false, null );
        wp_enqueue_style( 'dokan-fontawesome' );
        wp_enqueue_style( 'dokan-opensans', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:400,700' );
        wp_enqueue_style( 'dokan-theme', $template_directory . '/style.css', false, null );
        wp_enqueue_style( 'dokan-theme-skin', $template_directory . '/assets/css/skins/' . $skin, false, null );

        /****** Scripts ******/
        if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        if ( is_singular() && wp_attachment_is_image() ) {
            wp_enqueue_script( 'keyboard-image-navigation', $template_directory . '/assets/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
        }

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui' );

        wp_enqueue_script( 'bootstrap-min', $template_directory . '/assets/js/bootstrap.min.js', false, null, true );
        wp_enqueue_script( 'flexslider', $template_directory . '/assets/js/jquery.flexslider-min.js', array( 'jquery' ) );

        wp_enqueue_script( 'dokan-theme-scripts', $template_directory . '/assets/js/script.js', false, null, true );
    }

    /**
     * Create a nicely formatted and more specific title element text for output
     * in head of document, based on current view.
     *
     * @since Dokan 1.0.4
     *
     * @param string  $title Default title text for current view.
     * @param string  $sep   Optional separator.
     * @return string The filtered title.
     */
    function wp_title( $title, $sep ) {
        global $paged, $page;

        if ( is_feed() ) {
            return $title;
        }

        // Add the site name.
        $title .= get_bloginfo( 'name' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title = "$title $sep $site_description";
        }

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 ) {
            $title = "$title $sep " . sprintf( __( 'Page %s', 'dokan-theme' ), max( $paged, $page ) );
        }

        return $title;
    }

    public function slider_page() {
        add_submenu_page( 'themes.php', __( 'Slider', 'dokan-theme' ), __( 'Slider', 'dokan-theme' ), 'manage_options', 'edit.php?post_type=dokan_slider' );
    }

}

/*********************************************************************
*
*
購物車結帳
*
*
*********************************************************************/

/*----------------
這裡放置要改名的欄位
----------------*/
/*//將連絡電話改成手機
add_filter( 'woocommerce_billing_fields', 'custom_billing_phone_label' );
function custom_billing_phone_label($fields) {
    $fields['billing_phone'] = array(
    'label'=>""
    );
    return $fields;
}*/
//將姓氏改為姓名
add_filter( 'woocommerce_billing_fields', 'custom_billing_name_label' );
function custom_billing_name_label($fields) {
    $fields['billing_last_name'] = array(
    'label'=>"訂購人",
    'required' => true,
    );
    return $fields;
}

/*----------------
將必填改成非必填
----------------*/

//隱藏公司名稱
add_filter( 'woocommerce_billing_fields', 'remove_billing_company' );
function remove_billing_company($fields){
    unset($fields['billing_company']);
    return $fields;
}

/*//切換運送方式
function mxp_hidden_checkout_fields_base_on_shipping_method($value) {
	// 判斷當前選擇到的運送方式
	$chosen_methods = WC()->session->get('chosen_shipping_methods');
    $chosen_shipping = current(explode(':', $chosen_methods[0]));
	$fields = WC()->checkout->get_checkout_fields('billing');
	$html = "";
	foreach ($fields as $key => $field) {
		$field['return'] = true;
        $html .= woocommerce_form_field($key, $field, WC()->checkout->get_value($key));
    }
    

    return $value;

    
}
add_filter('woocommerce_update_order_review_fragments', 'mxp_hidden_checkout_fields_base_on_shipping_method', 999, 1);
*/

//判斷當前選擇到的運送方式
function mxp_hidden_checkout_fields_base_on_shipping_method($value) {
    $chosen_methods = WC()->session->get('chosen_shipping_methods');
    $chosen_shipping = current(explode(':', $chosen_methods[0]));
    if ($chosen_shipping == 'local_pickup:3') { //內用
        $fields = WC()->checkout->get_checkout_fields('billing');
        $html = "";
        foreach ($fields as $key => $field) {
            $field['return'] = true;
            if ($key == 'billing_company' || $key == 'billing_first_name' || $key == 'billing_country' || $key == 'billing_postcode' || $key == 'billing_address_1' || $key == 'billing_address_2' || $key == 'billing_city' || $key == 'billing_email' || $key == 'billing_state' || $key == 'billing_phone') {
                $field['class'] = array('hidden');
                $field['type'] = 'hidden';
                $field['required'] = false;
            }
            //$html .= woocommerce_form_field($key, $field, WC()->checkout->get_value($key));
        }
        table_number_method(); //顯示桌號
        eating_time_method(); //顯示預約來店用餐時間
        $value['.woocommerce-billing-fields__field-wrapper'] = '<div class="woocommerce-billing-fields__field-wrapper">' . $html . '</div>';
    } else if($chosen_shipping == 'free_shipping:2'){ //外送
        $fields = WC()->checkout->get_checkout_fields('billing');
        $html = "";
        foreach ($fields as $key => $field) {
            $field['return'] = true;
            if ($key == 'billing_company' || $key == 'billing_first_name' || $key == 'billing_country' || $key == 'billing_email') {
                $field['class'] = array('hidden');
                $field['type'] = 'hidden';
                $field['required'] = false;
            }
            $html .= woocommerce_form_field($key, $field, WC()->checkout->get_value($key));
        }
        arrival_time_method(); //顯示預約送達期望時間
        $value['.woocommerce-billing-fields__field-wrapper'] = '<div class="woocommerce-billing-fields__field-wrapper">' . $html . '</div>';
    } else if($chosen_shipping == 'local_pickup:1'){ //外帶
        $fields = WC()->checkout->get_checkout_fields('billing');
        $html = "";
        foreach ($fields as $key => $field) {
            $field['return'] = true;
            if ($key == 'billing_company' || $key == 'billing_first_name' || $key == 'billing_country' || $key == 'billing_postcode' || $key == 'billing_address_1' || $key == 'billing_address_2' || $key == 'billing_city' || $key == 'billing_email' || $key == 'billing_state') {
                $field['class'] = array('hidden');
                $field['type'] = 'hidden';
                $field['required'] = false;
            }
            $html .= woocommerce_form_field($key, $field, WC()->checkout->get_value($key));
        }
        take_meal_time_method(); //顯示預約來店取餐時間
        $value['.woocommerce-billing-fields__field-wrapper'] = '<div class="woocommerce-billing-fields__field-wrapper">' . $html . '</div>';
    } else {
        $fields = WC()->checkout->get_checkout_fields('billing');
        $html = "";
        foreach ($fields as $key => $field) {
            $field['return'] = true;
            $html .= woocommerce_form_field($key, $field, WC()->checkout->get_value($key));
        }
        $value['.woocommerce-billing-fields__field-wrapper'] = '<div class="woocommerce-billing-fields__field-wrapper">' . $html . '</div>';
    }

    return $value;
}
add_filter('woocommerce_update_order_review_fragments', 'mxp_hidden_checkout_fields_base_on_shipping_method', 999, 1);

/**************************
 * 三種不同類型的時間呈現方法
 *************************/

function time_array(){
    date_default_timezone_set("Asia/Taipei");
    $hour = date("G");
    $i = date("i");

    $time_array = array();
    $j = 0;
    while(true){
        if( $j==0 ){
            $time_array[$j] = "請選擇時間";
        }else if( $j==1 ){
             $time_array[$j] = "即時";
        }else{
            if($i>=30){
                if($hour+1 == 24){
                    break;
                }
                $time_array[($hour+1).":00"] = ($hour+1).":00";
                $hour++;
                $i-=31;
            }else{
                $time_array[($hour).":30"] = ($hour).":30";
                $i+=31;
            }
        }
        $j++;
    }

    return $time_array;
}

function time_array_far($value = 0){
    date_default_timezone_set("Asia/Taipei");
    $hour = date("G");
    $i = date("i");

    $time_array = array();
    $j = 0;
    while(true){
        if( $j==0 ){
            $time_array[$j] = "請選擇時間";
        }else if( $j==1 ){
             $time_array[$j] = "即時";
        }else{
            if($i>=30){
                if($hour+1 == 24){
                    break;
                }
                $time_array[($hour+1).":00"] = ($hour+1).":00";
                $hour++;
                $i-=31;
            }else{
                $time_array[($hour).":30"] = ($hour).":30";
                $i+=31;
            }
        }
        $j++;
    }

    return $time_array;
}

/*** 內用->預約來店用餐時間 ***/
function eating_time_method(){?>
<?php
    //新增預約來店用餐時間
    add_action( 'woocommerce_before_order_notes', 'add_eating_time' );
    function add_eating_time( $checkout ) {
        if(2==2){ //距離近時
            woocommerce_form_field( 'eating_time', array(
                'type' => 'select',
                'class' => array( 'form-row-wide' ),
                'label' => '預約來店用餐時間',
                'options' => time_array(),
                'default' => 0,
                'required' => true,
            ),$checkout->get_value( 'eating_time' ));
        }else{ //距離遠時
            woocommerce_form_field( 'eating_time', array(
                'type' => 'select',
                'class' => array( 'form-row-wide' ),
                'label' => '預約來店用餐時間',
                'options' => time_array_far(),
                'default' => 1,
                'required' => true
            ),$checkout->get_value( 'eating_time' ));
        }
    }
    //儲存預約來店用餐時間資料至資料庫
    add_action('woocommerce_checkout_update_order_meta', 'update_eating_time_data');
    function update_eating_time_data( $order_id ) {
        if ($_POST['eating_time']){
            update_post_meta( $order_id, 'eating_time', esc_attr($_POST['eating_time']));
        }
    }
    //在後台顯示預約來店用餐時間資料
    add_action( 'woocommerce_admin_order_data_after_shipping_address', 'eating_time_order_meta', 10, 1 );
    function eating_time_order_meta($order){
        echo '<p><strong>預約來店用餐時間:</strong> ' . get_post_meta( $order->id, 'eating_time', true ) . '</p>';
    }
}

/*** 外帶->預約來店取餐時間 ***/
function take_meal_time_method(){
    //新增預約來店取餐時間
    add_action( 'woocommerce_before_order_notes', 'add_take_meal_time' );
    function add_take_meal_time( $checkout ) {
        if(true){ //距離近時
            woocommerce_form_field( 'take_meal_time', array(
                'type' => 'select',
                'class' => array( 'form-row-wide' ),
                'label' => '預約來店取餐時間',
                'options' => time_array(),
                'default' => "即時1",
                'required' => true,
            ),$checkout->get_value( 'take_meal_time' ));
        }else{ //距離遠時
            woocommerce_form_field( 'take_meal_time', array(
                'type' => 'select',
                'class' => array( 'form-row-wide' ),
                'label' => '預約來店取餐時間',
                'options' => time_array_far(),
                'default' => '請選擇時間1',
                'required' => true,
            ),$checkout->get_value( 'take_meal_time' ));
        }
    }
    //儲存預約來店取餐時間資料至資料庫
    add_action('woocommerce_checkout_update_order_meta', 'update_take_meal_time_data');
    function update_take_meal_time_data( $order_id ) {
        if ($_POST['take_meal_time']){
            update_post_meta( $order_id, 'take_meal_time', esc_attr($_POST['take_meal_time']));
        }
    }
    //在後台顯示預約來店取餐時間資料
    add_action( 'woocommerce_admin_order_data_after_shipping_address', 'take_meal_time_order_meta', 10, 1 );
    function take_meal_time_order_meta($order){
        echo '<p><strong>預約來店取餐時間:</strong> ' . get_post_meta( $order->id, 'take_meal_time', true ) . '</p>';
    }
}

/*** 外送->預約送達期望時間 ***/
function arrival_time_method(){
    //新增預約送達期望時間
    add_action( 'woocommerce_before_order_notes', 'arrival_time' );
    function arrival_time( $checkout ) {
        if(true){ //距離近時
            woocommerce_form_field( 'arrival_time', array(
                'type' => 'select',
                'class' => array( 'form-row-wide' ),
                'label' => '預約送達期望時間',
                'options' => time_array(),
                'default' => "即時",
                'required' => true,
            ),$checkout->get_value( 'arrival_time' ));
        }else{ //距離遠時
            woocommerce_form_field( 'arrival_time', array(
                'type' => 'select',
                'class' => array( 'form-row-wide' ),
                'label' => '預約送達期望時間',
                'options' => time_array(),
                'default' => '請選擇時間',
                'required' => true,
            ),$checkout->get_value( 'arrival_time' ));
        }
    }
    //儲存預約送達期望時間資料至資料庫
    add_action('woocommerce_checkout_update_order_meta', 'update_arrival_time_time_data');
    function update_arrival_time_time_data( $order_id ) {
        if ($_POST['arrival_time']){
            update_post_meta( $order_id, 'arrival_time', esc_attr($_POST['arrival_time']));
        }
    }
    //在後台顯示預約送達期望時間資料
    add_action( 'woocommerce_admin_order_data_after_shipping_address', 'take_arrival_time_order_meta', 10, 1 );
    function take_arrival_time_order_meta($order){
        echo '<p><strong>預約送達期望時間:</strong> ' . get_post_meta( $order->id, 'arrival_time', true ) . '</p>';
    }
}

/*** 桌號方法 ***/
function table_number_method(){
    //新增桌號
    add_action( 'woocommerce_before_order_notes', 'add_table_number' );
    function add_table_number( $checkout ) {

        $table_number = array();
        for($i=1;$i<=99;$i++){
            $table_number[$i]= $i;
        }

        woocommerce_form_field( 'table_number', array(
            'type' => 'select',
            'class' => array( 'form-row-wide' ),
            'label' => '桌號',
            'options' => $table_number
        ),$checkout->get_value( 'table_number' ));
    }
    //儲存桌號資料至資料庫
    add_action('woocommerce_checkout_update_order_meta', 'update_table_number_data');
    function update_table_number_data( $order_id ) {
        if ($_POST['table_number']){
            update_post_meta( $order_id, 'table_number', esc_attr($_POST['table_number']));
        }
    }
    //在後台顯示桌號資料
    add_action( 'woocommerce_admin_order_data_after_shipping_address', 'table_number_order_meta', 10, 1 );
    function table_number_order_meta($order){
        echo '<p><strong>桌號:</strong> ' . get_post_meta( $order->id, 'table_number', true ) . '</p>';
    }
}

/*** 預約人數 ***/
function people_number_method(){
    //新增預約人數
    add_action( 'woocommerce_before_order_notes', 'add_people_number' );
    function add_people_number( $checkout ) {
        woocommerce_form_field( 'people_number', array(
            'type' => 'number',
            'class' => array( 'form-row-wide' ),
            'label' => '預約人數',
            'default' => 1,
            'required' => true
        ),$checkout->get_value( 'people_number' ));
    }
    //儲存預約人數資料至資料庫
    add_action('woocommerce_checkout_update_order_meta', 'people_number_field_data');
    function people_number_field_data( $order_id ) {
        if ($_POST['people_number']){
            update_post_meta( $order_id, 'people_number', esc_attr($_POST['people_number']));
        }
    } 
    //在後台顯示預約人數資料
    add_action( 'woocommerce_admin_order_data_after_shipping_address', 'people_number_order_meta', 10, 1 );
    function people_number_order_meta($order){
       echo '<p><strong>預約人數:</strong> ' . get_post_meta( $order->id, 'people_number', true ) . '</p>';
    } 
}

//新增預約日期
add_action( 'woocommerce_before_order_notes', 'add_date' );
function add_date( $checkout ) {
    woocommerce_form_field( 'date', array(
        'type' => 'date',
        'class' => array( 'form-row-wide' ),
        'label' => '預約日期',
        'default' => date("Y-m-d"),
        'required' => true
    ),$checkout->get_value( 'date' ));
}
//儲存預約日期資料至資料庫
add_action('woocommerce_checkout_update_order_meta', 'date_field_data');
function date_field_data( $order_id ) {
    if ($_POST['date']){
        update_post_meta( $order_id, 'date', esc_attr($_POST['date']));
    }
} 
//在後台顯示預約日期資料
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'date_order_meta', 10, 1 );
function date_order_meta($order){
   echo '<p><strong>預約日期:</strong> ' . get_post_meta( $order->id, 'date', true ) . '</p>';
} 

/**************************
 * 選擇運送方式
 *************************/
function mxp_checkout_fields_modify_base_on_shipping_method($fields) {
    //共同隱藏的欄位
    $hide_address_array = array(
        'billing_company', //隱藏公司名稱
        //'billing_last_name', //隱藏姓氏
        'billing_first_name', //隱藏名字
        'billing_country', //隱藏國家
        'billing_postcode', //隱藏郵遞區號
        'billing_address_1', //隱藏門牌號碼與街道名稱
        'billing_address_2', //隱藏公寓、套房、單位等
        'billing_city', //隱藏鄉鎮市
        'billing_email', //隱藏E-mail
        'billing_state', //隱藏縣、市
    );
    //不隱藏地址
    $hide_fields_array = array(
        'billing_company', //隱藏公司名稱
        //'billing_last_name', //隱藏姓氏
        'billing_first_name', //隱藏名字
        'billing_country', //隱藏國家
        'billing_email', //隱藏E-mail
    );
    $chosen_methods = WC()->session->get('chosen_shipping_methods');
    $chosen_shipping = $chosen_methods[0];

    //在店家附近時
    if ($chosen_shipping === 'local_pickup:3') { //內用
        //共同隱藏的欄位
        foreach($hide_address_array as $value){
            $fields['billing'][$value]['required'] = false;
            $fields['billing'][$value]['class'] = array('hidden');
            $fields['billing'][$value]['type'] = 'hidden';
        }
        //隱藏電話
        $fields['billing']['billing_phone']['required'] = false;
        $fields['billing']['billing_phone']['class'] = array('hidden');
        $fields['billing']['billing_phone']['type'] = 'hidden';
        //顯示桌號
        table_number_method();
        //顯示預約來店用餐時間
        eating_time_method();
        //顯示預約人數
        people_number_method();
    }else{
        //選擇要隱藏的欄位
        if($chosen_shipping === 'free_shipping:2'){ //外送
            $hide = $hide_fields_array; //僅隱藏非地址欄位
            arrival_time_method(); //顯示預約送達期望時間
        }else if ($chosen_shipping === 'local_pickup:1'){ //外帶
            $hide = $hide_address_array; //隱藏含地址欄位
            take_meal_time_method(); //顯示預約來店取餐時間
//            gogovan();
        }
        //隱藏欄位
        if($hide != null){
            foreach($hide as $value){
                $fields['billing'][$value]['required'] = false;
                $fields['billing'][$value]['class'] = array('hidden');
                $fields['billing'][$value]['type'] = 'hidden';
            }
        }
    }

    return $fields;
}

function SMEconnect(){
    global $wpdb;
    $SME = new SMEConnect();
    //取得前一天日期
    $yesterday = date("Y-m-d", strtotime('-1 day'));
    $yesterday_start = $yesterday."00:00:00";
    $yesterday_end = $yesterday."23:59:59";

    //撈出店家id和金鑰
    $keys = $wpdb->get_results("SELECT * FROM wp_store_keys WHERE store_id <> ''");

    $sql = "SELECT a.order_id,date_created,num_items_sold,total_sales 
            FROM `wp_dokan_orders` a 
            JOIN `wp_wc_order_stats` b 
            ON a.order_id = b.order_id 
            WHERE date_created > '$yesterday_start' AND date_created <= '$yesterday_end'";

    foreach ($keys as $item)
    {
        $SQL = $sql. " AND seller_id = ".$item->store_id;
        $rows = $wpdb->get_results($SQL);
        if($rows)
        {
            $send_data = [];
            foreach ( $rows as $row) {
                $send_data[] = [
                    "交易序號"=> $row->order_id,
                    "交易時間"=> $row->date_created,
                    "品項數"=> $row->num_items_sold,
                    "點餐金額"=> $row->total_sales
                ];
            }

            $SME->service_DATA1010($item->store_number,$item->store_keys,$send_data);
        }
    }

//    $rows = $wpdb->get_results( "SELECT * FROM wp_posts limit 10" );
//    var_dump($rows);
}

add_action('SME_order_sender','SMEconnect');

function gogovan()
{
//    $gogovan = new DeliveryGOGOVAN();
    $datas = DeliveryGOGOVAN::get_quotation();
}
//add_filter('woocommerce_checkout_fields', 'gogovan');

add_filter('woocommerce_checkout_fields', 'mxp_checkout_fields_modify_base_on_shipping_method', 999, 1);

$dokan = new WeDevs_Dokan_Theme();

//自動更新購物車總計價格
function designhu_auto_cart_update_qty_script() {
    ?>
      <script>
          jQuery('div.woocommerce').on('change', '.qty', function(){
             jQuery("[name='update_cart']").removeAttr('disabled');
             jQuery("[name='update_cart']").trigger("click");
          });
     </script>
  <?php
  }
  add_action('woocommerce_after_cart', 'designhu_auto_cart_update_qty_script');


add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
	$cell_phone = get_the_author_meta( 'cell_phone', $user->ID );
	?>

	<table class="form-table">
		<tr>
			<th><label for="cell_phone"><?php esc_html_e( '手機', 'crf' ); ?></label></th>
			<td>
				<input type="number"
			       id="cell_phone"
			       name="cell_phone"
			       value="<?php echo esc_attr( $cell_phone ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
	</table>
	<?php
}

add_action( 'personal_options_update', 'crf_update_profile_fields' );
add_action( 'edit_user_profile_update', 'crf_update_profile_fields' );

function crf_update_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	if ( ! empty( $_POST['cell_phone'] ) ) {
		update_user_meta( $user_id, 'cell_phone', intval( $_POST['cell_phone'] ) );
	}
}

//新增手機註冊
/*function wooc_extra_register_fields() {
    ?>

    <p class="form-row form-row-first">
    <label for="reg_cell_phone"><?php _e( '手機', 'woocommerce' ); ?><span class="required">*</span></label>
    <input type="text" class="input-text" name="cell_phone" id="reg_cell_phone" value="<?php if ( ! empty( $_POST['cell_phone'] ) ) esc_attr_e( $_POST['cell_phone'] ); ?>" />
    </p>

    <?php
}

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );*/

/*function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
    $phone_arr = str_split($_POST['cell_phone'],2);
    if ( strlen($_POST['cell_phone'])!=10 || $phone_arr[0] !="09" ) {
           $validation_errors->add( 'cell_phone_error', __( '請輸入正確手機格式 09xxxxxxxx', 'woocommerce' ) );
    }
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );*/

function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['cell_phone'] ) ) {
           update_user_meta( $customer_id, 'cell_phone', sanitize_text_field( $_POST['cell_phone'] ) );
    }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

//新增繼續購物
add_action('woocommerce_before_checkout_form','add_sale_word',10);
function add_sale_word(){
echo "<p style='color:red;'><a href='../store-listing/'>繼續購物</a></p>";
}