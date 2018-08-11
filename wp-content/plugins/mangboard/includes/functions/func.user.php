<?php

if(!function_exists('mbw_set_user_point')){
	function mbw_set_user_point($target,$action,$add_point=0,$user_pid="0",$user_name=""){
		global $mstore,$mdb;
		global $mb_admin_tables,$mb_fields,$mb_board_table_name,$mb_comment_table_name;
		$point		= 0;
		$sign			= "";
		
		if(mbw_is_login() || !empty($user_pid)){		
			if($target=="comment"){

				if($action=="write" || $action=="reply" || $action=="delete"){
					$sign			= "+";
					$point		= intval(mbw_get_board_option("fn_point_comment_write"));
				}

				if($action=="delete"){
					$point		= $point*(-1);
					$comment_pid	= mbw_get_param("comment_pid");
					if(!empty($comment_pid)){						
						$user_pid		= $mdb->get_var($mdb->prepare("select ".$mb_fields["select_comment"]["fn_user_pid"]." from `".$mb_comment_table_name."` where `".$mb_fields["select_comment"]["fn_pid"]."`=%d limit 1", $comment_pid));
					}
				}
				if($point<0){
					$sign			= "-";
					$point		= $point*(-1);
				}
			}else if($target=="board"){
				$sign			= "+";
				if($action=="write")	$point		= intval(mbw_get_board_option("fn_point_board_write"));
				else if($action=="reply")	$point		= intval(mbw_get_board_option("fn_point_board_reply"));
				else if($action=="delete"){
					$point			= intval(mbw_get_board_option("fn_point_board_write"))*(-1);
					$board_pid		= mbw_get_param("board_pid");
					if(!empty($board_pid)){						
						$user_pid		= $mdb->get_var($mdb->prepare("select ".$mb_fields["select_board"]["fn_user_pid"]." from `".$mb_board_table_name."` where `".$mb_fields["select_board"]["fn_pid"]."`=%d limit 1", $board_pid));
					}
				}
				if($point<0){
					$sign			= "-";
					$point		= $point*(-1);
				}
			}else if($target=="user"){
				$sign			= "+";
				if($action=="join")	$point		= intval(mbw_get_option("user_join_point"));
				if($action=="login")	$point		= intval(mbw_get_option("user_login_point"));
			}else{
				if($add_point>=0) $sign			= "+";
				else{
					$sign				= "-";
					$add_point		= $add_point*(-1);
				}
				$point		= $add_point;
			}
			$user_point		= intval(mbw_get_user("fn_user_point"));

			if($sign!="" && $point!=0){
				if($sign=="-" && $point>$user_point && ($action=="write" || $action=="reply")){
					mbw_error_message("포인트 잔액이 부족합니다<br>(".($point-$user_point)." Point)","","1000");
				}else{
					//User 포인트가 차감 포인트 보다 작을 경우 0포인트로 설정
					if(mbw_is_login() && $sign=="-" && $point>$user_point){
						$point		= $user_point;
					}
					
					$options		= array("mode"=>$target,"board_action"=>$action,"board_name"=>"users");
					if(empty($user_pid)) $user_pid		= mbw_get_user("fn_pid");				
					else{
						$options["user_pid"]			= $user_pid;
						if(empty($user_name)) $options["user_name"]		= $mdb->get_var($mdb->prepare("select ".$mb_fields["users"]["fn_user_name"]." from `".$mb_admin_tables["users"]."` where `".$mb_fields["users"]["fn_pid"]."`=%d limit 1", $user_pid));					
						else $options["user_name"]		= $user_name;
					}
					
					if(!empty($user_pid)) {
						$mdb->query($mdb->prepare("update ".$mb_admin_tables["users"]." set ".$mb_fields["users"]["fn_user_point"]."=".$mb_fields["users"]["fn_user_point"].$sign.$point." where ".$mb_fields["users"]["fn_pid"]."=%d",$user_pid));				
						do_action('mbw_user_point');

						//포인트 로그 남기기
						if(mbw_get_option("point_log")) mbw_set_log("point",$sign.$point,$options);				
					}
				}
			}
		}
	}
}


