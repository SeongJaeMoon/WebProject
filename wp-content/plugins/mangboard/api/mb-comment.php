<?php
define("MBW_REQUEST_MODE", "API");
if(!defined('_MB_')) exit();

do_action('mbw_comment_api_init');

if(!mbw_verify_nonce() && mbw_get_param("board_action")!="list"){
	mbw_error_message("MSG_NONCE_MATCH_ERROR", "","1401");
}

$query_command		= "";
$send_data					= array();
$where_data				= array();
$query_data				= array();
$parent_pid					= intval(mbw_get_param("parent_pid"));
$comment_pid			= intval(mbw_get_param("comment_pid"));
$comment_parent_pid	= 0;

$api_fields			= $mb_fields["select_comment"];
$send_data			= mbw_set_api_params($api_fields);
mbw_check_api_permission($api_fields,$send_data);
mbw_check_api_required($api_fields,$send_data);
do_action('mbw_comment_api_header');

if(mbw_get_param("board_action")=="write" || mbw_get_param("board_action")=="modify" || mbw_get_param("board_action")=="reply"){
	$upload_check		= mbw_check_api_file("board");
}

if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}

if(mbw_get_param("mode")=="comment"){
	if(mbw_get_param("board_action")=="reply"){
		$query_command												= "INSERT";	
		$comment_reply			= 0;

		$item_data							= $mdb->get_row("select ".$api_fields["fn_pid"].",".$api_fields["fn_user_pid"].",".$api_fields["fn_parent_pid"]." from `".$mb_comment_table_name."` where ".$api_fields["fn_pid"]."='".$comment_pid."'",ARRAY_A);
		$comment_parent_user_pid	= intval($item_data[$api_fields["fn_user_pid"]]);
		$comment_parent_pid			= intval($item_data[$api_fields["fn_parent_pid"]]);
			
		if(isset($api_fields["fn_gid"]))		$send_data[$api_fields["fn_gid"]]										= $comment_pid;
		if(isset($api_fields["fn_reply"]))		$send_data[$api_fields["fn_reply"]]								= $comment_reply+1;
		if(isset($api_fields["fn_parent_user_pid"]))		$send_data[$api_fields["fn_parent_user_pid"]]	= $comment_parent_user_pid;
		if(isset($api_fields["fn_parent_pid"]))		$send_data[$api_fields["fn_parent_pid"]]				= $comment_parent_pid;

		$comment_pid					= intval($mdb->get_var("select ".$api_fields["fn_pid"]." from `".$mb_comment_table_name."` ORDER BY ".$api_fields["fn_pid"]." DESC limit 1"))+1;		
		mbw_set_param("comment_pid",$comment_pid);
		if(isset($api_fields["fn_pid"]))		$send_data[$api_fields["fn_pid"]]							= $comment_pid;
		
		$mdb->query("update ".$mb_comment_table_name." set ".$api_fields["fn_reply"]."=".$api_fields["fn_reply"]."+1 where ".$api_fields["fn_gid"]."='".$comment_pid."' and ".$api_fields["fn_reply"].">".$comment_reply);

	}else if(mbw_get_param("board_action")=="write"){
		$query_command												= "INSERT";
		$comment_pid		= intval($mdb->get_var("select ".$api_fields["fn_pid"]." from `".$mb_comment_table_name."` ORDER BY ".$api_fields["fn_pid"]." DESC limit 1"))+1;
		$board_user_pid		= intval($mdb->get_var("select ".$api_fields["fn_user_pid"]." from `".$mb_board_table_name."` where ".$api_fields["fn_pid"]."='".$parent_pid."' limit 1"));
		mbw_set_param("comment_pid",$comment_pid);

		if(isset($api_fields["fn_pid"]))		$send_data[$api_fields["fn_pid"]]							= $comment_pid;
		if(isset($api_fields["fn_gid"]))		$send_data[$api_fields["fn_gid"]]							= $comment_pid;
		if(isset($api_fields["fn_parent_user_pid"]))		$send_data[$api_fields["fn_parent_user_pid"]]	= $board_user_pid;

	}else if(mbw_get_param("board_action")=="modify"){
		if(isset($api_fields["fn_is_secret"])){	
			if(empty($send_data[$api_fields["fn_is_secret"]])) $send_data[$api_fields["fn_is_secret"]]	= 0;
			else $send_data[$api_fields["fn_is_secret"]]	= 1;		
		}
		$query_command												= "UPDATE";
		if(isset($api_fields["fn_parent_pid"]) && empty($send_data[$api_fields["fn_parent_pid"]]))		unset($send_data[$api_fields["fn_parent_pid"]]);
		$where_data[$api_fields["fn_pid"]]			= $comment_pid;
	}else if(mbw_get_param("board_action")=="delete"){
		$query_command												= "DELETE";
		$where_data[$api_fields["fn_pid"]]					= $comment_pid;
	}else if(mbw_get_param("board_action")=="vote_good"){
		if(isset($api_fields["fn_vote_good_count"])){		
			$cookie_check		= mbw_check_cookie(array("type"=>"mb_comment_vote","save"=>"db","name"=>"comment_pid","value"=>$comment_pid));
			if($cookie_check=="success"){
				$query_data[]		= $mdb->prepare( "update ".$mb_comment_table_name." set ".$api_fields["fn_vote_good_count"]."=".$api_fields["fn_vote_good_count"]."+1 where ".$api_fields["fn_pid"]."=%d",$comment_pid);
			}else if($cookie_check=="exist"){
				mbw_error_message("MSG_VOTE_PARTICIPATE_ERROR");
			}else if($cookie_check=="login"){
				mbw_error_message("MSG_REQUIRE_LOGIN");
			}
		}
	}else if(mbw_get_param("board_action")=="vote_bad"){
		if(isset($api_fields["fn_vote_bad_count"])){
			$cookie_check		= mbw_check_cookie(array("type"=>"mb_comment_vote","save"=>"db","name"=>"comment_pid","value"=>$comment_pid));
			if($cookie_check=="success"){
				$query_data[]		= $mdb->prepare( "update ".$mb_comment_table_name." set ".$api_fields["fn_vote_bad_count"]."=".$api_fields["fn_vote_bad_count"]."+1 where ".$api_fields["fn_pid"]."=%d",$comment_pid);
			}else if($cookie_check=="exist"){
				mbw_error_message("MSG_VOTE_PARTICIPATE_ERROR");
			}else if($cookie_check=="login"){
				mbw_error_message("MSG_REQUIRE_LOGIN");
			}
		}
	}
}

