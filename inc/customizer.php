<?php
/**
 * Mindful Customizer
 *
 * @package Mindful
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mindful_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->remove_control('header_textcolor');
	$wp_customize->remove_control('background_color');
}
add_action( 'customize_register', 'mindful_customize_register' );

/**
 * Options for Mindful Customizer.
 */
function mindful_customizer( $wp_customize ) {

	/* Main option Settings Panel */
	$wp_customize->add_panel('mindful_main_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Mindful Options', 'mindful' ),
		'description' => __( 'Panel to update mindful theme options', 'mindful' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));


	/* Main option Settings Panel */
	$wp_customize->add_panel('mindful_homepage_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Mindful HomePage Options', 'mindful' ),
		'description' => __( 'Panel to update mindful homepage options', 'mindful' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));

	// add "Content Options" section
	$wp_customize->add_section( 'mindful_content_section' , array(
		'title'      => esc_html__( 'Content Options', 'mindful' ),
		'priority'   => 50,
		'panel' => 'mindful_main_options',
	) );
	// add setting for excerpts/full posts toggle
	$wp_customize->add_setting( 'mindful_excerpts', array(
		'default'           => 0,
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	) );
	// add checkbox control for excerpts/full posts toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful_excerpts', array(
		'label'     => esc_html__( 'Show post excerpts in Home, Archive, and Category pages', 'mindful' ),
		'section'   => 'mindful_content_section',
		'priority'  => 10,
		'type'      => 'epsilon-toggle',
	) ) );

	$wp_customize->add_setting( 'mindful_page_comments', array(
		'default' => 1,
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful_page_comments', array(
		'label'     => esc_html__( 'Display Comments on Static Pages?', 'mindful' ),
		'section'   => 'mindful_content_section',
		'priority'  => 20,
		'type'      => 'epsilon-toggle',
	) ) );


	// add setting for Show/Hide posts date toggle
	$wp_customize->add_setting( 'mindful_post_date', array(
		'default'           => 1,
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts date toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful_post_date', array(
		'label'     => esc_html__( 'Show post date?', 'mindful' ),
		'section'   => 'mindful_content_section',
		'priority'  => 30,
		'type'      => 'epsilon-toggle',
	) ) );

	// add setting for Show/Hide posts Author Bio toggle
	$wp_customize->add_setting( 'mindful_post_author_bio', array(
		'default'           => 1,
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts Author Bio toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful_post_author_bio', array(
		'label'     => esc_html__( 'Show Author Bio?', 'mindful' ),
		'section'   => 'mindful_content_section',
		'priority'  => 40,
		'type'      => 'epsilon-toggle',
	) ) );



	/* mindful Main Options */
	$wp_customize->add_section('mindful_slider_options', array(
		'title' => __( 'Slider options', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_homepage_options',
	));
	$wp_customize->add_setting( 'mindful[mindful_slider_checkbox]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful[mindful_slider_checkbox]', array(
		'label' => esc_html__( 'Check if you want to enable slider', 'mindful' ),
		'section'   => 'mindful_slider_options',
		'priority'  => 5,
		'type'      => 'epsilon-toggle',
	) ) );
	$wp_customize->add_setting( 'mindful[mindful_slider_link_checkbox]', array(
		'default' => 1,
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful[mindful_slider_link_checkbox]', array(
		'label' => esc_html__( 'Turn "off" this option to remove the link from the slides', 'mindful' ),
		'section'   => 'mindful_slider_options',
		'priority'  => 6,
		'type'      => 'epsilon-toggle',
	) ) );

	// Pull all the categories into an array
	global $options_categories;
	$wp_customize->add_setting('mindful[mindful_slide_categories]', array(
		'default' => '',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'mindful_sanitize_slidecat',
	));
	$wp_customize->add_control('mindful[mindful_slide_categories]', array(
		'label' => __( 'Slider Category', 'mindful' ),
		'section' => 'mindful_slider_options',
		'type'    => 'select',
		'description' => __( 'Select a category for the featured post slider', 'mindful' ),
		'choices'    => $options_categories,
	));

	$wp_customize->add_setting('mindful[mindful_slide_number]', array(
		'default' => 3,
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_number',
	));
	$wp_customize->add_control('mindful[mindful_slide_number]', array(
		'label' => __( 'Number of slide items', 'mindful' ),
		'section' => 'mindful_slider_options',
		'description' => __( 'Enter the number of slide items', 'mindful' ),
		'type' => 'text',
	));