if(!function_exists('mbw_set_wp_user_data')){
	function mbw_set_wp_user_data($user_id=NULL){
		if(mbw_get_trace("mbw_set_wp_user_data")!="") return;

		mbw_add_trace("mbw_set_wp_user_data");
		global $mstore,$mdb;
		global $mb_admin_tables,$mb_fields;

		$send_data			= array();
		$where_data		= array();
		$cookie				= "";
		$user_mode		= "WP";
		
		if(empty($user_id)){		
			if($mstore->is_login_cookie()){				
				$cookie					= $mstore->get_login_cookie();
				$cookie_elements		= explode('|', $cookie);
				list($user_id, $expiration, $hmac, $user_mode) = $cookie_elements;
			}
		}

		if(empty($mb_admin_tables["users"])) return;		
		if(!empty($user_id)){
			$today_date			= $mstore->get_current_date();
			$point_type				= "";
			$log_type				= "";
			$field						= $mb_fields["users"];
			
			if(empty($cookie)){
				
				$user_check			= intval($mdb->get_var(mbw_get_add_query(array("column"=>"count(*)","table"=>$mb_admin_tables["users"]), array(array("field"=>$field["fn_user_id"],"value"=>$user_id)))));	

				if($user_check==0 && function_exists('wp_get_current_user')){
					$user																	= wp_get_current_user();
					if(!empty($user) && !empty($user->data->user_login)){
						$send_data[$field["fn_wp_user_pid"]]					= $user->data->ID;
						$send_data[$field["fn_user_id"]]							= $user->data->user_login;
						$send_data[$field["fn_user_email"]]						= $user->data->user_email;
						if(!empty($user->data->user_email))
							$send_data[$field["fn_reg_mail"]]					= 1;

						if(current_user_can("administrator")) $send_data[$field["fn_user_level"]]	= 10;

						$send_data[$field["fn_user_platform"]]					= "wp";
						$send_data[$field["fn_user_name"]]						= $user->data->display_name;
						$send_data[$field["fn_user_homepage"]]				= $user->data->user_url;
						$send_data[$field["fn_user_picture"]]					= get_user_meta( $user->data->ID, "mb_thumbnail", true );

						$send_data[$field["fn_passwd"]]							= $user->data->user_pass;
						$send_data[$field["fn_user_auth_key"]]					= mbw_get_user_auth_key();
						$send_data[$field["fn_reg_date"]]						= mbw_get_current_time();
						$send_data[$field["fn_last_login"]]						= mbw_get_current_time();
						$send_data[$field["fn_user_access_token"]]			= mbw_generate_access_token();

						//회원 가입 포인트 지급
						$join_point		= intval(mbw_get_option("user_join_point"));
						if($join_point>0) $send_data[$field["fn_user_point"]]			= $join_point;

						$mdb->db_query("INSERT",$mb_admin_tables["users"], $send_data, $where_data);
						//회원 포인트 로그
						if($join_point>0 && mbw_get_option("point_log")) {
							$user_pid	= ($mdb->get_var("select ".$field["fn_pid"]." from `".$mb_admin_tables["users"]."` ORDER BY ".$field["fn_pid"]." DESC limit 1"));
							mbw_set_log("point","+".$join_point,array("mode"=>"user","board_action"=>"join","board_name"=>"users","user_pid"=>$user_pid,"user_name"=>$user->data->display_name));
						}
						mbw_analytics("today_join");
						$log_type																					= "join";
					}
					
				}else{
					$log_type																					= "login";
					$user_data						= $mdb->get_row($mdb->prepare("select ".$field["fn_last_login"].",".$field["fn_login_count"]." from `".$mb_admin_tables["users"]."` where `".$field["fn_user_id"]."`=%s",$user_id),ARRAY_A);
					if(!empty($user_data)){
						$user_last_login			= $user_data[$field["fn_last_login"]];
						$user_login_count		= intval($user_data[$field["fn_login_count"]]);

						if((mbw_get_option("user_login_point"))>0){						
							if(strpos($user_last_login,$today_date)===false){
								$point_type			= $log_type;
							}
						}
						if($user_mode=="WP" && function_exists('wp_get_current_user')){
							$user															= wp_get_current_user();
							if(!empty($user->data->user_email)){
								$send_data[$field["fn_user_email"]]					= $user->data->user_email;
								$send_data[$field["fn_reg_mail"]]					= 1;
							}
							//if(!empty($user->data->display_name)) $send_data[$field["fn_user_name"]]					= $user->data->display_name;
							if(!empty($user->data->user_pass)) $send_data[$field["fn_passwd"]]								= $user->data->user_pass;
						}

						//마지막 로그인 시간 수정
						$send_data[$field["fn_last_login"]]									= mbw_get_current_time();
						//$send_data[$field["fn_user_auth_key"]]								= mbw_get_user_auth_key();
						$send_data[$field["fn_login_count"]]								= $user_login_count+1;										
						$send_data[$field["fn_user_access_token"]]						= mbw_generate_access_token();
						$where_data[$field["fn_user_id"]]									= $user_id;

						$mdb->db_query("UPDATE",$mb_admin_tables["users"], $send_data, $where_data);
					}
				}
			}
			
			//회원 데이타 디비에서 가져오기
			$mstore->set_user_data($user_id);
			do_action('mbw_user_login');

			//로그인 포인트 설정
			if(!empty($point_type))	mbw_set_user_point("user",$point_type);
			if(!empty($log_type) && mbw_get_option("login_log")) mbw_set_log($log_type,"",array("mode"=>"user","board_action"=>$log_type,"board_name"=>"users"));
		}
	}
}

