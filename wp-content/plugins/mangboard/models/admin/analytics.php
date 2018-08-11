<?php
$desktop_model					= array();
$tablet_model					= array();
$mobile_model				= array();
$desktop_model['version']		= "1.0.0";

$desktop_model['list']		= '
{"type":"list_check","width":"50px","level":"10","class":"list_check"},
{"field":"fn_date","name":"W_DATE","width":"120px","mobile_width":"80px"},
{"field":"fn_today_join","name":"W_TODAY_JOIN","width":"70px","responsive":"mb-hide-mobile"},
{"field":"fn_today_write","name":"W_TODAY_WRITE","width":"70px","responsive":"mb-hide-mobile"},
{"field":"fn_today_reply","name":"W_TODAY_REPLY","width":"70px","responsive":"mb-hide-mobile"},
{"field":"fn_today_comment","name":"W_TODAY_COMMENT","width":"70px","responsive":"mb-hide-mobile"},
{"field":"fn_today_upload","name":"W_TODAY_UPLOAD","width":"70px","responsive":"mb-hide-mobile mb-hide-tablet"},
{"field":"fn_today_page_view","name":"W_TODAY_PAGE_VIEW","width":"90px"},
{"field":"fn_today_visit","name":"W_TODAY_VISIT","width":"90px"},
{"field":"fn_total_visit","name":"W_CUMULATE_VISIT","width":"100px","responsive":"mb-hide-mobile mb-hide-tablet","search":"false"}
';

//글보기 스킨 수정
$desktop_model['view']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_VIEW_MSG","width":"20%,*","mobile_width":"90px,*","class":"table table-view"},
{"field":"fn_date","name":"W_DATE","width":"300px"},
{"field":"fn_today_visit","name":"W_TODAY_VISIT","width":"300px"},
{"field":"fn_today_join","name":"W_TODAY_JOIN","width":"300px"},
{"field":"fn_today_write","name":"W_TODAY_WRITE","width":"300px"},
{"field":"fn_today_reply","name":"W_TODAY_REPLY","width":"300px"},
{"field":"fn_today_comment","name":"W_TODAY_COMMENT","width":"300px"},
{"field":"fn_today_upload","name":"W_TODAY_UPLOAD","width":"300px"},
{"field":"fn_page_view","name":"W_TODAY_PAGE_VIEW","width":"300px"},
{"field":"fn_total_visit","name":"W_CUMULATE_VISIT","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';


//글작성 스킨 수정
$desktop_model['write']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_WRITE","width":"20%,*","mobile_width":"90px,*","class":"table table-write"},
{"field":"fn_date","name":"W_DATE","width":"300px"},
{"field":"fn_today_visit","name":"W_TODAY_VISIT","width":"300px"},
{"field":"fn_today_join","name":"W_TODAY_JOIN","width":"300px"},
{"field":"fn_today_write","name":"W_TODAY_WRITE","width":"300px"},
{"field":"fn_today_reply","name":"W_TODAY_REPLY","width":"300px"},
{"field":"fn_today_comment","name":"W_TODAY_COMMENT","width":"300px"},
{"field":"fn_today_upload","name":"W_TODAY_UPLOAD","width":"300px"},
{"field":"fn_page_view","name":"W_TODAY_PAGE_VIEW","width":"300px"},
{"field":"fn_total_visit","name":"W_CUMULATE_VISIT","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';

$tablet_model									= $desktop_model;
$mobile_model								= $desktop_model;
mbw_set_fields("select_board",$mb_fields["analytics"]);

?>