<?php
define("MBW_REQUEST_MODE", "API");
if(!defined('_MB_')) exit();

do_action('mbw_board_api_init');
if(!mbw_verify_nonce()){
	if(mbw_get_param("board_action")=="board_hit") {echo mbw_data_encode($mstore->result_data);exit;}	
	mbw_error_message("MSG_NONCE_MATCH_ERROR", "","1401");
}


$send_data					= array();
$where_data				= array();
$query_data				= array();
$query1						= "";
$query2						= "";
$query_command		= "";
$board_pid			= intval(mbw_get_param("board_pid"));

$api_fields			= $mb_fields["select_board"];
$send_data			= mbw_set_api_params($api_fields);
mbw_check_api_permission($api_fields,$send_data);
mbw_check_api_required($api_fields,$send_data);

do_action('mbw_board_api_header');

$file_check				= false;
if(mbw_get_param("mode")=="write")
	$upload_check		= mbw_check_api_file("board");


if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}

if(mbw_get_param("mode")=="write" && mbw_get_param("board_action")=="modify"){
	$query_command												= "UPDATE";

	if(intval(mbw_get_board_option("fn_use_notice")) == 1 && intval(mbw_get_user("fn_user_level"))>=mbw_get_option("admin_level") && isset($api_fields["fn_is_notice"])){
		//공지사항 해제일 경우
		if(empty($send_data[$api_fields["fn_is_notice"]])){		
			if(isset($api_fields["fn_gid"])){
				$notice_state		= intval($mdb->get_var("select ".$api_fields["fn_is_notice"]." from `".$mb_board_table_name."` where ".$api_fields["fn_pid"]."='".$board_pid."' limit 1"));			
				//공지사항 해제일 경우 gid 숫자를 내려서 정렬을 원위치 시킴
				if($notice_state==1)
					$send_data[$api_fields["fn_gid"]]						= $board_pid;
			}
			$send_data[$api_fields["fn_is_notice"]]						= 0;
		//공지사항 등록일 경우
		}else{
			if(isset($api_fields["fn_gid"])){
				$notice_state		= intval($mdb->get_var("select ".$api_fields["fn_is_notice"]." from `".$mb_board_table_name."` where ".$api_fields["fn_pid"]."='".$board_pid."' limit 1"));			
				if($notice_state==0)
					$send_data[$api_fields["fn_gid"]]						= $board_pid+1000000;				
			}		
			$send_data[$api_fields["fn_is_notice"]]						= 1;
		}
	}
	if(intval(mbw_get_board_option("fn_use_secret")) != 0 && isset($api_fields["fn_is_secret"])){	
		if(empty($send_data[$api_fields["fn_is_secret"]])) $send_data[$api_fields["fn_is_secret"]]	= 0;
		else $send_data[$api_fields["fn_is_secret"]]	= 1;
	}

	$where_data[$api_fields["fn_pid"]]			= $board_pid;
}else if((intval(mbw_get_board_option("fn_modify_level")) <= intval(mbw_get_user("fn_user_level"))) && mbw_get_param("board_action")=="multi_modify"){	
	//체크박스가 선택된 항목만 수정
	if(mbw_get_param("check_array")!=""){
		$checked_pid			= ",".implode(",",mbw_get_param("check_array")).",";
	}else if(!empty($board_pid)){
		$checked_pid			= ",".$board_pid.",";
	}
	
	if(!empty($checked_pid)){	
		$query_command											= "UPDATE";
		$pid_data				= mbw_get_param($api_fields["fn_pid"]."_array");	
		$count					= count($pid_data);

		for($i=0;$i<$count;$i++){
			$modify_data		= array();
			if(strpos($checked_pid, $pid_data[$i])!==false){			
				foreach($send_data as $key => $value){
					if(is_array($send_data[$key])){						
						$modify_data[$key]										= $send_data[$key][$i];						
					}
				}
				$where_data[$api_fields["fn_pid"]]					= $pid_data[$i];
				if(isset($api_fields["fn_modify_date"]))	$modify_data[$api_fields["fn_modify_date"]]	= mbw_get_current_time();
				$mdb->db_query($query_command,$mb_board_table_name, $modify_data, $where_data);
			}
		}
		$query_command		= "";
	}
}else if(mbw_get_param("mode")=="write" && mbw_get_param("board_action")=="reply"){
	$query_command												= "INSERT";	
	$board_gid				= intval(mbw_get_param("board_gid"));
	$board_reply			= intval(mbw_get_param("board_reply"));
	$board_pid				= intval($mdb->get_var("select ".$api_fields["fn_pid"]." from `".$mb_board_table_name."` ORDER BY ".$api_fields["fn_pid"]." DESC limit 1"))+1;
	mbw_set_param("board_pid",$board_pid);

	$item_data				= $mdb->get_row("select * from `".$mb_board_table_name."` where ".$api_fields["fn_pid"]."='".$board_gid."'",ARRAY_A);
	if(isset($api_fields["fn_parent_user_pid"]))		$send_data[$api_fields["fn_parent_user_pid"]]	= $item_data[$api_fields["fn_user_pid"]];
	if(isset($api_fields["fn_parent_pid"]))		$send_data[$api_fields["fn_parent_pid"]]				= $item_data[$api_fields["fn_parent_pid"]];
	if(isset($api_fields["fn_category1"]) && empty($send_data[$api_fields["fn_category1"]]))		$send_data[$api_fields["fn_category1"]]				= $item_data[$api_fields["fn_category1"]];
	if(isset($api_fields["fn_category2"]) && empty($send_data[$api_fields["fn_category2"]]))		$send_data[$api_fields["fn_category2"]]				= $item_data[$api_fields["fn_category2"]];
	if(isset($api_fields["fn_category3"]) && empty($send_data[$api_fields["fn_category3"]]))		$send_data[$api_fields["fn_category3"]]				= $item_data[$api_fields["fn_category3"]];


	if(isset($api_fields["fn_pid"]))		$send_data[$api_fields["fn_pid"]]							= $board_pid;
	if(isset($api_fields["fn_gid"]))		$send_data[$api_fields["fn_gid"]]							= $board_gid;
	if(isset($api_fields["fn_reply"]))		$send_data[$api_fields["fn_reply"]]						= $board_reply+1;
	if(isset($api_fields["fn_reply_depth"]))	$send_data[$api_fields["fn_reply_depth"]]			= intval(mbw_get_param("reply_depth"))+1;
	

	$mdb->query("update ".$mb_board_table_name." set ".$api_fields["fn_reply"]."=".$api_fields["fn_reply"]."+1 where ".$api_fields["fn_gid"]."='".$board_gid."' and ".$api_fields["fn_reply"].">".$board_reply);

}else if(mbw_get_param("board_action")=="delete"){
	$query_command														= "DELETE";
	$where_data[$api_fields["fn_pid"]]					= mbw_get_param("board_pid");

	//게시물 삭제시 댓글도 삭제
	if(mbw_get_board_option("fn_use_comment") == 1 && $mstore->table_exists($mb_comment_table_name)){
		$query_data[]		= $mdb->prepare( "DELETE FROM ".$mb_comment_table_name." WHERE ".$mb_fields["select_comment"]["fn_parent_pid"]."=%d", mbw_get_param("board_pid") );
	}

	//게시물 삭제시 파일 연결 해제
	$query_data[]		= $mdb->prepare( "UPDATE ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=0 where ".$mb_fields["files"]["fn_table_name"]."=%s and ".$mb_fields["files"]["fn_board_pid"]."=%d", $mb_board_table_name, mbw_get_param("board_pid") );
	$query_data[]		= $mdb->prepare( "UPDATE ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=0 where ".$mb_fields["files"]["fn_table_name"]."=%s and ".$mb_fields["files"]["fn_board_pid"]."=%d", $mb_comment_table_name, mbw_get_param("board_pid") );
}else if((intval(mbw_get_board_option("fn_delete_level")) <= intval(mbw_get_user("fn_user_level"))) && mbw_get_param("board_action")=="multi_delete"){
	if(mbw_get_param("check_array")!=""){
		$query_command					= "";

		$pid_array					= mbw_get_param("check_array");	
		$pid_format			= array();
		foreach($pid_array as $key){
			$pid_format[]		= "%d";
		}
		$query_data[]		= $mdb->prepare( "DELETE FROM ".$mb_board_table_name." WHERE `".$api_fields["fn_pid"]."` in (".implode(",",$pid_format).")", $pid_array );
		
		//게시물 삭제시 댓글도 삭제
		if(mbw_get_board_option("fn_use_comment") == 1 && $mstore->table_exists($mb_comment_table_name)) 
			$query_data[]		= $mdb->prepare( "DELETE FROM ".$mb_comment_table_name." WHERE `".$mb_fields["select_comment"]["fn_parent_pid"]."` in (".implode(",",$pid_format).")", $pid_array );

		//게시물 삭제시 파일 연결 해제
		$query_data[]		= $mdb->prepare("UPDATE ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=0 where ".$mb_fields["files"]["fn_table_name"]."='".$mb_board_table_name."' and ".$mb_fields["files"]["fn_board_pid"]." in (".implode(",",$pid_format).")", $pid_array );
		$query_data[]		= $mdb->prepare("UPDATE ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=0 where ".$mb_fields["files"]["fn_table_name"]."='".$mb_comment_table_name."' and ".$mb_fields["files"]["fn_board_pid"]." in (".implode(",",$pid_format).")", $pid_array );
	}	

}else if((intval(mbw_get_board_option("fn_manage_level")) <= intval(mbw_get_user("fn_user_level"))) && (mbw_get_param("board_action")=="multi_move" || mbw_get_param("board_action")=="multi_copy")){
		
	if(mbw_get_param("check_array")!=""){
		$query_command					= "";

		$pid_array				= mbw_get_param("check_array");	
		$pid_format			= array();
		foreach($pid_array as $key){
			$pid_format[]		= "%d";
		}

		$select_board_name						= mbw_get_param("select_board_name");
		$select_board_table_name				= mbw_get_table_name($select_board_name);

		$select_comment_table_name		= mbw_get_table_name($select_board_name,"comment");
		
		$match_board				= array();
		$match_comment		= array();
		$match_file					= array();
		$board_pid					= intval($mdb->get_var("select ".$api_fields["fn_pid"]." from `".$select_board_table_name."` ORDER BY ".$api_fields["fn_pid"]." DESC limit 1"))+1;
		$select_query				= $mdb->prepare( "SELECT * FROM ".$mb_board_table_name." WHERE `".$api_fields["fn_pid"]."` in (".implode(",",$pid_format).") order by ".$api_fields["fn_pid"]." asc", $pid_array );
		$board_items				= $mdb->get_results($select_query,ARRAY_A);
		//선택된 게시물 복사
		foreach($board_items as $item){

			if(empty($match_board[$item[$api_fields["fn_pid"]]])) 
				$match_board	[$item[$api_fields["fn_pid"]]]			= $board_pid;

			$item[$api_fields["fn_pid"]]							= $board_pid;
			if(!empty($match_board[$item[$api_fields["fn_gid"]]])) 
				$item[$api_fields["fn_gid"]]							= $match_board[$item[$api_fields["fn_gid"]]];
			else
				$item[$api_fields["fn_gid"]]							= $board_pid;

			$query_keys			= " (".implode(",",array_keys($item)).")";
			$query_values			= " ('".implode("','",$item)."')";

			$query					= "INSERT INTO ".$select_board_table_name.$query_keys." VALUES ".$query_values;
			$query_data[]			= $query;
			$board_pid++;
		}

		if(mbw_get_board_option("fn_use_comment") == 1 && $mstore->table_exists($mb_comment_table_name)){
			$comment_field		= $mb_fields["comment"];
			$comment_pid		= intval($mdb->get_var("select ".$comment_field["fn_pid"]." from `".$select_comment_table_name."` ORDER BY ".$comment_field["fn_pid"]." DESC limit 1"))+1;
			$select_query			= $mdb->prepare( "SELECT * FROM ".$mb_comment_table_name." WHERE `".$comment_field["fn_parent_pid"]."` in (".implode(",",$pid_format).") order by ".$comment_field["fn_pid"]." asc", $pid_array );
			$comment_items		= $mdb->get_results($select_query,ARRAY_A);

			//선택된 게시물의 댓글  복사
			foreach($comment_items as $item){
				if(!empty($match_board[$item[$comment_field["fn_parent_pid"]]])) 
					$item[$comment_field["fn_parent_pid"]]							= $match_board[$item[$comment_field["fn_parent_pid"]]];

				if(empty($match_comment[$item[$comment_field["fn_pid"]]])) 
					$match_comment[$item[$comment_field["fn_pid"]]]			= $comment_pid;

				$item[$comment_field["fn_pid"]]							= $comment_pid;
				if(!empty($match_comment[$item[$comment_field["fn_gid"]]])) 
					$item[$comment_field["fn_gid"]]							= $match_comment[$item[$comment_field["fn_gid"]]];
				else
					$item[$comment_field["fn_gid"]]							= $comment_pid;

				$query_keys			= " (".implode(",",array_keys($item)).")";
				$query_values			= " ('".implode("','",$item)."')";

				$query					= "INSERT INTO ".$select_comment_table_name.$query_keys." VALUES ".$query_values;
				$query_data[]			= $query;
				$comment_pid++;
			}
		}

		//선택된 게시물의 파일 복사
		if(true){
			$file_field		= $mb_fields["files"];
			if(mbw_get_param("board_action")=="multi_copy"){
				$mdb->query($mdb->prepare( "UPDATE ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_link_count"]."=".$mb_fields["files"]["fn_link_count"]."+1 WHERE `".$file_field["fn_board_pid"]."` in (".implode(",",$pid_format).") and ".$file_field["fn_table_name"]."='".$mb_board_table_name."' order by ".$file_field["fn_pid"]." asc", $pid_array));
			}
			$file_pid			= intval($mdb->get_var("select ".$file_field["fn_pid"]." from `".$mb_admin_tables["files"]."` ORDER BY ".$file_field["fn_pid"]." DESC limit 1"))+1;
			$select_query	= $mdb->prepare( "SELECT * FROM ".$mb_admin_tables["files"]." WHERE `".$file_field["fn_board_pid"]."` in (".implode(",",$pid_format).") and ".$file_field["fn_table_name"]."='".$mb_board_table_name."' order by ".$file_field["fn_pid"]." asc", $pid_array);
			$file_items		= $mdb->get_results($select_query,ARRAY_A);

			foreach($file_items as $item){
				if(!empty($match_board[$item[$file_field["fn_board_pid"]]])) 
					$item[$file_field["fn_board_pid"]]							= $match_board[$item[$file_field["fn_board_pid"]]];

				$item[$file_field["fn_pid"]]						= $file_pid;
				$item[$file_field["fn_board_name"]]			= $select_board_name;
				$item[$file_field["fn_table_name"]]			= $select_board_table_name;
				$item[$file_field["fn_link_count"]]			= 1;

				$query_keys			= " (".implode(",",array_keys($item)).")";
				$query_values			= " ('".implode("','",$item)."')";

				$query_data[]			= "INSERT INTO ".$mb_admin_tables["files"].$query_keys." VALUES ".$query_values;
				$file_pid++;
			}
		}

		//이동일 경우 선택된 게시물 삭제
		if(mbw_get_param("board_action")=="multi_move"){
			$query_data[]		= $mdb->prepare( "DELETE FROM ".$mb_board_table_name." WHERE `".$api_fields["fn_pid"]."` in (".implode(",",$pid_format).")", $pid_array );			

			//게시물 삭제시 댓글도 삭제
			if(mbw_get_board_option("fn_use_comment") == 1 && $mstore->table_exists($mb_comment_table_name)) 
				$query_data[]		= $mdb->prepare( "DELETE FROM ".$mb_comment_table_name." WHERE `".$mb_fields["select_comment"]["fn_parent_pid"]."` in (".implode(",",$pid_format).")", $pid_array );

			//게시물 삭제시 파일 연결 해제
			$query_data[]		= $mdb->prepare("UPDATE ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=0 where ".$mb_fields["files"]["fn_table_name"]."='".$mb_board_table_name."' and ".$mb_fields["files"]["fn_board_pid"]." in (".implode(",",$pid_format).")", $pid_array );
		}
	}
}else if(mbw_get_param("mode")=="write" && mbw_get_param("board_action")=="write"){
	$query_command												= "INSERT";
	$board_pid		= intval($mdb->get_var("select ".$api_fields["fn_pid"]." from `".$mb_board_table_name."` ORDER BY ".$api_fields["fn_pid"]." DESC limit 1"))+1;
	mbw_set_param("board_pid",$board_pid);

	if(isset($api_fields["fn_pid"]))		$send_data[$api_fields["fn_pid"]]							= $board_pid;
	if(isset($api_fields["fn_gid"])){
		if(isset($api_fields["fn_is_notice"]) && isset($send_data[$api_fields["fn_is_notice"]]) && $send_data[$api_fields["fn_is_notice"]]=="1"){
			//공지사항 설정일 경우 gid 숫자를 올려 정렬에서 상단에 위치시킴
			$send_data[$api_fields["fn_gid"]]							= $board_pid+1000000;
		}else{
			$send_data[$api_fields["fn_gid"]]							= $board_pid;
		}		
	}
	$mstore->set_result_data(array("data"=>array("pid"=>$board_pid)));
}else if(mbw_get_param("board_action")=="file_download"){	
	$file_pid		= intval(mbw_get_param("file_pid"));
	$file_name	= mbw_get_param("file_name");
	if(!empty($file_pid) && !empty($file_name)){
		$file_data			= $mdb->get_row($mdb->prepare("select ".$mb_fields["files"]["fn_file_path"]." from `".$mb_admin_tables["files"]."` where ".$mb_fields["files"]["fn_pid"]."=%d and ".$mb_fields["files"]["fn_file_name"]."=%s limit 1", $file_pid, $file_name),ARRAY_A);
		if(!empty($file_data)){
			$mdb->query($mdb->prepare("update ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_download_count"]."=".$mb_fields["files"]["fn_download_count"]."+1 where ".$mb_fields["files"]["fn_pid"]."=%d", $file_pid));
			$file_data["file_path"]		= urlencode(base64_encode($file_data["file_path"]));
			$mstore->set_result_data(array("data"=>$file_data));
		}	
	}
}else if(mbw_get_param("board_action")=="board_hit"){
	//조회수 체크
	if(isset($api_fields["fn_hit"])){		
		$cookie_check		= mbw_check_cookie(array("type"=>"mb_board_hit","save"=>"file","name"=>"board_pid","value"=>mbw_get_param("board_pid")));
		if($cookie_check=="success"){
			$query_data[]		= $mdb->prepare( "UPDATE ".$mb_board_table_name." set ".$api_fields["fn_hit"]."=".$api_fields["fn_hit"]."+1 WHERE ".$api_fields["fn_pid"]."=%d", mbw_get_param("board_pid") );			
		}
	}
}else if(mbw_get_param("board_action")=="vote_good"){
	if(isset($api_fields["fn_vote_good_count"])){		
		$cookie_check		= mbw_check_cookie(array("type"=>"mb_board_vote","save"=>"db","name"=>"board_pid","value"=>$board_pid));
		if($cookie_check=="success"){
			$query_data[]		= $mdb->prepare( "update ".$mb_board_table_name." set ".$api_fields["fn_vote_good_count"]."=".$api_fields["fn_vote_good_count"]."+1 where ".$api_fields["fn_pid"]."=%d",$board_pid);
			$vote_count		= intval($mdb->get_var($mdb->prepare( "select ".$api_fields["fn_vote_good_count"]." from `".$mb_board_table_name."` where ".$api_fields["fn_pid"]."=%d limit 1",$board_pid)))+1;
			$mstore->set_result_data(array("count"=>$vote_count));
			do_action( 'mbw_board_vote_good');
		}else if($cookie_check=="exist"){
			mbw_error_message("MSG_VOTE_PARTICIPATE_ERROR","","1000");
		}else if($cookie_check=="login"){
			mbw_error_message("MSG_REQUIRE_LOGIN","","1101");
		}
	}
}else if(mbw_get_param("board_action")=="vote_bad"){
	if(isset($api_fields["fn_vote_bad_count"])){
		$cookie_check		= mbw_check_cookie(array("type"=>"mb_board_vote","save"=>"db","name"=>"board_pid","value"=>$board_pid));
		if($cookie_check=="success"){
			$query_data[]		= $mdb->prepare( "update ".$mb_board_table_name." set ".$api_fields["fn_vote_bad_count"]."=".$api_fields["fn_vote_bad_count"]."+1 where ".$api_fields["fn_pid"]."=%d",$board_pid);
			$vote_count		= intval($mdb->get_var($mdb->prepare( "select ".$api_fields["fn_vote_bad_count"]." from `".$mb_board_table_name."` where ".$api_fields["fn_pid"]."=%d limit 1",$board_pid)))+1;
			$mstore->set_result_data(array("count"=>$vote_count));
			do_action( 'mbw_board_vote_bad');
		}else if($cookie_check=="exist"){
			mbw_error_message("MSG_VOTE_PARTICIPATE_ERROR","","1000");
		}else if($cookie_check=="login"){
			mbw_error_message("MSG_REQUIRE_LOGIN","","1101");
		}
	}
}

