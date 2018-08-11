<?php

function one_page_express_setup()
{
    global $content_width;

    if ( ! isset($content_width)) {
        $content_width = 3840;
    }

    load_theme_textdomain('one-page-express', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');


    set_post_thumbnail_size(1024, 0, false);

    register_default_headers(array(
        'homepage-image' => array(
            'url'           => '%s/assets/images/home_page_header.jpg',
            'thumbnail_url' => '%s/assets/images/home_page_header.jpg',
            'description'   => __('Homepage Header Image', 'one-page-express'),
        ),
    ));

    add_theme_support('custom-header', apply_filters('one_page_express_custom_header_args', array(
        'default-image' => get_template_directory_uri() . "/assets/images/home_page_header.jpg",
        'width'         => 1920,
        'height'        => 800,
        'flex-height'   => true,
        'flex-width'    => true,
        'header-text'   => false,
    )));

    add_theme_support('custom-logo', array(
        'flex-height' => true,
        'flex-width'  => true,
        'width'       => 150,
        'height'      => 70,
    ));

    add_image_size( 'one-page-express-full-hd', 1920, 1080 );


    add_theme_support('customize-selective-refresh-widgets');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'one-page-express'),
    ));

    include_once get_template_directory() . '/customizer/kirki/kirki.php';

    Kirki::add_config('one_page_express', array(
        'capability'  => 'edit_theme_options',
        'option_type' => 'theme_mod',
    ));

    require_once get_template_directory() . '/inc/companion.php';

    /* tgm-plugin-activation */
    require_once get_template_directory() . '/class-tgm-plugin-activation.php';

    $plugins = array(
        'one-page-express-companion' => array(
            'title'       => __('One Page Express Companion', 'one-page-express'),
            'description' => __('The One Page Express Companion plugin adds drag and drop functionality and many other features to the One Page Express theme.', 'one-page-express'),
            'activate'    => array(
                'label' => __('Activate', 'one-page-express'),
            ),
            'install'     => array(
                'label' => __('Install', 'one-page-express'),
            ),
        ),
        'contact-form-7'             => array(
            'title'       => __('Contact Form 7', 'one-page-express'),
            'description' => __('The Contact Form 7 plugin is recommended for the One Page Express contact section.', 'one-page-express'),
            'activate'    => array(
                'label' => __('Activate', 'one-page-express'),
            ),
            'install'     => array(
                'label' => __('Install', 'one-page-express'),
            ),
        ),
    );
    $plugins = apply_filters('one_page_express_theme_info_plugins', $plugins);
    \OnePageExpress\Companion_Plugin::init(array(
        'slug'           => 'one-page-express-companion',
        'activate_label' => __('Activate One Page Express Companion', 'one-page-express'),
        'activate_msg'   => __('This feature requires the One Page Express Companion plugin to be activated.', 'one-page-express'),
        'install_label'  => __('Install One Page Express Companion', 'one-page-express'),
        'install_msg'    => __('This feature requires the One Page Express Companion plugin to be installed.', 'one-page-express'),
        'plugins'        => $plugins,
    ));

    add_action('admin_menu', 'one_page_express_register_theme_page');
}


add_filter( 'image_size_names_choose', 'one_page_express_full_hd_image_size_label' );

function one_page_express_full_hd_image_size_label( $sizes ) {
    return array_merge( $sizes, array(
        'one-page-express-full-hd' => __( 'Full HD' , 'one-page-express' ),
    ) );
}

function one_page_express_register_theme_page()
{
    add_theme_page('one_page_express_theme_page', __('One Page Express Info', 'one-page-express'), 'activate_plugins', 'one-page-express-welcome', 'one_page_express_load_theme_partial');
}

function one_page_express_load_theme_partial()
{
    wp_enqueue_style('one-page-express-theme-info', get_template_directory_uri() . "/assets/css/theme-info.css");
    require_once get_template_directory() . "/inc/theme-info.php";
}

add_action('after_setup_theme', 'one_page_express_setup');

