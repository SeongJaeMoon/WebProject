<?php

namespace OnePageExpress\Customizer;

class Customizer
{
    public $cpData = null;
    private $_companion = null;

    private $globalScriptsPrinted = false;
    private $autoSetting = false;

    private $registeredTypes
        = array(
            'panels'   => array(
                "OnePageExpress\\Customizer\\BasePanel" => true,
            ),
            'sections' => array(),
            'controls' => array(
                "OnePageExpress\\Customizer\\BaseControl" => true,
            ),
        );

    public function __construct($companion)
    {
        $this->_companion = $companion;


        if ( ! $this->customizerSupportsViewedTheme()) {
            return;
        }

        do_action('cloudpress\customizer\loaded');

        $this->register(array($this, '__registerComponents'));

        $this->register(array($this, '__registerAssets'));
        $this->previewInit(array($this, '__registePreviewAssets'));

        $this->register(array($this, '__addGlobalScript'));
        $this->previewInit(array($this, '__previewScript'));

        add_filter('customize_dynamic_setting_args', array($this, '__autoSettingsOptions'), PHP_INT_MAX, 2);
        add_filter('customize_dynamic_setting_class', array($this, '__autoSettingsClass'), 10, 3);

        require_once($this->_companion->assetsRootPath() . "/ajax_req/index.php");
    }


    public function customizerSupportsViewedTheme()
    {

        $supportedThemes = (array)$this->_companion->getCustomizerData('themes', false);
        $currentTheme    = $this->_companion->getThemeSlug();

        if (isset($_REQUEST['theme'])) {
            $currentTheme = $_REQUEST['theme'];
        }

        if (isset($_REQUEST['customize_theme'])) {
            $currentTheme = $_REQUEST['customize_theme'];
        }

        $supported = (in_array($currentTheme, $supportedThemes) || in_array('*', $supportedThemes));
        $supported = apply_filters('cloudpress\customizer\supports', $supported, $currentTheme);

        return $supported;

    }

    public function companion()
    {
        return $this->_companion;
    }

    public function __registerComponents($wp_customize)
    {
        $this->cpData = apply_filters('cloudpress\customizer\data', $this->_companion->getCustomizerData(), $this);
        $this->registerComponents($wp_customize);
    }

    public function __registerAssets($wp_customize)
    {
        $self = $this;
        add_action('admin_enqueue_scripts',
            function () use ($self) {
                wp_enqueue_style('thickbox');
                wp_enqueue_script('thickbox');

                $jsUrl  = $self->companion()->assetsRootURL() . "/js/customizer/";
                $cssUrl = $self->companion()->assetsRootURL() . "/css";

                $ver = $self->companion()->version;

                wp_enqueue_style('cp-fa-media-tab', $cssUrl . '/fa-tab.css', array(), $ver);
                wp_enqueue_style('cp-customizer-base', $cssUrl . '/customizer.css', array(), $ver);
                wp_enqueue_style('cp-customizer-spectrum', $cssUrl . '/libs/spectrum.css', array(), $ver);
                wp_enqueue_style($self->companion()->getThemeSlug() . '_font-awesome', get_template_directory_uri() . '/assets/font-awesome/font-awesome.min.css', array(), $ver);

                wp_enqueue_script('cp-customizer-spectrum', $jsUrl . "../libs/spectrum.js", array(), $ver, true);
                wp_enqueue_script('cp-customizer-speakurl', $jsUrl . "../libs/speakingurl.js", array(), $ver, true);
                wp_enqueue_script('cp-hooks-manager', $jsUrl . "../libs/hooks-manager.js", array(), $ver, true);
                wp_enqueue_script('cp-customizer-base', $jsUrl . "customizer-base.js", array(), $ver, true);
                wp_enqueue_script('cp-customizer-utils', $jsUrl . "customizer-utils.js", array(), $ver, true);
                wp_enqueue_script('cp-customizer-support', $jsUrl . "customizer-support.js", array(), $ver, true);
                wp_enqueue_script('cp-fa-media-tab', $jsUrl . '/fa-tab.js', array('media-views'), $ver);
                wp_enqueue_script('cp-webfonts', $jsUrl . '/web-fonts.js', array('jQuery'));
                wp_enqueue_script('cp-customizer-shortcodes-popup', $jsUrl . "/customizer-shortcodes-popup.js", array(), $ver, true);

                do_action('cloudpress\customizer\add_assets', $self);
            });
    }

