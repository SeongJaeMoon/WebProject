<?php
/*
 * Node Code -> Insert pun here
*/

define("BLEEPER_API_URL", "https://bleeper.io/app/api/v1/");
define("BLEEPER_REMOTE_DASH_ROUTE", "remote_dashboard.php");

define("BLEEPER_NODE_SERVER_URL", "https://bleeper.us-3.evennode.com");

//define("BLEEPER_NODE_SERVER_URL", "http://localhost:3000");
define("BLEEPER_NODE_END_POINTS_ROUTE", "api/v1/");
define("BLEEPER_NODE_END_POINT_TOKEN", "zf6fe1399sdfgsdfg02ad09ab6a8cb7345s");


add_action("wplc_activate_hook", "wplc_node_server_token_check", 10);
add_action("wplc_update_hook", "wplc_node_server_token_check", 10);
/**
 * Checks if a secret key has been created.
 * If not create one for use in the API
 *
 * @return void
*/
function wplc_node_server_token_check(){
	if (!get_option("wplc_node_server_secret_token")) {
		$user_token = wplc_node_server_token_create();
        add_option("wplc_node_server_secret_token", $user_token);
    }
}

add_action("wplc_admin_remote_dashboard_below", "wplc_admin_remote_dashboard_thank_you_footer");
/*
 * Adds a simple thank you message to the footer of the dashboard
*/
function wplc_admin_remote_dashboard_thank_you_footer(){
	echo "<p id='wplc_footer_message' style='display:none;'>";
	echo __("Thank you for using WP Live Chat Support - Need assistance? Please get in touch here: ", "wplivechat");
	echo "<a href='https://wp-livechat.com/contact-us/' rel='nofollow' target='_blank'>" . __("Contact us", "wplivechat") . "</a><span class='bleeper_stats'></span><span class='bleeper_instance'></span>";
	echo "</p>";
}

/**
 * Generates a new Secret Token
 *
 * @return string
*/
function wplc_node_server_token_create(){
	$the_code = rand(0, 1000) . rand(0, 1000) . rand(0, 1000) . rand(0, 1000) . rand(0, 1000);
	$the_time = time();
	$token = md5($the_code . $the_time);
	return $token;
}

/**
 * Re-Generates the token
 * @return void
*/
function wplc_node_server_token_regenerate(){
	$wplc_node_token_new = wplc_node_server_token_create();
    update_option("wplc_node_server_secret_token", $wplc_node_token_new);
}

/**
 * Post to the NODE server -
 *
 * @param string $route Route you would like to use for the node server
 * @param string $form_data data to send
 * @return string (or false on fail)
*/
function wplc_node_server_post($route, $form_data){
    $url = BLEEPER_NODE_SERVER_URL . BLEEPER_NODE_END_POINTS_ROUTE . $route;

    $wplc_end_point_override = get_option("wplc_end_point_override");
    if($wplc_end_point_override !== false && $wplc_end_point_override !== ""){
    	$url = $wplc_end_point_override . BLEEPER_NODE_END_POINTS_ROUTE . $route; //Use the override URL
    }


    if(!isset($form_data['token'])){
        $form_data['token'] = BLEEPER_NODE_END_POINT_TOKEN; //Add the security token
    }

	if(!isset($form_data['api_key'])){
        $wplc_node_token = get_option("wplc_node_server_secret_token");
        if(!$wplc_node_token){
            if(function_exists("wplc_node_server_token_regenerate")){
                wplc_node_server_token_regenerate();
                $wplc_node_token = get_option("wplc_node_server_secret_token");
            }
        }

        $form_data['api_key'] = $wplc_node_token; //Add the security token
    }

    if(!isset($form_data['origin_url'])){
        $ajax_url = admin_url('admin-ajax.php');
        $origin_url = str_replace("/wp-admin/admin-ajax.php", "", $ajax_url);
        $form_data['origin_url'] = $origin_url; //Add the security token
    }

    $context  = @stream_context_create($options);
    $result = @file_get_contents($url . "?" . http_build_query($form_data), false, $context);

    if ($result === FALSE) {
        return false;
    } else {
        return $result;
    }
}

add_action("wplc_hook_chat_notification","wplc_filter_notification_hook_node",20,3);
/**
 * Send a system notification to the node server
 *
 * @return void
*/
function wplc_filter_notification_hook_node($type,$cid,$data){
    $wplc_settings = get_option("WPLC_SETTINGS");
    if(isset($wplc_settings['wplc_use_node_server']) && intval($wplc_settings['wplc_use_node_server']) == 1) {

    	if(filter_var($cid, FILTER_VALIDATE_INT) ) {
	        //Let's reverse the CID back to it's rel counterpart
		    $cid = wplc_return_chat_rel_by_id($cid);
		}

		$msg = false;
		switch($type){
			case "doc_suggestion":
				$msg = $data['formatted_msg'];
				break;
			default:
				break;
		}

		if(isset($cid)){
			if($msg !== false){
	            $form_data = array(
	                    'chat_id' => $cid,
	                    'notification_text' => $msg,
	            );

	            $user_request = wplc_node_server_post("user_chat_notification", $form_data);

	            if($user_request === false){
	            	//Something is wrong
	            } else {

	            }
			}
		}
	}

	return;
}

add_action("wplc_api_route_hook", "wplc_api_node_routes");
/**
 * Add a REST API routes for the node server
 *
 * @return void
*/
function wplc_api_node_routes(){
	register_rest_route('wp_live_chat_support/v1','/async_storage', array(
						'methods' => 'POST',
						'callback' => 'wplc_node_async_storage_rest'
	));
}

/**
 * Handles Async storage REST -> Params are processed within the request
 * Required POST variables:
 * - Chat ID
 * - Security Key
 * - Message (JSON encoded array)
 * - Action
 *
 * @param WP_REST_Request $request Request Data
 * @return void
*/
function wplc_node_async_storage_rest(WP_REST_Request $request){
	$return_array = array();
	$return_array['request_status'] = false; //Default to be returned if something goes wrong
	if(isset($request)){
		if(isset($request['security'])){
			$stored_token = get_option("wplc_node_server_secret_token");
			$check = $_POST['server_token'] == $stored_token ? true : false;
			if ($check) {
				if(isset($request['chat_id'])){
					if(isset($request['messages'])){
						if(isset($request['relay_action'])){
							$chat_id = sanitize_text_field($request['chat_id']);
							$message_data = json_decode($request['messages']);
							$chat_session = wplc_return_chat_session_variable($chat_id);
							$action = $request['relay_action'];
							if($message_data !== NULL){
								if($action == "wplc_user_send_msg"){
									foreach ($message_data as $message) {
										$message = sanitize_text_field($message);
										wplc_record_chat_msg("1", $chat_id, $message);

										//wplc_update_user_on_page($chat_id, "3", $chat_session); //Keep timestamp active
										wplc_update_active_timestamp($chat_id);
									}

									$return_array['request_status'] = true;
									$return_array['request_information'] = __("Success", "wplivechat");
								} else if ($action == "wplc_admin_send_msg"){
									foreach ($message_data as $message) {
										$message = sanitize_text_field($message);
										wplc_record_chat_msg("2", $chat_id, $message, true);

										//wplc_update_user_on_page($chat_id, "3", $chat_session); //Keep timestamp active
										wplc_update_active_timestamp($chat_id);
									}

									$return_array['request_status'] = true;
									$return_array['request_information'] = __("Success", "wplivechat");
								}
							} else {
								$return_array['request_information'] = __("Message data is corrupt", "wplivechat");
							}
						} else {
							$return_array['request_information'] = __("Action not set", "wplivechat");
						}
					} else {
						$return_array['request_information'] = __("Message data array not set", "wplivechat");
					}
				} else {
					$return_array['request_information'] = __("Chat ID is not set", "wplivechat");
				}
			}
		} else {
			$return_array['request_information'] = __("No security nonce found", "wplivechat");
		}
	}

	return $return_array;

}