function one_page_express_register_required_plugins()
{
    $plugins = array(
        array(
            'name'     => 'One Page Express Companion',
            'slug'     => 'one-page-express-companion',
            'required' => false,
        ),

        array(
            'name'     => 'Contact Form 7',
            'slug'     => 'contact-form-7',
            'required' => false,
        ),
    );

    $plugins = apply_filters('one_page_express_tgmpa_plugins', $plugins);

    $config = array(
        'id'           => 'one_page_express',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    $config = apply_filters('one_page_express_tgmpa_config', $config);

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'one_page_express_register_required_plugins');

function one_page_express_sanitize_checkbox($val)
{
    return (isset($val) && $val == true ? true : false);
}

function one_page_express_sanitize_textfield($val)
{
    return wp_kses_post(force_balance_tags($val));
}

function one_page_express_print_header_image()
{
    $image = get_theme_mod('one_page_express_header_content_image', get_template_directory_uri() . "/screenshot.jpg");
    if ( ! empty($image)) {
        printf('<img class="homepage-header-image" src="%1$s"/>', esc_url($image));
    }
}

function one_page_express_parse_eff($text)
{
    if (is_customize_preview()) {
        return $text;
    }

    $matches = array();

    preg_match_all('/\{([^\}]+)\}/i', $text, $matches);

    $alternative_texts = get_theme_mod("one_page_express_header_text_morph_alternatives", "");
    $alternative_texts = preg_split("/[\r\n]+/", $alternative_texts);

    for ($i = 0; $i < count($matches[1]); $i++) {
        $orig    = $matches[0][$i];
        $str     = $matches[1][$i];
        $strings = explode("|", $str);
        if (count($alternative_texts)) {
            $str = json_encode(array_merge($strings, $alternative_texts));
        }
        $text = str_replace($orig, '<span data-text-effect="' . esc_attr($str) . '">' . $strings[0] . '</span>', $text);
    }

    return $text;
}

function one_page_express_print_header_title()
{
    $title = get_theme_mod('one_page_express_header_title', "");
    $show  = get_theme_mod('one_page_express_header_show_title', true);

    $title = one_page_express_parse_eff($title);


    $has_text_effect = get_theme_mod('one_page_express_header_show_text_morph_animation', true);


    if (current_user_can('edit_theme_options')) {
        if ($title == "") {
            $title = __('You can set this title from the customizer.', 'one-page-express');
        }
    }
    if ($show) {
        printf('<h1 class="heading8">%1$s</h1>', $title);
    }
}

function one_page_express_print_header_subtitle()
{
    $subtitle = get_theme_mod('one_page_express_header_subtitle', "");
    $show     = get_theme_mod('one_page_express_header_show_subtitle', true);

    $subtitle = one_page_express_parse_eff($subtitle);

    if (current_user_can('edit_theme_options')) {
        if ($subtitle == "") {
            $subtitle = __('You can set this subtitle from the customizer.', 'one-page-express');
        }
    }
    if ($show) {
        printf('<p class="header-subtitle">%1$s</p>', $subtitle);
    }
}

if ( ! function_exists('one_page_express_print_header_button_1')) {
    function one_page_express_print_header_button_1()
    {
        $title = get_theme_mod('one_page_express_header_btn_1_label', "");
        $url   = get_theme_mod('one_page_express_header_btn_1_url', '#');
        $show  = get_theme_mod('one_page_express_header_show_btn_1', true);

        if (current_user_can('edit_theme_options')) {
            if (empty($title)) {
                $title = __('Action button 1', 'one-page-express');
            }
        }
        if ($show && $title) {
            printf('<a class="button blue big hp-header-primary-button" href="%1$s">%2$s</a>', esc_url($url), wp_kses_post($title));
        }
    }

}

if ( ! function_exists('one_page_express_print_header_button_2')) {
    function one_page_express_print_header_button_2()
    {
        $title = get_theme_mod('one_page_express_header_btn_2_label', "");
        $url   = get_theme_mod('one_page_express_header_btn_2_url', '#');
        $show  = get_theme_mod('one_page_express_header_show_btn_2', true);

        if (current_user_can('edit_theme_options')) {
            if (empty($title)) {
                $title = __('Action button 2', 'one-page-express');
            }
        }
        if ($show && $title) {
            printf('<a class="button green big hp-header-secondary-button" href="%1$s">%2$s</a>', esc_url($url), wp_kses_post($title));
        }
    }
}

function one_page_express_add_sections($wp_customize)
{
    $wp_customize->add_panel('one_page_express_header',
        array(
            'priority'       => 2,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => esc_html__('Header', 'one-page-express'),
            'description'    => '',
        )
    );

    $wp_customize->add_section('one_page_express_page_content', array(
        'priority' => 2,
        'title'    => __('Front Page content', 'one-page-express'),
    ));

    $wp_customize->add_section('one_page_express_footer_template', array(
        'title'    => __('Footer Settings', 'one-page-express'),
        'priority' => 3,
    ));

    $sections = array(
        'one_page_express_header_layout' => array(
            'title'    => __('Front Page Header Designs', 'one-page-express'),
            'priority' => 1,
        ),

        'one_page_express_header_background_chooser' => array(
            'title' => __('Front Page Header Background', 'one-page-express'),
            'panel' => 'one_page_express_header',
        ),

        'one_page_express_header_content' => array(
            'title' => __('Front Page Header Content', 'one-page-express'),
            'panel' => 'one_page_express_header',
        ),

        'header_image' => array(
            'title' => __('Inner Pages Header Background', 'one-page-express'),
            'panel' => 'one_page_express_header',
        ),

        'one_page_express_inner_header_content' => array(
            'title' => __('Inner Pages Header Content', 'one-page-express'),
            'panel' => 'one_page_express_header',
        ),
    );

    foreach ($sections as $name => $value) {
        $wp_customize->add_section($name, $value);
    }


    $wp_customize->add_section('general_site_style', array(
        'title'      => __('Typography', 'one-page-express'),
        'panel'      => 'general_settings',
        'capability' => 'edit_theme_options',
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'ope-info-pro',
        'label'    => __('Typography options are only available in PRO. @BTN@', 'one-page-express'),
        'section'  => 'general_site_style',
        'settings' => "general_site_style_pro",
    ));
}

function one_page_express_header_presets()
{
    global $ONE_PAGE_EXPRESS_PRESETS;

    $result       = array();
    $presets_file = get_template_directory() . '/customizer/presets.php';
    if (file_exists($presets_file) && ! isset($ONE_PAGE_EXPRESS_PRESETS)) {
        $ONE_PAGE_EXPRESS_PRESETS = require $presets_file;
    }

    if (isset($ONE_PAGE_EXPRESS_PRESETS)) {
        $result = $ONE_PAGE_EXPRESS_PRESETS;
    }


    $result = apply_filters('one_page_express_header_presets', $result);

    return $result;

}

add_action('customize_controls_enqueue_scripts', function () {
    $cssUrl = get_template_directory_uri() . "/customizer/";
    $jsUrl  = get_template_directory_uri() . "/customizer/js/";

    wp_enqueue_script('one-page-express-customize', $jsUrl . "/customize.js", array('jquery'));
    wp_enqueue_style('one-page-express-webgradients', get_template_directory_uri() . '/assets/css/webgradients.css');
    wp_enqueue_style('one-page-express-customizer-base', $cssUrl . '/customizer.css');
});

add_action('customize_preview_init', function () {
    $jsUrl = get_template_directory_uri() . "/customizer/js/";
    wp_enqueue_script('one-page-express-customize-preview', $jsUrl . "/customize-preview.js", array('jquery', 'customize-preview'), '', true);
});

function one_page_express_footer_filter()
{
    $footer_template = get_theme_mod("one_page_express_footer_template", "simple");

    if ($footer_template == 'simple') {
        $footer_template = '';
    }

    if ($footer_template) {
        wp_enqueue_style('one-page-express-' . $footer_template . '-css', get_template_directory_uri() . "/assets/css/footer-$footer_template.css", array("one-page-express-style"));
    }

    return $footer_template;
}

add_filter('one_page_express_footer', 'one_page_express_footer_filter');

function one_page_express_get_footer()
{
    $template = apply_filters('one_page_express_footer', "");
    get_footer($template);
}


if ( ! function_exists("one_page_express_get_header")) {
    function one_page_express_get_header($template = "")
    {
        $template = apply_filters('one_page_express_get_header', $template);
        get_header($template);
    }
}


$one_page_express_footer_socials_icons = array(
    array(
        'icon'  => "fa-facebook-f",
        'link'  => "#",
        'label' => __('Icon 1', 'one-page-express'),
        'id'    => 'social_icon_1',
    ),
    array(
        'icon'  => "fa-twitter",
        'link'  => "#",
        'label' => __('Icon 2', 'one-page-express'),
        'id'    => 'social_icon_2',
    ),
    array(
        'icon'  => "fa-google-plus",
        'link'  => "#",
        'label' => __('Icon 3', 'one-page-express'),
        'id'    => 'social_icon_3',
    ),
    array(
        'icon'  => "fa-behance",
        'link'  => "#",
        'label' => __('Icon 4', 'one-page-express'),
        'id'    => 'social_icon_4',
    )
,
    array(
        'icon'  => "fa-dribbble",
        'link'  => "#",
        'label' => __('Icon 5', 'one-page-express'),
        'id'    => 'social_icon_5',
    ),
);

function one_page_express_footer_settings($wp_customize)
{

    $wp_customize->add_section(new OnePageExpress\Info_PRO_Section(
        $wp_customize,
        'ope-pro',
        array(
            "priority"   => 0,
            'capability' => "edit_theme_options",
        )));

    Kirki::add_field('one_page_express', array(
        'type'     => 'select',
        'settings' => 'one_page_express_footer_template',
        'label'    => esc_html__('Template', 'one-page-express'),
        'section'  => 'one_page_express_footer_template',
        'default'  => 'simple',
        'choices'  => array(
            "simple"        => __("Simple", "one-page-express"),
            "contact-boxes" => __("Contact Boxes", "one-page-express"),
            "content-lists" => __("Widgets Boxes", "one-page-express"),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'ope-info-pro',
        'label'     => __('Footer text and color options available in PRO. @BTN@', 'one-page-express'),
        'section'   => 'one_page_express_footer_template',
        'settings'  => "one_page_express_footer__footer_pro",
        'default'   => true,
        'transport' => 'postMessage',
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'sectionseparator',
        'label'           => __('Box 1', 'one-page-express'),
        'section'         => 'one_page_express_footer_template',
        'settings'        => "one_page_express_footer_box1_separator",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => 'in',
                'value'    => array("contact-boxes"),
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'font-awesome-icon-control',
        'settings'        => 'one_page_express_footer_boxes_b1_icon',
        'label'           => __('Icon', 'one-page-express'),
        'section'         => 'one_page_express_footer_template',
        'default'         => "fa-map-marker",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => '==',
                'value'    => "contact-boxes",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'textarea',
        'settings'          => 'one_page_express_footer_boxes_b1_text',
        'label'             => __('Text', 'one-page-express'),
        'section'           => 'one_page_express_footer_template',
        'default'           => "San Francisco - Adress - 18 California Street 1100.",
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => '==',
                'value'    => "contact-boxes",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'sectionseparator',
        'label'           => __('Box 2', 'one-page-express'),
        'section'         => 'one_page_express_footer_template',
        'settings'        => "one_page_express_footer_box2_separator",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => 'in',
                'value'    => array("contact-boxes"),
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'font-awesome-icon-control',
        'settings'        => 'one_page_express_footer_boxes_b2_icon',
        'label'           => __('Icon', 'one-page-express'),
        'section'         => 'one_page_express_footer_template',
        'default'         => "fa-envelope-o",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => '==',
                'value'    => "contact-boxes",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'textarea',
        'settings'          => 'one_page_express_footer_boxes_b2_text',
        'label'             => __('Text', 'one-page-express'),
        'section'           => 'one_page_express_footer_template',
        'default'           => "hello@mycoolsite.com",
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => '==',
                'value'    => "contact-boxes",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'sectionseparator',
        'label'           => __('Box 3', 'one-page-express'),
        'section'         => 'one_page_express_footer_template',
        'settings'        => "one_page_express_footer_box3_separator",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => 'in',
                'value'    => array("contact-boxes"),
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'font-awesome-icon-control',
        'settings'        => 'one_page_express_footer_boxes_b3_icon',
        'label'           => __('Icon', 'one-page-express'),
        'section'         => 'one_page_express_footer_template',
        'default'         => "fa-phone",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => '==',
                'value'    => "contact-boxes",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'textarea',
        'settings'          => 'one_page_express_footer_boxes_b3_text',
        'label'             => __('Text', 'one-page-express'),
        'section'           => 'one_page_express_footer_template',
        'default'           => "+1 (555) 345 234343",
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => '==',
                'value'    => "contact-boxes",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'sectionseparator',
        'label'           => __('Social Icons', 'one-page-express'),
        'section'         => 'one_page_express_footer_template',
        'settings'        => "one_page_express_footer_social_icons_separator",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_footer_template',
                'operator' => 'in',
                'value'    => array("contact-boxes", "content-lists"),
            ),
        ),
    ));

    global $one_page_express_footer_socials_icons;
    foreach ($one_page_express_footer_socials_icons as $social) {
        $sociallabel = $social['label'];
        $socialid    = $social['id'];
        Kirki::add_field('one_page_express', array(
            'type'            => 'checkbox',
            'settings'        => 'one_page_express_footer_social_icons_show_' . $socialid,
            'label'           => __('Show ', 'one-page-express') . $sociallabel,
            'section'         => 'one_page_express_footer_template',
            'default'         => true,
            'active_callback' => array(
                array(
                    'setting'  => 'one_page_express_footer_template',
                    'operator' => 'in',
                    'value'    => array("contact-boxes", "content-lists"),
                ),
            ),
        ));

        Kirki::add_field('one_page_express', array(
            'type'            => 'url',
            'settings'        => 'one_page_express_footer_social_icons_' . $socialid . '_url',
            'label'           => $sociallabel . __(' url', 'one-page-express'),
            'section'         => 'one_page_express_footer_template',
            'default'         => "#",
            'active_callback' => array(
                array(
                    'setting'  => 'one_page_express_footer_social_icons_show_' . $socialid,
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'one_page_express_footer_template',
                    'operator' => 'in',
                    'value'    => array("contact-boxes", "content-lists"),
                ),
            ),
        ));

        Kirki::add_field('one_page_express', array(
            'type'            => 'font-awesome-icon-control',
            'settings'        => 'one_page_express_footer_social_icons_' . $socialid . '_icon',
            'label'           => $sociallabel . __(' icon', 'one-page-express'),
            'section'         => 'one_page_express_footer_template',
            'default'         => $social['icon'],
            'active_callback' => array(
                array(
                    'setting'  => 'one_page_express_footer_social_icons_show_' . $socialid,
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'one_page_express_footer_template',
                    'operator' => 'in',
                    'value'    => array("contact-boxes", "content-lists"),
                ),
            ),
        ));
    }
}

