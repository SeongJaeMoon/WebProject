<?php
$wplc_basic_plugin_url = WPLC_BASIC_PLUGIN_URL;

function wplc_log_user_on_page($name,$email,$session, $is_mobile = false) {
    global $wpdb;
    global $wplc_tblname_chats;

    $wplc_settings = get_option('WPLC_SETTINGS');


    /** DEPRECATED DUE TO GDPR */
    /*if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1){

        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        $user_data = array(
            'ip' => $ip_address,
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        );
    } else {
        $user_data = array(
            'ip' => "",
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        );
    }*/

    $user_data = array(
        'ip' => "",
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
    );


    /* user types
     * 1 = new
     * 2 = returning
     * 3 = timed out
     */

     $other = array(
         "user_type" => 1
     );

     if($is_mobile){
        $other['user_is_mobile'] = true;
     } else {
        $other['user_is_mobile'] = false;
     }

    $other = apply_filters("wplc_log_user_on_page_insert_other_data_filter", $other);

    $wplc_chat_session_data = array(
            'status' => '5',
            'timestamp' => current_time('mysql'),
            'name' => $name,
            'email' => $email,
            'session' => $session,
            'ip' => maybe_serialize($user_data),
            'url' => sanitize_text_field($_SERVER['HTTP_REFERER']),
            'last_active_timestamp' => current_time('mysql'),
            'other' => maybe_serialize($other),
    );

    $wplc_chat_session_data = apply_filters("wplc_log_user_on_page_insert_filter", $wplc_chat_session_data);

    /* Omitted from inser call as this defaults to string
    $wplc_chat_session_types = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
    ); */


    $wpdb->insert($wplc_tblname_chats, $wplc_chat_session_data);
    $lastid = $wpdb->insert_id;

    do_action("wplc_log_user_on_page_after_hook", $lastid, $wplc_chat_session_data);


    return $lastid;

}
function wplc_update_user_on_page($cid, $status = 5,$session) {
    global $wpdb;
    global $wplc_tblname_chats;
    $wplc_settings = get_option('WPLC_SETTINGS');

    /** DEPRECATED BY GDPR */
    /*if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1){

        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ip_address = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip_address = sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }
        $user_data = array(
            'ip' => $ip_address,
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'])
        );
    } else {
        $user_data = array(
            'ip' => "",
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'])
        );
    }*/

    $user_data = array(
        'ip' => "",
        'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'])
    );



    $query = $wpdb->update(
        $wplc_tblname_chats,
        array(
            'url' => sanitize_text_field($_SERVER['HTTP_REFERER']),
            'last_active_timestamp' => current_time('mysql'),
            'ip' => maybe_serialize($user_data),
            'status' => $status,
            'session' => $session,
        ),
        array('id' => $cid),
        array(
            '%s',
            '%s',
            '%s',
            '%d',
            '%s'
        ),
        array('%d')
    );


    return $query;


}


function wplc_record_chat_msg($from, $cid, $msg, $rest_check = false, $aid = false, $other = false) {
    global $wpdb;
    global $wplc_tblname_msgs;


    if( ! filter_var($cid, FILTER_VALIDATE_INT) ) {

        /**
         * We need to identify if this CID is a node CID, and if so, return the WP CID from the wplc_chat_msgs table
         */
        $cid = wplc_return_chat_id_by_rel($cid);
    }

    /**
     * check if this CID even exists, if not, create it
     *
     * If it doesnt exist, it most likely is an agent-to-agent chat that we now need to save.
     */

    global $wplc_tblname_chats;
    $results = $wpdb->get_results("SELECT * FROM $wplc_tblname_chats WHERE `rel` = '".$cid."' OR `id` = '".$cid."' LIMIT 1");
    if (!$results) {
        /* it doesnt exist, lets put it in the table */

        $wpdb->insert(
            $wplc_tblname_chats,
            array(
                'status' => 3,
                'timestamp' => current_time('mysql'),
                'name' => 'agent-to-agent chat',
                'email' => 'none',
                'session' => '1',
                'ip' => '0',
                'url' => '',
                'last_active_timestamp' => current_time('mysql'),
                'other' => '',
                'rel' => $cid,
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );


        $cid = $wpdb->insert_id;
    }


    if ($from == "2" && $rest_check == false) {
        $wplc_current_user = get_current_user_id();

        if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) ){
        /*
          -- modified in in 6.0.04 --

          if(current_user_can('wplc_ma_agent') || current_user_can('manage_options')){
         */  } else { return "security issue"; }
    }

    if ($from == "1") {
        $fromname = wplc_return_chat_name(sanitize_text_field($cid));
        if (empty($fromname)) { $fromname = 'Guest'; }
        //$fromemail = wplc_return_chat_email($cid);
        $orig = '2';
    }
    else {
        $fromname = apply_filters("wplc_filter_admin_name","Admin");

        //$fromemail = "SET email";
        $orig = '1';
    }

    $msg_id = '';

    if ($other !== false) {
        if (!empty($other->msgID)) {
            $msg_id = $other->msgID;
        } else {
            $msg_id = '';
        }
    }


    $orig_msg = $msg;

    $msg = apply_filters("wplc_filter_message_control",$msg);

    if (!$aid) {
        $wplc_current_user = get_current_user_id();

        if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) ){
            $other_data = array('aid'=>$wplc_current_user);
        } else {
            $other_data = '';
        }
    } else {
        if( get_user_meta( $aid, 'wplc_ma_agent', true ) ){
            $other_data = array('aid'=>$aid);
        } else {
            $other_data = '';
        }
    }





    $wpdb->insert(
        $wplc_tblname_msgs,
        array(
                'chat_sess_id' => $cid,
                'timestamp' => current_time('mysql'),
                'msgfrom' => $fromname,
                'msg' => $msg,
                'status' => 0,
                'originates' => $orig,
                'other' => maybe_serialize( $other_data ),
                'rel' => $msg_id
        ),
        array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s'
        )
    );

    $data = array(
        'cid' => $cid,
        'from' => $from,
        'msg' => $orig_msg,
        'orig' => $orig
    );
    do_action("wplc_hook_message_sent",$data);

    wplc_update_active_timestamp(sanitize_text_field($cid));


    return true;

}

function wplc_update_active_timestamp($cid) {
    global $wpdb;
    global $wplc_tblname_chats;
//    $results = $wpdb->get_results(
//        "
//        UPDATE $wplc_tblname_chats
//        SET `last_active_timestamp` = '".date("Y-m-d H:i:s")."'
//        WHERE `id` = '$cid'
//        LIMIT 1
//        "
//    );
    $wpdb->update(
        $wplc_tblname_chats,
        array(
            'last_active_timestamp' => current_time('mysql')
        ),
        array('id' => $cid),
        array('%s'),
        array('%d')
    );

    //wplc_change_chat_status(sanitize_text_field($cid),3);
    return true;

}

function wplc_return_chat_name($cid) {
    global $wpdb;
    global $wplc_tblname_chats;

    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_chats
        WHERE `id` = '$cid'
        "
    );
    foreach ($results as $result) {
        return $result->name;
    }

}


/**
 * Find out if we are dealing with a NODE CID and convert it to the WP CID.
 *
 * If it cannot find a relative, then simply return the original CID parsed through.
 *
 * @param  string|int $rel The CId to compare
 * @return string|int      The suggested CID
 */