add_action("wp_ajax_wplc_node_async_storage_ajax", "wplc_node_async_storage_ajax");
add_action("wp_ajax_nopriv_wplc_node_async_storage_ajax", "wplc_node_async_storage_ajax");
/**
 * Handles Async storage AJAX (Fallback for if REST is not present) -> Params are processed within the request
 * Required POST variables:
 * - Chat ID
 * - Security Key
 * - Message (JSON encoded array)
 * - Action
 *
 * @return void
*/
function wplc_node_async_storage_ajax(){
	$return_array = array();
	$return_array['request_status'] = false; //Default to be returned if something goes wrong
	if(isset($_POST)){
		if(isset($_POST['server_token'])){
			$stored_token = get_option("wplc_node_server_secret_token");
			$check = $_POST['server_token'] == $stored_token ? true : false;
			if ($check) {
				if(isset($_POST['chat_id'])){
					if(isset($_POST['messages'])){
						if(isset($_POST['relay_action'])){
							$chat_id = sanitize_text_field($_POST['chat_id']);
							$message_data = json_decode($_POST['messages']);
							$chat_session = wplc_return_chat_session_variable($chat_id);
							$action = $_POST['relay_action'];
							if($message_data !== NULL){
								if($action == "wplc_user_send_msg"){
									foreach ($message_data as $message) {
										$message = sanitize_text_field($message);
										wplc_record_chat_msg("1", $chat_id, $message);
										//wplc_update_user_on_page($chat_id, "3", $chat_session); //Keep timestamp active
										wplc_update_active_timestamp($chat_id);

									}

									$return_array['request_status'] = true;
									$return_array['request_information'] = __("Success", "wplivechat");
								} else if ($action == "wplc_admin_send_msg"){
									foreach ($message_data as $message) {
										$message = sanitize_text_field($message);
										wplc_record_chat_msg("2", $chat_id, $message);
										//wplc_update_user_on_page($chat_id, "3", $chat_session); //Keep timestamp active
										wplc_update_active_timestamp($chat_id);
									}

									$return_array['request_status'] = true;
									$return_array['request_information'] = __("Success", "wplivechat");
								}
							} else {
								$return_array['request_information'] = __("Message data is corrupt", "wplivechat");
							}
						} else {
							$return_array['request_information'] = __("Action not set", "wplivechat");
						}
					} else {
						$return_array['request_information'] = __("Message data array not set", "wplivechat");
					}
				} else {
					$return_array['request_information'] = __("Chat ID is not set", "wplivechat");
				}
			}
		} else {
			$return_array['request_information'] = __("No security nonce found", "wplivechat");
		}
	}

	return $return_array;

}

/**
 * Loads remote dashboard
 *
 * @return void
*/
function wplc_admin_dashboard_layout_node( $location = 'dashboard' ){
	if ( $location === 'dashboard') {

		if( ! get_user_meta( get_current_user_id(), 'wplc_ma_agent', true ) ){
			echo "<div class='error below-h1'>";
		    echo "<h2>".__("Error", "wplivechat")."</h2>";
		    echo "<p>".__("Only chat agents can access this page.", "wplivechat")."</p>";
		    echo "</div>";
			return;
		}

		do_action("wplc_admin_remote_dashboard_above");

		echo "<div id='bleeper_content_wrapper'></div>";

		if ( ! isset( $_GET['action'] ) || 'history' !== $_GET['action'] ) {

            echo "<div class='wplc_remote_dash_below_contianer'>";
            do_action("wplc_admin_remote_dashboard_below");
            echo "</div>";

        }
   } else {
		do_action("wplc_admin_remote_dashboard_above");

		echo "<div id='bleeper_content_wrapper'></div>";

		if ( ! empty( $_GET['page'] ) && 'wplivechat-menu' === $_GET['page'] ) { // This div is also hidden by js under the same conditions

            echo "<div class='wplc_remote_dash_below_contianer'>";
            do_action("wplc_admin_remote_dashboard_below");
            echo "</div>";

        }
   }
}

add_action("wplc_admin_remote_dashboard_below", "wplc_admin_remote_dashboard_below_delegate");
/*
 * Delegates the below dashboard hooks
*/
function wplc_admin_remote_dashboard_below_delegate(){
	do_action("wplc_hook_chat_dashboard_bottom");
}

add_action("wplc_hook_chat_dashboard_bottom","wplc_hook_control_dashboard_bottom_loading_logo",1);
/**
 * Decides whether or not to show the available extensions for this area.
 * @return void
 * @since  6.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
function wplc_hook_control_dashboard_bottom_loading_logo() {
    $wplc_settings = get_option("WPLC_SETTINGS");
    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
          echo "<div id='wplc_footer_loading_icon'><img src='https://bleeper.io/app/assets/images/wplc_loading.png' width='50' /><br />Connecting...</div>";
    }
}

add_action('admin_enqueue_scripts', 'wplc_enqueue_dashboard_popup_scripts');
/**
 * Enqueues the scripts for the admin dashboard popup icon and chat box
 * @return void
 */
function wplc_enqueue_dashboard_popup_scripts() {
	global $wplc_version;
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('wplc-admin-popup', plugins_url('../js/wplc_admin_popup.js', __FILE__ ), array('jquery-ui-draggable'), $wplc_version);
	
	wp_button_pointers_load_scripts('toplevel_page_wplivechat-menu');
}

add_action( "admin_footer", "wplc_dashboard_display_decide" );
/**
 * Decide whether or not to display the dashboard layout on an admin page
 * @return  void
 */
function wplc_dashboard_display_decide() {
	$wplc_settings = get_option("WPLC_SETTINGS");
    if ( isset( $wplc_settings['wplc_use_node_server'] ) && $wplc_settings['wplc_use_node_server'] == 1 ) {
    	//Node in use, load remote dashboard
    	if ( isset( $_GET['page'] ) && $_GET['page'] === 'wplivechat-menu') {
    		// we control this in the wplc_admin_menu_layout function
    		//wplc_admin_dashboard_layout_node('dashboard');
    	} else {
    		if (function_exists("wplc_pro_version_control")) {
	    		global $wplc_pro_version;
			    $wplc_ver = str_replace('.', '', $wplc_pro_version);
			    $checker = intval($wplc_ver);
			    if (function_exists("wplc_pro_version_control") && $checker < 8000) {
			    	/* ONLY SHOW THE POPOUT DASHBOARD IF THEY ARE USING PRO 8.0.00 and above */
			    	return;
			    }
			}


			/**
			 * Check to see if we have enabled "Enable chat dashboard and notifications on all admin pages"
			 */
			
			if ( isset( $wplc_settings['wplc_enable_all_admin_pages'] ) && $wplc_settings['wplc_enable_all_admin_pages'] === '1' ) {


	    		wplc_admin_dashboard_layout_node('other');

	    		echo '<div class="floating-right-toolbar">';
	      		echo '<label for="user_list_bleeper_control" style="margin-bottom: 0; display:none;"></label>';

	            echo '<i id="toolbar-item-open-bleeper" class="fa fa-fw" style="background:url(\''.plugins_url('../images/48px.png', __FILE__).'\') no-repeat; background-size: cover;"></i>';
	    		echo '</div>';
	    	}

    	}
    }



}


