<?php

if(!function_exists('mbw_get_api_headers')){
	function mbw_get_api_headers(){
		mbw_add_trace("mbw_get_api_headers");
		header("Content-Type: text/html; charset=UTF-8");
		header("X-XSS-Protection:1; mode=block");
		send_origin_headers();		
		send_nosniff_header();
		nocache_headers();		
	}
}

if(!function_exists('mbw_check_pattern')){
	function mbw_check_pattern($data,$text){
		global $mstore;
		
		$pattern		= mbw_get_pattern($data);
		 if(preg_match($pattern, $text)) return true;
		 return false;
	}
}

if(!function_exists('mbw_check_filter')){
	function mbw_check_filter($data,$text){
		global $mstore;
		$filter			= array();
		if(mbw_get_option("filter_words")!="")
			$filter			= explode(",",mbw_get_option("filter_words"));	

		if(strpos($data, '|')!==false){
			$filter_key		= explode("|",$data);
			$count			= count($filter_key);
			for($i=0;$i<$count;$i++) {
				if(!empty($filter_key[$i])){
					$filter = array_merge( $filter, explode(",",mbw_get_filter($filter_key[$i])));
				}
			}
		}else{
			$filter = array_merge( $filter, explode(",",mbw_get_filter($data)));
		}
		$count			= count($filter);		
		for($i=0;$i<$count;$i++) {
			if(!empty($filter[$i])){
				if(preg_match("/".$filter[$i]."/i", $text)) return $filter[$i];
			}
		}		
		return "";
	}
}