function one_page_express_header_clasic_settings($wp_customize, $inner)
{
    $prefix  = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $section = $inner ? "header_image" : "one_page_express_header_background_chooser";

    /* background type dropdown */
    $wp_customize->add_setting($prefix . '_background_type', array(
        'default'           => "image",
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new OnePageExpress\BackgroundTypesControl($wp_customize, $prefix . '_background_type', array(
        'label'    => __('Background Type', 'one-page-express'),
        'section'  => $section,
        "choices"  => apply_filters(
            'ope_header_background_type',
            array(
                "image"     => array(
                    "label"   => __("Image", "one-page-express"),
                    "control" => array(
                        $inner ? "header_image" : "one_page_express_header_image",
                        $prefix . "_parallax_pro",
                    ),
                ),
                "gradient"  => array(
                    "label"   => __("Gradient", "one-page-express"),
                    "control" => array(
                        $prefix . "_gradient",
                        $prefix . "_gradient_pro_info",
                    ),
                ),
                "slideshow" => array(
                    "label"   => __("Slideshow", "one-page-express"),
                    "control" => array(
                        $prefix . "_slideshow",
                        $prefix . "_slideshow_speed",
                        $prefix . "_slideshow_duration",
                    ),
                ),
                "video"     => array(
                    "label"   => __("Video", "one-page-express"),
                    "control" => array(
                        $prefix . "_video",
                        $prefix . "_video_external",
                        $prefix . "_video_poster",
                    ),
                ),
            ),
            $inner,
            $prefix
        ),
        'priority' => 2,
    )));

    /* image settings */
    if ( ! $inner) {
        $wp_customize->add_setting($prefix . '_image', array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => get_template_directory_uri() . "/assets/images/home_page_header.jpg",
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $prefix . '_image',
            array(
                'label'    => __('Header Image', 'one-page-express'),
                'section'  => $section,
                'priority' => 2,
            )));

        $wp_customize->add_setting($prefix . '_parallax_pro', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(new OnePageExpress\Info_PRO_Control($wp_customize, $prefix . '_parallax_pro',
            array(
                'label'     => __('Parallax header background image available in PRO. @BTN@', 'one-page-express'),
                'section'   => $section,
                'priority'  => 2,
                'transport' => 'postMessage',
            )));
    }

    /* video settings */

    $wp_customize->add_setting($prefix . '_video', array(
        'default'           => "",
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, $prefix . '_video', array(
        'label'     => __('Self hosted video (MP4)', 'one-page-express'),
        'section'   => $section,
        'mime_type' => 'video',
        "priority"  => 2,
    )));

    $wp_customize->add_setting($prefix . '_video_external', array(
        'default'           => "https://www.youtube.com/watch?v=3iXYciBTQ0c",
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control($prefix . '_video_external', array(
        'label'    => __('External Video', 'one-page-express'),
        'section'  => $section,
        'type'     => 'text',
        "priority" => 2,
    ));

    $wp_customize->add_setting($prefix . '_video_poster', array(
        'default'           => get_template_directory_uri() . "/assets/images/Mock-up.jpg",
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $prefix . '_video_poster', array(
        'label'    => __('Video Poster', 'one-page-express'),
        'section'  => $section,
        "priority" => 2,
    )));
}

function one_page_express_footer_social_icons()
{
    global $one_page_express_footer_socials_icons;

    foreach ($one_page_express_footer_socials_icons as $social_icon) {
        $socialid = $social_icon['id'];
        $show     = get_theme_mod('one_page_express_footer_social_icons_show_' . $socialid, true);
        if ($show) {
            $url      = get_theme_mod('one_page_express_footer_social_icons_' . $socialid . '_url', '#');
            $icon_mod = 'one_page_express_footer_social_icons_' . $socialid . '_icon';
            $icon     = get_theme_mod($icon_mod, $social_icon['icon']);
            printf('<a href="%1$s" target="_blank"><i class="font-icon-19 fa %2$s"></i></a>', esc_url($url), esc_attr($icon));
        }
    }
}

function one_page_express_header_settings($inner)
{
    $prefix  = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $section = $inner ? "header_image" : "one_page_express_header_background_chooser";

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Navigation Options', 'one-page-express'),
        'section'  => $section,
        'priority' => 0,
        'settings' => $prefix . "_nav_header_1",
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'checkbox',
        'label'     => __('Show Navigation Bottom Border', 'one-page-express'),
        'section'   => $section,
        'priority'  => 0,
        'settings'  => "{$prefix}_nav_border",
        'default'   => false,
        'transport' => 'refresh',
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'checkbox',
        'label'     => __('Boxed Navigation', 'one-page-express'),
        'section'   => $section,
        'priority'  => 0,
        'settings'  => "{$prefix}_nav_boxed",
        'default'   => false,
        'transport' => 'refresh',
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'checkbox',
        'label'     => __('Stick to top', 'one-page-express'),
        'section'   => $section,
        'priority'  => 0,
        'settings'  => "{$prefix}_nav_sticked",
        'default'   => true,
        'transport' => 'refresh',
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'checkbox',
        'label'     => __('Transparent Navigation', 'one-page-express'),
        'section'   => $section,
        'priority'  => 0,
        'settings'  => "{$prefix}_nav_transparent",
        'default'   => true,
        'transport' => 'postMessage',
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'ope-info-pro',
        'label'     => __('Navigation colors and typography options available in PRO. @BTN@', 'one-page-express'),
        'section'   => $section,
        'priority'  => 0,
        'settings'  => "{$prefix}_nav_pro",
        'default'   => true,
        'transport' => 'postMessage',
    ));

    $nav_class = ".homepage.header-top.fixto-fixed";
    if ($inner) {
        $nav_class = ".header-top.fixto-fixed";
    }

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Header Background Options', 'one-page-express'),
        'section'  => $section,
        'priority' => 1,
        'settings' => $prefix . "_header_1",
    ));

    if ( ! $inner) {
        Kirki::add_field('one_page_express', array(
            'type'      => 'checkbox',
            'label'     => __('Full Height Background', 'one-page-express'),
            'section'   => "one_page_express_header_background_chooser",
            'priority'  => 1,
            'settings'  => 'one_page_express_full_height',
            'default'   => false,
            'transport' => 'postMessage',
        ));
    }

    Kirki::add_field('one_page_express', array(
        'type'      => 'radio-html',
        'settings'  => $prefix . '_gradient',
        'label'     => esc_html__('Header Gradient', 'one-page-express'),
        'section'   => $section,
        'default'   => 'plum_plate',
        "priority"  => 2,
        'choices'   => array(
            "plum_plate"    => "plum_plate",
            "ripe_malinka"  => "ripe_malinka",
            "new_life"      => "new_life",
            "sunny_morning" => "sunny_morning",
        ),
        'transport' => 'postMessage',
    ));


    Kirki::add_field('one_page_express', array(
        'type'      => 'ope-info-pro',
        'settings'  => $prefix . '_gradient_pro_info',
        'label'     => esc_html__('You can use over 170 gradients in the PRO version. @BTN@', 'one-page-express'),
        'section'   => $section,
        "priority"  => 2,
        'transport' => 'postMessage',
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'repeater',
        'label'     => __('Header Slideshow Images', 'one-page-express'),
        'section'   => $section,
        'priority'  => 2,
        'row_label' => array(
            'type'  => 'text',
            'value' => esc_attr__('slideshow image', 'one-page-express'),
        ),
        'settings'  => $prefix . '_slideshow',
        'default'   => array(
            array("url" => get_template_directory_uri() . "/assets/images/home_page_header.jpg"),
            array("url" => get_template_directory_uri() . "/assets/images/jeremy-bishop-14593.jpg"),
        ),
        'fields'    => array(
            'url' => array(
                'type'    => 'image',
                'label'   => esc_attr__('Image', 'one-page-express'),
                'default' => get_template_directory_uri() . "/assets/images/home_page_header.jpg",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'number',
        'settings'        => $prefix . '_slideshow_duration',
        'label'           => __('Slide Duration', 'one-page-express'),
        'section'         => $section,
        'priority'        => 2,
        'default'         => 5000,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'number',
        'priority'        => 2,
        'settings'        => $prefix . '_slideshow_speed',
        'label'           => __('Effect Speed', 'one-page-express'),
        'section'         => $section,
        'default'         => 1000,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'slideshow',
            ),
        ),
    ));


    /* overlay settings */

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Header Overlay Options', 'one-page-express'),
        'section'  => $section,
        'priority' => 3,
        'settings' => $prefix . '_overlay_header',
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'settings' => $prefix . '_show_overlay',
        'label'    => __('Show overlay', 'one-page-express'),
        'section'  => $section,
        'priority' => 3,
        'default'  => true,
    ));

    $header_class = $inner ? ".header" : ".header-homepage";

    Kirki::add_field('one_page_express', array(
        'type'      => 'color',
        'label'     => __('Overlay Color', 'one-page-express'),
        'section'   => $section,
        'priority'  => 3,
        'settings'  => $prefix . '_overlay_color',
        'default'   => "#000",
        'transport' => 'postMessage',
        'choices'   => array(
            'alpha' => false,
        ),

        "output" => array(
            array(
                'element'  => $header_class . '.color-overlay:before',
                'property' => 'background-color',
            ),
        ),

        'js_vars'         => array(
            array(
                'element'  => $header_class . ".color-overlay:before",
                'function' => 'css',
                'property' => 'background-color',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'slider',
        'label'     => __('Overlay Opacity', 'one-page-express'),
        'section'   => $section,
        'priority'  => 3,
        'settings'  => $prefix . '_overlay_opacity',
        'default'   => 0.4,
        'transport' => 'postMessage',
        'choices'   => array(
            'min'  => '0',
            'max'  => '1',
            'step' => '0.01',
        ),

        "output" => array(
            array(
                'element'  => $header_class . '.color-overlay:before',
                'property' => 'opacity',
            ),
        ),

        'js_vars'         => array(
            array(
                'element'  => $header_class . '.color-overlay:before',
                'function' => 'css',
                'property' => 'opacity',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_overlay',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Header Separator', 'one-page-express'),
        'section'  => $section,
        'settings' => $prefix . '_separator_header',
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'label'    => __('Show header separator', 'one-page-express'),
        'section'  => $section,
        'settings' => $prefix . '_show_separator',
        'default'  => true,
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'select',
        'settings'        => $prefix . '_separator',
        'label'           => esc_html__('Type', 'one-page-express'),
        'section'         => $section,
        'default'         => 'triangle-asymmetrical-negative',
        'choices'         => one_page_express_separators_list(),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    $separator_class = $inner ? ".header-separator" : ".header-separator";

    Kirki::add_field('one_page_express', array(
        'type'            => 'slider',
        'label'           => __('Separator Height', 'one-page-express'),
        'section'         => $section,
        'settings'        => $prefix . '_separator_height',
        'default'         => 90,
        'transport'       => 'postMessage',
        'choices'         => array(
            'min'  => '0',
            'max'  => '400',
            'step' => '1',
        ),
        "output"          => array(
            array(
                "element"  => $inner ? ".header-separator svg" : ".header-homepage + .header-separator svg",
                'property' => 'height',
                'suffix'   => '!important',
                'units'    => 'px',
            ),
        ),
        'js_vars'         => array(
            array(
                'element'  => $inner ? ".header-separator svg" : ".header-homepage + .header-separator svg",
                'function' => 'css',
                'property' => 'height',
                'units'    => "px",
                'suffix'   => '!important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    $section       = $inner ? "one_page_express_inner_header_content" : "one_page_express_header_content";
    $content_class = $inner ? ".inner-header-description" : ".header-description";

    if ($inner) {
        Kirki::add_field('one_page_express', array(
            'type'     => 'radio-buttonset',
            'label'    => __('Text Align', 'one-page-express'),
            'section'  => $section,
            'settings' => $prefix . '_text_align',
            'default'  => "center",

            "choices" => array(
                "left"   => __("Left", "one-page-express"),
                "center" => __("Center", "one-page-express"),
                "right"  => __("Right", "one-page-express"),
            ),

            "output" => array(
                array(
                    "element"     => $content_class,
                    "property"    => "text-align",
                    "media_query" => "@media only screen and (min-width: 768px)",
                ),
            ),

            'transport' => 'postMessage',

            'js_vars' => array(
                array(
                    'element'     => $content_class,
                    'function'    => 'css',
                    'property'    => 'text-align',
                    "media_query" => "@media only screen and (min-width: 768px)",
                ),
            ),
        ));

        Kirki::add_field('one_page_express', array(
            'type'            => 'checkbox',
            'label'           => __('Show subtitle (blog description)', 'one-page-express'),
            'section'         => $section,
            'settings'        => $prefix . '_show_subtitle',
            'default'         => true,
            'partial_refresh' => array(
                $prefix . '_show_subtitle' => array(
                    'selector'            => '.inner-header-description .header-subtitle',
                    'container_inclusive' => true,
                    'render_callback'     => function () {
                        $one_page_express_inner_header_show_subtitle = get_theme_mod('one_page_express_inner_header_show_subtitle', 1);
                        if ($one_page_express_inner_header_show_subtitle) {
                            echo esc_html(get_bloginfo('description'));
                        }
                    },
                ),
            ),
        ));

        Kirki::add_field('one_page_express', array(
            'type'     => 'spacing',
            'label'    => __('Content Spacing', 'one-page-express'),
            'section'  => "one_page_express_inner_header_content",
            'settings' => 'one_page_express_inner_header_spacing',

            'default' => array(
                "top"    => "8%",
                "bottom" => "8%",
            ),

            "output" => array(
                array(
                    "element"  => ".inner-header-description",
                    "property" => "padding",
                    'suffix'   => ' !important',
                ),
            ),

            'transport' => 'postMessage',

            'js_vars' => array(
                array(
                    'element'  => '.inner-header-description',
                    'function' => 'css',
                    'property' => 'padding',
                    'suffix'   => ' !important',
                ),
            ),
        ));
    }
}


if ( ! function_exists("one_page_express_print_header_content")) {
    function one_page_express_print_header_content()
    {
        one_page_express_print_header_title();
        one_page_express_print_header_subtitle();

        echo '<div class="header-buttons-wrapper">';
        one_page_express_print_header_button_1();
        one_page_express_print_header_button_2();
        echo '</div>';
    }
}

function one_page_express_separators_list()
{
    $allseparators = array(
        'tilt'                  => array(
            'title'       => _x('Tilt', 'Shapes', 'one-page-express'),
            'has_flip'    => true,
            'height_only' => true,
        ),
        'tilt-flipped'          => array(
            'title'       => _x('Tilt Flipped', 'Shapes', 'one-page-express'),
            'has_flip'    => true,
            'height_only' => true,
        ),
        'opacity-tilt'          => array(
            'title'    => _x('Tilt Opacity', 'Shapes', 'one-page-express'),
            'has_flip' => true,
        ),
        'triangle'              => array(
            'title'        => _x('Triangle', 'Shapes', 'one-page-express'),
            'has_negative' => true,
        ),
        'triangle-asymmetrical' => array(
            'title'        => _x('Triangle Asymmetrical', 'Shapes', 'one-page-express'),
            'has_negative' => true,
            'has_flip'     => true,
        ),

        'opacity-fan' => array(
            'title' => _x('Fan Opacity', 'Shapes', 'one-page-express'),
        ),
        'mountains'   => array(
            'title'    => _x('Mountains', 'Shapes', 'one-page-express'),
            'has_flip' => true,
        ),

        'pyramids' => array(
            'title'        => _x('Pyramids', 'Shapes', 'one-page-express'),
            'has_negative' => true,
            'has_flip'     => true,
        ),

        'waves'         => array(
            'title'        => _x('Waves', 'Shapes', 'one-page-express'),
            'has_negative' => true,
            'has_flip'     => true,
        ),
        'wave-brush'    => array(
            'title'    => _x('Waves Brush', 'Shapes', 'one-page-express'),
            'has_flip' => true,
        ),
        'waves-pattern' => array(
            'title'    => _x('Waves Pattern', 'Shapes', 'one-page-express'),
            'has_flip' => true,
        ),

        'clouds' => array(
            'title'        => _x('Clouds', 'Shapes', 'one-page-express'),
            'has_negative' => true,
            'has_flip'     => true,
            'height_only'  => true,
        ),

        'curve'              => array(
            'title'        => _x('Curve', 'Shapes', 'one-page-express'),
            'has_negative' => true,
        ),
        'curve-asymmetrical' => array(
            'title'        => _x('Curve Asymmetrical', 'Shapes', 'one-page-express'),
            'has_negative' => true,
            'has_flip'     => true,
        ),

        'drops' => array(
            'title'        => _x('Drops', 'Shapes', 'one-page-express'),
            'has_negative' => true,
            'has_flip'     => true,
            'height_only'  => true,
        ),

        'arrow' => array(
            'title'        => _x('Arrow', 'Shapes', 'one-page-express'),
            'has_negative' => true,
        ),

        'book' => array(
            'title'        => _x('Book', 'Shapes', 'one-page-express'),
            'has_negative' => true,
        ),

        'split' => array(
            'title'        => _x('Split', 'Shapes', 'one-page-express'),
            'has_negative' => true,
        ),

        'zigzag' => array(
            'title' => _x('Zigzag', 'Shapes', 'one-page-express'),
        ),
    );
    $separators    = array();

    foreach ($allseparators as $key => $value) {
        $separators[$key] = $value['title'];
        if (isset($value['has_negative'])) {
            $separators["$key-negative"] = $value['title'] . " Negative";
        }
    }

    // array_multisort($separators);

    return $separators;
}

function one_page_express_customize_register_controls($wp_customize)
{
    $wp_customize->register_control_type('OnePageExpress\Kirki_Controls_Separator_Control');

    // Register our custom control with Kirki
    add_filter('kirki/control_types', function ($controls) {
        $controls['sectionseparator'] = '\\OnePageExpress\\Kirki_Controls_Separator_Control';
        $controls['ope-info']         = '\\OnePageExpress\\Info_Control';
        $controls['ope-info-pro']     = '\\OnePageExpress\\Info_PRO_Control';

        return $controls;
    });

    $wp_customize->register_control_type('\OnePageExpress\Kirki_Controls_Radio_HTML_Control');

    // Register our custom control with Kirki
    add_filter('kirki/control_types', function ($controls) {
        $controls['radio-html'] = '\\OnePageExpress\\Kirki_Controls_Radio_HTML_Control';

        return $controls;
    });

    $wp_customize->register_control_type('\OnePageExpress\FontAwesomeIconControl');
    add_filter('kirki/control_types', function ($controls) {
        $controls['font-awesome-icon-control'] = "\\OnePageExpress\\FontAwesomeIconControl";

        return $controls;
    });

    require_once get_template_directory() . "/customizer/customizer-controls.php";

    one_page_express_add_sections($wp_customize);
    one_page_express_customize_register_action($wp_customize);
}

if ( ! class_exists("Kirki")) {
    include_once get_template_directory() . '/customizer/kirki/kirki.php';
}

function one_page_express_partial_render_callback($partial)
{
    return get_theme_mod($partial->settings[0]);
}

one_page_express_header_settings(false);
one_page_express_header_settings(true);
one_page_express_header_frontpage_settings();

function one_page_express_customize_register_action($wp_customize)
{
    one_page_express_header_clasic_settings($wp_customize, false);
    one_page_express_header_clasic_settings($wp_customize, true);
    one_page_express_footer_settings($wp_customize);

    $wp_customize->add_setting('header_presets', array(
        'default'           => "image",
        'sanitize_callback' => 'esc_html',
        "transport"         => "postMessage",
    ));

    $wp_customize->add_control(new OnePageExpress\RowsListControl($wp_customize, 'header_presets', array(
        'label'      => __('Background Type', 'one-page-express'),
        'section'    => 'one_page_express_header_layout',
        "insertText" => __("Apply Preset", "one-page-express"),
        "type"       => "presets_changer",
        "dataSource" => one_page_express_header_presets(),
        "priority"   => 2,
    )));

    if (apply_filters('show_inactive_plugin_infos', true)) {
        $wp_customize->add_setting('frontpage_header_presets_pro', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control(new OnePageExpress\Info_Control($wp_customize, 'frontpage_header_presets_pro',
            array(
                'label'     => __('10 more beautiful header designs are available in the PRO version. @BTN@', 'one-page-express'),
                'section'   => 'one_page_express_header_layout',
                'priority'  => 2,
                'transport' => 'postMessage',
            )));
    }

    /* logo height */
    $wp_customize->add_setting('one_page_express_logo_max_height', array(
        'default'           => 70,
        'sanitize_callback' => 'one_page_express_sanitize_textfield',
    ));

    $wp_customize->add_control('one_page_express_logo_max_height', array(
        'label'    => __('Logo Max Height', 'one-page-express'),
        'section'  => 'title_tagline',
        'priority' => 8,
        'type'     => 'number',
    ));

    $wp_customize->add_setting('one_page_express_bold_logo', array(
        'default'           => true,
        'sanitize_callback' => 'one_page_express_sanitize_checkbox',
    ));
    $wp_customize->add_control('one_page_express_bold_logo', array(
        'label'    => __('Alternate text logo words', 'one-page-express'),
        'section'  => 'title_tagline',
        'priority' => 9,
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting('one_page_express_logo_dark', array(
        'default'           => false,
        'sanitize_callback' => 'absint',
    ));

    $custom_logo_args = get_theme_support('custom-logo');
    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'one_page_express_logo_dark', array(
        'label'         => __('Dark Logo', 'one-page-express'),
        'section'       => 'title_tagline',
        'priority'      => 9,
        'height'        => $custom_logo_args[0]['height'],
        'width'         => $custom_logo_args[0]['width'],
        'flex_height'   => $custom_logo_args[0]['flex-height'],
        'flex_width'    => $custom_logo_args[0]['flex-width'],
        'button_labels' => array(
            'select'       => __('Select logo', 'one-page-express'),
            'change'       => __('Change logo', 'one-page-express'),
            'remove'       => __('Remove', 'one-page-express'),
            'default'      => __('Default', 'one-page-express'),
            'placeholder'  => __('No logo selected', 'one-page-express'),
            'frame_title'  => __('Select logo', 'one-page-express'),
            'frame_button' => __('Choose logo', 'one-page-express'),
        ),
    )));
}

function one_page_express_header_frontpage_settings()
{
    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Main Content', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => "one_page_express_header_content_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'settings' => 'one_page_express_blog_header_overlap',
        'label'    => __('Allow blog content to overlap header', 'one-page-express'),
        'section'  => 'one_page_express_inner_header_content',
        'default'  => true,
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'dimension',
        'settings'        => 'one_page_express_blog_header_margin',
        'label'           => __('Overlap with', 'one-page-express'),
        'section'         => 'one_page_express_inner_header_content',
        'default'         => '200px',
        'active_callback' => array(
            array(
                "setting"  => "one_page_express_blog_header_overlap",
                "operator" => "==",
                "value"    => true,
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'select',
        'settings' => 'one_page_express_header_content_partial',
        'label'    => esc_html__('Content template', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'default'  => 'content-on-center',
        'choices'  => array(
            "content-on-center" => __("Text on center", "one-page-express"),
            "content-on-right"  => __("Text on right", "one-page-express"),
            "content-on-left"   => __("Text on left", "one-page-express"),
            "image-on-left"     => __("Image on left, text on right", "one-page-express"),
            "image-on-right"    => __("Text on left, image on right", "one-page-express"),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'ope-info-pro',
        'label'    => __('More content layouts available in PRO. @BTN@', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'settings' => "one_page_express_header_content_partial_pro",
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'radio-buttonset',
        'label'    => __('Text Align', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'settings' => 'one_page_express_header_text_align',
        'default'  => "center",

        "choices" => array(
            "left"   => __("Left", "one-page-express"),
            "center" => __("Center", "one-page-express"),
            "right"  => __("Right", "one-page-express"),
        ),

        "output" => array(
            array(
                "element"     => ".header-content .align-holder",
                "property"    => "text-align",
                "suffix"      => "!important",
                "media_query" => "@media only screen and (min-width: 768px)",
            ),

        ),

        'transport' => 'postMessage',

        'js_vars' => array(
            array(
                'element'  => ".header-content .align-holder",
                'function' => 'css',
                "suffix"   => "!important",
                'property' => 'text-align',
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'spacing',
        'label'    => __('Content Spacing', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => 'one_page_express_header_spacing',

        'default' => array(
            "top"    => "8%",
            "bottom" => "8%",
        ),

        "output" => array(
            array(
                "element"  => ".header-homepage .header-description-row",
                "property" => "padding",
                'suffix'   => ' !important',
            ),
        ),

        'transport' => 'postMessage',

        'js_vars' => array(
            array(
                'element'  => '.header-homepage .header-description-row',
                'function' => 'css',
                'property' => 'padding',
                'suffix'   => ' !important',
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'slider',
        'label'    => __('Image width', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => 'one_page_express_header_column_width',

        'choices' => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'default' => 50,

        'transport' => 'postMessage',

        "output" => array(
            array(
                "element"     => ".header-description-left",
                "property"    => "width",
                'suffix'      => '%!important',
                "media_query" => "@media only screen and (min-width: 768px)",
            ),
            array(
                "element"     => ".header-description-right",
                "property"    => "width",
                "function"    => "style",
                'prefix'      => 'calc(100% - ',
                'suffix'      => '%)!important',
                "media_query" => "@media only screen and (min-width: 768px)",
            ),
        ),

        "js_vars"         => array(
            array(
                "element"     => ".header-description-left",
                "function"    => "style",
                "property"    => "width",
                'suffix'      => '%!important',
                "media_query" => "@media only screen and (min-width: 768px)",
            ),
            array(
                "element"     => ".header-description-right",
                "property"    => "width",
                "function"    => "style",
                'prefix'      => 'calc(100% - ',
                'suffix'      => '% )!important',
                "media_query" => "@media only screen and (min-width: 768px)",
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_header_content_partial',
                'operator' => 'in',
                'value'    => array('image-on-left', 'image-on-right'),
            ),
        ),

    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'slider',
        'label'    => __('Text Width', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => 'one_page_express_header_content_width',

        'choices' => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'default'   => 100,
        'transport' => 'postMessage',

        "js_vars" => array(
            array(
                "element"  => ".header-content",
                "function" => "css",
                "property" => "width",
                'suffix'   => '!important',
                "units"    => "%",
            ),
        ),

        "output" => array(
            array(
                "element"     => ".header-content",
                "property"    => "width",
                'suffix'      => '!important',
                "units"       => "%",
                "media_query" => "@media only screen and (min-width: 768px)",
            ),
        ),
    ));

    /* Header Content Image */

    function one_page_express_render_header_image()
    {
        $image = get_theme_mod('one_page_express_header_content_image', get_template_directory_uri() . "/assets/images/project1.jpg");
        if (empty($image)) {
            $image = "";
        }

        return '<img  class="homepage-header-image" src="' . esc_url($image) . '" />';
    }

    Kirki::add_field('one_page_express', array(
        'type'            => 'image',
        'settings'        => 'one_page_express_header_content_image',
        'label'           => __('Image', 'one-page-express'),
        'section'         => 'one_page_express_header_content',
        'default'         => get_template_directory_uri() . "/screenshot.jpg",
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_header_content_partial',
                'operator' => 'contains',
                'value'    => array('image-on-left', 'image-on-right'),
            ),
        ),

        'partial_refresh' => array(
            'one_page_express_header_content_image' => array(
                'selector'            => ".header-description-left",
                'container_inclusive' => false,
                'render_callback'     => "one_page_express_render_header_image",
            ),
        ),
    ));

    /* Header Title */

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Title', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => "one_page_express_header_content_title_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'settings' => 'one_page_express_header_show_title',
        'label'    => __('Show title', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'default'  => true,
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'text',
        'settings'          => 'one_page_express_header_title',
        'label'             => __('Title', 'one-page-express'),
        'section'           => 'one_page_express_header_content',
        'default'           => "",
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'one_page_express_header_show_title',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport'         => 'postMessage',
        'js_vars'           => array(
            array(
                'element'  => ".header-homepage .heading8",
                'function' => 'html',
            ),
        ),
        'partial_refresh'   => array(
            'one_page_express_header_title' => array(
                'selector'        => ".header-homepage .heading8",
                'render_callback' => "one_page_express_partial_render_callback",
            ),
        ),

    ));

    /* Header Subtitle */

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Subtitle', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => "one_page_express_header_content_subtitle_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'settings' => 'one_page_express_header_show_subtitle',
        'label'    => __('Show subtitle', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'default'  => true,
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'textarea',
        'settings'          => 'one_page_express_header_subtitle',
        'label'             => __('Subtitle', 'one-page-express'),
        'section'           => 'one_page_express_header_content',
        'default'           => "",
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'one_page_express_header_show_subtitle',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport'         => 'postMessage',
        'js_vars'           => array(
            array(
                'element'  => ".header-homepage .header-subtitle",
                'function' => 'html',
            ),
        ),
        'partial_refresh'   => array(
            'one_page_express_header_content' => array(
                'selector'        => ".header-homepage .header-subtitle",
                'render_callback' => "one_page_express_partial_render_callback",
            ),
        ),

    ));

    /* Button 1 */

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Primary Button', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => "one_page_express_header_content_primary_button_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'settings' => 'one_page_express_header_show_btn_1',
        'label'    => __('Show primary button', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'default'  => true,
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'text',
        'settings'          => 'one_page_express_header_btn_1_label',
        'label'             => __('Label', 'one-page-express'),
        'section'           => 'one_page_express_header_content',
        'default'           => "",
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'one_page_express_header_show_btn_1',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport'         => 'postMessage',
        'js_vars'           => array(
            array(
                'element'  => ".header-homepage a.hp-header-primary-button",
                'function' => 'html',
            ),
        ),
        'partial_refresh'   => array(
            'one_page_express_header_btn_1_label' => array(
                'selector'        => ".header-homepage a.hp-header-primary-button",
                'render_callback' => "one_page_express_partial_render_callback",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'url',
        'settings'        => 'one_page_express_header_btn_1_url',
        'label'           => __('URL', 'one-page-express'),
        'section'         => 'one_page_express_header_content',
        'default'         => '#',
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_header_show_btn_1',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => ".header-homepage a.hp-header-primary-button",
                'function' => 'html',
                'attr'     => 'href',
            ),
        ),
    ));

    /* Button 2 */

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Secondary Button', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        'settings' => "one_page_express_header_content_secondary_button_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'settings' => 'one_page_express_header_show_btn_2',
        'label'    => __('Show secondary button', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'default'  => true,
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'text',
        'settings'          => 'one_page_express_header_btn_2_label',
        'label'             => __('Label', 'one-page-express'),
        'section'           => 'one_page_express_header_content',
        'default'           => "",
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'   => array(
            array(
                'setting'  => 'one_page_express_header_show_btn_2',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport'         => 'postMessage',
        'js_vars'           => array(
            array(
                'element'  => ".header-homepage a.hp-header-secondary-button",
                'function' => 'html',
            ),
        ),
        'partial_refresh'   => array(
            'one_page_express_header_btn_2_label' => array(
                'selector'        => ".header-homepage a.hp-header-secondary-button",
                'render_callback' => "one_page_express_partial_render_callback",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'url',
        'settings'        => 'one_page_express_header_btn_2_url',
        'label'           => __('URL', 'one-page-express'),
        'section'         => 'one_page_express_header_content',
        'default'         => '#',
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_header_show_btn_2',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => ".header-homepage a.hp-header-secondary-button",
                'function' => 'html',
                'attr'     => 'href',
            ),
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'ope-info-pro',
        'label'    => __('Title and buttons style options available in PRO. @BTN@', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'settings' => "one_page_express_header_content_title_buttons_pro",
    ));

}

function one_page_express_customize_change_controls($wp_customize)
{
    $wp_customize->get_control('header_image')->priority = 3;

    \OnePageExpress\Companion_Plugin::check_companion($wp_customize);
}

add_action('customize_register', 'one_page_express_customize_register_controls');
add_action('customize_register', 'one_page_express_customize_change_controls', 999);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function one_page_express_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
    }
}

add_action('wp_head', 'one_page_express_pingback_header');

/**
 * Register sidebar
 */
function one_page_express_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Sidebar widget area', 'one-page-express'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => "Footer First Box Widgets",
        'id'            => "one_page_express_first_box_widgets",
        'title'         => "Widget Area",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => "Footer Second Box Widgets",
        'id'            => "one_page_express_second_box_widgets",
        'title'         => "Widget Area",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => "Footer Third Box Widgets",
        'id'            => "one_page_express_third_box_widgets",
        'title'         => "Widget Area",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ));
}

add_action('widgets_init', 'one_page_express_widgets_init');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Read more' link.
 *
 * @return string '... Read more'
 */
function one_page_express_excerpt_more($link)
{

    if ( is_admin() ) {
        return $link;
    }
    
    return '&hellip; <br> <a class="button small blue" href="' . esc_url(get_permalink(get_the_ID())) . '">' . __('Read more', 'one-page-express') . '</a>';
}

add_filter('excerpt_more', 'one_page_express_excerpt_more');

function one_page_express_bold($str)
{
    $bold = get_theme_mod('one_page_express_bold_logo', true);

    if ( ! $bold) {
        return $str;
    }

    $str   = trim($str);
    $words = preg_split("/(?<=[a-z])(?=[A-Z])|(?=[\s]+)/x", $str);

    $result = "";
    $c      = 0;
    for ($i = 0; $i < count($words); $i++) {
        $word = $words[$i];
        if (preg_match("/^\s*$/", $word)) {
            $result .= $words[$i];
        } else {
            $c++;
            if ($c % 2) {
                $result .= $words[$i];
            } else {
                $result .= '<span style="font-weight: 300;" class="span12">' . $words[$i] . "</span>";
            }
        }
    }

    return $result;
}

/**
 * Gets logo as text or image, depending on user
 *
 * @param boolean $footer Use in footer
 *
 * @return string Logo html
 */

function one_page_express_logo($footer = false)
{
    if (function_exists('has_custom_logo') && has_custom_logo()) {
        $dark_logo_image = get_theme_mod('one_page_express_logo_dark', false);
        if ($dark_logo_image) {
            $dark_logo_html = sprintf('<a href="%1$s" class="logo-link dark" rel="home" itemprop="url">%2$s</a>',
                esc_url(home_url('/')),
                wp_get_attachment_image($dark_logo_image, 'full', false, array(
                    'class'    => 'logo dark',
                    'itemprop' => 'logo',
                ))
            );

            echo $dark_logo_html;
        }

        the_custom_logo();
    } else if ($footer) {
        printf('<h2 class="footer-logo">%1$s</h2>', get_bloginfo('name'));
    } else {
        printf('<a class="text-logo" href="%1$s">%2$s</a>', esc_url(home_url('/')), one_page_express_bold(get_bloginfo('name')));
    }
}

function one_page_express_header_height()
{
    $full_height = get_theme_mod('one_page_express_full_height', false);

    if ($full_height) {
        return "100vh";
    } else {
        return "";
    }
}


function one_page_express_header_separator($inner = false)
{
    $prefix = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $show   = get_theme_mod($prefix . '_show_separator', true);
    if ($show) {
        $separator = get_theme_mod($prefix . '_separator', 'triangle-asymmetrical-negative');
        $reverse   = strpos($separator, "-negative") === false ? "header-separator-reverse" : "";
        echo '<div class="header-separator header-separator-bottom ' . $reverse . '">';
        ob_start();
        require get_template_directory() . "/assets/separators/" . $separator . ".svg";
        $content = ob_get_clean();
        echo $content;
        echo '</div>';
    }
}

function one_page_express_latest_posts_partial()
{
    $query = new WP_Query(
        array(
            'posts_per_page'   => 3,
            'suppress_filters' => 0,
        )
    );

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="featured-item">
                <div class="featured-item-row">
                    <?php the_post_thumbnail('large', array('class' => 'image3')); ?>
                    <div class="row_47">
                        <h3 class="heading10"><?php the_title(); ?></h3>

                        <p><?php the_excerpt(); ?></p>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    endif;
}

/* show latest posts */

function one_page_express_latest_posts()
{
    ?>
    <div class="blog-latest-posts row_34">
        <div class="gridContainer">
            <div class="row featured-items">
                <?php one_page_express_latest_posts_partial(); ?>
            </div>
        </div>
    </div>
    <?php

}


function one_page_express_enqueue_google_fonts()
{
    $gFonts = array(

        'Source Sans Pro' => array(
            "weights" => array("200", "normal", "300", "600", "700"),
        ),

        'Playfair Display' => array(
            "weights" => array("regular", "italic", "700", "900"),
        ),

    );

    $gFonts = apply_filters("one_page_express_google_fonts", $gFonts);

    foreach ($gFonts as $family => $font) {
        $fontQuery[] = $family . ":" . implode(',', $font['weights']);
    }

    $query_args = array(
        'family' => urlencode(implode('|', $fontQuery)),
        'subset' => urlencode('latin,latin-ext'),
    );

    $fontsURL = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    wp_enqueue_style('one-page-express-fonts', $fontsURL, array(), null);
}

/**
 * Enqueue scripts and styles.
 */
function one_page_express_scripts()
{

    one_page_express_enqueue_google_fonts();

    $theme = wp_get_theme();
    $ver   = $theme->get('Version');
    
    wp_enqueue_style('one-page-express-style', get_stylesheet_uri(), array(), $ver);
    wp_enqueue_style('one-page-express-font-awesome', get_template_directory_uri() . '/assets/font-awesome/font-awesome.min.css', array(), $ver);
    wp_enqueue_style('one-page-express-animate', get_template_directory_uri() . '/assets/css/animate.css', array(), $ver);

    wp_enqueue_script('one-page-express-smoothscroll', get_template_directory_uri() . '/assets/js/smoothscroll.js', array('jquery'), $ver);
    wp_enqueue_script('one-page-express-ddmenu', get_template_directory_uri() . '/assets/js/drop_menu_selection.js', array('jquery-effects-slide'), $ver, true);
    wp_enqueue_script('one-page-express-theme', get_template_directory_uri() . '/assets/js/theme.js', array('one-page-express-morphext'), $ver, true);
    wp_enqueue_script('one-page-express-morphext', get_template_directory_uri() . '/assets/js/libs/typed.js', array('jquery'), $ver, true);

    wp_enqueue_script('one-page-express-fixto', get_template_directory_uri() . '/assets/js/libs/fixto.js', array('jquery'), $ver, true);
    wp_enqueue_script('one-page-express-sticky', get_template_directory_uri() . '/assets/js/sticky.js', array('one-page-express-fixto'), $ver, true);
    wp_enqueue_script('masonry', get_template_directory_uri() . '/assets/js/masonry.js', array('jquery'), $ver, true);

    wp_enqueue_script('comment-reply');

    $if_front_page = (is_front_page() && ! is_home());

    $prefix = ( ! $if_front_page) ? "one_page_express_inner_header" : "one_page_express_header";

    $one_page_express_jssettings = array(
        'header_text_morph_speed' => intval(get_theme_mod('one_page_express_header_text_morph_speed', 200)),
        'header_text_morph'       => get_theme_mod('one_page_express_header_show_text_morph_animation', true),
    );

    wp_localize_script('one-page-express-theme', 'one_page_express_settings', $one_page_express_jssettings);

    $maxheight = get_theme_mod('one_page_express_logo_max_height', 70);
    wp_add_inline_style('one-page-express-style', sprintf('img.logo.dark, img.custom-logo{max-height:%1$s;}', $maxheight . "px"));

    $transparent_nav = get_theme_mod($prefix . '_nav_transparent', true);

    wp_enqueue_style('one-page-express-webgradients', get_template_directory_uri() . '/assets/css/webgradients.css', array(), $ver);
}

add_action('wp_enqueue_scripts', 'one_page_express_scripts');

/**
 * Footer copyright
 *
 * @return string The footer copyright text.
 */

if(!function_exists('one_page_express_copyright')){
    function one_page_express_copyright()
    {
        $defaultText   = __('Built using WordPress and <a href="https://extendthemes.com/go/built-with-one-page-express">OnePage Express Theme</a>.', 'one-page-express');
        $copyrightText = apply_filters("one-page-express-copyright", $defaultText);

        return '&copy;&nbsp;' . "&nbsp;" . date_i18n(__('Y','one-page-express')) . '&nbsp;' . esc_html(get_bloginfo('name')) . '.&nbsp;' . wp_kses_post($copyrightText);
    }
}

/**
 * Menu fallback used for wp_nav_menu
 *
 * @return string The wp_page_menu generated html
 */
function one_page_express_nomenu_cb()
{
    return wp_page_menu(array(
        "menu_class" => 'fm2_drop_mainmenu',
        "menu_id"    => 'drop_mainmenu_container',
        'before'     => '<ul id="drop_mainmenu" class="fm2_drop_mainmenu">',
        'after'      => apply_filters('one_page_express_nomenu_after', "") . '</ul>',
    ));
}

/**
 * The title to be used in header depending on the current post and template
 *
 * @return string The title to be used in header
 */
function one_page_express_title()
{
    $title = '';

    if (is_404()) {
        $title = __('Page not found', 'one-page-express');
    } else if (is_search()) {
        $title = sprintf(__('Search Results for &#8220;%s&#8221;', 'one-page-express'), get_search_query());
    } else if (is_home()) {
        if (is_front_page()) {
            $title = get_bloginfo('name');
        } else {
            $title = single_post_title();
        }
    } else if (is_archive()) {

        if (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } else {
            $title = get_the_archive_title();
        }
    } else if (is_single()) {
        $title = get_bloginfo('name');

        global $post;
        if ($post) {
            $title = apply_filters('single_post_title', $post->post_title, $post);
        }
    } else {
        $title = get_the_title();
    }

    $title = apply_filters('one_page_express_header_title', $title);

    return $title;
}

/**
 * Current homepage header
 *
 * @return string The escaped url of homepage header image
 */
function one_page_express_homepage_header()
{
    return esc_url(get_theme_mod('one_page_express_homepage_header', get_template_directory_uri() . "/assets/images/home_page_header.jpg"));
}

function one_page_express_background($inner = false)
{
    $attrs = array(
        'class' => $inner ? "header " : "header-homepage ",
    );

    $prefix = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $bgType = get_theme_mod($prefix . '_background_type', 'image');

    $header_type  = $inner ? "inner_header" : "header";
    $show_overlay = get_theme_mod("one_page_express_" . $header_type . "_show_overlay", true);
    if ($show_overlay) {
        $attrs['class'] .= " color-overlay ";
    }

    switch ($bgType) {

        case 'image':
            $bgImage        = $inner ? get_header_image() : get_theme_mod($prefix . '_image', get_template_directory_uri() . "/assets/images/home_page_header.jpg");
            $attrs['style'] = 'background-image:url("' . esc_url($bgImage) . '")';
            $parallax       = get_theme_mod("one_page_express_" . $header_type . "_parallax", true);
            if ($parallax) {
                $attrs['data-parallax-depth'] = "20";
            }
            break;

        case 'gradient':
            $bgGradient     = get_theme_mod($prefix . "_gradient", "plum_plate");
            $attrs['class'] .= $bgGradient;
            break;

        case 'slideshow':

            $js = get_template_directory_uri() . "/assets/js/libs/jquery.backstretch.js";
            wp_enqueue_script('one-page-express-backstretch', $js, array('jquery'), false, true);
            add_action('wp_footer', $prefix . '_slideshow_script');

            break;

        case 'video':
            $internalVideo = get_theme_mod($prefix . '_video', "");
            $video_url     = get_theme_mod($prefix . '_video_external', "https://www.youtube.com/watch?v=3iXYciBTQ0c");
            $videoPoster   = get_theme_mod($prefix . '_video_poster', get_template_directory_uri() . "/assets/images/Mock-up.jpg");

            if ($internalVideo) {
                $video_url = wp_get_attachment_url($internalVideo);
                $video_url = apply_filters('get_header_video_url', $video_url);
            }

            $video_type = wp_check_filetype($video_url, wp_get_mime_types());
            $header     = get_custom_header();
            $settings   = array(
                'mimeType'  => '',
                'videoUrl'  => $video_url,
                'posterUrl' => $videoPoster,
                'width'     => absint($header->width),
                'height'    => absint($header->height),
                'minWidth'  => 900,
                'minHeight' => 500,
                'l10n'      => array(
                    'pause'      => __('Pause', 'one-page-express'),
                    'play'       => __('Play', 'one-page-express'),
                    'pauseSpeak' => __('Video is paused.', 'one-page-express'),
                    'playSpeak'  => __('Video is playing.', 'one-page-express'),
                ),
            );

            if (preg_match('#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $video_url)) {
                $settings['mimeType'] = 'video/x-youtube';
            } else if ( ! empty($video_type['type'])) {
                $settings['mimeType'] = $video_type['type'];
            }

            $settings = apply_filters('header_video_settings', $settings);

            wp_enqueue_script('wp-custom-header');
            wp_localize_script('wp-custom-header', '_wpCustomHeaderSettings', $settings);
            wp_enqueue_script('cp-video-bg', get_template_directory_uri() . "/assets/js/video-bg.js", array('wp-custom-header'));
            $attrs['class'] .= " cp-video-bg";
            break;
    }

    $result = "";

    if ( ! isset($attrs['style'])) {
        $attrs['style'] = "";
    } else {
        $attrs['style'] .= ";";
    }

    if ( ! $inner) {
        $attrs['style'] .= " min-height:" . one_page_express_header_height();
    }

    $attrs = apply_filters('one_page_express_header_background_atts', $attrs, $bgType, $inner);

    foreach ($attrs as $key => $value) {
        $value  = trim(esc_attr($value));
        $result .= " {$key}='{$value}'";
    }

    return $result;
}

function one_page_express_header_slideshow_script()
{
    one_page_express_header_slideshow_script_();
}

function one_page_express_inner_header_slideshow_script()
{
    one_page_express_header_slideshow_script_(true);
}

function one_page_express_header_slideshow_script_($inner = false)
{
    $prefix = $inner ? "one_page_express_inner_header" : "one_page_express_header";

    $bgSlideshow = get_theme_mod($prefix . "_slideshow", array(
        array("url" => get_template_directory_uri() . "/assets/images/home_page_header.jpg"),
        array("url" => get_template_directory_uri() . "/assets/images/jeremy-bishop-14593.jpg"),
    ));

    $images = array();
    foreach ($bgSlideshow as $key => $value) {
        if (is_numeric($value['url'])) {
            array_push($images, wp_get_attachment_url($value['url']));
        } else {
            array_push($images, $value['url']);
        }
    }

    $bgSlideshowSpeed    = intval(get_theme_mod($prefix . "_slideshow_speed", '1000'));
    $bgSlideshowDuration = intval(get_theme_mod($prefix . "_slideshow_duration", '5000'));

    $one_page_express_jssettings = array(
        'images'             => $images,
        'duration'           => intval($bgSlideshowDuration),
        'transitionDuration' => intval($bgSlideshowSpeed),
        'animateFirst'       => false,
    );

    wp_localize_script('one-page-express-backstretch', 'one_page_express_backstretch', $one_page_express_jssettings);
}

function one_page_express_print_video_container($inner = false)
{
    $prefix = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $bgType = get_theme_mod($prefix . "_background_type", null);
    $poster = get_theme_mod($prefix . '_video_poster', get_template_directory_uri() . "/assets/images/Mock-up.jpg");

    if ($bgType === "video"):
        ?>
        <div id="wp-custom-header" class="wp-custom-header cp-video-bg">
            <script>
                // resize the poster image as fast as possible to a 16:9 visible ratio
                var one_page_express_video_background = {
                    getVideoRect: function () {
                        var header = document.querySelector(".cp-video-bg");
                        var headerWidth = header.getBoundingClientRect().width,
                            videoWidth = headerWidth,
                            videoHeight = header.getBoundingClientRect().height;

                        videoWidth = Math.max(videoWidth, videoHeight);

                        if (videoWidth < videoHeight * 16 / 9) {
                            videoWidth = 16 / 9 * videoHeight;
                        } else {
                            videoHeight = videoWidth * 9 / 16;
                        }

                        videoWidth *= 1.2;
                        videoHeight *= 1.2;

                        var marginLeft = -0.5 * (videoWidth - headerWidth);

                        return {
                            width: Math.round(videoWidth),
                            height: Math.round(videoHeight),
                            left: Math.round(marginLeft)
                        }
                    },

                    resizePoster: function () {
                        var posterHolder = document.querySelector('#wp-custom-header');

                        var size = one_page_express_video_background.getVideoRect();
                        posterHolder.style.backgroundSize = size.width + 'px auto'


                    }

                }

                setTimeout(one_page_express_video_background.resizePoster, 0);
            </script>
        </div>
        <style>
            .header-wrapper {
                background: transparent;
            }

            div#wp-custom-header.cp-video-bg {
                background-image: url('<?php echo esc_url($poster); ?>');
                background-color: #000000;
                background-position: center top;
                background-size: cover;
                position: absolute;
                z-index: -2;
                height: 100%;
                width: 100%;
                margin-top: 0;
                top: 0px;
                -webkit-transform: translate3d(0, 0, -2px);
            }

            .header-homepage.cp-video-bg,
            .header.cp-video-bg {
                background-color: transparent !important;
                overflow: hidden;
            }

            div#wp-custom-header.cp-video-bg #wp-custom-header-video {
                object-fit: cover;
                position: absolute;
                opacity: 0;
                width: 100%;
                transition: opacity 0.4s cubic-bezier(0.44, 0.94, 0.25, 0.34);
            }

            div#wp-custom-header.cp-video-bg button#wp-custom-header-video-button {
                display: none;
            }
        </style>
        <?php
    endif;
}

add_action('wp_ajax_cp_list_fa', function () {
    $result = array();
    $icons  = (require get_template_directory() . "/customizer/fa-icons-list.php");

    foreach ($icons as $icon) {
        $title    = str_replace('-', ' ', str_replace('fa-', '', $icon));
        $result[] = array(
            'id'    => $icon,
            'fa'    => $icon,
            "title" => $title,
            'mime'  => "fa-icon/font",
            'sizes' => null,
        );
    }

    echo json_encode($result);
    exit;

});

function one_page_express_header_main_class($inner = false)
{
    $classes = array();

    $prefix = $inner ? "one_page_express_inner_header" : "one_page_express_header";

    if (get_theme_mod("{$prefix}_nav_boxed", false)) {
        $classes[] = "boxed";
    }

    $transparent_nav = get_theme_mod($prefix . '_nav_transparent', true);

    if ( ! $transparent_nav) {
        $classes[] = "coloured-nav";
    }

    if (get_theme_mod("{$prefix}_nav_border", false)) {
        $classes[] = "bordered";
    }

    echo implode(" ", $classes);
}

function one_page_express_navigation_wrapper_class($inner = false)
{
    $classes = array();

    $inner = $inner ? $inner : ope_is_inner_page();

    $prefix = $inner ? "one_page_express_inner_header" : "one_page_express_header";

    if ($inner) {
        $classes[] = 'ope-inner-page';
    } else {
        $classes[] = 'ope-front-page';
    }

    if (get_theme_mod("{$prefix}_nav_boxed", false)) {
        $classes[] = "gridContainer";
    }

    echo implode(" ", $classes);
}

function one_page_express_navigation_sticky_attrs($inner = false)
{
    $atts = array(
        "data-sticky"        => 0,
        "data-sticky-mobile" => 1,
        "data-sticky-to"     => "top",
    );

    $prefix = $inner ? "one_page_express_inner_header" : "one_page_express_header";

    $result = "";
    if (get_theme_mod("{$prefix}_nav_sticked", true)) {
        foreach ($atts as $key => $value) {
            $result .= " {$key}='{$value}' ";
        }
    } else {
        $result = 'style="position:absolute;top: 0px;z-index: 1;"';
    }

    echo $result;
}

function one_page_express_pagination($args = array(), $class = 'pagination')
{
    if ($GLOBALS['wp_query']->max_num_pages <= 1) {
        return;
    }

    $args = wp_parse_args($args, array(
        'mid_size'           => 2,
        'prev_next'          => false,
        'prev_text'          => __('Older posts', 'one-page-express'),
        'next_text'          => __('Newer posts', 'one-page-express'),
        'screen_reader_text' => __('Posts navigation', 'one-page-express'),
    ));

    $links = paginate_links($args);

    $next_link = get_previous_posts_link($args['next_text']);
    $prev_link = get_next_posts_link($args['prev_text']);

    $template = apply_filters('the_one_page_express_pagination_navigation_markup_template', '
    <div class="navigation %1$s" role="navigation">
        <h2 class="screen-reader-text">%2$s</h2>
        <div class="nav-links"><div class="prev-navigation">%5$s</div><div class="numbers-navigation">%4$s</div><div class="next-navigation">%3$s</div></div>
    </div>', $args, $class);

    echo sprintf($template, $class, $args['screen_reader_text'], $prev_link, $links, $next_link);
}

add_action('wp_head', function () {
    $margin            = get_theme_mod('one_page_express_blog_header_margin', '200px');
    $showBlogSeparator = get_theme_mod('one_page_express_blog_header_overlap', true);

    if(function_exists('one_page_express_is_woocommerce') && one_page_express_is_woocommerce()){
        return;
    }

    if (intval($showBlogSeparator)): ?>
        <style data-name="overlap">
            @media only screen and (min-width: 768px) {
                .blog .content,
                .archive .content,
                .single-post .content {
                    position: relative;
                    z-index: 10;
                }

                .blog .content > .gridContainer > .row,
                .archive .content > .gridContainer > .row,
                .single-post .content > .gridContainer > .row {
                    margin-top: -<?php echo  $margin; ?>;
                    background: transparent !important;
                }

                .blog .header,
                .archive .header,
                .single-post .header {
                    padding-bottom: <?php echo  $margin; ?>;
                }
            }
        </style>
        <?php
    endif;
});

add_action('wp_head', function () {
    $textalign = get_theme_mod('one_page_express_header_text_align', 'center');

    $margins = array(
        'top'    => "auto",
        'bottom' => "auto",
        'right'  => "auto",
        'left'   => "auto",
    );

    if (isset($margins[$textalign])) {
        $margins[$textalign] = 0;
    }

    $marginText = "{$margins["top"]} {$margins["right"]}  {$margins["bottom"]}  {$margins["left"]}";

    ?>
    <style>
        @media only screen and (min-width: 768px) {
            .align-container {
                margin: <?php echo $marginText; ?>
            }
        }
    </style>
    <?php

});

if ( ! function_exists('ope_is_front_page')) {
    function ope_is_front_page()
    {
        $is_front_page = (is_front_page() && ! is_home());

        return $is_front_page;
    }
}

if ( ! function_exists('ope_is_inner_page')) {
    function ope_is_inner_page()
    {
        global $post;

        return ($post->post_type === "page" && ! ope_is_front_page());
    }
}


if ( ! function_exists('ope_post_type_is')) {
    function ope_post_type_is($type)
    {
        global $wp_query;

        $post_type = $wp_query->query_vars['post_type'] ? $wp_query->query_vars['post_type'] : 'post';

        if ( ! is_array($type)) {
            $type = array($type);
        }

        return in_array($post_type, $type);
    }
}


//More colors in pro

Kirki::add_field('one_page_express', array(
    'type'     => 'ope-info-pro',
    'label'    => __('Customize all theme colors in PRO. @BTN@', 'one-page-express'),
    'section'  => 'colors',
    'settings' => "one_page_express_customize_colors_buttons_pro",
));




function one_page_express_kirki_configuration( $config ) {
    $config['url_path']     = get_template_directory_uri() . '/customizer/kirki/';
    return $config;
}
add_filter( 'kirki/config', 'one_page_express_kirki_configuration', 10 );