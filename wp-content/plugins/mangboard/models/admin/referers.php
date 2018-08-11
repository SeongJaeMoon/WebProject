<?php
$desktop_model					= array();
$tablet_model					= array();
$mobile_model				= array();
$desktop_model['version']		= "1.0.0";

$desktop_model['list']		= '
{"type":"list_check","width":"40px","level":"10","class":"list_check"},
{"field":"fn_pid","name":"W_PID","width":"60px","class":"num","type":"pid","class":"pid","responsive":"mb-hide-mobile mb-hide-tablet"},
{"field":"fn_referer_url","name":"Referer","width":"","type":"url_link","td_class":"text-left"},
{"field":"fn_ip","name":"IP","width":"120px","type":"admin_ip_agent","responsive":"mb-hide-mobile mb-hide-tablet"},
{"field":"fn_reg_date","name":"W_REGDATE","width":"130px","responsive":"mb-hide-mobile"},
';

//글보기 스킨 수정
$desktop_model['view']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_VIEW_MSG","width":"20%,*","mobile_width":"90px,*","class":"table table-view"},
{"field":"fn_pid","name":"W_PID","width":"60px"},
{"field":"fn_date","name":"W_DATE","width":"300px"},
{"field":"fn_referer_host","name":"Host","width":"300px"},
{"field":"fn_referer_url","name":"Referer","width":"300px"},
{"field":"fn_agent","name":"Agent","width":"300px"},
{"field":"fn_ip","name":"IP","width":"300px"},
{"field":"fn_reg_date","name":"W_REGDATE","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';


//글작성 스킨 수정
$desktop_model['write']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_WRITE","width":"20%,*","mobile_width":"90px,*","class":"table table-write"},
{"field":"fn_date","name":"W_DATE","width":"300px"},
{"field":"fn_referer_host","name":"Host","width":"300px"},
{"field":"fn_referer_url","name":"Referer","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';

$tablet_model									= $desktop_model;
$mobile_model								= $desktop_model;
mbw_set_fields("select_board",$mb_fields["referers"]);


if(mbw_is_admin_page()){		//어드민 페이지에서만 실행
	if(mbw_get_request_mode()=="Frontend"){		// 게시판 모드일 경우에만
		add_action('mbw_board_skin_search', 'mbw_get_date_search_template');		// 기간 설정 템플릿 추가
	}
}

?>