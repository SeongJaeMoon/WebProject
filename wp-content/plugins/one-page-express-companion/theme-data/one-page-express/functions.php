<?php


add_filter('show_inactive_plugin_infos', "__return_false");

function one_page_express_get_post_thumbnail()
{
    // $thumbnail = get_the_post_thumbnail();
    ob_start();
    the_post_thumbnail('post-thumbnail', array('class' => 'blog-postimg'));
    $thumbnail = trim(ob_get_clean());

    if (empty($thumbnail)) {
        if (is_customize_preview() || 1) {
            return "<img src='https://placeholdit.imgix.net/~text?txtsize=38&bg=FF7F66&txtclr=FFFFFFe&w=400&h=250' class='blog-postimg'/>";
        } else {
            return $thumbnail;
        }
    }

    return $thumbnail;
}

function one_page_express_latest_news_excerpt_length()
{
    return 30;
}

function one_page_express_latest_excerpt_more()
{
    return "[&hellip;]";
}

function one_page_express_latest_news()
{
    ob_start(); ?>
    <?php
    $recentPosts = new WP_Query();
    $cols        = intval(\OnePageExpress\Companion::getThemeMod('one_page_express_latest_news_columns', 4));

    $post_numbers = 12 / $cols;

    add_filter('excerpt_length', 'one_page_express_latest_news_excerpt_length');
    add_filter('excerpt_more', 'one_page_express_latest_excerpt_more');
    $recentPosts->query('showposts=' . $post_numbers . ';post_status=publish;post_status=publish;post_type=post');
    while ($recentPosts->have_posts()):
        $recentPosts->the_post(); ?>
        <div id="post-<?php the_ID(); ?>" class="blog-postcol cp<?php echo $cols; ?>cols">
            <div class="post-content">
                <?php if (has_post_thumbnail()): ?>
                    <a class="post-list-item-thumb" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(); ?>
                    </a>
                <?php endif; ?>
                <div class="row_345">
                    <h3 class="blog-title">
                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <?php the_excerpt(); ?>
                    <a class="button blue small" href="<?php echo get_permalink(); ?>">
                        <span data-theme="one_page_express_latest_news_read_more"><?php \OnePageExpress\Companion::echoMod('one_page_express_latest_news_read_more', 'Read more'); ?></span>
                    </a>
                    <?php get_template_part('template-parts/content-post-footer'); ?>
                </div>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();

    remove_filter('excerpt_length', 'one_page_express_latest_news_excerpt_length');
    remove_filter('excerpt_more', 'one_page_express_latest_excerpt_more');
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function one_page_express_news_static()
{
    return one_page_express_latest_news();
}

add_shortcode('one_page_express_latest_news', 'one_page_express_latest_news');

function one_page_express_blog_link()
{
    if ('page' == get_option('show_on_front')) {
        if (get_option('page_for_posts')) {
            return esc_url(get_permalink(get_option('page_for_posts')));
        } else {
            return esc_url(home_url('/?post_type=post'));
        }
    } else {
        return esc_url(home_url('/'));
    }
}

add_shortcode('one_page_express_blog_link', 'one_page_express_blog_link');

function one_page_express_contact_form($attrs = array())
{
    $atts = shortcode_atts(
        array(
            'shortcode' => "",
        ),
        $attrs
    );
    // compatibility with free //
    $contact_shortcode = get_theme_mod('one_page_express_contact_form_shortcode', '');
    if ($atts['shortcode']) {
        $contact_shortcode = "[" . html_entity_decode(html_entity_decode($atts['shortcode'])) . "]";
    }
    ob_start();
    if ($contact_shortcode !== "") {
        echo do_shortcode($contact_shortcode);
    } else {
        echo '<p style="text-align:center;color:#ababab">' . __('Contact form will be displayed here. To activate it you have to click this area and set the shortcode parameter in Customizer.',
                'one_page_express-companion') . '</p>';
    }

    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode('one_page_express_contact_form', 'one_page_express_contact_form');

add_filter('cloudpress\template\page_content',
    function ($content) {
        $content = str_replace('[one_page_express_latest_news]', one_page_express_latest_news(), $content);
        $content = str_replace('[one_page_express_contact_form]', one_page_express_contact_form(), $content);
        $content = str_replace('[one_page_express_blog_link]', one_page_express_blog_link(), $content);
        $content = str_replace('[tag_companion_uri]', \OnePageExpress\Companion::instance()->themeDataURL(), $content);

        return $content;
    });


add_filter('cloudpress\companion\cp_data',
    function ($data, $companion) {

        $sectionsJSON             = $companion->themeDataPath("/sections/sections.json");
        $contentSections          = json_decode(file_get_contents($sectionsJSON), true);
        $data['data']['sections'] = $contentSections;

        $showPro = apply_filters('ope_show_info_pro_messages', true);

        if ($showPro) {
            $proSectionsJSON = $companion->themeDataPath("/sections/pro-only-sections.json");
            if (file_exists($proSectionsJSON)) {
                $proSections              = json_decode(file_get_contents($proSectionsJSON), true);
                $data['data']['sections'] = array_merge($contentSections, $proSections);
            }
        }

        return $data;
    }, 10, 2);

add_action('cloudpress\template\load_assets',
    function ($companion) {
        $ver = $companion->version;
        wp_enqueue_style($companion->getThemeSlug() . '-common-css', $companion->themeDataURL('/templates/css/common.css'), array($companion->getThemeSlug() . '-style'), $ver);
        wp_enqueue_style('companion-page-css', $companion->themeDataURL('/sections/content.css'), array(), $ver);
        wp_enqueue_style('companion-cotent-swap-css', $companion->themeDataURL('/templates/css/HoverFX.css'), array(), $ver);

        wp_enqueue_script('companion-lib-hammer', $companion->themeDataURL('/templates/js/libs/hammer.js'), array(), $ver);
        wp_enqueue_script('companion-lib-modernizr', $companion->themeDataURL('/templates/js/libs/modernizr.js'), array(), $ver);
        wp_register_script('companion-' . $companion->getThemeSlug(), null, array('jquery', 'companion-lib-hammer', 'companion-lib-modernizr'), $ver);

        if ( ! is_customize_preview()) {
            wp_enqueue_script('companion-cotent-swap', $companion->themeDataURL('/templates/js/HoverFX.js'), array('companion-' . $companion->getThemeSlug()), $ver);
        }
        wp_enqueue_script('companion-scripts', $companion->themeDataURL('/sections/scripts.js'), array('companion-' . $companion->getThemeSlug()), $ver);
    });

add_action('cloudpress\customizer\preview_scripts',
    function ($customizer) {
        $ver = $customizer->companion()->version;
        wp_enqueue_script(
            $customizer->companion()->getThemeSlug() . "_preview-handle", $customizer->companion()->themeDataURL() . "/preview-handles.js", array('cp-customizer-preview'), $ver
        );
    });


add_action('cloudpress\customizer\global_scripts',
    function ($customizer) {
        $ver = $customizer->companion()->version;
        wp_enqueue_script(
            $customizer->companion()->getThemeSlug() . "_companion_theme_customizer",
            $customizer->companion()->themeDataURL() . "/customizer.js",
            array('cp-customizer-base'),
            $ver,
            true
        );
    });

function one_page_header_css()
{
    $headerContentCSS = \OnePageExpress\Companion::getThemeMod(
        'onepage_builder_header_content_css', array()
    );

    $headerContentCSS = array_merge(array(
        'title-margin-top'       => 'inherit',
        'title-margin-bottom'    => 'inherit',
        'title-text-align'       => 'right',
        'subtitle-margin-top'    => 'inherit',
        'subtitle-margin-bottom' => 'inherit',
        'subtitle-text-align'    => 'right',
        'buttons-position'       => "right",
    ), $headerContentCSS);

    $mappedSettings  = array();
    $buttonsAlignCss = array();
    switch ($headerContentCSS['buttons-position']) {
        case "left":
            $buttonsAlignCss = array(
                "text-align:left",
            );
            break;
        case "center":
            $buttonsAlignCss = array(
                "text-align:center",
            );
            break;
        case "right":
            $buttonsAlignCss = array(
                "text-align:right",
            );
            break;
    }

    foreach ($headerContentCSS as $key => $value) {
        $contentEL = "";
        if (strpos($key, "title-") === 0) {
            $key       = str_replace('title-', '', $key);
            $contentEL = "title";
        } else {
            $key       = str_replace('subtitle-', '', $key);
            $contentEL = "subtitle";
        }

        if ( ! isset($mappedSettings[$contentEL])) {
            $mappedSettings[$contentEL] = array();
        }

        $mappedSettings[$contentEL][$key] = $value;
    } ?>
    <style>
        .header-description-right {
        <?php echo implode(";", $buttonsAlignCss); ?>
        }

        .header-description-right h1 {
            margin-top: <?php echo one_page_builder_get_css_value($mappedSettings['title']['margin-top'], "em"); ?>;
            margin-bottom: <?php echo one_page_builder_get_css_value($mappedSettings['title']['margin-bottom'], "em"); ?>;
            text-align: <?php echo $mappedSettings['title']['text-align']; ?>;
            margin-left: <?php echo $mappedSettings['title']['text-align'] === "right" ? "5%" : "0%"; ?>;
            margin-right: <?php echo $mappedSettings['title']['text-align'] === "left" ? "5%" : "0%"; ?>
        }

        .header-description-right .header-subtitle {
            margin-top: <?php echo one_page_builder_get_css_value($mappedSettings['subtitle']['margin-top'], "em"); ?>;
            margin-bottom: <?php echo one_page_builder_get_css_value($mappedSettings['subtitle']['margin-bottom'], "em"); ?>;
            text-align: <?php echo $mappedSettings['subtitle']['text-align']; ?>;
            margin-left: <?php echo $mappedSettings['subtitle']['text-align'] === "right" ? "5%" : "0%"; ?>;
            margin-right: <?php echo $mappedSettings['subtitle']['text-align'] === "left" ? "5%" : "0%"; ?>
        }
    </style>
    <?php

}

function one_page_builder_get_css_value($value, $unit = false)
{
    $noUnitValues = array('inherit', 'auto', 'initial');
    if ( ! in_array($value, $noUnitValues)) {
        return $value . $unit;
    }

    return $value;
}

function one_page_inner_header_css()
{
    $headerContentCSS = \OnePageExpress\Companion::getThemeMod(
        'onepage_builder_inner_header_content_css', array()
    );

    $headerContentCSS = array_merge(array(
        'title-margin-top'       => 'inherit',
        'title-margin-bottom'    => 'inherit',
        'title-text-align'       => 'right',
        'subtitle-margin-top'    => 'inherit',
        'subtitle-margin-bottom' => 'inherit',
        'subtitle-text-align'    => 'right',
        'buttons-position'       => "right",
    ), $headerContentCSS);

    $mappedSettings = array();

    $contentAlignCss = array();

    switch ($headerContentCSS['buttons-position']) {
        case "left":
            $contentAlignCss = array(
                "text-align:left",
                "margin-left:0px",
                "float:none",
                "width:50%",
            );
            break;
        case "center":
            $contentAlignCss = array(
                "text-align:center",
                "margin-left:auto",
                "margin-right:auto",
                "float:none",
                "width:80%",
            );
            break;
        case "right":
            $contentAlignCss = array(
                "text-align:right",
                "margin-left:50%",
                "margin-right:auto",
                "float:none",
                "width:50%",
            );
            break;
    }

    foreach ($headerContentCSS as $key => $value) {
        $contentEL = "";
        if (strpos($key, "title-") === 0) {
            $key       = str_replace('title-', '', $key);
            $contentEL = "title";
        } else {
            $key       = str_replace('subtitle-', '', $key);
            $contentEL = "subtitle";
        }

        if ( ! isset($mappedSettings[$contentEL])) {
            $mappedSettings[$contentEL] = array();
        }

        $mappedSettings[$contentEL][$key] = $value;
    } ?>
    <style>
        @media only screen and (min-width: 768px) {
            .header-description-right h1 {
                margin-top: <?php echo one_page_builder_get_css_value($mappedSettings['title']['margin-top'], "em"); ?>;
                margin-bottom: <?php echo one_page_builder_get_css_value($mappedSettings['title']['margin-bottom'], "em"); ?>;
                text-align: <?php echo $mappedSettings['title']['text-align']; ?>;
            }

            .header-description-right .header-subtitle {
                margin-top: <?php echo one_page_builder_get_css_value($mappedSettings['subtitle']['margin-top'], "em"); ?>;
                margin-bottom: <?php echo one_page_builder_get_css_value($mappedSettings['subtitle']['margin-bottom'], "em"); ?>;
                text-align: <?php echo $mappedSettings['subtitle']['text-align']; ?>;
            }

            .header-description-right {
            <?php echo implode(";", $contentAlignCss); ?>
            }
        }
    </style>
    <?php

}

add_action('cloudpress\companion\activated\one-page-express', function ($companion) {
    $companion->__createFrontPage();
});

add_action('cloudpress\companion\deactivated\one-page-express', function ($companion) {
    $companion->restoreFrontPage();
});

function one_page_express_get_front_page_content($companion)
{
    $defaultSections = array("stripped-coloured-icon-boxes", "about-big-images-section", "content-image-left", "content-image-right", "portfolio-full-section", "testimonials-boxed-section", "cta-blue-section", "team-colors-section", "numbers-section", "blog-section", "contact-section");

    $alreadyColoredSections = array("numbers-section", "contact-section", "cta-blue-section");

    $availableSections = $companion->loadJSON($companion->themeDataPath("/sections/sections.json"));

    $content = "";

    $colors     = array('#ffffff', '#f6f6f6');
    $colorIndex = 0;

    foreach ($defaultSections as $ds) {
        foreach ($availableSections as $as) {
            if ($as['id'] == $ds) {
                $_content = $as['content'];

                if (strpos($_content, 'data-bg="transparent"') === false && ! in_array($ds, $alreadyColoredSections)) {
                    $_content   = preg_replace('/\<div/', '<div style="background-color:' . $colors[$colorIndex] . '" ', $_content, 1);
                    $colorIndex = $colorIndex ? 0 : 1;
                } else {
                    $colorIndex = 0;
                }

                $_content = preg_replace('/\<div/', '<div id="' . $as['elementId'] . '" ', $_content, 1);

                $content .= $_content;
                break;
            }
        }
    }

    return $content;
}

add_filter('cloudpress\companion\front_page_content',
    function ($content, $companion) {
        $content = one_page_express_get_front_page_content($companion);

        return \OnePageExpress\Companion::filterDefault($content);
    }, 10, 2);

add_filter('cloudpress\companion\template',
    function ($template, $companion, $post) {

        if ( ! $post) {
            return $template;
        }

        if ($companion->isActiveThemeSupported()) {
            if ($companion->isFrontPage($post->ID)) {
                if (strpos($template, "front-page.php") !== false) {
                    return $template;
                } else {
                    $template = $companion->themeDataPath("/templates/home-page.php");
                    add_filter('body_class', 'one_page_express_homepage_class');
                }
            } else {
                if ($companion->isMaintainable($post->ID)) {
                    add_filter('body_class', 'one_page_express_maintaibale_class');
                }
            }

        }

        return $template;
    }, 10, 3);


function one_page_express_homepage_class($classes)
{

    $classes[] = "homepage-template";

    foreach ($classes as $index => $class) {
        switch ($class) {
            case "page-template-default":
            case "page":
                unset($classes[$index]);
                break;
        }

    }

    return $classes;
}

function one_page_express_maintaibale_class($classes)
{

    $classes[] = "ope-maintainable";

    return $classes;
}

add_filter('cloudpress\customizer\control\content_sections\data',
    function ($data) {
        $categories = array(
            'overlapable',
            'about',
            'features',
            'content',
            'cta',
            'protfolio',
            'testimonials',
            'numbers',
            'clients',
            'team',
            'latest_news',
            'contact',
        );

        $result = array();

        foreach ($categories as $cat) {
            if (isset($data[$cat])) {
                $result[$cat] = $data[$cat];
                unset($data[$cat]);
            }
        }

        $result = array_merge($result, $data);

        return $result;
    });

add_filter('cloudpress\customizer\control\content_sections\category_label',
    function ($label, $category) {

        switch ($category) {
            case 'latest_news':
                $label = __("Latest News", 'cloudpress_companion');
                break;

            case 'cta':
                $label = __("Call to action", 'cloudpress_companion');
                break;

            default:
                $label = __($label, 'cloudpress_companion');
                break;
        }

        return $label;
    }, 10, 2);

add_action('wp_head', function () {
    $margin      = get_theme_mod('one_page_express_front_page_header_margin', '230px');
    $overlap_mod = get_theme_mod('one_page_express_front_page_header_overlap', true);
    if (1 == intval($overlap_mod)): ?>
        <style data-name="overlap">
            @media only screen and (min-width: 768px) {
                .header-homepage {
                    padding-bottom: <?php echo  $margin; ?>;
                }

                .homepage-template .content {
                    position: relative;
                    z-index: 10;
                }

                .homepage-template .page-content div[data-overlap]:first-of-type > div:first-of-type {
                    margin-top: -<?php echo  $margin; ?>;
                    background: transparent !important;
                }
            }
        </style>
        <?php
    endif;
});


add_action('edit_form_after_title', 'one_page_express_add_maintainable_filter');

function one_page_express_add_maintainable_filter($post)
{
    $companion    = \OnePageExpress\Companion::instance();
    $maintainable = $companion->isMaintainable($post->ID);

    add_editor_style(get_template_directory_uri() . "/style.css");
    add_editor_style(get_stylesheet_uri());

    add_editor_style($companion->themeDataURL('/templates/css/common.css'));
    add_editor_style($companion->themeDataURL('/sections/content.css'));
    add_editor_style($companion->themeDataURL('/templates/css/HoverFX.css'));
    add_editor_style(get_template_directory_uri() . '/assets/font-awesome/font-awesome.min.css');


    if ($maintainable) {
        add_filter('tiny_mce_before_init', 'one_page_express_maintainable_pages_tinymce_init');
    }
}


function one_page_express_maintainable_pages_tinymce_init($init)
{
    $init['verify_html'] = false;

    // convert newline characters to BR
    $init['convert_newlines_to_brs'] = true;

    // don't remove redundant BR
    $init['remove_redundant_brs'] = false;


    $opts                            = '*[*]';
    $init['valid_elements']          = $opts;
    $init['extended_valid_elements'] = $opts;
    $init['forced_root_block']       = false;
    $init['paste_as_text']           = true;

    return $init;
}


function one_page_express_remove_page_attribute_support($post)
{
    $companion = \OnePageExpress\Companion::instance();
    if ($post && $companion->isFrontPage($post->ID)) {
        remove_meta_box('pageparentdiv', 'page', 'side');

    }
}

add_action('edit_form_after_editor', 'one_page_express_remove_page_attribute_support');


add_filter('one_page_express_header_presets', 'one_page_express_header_presets_pro_info');

function one_page_express_header_presets_pro_info($presets)
{


    if (apply_filters('ope_show_info_pro_messages', true)) {
        $companion = \OnePageExpress\Companion::instance();

        $proPresets = $companion->themeDataPath("/pro-only-presets.php");
        if (file_exists($proPresets)) {
            $proPresets = require_once($proPresets);
        } else {
            $proPresets = array();
        }

        $presets = array_merge($presets, $proPresets);

    }

    return $presets;
}



// discount notice

function one_page_express_discount_end_date() {
    return "2017-12-02";
}

function one_page_express_discount_link(){
    return esc_url("https://extendthemes.com/go/one-page-express-upgrade#pricing");
}

function one_page_express_discount_notice_script()
{
    ?>
    <script type="text/javascript" >
        (function ($) {
            jQuery(document).on( 'click', '.ope-discount-notice .notice-dismiss', function() {
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'one_page_express_discount_notice_dismiss'
                    }
                });
            })
        })(jQuery);
    </script>
    <?php
}

