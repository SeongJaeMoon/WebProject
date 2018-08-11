<?php
$desktop_model					= array();
$tablet_model					= array();
$mobile_model				= array();
$desktop_model['version']		= "1.0.0";

$desktop_model['list']		= '
{"type":"list_check","width":"40px","level":"10","class":"list_check"},
{"field":"fn_board_name2","name":"W_BOARD_NAME","width":"","type":"admin_board_name","td_class":"text-left"},
{"field":"fn_skin_name","name":"W_SKIN_MODEL","width":"130px","type":"admin_skin_model","responsive":"mb-hide-mobile mb-hide-tablet"},
{"type":"admin_board_level","name":"W_AUTHORITY","width":"160px","td_class":"text-left","responsive":"mb-hide-mobile mb-hide-tablet"},
{"type":"admin_board_analytics","name":"W_STATUS_POSTINGS","width":"80px","responsive":"mb-hide-mobile"},
{"field":"admin_btn","name":"","name_btn":"W_SETTING","width":"90px","type":"admin_board_modify"}
';


$desktop_model['view']		= '
{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_BOARD_SETTING').'","style":"font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"W_VIEW_MSG","width":"20%,*","mobile_width":"90px,*","class":"table table-view"},
{"field":"fn_board_name2","name":"W_BOARD_NAME","width":"300px"},
{"field":"fn_description","name":"W_EXPLANATION_BOARD","width":"300px"},

{"field":"fn_skin_name","name":"W_SKIN_NAME","width":"250px"},
{"field":"fn_model_name","name":"W_MODEL_NAME","width":"250px","type":"admin_select_model_list","attribute":"disabled=\'true\'"},
{"field":"fn_editor_type","name":"W_EDITOR_SETTING","width":"250px","type":"admin_select_editor_list","attribute":"disabled=\'true\'"},
{"field":"fn_page_size","name":"W_LIST_COUNT","width":"200px","format":"count"},
{"field":"fn_comment_size","name":"W_COMMENT_COUNT","width":"200px","format":"count"},
{"field":"fn_block_size","name":"W_PAGE_BLOCK_COUNT","width":"200px","format":"count"},
{"field":"fn_use_list_title","name":"W_SHOW_TITLE_BAR","width":"100px","data":"1,0","label":"W_ON_OFF","default":"1","attribute":"disabled=\'true\'"},
{"field":"fn_use_comment","name":"W_COMMENT_FUNCTION","width":"100px","data":"1,0","label":"W_ON_OFF","default":"1","attribute":"disabled=\'true\'"},
{"field":"fn_use_notice","name":"W_NOTIFI_FUNCTION","width":"100px","data":"1,0","label":"W_ON_OFF","default":"1","attribute":"disabled=\'true\'"},
{"field":"fn_use_secret","name":"W_SECRET_FUNCTION","width":"100px","data":"1,2,0","label":"W_USE_SECRET_LABEL","default":"1","attribute":"disabled=\'true\'"},
{"field":"fn_post_id","name":"W_WORDPRESS_POSTID","width":"100px"},
{"field":"fn_table_link","name":"W_CONNECT_BOARD","width":"195px","type":"admin_select_board_link","data":"","label":"","class":"ext1","combo":{"field":"fn_table_link2","width":"200px","match_type":"show","match_value":"custom"},"attribute":"disabled=\'true\'"},
{"field":"fn_category_type","name":"W_CATEGORY_FUNCTION","width":"400px","type":"select","data":"NONE,TAB_RELOAD,TAB_AJAX,SELECT_NONE,SELECT_RELOAD,SELECT_AJAX","label":"'.__MW('W_OFF').','.__MW('W_TAP_MENU_REFRESH').','.__MW('W_TAP_MENU_AJAX').','.__MW('W_SELECT_CATEGORY_CLICK').','.__MW('W_SELECT_CATEGORY_REFRESH').','.__MW('W_SELECT_CATEGORY_AJAX').'","default":"NONE","attribute":"disabled=\'true\'"},
{"field":"fn_category_data","name":"W_CATEGORY_DATA","width":"600px"},
{"field":"fn_board_header","name":"W_BOARD_TOP_TEXT","width":"600px"},
{"field":"fn_board_footer","name":"W_BOARD_BOTTOM_TEXT","width":"600px"},
{"field":"fn_board_content_form","name":"W_WRITING_FORM","width":"600px"},
{"tpl":"tag","tag_name":"table","type":"end"},