if(!function_exists('mbw_synchronize_wp_user_data')){
	function mbw_synchronize_wp_user_data($user_id=NULL){
		mbw_add_trace("mbw_synchronize_wp_user_data");
		global $mstore,$mdb;
		global $mb_admin_tables,$mb_fields;
		
		$where_data				= array();
		$size							= 1000;
		$synchronize_count		= 0;

		$synchronize_index				= get_option("mb_user_synchronize_index");
		if(empty($synchronize_index)) $synchronize_index		= 0;
		$synchronize_index				= intval($synchronize_index);

		$wp_users			= $mdb->get_results("select * from ".$mdb->wp_prefix."users order by ID ASC limit ".$synchronize_index	.",".$size, ARRAY_A);
		$field					= $mb_fields["users"];		

		foreach($wp_users as $user){
			$user_check			= intval($mdb->get_var(mbw_get_add_query(array("column"=>"count(*)","table"=>$mb_admin_tables["users"]), array(array("field"=>$field["fn_user_id"],"value"=>$user["user_login"])))));	

			if($user_check==0){
				$send_data						= array();
				$send_data[$field["fn_wp_user_pid"]]					= $user["ID"];
				$send_data[$field["fn_user_id"]]							= $user["user_login"];
				$send_data[$field["fn_user_email"]]						= $user["user_email"];
				if(!empty($user["user_email"]))
					$send_data[$field["fn_reg_mail"]]					= 1;
				$send_data[$field["fn_user_platform"]]					= "wp";
				$send_data[$field["fn_user_name"]]						= $user["display_name"];
				$send_data[$field["fn_user_picture"]]					= $user["user_url"];
				$send_data[$field["fn_passwd"]]							= $user["user_pass"];
				$access_token			= wp_generate_password( 20, false );
				$send_data[$field["fn_user_access_token"]]			= $access_token;
				$send_data[$field["fn_user_auth_key"]]					= md5($access_token);
				$send_data[$field["fn_reg_date"]]						= mbw_get_current_time();
				$send_data[$field["fn_last_login"]]						= mbw_get_current_time();				
				$mdb->db_query("INSERT",$mb_admin_tables["users"], $send_data, $where_data);
				$synchronize_count++;
			}
		}		
		update_option("mb_user_synchronize_index",($synchronize_index+count($wp_users)));
		return $synchronize_count;
	}
}