add_action("wp_ajax_one_page_express_discount_notice_dismiss", function() {
    update_option( 'one-page-express-'.one_page_express_discount_end_date().'-notice-dismissed', 1);
});

function one_page_express_discount_notice() {
    if (get_option( 'one-page-express-'.one_page_express_discount_end_date().'-notice-dismissed', 0)) {
        return;
    }
    ?>
    <div class="ope-discount-notice notice notice-info is-dismissible" style="background-color: #fdffb3">
        <p style="font-size: 20px;">
            Black Friday Special Offer - <span style="color:red">40% discount</span> for One Page Express PRO
           
            <a class="button button-primary" style="margin-left:10px;float: right;" target="_blank" href="http://onepageexpress.com/#features-6">See PRO Features</a>
            <a class="button" style="background-color: red;border-color: #d65600;color: #ffffff;float: right;" target="_blank" href="<?php echo one_page_express_discount_link(); ?>">Get the offer</a> 
        </p>
    </div>
    <?php
}

    
    
add_action("admin_init", function() {
    $show = apply_filters('ope_show_info_pro_messages', true);
    if ($show && new DateTime() < new DateTime(one_page_express_discount_end_date())) {
        add_action( 'admin_notices', 'one_page_express_discount_notice' );
        add_action( 'admin_footer', 'one_page_express_discount_notice_script' );


        add_action('cloudpress\customizer\global_scripts',
        function ($customizer) {
            $ver = $customizer->companion()->version;
            wp_localize_script($customizer->companion()->getThemeSlug() . "_companion_theme_customizer", "ope_discount", array(
                "buylink" => one_page_express_discount_link(),
                "msg" => "Get PRO - 40% Black Friday Discount"
            ));
        });
    }
});