/**
 * Loads remote dashboard scripts and styles
 *
 * @return void
*/
function wplc_admin_remote_dashboard_scripts($wplc_settings){
	global $wplc_version;
	$wplc_current_user = get_current_user_id();
	if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true )) {

		$user_info = get_userdata(intval($wplc_current_user));

		$user_array = get_users(array(
	        'meta_key' => 'wplc_ma_agent',
	    ));

		$a_array = array();
		if ($user_array) {
            foreach ($user_array as $user) {
            	$current_user_name = apply_filters("wplc_agent_display_name_filter", $user->display_name);
                $a_array[$user->ID] = array();
                $a_array[$user->ID]['name'] = $user->display_name;
                $a_array[$user->ID]['display_name'] = $user->display_name;
                $a_array[$user->ID]['md5'] = md5( $user->user_email );
                $a_array[$user->ID]['email'] = md5( $user->user_email );
            }
        }


		if( isset($wplc_settings['wplc_show_name']) && $wplc_settings['wplc_show_name'] == '1' ){ $wplc_show_name = true; } else { $wplc_show_name = false; }
   		if( isset($wplc_settings['wplc_show_avatar']) && $wplc_settings['wplc_show_avatar'] ){ $wplc_show_avatar = true; } else { $wplc_show_avatar = false; }
		if( isset($wplc_settings['wplc_show_date']) && $wplc_settings['wplc_show_date'] == '1' ){ $wplc_show_date = true; } else { $wplc_show_date = false; }
		if( isset($wplc_settings['wplc_show_time']) && $wplc_settings['wplc_show_time'] == '1' ){ $wplc_show_time = true; } else { $wplc_show_time = false; }

	 	$wplc_chat_detail = array( 'name' => $wplc_show_name, 'avatar' => $wplc_show_avatar, 'date' => $wplc_show_date, 'time' => $wplc_show_time );




	 	$wplc_end_point_override = get_option("wplc_end_point_override");
	    if($wplc_end_point_override !== false && $wplc_end_point_override !== ""){
	    	$bleeper_url = $wplc_end_point_override; //Use the override URL
	    } else {
	    	$bleeper_url = BLEEPER_NODE_SERVER_URL;
	    }




		wp_register_script('wplc-admin-js-sockets', "https://bleeper.io/app/assets/js/vendor/socket.io/socket.io.slim.js", false, $wplc_version, false);
		//wp_register_script('wplc-admin-js-sockets', trailingslashit( $bleeper_url ) . "socket.io/socket.io.js", false, $wplc_version, false);
		//wp_register_script('wplc-admin-js-sockets', "http://localhost:3000/socket.io/socket.io.js", false, $wplc_version, false);
		wp_enqueue_script('wplc-admin-js-sockets');

		wp_register_script('wplc-admin-js-bootstrap', "https://bleeper.io/app/assets/js/bootstrap.js", array("wplc-admin-js-sockets"), $wplc_version, false);
		wp_enqueue_script('wplc-admin-js-bootstrap');

		// NB: This causes Failed to initVars ReferenceError: wplc_show_date is not defined when uncommented and enabled
		if(empty($wplc_settings['wplc_disable_emojis']))
		{
			wp_register_script('wplc-admin-js-emoji', "https://bleeper.io/app/assets/wdt-emoji/emoji.min.js", array("wplc-admin-js-sockets"), $wplc_version, false);
			wp_enqueue_script('wplc-admin-js-emoji');

			wp_register_script('wplc-admin-js-emoji-bundle', "https://bleeper.io/app/assets/wdt-emoji/wdt-emoji-bundle.min.js", array("wplc-admin-js-emoji"), $wplc_version, false);
			wp_enqueue_script('wplc-admin-js-emoji-bundle');
		}

		wp_register_script('md5', plugins_url( '../js/md5.js', __FILE__ ), array("wplc-admin-js-sockets"), false, false);
    	wp_enqueue_script('md5');

		$dependencies = array();
		if(empty($wplc_settings['wplc_disable_emojis']))
			$dependencies[] = "wplc-admin-js-emoji-bundle";
		wp_register_script('wplc-admin-js-agent', "https://bleeper.io/app/assets/js/bleeper-agent-dev.js", $dependencies, $wplc_version, false);

		wp_localize_script('wplc-admin-js-agent', 'bleeper_remote_enabled', "true");

		if (isset($wplc_settings['wplc_enable_msg_sound'])) { 

			if (intval($wplc_settings['wplc_enable_msg_sound']) == 1) {
				wp_localize_script('wplc-admin-js-agent', "bleeper_ping_sound_notification_enabled", "true");
			} else {
				wp_localize_script('wplc-admin-js-agent', "bleeper_ping_sound_notification_enabled", "false");
			}

		}

		wp_register_script('my-wplc-admin-chatbox-ui-events', plugins_url('../js/wplc_u_admin_chatbox_ui_events.js', __FILE__), array('jquery'), $wplc_version, true);
		wp_enqueue_script('my-wplc-admin-chatbox-ui-events'); 
		


		$wplc_et_ajax_nonce = wp_create_nonce( "wplc_et_nonce" );
		wp_register_script( 'wplc_transcript_admin', plugins_url( '../js/wplc_transcript.js', __FILE__ ), null, '', true );
		$wplc_transcript_localizations = array(
			'ajax_nonce'          => $wplc_et_ajax_nonce,
			'string_loading'      => __( "Sending transcript...", "wplivechat" ),
			'string_title'        => __( "Sending Transcript", "wplivechat" ),
			'string_close'        => __( "Close", "wplivechat" ),
			'string_chat_emailed' => __( "The chat transcript has been emailed.", "wplivechat" ),
			'string_error1'       => sprintf( __( "There was a problem emailing the chat. Please <a target='_BLANK' href='%s'>contact support</a>.", "wplivechat" ), "http://wp-livechat.com/contact-us/?utm_source=plugin&utm_medium=link&utm_campaign=error_emailing_chat" )
		);
		wp_localize_script( 'wplc_transcript_admin', 'wplc_transcript_nonce', $wplc_transcript_localizations );
		wp_enqueue_script( 'wplc_transcript_admin' );

		$wplc_node_token = get_option("wplc_node_server_secret_token");
	    if(!$wplc_node_token){
	        if(function_exists("wplc_node_server_token_regenerate")){
	            wplc_node_server_token_regenerate();
	            $wplc_node_token = get_option("wplc_node_server_secret_token");
	        }
	    }

	    $form_data = array("node_token" => $wplc_node_token, "action" => "wordpress");
	    $form_data = apply_filters("wplc_admin_dashboard_layout_node_request_variable_filter", $form_data); //Filter for pro to add a few request variables to the mix for additional structure

		/*$options = array(
	        'http' => array(
	            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	            'method'  => 'POST',
	            'content' => http_build_query($form_data)
	        )
	    );
	    $context  = @stream_context_create($options);
	    $result = @file_get_contents(BLEEPER_API_URL . BLEEPER_REMOTE_DASH_ROUTE, false, $context);*/

	    wp_localize_script('wplc-admin-js-agent', 'bleeper_remote_form_data_array', $form_data);
	    wp_localize_script('wplc-admin-js-agent', 'bleeper_remote_form_api_url', BLEEPER_API_URL);
	    wp_localize_script('wplc-admin-js-agent', 'bleeper_remote_form_route', BLEEPER_REMOTE_DASH_ROUTE);


	    if ( isset( $_GET['page'] ) && $_GET['page'] === 'wplivechat-menu' ) {
			wp_localize_script('wplc-admin-js-agent', 'bleeper_in_dashboard', '1');
	    } else {
	    	wp_localize_script('wplc-admin-js-agent', 'bleeper_in_dashboard', '0');
	    }

	    $inline_error_message = "<div class='error below-h1' style='display:none;' id='bleeper_inline_connection_error'>
	                				<p>" . __("Connection Error", "wplivechat") . "<br /></p>
	                				<p>" . __("We are having some trouble contacting the server. Please try again later.", "wplivechat") . "</p>
	            				</div>";
	    wp_localize_script('wplc-admin-js-agent', 'bleeper_remote_form_error', $inline_error_message);





	    if (isset($wplc_settings['wplc_enable_visitor_sound']) && intval($wplc_settings['wplc_enable_visitor_sound']) == 1) {
	        wp_localize_script('wplc-admin-js-agent', 'bleeper_enable_visitor_sound', '1');
	    } else {
	        wp_localize_script('wplc-admin-js-agent', 'bleeper_enable_visitor_sound', '0');
	    }




		$agent_display_name = $user_info->display_name;

		wp_localize_script('wplc-admin-js-agent', 'agent_id', "" . $wplc_current_user);
		wp_localize_script('wplc-admin-js-agent', 'bleeper_agent_name', apply_filters("wplc_agent_display_name_filter", $agent_display_name) );
		wp_localize_script('wplc-admin-js-agent', 'nifty_api_key', get_option("wplc_node_server_secret_token"));

        //For node verification
        if(function_exists("wplc_pro_activate")){
            wp_localize_script('wplc-admin-js-agent', 'bleeper_pro_auth', get_option('wp-live-chat-support-pro_key', "false"));
        } else {
            wp_localize_script('wplc-admin-js-agent', 'bleeper_pro_auth', 'false');
        }
        wp_localize_script('wplc-admin-js-agent', 'bleeper_agent_verification_end_point', rest_url('wp_live_chat_support/v1/validate_agent'));
		wp_localize_script('wplc-admin-js-agent', 'bleeper_disable_mongo', "true");
		wp_localize_script('wplc-admin-js-agent', 'bleeper_disable_add_message', "true");
		wp_localize_script('wplc-admin-js-agent', 'wplc_nonce', wp_create_nonce("wplc"));
		wp_localize_script('wplc-admin-js-agent', 'wplc_cid', "null");
		wp_localize_script('wplc-admin-js-agent', 'wplc_chat_name', "null");
		//wp_localize_script('wplc-admin-js-agent', 'wplc_chat_email', "null"); //TODO: Parse the email

		wp_localize_script( 'wplc-admin-js-agent', 'wplc_show_chat_detail', $wplc_chat_detail );

		wp_localize_script('wplc-admin-js-agent', 'wplc_agent_data', $a_array);
		wp_localize_script('wplc-admin-js-agent', 'all_agents', $a_array);

		wp_localize_script('wplc-admin-js-agent', 'wplc_url', plugins_url( '', dirname( __FILE__ ) ) );

		if( isset($wplc_settings['wplc_settings_enabled']) && intval($wplc_settings["wplc_settings_enabled"]) == 2) {

            $wplc_disabled_html = __("Chat is disabled in settings area, re-enable", "wplivechat");
            $wplc_disabled_html .= " <a href='?page=wplivechat-menu-settings'>" . __("here", "wplivechat") . "</a>";

            wp_localize_script('wplc-admin-js-agent', 'wplc_disabled', 'true');
            wp_localize_script('wplc-admin-js-agent', 'wplc_disabled_html',  $wplc_disabled_html);
        }


		//Added rest nonces
        if(class_exists("WP_REST_Request")) {
            wp_localize_script('wplc-admin-js-agent', 'wplc_restapi_enabled', '1');
            wp_localize_script('wplc-admin-js-agent', 'wplc_restapi_token', get_option('wplc_api_secret_token'));
            wp_localize_script('wplc-admin-js-agent', 'wplc_restapi_endpoint', rest_url('wp_live_chat_support/v1'));
            wp_localize_script('wplc-admin-js-agent', 'bleeper_override_upload_url', rest_url('wp_live_chat_support/v1/remote_upload'));
            wp_localize_script('wplc-admin-js-agent', 'wplc_restapi_nonce', wp_create_nonce( 'wp_rest' ));

        } else {
            wp_localize_script('wplc-admin-js-agent', 'wplc_restapi_enabled', '0');
            wp_localize_script('wplc-admin-js-agent', 'wplc_restapi_nonce', "false");
        }

	    $agent_tagline = apply_filters( "wplc_filter_simple_agent_data_agent_tagline", '', get_current_user_id() );
        $agent_bio = apply_filters( "wplc_filter_simple_agent_data_agent_bio", '', '', get_current_user_id() );
        $social_links = apply_filters( "wplc_filter_simple_agent_data_social_links", '', get_current_user_id() );
        $head_data = array(
            'tagline' => $agent_tagline,
            'bio' => $agent_bio,
            'social' => $social_links
        );
        wp_localize_script( 'wplc-admin-js-agent', 'wplc_head_data', $head_data );
        wp_localize_script( 'wplc-admin-js-agent', 'wplc_user_chat_notification_prefix', __("User received notification:", "wplivechat") );

        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_valid_direct_to_page_array', wplc_node_pages_posts_array() );

        if( isset($wplc_settings['wplc_new_chat_ringer_count']) && $wplc_settings['wplc_new_chat_ringer_count'] !== "") {
            $wplc_ringer_count = intval($wplc_settings['wplc_new_chat_ringer_count']);
            wp_localize_script( 'wplc-admin-js-agent', 'bleeper_ringer_count', "" . $wplc_ringer_count );
        }

        
        $wplc_server_location = get_option( "wplc_server_location" );
        $wplc_server_location = apply_filters('wplc_node_server_default_selection_override', $wplc_server_location, $wplc_settings);
        
        if( $wplc_server_location !== false && $wplc_server_location !== "" && $wplc_server_location !== "auto" ){
        	if ( $wplc_server_location === "us1") { $wplc_server_location = "0"; }
        	else if ( $wplc_server_location === "us2") { $wplc_server_location = "3"; }
        	else if ( $wplc_server_location === "eu1") { $wplc_server_location = "1"; }
        	else if ( $wplc_server_location === "eu2") { $wplc_server_location = "2"; }
        	else { $wplc_server_location = "0"; }
        	wp_localize_script( 'wplc-admin-js-agent', 'bleeper_server_location', $wplc_server_location );
        }

        /* use the end point override as the final decision for identifying the actual end point override variable */
        $wplc_end_point_override = get_option("wplc_end_point_override");
        if($wplc_end_point_override !== false && $wplc_end_point_override !== ""){
        	wp_localize_script( 'wplc-admin-js-agent', 'bleeper_end_point_override', $wplc_end_point_override );
        }

        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_new_chat_notification_title', __('New chat received', 'wplivechat') );
        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_new_chat_notification_text', __("A new chat has been received. Please go the 'Live Chat' page to accept the chat", "wplivechat") );

		$wplc_notification_icon = plugin_dir_url(dirname(__FILE__)) . 'images/wplc_notification_icon.png';
        wp_localize_script( 'wplc-admin-js-agent', 'bleeper_new_chat_notification_icon', $wplc_notification_icon );

		do_action("wplc_admin_remoter_dashboard_scripts_localizer");  //For pro localization of agents list, and departments

		wp_enqueue_script('wplc-admin-js-agent');

		wp_register_script('wplc-admin-chat-server', plugins_url( '../js/wplc_server.js', __FILE__ ), array("wplc-admin-js-agent", "wplc-admin-js-sockets"), $wplc_version, false); //Added this for async storage calls
    	wp_enqueue_script('wplc-admin-chat-server');

		wp_localize_script( 'wplc-admin-chat-server', 'wplc_datetime_format', array(
			'date_format' => get_option( 'date_format' ),
			'time_format' => get_option( 'time_format' ),
		) );
		
		wp_register_script('wplc-admin-chat-events', plugins_url( '../js/wplc_u_admin_events.js', __FILE__ ), array("wplc-admin-js-agent", "wplc-admin-js-sockets", "wplc-admin-chat-server"), $wplc_version, false); //Added this for async storage calls
		wp_enqueue_script('wplc-admin-chat-events');
		
		if (isset($wplc_settings['wplc_show_date']) && $wplc_settings["wplc_show_date"] == '1') {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_date', 'true');
        } else {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_date', 'false');
		}

		if (isset($wplc_settings['wplc_show_time']) && $wplc_settings["wplc_show_time"] == '1') {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_time', 'true');
        } else {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_time', 'false');
		}

		if (isset($wplc_settings['wplc_show_name']) && $wplc_settings["wplc_show_name"] == '1') {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_name', 'true');
        } else {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_name', 'false');
		}

		if (isset($wplc_settings['wplc_show_avatar']) && $wplc_settings["wplc_show_avatar"] == '1') {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_avatar', 'true');
        } else {
			wp_localize_script('wplc-admin-chat-server', 'wplc_show_avatar', 'false');
		}
	}
}

