<?php

namespace OnePageExpress;

class Companion
{

    private static $instance = null;
    private static $functionsFiles = array();

    private $_customizer = null;

    private $cpData = array();
    private $remoteDataURL = null;

    private $theme = null;
    public $themeName = null;
    private $themeSlug = null;
    public $version = null;
    private $path = null;

    private $getCustomizerDataCache = array();

    public function __construct($root = null)
    {
        $this->theme     = wp_get_theme();
        $this->themeSlug = $this->theme->get('TextDomain');
        $this->themeName = $this->theme->get('Name');

        // current theme is a child theme
        if ($this->theme->get('Template')) {
            $this->themeSlug = $this->theme->get('Template');
        }

        $this->path = $root;

        if ( ! $this->isActiveThemeSupported()) {
            return;
        }

        if (file_exists($this->themeDataPath("/functions.php"))) {
            require_once $this->themeDataPath("/functions.php");
        }

        if ( ! self::$instance) {
            self::$instance = $this;
            add_action('init', array($this, 'initCompanion'));
            $this->registerActivationHooks();
        } else {
            add_filter('cloudpress\companion\cp_data', array($this, 'getInstanceData'));
        }
        $this->version = $this->getCustomizerData('version');
    }

    public function registerActivationHooks()
    {
        $self = $this;

        register_activation_hook($this->path, function () use ($self) {
            do_action('cloudpress\companion\activated\\' . $self->getThemeSlug(), $self);
        });

        register_deactivation_hook($this->path, function () use ($self) {
            do_action('cloudpress\companion\deactivated\\' . $self->getThemeSlug(), $self);
        });
    }

    public function initCompanion()
    {
        // array($this,'checkIfCompatibleChildTheme'));
        $this->checkIfCompatibleChildTheme();
        $this->checkNotifications();

        $this->_customizer = new \OnePageExpress\Customizer\Customizer($this);
        \OnePageExpress\Customizer\Template::load($this);
        \OnePageExpress\Customizer\ThemeSupport::load();

        add_action('wp_ajax_create_home_page', array($this, 'createFrontPage'));

        add_action('wp_ajax_cp_open_in_customizer', array($this, 'openPageInCustomizer'));
        add_action('wp_ajax_cp_shortcode_refresh', array($this, 'shortcodeRefresh'));

        add_filter('page_row_actions', array($this, 'addEditInCustomizer'), 0, 2);

        add_action('admin_footer', array($this, 'addAdminScripts'));

        add_action('media_buttons', array($this, 'addEditInCustomizerPageButtons'));

        add_filter('is_protected_meta', array($this, 'isProtectedMeta'), 10, 3);

        // loadKirkiCss Output Components;
        $this->setKirkiOutputFields();

        // look for google fonts
        $this->addGoogleFonts();

        do_action('cloudpress\companion\ready', $this);

    }


    public function checkNotifications()
    {
        $notifications = $this->themeDataPath("/notifications.php");
        if (file_exists($notifications)) {
            $notifications = require_once $notifications;
        } else {
            $notifications = array();
        }

        \OnePageExpress\Notify\NotificationsManager::load($notifications);
    }


    public function checkIfCompatibleChildTheme()
    {
        $theme = wp_get_theme();

        if ($theme && $theme->get('Template')) {
            $template = $theme->get('Template');

            if (in_array($template, $this->getCustomizerData('themes'))) {
                add_filter('cloudpress\customizer\supports', "__return_true");
            }

        }

    }

    public function setKirkiOutputFields()
    {
        global $wp_customize;

        if ( ! class_exists("\Kirki")) {
            return;
        }

        // is managed in customizer;
        if ($wp_customize) {
            return;
        }

        $settings = (array)$this->getCustomizerData("customizer:settings");

        foreach ($settings as $id => $data) {
            $controlClass = self::getTreeValueAt($data, "control:class", "");
            if (strpos($controlClass, "kirki:") === 0 && self::getTreeValueAt($data, "control:wp_data:output")) {
                $configArgs = self::getTreeValueAt($data, "wp_data", array());
                \Kirki::add_config($id, $configArgs);

                $fieldArgs             = self::getTreeValueAt($data, "control:wp_data", array());
                $fieldArgs['type']     = str_replace("kirki:", "", $controlClass);
                $fieldArgs['settings'] = $id;
                $fieldArgs['section']  = self::getTreeValueAt($data, "section");

                if ( ! isset($fieldArgs['default'])) {
                    $fieldArgs['default'] = self::getTreeValueAt($data, "wp_data:default", array());
                }

                \Kirki::add_field($id, $fieldArgs);
            }
        }
    }