    public function __addGlobalScript($wp_customize)
    {
        $self = $this;


        add_action('customize_controls_print_scripts', function () {
            if (isset($_REQUEST['cp__changeset__preview'])): ?>
                <style>
                    #customize-controls {
                        display: none !important;
                    }

                    div#customize-preview {
                        position: fixed;
                        top: 0px;
                        left: 0px;
                        height: 100%;
                        width: 100%;
                        z-index: 10000000;
                        display: block;
                    }

                    html, body {
                        width: 100%;
                        max-width: 100%;
                        overflow-x: hidden;
                    }
                </style>
                <script>
                    window.__isCPChangesetPreview = true;
                </script>
            <?php endif;
        });

        add_action('customize_controls_print_footer_scripts', function () use ($self) {

            if (defined("CP__addGlobalScript")) {
                return;
            }

            define("CP__addGlobalScript", "1");

            $globalData = apply_filters('cloudpress\customizer\global_data', array(
                "version"              => $self->companion()->getCustomizerData('version'),
                "data"                 => $self->companion()->getCustomizerData('data'),
                "slugPrefix"           => $self->companion()->getThemeSlug(true),
                "cssAllowedProperties" => \OnePageExpress\Utils\Utils::getAllowCssProperties(),
                "stylesheetURL"        => get_stylesheet_directory_uri(),
                "includesURL"          => includes_url(),
                "themeURL"             => get_template_directory_uri(),
                "isMultipage"          => $self->companion()->isMultipage(),
                "restURL"              => get_rest_url(),
            ));
            ?>
            <!-- CloudPress Companion Global Data START -->
            <script type="text/javascript">
                (function () {
                    parent.cpCustomizerGlobal = window.cpCustomizerGlobal = {
                        pluginOptions:  <?php echo json_encode($globalData); ?>
                    };
                })();
            </script>

            <div id="cp-full-screen-loader" class="active">
                <div class="wrapper">
                    <div id="floatingCirclesG">
                        <div class="f_circleG" id="frotateG_01"></div>
                        <div class="f_circleG" id="frotateG_02"></div>
                        <div class="f_circleG" id="frotateG_03"></div>
                        <div class="f_circleG" id="frotateG_04"></div>
                        <div class="f_circleG" id="frotateG_05"></div>
                        <div class="f_circleG" id="frotateG_06"></div>
                        <div class="f_circleG" id="frotateG_07"></div>
                        <div class="f_circleG" id="frotateG_08"></div>
                    </div>
                    <p class="message-area"><?php _e('Please wait,<br/>this might take a little while', 'one-page-express-pro') ?></p>
                </div>
            </div>

            <?php $frontpageCB = uniqid('cb_') . "_CreateFrontendPage"; ?>
            <div class='reiki-needed-container' data-type="select">
                <div class="description customize-section-description">
                    <span><?php _e('This section only works when the ' . $self->companion()->themeName . ' custom front page is open in Customizer', 'cloudpress-companion'); ?>.</span>
                    <a onclick="<?php echo $frontpageCB ?>()" class="reiki-needed select available-item-hover-button"><?php _e('Open ' . $self->companion()->themeName . ' Front Page', 'reiki-companion'); ?></a>
                </div>
            </div>
            <script>
                <?php echo $frontpageCB ?>  = function () {
                    jQuery.post(
                        parent.ajaxurl,
                        {
                            action: 'create_home_page',
                            create_home_page_nounce: '<?php echo wp_create_nonce('create_home_page_nounce'); ?>'
                        },
                        function (response) {
                            parent.window.location = (parent.window.location + "").split("?")[0];
                        }
                    );
                }
            </script>

            <div class='reiki-needed-container' data-type="activate">
                <div class="description customize-section-description">
                    <span><?php _e('This section only works when the ' . $self->companion()->themeName . ' custom front page is activated', 'cloudpress-companion'); ?>.</span>
                    <a onclick="<?php echo $frontpageCB ?>()" class="reiki-needed activate available-item-hover-button"><?php _e('Activate ' . $self->companion()->themeName . ' Front Page', 'cloudpress-companion'); ?></a>
                </div>
            </div>

            <?php $makeMaintainable = uniqid('cb_') . "_MakePageMaintainable"; ?>
            <script>
                <?php echo $makeMaintainable ?> = function cp_open_page_in_customizer() {
                    var page = top.CP_Customizer.preview.data().pageID;
                    jQuery.post(ajaxurl, {
                        action: 'cp_open_in_customizer',
                        page: page
                    }).done(function (response) {
                        window.location = response.trim();
                    });
                }
            </script>

            <div class='reiki-needed-container' data-type="edit-this-page">
                <div class="description customize-section-description">
                    <span><?php _e('This page is not marked as editable in Customizer', 'cloudpress-companion'); ?>.</span>
                    <a onclick="<?php echo $makeMaintainable ?>()" class="reiki-needed edit-this-page available-item-hover-button"><?php _e('Make this page editable in customizer', 'cloudpress-companion'); ?></a>
                </div>
            </div>


            <?php do_action("cloudpress\customizer\global_scripts", $self); ?>
            <!-- CloudPress Companion Global Data END -->
            <?php

        });
    }

    public function __registePreviewAssets($wp_customize)
    {
        $jsUrl  = $this->_companion->assetsRootURL() . "/js/customizer";
        $cssUrl = $this->_companion->assetsRootURL() . "/css";

        wp_enqueue_style('cp-customizer-spectrum', $cssUrl . '/libs/spectrum.css');
        wp_enqueue_style('cp-customizer-base', $cssUrl . '/preview.css');

        wp_enqueue_script('cp-customizer-preview', $jsUrl . "/preview.js", array('jquery', 'jquery-ui-sortable', 'customize-preview'));
    }

    public function __autoSettingsOptions($args, $setting)
    {
        $settingRegex = \OnePageExpress\Customizer\Settings\AutoSetting::SETTING_PATTERN;

        if (preg_match($settingRegex, $setting)) {
            $args = array(
                'transport' => 'postMessage',
                'type'      => \OnePageExpress\Customizer\Settings\AutoSetting::TYPE,
            );
        }

        return $args;
    }


    public function __autoSettingsClass($class, $setting, $args)
    {
        $settingRegex = \OnePageExpress\Customizer\Settings\AutoSetting::SETTING_PATTERN;

        if (preg_match($settingRegex, $setting)) {
            $class = "\\OnePageExpress\\Customizer\\Settings\\AutoSetting";
        }

        return $class;
    }

    public function queryVarsCleaner($input)
    {
        foreach ($input as $key => &$value) {
            if (is_array($value)) {
                $value = $this->queryVarsCleaner($value);
            } else {
                if (strpos($key, 'cache') !== false) {
                    unset($input[$key]);
                }
            }
        }

        return array_filter($input);
    }

    public function __previewScript($wp_customize)
    {
        if (defined("CP__previewScript")) {
            return;
        }

        define("CP__previewScript", "1");

        $self = $this;

        add_action('wp_footer', function () use ($self) {
            global $wp_query;

            $vars              = $self->queryVarsCleaner($wp_query->query_vars);
            $vars['post_type'] = get_post_type();

            $previewData = apply_filters('cloudpress\customizer\preview_data', array(
                "version"      => $self->companion()->getCustomizerData('version'),
                "slug"         => $self->companion()->getThemeSlug(),
                "maintainable" => $self->companion()->isMaintainable(),
                "isFrontPage"  => $self->companion()->isFrontPage(),
                "pageID"       => $self->companion()->getCurrentPageId(),
                "queryVars"    => $vars,
                "hasFrontPage" => ($self->companion()->getFrontPage() !== null),
                "siteURL"      => get_site_url(),
                "pageURL"      => get_page_link(),
                "includesURL"  => includes_url(),
                "mod_defaults" => apply_filters('cloudpress\customizer\mod_defaults', array()),
            ));
            ?>
            <!-- CloudPress Companion Preview Data START -->
            <script type="text/javascript">
                (function () {
                    window.cpCustomizerPreview = <?php echo json_encode($previewData); ?>;
                    wp.customize.bind('preview-ready', function () {
                        jQuery(window).load(function () {

                            setTimeout(function () {
                                parent.postMessage('cloudpress_update_customizer', "*");
                            }, 100);

                        });

                    });
                })();
            </script>

            <style>
                *[contenteditable="true"] {
                    user-select: auto !important;
                    -webkit-user-select: auto !important;
                    -moz-user-select: text !important;
                }
            </style>

            <?php do_action("cloudpress\customizer\preview_scripts", $self); ?>
            <!-- CloudPress Companion Preview Data END -->
            <?php

        });
    }

    public function removeNamespace($name)
    {
        $parts  = explode("\\", $name);
        $result = array();

        foreach ($parts as $part) {
            $part = trim($part);
            if ( ! empty($part)) {
                $result[] = $part;
            }
        }

        $result = implode("-", $result);

        return strtolower($result);
    }

    private function registerComponents($wp_customize)
    {
        $wp_customize->register_panel_type("OnePageExpress\\Customizer\\BasePanel");
        $wp_customize->register_control_type("OnePageExpress\\Customizer\\BaseControl");

        foreach ($this->cpData['customizer'] as $category => $components) {
            switch ($category) {
                case 'panels':
                    $this->registerPanels($wp_customize, $components);
                    break;
                case 'sections':
                    $components = $this->cpData['customizer']['sections'];
                    $this->registerSections($wp_customize, $components);
                    break;

                case 'controls':
                    $components = $this->cpData['customizer']['controls'];
                    $this->registerControls($wp_customize, $components);
                    break;
                case 'settings':
                    $components = $this->cpData['customizer']['settings'];
                    $this->registerSettings($wp_customize, $components);
                    break;
            }
        }
    }

    public function registerPanels($wp_customize, $components)
    {
        foreach ($components as $id => $data) {
            if ($panel = $wp_customize->get_panel($id)) {
                if (isset($data['wp_data'])) {
                    foreach ($data['wp_data'] as $key => $value) {
                        $panel->$key = $value;
                    }
                }
                continue;
            }


            $panelClass = "OnePageExpress\\Customizer\\BasePanel";

            if (isset($data['class']) && $data['class']) {
                $panelClass = $data['class'];
            }

            if ( ! isset($this->registeredTypes['panels'][$panelClass])) {
                $this->registeredTypes['panels'][$panelClass] = true;
            }


            if (strpos($panelClass, "WP_Customize_") !== false) {
                $data = isset($data['wp_data']) ? $data['wp_data'] : array();
            }

            $wp_customize->add_panel(new $panelClass($wp_customize, $id, $data));
        }
    }


    public function registerSections($wp_customize, $components)
    {
        foreach ($components as $id => $data) {
            if ($section = $wp_customize->get_section($id)) {
                if (isset($data['wp_data'])) {
                    foreach ($data['wp_data'] as $key => $value) {
                        $section->$key = $value;
                    }
                }
                continue;
            }

            $sectionClass = "OnePageExpress\\Customizer\\BaseSection";

            if (isset($data['class']) && $data['class']) {
                $sectionClass = $data['class'];
            }

            if ( ! isset($this->registeredTypes['sections'][$sectionClass])) {
                $this->registeredTypes['sections'][$sectionClass] = true;
                $wp_customize->register_section_type($sectionClass);
            }


            if (strpos($sectionClass, "WP_Customize_") !== false) {
                $data = isset($data['wp_data']) ? $data['wp_data'] : array();
            }

            $wp_customize->add_section(new $sectionClass($wp_customize, $id, $data));
        }
    }

    public function registerControls($wp_customize, $components)
    {
        foreach ($components as $id => $data) {
            if ($control = $wp_customize->get_control($id)) {
                if (isset($data['wp_data'])) {
                    foreach ($data['wp_data'] as $key => $value) {
                        $control->$key = $value;
                    }
                }
                continue;
            }

            $controlClass = "OnePageExpress\\Customizer\\BaseControl";
            if (isset($data['class']) && $data['class']) {
                $controlClass = $data['class'];
            }

            if ( ! isset($this->registeredTypes['controls'][$controlClass])) {
                $this->registeredTypes['controls'][$controlClass] = true;
                // $wp_customize->register_control_type($controlClass);
            }


            if (strpos($controlClass, "WP_Customize_") !== false) {
                $data = isset($data['wp_data']) ? $data['wp_data'] : array();
            }

            if (strpos($controlClass, "kirki:") === 0) {
                $data         = isset($data['wp_data']) ? $data['wp_data'] : array();
                $data['type'] = str_replace("kirki:", "", $controlClass);
                \Kirki::add_field($id, $data);
            } else {
                $wp_customize->add_control(new $controlClass($wp_customize, $id, $data));
            }
        }
    }

    public function registerSettings($wp_customize, $components)
    {
        foreach ($components as $id => $data) {
            if ($setting = $wp_customize->get_setting($id)) {
                if (isset($data['wp_data'])) {
                    foreach ($data['wp_data'] as $key => $value) {
                        if ($key === "default") {
                            $value = BaseSetting::filterDefault($value);
                        }
                        $setting->$key = $value;
                    }
                }
                continue;
            }

            $settingClass = "OnePageExpress\\Customizer\\BaseSetting";

            if (isset($data['class']) && $data['class']) {
                $settingClass = $data['class'];
            }

            if (strpos($settingClass, "WP_Customize_") !== false) {
                $data = isset($data['wp_data']) ? $data['wp_data'] : array();
            }


            if (strpos($settingClass, "kirki") === 0) {
                $settingClass        = "OnePageExpress\\Customizer\\BaseSetting";
                $data['__is__kirki'] = true;
            }


            $setting = new $settingClass($wp_customize, $id, $data);

            if ( ! $setting->isKirki()) {
                $wp_customize->add_setting($setting);
            }

            if (method_exists($setting, 'setControl')) {
                $setting->setControl();
            }
        }
    }

    public function register($callback, $priority = 40)
    {
        add_action('customize_register', $callback, $priority);
    }

    public function registerScripts($callback, $priority = 40)
    {
        add_action('customize_controls_enqueue_scripts', $callback);
    }

    public function previewInit($callback, $priority = 40)
    {
        add_action('customize_preview_init', $callback, $priority);
    }
}