add_action("wplc_admin_remoter_dashboard_scripts_localizer", "wplc_admin_remote_dashboard_localize_upselling_tips");
/*
 * Localizes an array of upselling tips
*/
function wplc_admin_remote_dashboard_localize_upselling_tips(){
	$tips_header = __("Did you know?", "wplivechat");

	$tips_array = array(
      "0" => "<p><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=unlimited_agents_tip' title='".__("Add unlimited agents", "wplivechat")."' target=\"_BLANK\">".__("Add unlimited agents", "wplivechat")."</a> ".__(" with the Pro add-on of WP Live Chat Support","wplivechat")." "."<a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=unlimited_agents_tip2' target='_BLANK'>".__("(once off payment).","wplivechat")."</a></p>",
      "1" => "<p>".__("With the Pro add-on of WP Live Chat Support, you can", "wplivechat")." <a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate_tip' title='".__("see who's online and initiate chats", "wplivechat")."' target=\"_BLANK\">".__("initiate chats", "wplivechat")."</a> ".__("with your online visitors with the click of a button.", "wplivechat")." <br /><br /><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate_tip2' title='".__("Buy the Pro add-on now (once off payment).", "wplivechat")."' target=\"_BLANK\"><strong>".__("Buy the Pro add-on now (once off payment).", "wplivechat")."</strong></a></p>",
  	  "2" => "<p><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=transfer_tip' title='".__("Transfer Chats", "wplivechat")."' target=\"_BLANK\">".__("Transfer Chats", "wplivechat")."</a> ".__(" with the Pro add-on of WP Live Chat Support","wplivechat")." "."<a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=transfer_tip2' target='_BLANK'>".__("(once off payment).","wplivechat")."</a></p>"
    );

	$tips_array = apply_filters("wplc_admin_remote_dashboard_localize_tips_array", $tips_array);

	wp_localize_script( 'wplc-admin-js-agent', 'agent_to_agent_chat_upsell', sprintf(__('Chat to other agents with the <a href="%s" target="_BLANK">Pro version</a>.' ,'wplivechat'),'https://wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=a2achat'));

	$initiate_upsell = "<i class='fa fa-horn'></i> ".__("With the Pro add-on of WP Live Chat Support, you can", "wplivechat");
  	$initiate_upsell .= ' <a href="https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate1" title="'.__("see who's online and initiate chats", "wplivechat").'" target=\"_BLANK\">';
  	$initiate_upsell .= __("initiate chats", "wplivechat");
  	$initiate_upsell .= '</a> '.__("with your online visitors with the click of a button.", "wplivechat");
  	$initiate_upsell .= ' <a href="https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate2" title="'.__("Buy the Pro add-on now.", "wplivechat").'" target=\"_BLANK\">';
    $initiate_upsell .= '<strong>'.__("Buy the Pro add-on now.", "wplivechat").'</strong></a>';



	wp_localize_script( 'wplc-admin-js-agent', 'initiate_chat_upsell', $initiate_upsell);


	wp_localize_script( 'wplc-admin-js-agent', 'wplc_event_upsell', sprintf( __( 'Get detailed visitor events with the <a target="_BLANK" href="%s">Pro version</a>.', 'wplivechat'), 'https://wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=pro_events' ) );

	wp_localize_script( 'wplc-admin-js-agent', 'wplc_tip_header', $tips_header );
	wp_localize_script( 'wplc-admin-js-agent', 'wplc_tip_array', $tips_array );

	if (!function_exists("wplc_pro_activate")) {
		/* identify if the user wants to display the agent to agent chat upsell */
		$wplc_current_user = get_current_user_id();
		$check = get_user_meta( $wplc_current_user, "wplc_a2a_upsell" );
        if ($check) {
            wp_localize_script( 'wplc-admin-js-agent', 'wplc_upsell_a2a', '1' );
        }

	}


}