if(!function_exists('mbw_set_api_params')){
	function mbw_set_api_params($fields){
		mbw_add_trace("mbw_set_api_params");
		global $mstore,$mdb,$mb_vars,$mb_admin_tables,$mb_fields;
		global $mb_board_table_name,$mb_comment_table_name;
		$api_fields					= $fields;
		$check_fields				= $fields;
		$send_data					= array();
		$mb_user_level			= mbw_get_user("fn_user_level");

		//관리자 테이블에는 htmlspecialchars 기능 적용 안함
		$check_htmlspecialchars			= true;
		$is_admin_table						= false;
		
		if(mbw_is_admin_table($mb_board_table_name)){
			$is_admin_table					= true;
			if(mbw_is_admin() && mbw_get_param("board_name")=="options")
				$check_htmlspecialchars		= false;			

			if(!mbw_is_admin()){
				//관리자가 아닌 상태에서 관리자 테이블 목록을 요구할 경우 종료
				if(mbw_get_param("mode")=="list") exit;				
				//관리자가 아닌 상태에서 회원 테이블 이외의 관리자 테이블을 API로 호출할 경우 종료
				if($mb_board_table_name!=$mb_admin_tables["users"]) exit;
			}
		}
		//XSS 필터 적용하기
		if($check_htmlspecialchars && (mbw_get_param("data_type")=="html")){
			if(mbw_get_param("content")!=""){
				$tmp_content		= mbw_get_param("content");
				if(strpos($tmp_content, '<')!==false){
					if(!mbw_is_admin() && function_exists('mbw_get_htmlpurify') && version_compare(PHP_VERSION, '5.4.0', '>=')){
						mbw_set_param("content",mbw_get_htmlpurify($tmp_content));
					}else{
						$tmp_content		= strtolower($tmp_content);
						if(strpos($tmp_content, '<script')!==false || strpos($tmp_content, '<object')!==false || strpos($tmp_content, '<embed')!==false || strpos($tmp_content, '<applet')!==false || strpos($tmp_content, '<vbscript')!==false){
							mbw_set_param("content",mbw_htmlspecialchars(mbw_get_param("content"),ENT_NOQUOTES));
						}
					}
				}
			}
		}

		$allow_fields			= "";
		if(!mbw_is_admin_page()){
			if(mbw_get_option("use_form_session")){
				if(mbw_get_param("mode")=="write" || mbw_get_param("board_action")=="modify"){
					$session = @session_id();
					if(empty($session)) @session_start();
					$session_name		= 'mb_form_'.mbw_get_board_name();
					$session_name2		= 'mb_form_'.mbw_get_param("mb_nonce_value");
					if(!empty($_SESSION[$session_name])) $form_names			= $_SESSION[$session_name];
					else if(!empty($_SESSION[$session_name2])) $form_names			= $_SESSION[$session_name2];
					$allow_fields		= $form_names;
					if(!empty($allow_fields)) $allow_fields		= ",".$allow_fields.",";
				}
			}else{
				if(!mbw_is_admin()){
					if(!$is_admin_table){
						if(mbw_get_param("mode")=="comment"){
							if(!empty($mb_fields["comment_not_allow"])) $check_fields			= array_diff($api_fields, $mb_fields["comment_not_allow"]);
						}else{
							if(!empty($mb_fields["board_not_allow"])) $check_fields			= array_diff($api_fields, $mb_fields["board_not_allow"]);
						}
					}else{
						if($mb_board_table_name==$mb_admin_tables["users"]){
							if(!empty($mb_fields["users_not_allow"])) $check_fields			= array_diff($api_fields, $mb_fields["users_not_allow"]);
						}else{						
							if(!empty($mb_fields[mbw_get_board_name()."_not_allow"])) $check_fields			= array_diff($api_fields, $mb_fields[mbw_get_board_name()."_not_allow"]);
						}
					}
				}
			}
		}		

		foreach($check_fields as $key => $value){
			$param_key		= str_replace("fn_", "",$key);	
			if(strpos($key, 'fn_')===0 && isset($_REQUEST[$param_key]) && $key!="fn_pid"){
				if(!empty($allow_fields) && strpos($allow_fields, ','.$param_key.',')===false) continue;

				$param_data										= mbw_get_param($param_key);
				if(mbw_get_param("mode")=="write" && is_array($param_data)){
					$param_data		= implode(",",$param_data);
					$param_data		= strip_tags($param_data);
				}
				if($check_htmlspecialchars)
					$send_data[$check_fields[$key]]			= mbw_htmlspecialchars($param_data);
				else
					$send_data[$check_fields[$key]]			= mbw_stripslashes($param_data);
			}
		}

		if(!mbw_is_admin() && mbw_get_param("mode")=="write"){

			if($mb_board_table_name==$mb_admin_tables["users"]){
				if(isset($send_data["user_level"])) unset($send_data["user_level"]);	
				if(isset($send_data["user_point"])) unset($send_data["user_point"]);	
				if(isset($send_data["user_money"])) unset($send_data["user_money"]);	
				if(isset($send_data["payment_count"])) unset($send_data["payment_count"]);	
				if(isset($send_data["payment_total"])) unset($send_data["payment_total"]);	
			}
			if(isset($send_data["is_notice"])) unset($send_data["is_notice"]);	
		}

		//회원 로그인 상태이면 회원 정보 설정
		if(mbw_is_login()){
			$mb_user_pid				= "";
			$board_user_pid			= "";

			//Modify 상태에서는 자신의 글일 경우에만 이름 수정 
			if(mbw_get_param("board_action")=="modify" && isset($api_fields["fn_user_pid"])){	
				$mb_user_pid							= intval(mbw_get_user("fn_pid"));
				if(mbw_get_param("mode")=="comment"){	
					$table_name		= $mb_comment_table_name;
					$pid					= mbw_get_param("comment_pid");			
				}else{
					$table_name		= $mb_board_table_name;
					$pid					= mbw_get_param("board_pid");			
				}
				$board_user_pid		= $mdb->get_var("select ".$api_fields["fn_user_pid"]." from ".$table_name." where ".$api_fields["fn_pid"]."='".$pid."' limit 1");
			}

			if(!$is_admin_table && $mb_user_pid==$board_user_pid){
				if(isset($api_fields["fn_level"]))		$send_data[$api_fields["fn_level"]]				= mbw_get_user("fn_user_level");
				if(isset($api_fields["fn_user_pid"]))		$send_data[$api_fields["fn_user_pid"]]		= mbw_get_user("fn_pid");
				if(mbw_get_param("user_name")=="" && isset($api_fields["fn_user_name"]))		$send_data[$api_fields["fn_user_name"]]					= mbw_get_user("fn_user_name");
			}
			
			if(isset($api_fields["fn_passwd"])){
				if(!empty($send_data[$api_fields["fn_passwd"]])){
					$send_data[$api_fields["fn_passwd"]]			= mbw_hash_password($send_data[$api_fields["fn_passwd"]]);
				}else{
					//로그인 상태에서 비밀번호가 비어있을 경우
					if(!$is_admin_table){

						if(mbw_get_param("mode")=="comment"){
							if(mbw_get_param("board_action")=="write" || mbw_get_param("board_action")=="reply"){
								$send_data[$api_fields["fn_passwd"]]						= mbw_get_user("fn_pid");
							}
						}else{
							if(isset($api_fields["fn_is_secret"])){
								 if(empty($send_data[$api_fields["fn_is_secret"]])){
									if(mbw_get_param("board_action")=="modify" && $mb_user_pid!=$board_user_pid){
										unset($send_data[$api_fields["fn_passwd"]]);
									}else{
										$send_data[$api_fields["fn_passwd"]]						= mbw_get_user("fn_pid");
									}
								 }else{
									if(mbw_get_param("board_action")=="modify"){
										if($mb_user_pid!=$board_user_pid){
											unset($send_data[$api_fields["fn_passwd"]]);
										}else if(empty($send_data[$api_fields["fn_passwd"]])){
											unset($send_data[$api_fields["fn_passwd"]]);
										}
									}
								 }
							}else{
								if(mbw_get_param("board_action")=="modify" && $mb_user_pid!=$board_user_pid){
									unset($send_data[$api_fields["fn_passwd"]]);
								}else{
									$send_data[$api_fields["fn_passwd"]]						= mbw_get_user("fn_pid");
								}								
							}
						}
					}else{
						//어드민 테이블일 경우 비밀번호 값이 넘어오지 않으면 수정 안되도록 설정
						if(mbw_get_param("board_action")=="modify"){
							unset($send_data[$api_fields["fn_passwd"]]);
						}
					}
				}
			}
			if(isset($api_fields["fn_user_picture"]) && $mb_board_table_name==$mb_admin_tables["users"]){
				if(empty($send_data[$api_fields["fn_user_picture"]])) unset($send_data[$api_fields["fn_user_picture"]]);				
			}

		}else if(isset($api_fields["fn_passwd"]) && !empty($send_data[$api_fields["fn_passwd"]])){
			$send_data[$api_fields["fn_passwd"]]			= mbw_hash_password($send_data[$api_fields["fn_passwd"]]);
		}

		if(isset($api_fields["fn_ip"]) && mbw_get_param("board_name")!="access_ip")				$send_data[$api_fields["fn_ip"]]					= $_SERVER["REMOTE_ADDR"];
		if(isset($api_fields["fn_agent"]))		$send_data[$api_fields["fn_agent"]]				= $mb_vars["user_agent"];

		if(mbw_get_param("mode")=="comment"){	
			if(isset($api_fields["fn_reg_date"]))	$send_data[$api_fields["fn_reg_date"]]			= mbw_get_current_time();

		}else{
			if(strpos(mbw_get_param("board_action"),"modify")!==false){	
				if(isset($api_fields["fn_modify_date"]))	$send_data[$api_fields["fn_modify_date"]]	= mbw_get_current_time();
				if(isset($api_fields["fn_calendar_date"]) && mbw_get_param("calendar_date")=="") unset($send_data[$api_fields["fn_calendar_date"]]);
			}else{
				if(isset($api_fields["fn_reg_date"]))	$send_data[$api_fields["fn_reg_date"]]			= mbw_get_current_time();
				if(isset($api_fields["fn_modify_date"]))	$send_data[$api_fields["fn_modify_date"]]	= mbw_get_current_time();

				if(isset($api_fields["fn_calendar_date"])){
					if(mbw_get_param("calendar_date")!=""){
						$calendar_date		= mbw_get_param("calendar_date");
						if(mbw_get_param("calendar_time")!=""){
							$calendar_date		= $calendar_date." ".mbw_get_param("calendar_time");
						}
						$send_data[$api_fields["fn_calendar_date"]]	= date(mbw_get_option("date_format")." ".mbw_get_option("time_format"),strtotime($calendar_date));
					}else{
						$send_data[$api_fields["fn_calendar_date"]]	= mbw_get_current_time();
					}
				}
			}
		}
		return $send_data;
	}
}