if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}

//포인트 설정
mbw_set_user_point("comment",mbw_get_param("board_action"));

$mb_user_level						= mbw_get_user("fn_user_level");
$mb_user_pid							= mbw_get_user("fn_pid");

$comment_mode		= "view";
$where_query			= $mdb->prepare(" where ".$api_fields["fn_parent_pid"]."=%d", $parent_pid);
if($mb_user_level>=mbw_get_option("admin_level") && $parent_pid==0) {
	$comment_mode			= "list";
	$where_query				= "";
}
if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}
if(!empty($query_command)){
	if(has_filter('mf_comment_send_data')) $send_data		= apply_filters("mf_comment_send_data",$send_data);
	$mdb->db_query($query_command,$mb_comment_table_name, $send_data, $where_data);	

	if($upload_check) { 
		mbw_file_upload(array("board_name"=>mbw_get_param("board_name"),"table_name"=>$mb_comment_table_name,"board_pid"=>$parent_pid,"type"=>"board"));
		if(!empty($_FILES)){
			foreach($_FILES as $key=>$file_data){
				if(!empty($api_fields["fn_".$key])){
					$file_name		= mbw_check_upload_filename($_FILES[$key]["name"]);
					$image_path	= $mdb->get_var($mdb->prepare("select ".$mb_fields["files"]["fn_file_path"]." from `".$mb_admin_tables["files"]."` where ".$mb_fields["files"]["fn_board_pid"]."=%d and ".$mb_fields["files"]["fn_table_name"]."=%s and ".$mb_fields["files"]["fn_file_name"]."=%s", $parent_pid,$mb_comment_table_name,$file_name)." order by ".$mb_fields["files"]["fn_file_sequence"]." desc limit 1", ARRAY_A);
					if(!empty($image_path)){
						mbw_set_param("image_path",$image_path);
						$query_data[]		= $mdb->prepare("UPDATE ".$mb_comment_table_name." set ".$api_fields["fn_".$key]."=%s where ".$api_fields["fn_pid"]."=%d", $image_path, $comment_pid);
					}
				}
			}
		}
	}
}

$select_query		= mbw_get_add_query(array("column"=>"count(*)","table"=>$mb_comment_table_name));


$comment_total_count		= $mdb->get_var($select_query.$where_query);
$mstore->set_result_data(array("total_count"=>$comment_total_count));

do_action('mbw_comment_api_body');
if(!empty($query_command)){
	//댓글 전체 리스트를 불러올 경우 해당 글의 댓글 카운팅을 다시해서 저장
	if($comment_mode=="list"){
		$parent_pid						= intval($comment_parent_pid);
		$comment_total_count		= $mdb->get_var($mdb->prepare($select_query." where ".$api_fields["fn_parent_pid"]."=%d",$parent_pid));
	}
	$query_data[]	= $mdb->prepare("update ".$mb_board_table_name." set ".$mb_fields["select_board"]["fn_comment_count"]."=%d,".$mb_fields["select_board"]["fn_modify_date"]."=%s where ".$mb_fields["select_board"]["fn_pid"]."=%d",$comment_total_count,$mstore->get_current_time(),$parent_pid);

	if(mbw_get_param("board_action")=="write" || mbw_get_param("board_action")=="reply"){
		if(mbw_is_login())	 $query_data[]		= $mdb->prepare("UPDATE ".$mb_admin_tables["users"]." set ".$mb_fields["users"]["fn_comment_count"]."=".$mb_fields["users"]["fn_comment_count"]."+1 where ".$mb_fields["users"]["fn_pid"]."=%d",mbw_get_user("fn_pid"));
		mbw_analytics("today_comment");
	}	
}