/**
 * Loads remote dashboard styles
 *
 * @return void
*/
function wplc_admin_remote_dashboard_styles(){
    global $wplc_version;

    $wplc_settings = get_option("WPLC_SETTINGS");

    wp_register_style( 'wplc-admin-style', "https://bleeper.io/app/assets/css/chat_dashboard/admin_style.css", false, $wplc_version );
    wp_enqueue_style( 'wplc-admin-style' );

    if (!isset($wplc_settings['wplc_show_avatar']) || (isset($wplc_settings['wplc_show_avatar']) && intval($wplc_settings['wplc_show_avatar']) == 0) ) {
        wp_add_inline_style( 'wplc-admin-style', ".wplc-user-message, .wplc-admin-message { padding-left: 0 !important; }" );

        /*
        if(!isset($wplc_settings['wplc_show_name']) || (isset($wplc_settings['wplc_show_name']) && intval($wplc_settings['wplc_show_name']) == 0) ){
            //User is hiding both name and grav - add more inline styles

            $current_agent_info = wp_get_current_user();
            $current_agent_initial = "A"; //Default

            if(isset($current_agent_info->display_name)){
                $current_agent_initial = substr($current_agent_info->display_name, 0, 1);
            }


            $inline_identity_css =
                "
                .wplc-admin-message .messageBody::before {
                    display:inline-block; width: 15px; height: 15px; background:#333; content:'" . $current_agent_initial . "'; color:#fff; margin-right:10px; position:relative; top:px; text-align:center; font-size: 10px; border-radius:3px;
                }

                .wplc-user-message .messageBody::before {
                    display:inline-block; width: 15px; height: 15px; background:#2b97d2; content:'U'; color:#fff; margin-right:10px; position:relative; top:px; text-align:center; font-size: 10px; border-radius:3px;
                }
                ";

            wp_add_inline_style( 'wplc-admin-style', $inline_identity_css );
        }*/



    } else if( !isset($wplc_settings['wplc_show_name']) || (isset($wplc_settings['wplc_show_name']) && intval($wplc_settings['wplc_show_name']) == 0) ){
    	//User has enabled the gravatar, but has chosen to hide the user name.
    	//This causes some issues with admin display so let's just add some different styling to get around this
    	$inline_identity_css =
            "
            .wplc-admin-message-avatar, .wplc-user-message-avatar {
			    max-width:28px !important;
			    max-height:28px !important;
			}

			.wplc-admin-message, .wplc-user-message{
			    padding-left:25px !important;
			}

			.wplc-admin-message::before, .wplc-user-message::before  {
			    content: ' ';
			    width: 7px;
			    height: 7px;
			    background:#343434;
			    position: absolute;
			    left: 12px;
			    border-radius: 2px;
			    z-index: 1;
			}

			.wplc-user-message::before {
			    background:#2b97d2;
			}
            ";

        wp_add_inline_style( 'wplc-admin-style', $inline_identity_css );
    }

    wp_register_style( 'wplc-admin-style-bootstrap', "https://bleeper.io/app/assets/css/bootstrap.css", false, $wplc_version );
    wp_enqueue_style( 'wplc-admin-style-bootstrap' );

	if(empty($wplc_settings['wplc_disable_emojis']))
	{
		wp_register_style( 'wplc-admin-style-emoji', "https://bleeper.io/app/assets/wdt-emoji/wdt-emoji-bundle.css", false, $wplc_version );
		wp_enqueue_style( 'wplc-admin-style-emoji' );
	}
	
	do_action("wplc_admin_remote_dashboard_styles_hook");
}