{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_RECOM_SET').'","style":"margin-top:20px;font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"W_RECOM_SET","width":"20%,*","mobile_width":"90px,*","class":"table table-view","style":""},

{"field":"fn_use_board_vote_good","name":"W_BOARD_RECOM","width":"100px","data":"1,0","label":"W_ON_OFF","default":"0","attribute":"disabled=\'true\'"},
{"field":"fn_use_board_vote_bad","name":"W_BOARD_NON_RECOM","width":"100px","data":"1,0","label":"W_ON_OFF","default":"0","attribute":"disabled=\'true\'"},
{"field":"fn_use_comment_vote_good","name":"W_COMMENT_RECOM","width":"100px","data":"1,0","label":"W_ON_OFF","default":"0","attribute":"disabled=\'true\'"},
{"field":"fn_use_comment_vote_bad","name":"W_COMMENT_NON_RECOM","width":"100px","data":"1,0","label":"W_ON_OFF","default":"0","attribute":"disabled=\'true\'"},
{"tpl":"tag","tag_name":"table","type":"end"},

{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_BOARD_AUTHORITY_SET').'","style":"margin-top:20px;font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"BOARD AUTHORITY","width":"20%,*","mobile_width":"90px,*","class":"table table-view","style":""},
{"field":"fn_list_level","name":"W_AUTHORITY_LIST","width":"100px","format":" Level"},
{"field":"fn_write_level","name":"W_AUTHORITY_WRITE","width":"100px","format":" Level"},
{"field":"fn_view_level","name":"W_AUTHORITY_VIEW","width":"100px","format":" Level"},
{"field":"fn_reply_level","name":"W_AUTHORITY_REPLAY","width":"100px","format":" Level"},
{"field":"fn_comment_level","name":"W_AUTHORITY_COMMENT","width":"100px","format":" Level"},
{"field":"fn_modify_level","name":"W_AUTHORITY_MODIFY","width":"100px","format":" Level"},
{"field":"fn_secret_level","name":"W_AUTHORITY_SECRET","width":"100px","format":" Level"},
{"field":"fn_delete_level","name":"W_AUTHORITY_DELETE","width":"100px","format":" Level"},
{"field":"fn_manage_level","name":"W_AUTHORITY_ADMIN","width":"100px","format":" Level"},

{"tpl":"tag","tag_name":"table","type":"end"},

{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_POINT_SET').'","style":"margin-top:20px;font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"W_POINT_SET","width":"20%,*","mobile_width":"90px,*","class":"table table-view","style":""},
{"field":"fn_point_board_write","name":"W_WRITE_POINT","width":"100px","format":"point"},
{"field":"fn_point_board_reply","name":"W_REPLY_POINT","width":"100px","format":"point"},
{"field":"fn_point_comment_write","name":"W_COMMENT_POINT","width":"100px","format":"point"},

{"tpl":"tag","tag_name":"table","type":"end"}
';

$mb_locale			= mbw_get_option("locale");
$default_editor	= "S";
if($mb_locale!="ko_KR") $default_editor		= "C";

$desktop_model['write']		= '
{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_BOARD_SETTING').'","style":"font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"W_BOARD_SETTING","width":"20%,*","mobile_width":"90px,*","class":"table table-write"},
{"field":"fn_board_name2","name":"W_BOARD_NAME","width":"250px","required":"(*)","unique":"","modify":"text_static","maxlength":"30","pattern":"pattern_en_num_4ge","pattern_error":"MSG_BOARD_NAME_INPUT_CHECK","description":"<br>(MSG_BOARD_NAME_INPUT_CHECK)"},
{"field":"fn_description","name":"W_EXPLANATION_BOARD","width":"400px","description":"<br>(MSG_BOARD_EXPLANATION_INPUT)"},
{"field":"fn_board_type","name":"W_BOARD_TYPE","type":"hidden","default":"board","display":"hide"},
{"field":"fn_skin_name","name":"W_SKIN_NAME","width":"250px","type":"admin_select_skin_list","default":"bbs_basic"},
{"field":"fn_model_name","name":"W_MODEL_NAME","width":"250px","type":"admin_select_model_list","description":"<br>(MSG_BOARD_MODEL_SET)"},
{"field":"fn_editor_type","name":"W_EDITOR_SETTING","width":"250px","type":"admin_select_editor_list","default":"'.$default_editor.'","description":"<br>(MSG_EDITOR_SELECT)"},

