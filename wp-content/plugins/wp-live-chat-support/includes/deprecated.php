<?php
/* will soon become deprecated */
function wplc_output_box_ajax() {

    
    if(function_exists('wplc_display_chat_contents')){
        $display_contents = wplc_display_chat_contents();
    } else {
        $display_contents = 1;
    }

    if(function_exists('wplc_is_user_banned')){
        $user_banned = wplc_is_user_banned();
    } else if (function_exists('wplc_is_user_banned')){
        $user_banned = wplc_is_user_banned_basic();
    } else {
        $user_banned = 0;
    }
    if($display_contents && $user_banned == 0){  
       

        /* do not show if pro is outdated */
        global $wplc_pro_version;
        if (isset($wplc_pro_version)) {
            $float_version = floatval($wplc_pro_version);
            if ($float_version < 4 || $wplc_pro_version == "4.1.0" || $wplc_pro_version == "4.1.1") {
                return "";
            }
        }

        if (function_exists("wplc_register_pro_version")) {
            $wplc_settings = get_option("WPLC_SETTINGS");
            if (!class_exists('Mobile_Detect')) {
                require_once (plugin_dir_path(__FILE__) . 'Mobile_Detect.php');
            }
            $wplc_detect_device = new Mobile_Detect;
            $wplc_is_mobile = $wplc_detect_device->isMobile();
            if ($wplc_is_mobile && !isset($wplc_settings['wplc_enabled_on_mobile']) && $wplc_settings['wplc_enabled_on_mobile'] != 1) {
                return "";
            }
            if (function_exists('wplc_hide_chat_when_offline')) {
                $wplc_hide_chat = wplc_hide_chat_when_offline();
                if (!$wplc_hide_chat) {
                    $draw_box = true;
                }
            } else {
                $draw_box = true;
            }
        } else {
            $draw_box = true;
        }
    }



    if ($draw_box) {
        $wplc_class = "";
        $ret_msg = "";
        $wplc_settings = get_option("WPLC_SETTINGS");

        if ($wplc_settings["wplc_settings_enabled"] == 2) {
            return;
        }

        if ($wplc_settings["wplc_settings_align"] == 1) {
            $original_pos = "bottom_left";
            //$wplc_box_align = "left:100px; bottom:0px;";
            $wplc_box_align = "bottom:0px;";
        } else if ($wplc_settings["wplc_settings_align"] == 2) {
            $original_pos = "bottom_right";
            //$wplc_box_align = "right:100px; bottom:0px;";
            $wplc_box_align = "bottom:0px;";
        } else if ($wplc_settings["wplc_settings_align"] == 3) {
            $original_pos = "left";
    //        $wplc_box_align = "left:0; bottom:100px;";
            $wplc_box_align = " bottom:100px;";
            $wplc_class = "wplc_left";
        } else if ($wplc_settings["wplc_settings_align"] == 4) {
            $original_pos = "right";
    //        $wplc_box_align = "right:0; bottom:100px;";
            $wplc_box_align = "bottom:100px;";
            $wplc_class = "wplc_right";
        }
        
        if (isset($wplc_settings["wplc_settings_fill"])) {
            $wplc_settings_fill = "#" . $wplc_settings["wplc_settings_fill"];
        } else {
            $wplc_settings_fill = "#ed832f";
        }
        if (isset($wplc_settings["wplc_settings_font"])) {
            $wplc_settings_font = "#" . $wplc_settings["wplc_settings_font"];
        } else {
            $wplc_settings_font = "#FFFFFF";
        }

        $wplc_is_admin_logged_in = get_transient("wplc_is_admin_logged_in");
        if (!function_exists("wplc_register_pro_version") && $wplc_is_admin_logged_in != 1) {
            $ret_msg = "";
        }
        
        if(function_exists('wplc_pro_activate')){
            if(function_exists('wplc_return_animations')){
                
                $animations = wplc_return_animations();
                
                isset($animations['animation']) ? $wplc_animation = $animations['animation'] : $wplc_animation = 'animation-4';
                isset($animations['starting_point']) ? $wplc_starting_point = $animations['starting_point'] : $wplc_starting_point = 'display: none;';
                isset($animations['box_align']) ? $wplc_box_align = $animations['box_align'] : $wplc_box_align = '';

            } else {
                
            }
        } else {
            
            $wplc_starting_point = '';
            $wplc_animation = '';
            
            if ($wplc_settings["wplc_settings_align"] == 1) {
                $original_pos = "bottom_left";
                $wplc_box_align = "left:100px; bottom:0px;";
            } else if ($wplc_settings["wplc_settings_align"] == 2) {
                $original_pos = "bottom_right";
                $wplc_box_align = "right:100px; bottom:0px;";
            } else if ($wplc_settings["wplc_settings_align"] == 3) {
                $original_pos = "left";
                $wplc_box_align = "left:0; bottom:100px;";
                $wplc_class = "wplc_left";
            } else if ($wplc_settings["wplc_settings_align"] == 4) {
                $original_pos = "right";
                $wplc_box_align = "right:0; bottom:100px;";
                $wplc_class = "wplc_right";
            }

        }
        
        if (isset($wplc_settings['wplc_auto_pop_up'])) { $wplc_auto_popup = $wplc_settings['wplc_auto_pop_up']; } else { $wplc_auto_popup = "" ;}
        $ret_msg .= "<div id=\"wp-live-chat\" wplc_animation=\"".$wplc_animation."\" style=\"".$wplc_starting_point." ".$wplc_box_align.";\" class=\"".$wplc_class." wplc_close\" original_pos=\"".$original_pos."\" wplc-auto-pop-up=\"". $wplc_auto_popup."\" > ";
      
            if (function_exists("wplc_pro_output_box_ajax")) {
                 $ret_msg .= wplc_pro_output_box_ajax();
            } else {
                
                $ret_msg .= "<div class=\"wp-live-chat-wraper\">";
                $ret_msg .= "<div id=\"wp-live-chat-header\" style=\"background-color: ".$wplc_settings_fill." !important; color: ".$wplc_settings_font." !important; \">";
                $ret_msg .= "<i id=\"wp-live-chat-minimize\" class=\"fa fa-minus\" style=\"display:none;\" ></i>";
       
                $ret_msg .= "<i id=\"wp-live-chat-close\" class=\"fa fa-times\" style=\"display:none;\" ></i>";

                $ret_msg .= " <div id=\"wp-live-chat-1\" >";
                $ret_msg .= "<div style=\"display:block; \">";
                $ret_msg .= "<strong>".__("Questions?", "wplivechat")."</strong> ".__("Chat with us", "wplivechat");
                $ret_msg .= "</div>";
                $ret_msg .= "</div>";
                $ret_msg .= "</div>";

                $ret_msg .= "<div id=\"wp-live-chat-2\" style=\"display:none;\">";
                $ret_msg .= "<div id=\"wp-live-chat-2-info\">";
                $ret_msg .= "<strong>".__('Start Live Chat', 'wplivechat')."</strong>";
                $ret_msg .= "</div>";
                        
                        if (isset($wplc_settings['wplc_loggedin_user_info']) && $wplc_settings['wplc_loggedin_user_info'] == 1) {
                            $wplc_use_loggedin_user_details = 1;
                        } else {
                            $wplc_use_loggedin_user_details = 0;
                        }

                        $wplc_loggedin_user_name = "";
                        $wplc_loggedin_user_email = "";

                        if ($wplc_use_loggedin_user_details == 1) {
                            global $current_user;

                            if ($current_user->data != null) {
                                //Logged in. Get name and email
                                $wplc_loggedin_user_name = $current_user->user_nicename;
                                $wplc_loggedin_user_email = $current_user->user_email;
                            }
                        } else {
                            $wplc_loggedin_user_name = '';
                            $wplc_loggedin_user_email = '';
                        }

                        if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 1) {
                            $wplc_ask_user_details = 1;
                        } else {
                            $wplc_ask_user_details = 0;
                        }

                        if ($wplc_ask_user_details == 1) {
                            //Ask the user to enter name and email
                   
                            $ret_msg .= "<input type=\"text\" name=\"wplc_name\" id=\"wplc_name\" value='".$wplc_loggedin_user_name."' placeholder=\"".__("Name", "wplivechat")."\" />";
                            $ret_msg .= "<input type=\"text\" name=\"wplc_email\" id=\"wplc_email\" wplc_hide=\"0\" value=\"".$wplc_loggedin_user_email."\" placeholder=\"".__("Email", "wplivechat")."\"  />";
                        } else {
                            //Dont ask the user
                            $ret_msg .= "<div style=\"padding: 7px; text-align: center;\">";
                            if (isset($wplc_settings['wplc_user_alternative_text'])) {
                                $ret_msg .= stripslashes($wplc_settings['wplc_user_alternative_text']);
                            }
                            $ret_msg .= '</div>';

                            $wplc_random_user_number = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
                            //$wplc_loggedin_user_email = $wplc_random_user_number."@".$wplc_random_user_number.".com";
                            if ($wplc_loggedin_user_name != '') { $wplc_lin = $wplc_loggedin_user_name; } else {  $wplc_lin = 'user' . $wplc_random_user_number; }
                            if ($wplc_loggedin_user_email != '' && $wplc_loggedin_user_email != null) { $wplc_lie = $wplc_loggedin_user_email; } else { $wplc_lie = $wplc_random_user_number . '@' . $wplc_random_user_number . '.com'; }
                            $ret_msg .= "<input type=\"hidden\" name=\"wplc_name\" id=\"wplc_name\" value=\"".$wplc_lin."\" />";
                            $ret_msg .= "<input type=\"hidden\" name=\"wplc_email\" id=\"wplc_email\" wplc_hide=\"1\" value=\"".$wplc_lie."\" />";
                        }   
                        
                        $ret_msg .= "<input id=\"wplc_start_chat_btn\" type=\"button\" value=\"".__("Start Chat", "wplivechat")."\" style=\"background-color: ".$wplc_settings_fill." !important; color: ".$wplc_settings_font." !important;\"/>";
                        $ret_msg .= "</div>";
                        $ret_msg .= "<div id=\"wp-live-chat-3\" style=\"display:none;\">";
                        $ret_msg .= "<p>".__("Connecting you to a sales person. Please be patient.", "wplivechat")."</p>";
                        $ret_msg .= "</div>";
                        $ret_msg .= "<div id=\"wp-live-chat-react\" style=\"display:none;\">";
                        $ret_msg .= "<p>".__("Reactivating your previous chat...", "wplivechat")."</p>";
                        $ret_msg .= "</div>";
                        $ret_msg .= "<div id=\"wp-live-chat-4\" style=\"display:none;\">";
                        $ret_msg .= "<div id=\"wplc_sound_update\" style=\"height:0; width:0; display:none; border:0;\"></div>";
                        $ret_msg .= "<div id=\"wplc_chatbox\"></div>";
                        $ret_msg .= "<p style=\"text-align:center; font-size:11px;\">".__("Press ENTER to send your message", "wplivechat")."</p>";
                        $ret_msg .= "<p>";
                        $ret_msg .= "<input type=\"text\" name=\"wplc_chatmsg\" id=\"wplc_chatmsg\" value=\"\" />";
                        $ret_msg .= "<input type=\"hidden\" name=\"wplc_cid\" id=\"wplc_cid\" value=\"\" />";
                        $ret_msg .= "<input id=\"wplc_send_msg\" type=\"button\" value=\"".__("Send", "wplivechat")."\" style=\"display:none;\" />";
                        $ret_msg .= "</p>";
                        $ret_msg .= "</div>";
                        $ret_msg .= "</div>";
            }
        $ret_msg .= "</div>";
        return json_encode($ret_msg);
    } else {
        return "";
    }


}



