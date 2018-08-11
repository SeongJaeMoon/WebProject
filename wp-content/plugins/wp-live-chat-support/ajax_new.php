<?php

add_action('wp_ajax_wplc_admin_long_poll', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_admin_long_poll_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_admin_accept_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_admin_close_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_admin_send_msg', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_call_to_server_visitor', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_user_close_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_user_minimize_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_user_maximize_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_user_send_msg', 'wplc_init_ajax_callback');
add_action('wp_ajax_wplc_start_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_nopriv_wplc_start_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_nopriv_wplc_call_to_server_visitor', 'wplc_init_ajax_callback');
add_action('wp_ajax_nopriv_wplc_user_close_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_nopriv_wplc_user_minimize_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_nopriv_wplc_user_maximize_chat', 'wplc_init_ajax_callback');
add_action('wp_ajax_nopriv_wplc_user_send_msg', 'wplc_init_ajax_callback');

add_action('wp_ajax_wplc_get_chat_box', 'wplc_init_ajax_callback');
add_action('wp_ajax_nopriv_wplc_get_chat_box', 'wplc_init_ajax_callback');
 
function wplc_init_ajax_callback() {
    @ob_start();

    $wplc_session_id = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    $check = check_ajax_referer( 'wplc', 'security' );

    if ($check == 1) {

        $wplc_advanced_settings = get_option("wplc_advanced_settings");
        if (!$wplc_advanced_settings) {
            $wplc_delay_between_updates = 500000;
            $wplc_delay_between_loops = 500000;
            $wplc_iterations = 55;
        } else {
            if (isset($wplc_advanced_settings['wplc_delay_between_updates'])) { $wplc_delay_between_updates = intval($wplc_advanced_settings['wplc_delay_between_updates']); } else { $wplc_delay_between_updates = 500000; }
            if (isset($wplc_advanced_settings['wplc_delay_between_loops'])) { $wplc_delay_between_loops = intval($wplc_advanced_settings['wplc_delay_between_loops']); } else { $wplc_delay_between_loops = 500000; }
            if (isset($wplc_advanced_settings['wplc_iterations'])) { $wplc_iterations = intval($wplc_advanced_settings['wplc_iterations']); } else { $wplc_iterations = 55; }

            if ($wplc_iterations < 10) { $wplc_iterations = 10; }
            if ($wplc_iterations > 200) { $wplc_iterations = 200; }

            if ($wplc_delay_between_updates < 250000) { $wplc_delay_between_updates = 250000; }
            if ($wplc_delay_between_updates > 1000000) { $wplc_delay_between_updates = 1000000; }

            if ($wplc_delay_between_loops < 250000) { $wplc_delay_between_loops = 250000; }
            if ($wplc_delay_between_loops > 1000000) { $wplc_delay_between_loops = 1000000; }

        }


        $iterations = $wplc_iterations;



        /* time in microseconds between updating the user on the page within the DB  (lower number = higher resource usage) */
        define('WPLC_DELAY_BETWEEN_UPDATES', $wplc_delay_between_updates);
        /* time in microseconds between long poll loop (lower number = higher resource usage) */
        define('WPLC_DELAY_BETWEEN_LOOPS', $wplc_delay_between_loops);
        /* this needs to take into account the previous constants so that we dont run out of time, which in turn returns a 503 error */
        define('WPLC_TIMEOUT', (((WPLC_DELAY_BETWEEN_UPDATES + WPLC_DELAY_BETWEEN_LOOPS)) * $iterations) / 1000000);



        global $wpdb;
        global $wplc_tblname_chats;
        global $wplc_tblname_msgs;
        /* we're using PHP 'sleep' which may lock other requests until our script wakes up. Call this function to ensure that other requests can run without waiting for us to finish */
        session_write_close();

        if ($_POST['action'] == "wplc_get_chat_box") {
            $continue = apply_filters( "wplc_version_check_continue", true );
            if ($continue === true) {
                echo wplc_output_box_5100(sanitize_text_field($_POST['cid']));
            } else {
                echo $continue;
            }
            die();
        }

        if($_POST['action'] == 'wplc_admin_long_poll'){
             // header("HTTP/1.0 500"); //Simulate 500 error
             // header("HTTP/1.0 404"); //Simulate 404 error
             // die();
			 
            if (defined('WPLC_TIMEOUT')) { @set_time_limit(WPLC_TIMEOUT); } else { @set_time_limit(120); }
            //sleep(6);
            $i = 1;
             $wplc_current_user = get_current_user_id();

            /* If user is either an agent or an admin, access the page. */
            if( !get_user_meta( $wplc_current_user, 'wplc_ma_agent', true )) {
                $array['error'] = 1;
                echo json_encode($array);
                exit();
            }
			
            while($i <= $iterations){
                
                
                
                if($i %round($iterations/2) == 0) {
                    wplc_update_chat_statuses();
                }
                
               

                if($_POST['wplc_update_admin_chat_table'] == 'false'){
                    /* this is a new load of the page, return false so we can force a send of the new visitor data */
                    $old_chat_data = false;
                } else {
                    $old_chat_data = stripslashes($_POST['wplc_update_admin_chat_table']);
                }
                
                $pending = wplc_check_pending_chats();
                $new_chat_data = wplc_list_chats_new($_POST);
                

                if ($new_chat_data == "false") { $new_chat_data = false; }


                if($new_chat_data !== $old_chat_data){
                    $array['old_chat_data'] = $old_chat_data;
                    $array['wplc_update_admin_chat_table'] = $new_chat_data;
                    $array['pending'] = $pending;
                    $array['action'] = "wplc_update_chat_list";
                    
                }
                
                if(isset($array)){
                    echo json_encode($array);
                    break;
                }
                @ob_end_flush();
                if (defined('WPLC_DELAY_BETWEEN_LOOPS')) { usleep(WPLC_DELAY_BETWEEN_LOOPS); } else { usleep(500000); }
                $i++;
            }
        }
        if($_POST['action'] == "wplc_admin_long_poll_chat"){
            if (defined('WPLC_TIMEOUT')) { @set_time_limit(WPLC_TIMEOUT); } else { @set_time_limit(120); }
            $i = 1;
            $cdata = wplc_get_chat_data($_POST['cid']);
            $array = array();
            while($i <= $iterations){
                $array = apply_filters("wplc_filter_admin_long_poll_chat_loop_iteration",$array,$_POST,$i,$cdata);
                if($array){
                    echo json_encode($array);
                    break;
                }
                @ob_end_flush();
                if (defined('WPLC_DELAY_BETWEEN_LOOPS')) { usleep(WPLC_DELAY_BETWEEN_LOOPS); } else { usleep(500000); }
                $i++;
            }
        }
        if ($_POST['action'] == "wplc_admin_accept_chat") {
            wplc_admin_accept_chat(sanitize_text_field($_POST['cid']));
        }
        if ($_POST['action'] == "wplc_admin_close_chat") {
            $chat_id = sanitize_text_field($_POST['cid']);
            wplc_change_chat_status($chat_id,1);        
            echo 'done';        
        }
        if ($_POST['action'] == "wplc_admin_send_msg") {
            $chat_id = sanitize_text_field($_POST['cid']);           
            $chat_msg = strip_tags($_POST['msg'], '<a><p><img><hr>');            
            $wplc_rec_msg = wplc_record_chat_msg("2",$chat_id,$chat_msg);
            if ($wplc_rec_msg) {
                echo 'sent';
            } else {
                echo "There was an error sending your chat message. Please contact support";
            }
        }

        //User Ajax
        
        if($_POST['action'] == 'wplc_call_to_server_visitor'){



            $wplc_settings = get_option("WPLC_SETTINGS");

            
            if (defined('WPLC_TIMEOUT')) { @set_time_limit(WPLC_TIMEOUT); } else { @set_time_limit(120); }
            $i = 1;
            $array = array("check" => false);
            $array['debug'] = "";

            $cdata = false;
            if($_POST['cid'] == null || $_POST['cid'] == "" || $_POST['cid'] == "null" || $_POST['cid'] == 0){ } else {
                /* get agent ID */


                $cdata = wplc_get_chat_data(sanitize_text_field(intval($_POST['cid'])),__LINE__);
                $from = __("Admin","wplivechat"); /* set default */

                $array['aname'] = apply_filters("wplc_filter_admin_from", $from, $_POST['cid'],$cdata);
            
            }
            
            while($i <= $iterations) {
                
                if($i %round($iterations/2) == 0) {
                    wplc_update_chat_statuses();
                }



                if($_POST['cid'] == null || $_POST['cid'] == "" || $_POST['cid'] == "null" || $_POST['cid'] == 0){
    //                echo 1;
                    
                    if( isset( $_POST['wplc_name'] ) && $_POST['wplc_name'] !== '' ){
                        $user = sanitize_text_field($_POST['wplc_name']);                        
                    } else {
                        $user = "Guest";    
                    }
                    
                    if( isset( $_POST['wplc_email'] ) && $_POST['wplc_email'] !== '' ){
                        $email = sanitize_text_field($_POST['wplc_email']);    
                    } else {
                        $email = "no email set";    
                    }

                    if(isset($_POST['wplc_is_mobile']) && ($_POST['wplc_is_mobile'] === 'true' || $_POST['wplc_is_mobile'] === true)){
                        $is_mobile = true;
                    } else {
                        $is_mobile = false;
                    }
                     
                    $cid = wplc_log_user_on_page($user,$email,sanitize_text_field($_POST['wplcsession']), $is_mobile);
                    $array['cid'] = $cid;
                    $array['status'] = wplc_return_chat_status($cid);
                    $array['wplc_name'] = $user;
                    $array['wplc_email'] = $email;
                    $array['check'] = true;        

                } else {
    //                echo 2;
                    



                    $new_status = wplc_return_chat_status(sanitize_text_field($_POST['cid']));
                    $array['wplc_name'] = sanitize_text_field($_POST['wplc_name']);
                    $array['wplc_email'] = sanitize_text_field($_POST['wplc_email']);
                    $array['cid'] = sanitize_text_field($_POST['cid']);
                    $array['aid'] = sanitize_text_field($_POST['cid']);

                    $array = apply_filters("wplc_filter_user_long_poll_chat_loop_iteration",$array,$_POST,$i,$cdata);


                    if($new_status == $_POST['status']){ // if status matches do the following
                        if( intval( $_POST['status'] ) != 2){
                            /* check if session_variable is different? if yes then stop this script completely. */
                            if (isset($_POST['wplcsession']) && $_POST['wplcsession'] != '' && $i > 1) {
                                $wplc_session_variable = sanitize_text_field($_POST['wplcsession']);
                                $current_session_variable = wplc_return_chat_session_variable(sanitize_text_field($_POST['cid']));
                                if ($current_session_variable != "" && $current_session_variable != $wplc_session_variable) {
                                    /* stop this script */
                                    $array['status'] = 11;
                                    echo json_encode($array);
                                    die();
                                }
                            }


                            if ($i == 1) {
                                if (intval( $_POST['status'] ) != 12) {
                                    /* we dont want to update the time if the user was not answered by the agent as this needs to eventually time out and become a "missed chat" - status: 0 */
                                    wplc_update_user_on_page(sanitize_text_field($_POST['cid']), sanitize_text_field($_POST['status']), sanitize_text_field($_POST['wplcsession']));
                                }
                            }
                        }
                        
                        if ( intval( $_POST['status'] ) == 0 || intval($_POST['status'] ) == 12 ){ // browsing - user tried to chat but admin didn't answer so turn back to browsing
                            //wplc_update_user_on_page(sanitize_text_field($_POST['cid']), 0, sanitize_text_field($_POST['wplcsession']));
                            //$array['status'] = 5;
                            $array['status'] = 12;
                            //$array['check'] = true;
                            
                        } 
                        else if( intval($_POST['status'] ) == 3 || intval($_POST['status'] ) == 10){
                            //wplc_update_user_on_page(sanitize_text_field($_POST['cid']), 3);
                            $messages = wplc_return_user_chat_messages(sanitize_text_field($_POST['cid']),$wplc_settings,$cdata);
	                        if ( intval( $_POST['status'] ) == 10 ) {
		                        $array['alert'] = true;
	                        }
                            if ($messages){
                                wplc_mark_as_read_user_chat_messages( sanitize_text_field($_POST['cid']) );
                                $array['status'] = 3;
                                $array['data'] = $messages;
                                $array['check'] = true;
                            }
                        } 
                        else if(intval($_POST['status']) == 2){
                            //wplc_update_user_on_page(sanitize_text_field($_POST['cid']), 3);
                            $messages = wplc_return_user_chat_messages(sanitize_text_field($_POST['cid']),$wplc_settings,$cdata);
                            $array['debug'] = "we are here ".__LINE__;
                            if ($messages){
                                wplc_mark_as_read_user_chat_messages(sanitize_text_field($_POST['cid']));
                                $array['status'] = 2;
                                $array['data'] = $messages;
                                $array['check'] = true;
                            }
                        } 
                        else if( intval( $new_status ) == 12){ // no answer from admin, for the second+ time.
                            $array['data'] = wplc_return_no_answer_string(sanitize_text_field($_POST['cid']));
                            $array['check'] = true;
                            @do_action("wplc_hook_missed_chat",array("cid" => $_POST['cid'],"name" => $_POST['wplc_name'],"email" => $_POST['wplc_email']));
                            
                        } 


                        /* check if this is part of the first run */
                        if (isset($_POST['first_run']) && sanitize_text_field($_POST['first_run']) == 1) {
                            /* if yes, then send data now and dont wait for all iterations to complete */
                            if (!isset($array['status'])) { $array['status'] = $new_status; }
                            $array['check'] = true;
                        } 
                        else if (isset($_POST['short_poll']) && sanitize_text_field($_POST['short_poll']) == "true") {
                            /* if yes, then send data now and dont wait for all iterations to complete */
                            if (!isset($array['status'])) { $array['status'] = $new_status; }
                            $array['check'] = true;
                        }
                    } else { // statuses do not match

                        $array['debug'] = $array['debug']. " ". "Doesnt match $new_status ".$_POST['status'];
                        $array['status'] = $new_status;
                        if( intval( $new_status ) == 1 ){ // completed
                            wplc_update_user_on_page( sanitize_text_field( $_POST['cid'] ), 8, sanitize_text_field( $_POST['wplcsession'] ) );
                            $array['check'] = true;
                            $array['status'] = 8;
                            $array['data'] = array();
                            $array['data'][9999] = array();
                            $array['data'][9999]['msg'] =  __("Admin has closed and ended the chat","wplivechat");

                        }
                        else if( intval( $new_status ) == 2 ) { // pending
                            $array['debug'] = "we are here ".__LINE__;
                            $array['check'] = true;
                            $array['wplc_name'] = wplc_return_chat_name( sanitize_text_field($_POST['cid'] ) );
                            $array['wplc_email'] = wplc_return_chat_email( sanitize_text_field($_POST['cid'] ) );
                            $messages = wplc_return_chat_messages( sanitize_text_field($_POST['cid']), false, true, $wplc_settings, $cdata, 'array', false );
                            if ($messages){
                                $array['data'] = $messages;
                            }
                        }
                        else if( intval( $new_status ) == 3 ){ // active
                            $array['data'] = null;
                            $array['check'] = true;

                            if($_POST['status'] == 5 || $_POST['status'] == 3){
	                            $array['sound'] = false;
	                            $messages = wplc_return_chat_messages(sanitize_text_field($_POST['cid']),false,true,$wplc_settings,$cdata,'array',false);
                                if ($messages){
                                    $array['data'] = $messages;
                                }
                            } 
                        }
                        else if( intval( $new_status ) == 7){ // timed out
                            wplc_update_user_on_page(sanitize_text_field($_POST['cid']), 5, sanitize_text_field($_POST['wplcsession']));
                        }
                        else if( intval( $new_status ) == 9){ // user closed chat without inputting or starting a chat
                            $array['check'] = true;
                        } 
                        else if( intval( $new_status ) == 12){ // no answer from admin

                            $array['data'] = wplc_return_no_answer_string(sanitize_text_field($_POST['cid']));
                            $array['check'] = true;
                            wplc_update_user_on_page(sanitize_text_field($_POST['cid']), 12, sanitize_text_field($_POST['wplcsession']));                            
                            @do_action("wplc_hook_missed_chat",array("cid" => $_POST['cid'],"name" => $_POST['wplc_name'],"email" => $_POST['wplc_email']));
                            
                        } 
                        else if( intval( $new_status ) == 10 ) { // minimized active chat
                            $array['check'] = true;
                            if($_POST['status'] == 5){
                                $messages = wplc_return_chat_messages(sanitize_text_field($_POST['cid']),false,true,$wplc_settings,$cdata,'array',false);
                                if ($messages){
                                    $array['data'] = $messages;
                                }
                            }
                        }
                        /* check if this is part of the first run */
                        if (isset($_POST['first_run']) && sanitize_text_field($_POST['first_run']) == "1") {
                            /* if yes, then send data now and dont wait for all iterations to complete */
                            if (!isset($array['status'])) { $array['status'] = $new_status; }
                            $array['check'] = true;
                        } 
                        else if (isset($_POST['short_poll']) && sanitize_text_field($_POST['short_poll']) == "true") {
                            /* if yes, then send data now and dont wait for all iterations to complete */
                            if (!isset($array['status'])) { $array['status'] = $new_status; }
                            $array['check'] = true;
                        }                         
                        $array = apply_filters("wplc_filter_wplc_call_to_server_visitor_new_status_check",$array);  
                        
                    }
                }
                if($array['check'] == true){
                    echo json_encode($array);
                    break;
                }
                $i++;

                if (defined('WPLC_DELAY_BETWEEN_LOOPS')) { usleep(WPLC_DELAY_BETWEEN_LOOPS); } else { usleep(500000); }

                @ob_end_flush();
            }
        }
        
    /*  */
        if ($_POST['action'] == "wplc_user_close_chat") {
            if($_POST['status'] == 5){
                wplc_change_chat_status(sanitize_text_field($_POST['cid']),9);
            } else if($_POST['status'] == 3){
                wplc_change_chat_status(sanitize_text_field($_POST['cid']),8);
            }
        }

        if ($_POST['action'] == "wplc_user_minimize_chat") {
            $chat_id = sanitize_text_field($_POST['cid']);
            wplc_change_chat_status(sanitize_text_field($_POST['cid']),10);
        }
        if ($_POST['action'] == "wplc_user_maximize_chat") {
            $chat_id = sanitize_text_field($_POST['cid']); 
            $chat_status = intval(sanitize_text_field($_POST['chat_status'])); 
            wplc_change_chat_status(sanitize_text_field($_POST['cid']),$chat_status);
        }

        if ($_POST['action'] == "wplc_user_send_msg") {
            $chat_id = sanitize_text_field($_POST['cid']);
            $chat_msg = strip_tags($_POST['msg'], '<p><a><img><hr>');
            $wplc_rec_msg = wplc_record_chat_msg("1",$chat_id,$chat_msg);
            if ($wplc_rec_msg) {
                echo 'sent';
            } else {
                echo "There was an error sending your chat message. Please contact support";
            }
        }
        if ($_POST['action'] == "wplc_start_chat") {
            if (isset($_POST['cid'])) {
                if ($_POST['name'] && $_POST['email']) {
                    echo wplc_user_initiate_chat(sanitize_text_field($_POST['name']),sanitize_email($_POST['email']),sanitize_text_field($_POST['cid']), sanitize_text_field($_POST['wplcsession'])); // echo the chat session id
                } else {
                    echo "error2";
                }
            } else {
                if ($_POST['name'] && $_POST['email']) {
                    echo wplc_user_initiate_chat(sanitize_text_field($_POST['name']), sanitize_email($_POST['email']), null, sanitize_text_field($_POST['wplcsession'])); // echo the chat session id
                } else {
                    echo "error2";
                }
            }
        }
        
    }

    die();
}