{"field":"fn_page_size","name":"W_LIST_COUNT","width":"100px","type":"select","data":"1,2,3,4,5,6,7,8,9,10,15,20,25,30,50,100","default":"20","description":"<br>(MSG_NUM_POST_ONE_PAGE)"},
{"field":"fn_comment_size","name":"W_COMMENT_COUNT","width":"100px","type":"select","data":"1,2,3,4,5,6,7,8,9,10,15,20,25,30,35,40,45,50","default":"50","description":"<br>(MSG_NUM_COMMENT_ONE_PAGE)"},
{"field":"fn_block_size","name":"W_PAGE_BLOCK_COUNT","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10,100","default":"10","description":"<br>(MSG_PAGE_BLOCK_NUM_SET)"},
{"field":"fn_use_list_title","name":"W_SHOW_TITLE_BAR","width":"100px","type":"select","data":"1,0","label":"W_ON_OFF","default":"1","description":"<br>(MSG_TITLE_BAR_LIST)"},
{"field":"fn_use_comment","name":"W_COMMENT_FUNCTION","width":"100px","type":"select","data":"1,0","label":"W_ON_OFF","default":"1"},
{"field":"fn_use_notice","name":"W_NOTIFI_FUNCTION","width":"100px","type":"select","data":"1,0","label":"W_ON_OFF","default":"1"},
{"field":"fn_use_secret","name":"W_SECRET_FUNCTION","width":"100px","type":"select","data":"1,2,0","label":"W_USE_SECRET_LABEL","default":"1"},
{"field":"fn_post_id","name":"W_WORDPRESS_POSTID","width":"100px","write":"none","description":"<br>(MSG_POST_ID_ENTER)"},
{"field":"fn_table_link","name":"W_CONNECT_BOARD","width":"195px","type":"admin_select_board_link","data":"","label":"","class":"ext1","combo":{"field":"fn_table_link2","width":"200px","match_type":"show","match_value":"custom"},"description":"<br>(MSG_BOARD_SET_CHANGE)"},
{"field":"fn_category_type","name":"W_CATEGORY_FUNCTION","width":"400px","type":"select","data":"NONE,TAB_RELOAD,TAB_AJAX,SELECT_NONE,SELECT_RELOAD,SELECT_AJAX","label":"'.__MW('W_OFF').','.__MW('W_TAP_MENU_REFRESH').','.__MW('W_TAP_MENU_AJAX').','.__MW('W_SELECT_CATEGORY_CLICK').','.__MW('W_SELECT_CATEGORY_REFRESH').','.__MW('W_SELECT_CATEGORY_AJAX').'","default":"NONE","description":"<br>(MSG_SHOW_CATEGORY)"},
{"field":"fn_category_data","name":"W_CATEGORY_DATA","width":"600px","type":"textarea","description":"<br>'.__MW('W_CATEGORY1_DISTING_COMMA').' : 111,222,333,444,555,666,777<br>'.__MW('W_CATEGORY2_JSON_TYPE').' : { \"100\":{\"110\":{\"111\":\"111\",\"112\":\"112\"},\"120\":\"120\"}, \"200\":{\"210\":{\"211\":\"211\",\"212\":\"212\"},\"220\":\"220\"}, \"300\":\"300\"}"},
{"field":"fn_board_header","name":"W_BOARD_TOP_TEXT","width":"600px","type":"textarea","description":"<br>(MSG_BOARD_TOP_HTML)"},
{"field":"fn_board_footer","name":"W_BOARD_BOTTOM_TEXT","width":"600px","type":"textarea","description":"<br>(MSG_BOARD_BOTTOM_HTML)"},
{"field":"fn_board_content_form","name":"W_WRITING_FORM","width":"600px","type":"textarea","description":"<br>(MSG_DEFAULT_FORM_ENTER)"},
{"tpl":"tag","tag_name":"table","type":"end"},