do_action('mbw_board_api_body');

if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}

//회원 포인트 지급
mbw_set_user_point("board",mbw_get_param("board_action"));

if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}

if(!empty($query_command)){

	if(has_filter('mf_board_send_data')) $send_data		= apply_filters("mf_board_send_data",$send_data);
	$mdb->db_query($query_command,$mb_board_table_name, $send_data, $where_data);
	
	if(mbw_get_param("mode")=="write"){
		
		//게시판에서 업로드된 파일 등록
		if($upload_check) { 
			mbw_file_upload(array("board_name"=>mbw_get_param("board_name"),"table_name"=>$mb_board_table_name,"board_pid"=>$board_pid,"type"=>"board"));
			$file_check		= true;
		}

		//에디터에서 업로드된 파일 등록
		if(isset($api_fields["fn_content"]) && isset($send_data[$api_fields["fn_content"]])){
			mbw_file_check($send_data[$api_fields["fn_content"]],$board_pid, $query_command);
		}
		if(mbw_get_param("content2")!=""){
			mbw_file_check(mbw_get_param("content2"),$board_pid, $query_command);
		}

		if(mbw_get_param("board_action")=="modify"){
			//체크박스가 선택된 파일 항목만 삭제
			if(mbw_get_param("file_delete_pid")!=""){
				$file_check				= true;
				$pid_data				= mbw_get_param("file_delete_pid");
				$pid_format			= array();
				foreach($pid_data as $key){
					$pid_format[]		= "%d";
				}
				$mdb->query($mdb->prepare("update ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=0 where ".$mb_fields["files"]["fn_table_name"]."='".$mb_board_table_name."' and ".$mb_fields["files"]["fn_pid"]." in (".implode(",",$pid_format).")", $pid_data));
			}

			//순서가 있는 파일 리스트를 사용할 경우 순서 확인
			if(mbw_get_param("file_list_sequence")!=""){
				$seq_data				= mbw_get_param("file_list_sequence");
				$pid_data				= mbw_get_param("file_list_pid");
				$count					= count($seq_data);

				for($i=0;$i<$count;$i++){
					$mdb->query($mdb->prepare( "update ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_file_sequence"]."=".$seq_data[$i]." where ".$mb_fields["files"]["fn_table_name"]."=%s and ".$mb_fields["files"]["fn_pid"]."=%d", $mb_board_table_name, $pid_data[$i] ));
				}
			}
		}else if(mbw_get_param("board_action")=="reply"){
			if(mbw_is_login())	 $query_data[]		= $mdb->prepare( "UPDATE ".$mb_admin_tables["users"]." set ".$mb_fields["users"]["fn_reply_count"]."=".$mb_fields["users"]["fn_reply_count"]."+1 where ".$mb_fields["users"]["fn_pid"]."=%d", mbw_get_user("fn_pid") );
			mbw_analytics("today_reply");
		}else if(mbw_get_param("board_action")=="write"){
			if(mbw_is_login())	 $query_data[]		= $mdb->prepare( "UPDATE ".$mb_admin_tables["users"]." set ".$mb_fields["users"]["fn_write_count"]."=".$mb_fields["users"]["fn_write_count"]."+1 where ".$mb_fields["users"]["fn_pid"]."=%d", mbw_get_user("fn_pid") );
			if($mb_board_table_name!=$mb_admin_tables["users"]) mbw_analytics("today_write");
		}


		if(mbw_get_param("board_action")=="write" || mbw_get_param("board_action")=="reply" || mbw_get_param("board_action")=="modify"){

			if(mbw_get_board_option("fn_board_type")!="admin" && isset($api_fields["fn_file_count"]) && $file_check){			
				$file_count			= 0;
				$file_count			= intval($mdb->get_var($mdb->prepare("SELECT count(*) FROM ".$mb_admin_tables["files"]." WHERE ".$mb_fields["files"]["fn_board_pid"]."=%d and ".$mb_fields["files"]["fn_table_name"]."=%s and ".$mb_fields["files"]["fn_is_download"]."=1",$board_pid,$mb_board_table_name)));
				$query_data[]		= $mdb->prepare("UPDATE ".$mb_board_table_name." set ".$api_fields["fn_file_count"]."=%d where ".$api_fields["fn_pid"]."=%d", $file_count, $board_pid);
			}
			$check_image_path		= true;
			if(!empty($_FILES)){
				if(!empty($_FILES["image_path"])) $check_image_path		= false;
				foreach($_FILES as $key=>$file_data){
					if(!empty($api_fields["fn_".$key])){
						$file_name		= mbw_check_upload_filename($_FILES[$key]["name"]);
						$image_path	= $mdb->get_var($mdb->prepare("select ".$mb_fields["files"]["fn_file_path"]." from `".$mb_admin_tables["files"]."` where ".$mb_fields["files"]["fn_board_pid"]."=%d and ".$mb_fields["files"]["fn_table_name"]."=%s and ".$mb_fields["files"]["fn_file_name"]."=%s", $board_pid,$mb_board_table_name,$file_name)." order by ".$mb_fields["files"]["fn_file_sequence"]." desc limit 1", ARRAY_A);
						if(!empty($image_path)){
							mbw_set_param("image_path",$image_path);
							$query_data[]		= $mdb->prepare("UPDATE ".$mb_board_table_name." set ".$api_fields["fn_".$key]."=%s where ".$api_fields["fn_pid"]."=%d", $image_path, $board_pid);
						}
					}
				}
			}
			if($check_image_path && isset($api_fields["fn_image_path"])){				
				//대표 이미지 경로가 있을 경우
				if(!empty($send_data[$api_fields["fn_image_path"]])){
					//$file_pid		= intval($mdb->get_var($mdb->prepare("select ".$mb_fields["files"]["fn_pid"]." from `".$mb_admin_tables["files"]."` where ".$mb_fields["files"]["fn_file_path"]."=%s limit 1", $send_data[$api_fields["fn_image_path"]] ), ARRAY_A));
					//if(!empty($file_pid))
						//$mdb->query($mdb->prepare("update ".$mb_admin_tables["files"]." set ".$mb_fields["files"]["fn_board_pid"]."=%d, ".$mb_fields["files"]["fn_file_sequence"]."=0, ".$mb_fields["files"]["fn_table_name"]."=%s where ".$mb_fields["files"]["fn_pid"]."=%d", $board_pid, $mb_board_table_name,$file_pid));
				}else{
					$image_path	= $mdb->get_var($mdb->prepare("select ".$mb_fields["files"]["fn_file_path"]." from `".$mb_admin_tables["files"]."` where ".$mb_fields["files"]["fn_board_pid"]."=%d and ".$mb_fields["files"]["fn_table_name"]."=%s", $board_pid,$mb_board_table_name)." and ".$mb_fields["files"]["fn_file_type"]." like 'image%' order by ".$mb_fields["files"]["fn_is_download"]." desc,".$mb_fields["files"]["fn_file_sequence"]." asc limit 1", ARRAY_A);
					if(!empty($image_path)){
						mbw_set_param("image_path",$image_path);
						$query_data[]		= $mdb->prepare("UPDATE ".$mb_board_table_name." set ".$api_fields["fn_image_path"]."=%s where ".$api_fields["fn_pid"]."=%d", $image_path, $board_pid);
					}
				}
			}
		}
	}
}

if(!empty($query_data)){
	$count					= count($query_data);
	for($i=0;$i<$count;$i++){
		if(!empty($query_data[$i])) $mdb->query($query_data[$i]);		
	}
}

if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}

do_action('mbw_board_api_footer');
echo mbw_data_encode($mstore->get_result_datas(array("state"=>"success")));	
exit;
?>