//필수입력 체크
if(!function_exists('mbw_check_api_required')){
	function mbw_check_api_required($fields,$send_data){
		mbw_add_trace("mbw_check_api_required");
		global $mstore,$mdb;		
		$api_fields				= $fields;		
		if(mbw_get_model(mbw_get_param("mode")."_".mbw_get_param("board_action"))!=""){
			$model_name				= mbw_get_param("mode")."_".mbw_get_param("board_action");			
		}else{
			$model_name				= mbw_get_param("mode");
		}

		$model							= mbw_get_model($model_name);
		if(!empty($model)){
			$model_data				= mbw_json_decode($model);
			$mb_user_level			= mbw_get_user("fn_user_level");
			foreach($model_data as $data){
				//필수 입력 검사

				if(isset($data["required"])){					

					if(!empty($data["required_field"]))
						$data["field"]		= $data["required_field"];

					if(!empty($data["required_action"]) && $data["required_action"]!=mbw_get_param("board_action")){
						//required_action 설정이 있고, board_action과 일치하지 않을 경우 예외처리						
					}else if(!empty($data["type"]) && strpos($data["type"],'file')===0){		//파일 타입에 required 설정했을 경우
						$name		= str_replace("fn_", "", $data["field"]);
						if(isset($_REQUEST[$name]) && empty($_FILES[$name])){
							if(isset($data["required_error"])){
								$error_message		= mbw_get_message($data["required_error"]);
							}else{
								$error_message		= "MSG_FILE_EMPTY_ERROR2";
							}
							mbw_error_message($error_message, $data["name"],"1201",str_replace("fn_", "", $data["field"]));
							break;
						}

					}else if(!isset($api_fields[$data["field"]])){		//field가 정의되어 있지 않을 경우 에러 출력
						mbw_error_message("%s field error", $api_fields[$data["field"]],"1302");
						break;
					}else if(!isset($send_data[$api_fields[$data["field"]]]) || $send_data[$api_fields[$data["field"]]]==""){		//field 값이 비어있을 경우 에러 출력			
						$check_required		= true;
						//회원 정보 수정시 비밀번호가 없으면 예외처리
						if($data["field"]=="fn_passwd" && mbw_get_param("board_action")=="modify" && $mb_board_table_name==$mb_admin_tables["users"]){
							$mb_user_pid							= mbw_get_user("fn_pid");
							$modify_level		= intval(mbw_get_board_option("fn_modify_level"));
							if(empty($modify_level)) $modify_level	= mbw_get_option("admin_level");
							if($mb_user_pid==mbw_get_param("board_pid") || $mb_user_level>=$modify_level){	//본인의 회원정보 수정 or 관리자에 의한 회원정보 수정 허용
								$check_required		= false;
							}						
						//게시판 정보 수정시 이름 데이타 예외 처리
						}else if($data["field"]=="fn_user_name" && mbw_get_param("board_action")=="modify"){
							$modify_level							= intval(mbw_get_board_option("fn_modify_level"));
							if(empty($modify_level)) $modify_level	= mbw_get_option("admin_level");
							if($mb_user_level>=$modify_level){		//관리자에 의한 게시물 수정 허용
								$check_required		= false;
							}
						}
						if($check_required){
							if(isset($data["required_error"])){
								$error_message		= mbw_get_message($data["required_error"]);
							}else{
								$error_message		= "MSG_FIELD_EMPTY_ERROR1";
							}
							mbw_error_message($error_message, $data["name"],"1201",str_replace("fn_", "", $data["field"]));
							break;						
						}
					}else{					
						
						//Unique 상태 검사
						if(mbw_get_param("mode")!="comment" && isset($data["unique"])){
							$where_data		= array();
							$where_data[]		= array("field"=>$api_fields[$data["field"]],"value"=>$send_data[$api_fields[$data["field"]]]);
							if(mbw_get_param("board_action")=="modify"){		// modify 일 경우 수정글 값은 제외하고 체크
								$where_data[]		= array("field"=>"fn_pid","sign"=>"!=","value"=>mbw_get_param("board_pid"));							
							}
							$unique_check	= intval($mdb->get_var(mbw_get_add_query(array("column"=>"count(*)"),$where_data)));
							if($unique_check>0){
								if(isset($data["unique_error"])){
									$error_message		= mbw_get_message($data["unique_error"]);
								}else{
									$error_message		= "MSG_UNIQUE_ERROR";
								}
								mbw_error_message($error_message, array($send_data[$api_fields[$data["field"]]],$data["name"]),"1205",str_replace("fn_", "", $data["field"]));
								break;
							}						
						}
					}
				}
				//입력 패턴 검사
				if(!empty($data["pattern"]) && $send_data[$api_fields[$data["field"]]]!=""){

					if(!empty($data["pattern_action"]) && $data["pattern_action"]!=mbw_get_param("board_action")){
						//pattern_action 설정이 있고, board_action과 일치하지 않을 경우 예외처리
					}else{
						$pattern_text		= $send_data[$api_fields[$data["field"]]];
						if(isset($data["field"]) && $data["field"]=="fn_passwd") $pattern_text		= $_REQUEST["passwd"];
						if(!mbw_check_pattern($data["pattern"],$pattern_text)){
							if(isset($data["pattern_error"])){
								$error_message		= mbw_get_message($data["pattern_error"]);
							}else{
								$error_message		= "MSG_PATTERN_ERROR";
							}
							mbw_error_message($error_message, $data["name"],"1203",str_replace("fn_", "", $data["field"]));
							break;
						}
					}
				}

				if(!empty($data["filter"]) && $mb_user_level<mbw_get_option("admin_level")){
					$filter		= mbw_check_filter($data["filter"], $send_data[$api_fields[$data["field"]]]);
					if(!empty($filter)){
						if(isset($data["filter_error"])){
							$error_message		= '<p>"'.$filter.'"</p>'.mbw_get_message($data["filter_error"]);
						}else{
							$error_message		= "MSG_FILTER_ERROR";
						}
						mbw_error_message($error_message, $filter,"1204",str_replace("fn_", "", $data["field"]));
						break;
					}
				}

			}
		}else if(mbw_get_param("mode")=="list"){
			$error_check		= false;
			foreach($model_data as $data){
				if(isset($data["required"]) || !empty($data["filter"]) ){

					if(!isset($api_fields[$data["field"]])){
						mbw_error_message("%s field error", $api_fields[$data["field"]],"1302");
						break;
					}else if(is_array($send_data[$api_fields[$data["field"]]])){
						$check_data			= $send_data[$api_fields[$data["field"]]];
						$count					= count($check_data);

						for($i=0;$i<$count;$i++){

							if(isset($data["required"])){
								if(!isset($check_data[$i]) || $check_data[$i]==""){
									if(isset($data["required_error"])){
										$error_message		= mbw_get_message($data["required_error"]);
									}else{
										$error_message		= "MSG_FIELD_EMPTY_ERROR1";
									}
									mbw_error_message($error_message, $data["name"],"1201");
									$error_check		= true;
									break;
								}else if(!empty($data["pattern"])){
									if(!mbw_check_pattern($data["pattern"], $check_data[$i])){
										if(isset($data["pattern_error"])){
											$error_message		= mbw_get_message($data["pattern_error"]);
										}else{
											$error_message		= "MSG_PATTERN_ERROR";
										}
										mbw_error_message($error_message, $data["name"],"1203");
										$error_check		= true;
										break;
									}
								}
							}
							if(!empty($data["filter"]) && $mb_user_level<mbw_get_option("admin_level")){
								$filter		= mbw_check_filter($data["filter"], $send_data[$api_fields[$data["field"]]]);
								if(!empty($filter)){
									if(isset($data["filter_error"])){
										$error_message		= '<p>"'.$filter.'"</p>'.mbw_get_message($data["filter_error"]);
									}else{
										$error_message		= "MSG_FILTER_ERROR";
									}
									mbw_error_message($error_message, $filter,"1204");
									$error_check		= true;
									break;
								}
							}
						}
						if($error_check){							
							break;
						}
					}					
				}				
			}
		}
	}
}



