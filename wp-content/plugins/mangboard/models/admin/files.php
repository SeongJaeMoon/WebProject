<?php
$desktop_model					= array();
$tablet_model					= array();
$mobile_model				= array();
$desktop_model['version']		= "1.0.0";

$desktop_model['list']		= '
{"type":"list_check","width":"40px","level":"10","class":"list_check"},
{"field":"fn_pid","name":"W_PID","width":"60px","responsive":"mb-hide-mobile mb-hide-tablet"},
{"field":"fn_file_path","name":"W_IMAGE","width":"50px","height":"50px","search":"false","type":"img_ratio_link","size":"small"},
{"field":"fn_board_name","name":"W_BOARD_NAME_PID","width":"150px","type":"admin_board_name_pid","responsive":"mb-hide-mobile"},
{"field":"fn_file_name","name":"File Name","width":"","type":"admin_file_name_size","td_class":"text-left"},
{"field":"fn_download_count","name":"Download","width":"70px"},
{"field":"fn_link_count","name":"Link","width":"50px","responsive":"mb-hide-mobile"},
{"field":"fn_user_name","name":"W_USER_REGDATE","width":"160px","type":"admin_user_name_pid_date","responsive":"mb-hide-mobile"},
{"field":"fn_ip","name":"IP","width":"140px","type":"admin_ip_agent","responsive":"mb-show-desktop-large"}
';

//글보기 스킨 수정
$desktop_model['view']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_VIEW_MSG","width":"20%,*","mobile_width":"90px,*","class":"table table-view"},
{"field":"fn_pid","name":"W_PID","width":"60px"},
{"field":"fn_user_name","name":"W_USER_NAME","width":"40px"},
{"field":"fn_board_name","name":"W_BOARD_NAME","width":"40px"},
{"field":"fn_board_pid","name":"W_BOARD_PID","width":"40px"},
{"field":"fn_file_name","name":"File Name","width":"40px"},
{"field":"fn_file_caption","name":"File Caption","width":"40px"},
{"field":"fn_file_alt","name":"File Alt","width":"40px"},
{"field":"fn_file_description","name":"File Description","width":"40px"},
{"field":"fn_file_size","name":"File Size","width":"40px"},
{"field":"fn_reg_date","name":"W_REGDATE","width":"40px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';


//글작성 스킨 수정
$desktop_model['write']		= '
{"tpl":"tag","tag_name":"table","type":"start","name":"W_WRITE","width":"20%,*","mobile_width":"90px,*","class":"table table-write"},
{"field":"fn_user_name","name":"W_USER_NAME","width":"300px"},
{"field":"fn_board_name","name":"W_BOARD_NAME","width":"300px"},
{"field":"fn_board_pid","name":"W_BOARD_PID","width":"300px"},
{"field":"fn_file_name","name":"File name","width":"300px"},
{"field":"fn_file_caption","name":"File Caption","width":"300px"},
{"field":"fn_file_alt","name":"File Alt","width":"300px"},
{"field":"fn_file_description","name":"File Description","width":"300px"},
{"field":"fn_file_size","name":"File Size","width":"300px"},
{"field":"fn_reg_date","name":"W_REGDATE","width":"300px"},
{"tpl":"tag","tag_name":"table","type":"end"}
';

$tablet_model									= $desktop_model;
$mobile_model								= $desktop_model;
mbw_set_fields("select_board",$mb_fields["files"]);



function mbw_board_files_api_body(){	
	global $mdb,$mb_fields,$mb_admin_tables,$mstore;
	$where_query			= "";
	$query_command	= "";
	$field						= $mb_fields["files"];
	
	if(mbw_is_admin()){
				
		if(mbw_get_param("board_action")=="delete"){			
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
			$select_query				= "SELECT * FROM ".$mb_admin_tables["files"].$where_query;
			$items						= $mdb->get_results($select_query,ARRAY_A);
			
			foreach($items as $item){
				if($item[$field["fn_link_count"]]=="0"){
					$file_path		= MBW_UPLOAD_PATH.$item[$field["fn_file_path"]];

					if(is_file($file_path)){
						@unlink($file_path);

						$file_path_small		= substr($file_path,0,strrpos($file_path, "."))."_small".substr($file_path,strrpos($file_path, "."),strlen($file_path));
						if(is_file($file_path_small)) @unlink($file_path_small);

						$file_path_middle		= substr($file_path,0,strrpos($file_path, "."))."_middle".substr($file_path,strrpos($file_path, "."),strlen($file_path));						
						if(is_file($file_path_middle)) @unlink($file_path_middle);

					}
				}
			}
		}
	}
}
add_action('mbw_board_api_body', 'mbw_board_files_api_body',5); 

mbw_set_board_option("fn_delete_level",10);
if(mbw_is_admin_page()){		//어드민 페이지에서만 실행
	if(mbw_get_request_mode()=="Frontend"){		// 게시판 모드일 경우에만
		add_action('mbw_board_skin_search', 'mbw_get_date_search_template');		// 기간 설정 템플릿 추가		
	}
}

?>