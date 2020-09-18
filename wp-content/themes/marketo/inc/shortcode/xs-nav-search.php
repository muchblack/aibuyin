<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * nav serch widgets
 */
class Xs_Nav_Search extends Widget_Base {


    public function get_name() {
        return 'xs-nav-serch';
    }

    public function get_title() {
        return esc_html__( 'Marketo Nav Search', 'marketo' );
    }

    public function get_icon() {
        return 'eicon-site-search';
    }

    public function get_categories() {
        return [ 'marketo-elements' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_nav_search_settings',
            array(
                'label' => esc_html__( 'Menu Setting', 'marketo' ),
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
        <form class="xs-navbar-search xs-navbar-search-wrapper elementor-search-wrapper" action="<?php echo esc_url(home_url('/')); ?>" method="get"
              id="header_form">
            <div class="input-group">
                <input type="search" name="s" class="form-control"
                       placeholder="<?php echo esc_attr($market_nav_search_place_holder); ?>">
                <?php if (!class_exists('Algolia_Plugin')): ?>
                    <div class="xs-category-select-wraper">
                        <i class="xs-spin"></i>
                        <select class="xs-category-select" name="product_cat">
                            <option value="-1"><?php echo esc_html($market_nav_search); ?></option>
                            <?php if (is_array($cats) && !empty($cats)): ?>
                                <?php foreach ($cats as $cat) { ?>
                                    <option value="<?php echo esc_html($cat->term_id); ?>"><?php echo esc_html($cat->name); ?></option>
                                <?php } ?>
                            <?php endif; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="input-group-btn elementor-search-button">
                    <input type="hidden" id="search-param" name="post_type"
                           value="<?php esc_html_e('product', 'marketo'); ?>">
                    <button type="submit" class="btn btn-primary"><i class="<?php echo esc_attr($market_vertical_menu_search_icon['value']); ?>"></i></button>
                </div>
            </div>
        </form>
        <?php
    }

    protected function _content_template() {}
}