//api 접근 권한 체크
if(!function_exists('mbw_check_api_permission')){
	function mbw_check_api_permission($fields,$send_data){
		mbw_add_trace("mbw_check_api_permission");
		global $mstore,$mdb;
		global $mb_admin_tables,$mb_fields,$mb_languages;
		global $mb_board_table_name,$mb_comment_table_name;

		$api_fields			= $fields;

		if(mbw_get_param("mode")=="comment"){	
			$table_name		= $mb_comment_table_name;
			$pid					= mbw_get_param("comment_pid");
		}else{
			$table_name		= $mb_board_table_name;
			$pid					= mbw_get_param("board_pid");
		}

		//접근 권한 체크
		$mb_user_level						= mbw_get_user("fn_user_level");
		$mb_user_pid							= intval(mbw_get_user("fn_pid"));

		if(strpos(mbw_get_param("board_action"),"delete")!==false){
			if(intval(mbw_get_board_option("fn_delete_level")) > $mb_user_level){
				//user_pid 필드가 없는 게시판은 일반 유저가 삭제하지 못하도록 설정
				if(!empty($api_fields["fn_user_pid"])){
					$board_item	= $mdb->get_row("select * from ".$table_name." where ".$api_fields["fn_pid"]."='".$pid."' limit 1",ARRAY_A);
					//비회원이 작성한 글일 경우 비밀번호가 일치하는지 확인
					if($board_item[$api_fields["fn_user_pid"]]=="0"){
						if(!empty($api_fields["fn_passwd"])){
							if(empty($send_data[$api_fields["fn_passwd"]])){
								mbw_error_message("MSG_FIELD_EMPTY_ERROR1", $mb_languages["W_PASSWORD"],"1201");
							}else if(!mbw_check_password(mbw_get_param("passwd"), $board_item[$api_fields["fn_passwd"]])){
								mbw_error_message("MSG_MATCH_ERROR", $mb_languages["W_PASSWORD"],"1206","passwd");
							}
						}
					//회원이 작성한 글일 경우 본인 글이 아닐 경우 에러 출력
					}else{
						if($mb_user_pid!=$board_item[$api_fields["fn_user_pid"]]){
							mbw_error_message("MSG_PERMISSION_ERROR", $mb_languages["W_DELETE"],"1102");
						}
					}
				}else{
					mbw_error_message("MSG_PERMISSION_ERROR", $mb_languages["W_DELETE"],"1102");
				}
			}
		}else if(strpos(mbw_get_param("board_action"),"modify")!==false){
			$board_item	= $mdb->get_row("select * from ".$table_name." where ".$api_fields["fn_pid"]."='".$pid."' limit 1",ARRAY_A);
			if(intval(mbw_get_board_option("fn_modify_level")) > $mb_user_level){
				//비회원이 작성한 글일 경우 비밀번호가 일치하는지 확인
				if(!empty($api_fields["fn_user_pid"])){
					if($board_item[$api_fields["fn_user_pid"]]=="0"){
						if(empty($send_data[$api_fields["fn_passwd"]])){
							mbw_error_message("MSG_FIELD_EMPTY_ERROR1", $mb_languages["W_PASSWORD"],"1201");
						}else if(!mbw_check_password(mbw_get_param("passwd"), $board_item[$api_fields["fn_passwd"]])){
							mbw_error_message("MSG_MATCH_ERROR", $mb_languages["W_PASSWORD"],"1206","passwd");
						}
					//회원이 작성한 글일 경우 본인 글이 아닐 경우 에러 출력
					}else{
						if($mb_user_pid!=$board_item[$api_fields["fn_user_pid"]]){							
							mbw_error_message("MSG_PERMISSION_ERROR", $mb_languages["W_MODIFY"],"1102");
						}
					}
				}else if($mb_board_table_name==$mb_admin_tables["users"]){
					if($mb_user_pid!=$board_item[$api_fields["fn_pid"]]){
						mbw_error_message("MSG_PERMISSION_ERROR", $mb_languages["W_MODIFY"],"1102");
					}
				}else{
					mbw_error_message("MSG_PERMISSION_ERROR", $mb_languages["W_MODIFY"],"1102");
				}
			}

		}else if(mbw_get_param("board_action")=="multi_move"){
			if(intval(mbw_get_board_option("fn_manage_level")) > $mb_user_level){
				mbw_error_message("MSG_PERMISSION_ERROR", $mb_languages["W_MOVE"],"1102");
			}
		}else if(mbw_get_param("board_action")=="multi_copy"){
			if(intval(mbw_get_board_option("fn_manage_level")) > $mb_user_level){
				mbw_error_message("MSG_PERMISSION_ERROR", $mb_languages["W_COPY"],"1102");
			}
		}
	}
}