if(!empty($query_data)){
	$count					= count($query_data);
	for($i=0;$i<$count;$i++){
		if(!empty($query_data[$i])) $mdb->query($query_data[$i]);
	}
}

if(mbw_get_param("comment_page")!=""){
	$comment_page		= intval(mbw_get_param("comment_page"));
}else{
	$comment_page		= "0";
}
if(mbw_get_param("comment_size")!=""){
	$comment_size		= intval(mbw_get_param("comment_size"));
}else{
	$comment_size		= intval(mbw_get_board_option("fn_comment_size"));
}

$select_query		= mbw_get_add_query(array("column"=>"*","table"=>$mb_comment_table_name));
mbw_set_comment_items_query($select_query.$where_query." order by ".$api_fields["fn_gid"]." desc, ".$api_fields["fn_reply"]." asc limit ".$comment_page.", ".$comment_size);


$comment_data						= array();
$comment_item						= array();
$comment_count						= 0;
$comment_items						= mbw_get_comment_items();
$comment_model					= mbw_json_decode(mbw_get_model("comment_list"));
if(!empty($comment_items)){
	foreach($comment_items as $item){
		mbw_set_comment_item($item);				
		
		foreach($api_fields as $key=>$value){
			$comment_item[$value]			= mbw_get_comment_item($key);
		}

		foreach($comment_model as $data){
			$data["value"]			= $comment_item[$mb_fields["select_comment"][$data["field"]]];
			if($data["value"]!="" && ($data["type"]=="" || $data["type"]=="static" || $data["type"]=="view" || $data["type"]=="select" || $data["type"]=="radio" || $data["type"]=="checkbox") && (!empty($data["label"]) || !empty($data["data"]))){
				if(empty($data["label"]) && !empty($data["data"])) $data["label"]		= $data["data"];
				if(empty($data["data"]) && !empty($data["label"])) $data["data"]		= $data["label"];
				if($data["type"]=="checkbox") $data["data"]		= "1";
				$t_data				= explode(",",$data["data"]);
				$t_label				= explode(",",$data["label"]);
				$count				= count($t_data);
				for($i=0;$i<$count;$i++){
					if($data["value"]==$t_data[$i]){
						if(isset($t_label[$i])) $comment_item[$mb_fields["select_comment"][$data["field"]]]		= $t_label[$i];
					}
				}
			}
		}
		$comment_item["passwd"]			= "";
		$comment_item["delete_type"]		= "";
		$comment_item["secret_type"]		= "";
		$comment_item["modify_type"]		= "";
		$comment_item["reply_type"]		= "";
		$is_secret									= false;	

		if(intval(mbw_get_comment_item("fn_is_secret"))==1 && mbw_is_secret(array(mbw_get_comment_item("fn_user_pid"),mbw_get_comment_item("fn_parent_user_pid")),mbw_get_comment_item("fn_passwd"))){
			$comment_item["content"]			= __MM("MSG_SECRET");
			$comment_item["secret_type"]		= "lock";
			$is_secret									= true;
		}else{
			$comment_item["content"]			= nl2br($comment_item["content"]);
		}	

		if(!$is_secret){
			if(intval(mbw_get_board_option("fn_comment_level"))<=$mb_user_level)
			{
				$comment_item["mode"]		= $comment_mode;

				if(mbw_get_comment_item("fn_user_pid")=="0" && empty($mb_user_pid)){
					$comment_item["delete_type"]		= "guest";
				}else if((intval(mbw_get_board_option("fn_delete_level"))<=$mb_user_level || mbw_get_comment_item("fn_user_pid")==$mb_user_pid)){	
					$comment_item["delete_type"]		= "user";
				}

				if(mbw_get_comment_item("fn_user_pid")=="0" && empty($mb_user_pid)){
					$comment_item["modify_type"]		= "guest";
				}else if((intval(mbw_get_board_option("fn_modify_level"))<=$mb_user_level || mbw_get_comment_item("fn_user_pid")==$mb_user_pid)){	
					$comment_item["modify_type"]		= "user";
				}

				if(empty($mb_user_pid))
					$comment_item["reply_type"]		= "guest";
				else
					$comment_item["reply_type"]		= "user";
			}
		}		
		$comment_data[]		= $comment_item;
		$comment_count++;
	}
}

if($mstore->get_result_data("state")=="error"){
	echo mbw_data_encode($mstore->result_data);	
	exit;
}
$mstore->set_result_data(array("data"=>$comment_data));
$mstore->set_result_data(array("count"=>$comment_count));

do_action('mbw_comment_api_footer');
echo mbw_data_encode($mstore->get_result_datas(array("state"=>"success")));	
exit;
?>