{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_RECOM_SET').'","style":"margin-top:20px;font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"W_RECOM_SET","width":"20%,*","mobile_width":"90px,*","class":"table table-view","style":""},
{"field":"fn_use_board_vote_good","name":"W_BOARD_RECOM","width":"100px","type":"select","data":"1,0","label":"W_ON_OFF","default":"0"},
{"field":"fn_use_board_vote_bad","name":"W_BOARD_NON_RECOM","width":"100px","type":"select","data":"1,0","label":"W_ON_OFF","default":"0"},
{"field":"fn_use_comment_vote_good","name":"W_COMMENT_RECOM","width":"100px","type":"select","data":"1,0","label":"W_ON_OFF","default":"0"},
{"field":"fn_use_comment_vote_bad","name":"W_COMMENT_NON_RECOM","width":"100px","type":"select","data":"1,0","label":"W_ON_OFF","default":"0"},
{"tpl":"tag","tag_name":"table","type":"end"},

{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_BOARD_AUTHORITY_SET').'","style":"margin-top:20px;font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"BOARD AUTHORITY","width":"20%,*","mobile_width":"90px,*","class":"table table-view","style":""},
{"field":"fn_list_level","name":"W_AUTHORITY_LIST","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"0","description":"<br>(MSG_LIST_VIEW_AUTHORITY)"},
{"field":"fn_write_level","name":"W_AUTHORITY_WRITE","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"0","description":"<br>(MSG_SET_WRITE)"},
{"field":"fn_view_level","name":"W_AUTHORITY_VIEW","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"0","description":"<br>(MSG_SET_VIEW)"},
{"field":"fn_reply_level","name":"W_AUTHORITY_REPLAY","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"0","description":"<br>(MSG_SET_REPLY)"},
{"field":"fn_comment_level","name":"W_AUTHORITY_COMMENT","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"0","description":"<br>(MSG_SET_COMMENT)"},
{"field":"fn_modify_level","name":"W_AUTHORITY_MODIFY","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"8","description":"<br>(MSG_AUTHORITY_MODIFY)"},
{"field":"fn_secret_level","name":"W_AUTHORITY_SECRET","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"8","description":"<br>(MSG_AUTHORITY_SECRET_MSG)"},
{"field":"fn_delete_level","name":"W_AUTHORITY_DELETE","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"8","description":"<br>(MSG_AUTHORITY_DELETE)"},
{"field":"fn_manage_level","name":"W_AUTHORITY_ADMIN","width":"100px","type":"select","data":"0,1,2,3,4,5,6,7,8,9,10","default":"8","description":"<br>(MSG_AUTHORITY_BOARD_ADMIN)"},
{"tpl":"tag","tag_name":"table","type":"end"},

{"tpl":"tag","tag_name":"div","text":"■ '.__MW('W_POINT_SET').'","style":"margin-top:20px;font-weight:600;font-size:14px;padding:5px 2px;"},
{"tpl":"tag","tag_name":"table","type":"start","name":"W_POINT_SET","width":"20%,*","mobile_width":"90px,*","class":"table table-view","style":""},
{"field":"fn_point_board_write","name":"W_WRITE_POINT","width":"100px","default":"0","maxlength":"8","description":"<br>(MSG_POINT_WRITING)"},
{"field":"fn_point_board_reply","name":"W_REPLY_POINT","width":"100px","default":"0","maxlength":"8","description":"<br>(MSG_POINT_REPLY)"},
{"field":"fn_point_comment_write","name":"W_COMMENT_POINT","width":"100px","default":"0","maxlength":"8","description":"<br>(MSG_POINT_COMMENT)"},
{"tpl":"tag","tag_name":"table","type":"end"}
';



$tablet_model									= $desktop_model;
$mobile_model								= $desktop_model;
mbw_set_fields("select_board",$mb_fields["board_options"]);

if(mbw_get_param("show")=="all"){
	mbw_set_param("page_size",100);	
}else{
	if(mbw_get_param("mode")=="" || mbw_get_param("mode")=="list"){
		mbw_set_board_where(array("field"=>"fn_is_show", "value"=>"1"));
	}
}

mbw_set_pattern("pattern_en_num_4ge","/^[a-z]+[a-z0-9_]{3,29}$/i");



function mbw_board_options_api_body(){	
	global $mdb,$mb_fields,$mb_admin_tables,$mstore;
	$where_query			= "";
	$query_command	= "";
	$field						= $mb_fields["board_options"];
	if(mbw_is_admin()){
		//게시판 추가시 디비 테이블 추가 액션
		if(mbw_get_param("board_action")=="write"){		
			$query_command												= "INSERT";	
			if(empty($_POST["table_link"]) && mbw_get_param("board_name2")!=""){
				$board_table_name			= mbw_get_table_name(mbw_get_param("board_name2"),"board","mb");

				if(!$mstore->table_exists($board_table_name))	//게시판 테이블이 존재하지 않으면
					mbw_create_board_table(mbw_get_param("board_name2"));		//게시판 테이블 생성
			}
		//게시판 삭제시 디비 테이블 삭제하는 액션
		}else if(mbw_get_param("board_action")=="delete"){
			$query_command		= "DELETE";	
			$where_query				= $mdb->prepare(" WHERE ".$field["fn_pid"]."=%d", mbw_get_param("board_pid") );
		}else if(mbw_get_param("board_action")=="multi_delete"){
			$query_command		= "DELETE";	
			$pid_array					= mbw_get_param("check_array");		
			$pid_format				= array();
			foreach($pid_array as $key){
				$pid_format[]			= "%d";
			}
			$where_query				= $mdb->prepare(" WHERE ".$field["fn_pid"]." in (".implode(",",$pid_format).")", $pid_array );	
		}

		if($query_command=="DELETE"){
			$select_query				= "SELECT * FROM ".$mb_admin_tables["board_options"].$where_query;
			$items						= $mdb->get_results($select_query,ARRAY_A);

			foreach($items as $item){
				if($item[$field["fn_table_link"]]=="" && $item[$field["fn_board_type"]]=="board"){
					$board_table_name			= mbw_get_table_name($item[$field["fn_board_name2"]]);
					$comment_table_name		= mbw_get_table_name($item[$field["fn_board_name2"]],"comment");

					if($mstore->table_exists($board_table_name))	mbw_drop_query($board_table_name);
					if($mstore->table_exists($comment_table_name))	mbw_drop_query($comment_table_name);				
				}
			}	
		}
	}
}
add_action('mbw_board_api_body', 'mbw_board_options_api_body',5); 

function mbw_board_options_api_init(){	
	//게시판 연결 기능시 table_link2 데이타를 table_link에 설정
	if(mbw_get_param("table_link")=="custom"){
		mbw_set_param("table_link",mbw_get_param("table_link2"));
		mbw_set_param("use_comment","0");
		mbw_set_param("board_type","custom");
	}else if(mbw_get_param("table_link")!=""){
		mbw_set_param("board_type","link");
	}
}
add_action('mbw_board_api_init', 'mbw_board_options_api_init',5); 


function mbw_board_options_skin_header(){	
	//게시판 설정 복사
	if(mbw_get_param("board_action") == "write" && mbw_get_param("board_pid")!="") {
		$select_query				= mbw_get_add_query(array("column"=>"*"), array(array("field"=>"fn_pid","value"=>mbw_get_param("board_pid"))));
		$board_item				= mbw_get_board_item_query($select_query);
		mbw_set_board_item("fn_board_name2","");
	}
}
add_action('mbw_board_skin_header', 'mbw_board_options_skin_header',5); 


mbw_set_category_fields(array("fn_board_type"));		//카테고리 필드 수정
if(mbw_is_admin_page()){		//어드민 페이지에서만 실행	
	if(mbw_get_request_mode()=="Frontend"){		// 게시판 모드일 경우에만
		//카테고리 데이타 수정
		$category		= $mdb->get_distinct_values($mb_admin_tables["board_options"],$mb_fields["board_options"]["fn_board_type"],array(array("field"=>$mb_fields["board_options"]["fn_is_show"],"value"=>"1")));		//board_type 필드에서 고유한 값을 배열로 가져옴

		if(!empty($category)) mbw_set_board_option("fn_category_data", implode(",",$category));
	}
}

$mb_words["Write"]		= "W_BOARD_INSERT";

?>