if(!function_exists('mbw_check_api_file')){
	function mbw_check_api_file($type){
		mbw_add_trace("mbw_check_api_file");
		global $mstore;
		global $mb_image_upload_files,$mb_board_upload_files;

		if($type=="editor"){
			$check_ext		= $mb_image_upload_files;
		}else{		
			$check_ext		= $mb_board_upload_files;
		}
		$upload_check		= false;
		if(!empty($_FILES)){
			foreach($_FILES as $key=>$file_data){				
				if(!empty($file_data["name"])){
					$file_count2		= count($file_data["name"]);
					if($file_count2>1){
						for($i=0;$i<$file_count2;$i++){						
							$file_name		= $file_data["name"][$i];
							$file_size		= intval($file_data["size"][$i]);			
							$limit_size		= floatval(mbw_get_option("upload_file_size"))*1024*1024;

							$name_array	= explode('.',$file_name);
							if(count($name_array)==1) return false;
							$file_ext			= strtolower(array_pop($name_array));

							if($file_size==0){
								mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
								return false;
							}else if(!in_array($file_ext, $check_ext)){
								mbw_error_message("MSG_UPLOAD_EXT_ERROR", $file_ext,"1502");
								return false;
							}else if($file_size>$limit_size){
								mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
								return false;
							}else{
								$upload_check		= true;
							}
						}
					}else{
						$file_name		= $file_data["name"];
						$file_size		= intval($file_data["size"]);			
						$limit_size		= floatval(mbw_get_option("upload_file_size"))*1024*1024;

						$name_array	= explode('.',$file_name);
						if(count($name_array)==1) return false;
						$file_ext			= strtolower(array_pop($name_array));

						if($file_size==0){
							mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
							return false;
						}else if(!in_array($file_ext, $check_ext)){
							mbw_error_message("MSG_UPLOAD_EXT_ERROR", $file_ext,"1502");
							return false;
						}else if($file_size>$limit_size){
							mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
							return false;
						}else{
							$upload_check		= true;
						}
					}
				}
			}		
		}else if(!empty($_POST["img64"])){			
			$upload_check		= true;
		}
		return $upload_check;
	}
}

if(!function_exists('mbw_check_upload_filename')){
	function mbw_check_upload_filename($file_name){
		$file_name		= trim($file_name);
		$file_name		= strip_tags($file_name);
		$file_name		= str_replace(array('"',"'",";","\0"), "", $file_name);
		$file_name		= str_replace('#','＃',$file_name);
		$file_name		= str_replace('%','％',$file_name);
		if(strpos($file_name, '.php')!==false) exit;
		return $file_name;
	}
}

