<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * nav serch widgets
 */
class Xs_Nav_Cart extends Widget_Base {


    public function get_name() {
        return 'xs-nav-cart';
    }

    public function get_title() {
        return esc_html__( 'Marketo Nav Cart', 'marketo' );
    }

    public function get_icon() {
        return 'eicon-cart-light';
    }

    public function get_categories() {
        return [ 'marketo-elements' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_nav_cart_settings',
            array(
                'label' => esc_html__( 'Cart Setting', 'marketo' ),
            )
        );

        $this->add_control(
            'market_nav_search',
            array(
                'label'       => esc_html__( 'Button text', 'marketo' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('All Categories', 'marketo'),
                'default'     => 'All Categories',
                'label_block' => true,
            )
        );
        $this->add_control(
            'market_nav_search_place_holder',
            array(
                'label'       => esc_html__( 'Placeholder', 'marketo' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Find your product', 'marketo'),
                'default'     => 'Find your product',
                'label_block' => true,
            )
        );
        $this->add_control(
            'market_vertical_menu_search_icon',
            [
                'label' => esc_html__( 'Icon', 'marketo' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-search',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'marketo_nav_search_style',
            [
                'label' => esc_html__( 'Search style', 'marketo' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default'  => esc_html__( 'Default', 'marketo' ),
                    'dashed' => esc_html__( 'Style1', 'marketo' ),
                    'dotted' => esc_html__( 'Style2', 'marketo' ),
                    'double' => esc_html__( 'Style3', 'marketo' ),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'marketo_btn_section_style',
            [
                'label' =>esc_html__( 'Button', 'marketo' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );



        $this->start_controls_tabs( 'marketo_btn_tabs_style' );

        $this->start_controls_tab(
            'marketo_btn_tabnormal',
            [
                'label' =>esc_html__( 'Normal', 'marketo' ),
            ]
        );

        $this->add_responsive_control(
            'ekit_btn_text_color',
            [
                'label' =>esc_html__( 'Icon Color', 'marketo' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-wrapper .elementor-search-button button i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'marketo_btn_bg_color',
                'selector' => '{{WRAPPER}} .elementor-search-wrapper .elementor-search-button button',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'marketo_btn_tab_button_hover',
            [
                'label' =>esc_html__( 'Hover', 'marketo' ),
            ]
        );

        $this->add_responsive_control(
            'marketo_btn_hover_color',
            [
                'label' =>esc_html__( 'Icon Color', 'marketo' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-wrapper .elementor-search-button button:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'marketo_btn_bg_hover_color',
                'default' => '',
                'selector' => '.elementor-search-wrapper .elementor-search-button button:hover:before',
            )
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->end_controls_section();

    }


    /**
     * Get lcation coordinates by entered address and store into metadata.
     *
     * @return void
     */

    protected function render() {
        $settings = $this->get_settings();

        extract($settings);

        $cats = xs_category_list_slug('product_cat');

        ?>
        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
            <div class="col-lg-2 xs-wishlist-group">
                <div class="xs-wish-list-item clearfix">
                    <?php if(class_exists( 'YITH_WCWL' )): ?>
                        <span class="xs-wish-list">
                                <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="xs-single-wishList">
                                    <span class="xs-item-count xswhishlist"><?php echo YITH_WCWL()->count_products(); ?></span>
                                    <i class="icon icon-heart"></i>
                                </a>
                            </span>
                    <?php endif; ?>
                    <div class="xs-miniCart-dropdown">
                        <?php
                       require_once plugin_dir_url('woocommerce/woocommerce.php');
                        $GLOBALS['woocommerce'] = WC();
                        $xs_product_count = '0';

                        if(is_object(WC()->cart)){

                            $xs_product_count = WC()->cart->cart_contents_count;
                        }
                         ?>
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"  class ="xs-single-wishList offset-cart-menu">
                            <span class="xs-item-count highlight xscart"><?php echo esc_html($xs_product_count); ?></span>
                            <i class="icon icon-bag"></i>
                        </a>
                    </div>
                    <div class="xs-myaccount">
                        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class ="xs-single-wishList" >
                            <i class="icon icon-user2"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
    }

    protected function _content_template() {}
}