function wplc_return_chat_id_by_rel($rel) {
    global $wpdb;
    global $wplc_tblname_chats;

    $results = $wpdb->get_results("SELECT * FROM $wplc_tblname_chats WHERE `rel` = '$rel' LIMIT 1");
    if ($results) {
        foreach ($results as $result) {
            if (isset($result->id)) {
                return $result->id;
            } else {
                return $rel;
            }
        }
    } else {
        return $rel;
    }

}
function wplc_return_chat_email($cid) {
    global $wpdb;
    global $wplc_tblname_chats;
    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_chats
        WHERE `id` = '$cid'
        "
    );
    foreach ($results as $result) {
        return $result->email;
    }

}
function wplc_list_chats() {

    global $wpdb;
    global $wplc_tblname_chats;
    $status = 3;
    $wplc_c = 0;
    $results = $wpdb->get_results(
        "
    SELECT *
    FROM $wplc_tblname_chats
        WHERE `status` = 3 OR `status` = 2 OR `status` = 10
        ORDER BY `timestamp` ASC

    "
    );

        $table = "<div class='wplc_chats_container'>";

    if (!$results) {
        $table.= "<p>".__("No chat sessions available at the moment","wplivechat")."</p>";
    } else {
        $table .= "<h2>".__('Active Chats', 'wplivechat')."</h2>";

        foreach ($results as $result) {
            unset($trstyle);
            unset($actions);
            $wplc_c++;


            global $wplc_basic_plugin_url;
            $user_data = maybe_unserialize($result->ip);
            $user_ip = $user_data['ip'];
            $browser = wplc_return_browser_string($user_data['user_agent']);
            $browser_image = wplc_return_browser_image($browser,"16");

            if($user_ip == ""){
                $user_ip = __('IP Address not recorded', 'wplivechat');
            } else {
                $user_ip = "<a href='http://www.ip-adress.com/ip_tracer/" . $user_ip . "' title='".__('Whois for' ,'wplivechat')." ".$user_ip."' target='_BLANK'>".$user_ip."</a>";
            }

            if ($result->status == 2) {
                $url = admin_url( 'admin.php?page=wplivechat-menu&action=ac&cid='.$result->id);
                $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Accept Chat","wplivechat")."</a>";
                $trstyle = "style='background-color:#FFFBE4; height:30px;'";
                $icon = "<i class=\"fa fa-phone wplc_pending\" title='".__('Incoming Chat', 'wplivechat')."' alt='".__('Incoming Chat', 'wplivechat')."'></i><div class='wplc_icon_message'>".__('You have an incoming chat.', 'wplivechat')."</div>";
            }
            if ($result->status == 3) {
                $url = admin_url( 'admin.php?page=wplivechat-menu&action=ac&cid='.$result->id);
                $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Open Chat Window","wplivechat")."</a>";
                $trstyle = "style='background-color:#F7FCFE; height:30px;'";
                $icon = "<i class=\"fa fa-check-circle wplc_active\" title='".__('Chat Active', 'wplivechat')."' alt='".__('Chat Active', 'wplivechat')."'></i><div class='wplc_icon_message'>".__('This chat is active', 'wplivechat')."</div>";
            }


            /* if ($wplc_c>1) { $actions = wplc_get_msg(); } */

           $trstyle = "";

            $table .= "
                <div class='wplc_single_chat' id='record_".$result->id."' $trstyle> 
                    <div class='wplc_chat_section section_1'>
                        <div class='wplc_user_image' id='chat_image_".$result->id."'>
                            <img src=\"//www.gravatar.com/avatar/".md5($result->email)."?s=60&d=mm\" />
                        </div>
                        <div class='wplc_user_meta_data'>
                            <div class='wplc_user_name' id='chat_name_".$result->id."'>
                                <h3>".$result->name.$icon."</h3>
                                <a href='mailto:".$result->email."' target='_BLANK'>".$result->email."</a>
                            </div>                                
                        </div>    
                    </div>
                    <div class='wplc_chat_section section_2'>
                        <div class='admin_visitor_advanced_info'>
                            <strong>" . __("Site Info", "wplivechat") . "</strong>
                            <hr />
                            <span class='part1'>" . __("Chat initiated on:", "wplivechat") . "</span> <span class='part2'> <a href='".esc_url($result->url)."' target='_BLANK'>" . esc_url($result->url) . "</a></span>
                        </div>

                        <div class='admin_visitor_advanced_info'>
                            <strong>" . __("Advanced Info", "wplivechat") . "</strong>
                            <hr />
                            <span class='part1'>" . __("Browser:", "wplivechat") . "</span><span class='part2'> $browser <img src='" . $wplc_basic_plugin_url . "/images/$browser_image' alt='$browser' title='$browser' /><br />
                            <span class='part1'>" . __("IP Address:", "wplivechat") . "</span><span class='part2'> ".$user_ip."
                        </div>
                    </div>
                    <div class='wplc_chat_section section_3'>
                        <div class='wplc_agent_actions'>
                            $actions
                        </div>
                    </div>
                </div>
                    ";
        }
    }
    $table .= "</div>";

    return $table;
}

function wplc_time_ago($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time   = current_time('timestamp');
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "0 min";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "1 min";
        }
        else{
            return "$minutes min";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "1 hr";
        }else{
            return "$hours hrs";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "1 day";
        }else{
            return "$days days";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "1 week";
        }else{
            return "$weeks weeks";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "1 month";
        }else{
            return "$months months";
        }
    }
    //Years
    else{
        if($years==1){
            return "1 year";
        }else{
            return "$years years";
        }
    }
}