add_action("wplc_admin_remote_dashboard_above", "wplc_limited_error_output");
/*
 * Outputs an error for limitations due to API key
*/
function wplc_limited_error_output(){
    if(function_exists("wplc_pro_activate")){
        echo "<p id='wplc_limited_container' class='update-nag' style='display:none;'>";
        echo     "<strong>" . __("Dear Pro User,", "wplivechat") . "</strong><br>";
        echo     __("Your API Key could not be validated, some functionality may be limited", "wplivechat");
        echo "</p>";
    }

    echo "<p id='wplc_agent_invalid_container' class='update-nag' style='display:none;'>";
    echo     __("You are not a verified agent, chat dashboard has been disabled", "wplivechat");
    echo "</p>";
}

/*
 * Add action for notice checks
*/
if ( ! function_exists( "wplc_active_chat_box_notices" ) ) {
	if(isset($_GET['page']) && $_GET['page'] === "wplivechat-menu"){
		add_action( "wplc_admin_remote_dashboard_above", "wplc_active_chat_box_notices" );
	}
}

add_action("wplc_admin_general_node_compat_check", "wplc_node_compat_version_check");
add_action("wplc_admin_remote_dashboard_above", "wplc_node_compat_version_check", 1);
/*
 * Checks if current Pro is compatible with node basic, if not, show notice, and localize scripts needed for conflict free execution
*/
function wplc_node_compat_version_check(){
    global $wplc_pro_version;
    $wplc_ver = str_replace('.', '', $wplc_pro_version);
    $checker = intval($wplc_ver);
    if (function_exists("wplc_pro_version_control") && $checker < 8000) {
         $wpc_ma_js_strings = array(
          'remove_agent' => __('Remove', 'wplivechat'),
          'nonce' => wp_create_nonce("wplc"),
          'user_id' => get_current_user_id(),
          'typing_string' => __('Typing...', 'wplivechat')

          );
          wp_localize_script('wplc-admin-js-agent', 'wplc_admin_strings', $wpc_ma_js_strings);

          if(isset($_GET['page']) && $_GET['page'] === "wplivechat-menu"){
          	wp_register_script('wplc-admin-force-offline-js', plugins_url('../js/wplc_node_offline_mode_controller.js', __FILE__), array('jquery'), '', true);
			wp_enqueue_script('wplc-admin-force-offline-js'); 
          }

          $is_dashboard = (isset($_GET['page']) && $_GET['page'] === "wplivechat-menu") ? true : false;
         ?>
            <div class="<?php echo ($is_dashboard ? "" : "update-nag"); ?>" id="wplc_offline_mode_prompt_container" style='margin-top:5px;margin-bottom:5px;<?php echo ($is_dashboard ? "display:none; " : ""); ?>'>
            	<div style="display: inline-block; width: 80px; position: absolute; padding-top: 1em;">
            		<img src="https://bleeper.io/app/assets/images/wplc_loading.png" />
            	</div>
            	<div style="display: inline-block; margin-left: 80px;">
	                <p style="display: none;"><strong id="wplc_offline_mode_prompt"><?php _e("WP Live Chat Support - Offline Mode", "wplivechat") ?></strong></p>
	                <?php echo wplc_node_compat_pro_update_nag_content(); ?>
	            </div>
            </div>
        <?php
    }
}

/*
 * Checks if the users Pro API key is expired - this will only be called if pro is active and is less than V8
 *   true -> Show link to my account page
 *   false -> Show link to update page
*/
function wplc_node_compat_pro_update_nag_content(){
	$html_out = "<p id='wplc_offline_mode_reason'>";
	
	$is_pro_valid = wplc_node_compat_pro_api_key_is_valid_post();

	if($is_pro_valid){
		$html_out .= sprintf(__("Chat is now in offline mode, please <a href='%s' target='_BLANK'>upgrade to Version 8</a> (or above) of the WP Live Chat Support Pro Add-on to ensure all functionality works as expected.", "wplivechat"), "update-core.php");
	} else {
		$html_out .= sprintf(__("Chat is now in offline mode, please renew your API key by visiting the <a href='%s' target='_BLANK'>My Account</a> area, and receive updates.", "wplivechat"), "https://wp-livechat.com/my-account");
	}

	$html_out .= "</p>";

	$html_out .= "<p>";
	$html_out .= __("Alternatively, please disable the node server option in the Live Chat settings area (Live Chat -> Settings -> Advanced Features)", "wplivechat");
	$html_out .= "</p>";

	if($is_pro_valid){
		$html_out .= "<a href='update-core.php' class='button button-primary' target='_BLANK'>" . __("Upgrade", "wplivechat") . "</a>"; 
	} else {
		$html_out .= "<a href='update-core.php' class='button button-primary' target='_BLANK'>" . __("Renew License", "wplivechat") . "</a>"; 
	}

	if(!isset($_GET['page']) || $_GET['page'] !== "wplivechat-menu-settings"){
		$html_out .= " <a href='?page=wplivechat-menu-settings#tabs-beta' class='button' target='_BLANK'>" . __("Settings", "wplivechat") . "</a>";
	}

	$html_out .= " <a href='?page=wplivechat-menu&action=welcome' class='button' target='_BLANK'>" . __("Whats new in Version 8", "wplivechat") . "</a>";

	return $html_out;

}