if(!function_exists('mbw_file_upload')){
	function mbw_file_upload($args,$html5_file=array()){
		mbw_add_trace("mbw_file_upload");
		global $mstore,$mdb;
		global $mb_fields,$mb_admin_tables,$mb_board_table_name;
		global $mb_vars,$mb_image_upload_files,$mb_board_upload_files;

		$send_data				= array();
		$where_data			= array();
		$upload_data			= array();
		$api_fields				= $mb_fields["files"];
		$file_name				= "";
		$file_count				= count($_FILES);
		$uploadPath			= MBW_UPLOAD_PATH;
		$datePath				= date("Y/m/d/",mbw_get_timestamp());
		$limit_size				= floatval(mbw_get_option("upload_file_size"))*1024*1024;				

		if(mbw_get_param("add_upload_path")!=""){
			$add_upload_path	= mbw_value_filter(mbw_get_param("add_upload_path"));
			$datePath				= $add_upload_path.'/'.$datePath;
		}

		if(!is_dir($uploadPath.$datePath)){
			@mkdir($uploadPath.$datePath, 0777, true);
			@chmod($uploadPath.$datePath, 0777);
		}

		if($args["type"]=="editor"){
			if(isset($api_fields["fn_is_download"]))		$send_data[$api_fields["fn_is_download"]]				= "0";
			$check_ext			= $mb_image_upload_files;
			$file_sequence		= 1000;
		}else{
			if(isset($api_fields["fn_is_download"]))		$send_data[$api_fields["fn_is_download"]]				= "1";
			$check_ext		= $mb_board_upload_files;
			$file_sequence		= 1;
		}

		if(isset($api_fields["fn_board_name"]))		$send_data[$api_fields["fn_board_name"]]					= $args["board_name"];
		if(isset($api_fields["fn_table_name"]))		$send_data[$api_fields["fn_table_name"]]						= $args["table_name"];
		if(isset($api_fields["fn_board_pid"]))			$send_data[$api_fields["fn_board_pid"]]						= $args["board_pid"];
		if(isset($api_fields["fn_ip"]))						$send_data[$api_fields["fn_ip"]]								= $_SERVER["REMOTE_ADDR"];
		if(isset($api_fields["fn_agent"]))				$send_data[$api_fields["fn_agent"]]								= $mb_vars["user_agent"];
		if(isset($api_fields["fn_reg_date"]))		$send_data[$api_fields["fn_reg_date"]]								= mbw_get_current_time();

		if(mbw_is_login()){
			if(isset($api_fields["fn_user_pid"]))			$send_data[$api_fields["fn_user_pid"]]						= mbw_get_user("fn_pid");
			if(isset($api_fields["fn_user_name"]))		$send_data[$api_fields["fn_user_name"]]					= mbw_get_user("fn_user_name");
		}

		$file_pid						= intval($mdb->get_var("select ".$mb_fields["files"]["fn_pid"]." from `".$mb_admin_tables["files"]."` ORDER BY ".$mb_fields["files"]["fn_pid"]." DESC limit 1"))+1;
		$upload_data["pid"]		= $file_pid;
		
		if(!empty($_FILES)){						
			if(mbw_get_param("board_action") == "modify"){
				$file_sequence		= intval($mdb->get_var("select ".$api_fields["fn_file_sequence"]." from `".$mb_admin_tables["files"]."` WHERE ".$mb_fields["files"]["fn_board_pid"]."='".$send_data[$api_fields["fn_board_pid"]]."' and ".$mb_fields["files"]["fn_table_name"]."='".$send_data[$api_fields["fn_table_name"]]."' ORDER BY ".$api_fields["fn_file_sequence"]." DESC limit 1"))+1;
			}
			foreach($_FILES as $key=>$file_data){
				if(!empty($file_data["name"])){
					$file_count2		= count($file_data["name"]);
					if($file_count2>1){
						for($i=0;$i<$file_count2;$i++){
							$file_tmp						= $file_data["tmp_name"][$i]; 		
							$file_size						= intval($file_data["size"][$i]);			
							$upload_data["name"]		= mbw_check_upload_filename($file_data["name"][$i]);
							
							$name_array	= explode('.',$upload_data["name"]);
							if(count($name_array)==1) return $upload_data;
							$file_ext			= strtolower(array_pop($name_array));					

							if(!is_uploaded_file($file_tmp)){
								mbw_error_message("MSG_ERROR", "Upload","1500");
							}else if($args["type"]=="editor" && getimagesize($file_tmp)===false){
								mbw_error_message("MSG_ERROR", "Upload","1500");
							}else if(!in_array($file_ext, $check_ext)){
								mbw_error_message("MSG_UPLOAD_EXT_ERROR", $file_ext,"1502");
							}else if($file_size>$limit_size){
								mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
							}else{
								$upload_data["path"]		= $datePath.mbw_get_file_name($file_pid,$upload_data["name"]);
								if($key=="image_path" || $key=="image_view"){
									if(isset($api_fields["fn_is_download"]))		$send_data[$api_fields["fn_is_download"]]				= "0";
								}
								if(isset($api_fields["fn_pid"]))						$send_data[$api_fields["fn_pid"]]								= $file_pid;
								if(isset($api_fields["fn_file_name"]))				$send_data[$api_fields["fn_file_name"]]					= $upload_data["name"];
								if(isset($api_fields["fn_file_sequence"]))			$send_data[$api_fields["fn_file_sequence"]]			= $file_sequence;
								if(isset($api_fields["fn_file_description"]))		$send_data[$api_fields["fn_file_description"]]			= $key;
								if(isset($api_fields["fn_file_size"]))				$send_data[$api_fields["fn_file_size"]]					= $file_size;
								if(isset($api_fields["fn_file_type"]))				$send_data[$api_fields["fn_file_type"]]					= $file_data["type"][$i];
								if(isset($api_fields["fn_file_path"]))				$send_data[$api_fields["fn_file_path"]]					= $upload_data["path"];
								
								$file_name				= mbw_get_file_name($file_pid,$upload_data["name"]);
								@move_uploaded_file($file_tmp, $uploadPath.$datePath.$file_name);
								@chmod($uploadPath.$datePath.$file_name, 0644);
								
								$mdb->db_query("INSERT",$mb_admin_tables["files"], $send_data, $where_data);
								mbw_analytics("today_upload");						

								$img_small_size		= mbw_get_option("make_img_small_size");
								$img_middle_size		= mbw_get_option("make_img_middle_size");
								if(!empty($img_small_size)) mbw_create_image($uploadPath.$datePath.$file_name,"small"); 
								if(!empty($img_middle_size)) mbw_create_image($uploadPath.$datePath.$file_name,"middle"); 					
								$file_pid++;
								$file_sequence++;
							}
						}
					}else{
						$file_tmp						= $file_data["tmp_name"]; 		
						$file_size						= intval($file_data["size"]);			
						$upload_data["name"]		= mbw_check_upload_filename($file_data["name"]);						


						$name_array	= explode('.',$upload_data["name"]);
						if(count($name_array)==1) return $upload_data;
						$file_ext			= strtolower(array_pop($name_array));					

						if(!is_uploaded_file($file_tmp)){
							mbw_error_message("MSG_ERROR", "Upload","1500");
						}else if($args["type"]=="editor" && getimagesize($file_tmp)===false){
							mbw_error_message("MSG_ERROR", "Upload","1500");
						}else if(!in_array($file_ext, $check_ext)){
							mbw_error_message("MSG_UPLOAD_EXT_ERROR", $file_ext,"1502");
						}else if($file_size>$limit_size){
							mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
						}else{
							$upload_data["path"]		= $datePath.mbw_get_file_name($file_pid,$upload_data["name"]);
							if($key=="image_path" || $key=="image_view"){
								if(isset($api_fields["fn_is_download"]))		$send_data[$api_fields["fn_is_download"]]				= "0";
							}

							if(isset($api_fields["fn_pid"]))						$send_data[$api_fields["fn_pid"]]								= $file_pid;
							if(isset($api_fields["fn_file_name"]))				$send_data[$api_fields["fn_file_name"]]					= $upload_data["name"];
							if(isset($api_fields["fn_file_sequence"]))			$send_data[$api_fields["fn_file_sequence"]]			= $file_sequence;
							if(isset($api_fields["fn_file_description"]))		$send_data[$api_fields["fn_file_description"]]			= $key;
							if(isset($api_fields["fn_file_size"]))				$send_data[$api_fields["fn_file_size"]]					= $file_size;
							if(isset($api_fields["fn_file_type"]))				$send_data[$api_fields["fn_file_type"]]					= $file_data["type"];
							if(isset($api_fields["fn_file_path"]))				$send_data[$api_fields["fn_file_path"]]					= $upload_data["path"];
							
							$file_name				= mbw_get_file_name($file_pid,$upload_data["name"]);
							@move_uploaded_file($file_tmp, $uploadPath.$datePath.$file_name);
							@chmod($uploadPath.$datePath.$file_name, 0644);
							
							$mdb->db_query("INSERT",$mb_admin_tables["files"], $send_data, $where_data);
							mbw_analytics("today_upload");						

							$img_small_size		= mbw_get_option("make_img_small_size");
							$img_middle_size		= mbw_get_option("make_img_middle_size");
							if(!empty($img_small_size)) mbw_create_image($uploadPath.$datePath.$file_name,"small"); 
							if(!empty($img_middle_size)) mbw_create_image($uploadPath.$datePath.$file_name,"middle"); 					
							$file_pid++;
							$file_sequence++;
						}
					}
				}
			}
			$upload_data["pid"]		= $file_pid-1;
		}else if(!empty($html5_file)){
			if(mbw_get_param("board_action") == "modify"){
				$file_sequence		= intval($mdb->get_var("select ".$api_fields["fn_file_sequence"]." from `".$mb_admin_tables["files"]."` WHERE ".$mb_fields["files"]["fn_board_pid"]."='".$send_data[$api_fields["fn_board_pid"]]."' and ".$mb_fields["files"]["fn_table_name"]."='".$send_data[$api_fields["fn_table_name"]]."' ORDER BY ".$api_fields["fn_file_sequence"]." DESC limit 1"))+1;
			}
			$file_data						= file_get_contents('php://input');
			$file_info						= new finfo(FILEINFO_MIME_TYPE);
			$mime_type					= $file_info->buffer($file_data);

			$upload_data["name"]		= rawurldecode($html5_file['file_name']);
			$upload_data["name"]		= mbw_check_upload_filename($upload_data["name"]);
			$file_size						= $html5_file["file_size"];			
			
			$name_array		= explode('.',$upload_data["name"]);
			if(count($name_array)==1) return false;
			$file_ext				= array_pop($name_array);
			$file_ext				= strtolower($file_ext);

			if(!in_array($file_ext, $check_ext)){
				mbw_error_message("MSG_UPLOAD_EXT_ERROR", $file_ext,"1502");
			}else if($args["type"]=="editor" && strpos($mime_type,"image/")!==0){
				mbw_error_message("MSG_ERROR", "Upload","1500");
			}else if($file_size>$limit_size){
				mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
			}else{
				$file_name						= $upload_data["name"];
				$tmp_name					= preg_replace("/[^_.0-9a-zA-Z-,]/u", '', $upload_data["name"]);
				if(strlen($tmp_name) != strlen($file_name)) $file_name						= mt_rand().".".$file_ext;

				$upload_data["path"]		= $datePath.mbw_get_file_name($file_pid,$file_name);

				if(isset($api_fields["fn_pid"]))						$send_data[$api_fields["fn_pid"]]							= $file_pid;
				if(isset($api_fields["fn_file_name"]))				$send_data[$api_fields["fn_file_name"]]				= $file_name;
				if(isset($api_fields["fn_file_sequence"]))			$send_data[$api_fields["fn_file_sequence"]]			= $file_sequence;
				if(isset($api_fields["fn_file_size"]))				$send_data[$api_fields["fn_file_size"]]					= $file_size;
				if(isset($api_fields["fn_file_type"]))				$send_data[$api_fields["fn_file_type"]]					= $html5_file["file_type"];
				if(isset($api_fields["fn_file_path"]))				$send_data[$api_fields["fn_file_path"]]					= $upload_data["path"];

				$file_name				= mbw_get_file_name($file_pid,$file_name);
				if(file_put_contents($uploadPath.$datePath.$file_name, $file_data)){
					@chmod($uploadPath.$datePath.$file_name, 0644);
					$mdb->db_query("INSERT",$mb_admin_tables["files"], $send_data, $where_data);
					mbw_analytics("today_upload");					

					$img_small_size		= mbw_get_option("make_img_small_size");
					$img_middle_size		= mbw_get_option("make_img_middle_size");
					if(!empty($img_small_size)) mbw_create_image($uploadPath.$datePath.$file_name,"small"); 
					if(!empty($img_middle_size)) mbw_create_image($uploadPath.$datePath.$file_name,"middle"); 					
				}
			}			
		}else if(!empty($_POST["img64"])){			
			$file_prefix			= "HE";			
			$file_ext				= "jpg";
			$file_type			= "image/jpeg";			

			if(mbw_get_param("file_name")!=""){
				$upload_data["name"]			= mbw_get_param("file_name");
			}else{				
				$upload_data["name"]			= $file_prefix.$args["board_pid"].".".$file_ext;
			}
			$name_array	= explode('.',$upload_data["name"]);
			if(count($name_array)==1) return $upload_data;
			$file_ext			= strtolower(array_pop($name_array));
			if(mbw_get_param("file_type")!=""){
				$file_type	= mbw_get_param("file_type");
			}else{
				if($file_ext=="png") $file_type	= "image/png";
			}
			$file_name			= mbw_get_file_name($file_pid,$upload_data["name"]);
			$file_path			= "";
			if(strpos($_POST["img64"], ',')!==false){
				$img_data				= explode(",",$_POST["img64"]);
				$_POST["img64"]		= str_replace(' ', '+', $img_data[1]);
			}
			$file_size			= strlen($_POST["img64"]);
			if(!in_array($file_ext, $mb_image_upload_files)){
				mbw_error_message("MSG_UPLOAD_EXT_ERROR", $file_ext,"1502");
			}else if($file_size>$limit_size){
				mbw_error_message("MSG_UPLOAD_SIZE_ERROR", mbw_get_option("upload_file_size"),"1503");
			}else{
				if(mbw_get_param("board_action") == "write"){
					$upload_data["path"]							= $datePath.$file_name;
					if(isset($api_fields["fn_pid"]))					$send_data[$api_fields["fn_pid"]]								= $file_pid;
					if(isset($api_fields["fn_file_name"]))			$send_data[$api_fields["fn_file_name"]]					= $upload_data["name"];
					if(isset($api_fields["fn_file_sequence"]))			$send_data[$api_fields["fn_file_sequence"]]			= $file_sequence;
					if(isset($api_fields["fn_file_size"]))				$send_data[$api_fields["fn_file_size"]]					= $file_size;
					if(isset($api_fields["fn_file_type"]))				$send_data[$api_fields["fn_file_type"]]					= $file_type;
					if(isset($api_fields["fn_file_path"]))				$send_data[$api_fields["fn_file_path"]]					= $upload_data["path"];
					$mdb->db_query("INSERT",$mb_admin_tables["files"], $send_data, $where_data);				
				}else{
					$upload_data["path"]		= ($mdb->get_var("select ".$mb_fields["files"]["fn_file_path"]." from `".$mb_admin_tables["files"]."` where ".$mb_fields["files"]["fn_file_name"]."='".$file_prefix.$args["board_pid"].".jpg"."' limit 1"));				
				}			
				
				$fd								= base64_decode($_POST["img64"]);
				$file_info						= new finfo(FILEINFO_MIME_TYPE);
				$mime_type					= $file_info->buffer($fd);
				if(strpos($mime_type,"image/")!==0){
					mbw_error_message("MSG_ERROR", "Upload","1500");
				}else{
					$fp		= fopen($uploadPath.$datePath.$file_name,"w");
					fwrite($fp,$fd);
					fclose($fp);
					@chmod($uploadPath.$datePath.$file_name, 0644);
					$img_small_size		= mbw_get_option("make_img_small_size");
					$img_middle_size		= mbw_get_option("make_img_middle_size");
					if(!empty($img_small_size)) mbw_create_image($uploadPath.$upload_data["path"],"small");
					if(!empty($img_middle_size)) mbw_create_image($uploadPath.$upload_data["path"],"middle");
				}
			}
		}
		return $upload_data;		
	}
}