add_filter("wplc_filter_list_chats_actions","wplc_filter_control_list_chats_actions",15,3);
/**
 * Only allow agents access
 * @return void
 * @since  6.0.00
 * @version  6.0.04 Updated to ensure those with the correct access can access this function
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_list_chats_actions($actions,$result,$post_data) {
    $aid = apply_filters("wplc_filter_aid_in_action","");

    $wplc_current_user = get_current_user_id();

    if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) ){

        if (intval($result->status) == 2) {
            $url_params = "&action=ac&cid=".$result->id.$aid;
            $url = admin_url( 'admin.php?page=wplivechat-menu'.$url_params);
            $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">". apply_filters("wplc_accept_chat_button_filter", __("Accept Chat","wplivechat"), $result->id)."</a>";
        }
        else if (intval($result->status) == 3 || intval($result->status) == 10) {
            $url_params = "&action=ac&cid=".$result->id.$aid;
            $url = admin_url( 'admin.php?page=wplivechat-menu'.$url_params);
            if ( ! function_exists("wplc_pro_version_control") || !isset( $result->agent_id ) || $wplc_current_user == $result->agent_id ) { //Added backwards compat checks
                $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Open Chat","wplivechat")."</a>";
            } else {
                $actions = "<span class=\"wplc-chat-in-progress\">" . __( "In progress with another agent", "wplivechat" ) . "</span>";
            }
        }
        else if (intval($result->status) == 2) {
            $url_params = "&action=ac&cid=".$result->id.$aid;
            $url = admin_url( 'admin.php?page=wplivechat-menu'.$url_params);
            $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Accept Chat","wplivechat")."</a>";
        }
        else if (intval($result->status) == 12 ) {
            $url_params = "&action=ac&cid=".$result->id.$aid;
            $url = admin_url( 'admin.php?page=wplivechat-menu'.$url_params);
            $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Open Chat","wplivechat")."</a>";
        }
    } else {
        $actions = "<a href='#'>".__( 'Only chat agents can accept chats', 'wplivechat' )."</a>";
    }
    return $actions;
}

function wplc_list_chats_new($post_data) {

    global $wpdb;
    global $wplc_tblname_chats;

    $data_array = array();
    $id_list = array();

    $status = 3;
    $wplc_c = 0;

    // Retrieve count of users in same department or in no department
    $user_id = get_current_user_id();
    $user_department = get_user_meta($user_id ,"wplc_user_department", true);

    $wplc_chat_count_sql = "SELECT COUNT(*) FROM $wplc_tblname_chats WHERE status IN (3,2,10,5,8,9,12)";
    if($user_department > 0)
        $wplc_chat_count_sql .= " AND (department_id=0 OR department_id=$user_department)";
    $data_array['visitor_count'] = $wpdb->get_var($wplc_chat_count_sql);

    // Retrieve data
    $wplc_chat_sql = "SELECT * FROM $wplc_tblname_chats WHERE (`status` = 3 OR `status` = 2 OR `status` = 10 OR `status` = 5 or `status` = 8 or `status` = 9 or `status` = 12)";
    $wplc_chat_sql .= apply_filters("wplc_alter_chat_list_sql_before_sorting", "");

    $wplc_chat_sql .= " ORDER BY `timestamp` ASC";

    $results = $wpdb->get_results($wplc_chat_sql);


    if($results) {


        foreach ($results as $result) {
            unset($trstyle);
            unset($actions);




            global $wplc_basic_plugin_url;
            $user_data = maybe_unserialize($result->ip);
            $user_ip = $user_data['ip'];
            $browser = wplc_return_browser_string($user_data['user_agent']);
            $browser_image = wplc_return_browser_image($browser,"16");

            if($user_ip == ""){
                $user_ip = __('IP Address not recorded', 'wplivechat');
            } else {
                $user_ip = "<a href='http://www.ip-adress.com/ip_tracer/" . $user_ip . "' title='".__('Whois for' ,'wplivechat')." ".$user_ip."' target='_BLANK'>".$user_ip."</a>";
            }


            $actions = apply_filters("wplc_filter_list_chats_actions","",$result,$post_data);


            $other_data = maybe_unserialize($result->other);



           $trstyle = "";

           $id_list[intval($result->id)] = true;

           $data_array[$result->id]['name'] = $result->name;
           $data_array[$result->id]['email'] = $result->email;

           $data_array[$result->id]['status'] = $result->status;
           $data_array[$result->id]['action'] = $actions;
           $data_array[$result->id]['timestamp'] = wplc_time_ago($result->timestamp);

           if ((current_time('timestamp') - strtotime($result->timestamp)) < 3600) {
               $data_array[$result->id]['type'] = __("New","wplivechat");
           } else {
               $data_array[$result->id]['type'] = __("Returning","wplivechat");
           }

           $data_array[$result->id]['image'] = "<img src=\"//www.gravatar.com/avatar/".md5($result->email)."?s=30&d=mm\"  class='wplc-user-message-avatar' />";
           $data_array[$result->id]['data']['browsing'] = $result->url;
           $path = parse_url($result->url, PHP_URL_PATH);

           if (strlen($path) > 20) {
                $data_array[$result->id]['data']['browsing_nice_url'] = substr($path,0,20).'...';
           } else {
               $data_array[$result->id]['data']['browsing_nice_url'] = $path;
           }

           $data_array[$result->id]['data']['browser'] = "<img src='" . $wplc_basic_plugin_url . "/images/$browser_image' alt='$browser' title='$browser' /> ";
           $data_array[$result->id]['data']['ip'] = $user_ip;
           $data_array[$result->id]['other'] = $other_data;
        }

        $data_array['ids'] = $id_list;
    }

    return json_encode($data_array);
}



function wplc_return_user_chat_messages($cid,$wplc_settings = false,$cdata = false) {
    global $wpdb;
    global $wplc_tblname_msgs;

    if (!$wplc_settings) {
        $wplc_settings = get_option("WPLC_SETTINGS");
    }

    if(isset($wplc_settings['wplc_display_name']) && $wplc_settings['wplc_display_name'] == 1){ $display_name = 1; } else { $display_name = 0; }

    $sql = "SELECT * FROM $wplc_tblname_msgs WHERE `chat_sess_id` = '$cid' AND `status` = '0' AND (`originates` = '1' OR `originates` = '0') ORDER BY `timestamp` ASC";
    $results = $wpdb->get_results($sql);
    if (!$cdata) {
        $cdata = wplc_get_chat_data($cid,__LINE__);
    }


    $msg_hist = array();
    foreach ($results as $result) {
        $system_notification = false;

        $id = $result->id;
        $from = $result->msgfrom;


        $msg = $result->msg;

        if ( isset( $result->other ) ) { $other_data = maybe_unserialize( $result->other ); } else { $other_data = array(); }
        if ($other_data == '') { $other_data = array(); }

        $timestamp = strtotime( $result->timestamp );
        $other_data['datetime'] = $timestamp;
	    $other_data['datetimeUTC'] = strtotime( get_gmt_from_date( $result->timestamp ) );

        //
        if($result->originates == 1){
            /* removed in 7.1.00
            $class = "wplc-admin-message wplc-color-bg-4 wplc-color-2 wplc-color-border-4";
            if(function_exists("wplc_pro_get_admin_picture")){
                $src = wplc_pro_get_admin_picture();
                if($src){
                    $image = "<img src=".$src." width='20px' id='wp-live-chat-2-img'/>";
                } else {
                    $image = "";
                }
            } else {
                $other = maybe_unserialize($cdata->other);
                if (isset($other['aid'])) {


                    $user_info = get_userdata(intval($other['aid']));

                    $image = "<img src='//www.gravatar.com/avatar/".md5($user_info->user_email)."?s=30'  class='wplc-admin-message-avatar' />";
                } else {


                    $image = "";
                    if(1 == 1) {

                    } else {

                        $image = "";
                    }
                }

            }

            $from = apply_filters("wplc_filter_admin_name",$from, $cid);
            */

        }
        else if (intval($result->originates) == 0) {
            /*
            system notifications
            from version 7
             */
            $system_notification = true;

        }
        else {

            /*
             removed in 7.1.00
            $class = "wplc-user-message wplc-color-bg-1 wplc-color-2 wplc-color-border-1";

            if(isset($_COOKIE['wplc_email']) && $_COOKIE['wplc_email'] != ""){ $wplc_user_gravatar = md5(strtolower(trim(sanitize_text_field($_COOKIE['wplc_email'])))); } else { $wplc_user_gravatar = ""; }

            if($wplc_user_gravatar != ""){
                $image = "<img src='//www.gravatar.com/avatar/$wplc_user_gravatar?s=30'  class='wplc-user-message-avatar' />";
            } else {
                $image = "";
            }
            */
        }

        if (!$system_notification) {
            /* this is a normal message */
            if(function_exists('wplc_encrypt_decrypt_msg')){
                $msg = wplc_encrypt_decrypt_msg($msg);
            }

            $msg_array = maybe_unserialize( $msg );

            if( is_array( $msg_array ) ){
                $msg = $msg_array['m'];
            }

            $msg = stripslashes($msg);

            $msg = apply_filters("wplc_filter_message_control_out",$msg);

            $msg = stripslashes($msg);

            $msg_hist[$id]['msg'] = $msg;
            $msg_hist[$id]['originates'] = intval($result->originates);
            $msg_hist[$id]['other'] = $other_data;

            /*
                removed this in 7.1.00 as the JS now handles this
            if($display_name){
                $msg_hist[$id]['msg'] = "<span class='wplc-admin-message wplc-color-bg-4 wplc-color-2 wplc-color-border-4'>$image <strong>$from </strong> $msg</span><br /><div class='wplc-clear-float-message'></div>";
            } else {
                $msg_hist[$id]['msg'] = "<span class='wplc-admin-message wplc-color-bg-4 wplc-color-2 wplc-color-border-4'>$msg</span><div class='wplc-clear-float-message'></div>";
            }*/
        } else {
            /* add the system notification to the list */
            if ( isset( $msg_hist[$id] ) ) { $msg_hist[$id] = array(); }

            $msg_hist[$id]['msg'] = $msg;
            $msg_hist[$id]['other'] = $other_data;
            $msg_hist[$id]['originates'] = intval($result->originates);
        }




    }

    return $msg_hist;


}





function wplc_return_no_answer_string($cid) {

    $wplc_settings = get_option("WPLC_SETTINGS");
    if (isset($wplc_settings['wplc_user_no_answer'])) {
        $string = stripslashes($wplc_settings['wplc_user_no_answer']);
    } else {
        $string = __("No agent was able to answer your chat request. Please try again.","wplivechat");
    }
    $string = apply_filters("wplc_filter_no_answer_string",$string,$cid);
    return "<span class='wplc_system_notification wplc_no_answer wplc-color-4'><center>".$string."</center></span>";
}
add_filter("wplc_filter_no_answer_string","wplc_filter_control_no_answer_string",10,2);

/**
 * Add the "retry chat" button when an agent hasnt answered
 * @param  string $string Original "No Answer" string
 * @param  intval $cid    Chat ID
 * @return string
 */
function wplc_filter_control_no_answer_string($string,$cid) {
    $string = $string. " <br /><button class='wplc_retry_chat wplc-color-bg-1 wplc-color-2' cid='".$cid."'>".__("Request new chat","wplivechat")."</button>";
    return $string;
}


function wplc_change_chat_status($id,$status,$aid = 0) {
    global $wpdb;
    global $wplc_tblname_chats;

    if ($aid > 0) {
        /* only run when accepting a chat */
        $results = $wpdb->get_results("SELECT * FROM ".$wplc_tblname_chats." WHERE `id` = '".$id."' LIMIT 1");
        foreach ($results as $result) {
            $other = maybe_unserialize($result->other);
            if (isset($other['aid']) && $other['aid'] > 0) {
                /* we have recorded this already */

            } else {
                /* first time answering the chat! */


                /* send welcome note */
                /*
                removed in version 7. added "chat notification events" instead, i.e. Agent has joined the chat.
                $wplc_settings = get_option("WPLC_SETTINGS");
                $wplc_welcome = __('Welcome. How may I help you?', 'wplivechat');
                if(isset($wplc_settings['wplc_using_localization_plugin']) && $wplc_settings['wplc_using_localization_plugin'] == 1){ $wplc_using_locale = true; } else { $wplc_using_locale = false; }
                if (!isset($wplc_settings['wplc_user_welcome_chat']) || $wplc_settings['wplc_user_welcome_chat'] == "") { $wplc_settings['wplc_user_welcome_chat'] = $wplc_welcome; }
                $text2 = ($wplc_using_locale ? $wplc_welcome : stripslashes($wplc_settings['wplc_user_welcome_chat']));

                $chat_id = sanitize_text_field($id);
                $chat_msg = sanitize_text_field($text2);
                $wplc_rec_msg = wplc_record_chat_msg("2",$chat_id,$chat_msg);

                */


            }

            $other['aid'] = $aid;
        }
    }




    if ($aid > 0) {
        $wpdb->update(
            $wplc_tblname_chats,
            array(
                'status' => $status,
                'other' => maybe_serialize($other),
                'agent_id' => $aid
            ),
            array('id' => $id),
            array(
                '%d',
                '%s',
                '%d'
                ),
            array('%d')
        );
    } else {
        $wpdb->update(
            $wplc_tblname_chats,
            array(
                'status' => $status
            ),
            array('id' => $id),
            array('%d'),
            array('%d')
        );
    }

    do_action("wplc_change_chat_status_hook", $id, $status);

    return true;

}

