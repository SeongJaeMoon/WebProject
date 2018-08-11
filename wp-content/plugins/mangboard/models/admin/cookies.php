<?php
$desktop_model					= array();
$tablet_model					= array();
$mobile_model				= array();
$desktop_model['version']		= "1.0.0";

$desktop_model['list']		= '
{"type":"list_check","width":"50px","level":"10","class":"list_check"},
{"field":"fn_pid","name":"W_PID","width":"60px"},
{"field":"fn_board_name","name":"W_BOARD_NAME","width":"120px"},
{"field":"fn_cookie_type","name":"Cookie Type","width":"140px"},
{"field":"fn_cookie_name","name":"Cookie Name","width":"180px"},
{"field":"fn_cookie_value","name":"Cookie Value","width":""},
{"field":"fn_user_name","name":"W_USER_NAME_PID","width":"120px","type":"admin_user_name_pid"},
{"field":"fn_agent","name":"Agent","width":"100px"},
{"field":"fn_ip","name":"IP","width":"140px"},
{"field":"fn_reg_date","name":"W_REGDATE","width":"150px"},
';

//글보기 스킨 수정
$desktop_model['view']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_VIEW_MSG","width":"20%,*","mobile_width":"90px,*","class":"table table-view"},
{"field":"fn_pid","name":"W_PID","width":"60px"},
{"field":"fn_board_name","name":"W_BOARD_NAME","width":"300px"},
{"field":"fn_cookie_type","name":"Cookie Type","width":"300px"},
{"field":"fn_cookie_name","name":"Cookie Name","width":"300px"},
{"field":"fn_cookie_value","name":"Cookie Value","width":"300px"},
{"field":"fn_user_pid","name":"W_USER_PID","width":"300px"},
{"field":"fn_agent","name":"Agent","width":"300px"},
{"field":"fn_ip","name":"IP","width":"300px"},
{"field":"fn_reg_date","name":"W_REGDATE","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';


//글작성 스킨 수정
$desktop_model['write']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_WRITE","width":"20%,*","mobile_width":"90px,*","class":"table table-write"},
{"field":"fn_board_name","name":"W_BOARD_NAME","width":"300px"},
{"field":"fn_cookie_type","name":"Cookie Type","width":"300px"},
{"field":"fn_cookie_name","name":"Cookie Name","width":"300px"},
{"field":"fn_cookie_value","name":"Cookie Value","width":"300px"},
{"field":"fn_user_pid","name":"W_USER_PID","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';

$tablet_model									= $desktop_model;
$mobile_model								= $desktop_model;
mbw_set_fields("select_board",$mb_fields["cookies"]);


if(mbw_is_admin_page()){		//어드민 페이지에서만 실행
	if(mbw_get_request_mode()=="Frontend"){		// 게시판 모드일 경우에만
		add_action('mbw_board_skin_search', 'mbw_get_date_search_template');		// 기간 설정 템플릿 추가
	}
}

?>