/*
 * Checks if the Pro API key is valid or not
 * Returns true or false
*/
function wplc_node_compat_pro_api_key_is_valid_post(){
	$wplc_pro_validation_url = "http://ccplugins.co/api-control/";
	$wplc_pro_option_key = "wp-live-chat-support-pro_key"; 
	$wplc_pro_slug = "wp-live-chat-support-pro";
	$is_valid = false; //By default it is false
	if (get_option($wplc_pro_option_key)) {
        $args = array(
            'slug' => $wplc_pro_slug,
        );
        $data_array = array(
            'method' => 'POST',
            'body' => array(
                'action' => 'api_validation',
                'd' => get_option('siteurl'),
                'request' => serialize($args),
                'api_key' => get_option($wplc_pro_option_key)
        ));
        $response = wp_remote_post($wplc_pro_validation_url, $data_array);
        if (is_array($response)) {
            if ( $response['response']['code'] == "200" ) {
                $data = $response['body'];
                $data = unserialize($data);

                if(isset($data['status']) && $data['status'] === "OK"){
                	$is_valid = true;
                }
            }
        }
            
    }

    return $is_valid;
}

add_filter("wplc_loggedin_filter","wplc_node_compat_version_disable_chat",99,1);
/*
 * Checks if user is using out-date pro with node server, if so, disable chat on front end
*/
function wplc_node_compat_version_disable_chat($logged_in) {
    global $wplc_pro_version;
    $wplc_settings = get_option("WPLC_SETTINGS");
    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
        $wplc_ver = str_replace('.', '', $wplc_pro_version);
        $checker = intval($wplc_ver);
        if (function_exists("wplc_pro_version_control") && $checker < 8000) {
            return false; //Force chat offline
        }
    }
    return $logged_in;
}

add_action("admin_notices", "wplc_node_v8_plus_notice_dismissable");
/*
 * Displays an admin notice (which can be dismissed), to notify any V8+ users of the node option (if not already checked)
*/
function wplc_node_v8_plus_notice_dismissable(){
    if(isset($_GET['page']) && strpos($_GET['page'], 'wplivechat') !== FALSE){
        if(isset($_GET['wplc_dismiss_notice_v8']) && $_GET['wplc_dismiss_notice_v8'] === "true"){
            update_option("wplc_node_v8_plus_notice_dismissed", 'true');
        }

        $wplc_settings = get_option("WPLC_SETTINGS");
        if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
            //Do Nothing
        } else {
            //User is not on node, let's check if they have seen this notice before, if not, let's show a notice
            $wplc_has_notice_been_dismissed = get_option("wplc_node_v8_plus_notice_dismissed", false);
            if($wplc_has_notice_been_dismissed === false){
                //Has not been dismissed
                $output = "<div class='notice notice-warning' style='border-color: #0180bc;'>";
                $output .=     "<p><strong>" . __( 'Welcome to V8 of WP Live Chat Support', 'wplivechat' ) . "</strong></p>";
                $output .=  "<p>" . __('Did you know, this version features high speed message delivery, agent to agent chat, and a single window layout?', 'wplivechat') . "</p>";
                $output .=  "<p>" . __('To activate this functionality please navigate to Live Chat -> Settings -> Advanced Features -> And enable our Chat Server option.', 'wplivechat') . "</p>";

                $output .=  "<p>";
                $output .=    "<a href='?page=wplivechat-menu-settings#tabs-beta' class='button button-primary'>" . __("Show me!", "wplivechat") . "</a> ";
                $output .=    "<a href='?page=".$_GET['page']."&wplc_dismiss_notice_v8=true' id='wplc_v8_dismiss_node_notice' class='button'>" . __("Don't Show This Again", "wplivechat") . "</a>";
                $output .=  "</p>";

                $output .= "</div>";

                echo $output;
            }
        }
    }
}

add_filter("wplc_activate_default_settings_array", "wplc_node_set_default_settings", 10, 1);
/*
 * Adds default node setting to the default settings array
*/
function wplc_node_set_default_settings($wplc_default_settings_array){
    if(is_array($wplc_default_settings_array)){
        if(!isset($wplc_default_settings_array['wplc_use_node_server'])){
            //Is not set already
            $wplc_default_settings_array['wplc_use_node_server'] = 1;
        }
    }
    return $wplc_default_settings_array;
}

add_filter( 'rest_url', 'wplc_node_rest_url_ssl_fix');
/**
 * Changes the REST URL to include the SSL version if we are using SSL
 * See https://core.trac.wordpress.org/ticket/36451
 */
function wplc_node_rest_url_ssl_fix($url){
        if (is_ssl()){
            $url = set_url_scheme( $url, 'https' );
            return $url;
        }
        return $url;
}

/**
 * Returns an array of pages/posts available on the site
*/
function wplc_node_pages_posts_array(){
    $r = array(
        'depth' 	=> 0,
        'child_of' 	=> 0,
        'echo' 		=> false,
        'id' 		=> '',
        'class' 	=> '',
        'show_option_none' 		=> '',
        'show_option_no_change' => '',
        'option_none_value' 	=> '',
        'value_field' 			=> 'ID',
    );

 	$pages = get_pages($r);
 	$posts = get_posts(array('posts_per_page' => -1));

 	$posts_pages = array_merge($pages,$posts);

 	$return_array = array();

 	foreach ($posts_pages as $key => $value) {
 		$post_page_id = $value->ID;
 		$post_page_title = $value->post_title;

 		$return_array[get_permalink($post_page_id)] = $post_page_title;
 	}

 	return $return_array;
 }



 add_action("init","wplc_node_cloud_server_integration_hook_handler");