//come back here
function wplc_return_chat_messages($cid, $transcript = false, $html = true, $wplc_settings = false, $cdata = false, $display = 'string', $only_read_message = false) {
    global $wpdb;
    global $wplc_tblname_msgs;


    if (!$wplc_settings) {
        $wplc_settings = get_option("WPLC_SETTINGS");
    }

    if(isset($wplc_settings['wplc_display_name']) && $wplc_settings['wplc_display_name'] == 1){ $display_name = 1; } else { $display_name = 0; }

    $results = wplc_get_chat_messages($cid, $only_read_message, $wplc_settings);
    if (!$results) { return; }

    if (!$cdata) {
        $cdata = wplc_get_chat_data($cid,__LINE__);
    }
    $msg_array = array();
    $msg_hist = "";
    $previous_time = "";
    $previous_timestamp = 0;
    foreach ($results as $result) {
        $display_notification = false;
        $system_notification = false;

        $from = $result->msgfrom;


        /* added a control here to see if we should use the NODE ID instead of the SQL ID */
        if (empty($result->rel)) {
            $id = $result->id;
        } else {
            $id = $result->rel;
        }
        $msg = $result->msg;


        if ( isset( $result->other ) ) { $other_data = maybe_unserialize( $result->other ); } else { $other_data = array(); }
        if ($other_data == '') { $other_data = array(); }

        $timestamp = strtotime( $result->timestamp );
        $other_data['datetime'] = $timestamp;
        $other_data['datetimeUTC'] = strtotime( get_gmt_from_date( $result->timestamp ) );
        $nice_time = date("d M Y H:i:s",$timestamp);


        $agent_from = false;

        $image = "";
        if($result->originates == 1){

            $agent_from = 'Agent';

        } else if ($result->originates == 2){


        } else if ($result->originates == 0 || $result->originates == 3) {



            $system_notification = true;
            $cuid = get_current_user_id();
            $is_agent = get_user_meta(esc_html( $cuid ), 'wplc_ma_agent', true);
            if ($is_agent && $result->originates == 3 ) {
                /* this user is an agent and the notification is meant for an agent, therefore display it */
                $display_notification = true;

                /* check if this came from the front end.. if it did, then dont display it (if this code is removed, all notifications will be displayed to agents who are logged in and chatting with themselves during testing, which may cause confusion) */
                if (isset($_POST) && isset($_POST['action']) && sanitize_text_field( $_POST['action'] ) == "wplc_call_to_server_visitor") {
                    $display_notification = false;
                }
            }
            else if (!$is_agent && $result->originates == 0) {
                /* this user is a not an agent and the notification is meant for a users, therefore display it */
                $display_notification = true;
            } else {
                /* this notification is not intended for this user */
                $display_notification = false;
            }
        }

        if (!$system_notification) {

            if(function_exists('wplc_encrypt_decrypt_msg')){
                $msg = wplc_encrypt_decrypt_msg($msg);
            }

            $msg = apply_filters("wplc_filter_message_control_out",$msg);

            if( is_serialized( $msg ) ){
                $msg_array = maybe_unserialize( $msg );

                if( is_array( $msg_array ) ){
                    $msg = $msg_array['m'];
                } else {
                    $msg = $msg;
                }

                $msg = stripslashes($msg);
            }

            if ( isset( $result->afrom ) && intval( $result->afrom ) > 0 ) {
                $msg_array[$id]['afrom'] = intval( $result->afrom ); $other_data['aid'] = intval( $result->afrom );

            }
            if ( isset( $result->ato ) && intval( $result->ato ) > 0 ) { $msg_array[$id]['ato'] = intval( $result->ato ); }


            /* use the new  "other" array to get the AID and agent name */
            if ( $result->originates == '1' && isset( $result->other ) ){
                $other_data = maybe_unserialize( $result->other );
                if ( isset( $other_data['aid'] ) ) {
                    $user_info = get_userdata( intval( $other_data['aid'] ) );
                    $agent_from = $user_info->display_name;
                }

            }

            /* get the name of the USER if there is one */
            if ( $result->originates == '2' && isset( $result->msgfrom ) ) {
                $user_from = $result->msgfrom;
            } else {
                $user_from = 'User';
            }


            $msg_array[$id]['msg'] = $msg;

            if ($agent_from !== false) {
                $msg_hist .= $agent_from . ": " . $msg . "<br />";
            } else {
                $msg_hist .= $user_from . ": " . $msg . "<br />";
            }


            $msg_array[$id]['originates'] = $result->originates;
            $msg_array[$id]['other'] = $other_data;


        } else {
            /* this is a system notification */
            if ($display_notification) {
                $str = "<span class='chat_time wplc-color-4'>".$nice_time."</span> <span class='wplc_system_notification wplc-color-4'>".$msg."</span>";

                if ( !isset( $msg_array[$id] ) ) { $msg_array[$id] = array(); }
                $msg_array[$id]['msg'] = $str;
                $msg_array[$id]['other'] = $other_data;
                $msg_array[$id]['originates'] = $result->originates;

                $msg_hist .= $str;
            }
        }

    }

    if ($display == 'string') { return $msg_hist; } else { return $msg_array; }


}

/**
 * Mark a message as 'read'
 *
 * Sets the 'status' of the message to 1 in the message table
 *
 * @param  [int] $mid Message ID - Unique
 * @return bool
 */
function wplc_mark_message_as_read( $mid ) {
    global $wpdb;
    global $wplc_tblname_msgs;

    $wpdb->update(
            $wplc_tblname_msgs,
            array(
                'status' => 1
            ),
            array('id' => $mid),
            array('%d'),
            array('%d')
        );
    return true;
}


/**
 * Mark all messages sent by an AGENT as read (a user has read them)
 *
 * @param  int      $cid    Chat ID
 * @return string           "ok"
 */