if(!function_exists('mbw_get_user_auth_key')){
	function mbw_get_user_auth_key(){		
		return md5(mbw_generate_access_token());
	}
}

if(!function_exists('mbw_wp_insert_user')){
	function mbw_wp_insert_user($userdata){
		return wp_insert_user( $userdata );
	}
}



if(!function_exists('mbw_is_user_join')){
	function mbw_is_user_join(){
		global $mstore;
		if(mbw_get_option("show_user_picture") || mbw_get_option("show_user_level"))
			return true;
		else 
			return false;
	}
}

if(!function_exists('mbw_get_user_url')){
	function mbw_get_user_url($type="",$mode=""){
		global $mstore;
		if(!empty($mode)){
			$user_mode		= $mode;
		}else if(mbw_get_option("user_form_mode")!=""){
			$user_mode		= strtoupper(mbw_get_option("user_form_mode"));
			if(strtoupper(mbw_get_option("user_mode"))=="MB") $user_mode		= "MB";
		}else{
			$user_mode		= strtoupper(mbw_get_option("user_mode"));
		}
		$user_url			= array("register"=>"","lost_password"=>"","login"=>"","logout"=>"","user_info"=>"","modify_password"=>"","privacy_policy"=>"","terms_service"=>"");
		$site_url				= mbw_get_ssl_url(MBW_HOME_URL);		
		if($user_mode=="MB"){			
			if($type=="login"){
				$user_url["login"]						= mbw_check_permalink(mbw_get_option("post_user_login"), $site_url);
			}else{
				$user_url["login"]						= mbw_check_permalink(mbw_get_option("post_user_login"), $site_url);
				$user_url["register"]					= mbw_check_permalink(mbw_get_option("post_user_register"), $site_url);
				$user_url["lost_password"]			= mbw_check_permalink(mbw_get_option("post_user_lost_password"), $site_url);
				$user_url["user_info"]				= mbw_check_permalink(mbw_get_option("post_user_info"), $site_url);
				//$user_url["logout"]					= mbw_check_permalink(mbw_get_option("post_user_logout"), $site_url);
				$user_url["logout"]					= $site_url.'/?mb_user=logout';

				$user_url["modify_password"]		= mbw_check_permalink(mbw_get_option("post_user_modify_password"), $site_url);
				$user_url["privacy_policy"]			= mbw_check_permalink(mbw_get_option("post_user_privacy_policy"), $site_url);
				$user_url["terms_service"]			= mbw_check_permalink(mbw_get_option("post_user_terms_service"), $site_url);
				}
		}else{
			if($type=="login"){
				if(mbw_get_option("user_form_mode")=="" || !function_exists('mbw_login_url_filter')){
					$user_url["login"]						= wp_login_url();
				}else{
					//이전 버젼 때문에 임시적으로 유지하는 코드, 차후 삭제 예정
					$user_url["login"]						= $site_url.'/wp-login.php';
				}
			}else{
				if(mbw_get_option("user_form_mode")=="" || !function_exists('mbw_login_url_filter')){
					if(function_exists('wp_registration_url')) $user_url["register"]					= wp_registration_url();
					if(function_exists('wp_lostpassword_url')) $user_url["lost_password"]			= wp_lostpassword_url();
					if(function_exists('wp_login_url')) $user_url["login"]			= wp_login_url();
					if(function_exists('wp_logout_url') && function_exists('wp_create_nonce')) $user_url["logout"]	= wp_logout_url();
					if(function_exists('get_edit_profile_url')) $user_url["user_info"]				= get_edit_profile_url();
				}else{
					//이전 버젼 때문에 임시적으로 유지하는 코드, 차후 삭제 예정
					$user_url["register"]					= $site_url.'/wp-login.php?action=register';
					$user_url["lost_password"]			= $site_url.'/wp-login.php?action=lostpassword';
					$user_url["login"]						= $site_url.'/wp-login.php';			
					$user_url["logout"]					= $site_url.'/wp-login.php?action=logout';
					$user_url["user_info"]				= "";
				}

				$user_url["modify_password"]		= "";
				$user_url["privacy_policy"]			= "";
				$user_url["terms_service"]			= "";
				if(mbw_get_option("post_user_modify_password")!="") $user_url["modify_password"]		= mbw_check_permalink(mbw_get_option("post_user_modify_password"), $site_url);
				if(mbw_get_option("post_user_privacy_policy")!="") $user_url["privacy_policy"]			= mbw_check_permalink(mbw_get_option("post_user_privacy_policy"), $site_url);
				if(mbw_get_option("post_user_terms_service")!="") $user_url["terms_service"]			= mbw_check_permalink(mbw_get_option("post_user_terms_service"), $site_url);
			}
		}

		if(empty($type)) {
			if(has_filter('mf_user_login_url')) $user_url["login"]								= apply_filters("mf_user_login_url",$user_url["login"]);
			if(has_filter('mf_user_register_url')) $user_url["register"]						= apply_filters("mf_user_register_url",$user_url["register"]);
			if(has_filter('mf_user_lost_password_url')) $user_url["lost_password"]		= apply_filters("mf_user_lost_password_url",$user_url["lost_password"]);
			if(has_filter('mf_user_modify_password_url')) $user_url["modify_password"]		= apply_filters("mf_user_modify_password_url",$user_url["modify_password"]);
			if(has_filter('mf_user_logout_url')) $user_url["logout"]							= apply_filters("mf_user_logout_url",$user_url["logout"]);
			if(has_filter('mf_user_user_info_url')) $user_url["user_info"]					= apply_filters("mf_user_user_info_url",$user_url["user_info"]);
			return $user_url;
		}else{
			if(has_filter('mf_user_'.$type.'_url')) $user_url[$type]			= apply_filters("mf_user_".$type."_url",$user_url[$type]);
			return $user_url[$type];
		}
	}
}

