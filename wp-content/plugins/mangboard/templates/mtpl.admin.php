<?php
//템플릿 함수 등록(템플릿 타입의 접두사, 템플릿 함수명)
if(function_exists('mbw_add_template')) mbw_add_template("admin","mbw_get_admin_template");

if(!function_exists('mbw_get_admin_template')){
	function mbw_get_admin_template($mode, $data){
		global $mdb,$mstore,$mb_languages;
		$template_start		= '';
		$item_type			= $data["type"];

		if($item_type=='admin_board_name'){
			$use_data			= array();
			if(mbw_get_board_item("fn_use_comment")=="1") $use_data[]			= __MW("W_COMMENT");
			if(mbw_get_board_item("fn_use_notice")=="1") $use_data[]				= __MW("W_NOTICE");
			if(mbw_get_board_item("fn_use_secret")!="0") $use_data[]				= __MW("W_SECRET");
			if(mbw_get_board_item("fn_use_category")=="1") $use_data[]			= __MW("W_CATEGORY");

			if(mbw_get_board_item("fn_use_board_vote_good")=="1") $use_data[]		= __MW("W_BOARD_VOTE_GOOD");
			if(mbw_get_board_item("fn_use_board_vote_bad")=="1") $use_data[]			= __MW("W_BOARD_VOTE_BAD");
			if(mbw_get_board_item("fn_use_comment_vote_good")=="1") $use_data[]	= __MW("W_COMMENT_VOTE_GOOD");
			if(mbw_get_board_item("fn_use_comment_vote_bad")=="1") $use_data[]		= __MW("W_COMMENT_VOTE_BAD");

			$board_use			= implode(",",$use_data);
			$board_type		= mbw_get_board_item("fn_board_type");
			$board_rss			= "";

			if($board_type=="board" && intval(mbw_get_board_item("fn_list_level"))==0){
				$board_rss		.= '<a href="'.MBW_HOME_URL.'/?mb_trigger=rss&board_name='.mbw_get_board_item("fn_board_name2").'" target="_blank"> [RSS]</a>';
			}
			if(intval(mbw_get_board_item("fn_post_id"))!=0){
				$board_rss		.= ' <a href="'.get_permalink(mbw_get_board_item("fn_post_id")).'" target="_blank"> [PAGE]</a>';				
			}			

			if(!empty($board_use)) $board_use		='<span class="admin_board_use"> ('.$board_use.')</span>';
			$template_start		= '<div><strong style="font-size:15px;">'.mbw_get_btn_template(array("name"=>mbw_get_board_item("fn_board_name2"),"type"=>"a","title"=>mbw_get_board_item("fn_board_name2")." ".substr(mbw_get_board_item("fn_ip"),0,-2)."**","href"=>admin_url('admin.php')."?page=mbw_board_options&board_name=".$data["value"],"class"=>"")).'</strong>'.$board_use.$board_rss;
			if(mbw_get_board_item("fn_description")!="") $template_start	.= '<div>'.mbw_get_board_item("fn_description").'</div>';			
			$template_start		.= '</div>';			
	
			//게시판 타입에 맞게 ShortCode 표시
			if($board_type=="admin" || $data["value"]=="user_messages" || $data["value"]=="user_activity"){
				$template_start	.= '<div>[mb_board name="'.$data["value"].'" style=""]</div>';
			}else if($board_type=="board" || $board_type=="link"){
				$template_start	.= '<div>'.__MW("W_BOARD_DATA").': [mb_board name="'.$data["value"].'" style=""]</div>';
				$template_start	.= '<div>'.__MW("W_BOARD_GALLERY").': [mb_board name="'.$data["value"].'" list_type="gallery" style=""]</div>';
				$template_start	.= '<div>'.__MW("W_BOARD_CALENDAR").': [mb_board name="'.$data["value"].'" list_type="calendar" style=""]</div>';
				$template_start	.= '<div>'.__MW("W_BOARD_LATESET").': [mb_latest name="'.$data["value"].'" title="'.$data["value"].'" list_size="5" style=""] </div>';
			}else{
				if($board_type=="custom") $board_type		= "board";
				$template_start	.= '<div>[mb_'.$board_type.' name="'.$data["value"].'" style=""]</div>';
			}

		}else if(strpos($item_type,'admin_select')===0){
			$t_data				= array();
			$t_label				= array();
			$data["type"]		= "select";

			if($item_type=='admin_select_skin_list'){
				$skin_entry			= mbw_get_dir_entry("skins");
				sort($skin_entry);
				$data["data"]		= implode(",",$skin_entry);
				$data["label"]		= $data["data"];
			}else if($item_type=='admin_select_model_list'){
				$board_type		= mbw_get_board_item("fn_board_type");
				$dir_type			= array("admin","user","commerce");
				$dir_name			= "";
				$model_path		= "models";
				
				if(in_array($board_type, $dir_type)){
					$dir_name			= $board_type."/";
					$model_path		= $model_path."/".$board_type;
				}else{
					$t_data[]					= "";
					$t_label[]				= "skin-model";
				}
				$select_data		= mbw_get_file_entry($model_path);
				sort($select_data);
				
				foreach($select_data as $value){
					$t_data[]			= $dir_name.$value;
					$t_label[]		= $dir_name.$value;		
				}
				$data["data"]		= implode(",",$t_data);
				$data["label"]		= implode(",",$t_label);
		
			}else if($item_type=='admin_select_editor_list'){
				$select_data		= mbw_get_editors();
				foreach($select_data as $value){
					$t_data[]			= $value["type"];
					$t_label[]			= $value["name"];
				}
				$data["data"]		= implode(",",$t_data);
				$data["label"]		= implode(",",$t_label);
			}else if($item_type=='admin_select_board_list'){
				if(mbw_get_board_option("fn_board_type")=="board"){
					$board_list		= mbw_get_table_list("board");
					if(empty($board_list)) return "";
					sort($board_list);
					$data["data"]		= implode(",",$board_list);
					$data["label"]		= $data["data"];
				}else return "";
			}else if($item_type=='admin_select_table_list'){
				$table_list		= mbw_get_table_list();
				if(empty($table_list)) return "";
				sort($table_list);
				$data["data"]		= implode(",",$table_list);
				$data["label"]		= $data["data"];
			}else if($item_type=='admin_select_board_link'){
				$table_list		= mbw_get_table_list("board");
				if(empty($table_list)){
					$data["data"]		= ',custom';
					$data["label"]		= __MW("W_BOARD_LINK_NONE").','.__MW("W_BOARD_LINK_INPUT");
				}else{
					sort($table_list);
					$data["data"]		= implode(',',$table_list);
					$data["label"]		= $data["data"];

					$data["data"]		= ','.$data["data"].',custom';
					$data["label"]		= __MW("W_BOARD_LINK_NONE").','.$data["label"].','.__MW("W_BOARD_LINK_INPUT");
				}
			}
			$template_start	.= mbw_get_input_template("admin",$data);

		}else if($item_type=='admin_option_modify'){
			$template_start	.= mbw_get_btn_template(array("name"=>$data["name_btn"],"onclick"=>"sendBoardListData({'mode':'list','board_action':'multi_modify','category1':'".mbw_get_param("category1")."','board_pid':'".mbw_get_board_item("fn_pid")."'})","class"=>"btn btn-default"));
			$template_start	.= '<input type="hidden" name="pid_array[]" value="'.mbw_get_board_item("fn_pid").'" />';
		}else if($item_type=='admin_board_modify'){
			if(mbw_get_board_item("fn_use_comment")=="1") $template_start	.= mbw_get_btn_template(array("name"=>__MW("W_COMMENT"),"href"=>admin_url('admin.php')."?page=mbw_board_options&board_name=".mbw_get_board_item("fn_board_name2")."&mode=comment","class"=>"btn btn-default margin-bottom-5","style"=>"width:96%;"));
			$template_start	.= mbw_get_btn_template(array("name"=>"Copy","href"=>admin_url('admin.php')."?page=mbw_board_options&board_name=".mbw_get_param("board_name")."&category1=".mbw_get_param("category1")."&mode=write&board_action=write&board_pid=".mbw_get_board_item("fn_pid"),"class"=>"btn btn-default margin-bottom-5","style"=>"width:96%;"));
			$template_start	.= mbw_get_btn_template(array("name"=>$data["name_btn"],"href"=>admin_url('admin.php')."?page=mbw_board_options&board_name=".mbw_get_param("board_name")."&category1=".mbw_get_param("category1")."&mode=write&board_action=modify&board_pid=".mbw_get_board_item("fn_pid"),"class"=>"btn btn-default","style"=>"width:96%;"));
		}else if($item_type=='admin_user_modify'){
			$template_start	.= mbw_get_btn_template(array("name"=>$data["name_btn"],"href"=>admin_url('admin.php')."?page=mbw_users&board_name=".mbw_get_param("board_name")."&category1=".mbw_get_param("category1")."&mode=write&board_action=modify&board_pid=".mbw_get_board_item("fn_pid"),"class"=>"btn btn-default"));
		}else if($item_type=='admin_board_analytics'){
			$template_start					= '<span style="font-size:11px;">';
			$board_name					= mbw_get_board_item("fn_board_name2");
			if(mbw_get_board_item("fn_table_link")!="") $board_name		= mbw_get_board_item("fn_table_link");
			$board_table_name			= mbw_get_table_name($board_name);
			$comment_table_name		= mbw_get_table_name($board_name,"comment");

			$board_type		= mbw_get_board_item("fn_board_type");

			if(mbw_get_board_item("fn_table_link")==""){
				if($mstore->table_exists($board_table_name)){
					$board_count					= $mdb->get_var($mstore->get_add_query(array("column"=>"count(*)","table"=>$board_table_name)));	
					$template_start					= $template_start.__MW("W_BOARD_ITEM").': '.$board_count;
					if($board_type!="admin" && $board_type!="custom"){
						
						$today_board_count			= intval($mdb->get_var($mstore->get_add_query(array("column"=>"count(*)","table"=>$board_table_name),array(array("field"=>"fn_reg_date", "value"=>mbw_get_current_date(), "sign"=>">=")))));	
						$template_start					= $template_start.'('.$today_board_count.")";
					}
				}
				if(mbw_get_board_item("fn_use_comment")=="1" && $mstore->table_exists($comment_table_name) ){
					$comment_count			= $mdb->get_var($mstore->get_add_query(array("column"=>"count(*)","table"=>$comment_table_name)));	
					$template_start				= $template_start.'<br>'.__MW("W_COMMENT").': '.$comment_count;

					if($board_type!="admin" && $board_type!="custom"){
						$today_comment_count	= intval($mdb->get_var($mstore->get_add_query(array("column"=>"count(*)","table"=>$comment_table_name),array(array("field"=>"fn_reg_date", "value"=>mbw_get_current_date(), "sign"=>">=")))));	
						$template_start					= $template_start.'('.$today_comment_count.")";
					}
				}
			}
			$template_start	.= '</span>';
		
		}else if(strpos($item_type,'admin_user_name_pid')===0){		
			if(mbw_get_param("mode")=="write" && mbw_get_param("board_action")!="modify")
				$user_name		= mbw_get_user("fn_user_name");
			else{
				$user_name		= (mbw_get_board_item('fn_user_name',false));
				if(mbw_get_board_item('fn_user_pid')=="0") $user_name		= "Guest";			
			}

			$template_start	.= '<input name="user_name" value="'.($user_name).'" type="hidden" />';
			$template_start	.= '<p>'.$user_name.'<span> ['.mbw_get_board_item('fn_user_pid').']</span></p>';
			if($item_type=='admin_user_name_pid_date'){
				$date		= mbw_get_board_item("fn_reg_date");
				if(!empty($date)) $template_start	.= '<p style="font-size:11px;">('.$date.')</p>';
			}

		}else if($item_type=='admin_skin_model'){
			$template_start	.= '<p>'.$data["value"].'</p>';
			$model_name		= mbw_get_board_item("fn_model_name");
			if(!empty($model_name)) $template_start	.= '<p style="font-size:11px;">('.$model_name.')</p>';
		}else if($item_type=='admin_ip_agent'){
			$template_start	.= '<p>'.$data["value"].'</p>';
			$agent		= mbw_get_board_item("fn_agent");
			if(!empty($agent)) $template_start	.= '<p style="font-size:11px;">('.$agent.')</p>';
		}else if($item_type=='admin_action_type'){
			$template_start	.= '<p>'.$data["value"].'</p>';
			$type					= mbw_get_board_item("fn_type");
			if(!empty($type)) $template_start	.= '<p style="font-size:11px;">('.$type.')</p>';
		}else if($item_type=='admin_board_name_pid'){

			$is_admin_page			= mbw_is_admin_page();
			$pid							= mbw_get_board_item("fn_board_pid");
			$board_name				= $data["value"];
			$link_url						= "";

			if(!empty($board_name) && $board_name!="N"){
				global $mb_table_prefix,$mb_table_comment_suffix;
				$table_name		= str_replace($mb_table_prefix,"", mbw_get_board_item("fn_table_name"));
				if(strpos($table_name,$mb_table_comment_suffix)!==false && $board_name.$mb_table_comment_suffix==$table_name){
					$table_name		= $board_name;
				}
				$link_url				= admin_url('admin.php')."?page=mbw_board_options&board_name=".$table_name;
				if(!empty($pid)) $link_url	.= "&mode=view&board_pid=".$pid;

				$template_start	.= '<a href="'.$link_url.'">';
				$template_start	.= '<p>'.$data["value"].'</p>';			
				if(!empty($pid)) $template_start	.= '<p style="font-size:11px;">('.$pid.')</p>';
				$template_start	.= '</a>';
			}else{
				$template_start	.= $data["value"];
			}

		}else if($item_type=='admin_file_name_size'){			
			if(mbw_is_image_file($data["value"])){
				$file_url			= mbw_get_image_url("url",mbw_get_board_item("fn_file_path"));
			}else{
				$file_url			= mbw_get_image_url("path",base64_encode(mbw_get_board_item("fn_file_path")));
				$file_url			.= "&type=download&file_name=".$data["value"];
			}
			$template_start	.= '<p><a href="'.($file_url).'" target="_blank">'.$data["value"].'</a></p>';
			$file_size			= mbw_set_format(mbw_get_board_item("fn_file_size"),"file_size");
			if(!empty($file_size)) $template_start	.= '<p style="font-size:11px;">('.$file_size.')</p>';
		}else if($item_type=='admin_reg_date_last_login'){
			$template_start	.= '<p>'.mbw_get_board_item("fn_reg_date").'</p>';				
			$last_login					= mbw_get_board_item("fn_last_login");
			if(!empty($last_login)) $template_start	.= '<p style="font-size:11px;">('.$last_login.')</p>';
		
		}else if($item_type=='admin_board_level'){

			$level_data			= array();
			$style					= ' style="color:#FF0000;"';
			if(intval(mbw_get_board_item("fn_list_level"))>0) $style					= ' style="color:#FF0000;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_list_level"))<90) $level_data[]		= '<span'.$style.'>'.__MW("W_LIST").":".mbw_get_board_item("fn_list_level").'</span>';

			if(intval(mbw_get_board_item("fn_view_level"))>0) $style					= ' style="color:#FF0000;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_view_level"))<90) $level_data[]		= '<span'.$style.'>'.__MW("W_VIEW").":".mbw_get_board_item("fn_view_level").'</span>';

			if(intval(mbw_get_board_item("fn_comment_level"))>0) $style					= ' style="color:#FF0000;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_comment_level"))<90) $level_data[]		= '<span'.$style.'>'.__MW("W_COMMENT").":".mbw_get_board_item("fn_comment_level").'</span>';


			if(intval(mbw_get_board_item("fn_write_level"))>0) $style					= ' style="color:#FF0000;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_write_level"))<90) $level_data[]		= "<br>".'<span'.$style.'>'.__MW("W_WRITE").":".mbw_get_board_item("fn_write_level").'</span>';

			if(intval(mbw_get_board_item("fn_reply_level"))>0) $style					= ' style="color:#FF0000;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_reply_level"))<90) $level_data[]		= '<span'.$style.'>'.__MW("W_REPLY").":".mbw_get_board_item("fn_reply_level").'</span>';

			if(intval(mbw_get_board_item("fn_modify_level"))<8) $style					= ' style="color:#0000FF;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_modify_level"))<90) $level_data[]		= '<span'.$style.'>'.__MW("W_MODIFY").":".mbw_get_board_item("fn_modify_level").'</span>';

			if(intval(mbw_get_board_item("fn_secret_level"))<8) $style					= ' style="color:#0000FF;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_secret_level"))<90) $level_data[]		= "<br>".'<span'.$style.'>'.__MW("W_SECRET").":".mbw_get_board_item("fn_secret_level").'</span>';

			if(intval(mbw_get_board_item("fn_delete_level"))<8) $style					= ' style="color:#0000FF;"';
			else $style					= '';
			if(intval(mbw_get_board_item("fn_delete_level"))<90) $level_data[]		= '<span'.$style.'>'.__MW("W_DELETE").":".mbw_get_board_item("fn_delete_level").'</span>';

			$template_start	.= '<span style="font-size:11px;">'.implode(",",$level_data).'</span>';
		}
		return $template_start;
	}
}

?>