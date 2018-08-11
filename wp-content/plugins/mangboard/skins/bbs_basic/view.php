<?php
	$view_model				= mbw_json_decode(mbw_get_model("view"));	
	$select_query				= mbw_get_add_query(array("column"=>"*"), array(array("field"=>"fn_pid","value"=>mbw_get_param("board_pid"))));
	$board_item				= mbw_get_board_item_query($select_query);

	//게시물이 존재하는지 확인
	if(empty($board_item)){
		echo mbw_error_message("MSG_ITEM_NOT_EXIST");return;
	}

	//비밀글인지 확인
	if(intval(mbw_get_board_item("fn_is_secret"))==1){		
		$is_secret_page			= true;
		//비밀글의 답변글은 비밀글 작성자가 비밀번호 없이 볼 수 있도록 설정
		if(!mbw_is_secret(array(mbw_get_board_item("fn_user_pid"),mbw_get_board_item("fn_parent_user_pid")),mbw_get_board_item("fn_passwd"))){
			$is_secret_page			= false;		
		}else if(intval(mbw_get_board_item("fn_reply_depth"))>0){		//답변글일 경우 부모글의 비밀번호와 일치하는지 확인
			$parent_passwd		= $mdb->get_var("select ".$mb_fields["select_board"]["fn_passwd"]." from ".$mb_board_table_name." where ".$mb_fields["select_board"]["fn_pid"]."='".mbw_get_board_item("fn_gid")."' limit 1");			
			//답변글이고 부모글의 비밀번호와 일치할 경우 비밀글의 내용 보여줌
			if(mbw_get_param("secret_passwd")!="" && mbw_check_password(mbw_get_param("secret_passwd"),$parent_passwd)){
				$is_secret_page			= false;
			}
		}
		if($is_secret_page){
			require_once(MBW_SKIN_PATH."secret.php");return;
		}
	}

?>

<script type="text/javascript">

var view_action			= "";
function showBoardViewDeleteConfirm(data){
	showConfirmPopup("<?php echo __MM('MSG_DELETE_CONFIRM');if(!mbw_is_login()) echo '<br>'.__MM('MSG_PASSWD_INPUT');?>", data, sendBoardViewDeleteData);	
}
function sendBoardViewDeleteData(){	
	sendBoardViewData("delete");
}

function sendBoardViewData(action){
	view_action			= action;
	var data				= "mode=view&board_action="+action+"&board_name="+mb_options["board_name"]+"&board_pid="+mb_options["pid"];
	if(action=="delete") data		= data+"&passwd="+jQuery("#mb_confirm_passwd").val();
	else if(action.indexOf('modify')==0) data		= data+"&"+jQuery('#'+mb_options["board_name"]+'_form_board_view').serialize();
	sendDataRequest(mb_urls["board_api"], data, sendBoardViewDataHandler);
}

function sendBoardViewDataHandler(response, state)
{
	if(response && response.state == "success"){
		if(view_action=="delete"){
			moveURL(<?php echo "\"".mbw_get_url(array("board_pid"=>"","mode"=>"list"))."\""; ?>);
		}else if(view_action=="vote_good"){
			jQuery("#"+mb_options["board_name"]+"_vote_good").html("("+response.count+")");
		}else if(view_action=="vote_bad"){
			jQuery("#"+mb_options["board_name"]+"_vote_bad").html("("+response.count+")");
		}else if(view_action.indexOf('modify')==0){
			moveURL("reload");
		}
	}else{
		showAlertPopup(response);
	}
}
</script>