function wplc_mark_as_read_user_chat_messages($cid) {
    global $wpdb;
    global $wplc_tblname_msgs;

    $results = $wpdb->get_results("SELECT *
            FROM $wplc_tblname_msgs
            WHERE `chat_sess_id` = '$cid' AND `status` = '0' AND (`originates` = 1 OR `originates` = 0)
            ORDER BY `timestamp` DESC");


    foreach ($results as $result) {
        $id = $result->id;

        $wpdb->update(
            $wplc_tblname_msgs,
            array(
                'status' => 1
            ),
            array('id' => $id),
            array('%d'),
            array('%d')
        );


    }
    return "ok";


}
/**
 * Mark all messages sent by a USER as read (an agent has read them)
 *
 * @param  int      $cid    Chat ID
 * @return string           "ok"
 */
function wplc_mark_as_read_agent_chat_messages($cid, $aid) {
    global $wpdb;
    global $wplc_tblname_msgs;

    $results = $wpdb->get_results("SELECT *
            FROM $wplc_tblname_msgs
            WHERE `chat_sess_id` = '$cid' AND `ato` = '".intval( $aid )."'
            ORDER BY `timestamp` DESC");


    foreach ($results as $result) {
        $id = $result->id;

        $wpdb->update(
            $wplc_tblname_msgs,
            array(
                'status' => 1
            ),
            array('id' => $id),
            array('%d'),
            array('%d')
        );


    }
    return "ok";


}


//here
function wplc_return_admin_chat_messages($cid) {
    $wplc_current_user = get_current_user_id();
    if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) ){
        /*
          -- modified in in 6.0.04 --

          if(current_user_can('wplc_ma_agent') || current_user_can('manage_options')){
         */
        $wplc_settings = get_option("WPLC_SETTINGS");

        if(isset($wplc_settings['wplc_display_name']) && $wplc_settings['wplc_display_name'] == 1){ $display_name = 1; } else { $display_name = 0; }

        global $wpdb;
        global $wplc_tblname_msgs;

        /**
         * `Originates` - codes:
         *     0 - System notification to be delivered to users
         *     1 - Message from an agent
         *     2 - Message from a user
         *     3 - System notification to be delivered to agents
         *
         */
        $results = $wpdb->get_results("SELECT * FROM $wplc_tblname_msgs WHERE `chat_sess_id` = '$cid' AND `status` = '0' AND (`originates` = '2' OR `originates` = '3') ORDER BY `timestamp` ASC");


        $msg_hist = array();
        foreach ($results as $result) {
            $system_notification = false;

            $id = $result->id;
            wplc_mark_as_read_admin_chat_messages($id);
            $from = $result->msgfrom;


            $msg = $result->msg;

            if ( isset( $result->other ) ) { $other_data = maybe_unserialize( $result->other ); } else { $other_data = array(); }
            if ($other_data == '') { $other_data = array(); }

            $timestamp = strtotime( $result->timestamp );
            $other_data['datetime'] = $timestamp;
	        $other_data['datetimeUTC'] = strtotime( get_gmt_from_date( $result->timestamp ) );

            if (intval($result->originates) == 3) {
                /*
                system notifications
                from version 7
                 */
                $system_notification = true;

            }
            else {


            }

            if (!$system_notification) {
                /* this is a normal message */
                if(function_exists('wplc_encrypt_decrypt_msg')){
                    $msg = wplc_encrypt_decrypt_msg($msg);
                }

                $msg_array = maybe_unserialize( $msg );

                if( is_array( $msg_array ) ){
                    $msg = $msg_array['m'];
                }

                $msg = stripslashes($msg);

                $msg = apply_filters("wplc_filter_message_control_out",$msg);

                $msg = stripslashes($msg);

                $msg_hist[$id]['msg'] = $msg;
                $msg_hist[$id]['originates'] = intval($result->originates);
                $msg_hist[$id]['other'] = $other_data;

            } else {
                /* add the system notification to the list */
                if ( isset( $msg_hist[$id] ) ) { $msg_hist[$id] = array(); }

                $msg_hist[$id]['msg'] = $msg;
                $msg_hist[$id]['other'] = $other_data;
                $msg_hist[$id]['originates'] = intval($result->originates);
            }




        }

        return $msg_hist;
    }



    else {
        return "security issue";
    }


}

/**
 * Mark all messages sent by a USER as read (an agent has read them)
 *
 * @param  int      $cid    Chat ID
 * @return string           "ok"
 */
function wplc_mark_as_read_admin_chat_messages( $mid ) {
    $wplc_current_user = get_current_user_id();

    if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) ){
        global $wpdb;
        global $wplc_tblname_msgs;

        $wpdb->update(
            $wplc_tblname_msgs,
            array(
                'status' => 1
            ),
            array('id' => $mid),
            array('%d'),
            array('%d')
        );

    } else { return "security issue"; }

    return "ok";
}





function wplc_return_chat_session_variable($cid) {
    global $wpdb;
    global $wplc_tblname_chats;
    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_chats
        WHERE `id` = '$cid'
        "
    );
    foreach ($results as $result) {
        return $result->session;
    }
}



function wplc_return_chat_status($cid) {
    global $wpdb;
    global $wplc_tblname_chats;
    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_chats
        WHERE `id` = '$cid'
        "
    );
    foreach ($results as $result) {
        return $result->status;
    }
}


function wplc_return_status($status) {
    if ($status == 1) {
        return __("complete","wplivechat");
    }
    if ($status == 2) {
        return __("pending", "wplivechat");
    }
    if ($status == 3) {
        return __("active", "wplivechat");
    }
    if ($status == 4) {
        return __("deleted", "wplivechat");
    }
    if ($status == 5) {
        return __("browsing", "wplivechat");
    }
    if ($status == 6) {
        return __("requesting chat", "wplivechat");
    }
    if($status == 8){
        return __("Chat Ended - User still browsing", "wplivechat");
    }
    if($status == 9){
        return __("User is browsing but doesn't want to chat", "wplivechat");
    }

}

add_filter("wplc_filter_mail_body","wplc_filter_control_mail_body",10,2);
function wplc_filter_control_mail_body($header,$msg) {
    $primary_bg_color = apply_filters("wplc_mailer_bg_color", "#ec822c"); //Default orange
    $body = '
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">      
    <html>
    
    <body>



        <table id="" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: ' . $primary_bg_color . ';">
        <tbody>
          <tr>
            <td width="100%" style="padding: 30px 20px 100px 20px;">
              <table align="center" cellpadding="0" cellspacing="0" class="" width="100%" style="border-collapse: separate; max-width:600px;">
                <tbody>
                  <tr>
                    <td style="text-align: center; padding-bottom: 20px;">
                      
                      <p>'.$header.'</p>
                    </td>
                  </tr>
                </tbody>
              </table>

              <table id="" align="center" cellpadding="0" cellspacing="0" class="" width="100%" style="border-collapse: separate; max-width: 600px; font-family: Georgia, serif; font-size: 12px; color: rgb(51, 62, 72); border: 0px solid rgb(255, 255, 255); border-radius: 10px; background-color: rgb(255, 255, 255);">
              <tbody>
                  <tr>
                    <td class="sortable-list ui-sortable" style="padding:20px; text-align:center;">
                        '.nl2br($msg).'
                    </td>
                  </tr>
                </tbody>
              </table>

              <table align="center" cellpadding="0" cellspacing="0" class="" width="100%" style="border-collapse: separate; max-width:100%;">
                <tbody>
                  <tr>
                    <td style="padding:20px;">
                      <table border="0" cellpadding="0" cellspacing="0" class="" width="100%">
                        <tbody>
                          <tr>
                            <td id="" align="center">
                             <p>'.site_url().'</p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>


        
        </div>
    </body>
</html>
            ';
            return $body;
}


add_filter("wplc_mailer_bg_color","wplc_fitler_mailer_bg_color",10,1);
function wplc_fitler_mailer_bg_color($default_color) {
    $wplc_settings = get_option('WPLC_SETTINGS');

    if (isset($wplc_settings['wplc_theme'])) {
        $wplc_theme = $wplc_settings['wplc_theme'];
    }

    if (isset($wplc_theme)) {
        if($wplc_theme == 'theme-1') {
            $default_color = "#DB0000";
        } else if ($wplc_theme == 'theme-2'){
            $default_color = "#000000";
        } else if ($wplc_theme == 'theme-3'){
            $default_color = "#B97B9D";
        } else if ($wplc_theme == 'theme-4'){
            $default_color = "#1A14DB";
        } else if ($wplc_theme == 'theme-5'){
            $default_color = "#3DCC13";
        } else if ($wplc_theme == 'theme-6'){
            //Check what color is selected in palette
            if (isset($wplc_settings["wplc_settings_color1"])) {
                $default_color = "#" . $wplc_settings["wplc_settings_color1"];
            }
        }
    }

    return $default_color;
}

/**
 * Send an email to the admin based on the settings in the settings page
 * @param  string $reply_to      email of the user
 * @param  string $reply_to_name name of the user
 * @param  string $subject       subject
 * @param  string $msg           message being emailed
 * @return void
 * @since  5.1.00
 */
