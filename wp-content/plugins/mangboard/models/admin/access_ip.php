<?php
$desktop_model				= array();
$tablet_model					= array();
$mobile_model				= array();
$desktop_model['version']	= "1.0.0";

$desktop_model['list']		= '
{"type":"list_check","width":"50px","level":"10","class":"list_check"},
{"field":"fn_pid","name":"W_PID","width":"60px"},
{"field":"fn_type","name":"W_TYPE","width":"120px","search":"false","data":"0,1","label":"W_DENY_ALLOW"},
{"field":"fn_ip","name":"IP","width":"200px"},
{"field":"fn_description","name":"W_DESCRIPTION","width":""},
{"field":"fn_reg_date","name":"W_REGDATE","width":"150px"}
';

//글보기 스킨 수정
$desktop_model['view']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_VIEW_MSG","width":"20%,*","mobile_width":"90px,*","class":"table table-view"},
{"field":"fn_pid","name":"W_PID","width":"300px"},
{"field":"fn_type","name":"W_TYPE","width":"300px"},
{"field":"fn_ip","name":"IP","width":"300px"},
{"field":"fn_description","name":"W_DESCRIPTION","width":"300px"},
{"field":"fn_reg_date","name":"W_REGDATE","width":"300px"}
{"tpl":"tag","tag_name":"table","type":"end"}
';


//글작성 스킨 수정
$desktop_model['write']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_WRITE","width":"20%,*","mobile_width":"90px,*","class":"table table-write"},
{"field":"fn_type","name":"W_TYPE","width":"100px","type":"select","data":"0,1","label":"W_DENY_ALLOW","default":"0","description":"<br>MSG_ACCESS_IP_ALLOW_DESC"},
{"field":"fn_ip","name":"IP","width":"250px","required":"(*)"},
{"field":"fn_description","name":"W_DESCRIPTION","width":"600px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';

$tablet_model									= $desktop_model;
$mobile_model								= $desktop_model;

mbw_set_fields("select_board",$mb_fields["access_ip"]);

$mb_words["Write"]							= "W_ADD";
?>