/**
 * V8 Cloud Action & Filter Handlers
*/
function wplc_node_cloud_server_integration_hook_handler() {
    $wplc_settings = get_option("WPLC_SETTINGS");
    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
        if(function_exists("wplc_cloud_load_updates")){
            remove_action("init","wplc_cloud_load_updates");
            remove_action("wplc_hook_chat_dashboard_above","wplc_cloud_1_hook_chat_dashboard_above");
            remove_action("wplc_hook_admin_chatbox_javascript","wplc_cloud_hook_control_push_js_to_admin", 10);
            remove_action("wplc_hook_push_js_to_front","wplc_cloud_hook_control_push_js_to_front", 10);
            remove_action("wplc_hook_chat_history","wplc_cloud_hook_control_chat_history", 1);
            remove_action("wplc_hook_chat_missed","wplc_cloud_hook_control_chat_missed", 1);
            remove_action("wplc_hook_initiate_check","wplc_cloud_hook_control_intiate_check", 1);
            remove_action("wplc_hook_history_draw_area","wplc_cloud_hook_control_history_draw_area", 1);
            remove_action("wplc_hook_change_status_on_answer","wplc_cloud_hook_control_change_status_on_answer", 1);
            remove_action("wplc_hook_update_agent_id","wplc_cloud_hook_control_update_agent_id", 1);
            remove_action('wplc_hook_accept_chat_url' , 'wplc_cloud_hook_control_accept_chat_url', 1);
            remove_action("wplc_hook_ma_check_if_answered_by_another_agent","wplc_cloud_hook_check_if_answered_by_another_agent", 1);
            remove_action("wplc_hook_settings_page_more_tabs","wplc_cloud_hook_control_settings_page_more_tabs");
            remove_action("init","wplc_cloud_first_run_check");
            remove_action('wplc_hook_admin_settings_save','wplc_cloud_save_settings');
            remove_action("wplc_api_route_hook", "wplc_api_node_routes_cloud", 1);
            remove_action('http_api_curl', 'wplc_cloud_http_api_curl', 100);
            remove_action("init", "wplc_cloud_additional_hooks", 1);

            remove_filter("wplc_filter_get_chat_messages","wplc_cloud_filter_control_chat_messages",10);
            remove_filter("wplc_filter_get_chat_data","wplc_cloud_filter_control_chat_data",1);
            remove_filter("wplc_filter_chat_area_data","wplc_cloud_filter_control_chat_area_data",10);
            remove_filter("wplc_rating_data_filter","wplc_cloud_filter_control_get_rating_data",1);
            remove_filter("wplc_filter_admin_javascript","wplc_cloud_filter_control_admin_javascript");
            remove_filter("wplc_start_chat_user_form_after_filter", "wplc_start_chat_user_form_after_filter_remove_departments_cloud",2);
            remove_filter("wplc_after_chat_visitor_count_hook", "wplc_admin_cloud_remove_departments_chat_area_before_end_chat_button",2);
            remove_filter("wplc_admin_chat_area_before_end_chat_button", "wplc_admin_cloud_remove_transfer_button_chat_area_before_end_chat_button",2);
            remove_filter("wplc_filter_front_js_extra_data","wplc_cloud_filter_control_front_js_extra_data",10);
            remove_filter("wplc_filter_ajax_url","wplc_cloud_filter_control_ajax_url",10);
            remove_filter("wplc_filter_setting_tabs","wplc_cloud_filter_control_setting_tabs");
            remove_filter("wplc_filter_menu_api","wplc_cloud_filter_control_menu_api",1);
            remove_filter('http_request_args', 'wplc_cloud_http_request_args',100);
        }
    }
}

add_action("init","wplc_node_mobile_integration_hook_handler");
/**
 * V8 Mobile/Desktop Extension Action & Filter Handlers
*/
function wplc_node_mobile_integration_hook_handler() {
    $wplc_settings = get_option("WPLC_SETTINGS");
    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
        if(function_exists("wplc_md_load_updates")){
            remove_action("init","wplc_md_load_updates");
            remove_action("wplc_hook_settings_page_more_tabs","wplc_mobile_hook_control_settings_page_more_tabs");
            remove_action("init","wplc_mobile_first_run_check");
            remove_action('wplc_hook_admin_settings_save','wplc_mobile_save_settings');

            remove_filter("wplc_filter_is_admin_logged_in","wplc_mobile_check_if_logged_in",10);
            remove_filter("wplc_filter_setting_tabs","wplc_mobile_filter_control_setting_tabs");
            remove_filter("wplc_filter_menu_api","wplc_mobile_filter_control_menu_api");
        }
    }
}


add_action("wplc_admin_remoter_dashboard_scripts_localizer", "wplc_admin_remote_dashboard_dynamic_translation_handler");
/*
 * Localizes an array of strings and ids in the dashboard which need to be replaced
 * Loads the custom JS file responsible for replacing the content dynamically.
*/
function wplc_admin_remote_dashboard_dynamic_translation_handler(){

	global $wplc_version;
    wp_register_script('wplc-admin-dynamic-translation', plugins_url( '../js/wplc_admin_dynamic_translations.js', __FILE__ ), array("wplc-admin-js-agent", "wplc-admin-js-sockets", "jquery"), $wplc_version, false); //Added this for async storage calls

    $wplc_dynamic_translation_array = array(
      'nifty_bg_holder_text_inner' => __('Connecting...', 'wplivechat'),
      'nifty_admin_chat_prompt_title' => __('Please Confirm', 'wplivechat'),
      'nifty_admin_chat_prompt_confirm' => __('Confirm', 'wplivechat'),
      'nifty_admin_chat_prompt_cancel' => __('Cancel', 'wplivechat'),
      'active_count_string' => __(' Active visitors', 'wplivechat'),
      'wplc-agent-info' => __('Agent(s) Online', 'wplivechat'),
      'wplc_history_link' => __('Chat History', 'wplivechat'),
      'nifty_agent_heading' => __('Agents', 'wplivechat'),
      'drag_zone_inner_text' => __('Drag Files Here', 'wplivechat'),
      'chatTransferLink' => __('Transfer', 'wplivechat'),
      'chatTransferDepLink' => __('Department Transfer', 'wplivechat'),
      'chatDirectUserToPageLink' => __('Direct User To Page', 'wplivechat'),
      'chatCloseTitle' => __('Leave chat', 'wplivechat'),
      'chatEndTitle' => __('End chat', 'wplivechat'),
      'chatTransferUps' => __('Transfer', 'wplivechat'),
      'chatDirectUserToPageUps' => __('Direct User To Page', 'wplivechat'),
      'nifty_event_heading' => __('Events', 'wplivechat'),
      'nifty_join_chat_button' => __('Join chat', 'wplivechat'),
      'nifty_filter_button' => __('Filters', 'wplivechat'),
      'nifty_new_visitor_item' => __('New Visitors (3 Min)', 'wplivechat'),
      'nifty_active_chats_item' => __('Active Chats', 'wplivechat'),
      'nifty_clear_filters_item' => __('Clear Filters', 'wplivechat'),
      'nifty_active_chats_heading' => __('Active visitors', 'wplivechat'),
      'nifty_vis_col_heading' => __('Visitor', 'wplivechat'),
      'nifty_vis_info_heading' => __('Info', 'wplivechat'),
      'nifty_vis_page_heading' => __('Page', 'wplivechat'),
      'nifty_vis_status_heading' => __('Chat Status', 'wplivechat'),
      'nifty_vis_dep_heading' => __('Department', 'wplivechat'),
      'wdt-emoji-search-result-title' => __('Search Results', 'wplivechat'),
      'wdt-emoji-no-result' => __('No emoji found', 'wplivechat')
    );

    apply_filters("wplc_adming_dynamic_translation_filter", $wplc_dynamic_translation_array);


    wp_localize_script('wplc-admin-dynamic-translation', 'wplc_dynamic_translation_array', $wplc_dynamic_translation_array);
    wp_enqueue_script('wplc-admin-dynamic-translation');

}