function wplcmail($reply_to,$reply_to_name,$subject,$msg) {

    $upload_dir = wp_upload_dir();

    $wplc_pro_settings = get_option("WPLC_SETTINGS");
    if(isset($wplc_pro_settings['wplc_pro_chat_email_address'])){
        $email_address = $wplc_pro_settings['wplc_pro_chat_email_address'];
    }else{
        $email_address = get_option('admin_email');
    }

    $email_address = explode(',', $email_address);

    if(get_option("wplc_mail_type") == "wp_mail" || !get_option('wplc_mail_type')){
        $headers[] = 'Content-type: text/html';
        $headers[] = 'Reply-To: '.$reply_to_name.'<'.$reply_to.'>';
        if($email_address){
            foreach($email_address as $email){
                /* Send offline message to each email address */
                $overbody = apply_filters("wplc_filter_mail_body",$subject,$msg);
                if (!wp_mail($email, $subject, $overbody, $headers)) {
                    $handle = fopen($upload_dir['basedir'].'/wp_livechat_error_log.txt', 'a');
                    $error = date("Y-m-d H:i:s") . " WP-Mail Failed to send \n";
                    @fwrite($handle, $error);
                }
            }
        }
//        $to = $wplc_pro_settings['wplc_pro_chat_email_address'];
        return;
    } else {



        //require 'phpmailer/PHPMailerAutoload.php';
        $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
        $host = get_option('wplc_mail_host');
        $port = get_option('wplc_mail_port');
        $username = get_option("wplc_mail_username");
        $password = get_option("wplc_mail_password");
        if($host && $port && $username && $password){
            //Create a new PHPMailer instance

            global $phpmailer;

            // (Re)create it, if it's gone missing
            if ( ! ( $phpmailer instanceof PHPMailer ) ) {
                require_once ABSPATH . WPINC . '/class-phpmailer.php';
                require_once ABSPATH . WPINC . '/class-smtp.php';
                $mail = new PHPMailer( true );
            }



            //$mail = new PHPMailer();


            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = $host;
            //Set the SMTP port number - likely to be 25, 26, 465 or 587
            $mail->Port = $port;
            //Set the encryption system to use - ssl (deprecated) or tls
            if($port == "587"){
                $mail->SMTPSecure = 'tls';
            } else if($port == "465"){
                $mail->SMTPSecure = 'ssl';
            }

            // Empty out the values that may be set
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
            $mail->ClearCustomHeaders();
            $mail->ClearReplyTos();


            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $mail->Username = $username;
            //Password to use for SMTP authentication
            $mail->Password = $password;
            //Set who the message is to be sent from
            $mail->setFrom($reply_to, $reply_to_name);
            //Set who the message is to be sent to
            if($email_address){
                foreach($email_address as $email){
                    $mail->addAddress($email);
                }
            }
            //Set the subject line
            $mail->Subject = $subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $body = apply_filters("wplc_filter_mail_body",$subject,$msg);
            $mail->msgHTML($body);
            //Replace the plain text body with one created manually
            $mail->AltBody = $msg;


            //send the message, check for errors
            if (!$mail->send()) {
                $handle = fopen($upload_dir['basedir'].'/wp_livechat_error_log.txt', 'a');
                $error = date("Y-m-d H:i:s")." ".$mail->ErrorInfo." \n";
                @fwrite($handle, $error);
            }
            return;
        }
    }
}
/**
 * Sends offline messages to the admin (normally via ajax)
 * @param  string $name  Name of the user
 * @param  string $email Email of the user
 * @param  string $msg   The message being sent to the admin
 * @param  int    $cid   Chat ID
 * @return void
 */
function wplc_send_offline_msg($name,$email,$msg,$cid) {
    $subject = apply_filters("wplc_offline_message_subject_filter", __("WP Live Chat Support - Offline Message from ", "wplivechat") ) . "$name";
    $msg = __("Name", "wplivechat").": $name \n".
    __("Email", "wplivechat").": $email\n".
    __("Message", "wplivechat").": $msg\n\n".
    __("Via WP Live Chat Support", "wplivechat");
    wplcmail($email,$name, $subject, $msg);
    return;
}


/**
 * Saves offline messages to the database
 * @param  string $name    User name
 * @param  string $email   User email
 * @param  string $message Message being saved
 * @return Void
 * @since  5.1.00
 */
function wplc_store_offline_message($name, $email, $message){
    global $wpdb;
    global $wplc_tblname_offline_msgs;

    $wplc_settings = get_option('WPLC_SETTINGS');

    /** DEPRECATED BY GDPR */
    /**if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ip_address = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip_address = sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }
        $offline_ip_address = $ip_address;
    } else {
        $offline_ip_address = "";
    }*/

    $offline_ip_address = "";


    $ins_array = array(
        'timestamp' => current_time('mysql'),
        'name' => sanitize_text_field($name),
        'email' => sanitize_email($email),
        'message' => implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $message ) ) ),
        'ip' => sanitize_text_field($offline_ip_address),
        'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'])
    );

    $rows_affected = $wpdb->insert( $wplc_tblname_offline_msgs, $ins_array );
    return;
}
/**
* Send what we have found as a system notification
*/
function wplc_send_welcome($cid,$wplc_settings) {

    if (!isset($wplc_settings['wplc_welcome_msg'])) { $wplc_settings['wplc_welcome_msg'] = __("Please standby for an agent. While you wait for the agent you may type your message.","wplivechat"); }
    $mdata = array(
        'msg' => $wplc_settings['wplc_welcome_msg']
    );
    wplc_record_chat_notification('await_agent',$cid,$mdata);
    return;

 }


function wplc_user_initiate_chat($name,$email,$cid = null,$session) {

    global $wpdb;
    global $wplc_tblname_chats;


    $wplc_settings = get_option('WPLC_SETTINGS');

    /** DEPRECATED BY GDPR */
    /*if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ip_address = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip_address = sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }
        $user_data = array(
            'ip' => $ip_address,
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'])
        );
        $wplc_ce_ip = $ip_address;
    } else {
        $user_data = array(
            'ip' => "",
            'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'])
        );
        $wplc_ce_ip = null;
    }*/

    $user_data = array(
        'ip' => "",
        'user_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT'])
    );
    $wplc_ce_ip = null;

    if(function_exists('wplc_ce_activate')){
        /* Log the chat for statistical purposes as well */
        if(function_exists('wplc_ce_record_initial_chat')){
            wplc_ce_record_initial_chat($name, $email, $cid, $wplc_ce_ip, sanitize_text_field($_SERVER['HTTP_REFERER']));
        }
    }

    if ($cid != null) {
        /* change from a visitor to a chat */

        /**
         * This helps us identify if this user needs to be answered. The user can start typing so long but an agent still needs to answer the chat
         * @var serialized array
         */
        $chat_data = wplc_get_chat_data($cid,__LINE__);

        if (isset($chat_data->other)) {
            $other_data = maybe_unserialize( $chat_data->other );
            $other_data['unanswered'] = true;

            $other_data = apply_filters("wplc_start_chat_hook_other_data_hook", $other_data);
            if (!isset($other_data['welcome'])) {
                //wplc_send_welcome($cid,$wplc_settings);
                $other_data['welcome'] = true;
            }

        } else {
            //wplc_send_welcome($cid,$wplc_settings);
            $other_data = array();
            $other_data['welcome'] = true;

        }


        $wpdb->update(
            $wplc_tblname_chats,
            array(
                'status' => 2,
                'timestamp' => current_time('mysql'),
                'name' => $name,
                'email' => $email,
                'session' => $session,
                'ip' => maybe_serialize($user_data),
                'url' => sanitize_text_field($_SERVER['HTTP_REFERER']),
                'last_active_timestamp' => current_time('mysql'),
                'other' => maybe_serialize($other_data)
            ),
            array('id' => $cid),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ),
            array('%d')
        );

        do_action("wplc_hook_initiate_chat",array("cid" => $cid, "name" => $name, "email" => $email));

        do_action("wplc_start_chat_hook_after_data_insert", $cid);
        return $cid;
    }
    else {
        $other_data = array();
        $other_data['unanswered'] = true;

        $other_data = apply_filters("wplc_start_chat_hook_other_data_hook", $other_data);



        $wpdb->insert(
            $wplc_tblname_chats,
            array(
                'status' => 2,
                'timestamp' => current_time('mysql'),
                'name' => $name,
                'email' => $email,
                'session' => $session,
                'ip' => maybe_serialize($user_data),
                'url' => sanitize_text_field($_SERVER['HTTP_REFERER']),
                'last_active_timestamp' => current_time('mysql'),
                'other' => maybe_serialize($other_data)
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );


        $lastid = $wpdb->insert_id;




        /* Nick: moved from top of function to bottom of function to try speed up the process of accepting the chart - version 7 */
        if (function_exists("wplc_list_chats_pro")) { /* check if functions-pro is around */
            wplc_pro_notify_via_email();
        }

        do_action("wplc_start_chat_hook_after_data_insert", $lastid);
        return $lastid;
    }

}