/*
	$wp_customize->add_setting('mindful[mindful_slide_height]', array(
		'default' => 500,
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_number',
	));
	$wp_customize->add_control('mindful[mindful_slide_height]', array(
		'label' => __( 'Height of slider ', 'mindful' ),
		'section' => 'mindful_slider_options',
		'description' => __( 'Enter the height for slider', 'mindful' ),
		'type' => 'text',
	));
*/
	$wp_customize->add_section('mindful_layout_options', array(
		'title' => __( 'Layout Options', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_main_options',
	));
	$wp_customize->add_section('mindful_style_color_options', array(
		'title' => __( 'Color Schemes', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_main_options',
	));

	// Layout options
	global $site_layout;
	$wp_customize->add_setting('mindful[site_layout]', array(
		'default' => 'side-pull-left',
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_layout',
	));
	$wp_customize->add_control('mindful[site_layout]', array(
		'label' => __( 'Website Layout Options', 'mindful' ),
		'section' => 'mindful_layout_options',
		'type'    => 'select',
		'description' => __( 'Choose between different layout options to be used as default', 'mindful' ),
		'choices'    => $site_layout,
	));

	// Colorful Template Styles options
	global $style_color;
	$wp_customize->add_setting('mindful[style_color]', array(
		'default' => 'white',
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_template',
	));
	$wp_customize->add_control('mindful[style_color]', array(
		'label' => __( 'Color Schemes', 'mindful' ),
		'section' => 'mindful_style_color_options',
		'type'    => 'select',
		'description' => __( 'Choose between different color template options to be used as default', 'mindful' ),
		'choices'    => $style_color,
	));

	//Background color
	$wp_customize->add_setting('mindful[background_color]', array(
		'default' => sanitize_hex_color( 'cccccc' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[background_color]', array(
		'label' => __( 'Background Color', 'mindful' ),
		//'description'   => __( 'Background Color','mindful' ),
		'section' => 'mindful_style_color_options',
	)));

	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_setting('mindful[woo_site_layout]', array(
			'default' => 'full-width',
			'type' => 'option',
			'sanitize_callback' => 'mindful_sanitize_layout',
		));
		$wp_customize->add_control('mindful[woo_site_layout]', array(
			'label' => __( 'WooCommerce Page Layout Options', 'mindful' ),
			'section' => 'mindful_layout_options',
			'type'    => 'select',
			'description' => __( 'Choose between different layout options to be used as default for all woocommerce pages', 'mindful' ),
			'choices'    => $site_layout,
		));
	}

	$wp_customize->add_setting('mindful[element_color_hover]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));


	 /* mindful Call To Action Options */
	$wp_customize->add_section('mindful_action_options', array(
		'title' => __( 'Call To Action (CTA)', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_homepage_options',
	));


	$wp_customize->add_setting('mindful[cfa_bg_color]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[cfa_bg_color]', array(
		'label' => __( 'CTA Section : Background Color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_action_options',
	)));


	$wp_customize->add_setting('mindful[w2f_cfa_text]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_strip_slashes',
	));
	$wp_customize->add_control('mindful[w2f_cfa_text]', array(
		'label' => __( 'Call To Action - Message Text', 'mindful' ),
		'description' => sprintf( __( 'Enter the text for CTA section', 'mindful' ) ),
		'section' => 'mindful_action_options',
		'type' => 'textarea',
	));


	$wp_customize->add_setting('mindful[cfa_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[cfa_color]', array(
		'label' => __( 'Call To Action - Message Text Color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_action_options',
	)));


	$wp_customize->add_setting('mindful[w2f_cfa_button]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_nohtml',
	));

	$wp_customize->add_control('mindful[w2f_cfa_button]', array(
		'label' => __( 'CTA Button Text', 'mindful' ),
		'section' => 'mindful_action_options',
		'description' => __( 'Enter the text for CTA button', 'mindful' ),
		'type' => 'text',
	));

	$wp_customize->add_setting('mindful[w2f_cfa_link]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('mindful[w2f_cfa_link]', array(
		'label' => __( 'CTA button link', 'mindful' ),
		'section' => 'mindful_action_options',
		'description' => __( 'Enter the link for CTA button', 'mindful' ),
		'type' => 'text',
	));



	$wp_customize->add_setting('mindful[cfa_btn_txt_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[cfa_btn_txt_color]', array(
		'label' => __( 'CTA Button Text Color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_action_options',
	)));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[element_color_hover]', array(
		'label' => __( 'CTA Button Color on hover', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_action_options',
		'settings' => 'mindful[element_color_hover]',
	)));

	$wp_customize->add_setting('mindful[cfa_btn_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[cfa_btn_color]', array(
		'label' => __( 'CTA Button Border Color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_action_options',
	)));


	/* this setting overrides other buttons */
	/*
		$wp_customize->add_setting('mindful[element_color]', array(
			'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
			'type'  => 'option',
			'sanitize_callback' => 'mindful_sanitize_hexcolor',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[element_color]', array(
			'label' => __( 'CTA Button Color', 'mindful' ),
			'description'   => __( 'Default used if no color is selected','mindful' ),
			'section' => 'mindful_action_options',
			'settings' => 'mindful[element_color]',
		)));

		*/
	/* mindful Typography Options */
	$wp_customize->add_section('mindful_typography_options', array(
		'title' => __( 'Typography', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_main_options',
	));
	// Typography Defaults
	$typography_defaults = array(
		'size'  => '14px',
		'face'  => 'Open Sans',
		'style' => 'normal',
		'color' => '#6B6B6B',
	);

	// Typography Options
	global $typography_options;
	$wp_customize->add_setting('mindful[main_body_typography][size]', array(
		'default' => $typography_defaults['size'],
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_typo_size',
	));
	$wp_customize->add_control('mindful[main_body_typography][size]', array(
		'label' => __( 'Main Body Text', 'mindful' ),
		'description' => __( 'Used in p tags', 'mindful' ),
		'section' => 'mindful_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['sizes'],
	));
	$wp_customize->add_setting('mindful[main_body_typography][face]', array(
		'default' => $typography_defaults['face'],
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_typo_face',
	));
	$wp_customize->add_control('mindful[main_body_typography][face]', array(
		'section' => 'mindful_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['faces'],
	));
	$wp_customize->add_setting('mindful[main_body_typography][style]', array(
		'default' => $typography_defaults['style'],
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_typo_style',
	));
	$wp_customize->add_control('mindful[main_body_typography][style]', array(
		'section' => 'mindful_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['styles'],
	));
	$wp_customize->add_setting('mindful[main_body_typography][color]', array(
		// 'default' => sanitize_hex_color( '#6B6B6B' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[main_body_typography][color]', array(
		'section' => 'mindful_typography_options',
	)));
	$wp_customize->add_setting('mindful[main_body_typography][subset]', array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'esc_html'
    ));
    $wp_customize->add_control('mindful[main_body_typography][subset]', array(
        'label' => __('Font Subset', 'mindful'),
        'section' => 'mindful_typography_options',
        'description' => __('Enter the Google fonts subset', 'mindful'),
        'type' => 'text'
    ));

	$wp_customize->add_setting('mindful[heading_color]', array(
		// 'default' => sanitize_hex_color( '#444' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[heading_color]', array(
		'label' => __( 'Heading Color', 'mindful' ),
		'description'   => __( 'Color for all headings (h1-h6)','mindful' ),
		'section' => 'mindful_typography_options',
	)));
	$wp_customize->add_setting('mindful[link_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[link_color]', array(
		'label' => __( 'Link Color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_typography_options',
	)));
	$wp_customize->add_setting('mindful[link_hover_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[link_hover_color]', array(
		'label' => __( 'Link:hover Color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_typography_options',
	)));

	/* mindful Header Options */
	$wp_customize->add_section('mindful_header_options', array(
		'title' => __( 'Header Menu', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_main_options',
	));

	$wp_customize->add_setting('mindful[sticky_menu]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful[sticky_menu]', array(
		'label' => __( 'Sticky Menu', 'mindful' ),
		'description' => sprintf( __( 'Check to show fixed header', 'mindful' ) ),
		'section' => 'mindful_header_options',
		'type' => 'epsilon-toggle',
	) ) );