if(!function_exists('mbw_create_image')){	
	function mbw_create_image($path,$size="200"){
		if(function_exists("imagejpeg") || function_exists("imagepng")){		
			global $mstore;
			$add_name		= "_".$size;
			if($size=="small") $size				= mbw_get_option("make_img_small_size");
			else if($size=="middle") $size				= mbw_get_option("make_img_middle_size");

			$max_size			= intval($size);
			$file_path			= substr($path,0,strrpos($path, ".")).$add_name.substr($path,strrpos($path, "."),strlen($path));

			list($img_width, $img_height, $type, $attr) = getimagesize($path);

			if($img_width>=$img_height){
				if($img_width >$max_size){			
					$create_width			= $max_size; 
					$create_height		= intval($img_height * ($create_width	/$img_width));
				}else return;			
			}else{
				if($img_height >$max_size){
					$create_height		= $max_size; 
					$create_width			= intval($img_width * ($create_height	/$img_height));
				}else return;
			}			

			if($type==2 && function_exists("imagejpeg")){		//jpg
				$create_img	= imagecreatetruecolor($create_width, $create_height);
				imagefill($create_img,0,0,imagecolorallocate($create_img, 255, 255, 255));		
				$img		= @imagecreatefromjpeg($path);
				if(!empty($img)){
					imagecopyresampled($create_img, $img, 0, 0, 0, 0, $create_width, $create_height, $img_width, $img_height);
					imagejpeg($create_img, $file_path, 80);
					@chmod($file_path, 0644);
				}else return;
			}else if($type==3 && function_exists("imagepng")){	//png
				$create_img	= imagecreatetruecolor($create_width, $create_height);
				imagefill($create_img,0,0,imagecolorallocate($create_img, 255, 255, 255));		
				$img		= @imagecreatefrompng($path);
				if(!empty($img)){
					imagecopyresampled($create_img, $img, 0, 0, 0, 0, $create_width, $create_height, $img_width, $img_height);
					imagepng($create_img, $file_path, 8);
					@chmod($file_path, 0644);
				}else return;
			}else return;			
		}	
	}
}