function wplc_get_msg() {
    return "<a href=\"javascript:void(0);\" class=\"wplc_second_chat_request button button-primary\" style='cursor:not-allowed' title=\"".__("Get Pro Add-on to accept more chats","wplivechat")."\" target=\"_BLANK\">".__("Accept Chat","wplivechat")."</a>";
}
function wplc_update_chat_statuses() {
    global $wpdb;
    global $wplc_tblname_chats;
    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_chats
        WHERE `status` = '2' OR `status` = '3' OR `status` = '5' or `status` = '8' or `status` = '9' or `status` = '10' or `status` = 12
        "
    );
    foreach ($results as $result) {
        $id = $result->id;
        $timestamp = strtotime($result->last_active_timestamp);
        $datenow = current_time('timestamp');
        $difference = $datenow - $timestamp;



        if (intval($result->status) == 2) {
            if ($difference >= 30) { // 60 seconds max
                wplc_change_chat_status($id,12);
            }
        }
        else if (intval($result->status) == 12) {
            if ($difference >= 30) { // 30 seconds max
                wplc_change_chat_status($id,0);
            }
        }
        else if (intval($result->status) == 3) {
            if ($difference >= 300) { // 5 minutes
                wplc_change_chat_status($id,1);
            }
        }
        else if (intval($result->status) == 5) {
            if ($difference >= 120) { // 2 minute timeout
                wplc_change_chat_status($id,7); // 7 - timedout
            }
        } else if(intval($result->status) == 8){ // chat is complete but user is still browsing
            if ($difference >= 45) { // 30 seconds
                wplc_change_chat_status($id,1); // 1 - chat is now complete
            }
        } else if(intval($result->status) == 9 || $result->status == 10){
            if ($difference >= 120) { // 120 seconds
                wplc_change_chat_status($id,7); // 7 - timedout
            }
        }
    }
}
function wplc_check_pending_chats(){
    global $wpdb;
    global $wplc_tblname_chats;
    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `status` = 2";
    $wpdb->query($sql);
    $results = $wpdb->get_results($sql);
    if($results){
        foreach ($results as $result) {
            $other = maybe_unserialize($result->other);
            if (isset($other['unanswered'])) {
                return true;
            }
        }

    }
    return false;
}
function wplc_get_active_and_pending_chats(){
    global $wpdb;
    global $wplc_tblname_chats;
    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `status` = 2 OR `status` = 3 ORDER BY `status`";
    $results = $wpdb->get_results($sql);
    if($results){
        return $results;
    } else {
        return false;
    }
}
function wplc_convert_array_to_string($array){
    $string = "";
    if($array){
        foreach($array as $value){
            $string.= $value->id." ;";
        }
    } else {
        $string = false;
    }
    return $string;
}

function wplc_return_browser_image($string,$size) {
    switch($string) {

        case "Internet Explorer":
            return "internet-explorer_".$size."x".$size.".png";
            break;
        case "Mozilla Firefox":
            return "firefox_".$size."x".$size.".png";
            break;
        case "Opera":
            return "opera_".$size."x".$size.".png";
            break;
        case "Google Chrome":
            return "chrome_".$size."x".$size.".png";
            break;
        case "Safari":
            return "safari_".$size."x".$size.".png";
            break;
        case "Other browser":
            return "web_".$size."x".$size.".png";
            break;
        default:
            return "web_".$size."x".$size.".png";
            break;
    }


}
function wplc_return_browser_string($user_agent) {
if(strpos($user_agent, 'MSIE') !== FALSE)
   return 'Internet Explorer';
 elseif(strpos($user_agent, 'Trident') !== FALSE) //For Supporting IE 11
    return 'Internet Explorer';
elseif(strpos($user_agent, 'Edge') !== FALSE)
    return 'Internet Explorer';
 elseif(strpos($user_agent, 'Firefox') !== FALSE)
   return 'Mozilla Firefox';
 elseif(strpos($user_agent, 'Chrome') !== FALSE)
   return 'Google Chrome';
 elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
   return "Opera";
 elseif(strpos($user_agent, 'Opera') !== FALSE)
   return "Opera";
 elseif(strpos($user_agent, 'Safari') !== FALSE)
   return "Safari";
 else
   return 'Other browser';
}

function wplc_error_directory() {
    $upload_dir = wp_upload_dir();

    if (is_multisite()) {
        if (!file_exists($upload_dir['basedir'].'/wp-live-chat-support')) {
            wp_mkdir_p($upload_dir['basedir'].'/wp-live-chat-support');
            $content = "Error log created";
            $fp = @fopen($upload_dir['basedir'].'/wp-live-chat-support/error_log.txt','w+');
            @fwrite($fp,$content);
        }
    } else {
        if (!file_exists($upload_dir['basedir'] .'/wp-live-chat-support')) {
            wp_mkdir_p($upload_dir['basedir'] . '/wp-live-chat-support');
            $content = "Error log created";
            $fp = @fopen($upload_dir['basedir'] . '/wp-live-chat-support/error_log.txt','w+');
            @fwrite($fp,$content);
        }

    }
    return true;

}

function wplc_error_log($error) {
    return;
    $upload_dir = wp_upload_dir();
    $content = "\r\n[".date("Y-m-d")."] [".date("H:i:s")."]".$error;
    $fp = @fopen($upload_dir['basedir'].'/wp-live-chat-support/error_log.txt','a+');
    @fwrite($fp,$content);
    @fclose($fp);


}
function Memory_Usage($decimals = 2) {
    $result = 0;

    if (function_exists('memory_get_usage')) {
        $result = memory_get_usage() / 1024;
    }

    else {
        if (function_exists('exec')) {
            $output = array();

            if (substr(strtoupper(PHP_OS), 0, 3) == 'WIN') {
                exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);

                $result = preg_replace('/[\D]/', '', $output[5]);
            }

            else {
                exec('ps -eo%mem,rss,pid | grep ' . getmypid(), $output);

                $output = explode('  ', $output[0]);

                $result = $output[1];
            }
        }
    }

    return number_format(intval($result) / 1024, $decimals, '.', '')." mb";
}
function wplc_get_memory_usage() {
    $size = memory_get_usage(true);
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];

}
function wplc_record_mem() {
    $upload_dir = wp_upload_dir();
    $data = array(
        'date' => current_time('mysql'),
        'php_mem' => wplc_get_memory_usage()
    );
    $fp = @fopen($upload_dir['basedir'].'/wp-live-chat-support'."/mem_usag.csv","a+");
    fputcsv($fp, $data);
    fclose($fp);
}

