<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Google Maps Widget
 */
class Xs_Nav_Vertical_Menu extends Widget_Base {


    public function get_name() {
        return 'xs-nav-vertical-menu';
    }

    public function get_title() {
        return esc_html__( 'Marketo Nav Vertical Menu', 'marketo' );
    }

    public function get_icon() {
        return 'eicon-navigation-vertical';
    }

    public function get_categories() {
        return [ 'marketo-elements' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_nav_vertical_menu_settings',
            array(
                'label' => esc_html__( 'Menu Setting', 'marketo' ),
            )
        );

        $this->add_control(
            'market_nav_vertical_menu',
            array(
                'label'       => esc_html__( 'Button text', 'marketo' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('All Categories', 'marketo'),
                'default'     => 'All Categories',
                'label_block' => true,
            )
        );
        $this->add_control(
            'market_vertical_menu_icon',
            [
                'label' => esc_html__( 'Icon', 'marketo' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-list-ul',
                    'library' => 'solid',
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

        $this->add_responsive_control(
            'marketo_btn_text_padding',
            [
                'label' =>esc_html__( 'Padding', 'marketo' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'marketo_btn_typography',
                'label' =>esc_html__( 'Typography', 'marketo' ),
                'selector' => '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets',
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
                'label' =>esc_html__( 'Text Color', 'marketo' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cd-dropdown-trigger::after, .cd-dropdown-trigger::before' => 'background:{{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'marketo_btn_bg_color',
                'selector' => '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets',
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
                'label' =>esc_html__( 'Text Color', 'marketo' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cd-dropdown-trigger:hover::after, .cd-dropdown-trigger:hover::before' => 'background:{{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'marketo_btn_bg_hover_color',
                'default' => '',
                'selector' => '.xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets:hover',
            )
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();




        $this->start_controls_section(
            'marketo_btn_border_style_tabs',
            [
                'label' =>esc_html__( 'Border', 'marketo' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'marketo_btn_border_style',
            [
                'label' => esc_html_x( 'Border Type', 'Border Control', 'marketo' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'marketo' ),
                    'solid' => esc_html_x( 'Solid', 'Border Control', 'marketo' ),
                    'double' => esc_html_x( 'Double', 'Border Control', 'marketo' ),
                    'dotted' => esc_html_x( 'Dotted', 'Border Control', 'marketo' ),
                    'dashed' => esc_html_x( 'Dashed', 'Border Control', 'marketo' ),
                    'groove' => esc_html_x( 'Groove', 'Border Control', 'marketo' ),
                ],
                'default'	=> 'none',
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets' => 'border-style: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'marketo_btn_border_dimensions',
            [
                'label' 	=> esc_html_x( 'Width', 'Border Control', 'marketo' ),
                'type' 		=> Controls_Manager::DIMENSIONS,
                'condition'	=> [
                    'ekit_btn_border_style!' => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'xs_tabs_button_border_style' );
        $this->start_controls_tab(
            'marketo_btn_tab_border_normal',
            [
                'label' =>esc_html__( 'Normal', 'marketo' ),
            ]
        );

        $this->add_responsive_control(
            'marketo_btn_border_color',
            [
                'label' => esc_html_x( 'Color', 'Border Control', 'marketo' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'marketo_btn_tab_button_border_hover',
            [
                'label' =>esc_html__( 'Hover', 'marketo' ),
            ]
        );
        $this->add_responsive_control(
            'marketo_btn_hover_border_color',
            [
                'label' => esc_html_x( 'Color', 'Border Control', 'marketo' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'marketo_btn_border_radius',
            [
                'label' =>esc_html__( 'Border Radius', 'marketo' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%'],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '' ,
                    'left' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'marketo_btn_box_shadow_style',
            [
                'label' =>esc_html__( 'Shadow', 'marketo' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'marketo_btn_box_shadow_group',
                'selector' => '{{WRAPPER}} .xs-vartical-menu .cd-dropdown-trigger.marketo-vertical-menu-widgets',
            ]
        );


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

        $button_text = $market_nav_vertical_menu;

        ?>
        <div class="cd-dropdown-wrapper xs-vartical-menu">
            <a class="cd-dropdown-trigger marketo-vertical-menu-widgets" href="#0">
                <i class="<?php echo esc_attr($market_vertical_menu_icon['value']); ?>"></i> <?php echo marketo_kses($button_text); ?>
            </a>
            <nav class="cd-dropdown">
                <h2><?php esc_html_e('Marketo','marketo')?></h2>
                <a href="#0" class="cd-close"><?php esc_html_e('Close','marketo')?></a>
                <?php
                get_template_part( 'template-parts/navigation/nav-part/vertical', 'nav' );
                ?>
            </nav>
        </div>
<?php
    }

    protected function _content_template() {}
}