if(!function_exists('mbw_file_check')){
	function mbw_file_check($content,$board_pid, $type){
		mbw_add_trace("mbw_file_check");
		global $mstore,$mdb;
		global $mb_admin_tables,$mb_fields,$mb_board_table_name;

		$index1			= 0;
		$index2			= 0;
		if($type!="DELETE"){

			$user_auth_key	= $mdb->get_var($mdb->prepare("select ".$mb_fields["users"]["fn_user_auth_key"]." from `".$mb_admin_tables["users"]."` where `".$mb_fields["users"]["fn_user_id"]."`=%s", $user_id));

			$file_sequence		= intval($mdb->get_var($mdb->prepare("select ".$mb_fields["files"]["fn_file_sequence"]." from `".$mb_admin_tables["files"]."` WHERE ".$mb_fields["files"]["fn_board_pid"]."=%d and ".$mb_fields["files"]["fn_table_name"]."=%s ORDER BY ".$mb_fields["files"]["fn_file_sequence"]." DESC limit 1", $board_pid,$mb_board_table_name)))+1;

			$image_url		= mbw_get_file_url();
			$image_url		= str_replace(array("http://","https://"), "", $image_url);
			$pid_array		= array();

			while(($index1= strpos($content,$image_url,$index1))!==false){
				if(strpos($content,"%2FF",$index1)!==false){
					$index1		= strpos($content,"%2FF",$index1)+4;
				}else if(strpos($content,"/F",$index1)!==false){
					$index1		= strpos($content,"/F",$index1)+4;
				}else break;

				if(strpos($content,"_",$index1)!==false){
					$index2		= strpos($content,"_",$index1);
				}else break;

				$file_pid				= intval(substr($content,$index1,$index2-$index1));
				$table_name		= $mdb->get_var("select ".$mb_fields["files"]["fn_table_name"]." from `".$mb_admin_tables["files"]."` where ".$mb_fields["files"]["fn_pid"]."=".$file_pid);
				$pid_array[]			= $file_pid;

				if($table_name=="N"){
					$mdb->query($mdb->prepare("update ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=%d, ".$mb_fields["files"]["fn_board_name"]."=%s, ".$mb_fields["files"]["fn_table_name"]."=%s, ".$mb_fields["files"]["fn_file_sequence"]."=%d where ".$mb_fields["files"]["fn_pid"]."=%d", $board_pid,mbw_get_param("board_name"),$mb_board_table_name,$file_sequence, $file_pid));
				}else if(!empty($table_name) && $type!="UPDATE"){
					$mdb->query($mdb->prepare("update ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_link_count"]."=".$mb_fields["files"]["fn_link_count"]."+1 where ".$mb_fields["files"]["fn_pid"]."=%d", $file_pid));
				}
				$file_sequence++;
			}

			if($type=="UPDATE" && !empty($pid_array) && !empty($board_pid) && function_exists('array_column')){
				$select_query			= $mdb->prepare("SELECT pid FROM ".$mb_admin_tables["files"]." where ".$mb_fields["files"]["fn_table_name"]."=%s and ".$mb_fields["files"]["fn_board_pid"]."=%d and ".$mb_fields["files"]["fn_is_download"]."='0' and ".$mb_fields["files"]["fn_file_description"]."!=''", $mb_board_table_name, $board_pid );				
				$items					= $mdb->get_results($select_query,ARRAY_A);
				if(!empty($items)){
					$file_pid				= array_column($items, 'pid');
					$delete_pid			= array_diff($file_pid,$pid_array);
					//삭제된 이미지 연결 해제
					if(!empty($delete_pid)) $mdb->query("UPDATE ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=0 where ".$mb_fields["files"]["fn_pid"]." in (".implode(",",$delete_pid).")");
				}
			}
		}
	}
}


if(!function_exists('mbw_data_encode')){
	function mbw_data_encode($data,$type="JSON"){
		return json_encode($data);
	}
}


?>