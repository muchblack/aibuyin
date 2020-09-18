<?php

$fields[]	 = array(
	'type'		 => 'color',
	'settings'	 => 'theme_primary_color',
	'label'		 => esc_html__( 'Primary Color', 'marketo' ),
	'section'	 => 'general_section',
	'transport'	 => 'auto',
	'output'	 => array(
		array(
			'element'	 => '.xs-content-header.background-version, .xs-nav-tab .nav-link::before, .owl-dots .owl-dot.active span,
			.xs-map-popup.btn-warning',
			'property'	 => 'background-color',
		),
		array(
			'element'			 => '.xs-nav-tab .nav-link::after',
			'property'			 => 'border-top',
			'value_pattern'		 => '8px solid top_border',
			'pattern_replace'	 => array(
				'top_border' => 'theme_primary_color',
			),
		),
		array(
			'element'			 => '.xs-deal-of-the-week',
			'property'			 => 'border',
			'value_pattern'		 => '2px solid top_border',
			'pattern_replace'	 => array(
				'top_border' => 'theme_primary_color',
			),
		),
		array(
			'element'	 => '.product-feature-ribbon',
			'property'	 => 'border-right-color',
		),
		array(
			'element'	 => '.product-feature-ribbon',
			'property'	 => 'border-top-color',
		),
		array(
			'element'	 => '.xs-single-wishList .xs-item-count.highlight',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.xs-single-wishList',
			'property'	 => 'color',
		),
		array(
			'element'	 => 'a.xs-map-popup.btn.btn-primary',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.xs-copyright',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.xs-progress .progress-bar',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.xs-countdown-timer .timer-count',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.product-block-slider .owl-dots .owl-dot.active span',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.select-options li:hover',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.shop-archive .widget_price_filter .ui-slider .ui-slider-handle, .shop-archive .widget_price_filter .ui-slider .ui-slider-range',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.product-title-v2 a',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.color-primary, .shop-view-nav .nav-item .nav-link.active',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.entry-header .entry-title a:hover',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.sidebar .widget-title',
			'property'	 => 'border-color',
		),
	),
);
$fields[]	 = array(
	'type'		 => 'color',
	'settings'	 => 'theme_secondary_color',
	'label'		 => esc_html__( 'Secondary Color', 'marketo' ),
	'section'	 => 'general_section',
	'transport'	 => 'auto',
	'output'	 => array(
		array(
			'element'	 => '.woocommerce-Price-amount.amount',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.xs-product-offer-label, .woocommerce button.button',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.product-item-meta li a:hover',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.product-item-meta.meta-style-2 li a',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.color-secondary, .xs-nav-tab.version-4 .nav-item .nav-link.active, .xs-nav-tab.version-4 .nav-item .nav-link:hover',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.woocommerce button.button.alt',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '.woocommerce #respond input#submit',
			'property'	 => 'background-color',
		),
	),
);
$fields[]	 = array(
	'type'		 => 'color',
	'settings'	 => 'theme_third_color',
	'label'		 => esc_html__( 'Alt Color', 'marketo' ),
	'section'	 => 'general_section',
	'transport'	 => 'auto',
	'output'	 => array(
		array(
			'element'	 => 'a',
			'property'	 => 'color',
		),
	),
);

$fields[] = array(
	'type'		 => 'image',
	'settings'	 => 'site_logo',
	'label'		 => esc_html__( 'Logo', 'marketo' ),
	'section'	 => 'general_section',
);

$fields[] = array(
	'type'		 => 'image',
	'settings'	 => 'retina_site_logo',
	'label'		 => esc_html__( 'Retina Logo', 'marketo' ),
	'section'	 => 'general_section',
);

$fields[] = array(
	'type'		 => 'text',
	'settings'	 => 'map_api',
	'label'		 => esc_html__( 'Google Map API Key', 'marketo' ),
	'section'	 => 'general_section',
	'default' => '',
);
