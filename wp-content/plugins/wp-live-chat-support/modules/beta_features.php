<?php
/*
 * Adds beta/opt-on options
*/

add_filter("wplc_filter_setting_tabs","wplc_beta_settings_tab_heading");
/**
 * Adds 'Beta Features' tab to settings area
*/
function wplc_beta_settings_tab_heading($tab_array) {
    $tab_array['beta'] = array(
      "href" => "#tabs-beta",
      "icon" => 'fa fa-bolt',
      "label" => __("Advanced Features","wplivechat")
    );
    return $tab_array;
}


add_action("wplc_hook_settings_page_more_tabs","wplc_beta_settings_tab_content");
/**
 * Adds 'Beta Features' content to settings area
*/
function wplc_beta_settings_tab_content() {
 $wplc_settings = get_option("WPLC_SETTINGS");
 if(isset($_GET['wplc_action']) && $_GET['wplc_action'] === "node_server_new_token"){
    if(function_exists("wplc_node_server_token_regenerate")){
       wplc_node_server_token_regenerate();
    }
 }
 $wplc_node_token = get_option("wplc_node_server_secret_token");
 if(!$wplc_node_token){
   $wplc_node_token = __("No token found", "wplivechat") . "...";
 }
 $wplc_end_point_override = get_option("wplc_end_point_override");
 $wplc_end_point_override = $wplc_end_point_override === false ? "" : $wplc_end_point_override;
 $wplc_server_location = get_option("wplc_server_location");
 $wplc_server_location = $wplc_server_location === false ? "auto" : $wplc_server_location;

 $wplc_us_servers_enabled = apply_filters('wplc_node_server_us_options_enabled', true, $wplc_settings);
 $wplc_server_location = apply_filters('wplc_node_server_default_selection_override', $wplc_server_location, $wplc_settings);
 
 $wplc_new_chat_ringer_count = 5;
 if(isset($wplc_settings['wplc_new_chat_ringer_count'])){
    $wplc_new_chat_ringer_count = intval($wplc_settings['wplc_new_chat_ringer_count']);
 }
 ?>
   <div id="tabs-beta">
     <h4><?php _e("Chat Server", "wplivechat") ?></h4>
     <?php 
      /*if (function_exists("wplc_cloud_load_updates")) { echo "<p><span class='update-nag'>".__('The node server cannot be activated while using the Cloud extension as they are not compatible. Please deactivate the cloud extension to make use of the new Node server.','wplivechat')."</span></p>"; } */
      do_action("wplc_admin_general_node_compat_check");
      ?>
     <table class="wp-list-table wplc_list_table widefat fixed striped pages">
       <tbody>
         <tr>
           <td width="250" valign="top">
             <label for="wplc_use_node_server"><?php _e("Use our server to handle chats","wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Disabling this will result in the plugin reverting back to using the legacy chat dashboard.', 'wplivechat'); ?>"></i></label>
           </td>
           <td valign="top">
             <input type="checkbox" value="1" name="wplc_use_node_server" <?php /*if (function_exists("wplc_cloud_load_updates")) { echo 'disabled="disabled" readonly="readonly"'; } */ ?> <?php if (isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == '1') { echo "checked"; } ?>> 
             <small><em><?php _e("Disabling this will revert the chat dashboard back to the legacy version.", "wplivechat"); ?></em></small>
           </td>
         </tr>
         <tr>
           <td width="250" valign="top">
             <label for="wplc_server_location"><?php _e("Server location","wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Select a server location that is near to you.', 'wplivechat'); ?>"></i></label>
           </td>
           <td valign="top">
             <select name='wplc_server_location'>
              <?php if($wplc_us_servers_enabled === true || $wplc_us_servers_enabled === 'true') { ?>
                <option value='auto' <?php if (isset($wplc_server_location) && $wplc_server_location === "auto") { echo "selected"; } ?>><?php _e("Automatic (suggested)"); ?></option>
                <option value='us1' <?php if (isset($wplc_server_location) && $wplc_server_location === "us1") { echo "selected"; } ?>><?php echo sprintf(__("United States - %s","wplivechat"), "#1"); ?></option>
                <option value='us2' <?php if (isset($wplc_server_location) && $wplc_server_location === "us2") { echo "selected"; } ?>><?php echo sprintf(__("United States - %s","wplivechat"), "#2"); ?></option>
              <?php } ?>

              <option value='eu1' <?php if (isset($wplc_server_location) && $wplc_server_location === "eu1") { echo "selected"; } ?>><?php echo sprintf(__("Europe - %s","wplivechat"), "#1"); ?></option>
              <option value='eu2' <?php if (isset($wplc_server_location) && $wplc_server_location === "eu2") { echo "selected"; } ?>><?php echo sprintf(__("Europe - %s","wplivechat"), "#2"); ?></option>
            </select>
            <?php do_action('wplc_node_server_selection_notices', $wplc_settings); ?>
           </td>
         </tr>
         <tr>
           <td width="250" valign="top">
             <label for="wplc_use_node_server"><?php _e("Chat server token","wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Security token for accessing chats on the node server. Changing this will remove current chats', 'wplivechat'); ?>"></i></label>
           </td>
           <td valign="top">
             <input type="text" value="<?php echo $wplc_node_token; ?>" id="wplc_node_token_input" name="wplc_node_token_input">
             <a class="button button-secondary" href="?page=wplivechat-menu-settings&wplc_action=node_server_new_token"><?php _e("Generate New", "wplivechat"); ?></a>
             <a class="button button-secondary" id='wplc_copy_code_btn' onclick=""><?php _e("Copy", "wplivechat"); ?></a>
           </td>
         </tr>
         <tr>
           <td width="250" valign="top">
             <label for="wplc_end_point_override"><?php _e("Server end point override","wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Do not change this unless advised to do so by a WP Live Chat Support representative', 'wplivechat'); ?>"></i></label>
           </td>
           <td valign="top">
             <input type="text" value="<?php echo $wplc_end_point_override; ?>" id="wplc_end_point_override" name="wplc_end_point_override" placeholder="<?php _e('Leave empty unless advised by a WP Live Chat Support representative', 'wplivechat'); ?>">
           </td>
         </tr>
         <?php do_action("wplc_hook_beta_options_content_inside_table"); ?>
         <tr>
           <td width="250" valign="top">
             <label for="wplc_new_chat_ringer_count"><?php _e("Limit chat ring amount","wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Limit the amount of time the new chat ringer will play', 'wplivechat'); ?>"></i></label>
           </td>
           <td valign="top">
             <input type="number" value="<?php echo $wplc_new_chat_ringer_count; ?>" id="wplc_new_chat_ringer_count" name="wplc_new_chat_ringer_count">
           </td>
         </tr>
         <tr>
           <td width="250" valign="top"></td>
           <td valign="top">
             <span class='update-nag' style='margin-top:0; font-size:12px; border-color: #0180bc ;'><strong><?php _e("Did you know?", "wplivechat"); ?></strong><br> <?php _e('You can copy this node server token to multiple sites in order to manage more than one domain from a single chat dashboard','wplivechat'); ?></span>
           </td>
         </tr>
       </tbody>
     </table>
     <script>
         jQuery(function(){
           jQuery("#wplc_copy_code_btn").click(function(){
             
             jQuery("#wplc_node_token_input").select();
             document.execCommand("copy");
             jQuery("#wplc_node_token_input").blur();
             jQuery(this).html("<i class='fa fa-check'></i>");
           });
         });
     </script>
 <?php
 do_action("wplc_hook_beta_options_content");
 ?>
 </div>
 <?php
}
add_filter("wplc_settings_save_filter_hook", "wplc_beta_settings_save_hooked", 10, 1);
/**
 * Save 'Beta Features' settings
*/
function wplc_beta_settings_save_hooked($wplc_data){
  
  if (isset($_POST['wplc_use_node_server'])) { $wplc_data['wplc_use_node_server'] = esc_attr($_POST['wplc_use_node_server']); }

  if (isset($_POST['wplc_node_token_input'])) { 
    $wplc_node_new_token = esc_attr($_POST['wplc_node_token_input']); 
    update_option("wplc_node_server_secret_token", $wplc_node_new_token);
  }

  if (isset($_POST['wplc_end_point_override'])) { 
    update_option("wplc_end_point_override", esc_attr($_POST['wplc_end_point_override']));
  }
  if (isset($_POST['wplc_server_location'])) { 
    update_option("wplc_server_location", esc_attr($_POST['wplc_server_location']));
  }

  if (isset($_POST['wplc_new_chat_ringer_count'])) { 
    $wplc_data['wplc_new_chat_ringer_count'] = intval($_POST['wplc_new_chat_ringer_count']); 
  }
  return $wplc_data;
}

add_filter("wplc_filter_inner_live_chat_box_4th_layer", "wplc_add_end_chat_button_to_chat_box", 10, 2);
/**
 * Adds an end chat button to the front end of the site
*/
function wplc_add_end_chat_button_to_chat_box($content, $wplc_settings){
  $custom_attr = apply_filters('wplc_end_button_custom_attributes_filter', "", $wplc_settings);
  $text = __("End Chat", "wplivechat");
  $html = "<button id=\"wplc_end_chat_button\" type=\"button\" $custom_attr>$text</button>";

  return $content . $html;
}