//header-text-color
	$wp_customize->add_setting('mindful[header_text_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[header_text_color]', array(
		'label' => __( 'Header Text Color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_header_options',
	)));
//header-text-color

	$wp_customize->add_setting('mindful[nav_bg_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[nav_bg_color]', array(
		'label' => __( 'Top nav background color', 'mindful' ),
		'description'   => __( 'Default used if no color is selected','mindful' ),
		'section' => 'mindful_header_options',
	)));

	$wp_customize->add_setting('mindful[nav_link_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[nav_link_color]', array(
		'label' => __( 'Top nav item color', 'mindful' ),
		'description'   => __( 'Link color','mindful' ),
		'section' => 'mindful_header_options',
	)));

	$wp_customize->add_setting('mindful[nav_item_hover_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[nav_item_hover_color]', array(
		'label' => __( 'Top nav item hover color', 'mindful' ),
		'description'   => __( 'Link:hover color','mindful' ),
		'section' => 'mindful_header_options',
	)));

	$wp_customize->add_setting('mindful[nav_dropdown_bg]', array(
		// 'default' => sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[nav_dropdown_bg]', array(
		'label' => __( 'Top nav dropdown background color', 'mindful' ),
		'description'   => __( 'Background of dropdown item hover color','mindful' ),
		'section' => 'mindful_header_options',
	)));

	$wp_customize->add_setting('mindful[nav_dropdown_item]', array(
		// 'default' => sanitize_hex_color( '#636467' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[nav_dropdown_item]', array(
		'label' => __( 'Top nav dropdown item color', 'mindful' ),
		'description'   => __( 'Dropdown item color','mindful' ),
		'section' => 'mindful_header_options',
	)));

	$wp_customize->add_setting('mindful[nav_dropdown_item_hover]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[nav_dropdown_item_hover]', array(
		'label' => __( 'Top nav dropdown item hover color', 'mindful' ),
		'description'   => __( 'Dropdown item hover color','mindful' ),
		'section' => 'mindful_header_options',
	)));

	$wp_customize->add_setting('mindful[nav_dropdown_bg_hover]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[nav_dropdown_bg_hover]', array(
		'label' => __( 'Top nav dropdown item background hover color', 'mindful' ),
		'description'   => __( 'Background of dropdown item hover color','mindful' ),
		'section' => 'mindful_header_options',
	)));

	/* mindful Footer Options */
	$wp_customize->add_section('mindful_footer_options', array(
		'title' => __( 'Footer', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_main_options',
	));
	$wp_customize->add_setting('mindful[footer_widget_bg_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[footer_widget_bg_color]', array(
		'label' => __( 'Footer widget area background color', 'mindful' ),
		'section' => 'mindful_footer_options',
	)));

	$wp_customize->add_setting('mindful[footer_bg_color]', array(
		// 'default' => sanitize_hex_color( '#1F1F1F' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[footer_bg_color]', array(
		'label' => __( 'Footer background color', 'mindful' ),
		'section' => 'mindful_footer_options',
	)));

	$wp_customize->add_setting('mindful[footer_text_color]', array(
		// 'default' => sanitize_hex_color( '#999' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[footer_text_color]', array(
		'label' => __( 'Footer text color', 'mindful' ),
		'section' => 'mindful_footer_options',
	)));

	$wp_customize->add_setting('mindful[footer_link_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[footer_link_color]', array(
		'label' => __( 'Footer link color', 'mindful' ),
		'section' => 'mindful_footer_options',
	)));

	$wp_customize->add_setting('mindful[custom_footer_text]', array(
		//'default' => 'mindful',
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_strip_slashes',
	));
	$wp_customize->add_control('mindful[custom_footer_text]', array(
		'label' => __( 'Footer information', 'mindful' ),
		'description' => sprintf( __( 'Footer Text (like Copyright Message)', 'mindful' ) ),
		'section' => 'mindful_footer_options',
		'type' => 'textarea',
	));

	/* mindful Social Options */
	$wp_customize->add_section('mindful_social_options', array(
		'title' => __( 'Social', 'mindful' ),
		'priority' => 31,
		'panel' => 'mindful_main_options',
	));
	$wp_customize->add_setting('mindful[social_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[social_color]', array(
		'label' => __( 'Social icon color', 'mindful' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'mindful' ) ),
		'section' => 'mindful_social_options',
	)));

	$wp_customize->add_setting('mindful[social_footer_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mindful_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mindful[social_footer_color]', array(
		'label' => __( 'Footer social icon color', 'mindful' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'mindful' ) ),
		'section' => 'mindful_social_options',
	)));

	$wp_customize->add_setting('mindful[footer_social]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'mindful_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mindful[footer_social]', array(
		'label' => __( 'Footer Social Icons', 'mindful' ),
		'description' => sprintf( __( 'Check to show social icons in footer', 'mindful' ) ),
		'section' => 'mindful_social_options',
		'type' => 'epsilon-toggle',
	) ) );

}
add_action( 'customize_register', 'mindful_customizer' );