    public function loadJSON($path)
    {

        if ( ! file_exists($path)) {
            return array();
        }

        $content = file_get_contents($path);

        return json_decode($content, true);
    }

    public function requireCPData($filter = true)
    {
        $cpData = get_theme_mod('theme_options', null);
        if ( ! $cpData) {
            $site = site_url();
            $site = preg_replace("/http(s)?:\/\//", "", $site);
            $key  = get_theme_mod('theme_pro_key', 'none');

            $cpData = $this->loadJSON($this->themeDataPath("/data.json"));

            if ( ! $cpData) {
                if ($this->remoteDataURL) {
                    require_once ABSPATH . WPINC . "/pluggable.php";

                    $url = $this->remoteDataURL . "/" . $this->themeSlug;

                    // allow remote url
                    add_filter('http_request_args', function ($r, $_url) use ($url) {
                        if ($url === $_url) {
                            $r['reject_unsafe_urls'] = false;
                        }

                        return $r;
                    }, 10, 2);

                    $data = wp_safe_remote_get(
                        $url,
                        array(
                            'method'      => 'GET',
                            'timeout'     => 45,
                            'redirection' => 5,
                            'blocking'    => true,
                            'httpversion' => '1.0',
                            'body'        => array(
                                'site' => $site,
                                'key'  => $key,
                            ),
                        )
                    );
                    if ($data instanceof \WP_Error) {
                        //TODO: Add a nicer message here
                        ob_get_clean();
                        wp_die('There was an issue connecting to the theme server. Please contact the theme support!');
                    } else {
                        //TODO: Load remote data
                        // $cpData = {};
                        // set_theme_mod('theme_options',$this->cpData);
                    }
                }
            }
        }

        if ($filter) {
            $cpData = apply_filters("cloudpress\companion\cp_data", $cpData, $this);
        }

        $this->cpData = $cpData;

        return $cpData;
    }

    public function getInstanceData()
    {
        return $this->requireCPData(false);
    }

    public function getCustomizerData($key = null, $filter = true)
    {
        if (isset($this->getCustomizerDataCache[$key])) {
            return $this->getCustomizerDataCache[$key];
        }

        if ( ! is_array($this->cpData)) {
            return array();
        }

        $this->requireCPData($filter);

        if ($key === null) {
            return $this->cpData;
        }

        $result = self::getTreeValueAt($this->cpData, $key);

        $this->getCustomizerDataCache[$key] = $result;

        return $result;
    }

    public function isActiveThemeSupported()
    {
        $supportedThemes = (array)$this->getCustomizerData('themes', false);
        $currentTheme    = $this->themeSlug;

        $supported = (in_array($currentTheme, $supportedThemes) || in_array('*', $supportedThemes));

        return $supported;
    }

    public function isMaintainable($post_id = false)
    {

        if ( ! $post_id) {
            global $post;
            $post_id = ($post && property_exists($post, "ID")) ? $post->ID : false;
        }

        if ( ! $post_id) {
            return false;
        }

        $result = (
            ('1' === get_post_meta($post_id, 'is_' . $this->themeSlug . '_front_page', true))
            || ('1' === get_post_meta($post_id, 'is_' . $this->themeSlug . '_maintainable_page', true))
        );

        $result = $result || $this->applyOnPrimaryLanguage($post_id, array($this, 'isMaintainable'));

        return $result;
    }

    public function isProtectedMeta($protected, $meta_key, $meta_type)
    {
        $is_protected = array(
            'is_' . $this->themeSlug . '_front_page',
            'is_' . $this->themeSlug . '_maintainable_page',
        );
        if (in_array($meta_key, $is_protected)) {
            return true;
        }

        return $protected;
    }

    public function isMultipage()
    {
        return $this->getCustomizerData('theme_type') === "multipage";
    }

    public function getCurrentPageId()
    {
        global $post;
        $post_id = ($post && property_exists($post, "ID")) ? $post->ID : false;

        if ( ! $post_id) {
            return false;
        }

        if ($post->post_type !== "page") {
            return false;
        }

        return $post_id;
    }