function wplc_admin_display_missed_chats() {

    global $wpdb;
    global $wplc_tblname_chats;


    if(isset($_GET['wplc_action']) && $_GET['wplc_action'] == 'remove_missed_cid'){
        if(isset($_GET['cid'])){
            if(isset($_GET['wplc_confirm'])){
                //Confirmed - delete
                $delete_sql = "";
                if ( empty( $_GET['cid'] ) ) {
                    exit('No CID?');
                }
                $delete_sql = "DELETE FROM $wplc_tblname_chats WHERE `id` = '".intval( sanitize_text_field( $_GET['cid'] ) )."' LIMIT 1";

                $wpdb->query($delete_sql);
                if ($wpdb->last_error) {
                    echo "<div class='update-nag' style='margin-top: 0px;margin-bottom: 5px;'>
                        ".__("Error: Could not delete chat", "wplivechat")."<br>
                      </div>";
                } else {
                     echo "<div class='update-nag' style='margin-top: 0px;margin-bottom: 5px;border-color:#67d552;'>
                        ".__("Chat Deleted", "wplivechat")."<br>
                      </div>";
                }

            } else {
                //Prompt
                echo "<div class='update-nag' style='margin-top: 0px;margin-bottom: 5px;'>
                        ".__("Are you sure you would like to delete this chat?", "wplivechat")."<br>
                        <a class='button' href='?page=wplivechat-menu-missed-chats&wplc_action=remove_missed_cid&cid=".$_GET['cid']."&wplc_confirm=1''>".__("Yes", "wplivechat")."</a> <a class='button' href='?page=wplivechat-menu-missed-chats'>".__("No", "wplivechat")."</a>
                      </div>";
            }
        }
    }

    echo "
        <table class=\"wp-list-table widefat fixed \" cellspacing=\"0\">
            <thead>
                <tr>
                    <th class='manage-column column-id'><span>" . __("Date", "wplivechat") . "</span></th>
                    <th scope='col' id='wplc_name_colum' class='manage-column column-id'><span>" . __("Name", "wplivechat") . "</span></th>
                    <th scope='col' id='wplc_email_colum' class='manage-column column-id'>" . __("Email", "wplivechat") . "</th>
                    <th scope='col' id='wplc_url_colum' class='manage-column column-id'>" . __("URL", "wplivechat") . "</th>
                    <th scope='col' id='wplc_url_colum' class='manage-column column-id'>" . __("Action", "wplivechat") . "</th>
                </tr>
            </thead>
            <tbody id=\"the-list\" class='list:wp_list_text_link'>";

	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit = 20; // number of rows in page
	$offset = ( $pagenum - 1 ) * $limit;
	if (function_exists("wplc_register_pro_version")) {
		$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM $wplc_tblname_chats WHERE (`status` = 0  OR `agent_id` = 0)" );
	} else {
		$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM $wplc_tblname_chats WHERE `status` = 0" );
	}
	$num_of_pages = ceil( $total / $limit );

    if (function_exists("wplc_register_pro_version")) {
        $sql = "SELECT * FROM $wplc_tblname_chats WHERE (`status` = 0  OR `agent_id` = 0) ORDER BY `timestamp` DESC LIMIT $limit OFFSET $offset";
    } else {
        $sql = "SELECT * FROM $wplc_tblname_chats WHERE `status` = 0 ORDER BY `timestamp` DESC LIMIT $limit OFFSET $offset";
    }

    $results = $wpdb->get_results($sql);

    if (!$results) {
        echo "<tr><td></td><td>" . __("You have not missed any chat requests.", "wplivechat") . "</td></tr>";
    } else {
        foreach ($results as $result) {

            $url = admin_url('admin.php?page=wplivechat-menu&action=history&cid=' . $result->id);
            $url2 = admin_url('admin.php?page=wplivechat-menu&action=download_history&type=csv&cid=' . $result->id);
            $url3 = "?page=wplivechat-menu-missed-chats&wplc_action=remove_missed_cid&cid=" . $result->id;
            $actions = "
                <a href='$url' class='button' title='".__('View Chat History', 'wplivechat')."' target='_BLANK' id=''><i class='fa fa-eye'></i></a> <a href='$url2' class='button' title='".__('Download Chat History', 'wplivechat')."' target='_BLANK' id=''><i class='fa fa-download'></i></a> <a href='$url3' class='button'><i class='fa fa-trash-o'></i></a>      
                ";

            echo "<tr id=\"record_" . $result->id . "\">";
            echo "<td class='chat_id column-chat_d'>" . sanitize_text_field($result->timestamp) . "</td>";
            echo "<td class='chat_name column_chat_name' id='chat_name_" . $result->id . "'><img src=\"//www.gravatar.com/avatar/" . md5($result->email) . "?s=30\"  class='wplc-user-message-avatar' /> " . sanitize_text_field($result->name) . "</td>";
            echo "<td class='chat_email column_chat_email' id='chat_email_" . $result->id . "'><a href='mailto:" . sanitize_text_field($result->email) . "' title='Email " . ".$result->email." . "'>" . sanitize_text_field($result->email) . "</a></td>";
            echo "<td class='chat_name column_chat_url' id='chat_url_" . $result->id . "'>" . esc_url($result->url) . "</td>";
            echo "<td class='chat_name column_chat_url'>".$actions."</td>";
            echo "</tr>";
        }
    }

    echo "
            </tbody>
        </table>";

	$page_links = paginate_links( array(
		'base' => add_query_arg( 'pagenum', '%#%' ),
		'format' => '',
		'prev_text' => __( '&laquo;', 'wplivechat' ),
		'next_text' => __( '&raquo;', 'wplivechat' ),
		'total' => $num_of_pages,
		'current' => $pagenum
	) );

	if ( $page_links ) {
		echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0;float:none;text-align:center;">' . $page_links . '</div></div>';
	}
}


/**
 * Compares the users IP address to the list in the banned IPs in the settings page
 * @return BOOL
 */
function wplc_is_user_banned_basic(){
    $banned_ip = get_option('WPLC_BANNED_IP_ADDRESSES');
    if($banned_ip){
        $banned_ip = maybe_unserialize($banned_ip);
        $banned = 0;
        if (is_array($banned_ip)) {
            foreach($banned_ip as $ip){

                if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
                    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                }

                if(isset($ip_address)){
                    if($ip == $ip_address){
                        $banned++;
                    }
                } else {
                    $banned = 0;
                }
            }
        } else {
            return 0;
        }
    } else {
        $banned = 0;
    }
    return $banned;
}




function wplc_return_animations_basic(){

    $wplc_settings = get_option("WPLC_SETTINGS");

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

    $animation_data = array();

    if(isset($wplc_settings['wplc_animation']) && $wplc_settings['wplc_animation'] == 'animation-1'){

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: -350px; right: 20px;';
            $wplc_animation = 'animation-1';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: -350px; left: 20px;';
            $wplc_animation = 'animation-1';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: -350px; left: 0px;';
            $wplc_box_align = "left:0; bottom:100px;";
            $wplc_animation = 'animation-1';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: -350px; right: 0px;';
            $wplc_animation = 'animation-1';
            $wplc_box_align = "right:0; bottom:100px;";
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else if (isset($wplc_settings['wplc_animation']) && $wplc_settings['wplc_animation'] == 'animation-2'){

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0px; right: -300px;';
            $wplc_animation = 'animation-2-br';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: -300px;';
            $wplc_animation = 'animation-2-bl';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: -999px;';
            $wplc_animation = 'animation-2-l';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 0px; right: -999px;';
            $wplc_animation = 'animation-2-r';
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else if (isset($wplc_settings['wplc_animation']) && $wplc_settings['wplc_animation'] == 'animation-3'){

        $wplc_animation = 'animation-3';

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0; right: 20px; display: none;';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: 20px; display: none;';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 100px; left: 0px; display: none;';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 100px; right: 0px; display: none;';
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else if (isset($wplc_settings['wplc_animation']) && $wplc_settings['wplc_animation'] == 'animation-4'){
        // Dont use an animation

        $wplc_animation = "animation-4";

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0; right: 20px; display: none;';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: 20px; display: none;';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 100px; left: 0px; display: none;';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 100px; right: 0px; display: none;';
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else {

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0; right: 20px; display: none;';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: 20px; display: none;';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 100px; left: 0px; display: none;';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 100px; right: 0px; display: none;';
        }

        $wplc_animation = 'none';

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;
    }

    return $animation_data;
}


add_action("wplc_advanced_settings_above_performance", "wplc_advanced_settings_above_performance_control", 10, 1);
function wplc_advanced_settings_above_performance_control($wplc_settings){
    $elem_trig_action = isset($wplc_settings['wplc_elem_trigger_action']) ? $wplc_settings['wplc_elem_trigger_action'] : "0";
    $elem_trig_type = isset($wplc_settings['wplc_elem_trigger_type']) ? $wplc_settings['wplc_elem_trigger_type'] : "0";
    $elem_trig_id = isset($wplc_settings['wplc_elem_trigger_id']) ? $wplc_settings['wplc_elem_trigger_id'] : "";

    echo "<tr>
            <td width='350'>
            ".__("Open chat window via", "wplivechat").":
            </td>
            <td>
                <select name='wplc_elem_trigger_action'>
                    <option value='0' ".($elem_trig_action == "0" ? "selected" : "").">".__("Click", "wplivechat")."</option>
                    <option value='1' ".($elem_trig_action == "1" ? "selected" : "").">".__("Hover", "wplivechat")."</option>
                </select>
                 ".__("element with", "wplivechat").": 
                <select name='wplc_elem_trigger_type'>
                    <option value='0' ".($elem_trig_type == "0" ? "selected" : "").">".__("Class", "wplivechat")."</option>
                    <option value='1' ".($elem_trig_type == "1" ? "selected" : "").">".__("ID", "wplivechat")."</option>
                </select>
                <input type='text' name='wplc_elem_trigger_id' value='".$elem_trig_id."'>
            </td>
          </tr>
         ";
}

/**
 * Reverse of wplc_return_chat_id_by_rel
 */
function wplc_return_chat_rel_by_id($cid) {
    global $wpdb;
    global $wplc_tblname_chats;

    $results = $wpdb->get_results("SELECT * FROM $wplc_tblname_chats WHERE `id` = '$cid' LIMIT 1");
    if ($results) {
        foreach ($results as $result) {
            if (isset($result->rel)) {
                return $result->rel;
            } else {
                return $cid;
            }
        }
    } else {
        return $cid;
    }

}

/*
 * Returns total message count for a chat
*/
function wplc_return_message_count_by_cid($cid) {
    global $wpdb;
    global $wplc_tblname_msgs;

    $sql = "SELECT `id` FROM $wplc_tblname_msgs WHERE `chat_sess_id` = '$cid'";
    $results = $wpdb->get_results($sql);

    $message_count = 0;
    foreach ($results as $result) {
        $message_count ++;
    }

    return $message_count;
}