/**
 * Sanitzie checkbox for WordPress customizer
 */
function mindful_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}
}
/**
 * Adds sanitization callback function: colors
 * @package mindful
 */
function mindful_sanitize_hexcolor( $color ) {
	$unhashed = sanitize_hex_color_no_hash( $color );
	if ( $unhashed ) {
		return '#' . $unhashed;
	}
	return $color;
}

/**
 * Adds sanitization callback function: Nohtml
 * @package mindful
 */
function mindful_sanitize_nohtml( $input ) {
	return wp_filter_nohtml_kses( $input );
}

/**
 * Adds sanitization callback function: Number
 * @package mindful
 */
function mindful_sanitize_number( $input ) {
	if ( isset( $input ) && is_numeric( $input ) ) {
		return $input;
	}
}

/**
 * Adds sanitization callback function: Strip Slashes
 * @package mindful
 */
function mindful_sanitize_strip_slashes( $input ) {
	return wp_kses_stripslashes( $input );
}

/**
 * Adds sanitization callback function: Sanitize Text area
 * @package mindful
 */
function mindful_sanitize_textarea( $input ) {
	return sanitize_text_field( $input );
}

/**
 * Adds sanitization callback function: Slider Category
 * @package mindful
 */
function mindful_sanitize_slidecat( $input ) {
	global $options_categories;
	if ( array_key_exists( $input, $options_categories ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Sidebar Layout
 * @package mindful
 */
function mindful_sanitize_layout( $input ) {
	global $site_layout;
	if ( array_key_exists( $input, $site_layout ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Color Template
 * @package mindful
 */
function mindful_sanitize_template( $input ) {
	global $style_color;
	if ( array_key_exists( $input, $style_color ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Typography Size
 * @package mindful
 */
function mindful_sanitize_typo_size( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['sizes'] ) ) {
		return $input;
	} else {
		return $typography_defaults['size'];
	}
}
/**
 * Adds sanitization callback function: Typography Face
 * @package mindful
 */
function mindful_sanitize_typo_face( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['faces'] ) ) {
		return $input;
	} else {
		return $typography_defaults['face'];
	}
}
/**
 * Adds sanitization callback function: Typography Style
 * @package mindful
 */
function mindful_sanitize_typo_style( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['styles'] ) ) {
		return $input;
	} else {
		return $typography_defaults['style'];
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mindful_customize_preview_js() {
	wp_enqueue_script( 'mindful_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20140317', true );
}
add_action( 'customize_preview_init', 'mindful_customize_preview_js' );

/*
 * Customizer Slider Toggle {category and numb of slides}
 */
add_action( 'customize_controls_print_footer_scripts', 'mindful_slider_toggle' );

function mindful_slider_toggle() {
	?>
<script>
	jQuery(document).ready(function() {
		/* This one shows/hides the an option when a checkbox is clicked. */
		jQuery('#customize-control-mindful-mindful_slide_categories, #customize-control-mindful-mindful_slide_number').hide();
		jQuery('#customize-control-mindful-mindful_slider_checkbox input').click(function() {
			jQuery('#customize-control-mindful-mindful_slide_categories, #customize-control-mindful-mindful_slide_number').fadeToggle(400);
		});

		if (jQuery('#customize-control-mindful-mindful_slider_checkbox input:checked').val() !== undefined) {
			jQuery('#customize-control-mindful-mindful_slide_categories, #customize-control-mindful-mindful_slide_number').show();
		}
	});
</script>
<?php
}
