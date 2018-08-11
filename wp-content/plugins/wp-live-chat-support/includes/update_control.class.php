<?php

final class wplc_update_control {

    private static $instance;
    private $wplc_api_url;
    private $wplc_api_slug;
    private $wplc_api_key;
    private $wplc_extension_string;
    private $wplc_option;
    private $wplc_button;
    private $wplc_form_name;
    private $wplc_option_is_valid;


    public function set_slug($slug) {
        $this->wplc_api_slug = $slug;
        $this->wplc_option = $slug."_key";
        $this->wplc_option_is_valid = $slug."_isvalid";
        $this->wplc_button = $slug."_button";
        $this->wplc_form_name = $slug."_form";
    }

    public function set_api($api) {
        $this->wplc_api_key = $api;
    }
    public function set_custom_option($option) {
        $this->wplc_option = $option;
    }

    public function set_path($path) {
        $this->wplc_path = $path;
    }   
    public function set_title($title) {
        $this->wplc_title = $title;
    }
    public function __clone() {
        // Cloning instances of the class is forbidden
        exit();
    }
    public function __wakeup() {
        // Unserializing instances of the class is forbidden
        exit();
    }
    public function set_api_url($url) {
        $this->wplc_api_url = $url;
    }

    public function activate() {
        $this->wplc_extension_string = $this->wplc_title;
        $this->wplc_api_url = 'https://ccplugins.co/api-control/';
 

        add_filter('pre_set_site_transient_update_plugins', array( $this, 'wplc_check_for_plugin_update' ));
        add_filter('plugins_api',  array( $this, 'wplc_plugin_api_call' ), 10, 3);
        add_filter("wplc_filter_api_page",array( $this, "wplc_filter_control_api_page" ),10,1);
        add_action("admin_init",array( $this, "wplc_save_api" ));
        add_action("after_plugin_row_{$this->wplc_path}", array( $this, "wplc_plugin_row" ), 10, 3 );
    }

    public function wplc_check_for_plugin_update($checked_data) {
        global $wp_version;
        
        //Comment out these two lines during testing.
        if (empty($checked_data->checked))
            return $checked_data;

        if ( empty( $checked_data->checked[$this->wplc_api_slug . '/' . $this->wplc_api_slug . '.php'] ) ) {
        	$plugin_data = get_plugin_data( trailingslashit( dirname( __FILE__, 3 ) ) . $this->wplc_api_slug . '/' . $this->wplc_api_slug . '.php' );
        	if ( ! empty( $plugin_data['Version'] ) ) {
        	    $version = $plugin_data['Version'];
	        } else {
        		$version = '0.0';
	        }
        } else {
        	$version = $checked_data->checked[$this->wplc_api_slug . '/' . $this->wplc_api_slug . '.php'];
        }
        
        $args = array(
            'slug' => $this->wplc_api_slug,
            'version' => $version,
        );
        
        $request_string = array(
            'body' => array(
                'action' => 'basic_check', 
                'request' => serialize($args),
                'api_key' => get_option($this->wplc_option),
                'd' => get_option('siteurl'),
                'ip' => $_SERVER['SERVER_ADDR']
            ),
            'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
        );
        // Start checking for an update
        $raw_response = wp_remote_post($this->wplc_api_url, $request_string);

        
        if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
            $response = unserialize($raw_response['body']);

        if (is_object($response) && !empty($response)) // Feed the update data into WP updater
            $checked_data->response[$this->wplc_api_slug . '/' . $this->wplc_api_slug . '.php'] = $response;

        return $checked_data;
    }

    public function wplc_plugin_api_call($def, $action, $args) {
    
        global $wp_version;

        if (!isset($args->slug) || ($args->slug != $this->wplc_api_slug))
            return false;
        
        // Get the current version
        $plugin_info = get_site_transient('update_plugins');
        $current_version = $plugin_info->checked[$this->wplc_api_slug . '/' . $this->wplc_api_slug . '.php'];
        $args->version = $current_version;

        $request_string = array(
            'body' => array(
                'action' => $action, 
                'request' => serialize($args),
                'api_key' => get_option($this->wplc_option),
                'd' => get_option('siteurl'),
                'ip' => $_SERVER['SERVER_ADDR']
            ),
            'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
        );

        $request = wp_remote_post($this->wplc_api_url, $request_string);

        if (is_wp_error($request)) {
            $res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
        } else {
            $res = unserialize($request['body']);

            if ($res === false)
                $res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
        }

        return $res;
    }

    public function wplc_filter_control_api_page($page_content) {
        if (get_option($this->wplc_option)) {
            $args = array(
                'slug' => $this->wplc_api_slug,
            );
            $data_array = array(
                'method' => 'POST',
                'httpversion' => '1.0',
                'sslverify' => false,
                'body' => array(
                    'action' => 'api_validation',
                    'd' => get_option('siteurl'),
                    'request' => serialize($args),
                    'api_key' => get_option($this->wplc_option)
            ));
            $response = wp_remote_post($this->wplc_api_url, $data_array);




			
            if (is_array($response)) {
                if ( $response['response']['code'] == "200" ) {
                    $data = $response['body'];
                    $data = unserialize($data);
                } else {
                    $data = array("message"=>"Unable to contact the host server at this point. Please try again later. Error: ".json_encode( $response ) );
                }
            } else {
                $data = array("message"=>"Unable to contact the host server at this point. Please try again later.");
            } 
            $data_array = array(
                "data" => $data,
                "string" => $this->wplc_extension_string,
                "form_name" => $this->wplc_form_name,
                "option_name" => $this->wplc_option,
                "button" => $this->wplc_button,
                "is_valid" => $this->wplc_option_is_valid

            );
        } else {
            $data_array = array(
                "data" => null,
                "string" => $this->wplc_extension_string,
                "form_name" => $this->wplc_form_name,
                "option_name" => $this->wplc_option,
                "button" => $this->wplc_button,
                "is_valid" => 0

            );
            
        }


        if (function_exists("wplc_build_api_check")) { return wplc_build_api_check($page_content,$data_array); }
		
        return $page_content;
        
    }

    public function wplc_save_api() {
        
        if(isset($_POST[$this->wplc_button])){
            if(isset($_POST[$this->wplc_option])){
                update_option($this->wplc_option, sanitize_text_field($_POST[$this->wplc_option]));
            }
        }
    }
    public function wplc_plugin_row( $plugin_file, $plugin_data, $status ) {
        if (!get_option($this->wplc_option_is_valid)) {
            if (function_exists("wplc_plugin_row_invalid_api")) { wplc_plugin_row_invalid_api(); }
        }
    }   

}