function wplc_draw_user_box() {
  

    if(function_exists('wplc_display_chat_contents')){
        if(wplc_display_chat_contents() >= 1){
            wplc_output_box();
        }
    } else {
        wplc_output_box();
    }
    
}


function wplc_output_box() {
    $wplc_class = "";
    $wplc_settings = get_option("WPLC_SETTINGS");

    if ($wplc_settings["wplc_settings_enabled"] == 2) {
        return;
    }

    if ($wplc_settings["wplc_settings_align"] == 1) {
        $original_pos = "bottom_left";
        //$wplc_box_align = "left:100px; bottom:0px;";
        $wplc_box_align = "bottom:0px;";
    } else if ($wplc_settings["wplc_settings_align"] == 2) {
        $original_pos = "bottom_right";
        //$wplc_box_align = "right:100px; bottom:0px;";
        $wplc_box_align = "bottom:0px;";
    } else if ($wplc_settings["wplc_settings_align"] == 3) {
        $original_pos = "left";
//        $wplc_box_align = "left:0; bottom:100px;";
        $wplc_box_align = " bottom:100px;";
        $wplc_class = "wplc_left";
    } else if ($wplc_settings["wplc_settings_align"] == 4) {
        $original_pos = "right";
//        $wplc_box_align = "right:0; bottom:100px;";
        $wplc_box_align = "bottom:100px;";
        $wplc_class = "wplc_right";
    }
    
    if ($wplc_settings["wplc_settings_fill"]) {
        $wplc_settings_fill = "#" . $wplc_settings["wplc_settings_fill"];
    } else {
        $wplc_settings_fill = "#ed832f";
    }
    if ($wplc_settings["wplc_settings_font"]) {
        $wplc_settings_font = "#" . $wplc_settings["wplc_settings_font"];
    } else {
        $wplc_settings_font = "#FFFFFF";
    }

    $wplc_is_admin_logged_in = get_transient("wplc_is_admin_logged_in");
    if (!function_exists("wplc_register_pro_version") && $wplc_is_admin_logged_in != 1) {
        return "";
    }
    
    if(function_exists('wplc_pro_activate')){
        if(function_exists('wplc_return_animations')){
            
            $animations = wplc_return_animations();
            
            isset($animations['animation']) ? $wplc_animation = $animations['animation'] : $wplc_animation = 'animation-4';
            isset($animations['starting_point']) ? $wplc_starting_point = $animations['starting_point'] : $wplc_starting_point = 'display: none;';
            isset($animations['box_align']) ? $wplc_box_align = $animations['box_align'] : $wplc_box_align = '';

        } else {
            
        }
    } else {
        
        $wplc_starting_point = '';
        $wplc_animation = '';
        
        if ($wplc_settings["wplc_settings_align"] == 1) {
            $original_pos = "bottom_left";
            $wplc_box_align = "left:100px; bottom:0px;";
        } else if ($wplc_settings["wplc_settings_align"] == 2) {
            $original_pos = "bottom_right";
            $wplc_box_align = "right:100px; bottom:0px;";
        } else if ($wplc_settings["wplc_settings_align"] == 3) {
            $original_pos = "left";
            $wplc_box_align = "left:0; bottom:100px;";
            $wplc_class = "wplc_left";
        } else if ($wplc_settings["wplc_settings_align"] == 4) {
            $original_pos = "right";
            $wplc_box_align = "right:0; bottom:100px;";
            $wplc_class = "wplc_right";
        }

    }
    /* here */
    ?>    
    <div id="wp-live-chat" wplc_animation='<?php echo $wplc_animation; ?>' style="<?php echo $wplc_starting_point." ".$wplc_box_align; ?>; " class="<?php echo $wplc_class; ?> wplc_close" original_pos="<?php echo $original_pos; ?>" wplc-auto-pop-up="<?php if (isset($wplc_settings['wplc_auto_pop_up'])) { echo $wplc_settings['wplc_auto_pop_up']; } ?>" > 
    <?php
        if (function_exists("wplc_register_pro_version")) {
             wplc_pro_output_box();
        } else {
            ?>
            <div class="wp-live-chat-wraper">
                <div id="wp-live-chat-header" style="background-color: <?php echo $wplc_settings_fill; ?> !important; color: <?php echo $wplc_settings_font; ?> !important; ">
                    <i id="wp-live-chat-minimize" class="fa fa-minus" style="display:none;" ></i>
                    <i id="wp-live-chat-close" class="fa fa-times" style="display:none;" ></i>

                    <div id="wp-live-chat-1" >
                        <div style="display:block; ">
                            <strong><?php _e("Questions?", "wplivechat") ?></strong> <?php _e("Chat with us", "wplivechat") ?>
                        </div>
                    </div>
                </div>

                <div id="wp-live-chat-2" style="display:none;">
                    <div id="wp-live-chat-2-info">
                        <strong><?php _e('Start Live Chat', 'wplivechat'); ?></strong> 
                    </div>
                    <?php
                    $wplc_settings = get_option("WPLC_SETTINGS");

                    if (isset($wplc_settings['wplc_loggedin_user_info']) && $wplc_settings['wplc_loggedin_user_info'] == 1) {
                        $wplc_use_loggedin_user_details = 1;
                    } else {
                        $wplc_use_loggedin_user_details = 0;
                    }

                    $wplc_loggedin_user_name = "";
                    $wplc_loggedin_user_email = "";

                    if ($wplc_use_loggedin_user_details == 1) {
                        global $current_user;

                        if ($current_user->data != null) {
                            //Logged in. Get name and email
                            $wplc_loggedin_user_name = $current_user->user_nicename;
                            $wplc_loggedin_user_email = $current_user->user_email;
                        }
                    } else {
                        $wplc_loggedin_user_name = '';
                        $wplc_loggedin_user_email = '';
                    }

                    if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 1) {
                        $wplc_ask_user_details = 1;
                    } else {
                        $wplc_ask_user_details = 0;
                    }

                    if ($wplc_ask_user_details == 1) {
                        //Ask the user to enter name and email
                        ?>
                        <input type="text" name="wplc_name" id="wplc_name" value="<?php echo $wplc_loggedin_user_name; ?>" placeholder="<?php _e("Name", "wplivechat"); ?>" />
                        <input type="text" name="wplc_email" id="wplc_email" wplc_hide="0" value="<?php echo $wplc_loggedin_user_email; ?>" placeholder="<?php _e("Email", "wplivechat"); ?>"  />
                        <?php
                    } else {
                        //Dont ask the user
                        echo '<div style="padding: 7px; text-align: center;">';
                        if (isset($wplc_settings['wplc_user_alternative_text'])) {
                            echo stripslashes($wplc_settings['wplc_user_alternative_text']);
                        }
                        echo '</div>';

                        $wplc_random_user_number = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
                        //$wplc_loggedin_user_email = $wplc_random_user_number."@".$wplc_random_user_number.".com";
                        ?>
                        <input type="hidden" name="wplc_name" id="wplc_name" value="<?php if ($wplc_loggedin_user_name != '') { echo $wplc_loggedin_user_name; } else { echo 'user' . $wplc_random_user_number; } ?>" />
                        <input type="hidden" name="wplc_email" id="wplc_email" wplc_hide="1" value="<?php if ($wplc_loggedin_user_email != '' && $wplc_loggedin_user_email != null) { echo $wplc_loggedin_user_email; } else { echo $wplc_random_user_number . '@' . $wplc_random_user_number . '.com'; } ?>" />
                        <?php
                    }   
                    ?>
                    <input id="wplc_start_chat_btn" type="button" value="<?php _e("Start Chat", "wplivechat"); ?>" style="background-color: <?php echo $wplc_settings_fill; ?> !important; color: <?php echo $wplc_settings_font; ?> !important;"/>
                </div>
                <div id="wp-live-chat-3" style="display:none;">
                    <p><?php _e("Connecting you to a sales person. Please be patient.", "wplivechat") ?></p>
                </div>
                <div id="wp-live-chat-react" style="display:none;">
                    <p><?php _e("Reactivating your previous chat...", "wplivechat") ?></p>
                </div>
                <div id="wp-live-chat-4" style="display:none;">
                    <div id="wplc_sound_update" style='height:0; width:0; display:none; border:0;'></div>
                    <div id="wplc_chatbox"></div>
                    <p style="text-align:center; font-size:11px;"><?php _e("Press ENTER to send your message", "wplivechat") ?></p>
                    <p>
                        <input type="text" name="wplc_chatmsg" id="wplc_chatmsg" value="" />
                        <input type="hidden" name="wplc_cid" id="wplc_cid" value="" />
                        <input id="wplc_send_msg" type="button" value="<?php _e("Send", "wplivechat"); ?>" style="display:none;" />
                    </p>
                </div>
            </div>    
        <?php } ?>
</div> 
<?php

}