    private function applyOnPrimaryLanguage($post_id, $callback)
    {
        $result = false;
        global $post;

        if (function_exists('pll_get_post') && function_exists('pll_default_language')) {
            $slug      = pll_default_language('slug');
            $defaultID = pll_get_post($post_id, $slug);
            $sourceID  = isset($_REQUEST['from_post']) ? $_REQUEST['from_post'] : null;
            $defaultID = $defaultID ? $defaultID : $sourceID;

            if ($defaultID && ($defaultID !== $post_id)) {
                $result = call_user_func($callback, $defaultID);
            }
        }
        global $sitepress;
        if ($sitepress) {
            $defaultLanguage = $sitepress->get_default_language();
            global $wpdb;

            $sourceTRID = isset($_REQUEST['trid']) ? $_REQUEST['trid'] : null;
            $trid       = $sitepress->get_element_trid($post_id);
            $trid       = $trid ? $trid : $sourceTRID;
            $defaultID  = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid=%d AND language_code=%s",
                    $trid,
                    $defaultLanguage));


            if ($defaultID && ($defaultID !== $post_id)) {
                $result = call_user_func($callback, $defaultID);
            }
        }

        return $result;
    }

    public function isFrontPage($post_id = false)
    {

        if ( ! $post_id) {
            global $post;
            $post_id = ($post && property_exists($post, "ID")) ? $post->ID : false;
        }

        if ( ! $post_id) {
            return false;
        }

        $isFrontPage = '1' === get_post_meta($post_id, 'is_' . $this->themeSlug . '_front_page', true);

        $isWPFrontPage = is_front_page() && ! is_home();

        if ($isWPFrontPage && ! $isFrontPage && $this->isMaintainable($post_id)) {
            update_post_meta($post_id, 'is_' . $this->themeSlug . '_front_page', '1');
            delete_post_meta($post_id, 'is_' . $this->themeSlug . '_maintainable_page');
            $isFrontPage = true;
        }

        $isFrontPage = $isFrontPage || $this->applyOnPrimaryLanguage($post_id, array($this, 'isFrontPage'));

        return $isFrontPage;
    }

    public function getFrontPage()
    {
        $query = new \WP_Query(
            array(
                "post_status" => "publish",
                "post_type"   => 'page',
                "meta_key"    => 'is_' . $this->themeSlug . '_front_page',
            )
        );
        if (count($query->posts)) {
            return $query->posts[0];
        }

        return null;
    }

    public function loadMaintainablePageAssets($post, $template)
    {
        do_action('cloudpress\template\load_assets', $this, $post, $template);
    }

    public function rootPath()
    {
        return dirname($this->path);
    }

    public function rootURL()
    {
        $templateDir = wp_normalize_path(get_stylesheet_directory());
        $pluginDir   = wp_normalize_path(plugin_dir_path($this->path));
        $path        = wp_normalize_path($this->path);
        $url         = site_url();
        if (strpos($path, $templateDir) === 0) {
            $path = dirname($path);
            $abs  = wp_normalize_path(ABSPATH);
            $path = str_replace($abs, '/', $path);
            $url  = get_stylesheet_directory_uri() . $path;
        } else {
            $url = plugin_dir_url($this->path);
        }

        return untrailingslashit($url);
    }

    public function themeDataPath($rel = "")
    {
        return $this->rootPath() . "/theme-data/" . $this->themeSlug . $rel;
    }

    public function themeDataURL($rel = "")
    {
        return $this->rootURL() . "/theme-data/" . $this->themeSlug . $rel;
    }

    public function assetsRootURL()
    {
        return $this->rootURL() . "/assets";
    }

    public function assetsRootPath()
    {
        return $this->rootPath() . "/assets";
    }

    public function customizer()
    {
        return $this->_customizer;
    }

    public function getThemeSlug($as_fn_prefix = false)
    {
        $slug = $this->themeSlug;

        if ($as_fn_prefix) {
            $slug = str_replace("-", "_", $slug);
        }

        return $slug;
    }

    public function __createFrontPage()
    {
        $page = $this->getFrontPage();

        update_option($this->themeSlug . '_companion_old_show_on_front', get_option('show_on_front'));
        update_option($this->themeSlug . '_companion_old_page_on_front', get_option('page_on_front'));

        if ( ! $page) {
            $content = apply_filters('cloudpress\companion\front_page_content', "", $this);

            $post_id = wp_insert_post(
                array(
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                    'post_name'      => $this->themeName,
                    'post_title'     => 'Front Page',
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                    'page_template'  => 'page.php',
                    'post_content'   => $content,
                )
            );

            set_theme_mod($this->themeSlug . '_page_content', $content);
            update_option('show_on_front', 'page');
            update_option('page_on_front', $post_id);
            update_post_meta($post_id, 'is_' . $this->themeSlug . '_front_page', "1");

            if (null == get_page_by_title('Blog')) {
                $post_id = wp_insert_post(
                    array(
                        'comment_status' => 'closed',
                        'ping_status'    => 'closed',
                        'post_name'      => 'blog',
                        'post_title'     => 'Blog',
                        'post_status'    => 'publish',
                        'post_type'      => 'page',
                    )
                );
            }

            $blog = get_page_by_title('Blog');
            update_option('page_for_posts', $blog->ID);
        } else {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $page->ID);
            update_post_meta($page->ID, 'is_' . $this->themeSlug . '_front_page', "1");
        }
    }

    public function createFrontPage()
    {
        $nonce = @$_POST['create_home_page_nounce'];
        if ( ! wp_verify_nonce($nonce, 'create_home_page_nounce')) {
            die();
        }

        $this->__createFrontPage();
    }

    public function restoreFrontPage()
    {
        if ($this->getFrontPage()) {
            update_option('show_on_front', get_option($this->themeSlug . '_companion_old_show_on_front'));
            update_option('page_on_front', get_option($this->themeSlug . '_companion_old_page_on_front'));
        }
    }

    public function addEditInCustomizer($actions, $post)
    {
        if ($this->isMultipage()) {
            $actions = array_merge(
                array(
                    "cp_page_builder" => '<a href="#" onclick="cp_open_page_in_customizer(' . $post->ID . ')" >Edit in Customizer</a>',
                ),
                $actions
            );
        }

        return $actions;
    }

    public function addEditInCustomizerPageButtons()
    {
        global $post;

        if ($post && $post->post_type === "page" && $this->isMultipage()) {
            echo '<a href="#"  onclick="cp_open_page_in_customizer(' . $post->ID . ')"  class="button button-primary">' . __('Edit In Customizer', 'cloudpress-companion') . '</a>';
        }
    }

    public function addAdminScripts()
    {
        if ($this->isMultipage()) {
            global $post;
            $title_placeholder = apply_filters('enter_title_here', __('Enter title here', 'cloudpress-companion'), $post);

            ?>
            <style>
                input[name=new-page-name-val] {
                    padding: 3px 8px;
                    font-size: 1.7em;
                    line-height: 100%;
                    height: 1.7em;
                    width: 100%;
                    outline: none;
                    margin: 0 0 3px;
                    background-color: #fff;
                    border-style: solid;
                    border-color: #c3c3c3;
                    border-width: 1px;
                    margin-bottom: 10px;
                    margin-top: 10px;
                }

                input[name=new-page-name-val].error {
                    border-color: #f39e9e;
                    border-style: solid;
                    color: #f39e9e;
                }

                h1.cp-open-in-custmizer {
                    font-size: 23px;
                    font-weight: 400;
                    margin: 0;
                    padding: 9px 0 4px 0;
                    line-height: 29px;
                }

            </style>
            <div style="display: none;" id="open_page_in_customizer_set_name">
                <h1 class="cp-open-in-custmizer"><?php _e('Set a name for the new page', 'cloudpress-companion'); ?></h1>
                <input placeholder="<?php echo $title_placeholder ?>" class="" name="new-page-name-val"/>
                <button class="button button-primary" name="new-page-name-save"> <?php _e('Set Page Name', 'cloudpress-companion'); ?></button>
            </div>
            <script>
                function cp_open_page_in_customizer(page) {

                    var isAutodraft = jQuery('[name="original_post_status"]').length ? jQuery('[name="original_post_status"]').val() === "auto-draft" : false;

                    function doAjaxCall(pageName) {
                        var data = {
                            action: 'cp_open_in_customizer',
                            page: page
                        };

                        if (pageName) {
                            data['page_name'] = pageName;
                        }

                        jQuery.post(ajaxurl, data).done(function (response) {

                            window.location = response.trim();
                        });
                    }

                    if (isAutodraft) {

                        alert("<?php echo __('Page needs to be published before editing it in customizer', 'cloudpress-companion'); ?>");
                        return;

                        var title = jQuery('[name="post_title"]').val();
                        tb_show('Set Page Name', '#TB_inline?inlineId=open_page_in_customizer_set_name&height=150', false);
                        var TB_Window = jQuery('#TB_window').height('auto');

                        var titleInput = TB_Window.find('[name="new-page-name-val"]');

                        titleInput.val(title).on('keypress', function () {
                            jQuery(this).removeClass('error');
                        });

                        TB_Window.find('[name="new-page-name-save"]').off('click').on('click', function () {
                            var newTitle = titleInput.val().trim();
                            if (newTitle.length == 0) {
                                titleInput.addClass('error');
                                return;
                            } else {
                                doAjaxCall(newTitle);
                            }
                        });

                    } else {
                        doAjaxCall();
                    }

                }
            </script>
            <?php

        }
    }

    public function openPageInCustomizer()
    {
        $post_id = intval($_REQUEST['page']);

        $post = get_post($post_id);

        if ($post) {

            if ($post->post_status === "auto-draft" || $post->post_status === "draft") {

                wp_publish_post($post_id);

                $title    = isset($_REQUEST['page_name']) ? wp_kses_post($_REQUEST['page_name']) : __('Untitled Page - ' . date("Y-m-d H:i:s"), 'cloudpress-companion');
                $new_slug = sanitize_title($title);
                wp_update_post(array(
                    'ID'         => $post_id,
                    'post_title' => $title,
                    'post_name'  => $new_slug, // do your thing here
                ));

            }

            $isMarked = get_post_meta($post_id, 'is_' . $this->themeSlug . '_maintainable_page', true);

            if ( ! intval($isMarked)) {
                update_post_meta($post_id, 'is_' . $this->themeSlug . '_maintainable_page', "1");
                $template = get_post_meta($post_id, '_wp_page_template', true);
                if ( ! $template || $template === "default") {
                    update_post_meta($post_id, '_wp_page_template', "full-width-page.php");
                }
            }

        }

        $url = $this->get_page_link($post_id);

        ?>
        <?php echo admin_url('customize.php') ?>?url=<?php echo esc_url($url) ?>
        <?php

        exit;
    }

    public function get_page_link($post_id)
    {
        global $sitepress;
        if ($sitepress) {
            $url = get_page_link($post_id);
            $args = array('element_id' => $post_id, 'element_type' => 'page' );
            $language_code = apply_filters( 'wpml_element_language_code', null, $args );
            $url = apply_filters( 'wpml_permalink', $url, $language_code );
        }

        if (!$url) {
            $url = get_page_link($post_id);
        }

        return $url;
    }

    public function shortcodeRefresh()
    {
        if ( ! is_user_logged_in() || ! current_user_can('edit_theme_options')) {
            die();
        }

        add_filter('is_shortcode_refresh', '__return_true');

        $shortcode = isset($_REQUEST['shortcode']) ? $_REQUEST['shortcode'] : false;
        $context   = isset($_REQUEST['context']) ? $_REQUEST['context'] : array();

        //TODO: apply context;
        if ( ! $shortcode) {
            die();
        }

        $shortcode = base64_decode($shortcode);

        $query = isset($context['query']) ? $context['query'] : array();

        global $wp_query;
        $wp_query = new \WP_Query($query);

        echo do_shortcode($shortcode);
        die();

    }

    public function addGoogleFonts()
    {
        $self = $this;

        /**
         * Add preconnect for Google Fonts.
         */
        add_filter('wp_resource_hints', function ($urls, $relation_type) use ($self) {
            if (wp_style_is($self->getThemeSlug() . '-fonts', 'queue') && 'preconnect' === $relation_type) {
                $urls[] = array(
                    'href' => 'https://fonts.gstatic.com',
                    'crossorigin',
                );
            }

            return $urls;
        }, 10, 2);

    }

    // SINGLETON

    public static function instance()
    {
        return self::$instance;
    }

    public static function load($pluginFile)
    {
        new \OnePageExpress\Companion($pluginFile);
    }

    public static function getTreeValueAt($tree, $path, $default = null)
    {
        $result   = $tree;
        $keyParts = explode(":", $path);
        if (is_array($result)) {
            foreach ($keyParts as $part) {
                if ($result && isset($result[$part])) {
                    $result = $result[$part];
                } else {
                    return $default;
                }
            }
        }

        return $result;
    }

    public static function prefixedMod($mod, $prefix = null)
    {
        $prefix = $prefix ? $prefix : self::instance()->getThemeSlug();
        $prefix = str_replace("-", "_", $prefix);

        return $prefix . "_" . $mod;
    }

    public static function getThemeMod($mod, $default = false)
    {
        global $wp_customize;

        if ($wp_customize) {
            $settings = $wp_customize->unsanitized_post_values();

            $key = "CP_AUTO_SETTING[" . $mod . "]";
            if (isset($settings[$key])) {
                return $settings[$key];
            } else {
                $exists = apply_filters('cloudpress\customizer\temp_mod_exists', false, $mod);
                if ($exists) {
                    return apply_filters('cloudpress\customizer\temp_mod_content', false, $mod);
                }
            }
        }

        if ($default === false) {
            $default                = self::instance()->getCustomizerData("customizer:settings:{$mod}:wp_data:default");
            $alternativeTextDomains = (array)self::instance()->getCustomizerData('alternativeTextDomains:' . self::instance()->getThemeSlug());

            if ( ! $default) {
                foreach ($alternativeTextDomains as $atd) {
                    $mod     = self::prefixedMod($mod, $atd);
                    $default = self::instance()->getCustomizerData("customizer:settings:{$mod}:wp_data:default");
                    if ($default !== null) {
                        break;
                    }
                }
            }
        }

        $result = $default;
        $temp   = get_theme_mod(self::prefixedMod($mod), "CP_UNDEFINED_THEME_MOD");
        if ($temp !== "CP_UNDEFINED_THEME_MOD") {
            $result = $temp;
        } else {
            $result                 = "CP_UNDEFINED_THEME_MOD";
            $alternativeTextDomains = (array)self::instance()->getCustomizerData('alternativeTextDomains:' . self::instance()->getThemeSlug());
            foreach ($alternativeTextDomains as $atd) {
                $temp = get_theme_mod(self::prefixedMod($mod, $atd), "CP_UNDEFINED_THEME_MOD");
                if ($temp !== "CP_UNDEFINED_THEME_MOD") {
                    $result = $temp;
                    break;
                }
            }

            if ($result === "CP_UNDEFINED_THEME_MOD") {
                $result = get_theme_mod($mod, $default);
            }
        }

        return $result;
    }

    public static function echoMod($mod, $default = false)
    {
        echo self::getThemeMod($mod, $default);
    }

    public static function echoURLMod($mod, $default = false)
    {
        $value = self::getThemeMod($mod, $default);
        $value = str_replace('[tag_companion_uri]', self::instance()->themeDataURL(), $value);
        echo esc_url($value);
    }

    public static function filterDefault($data)
    {
        if (is_array($data)) {
            $data = self::filterArrayDefaults($data);
        } else {
            $data = str_replace('[tag_companion_uri]', \OnePageExpress\Companion::instance()->themeDataURL(), $data);
            $data = str_replace('[tag_theme_uri]', get_template_directory_uri(), $data);

            $data = str_replace('[tag_companion_dir]', \OnePageExpress\Companion::instance()->themeDataPath(), $data);
            $data = str_replace('[tag_theme_dir]', get_template_directory(), $data);
            $data = str_replace('[tag_style_uri]', get_stylesheet_directory_uri(), $data);
        }

        return $data;
    }

    public static function filterArrayDefaults($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = \OnePageExpress\Companion::filterDefault($value);
        }

        return $data;
    }

    public static function dataURL($path = '')
    {
        return self::instance()->themeDataURL($path);
    }

    public static function translateArgs($data)
    {
        if (isset($data['title'])) {
            $data['title'] = __($data['title'], 'cloudpress-companion');
        }

        if (isset($data['label'])) {
            $data['label'] = __($data['label'], 'cloudpress-companion');
        }

        if (isset($data['choices'])) {
            foreach ($data['choices'] as $key => $value) {
                if (strpos($value, "#") === false && is_string($key)) {
                    $data['choices'][$key] = __($value, 'cloudpress-companion');
                }
            }
        }

        return $data;
    }

    public static function loadJSONFile($path)
    {
        Companion::instance()->loadJSON($path);
    }
}