<div class="mb-style1 board-view">
<?php do_action('mbw_board_skin_header'); ?>
	<form name="<?php echo $mb_board_name;?>_form_board_view" id="<?php echo $mb_board_name;?>_form_board_view" method="post">	
	<?php echo mbw_create_nonce("form"); ?>
	<div class="main-style1" id="<?php echo $mb_board_name;?>_board_box">
	<?php
		foreach($view_model as $data){				
			if(mbw_check_item($data)) mbw_get_view_template($data);
		}
		$prev_next_data					= array();
		if(mbw_get_vars("device_type")!="mobile"){
			$prev_next_data["field"]			= "fn_title,fn_user_name,fn_reg_date";
			$prev_next_data["width"]		= "8%,*,18%,14%";
		}else{
			$prev_next_data["field"]			= "fn_title";
			$prev_next_data["width"]		= "16%,*";
		}		
		$prev_next_html					= mbw_get_prev_next_html($prev_next_data);

	?>
	</div>
	<?php do_action('mbw_board_skin_form'); ?>
	<?php if(mbw_get_option("use_view_button")){ ?>
	<div class="view-btn">
		<div class="btn-box-right" id="<?php echo $mb_board_name;?>_btn_box">
			<?php
				echo '<div class="btn-box-left" style="float:left;">';
				echo mbw_get_left_button("view");
				echo '</div>';

				if(mbw_get_board_option("fn_use_board_vote_good") == 1 && isset($mb_fields["select_board"]["fn_vote_good_count"]) ) 
					echo mbw_get_btn_template(array("name"=>"Vote_Good","add_name"=>"<span id='".$mb_board_name."_vote_good'>(".mbw_get_board_item("fn_vote_good_count").")</span>","onclick"=>"sendBoardViewData('vote_good')","class"=>"btn btn-default btn-vote-good"));
					
				if(mbw_get_board_option("fn_use_board_vote_bad") == 1 && isset($mb_fields["select_board"]["fn_vote_bad_count"]))
					echo mbw_get_btn_template(array("name"=>"Vote_Bad","add_name"=>"<span id='".$mb_board_name."_vote_bad'>(".mbw_get_board_item("fn_vote_bad_count").")</span>","onclick"=>"sendBoardViewData('vote_bad')","class"=>"btn btn-default btn-vote-bad"));

				if(intval(mbw_get_board_option("fn_list_level")) <= $mb_user_level){
					if(mbw_get_vars("pagination_type")=="more"){
						$page_size			= intval(mbw_get_board_option("fn_page_size")) * intval(mbw_get_param("board_page"));
						echo mbw_get_btn_template(array("name"=>"List","href"=>mbw_get_url(array("board_pid"=>"","mode"=>"list","page_size"=>$page_size)),"class"=>"btn btn-default btn-list"));
					}else{
						echo mbw_get_btn_template(array("name"=>"List","href"=>mbw_get_url(array("board_pid"=>"","mode"=>"list","page_size"=>"")),"class"=>"btn btn-default btn-list"));
					}					
				}

				if(mbw_is_user_pid() || intval(mbw_get_board_option("fn_modify_level")) <= $mb_user_level){
					//모바일에서 CK이외의 에디터로 작성된 글 수정 못하도록 설정
					//if(mbw_get_vars("device_type")!="mobile" || mbw_get_board_item("fn_editor_type")=="C")
						echo mbw_get_btn_template(array("name"=>"Modify","href"=>mbw_get_url(array("mode"=>"write","board_gid"=>"","board_action"=>"modify")),"class"=>"btn btn-default btn-modify"));
				}
				
				if(mbw_is_user_pid("guest"))
					echo mbw_get_btn_template(array("name"=>"Delete","onclick"=>"showBoardViewDeleteConfirm({'type':'passwd'})","class"=>"btn btn-default btn-delete"));
				else if(intval(mbw_get_board_option("fn_delete_level")) <= $mb_user_level || mbw_is_user_pid())
					echo mbw_get_btn_template(array("name"=>"Delete","onclick"=>"showBoardViewDeleteConfirm()","class"=>"btn btn-default btn-delete"));
				
				if(intval(mbw_get_board_option("fn_reply_level")) <= $mb_user_level && intval(mbw_get_board_item("fn_is_notice"))==0)
					echo mbw_get_btn_template(array("name"=>"Reply","href"=>mbw_get_url(array("mode"=>"write","board_gid"=>mbw_get_board_item("fn_gid"),"board_action"=>"reply")),"class"=>"btn btn-default btn-reply"));
				if(intval(mbw_get_board_option("fn_write_level")) <= $mb_user_level)
					echo mbw_get_btn_template(array("name"=>"Write","href"=>mbw_get_url(array("board_pid"=>"","mode"=>"write","board_action"=>"write")),"class"=>"btn btn-default btn-write"));

				echo mbw_get_right_button("view");
			?>	
		</div>
	</div>	
	<?php } ?>
	</form>
	<?php do_action('mbw_board_skin_footer'); ?>

	<?php
	if(mbw_get_option("use_view_comment")){
		if(mbw_get_board_option("fn_use_comment") == 1){
			require_once(MBW_SKIN_PATH."comment.php");
		}
	}

	if(mbw_get_option("use_view_prev_next")){
		echo $prev_next_html;
	}

	?>
</div>
<script type="text/javascript"> jQuery( document ).ready(function(){ sendBoardViewData('board_hit'); });</script>