if(!function_exists('mbw_join_user_phone')){
	function mbw_join_user_phone(){
		if(mbw_get_param("phone1")!="" && mbw_get_param("phone2")!=""){
			mbw_set_param("phone",mbw_get_param("phone1")."-".mbw_get_param("phone2")."-".mbw_get_param("phone3"));
		}
		if(mbw_get_param("user_phone1")!="" && mbw_get_param("user_phone2")!=""){
			mbw_set_param("user_phone",mbw_get_param("user_phone1")."-".mbw_get_param("user_phone2")."-".mbw_get_param("user_phone3"));
		}
		if(mbw_get_param("home_tel1")!="" && mbw_get_param("home_tel2")!=""){
			mbw_set_param("home_tel",mbw_get_param("home_tel1")."-".mbw_get_param("home_tel2")."-".mbw_get_param("home_tel3"));
		}
		if(mbw_get_param("office_tel1")!="" && mbw_get_param("office_tel2")!=""){
			mbw_set_param("office_tel",mbw_get_param("office_tel1")."-".mbw_get_param("office_tel2")."-".mbw_get_param("office_tel3"));
		}
	}
}

if(!function_exists('mbw_get_level_item')){
	function mbw_get_level_item($level){
		$level_icon		= 'images/icon_level'.$level.'.gif';
		if(defined('MBW_SKIN_PATH') && is_file(MBW_SKIN_PATH.$level_icon)) return ' <img class="user-i-level mb-level-'.$level.'" src="'.MBW_SKIN_URL.$level_icon.'" />';
		else if(is_file(MBW_PLUGIN_PATH.'skins/bbs_basic/'.$level_icon)) return ' <img class="user-i-level mb-level-'.$level.'" src="'.MBW_PLUGIN_URL.'skins/bbs_basic/'.$level_icon.'" />';
		else return "[".$level."]";
	}
}

if(!function_exists('mbw_logout')){
	function mbw_logout($mode="WP",$log=true){
		if($log && mbw_is_login()) mbw_set_log("logout","",array("mode"=>"user","board_action"=>"logout","board_name"=>"users"));
		if(has_action('mbw_user_logout')) do_action('mbw_user_logout');
		mbw_clear_auth_cookie();
		if($mode!="MB") wp_logout();
	}
}

?>