<?php

	$board_action				= mbw_get_param("board_action");
	if(mbw_get_model("write_".$board_action)!="") $model_name				= "write_".$board_action;
	else $model_name				= "write";
	$write_model				= mbw_json_decode(mbw_get_model($model_name));

	if(mbw_get_param("board_action")=="modify" || mbw_get_param("board_action")=="reply" || mbw_get_param("board_action")=="copy"){
		$column		= "*";
		if(mbw_get_param("board_action") == "reply"){
			$column		= $mb_fields["select_board"]["fn_gid"].",".$mb_fields["select_board"]["fn_reply"].",".$mb_fields["select_board"]["fn_reply_depth"].",".$mb_fields["select_board"]["fn_title"].",".$mb_fields["select_board"]["fn_calendar_date"].",".$mb_fields["select_board"]["fn_category1"].",".$mb_fields["select_board"]["fn_category2"].",".$mb_fields["select_board"]["fn_category3"];
		}else if(mbw_get_param("board_action") == "copy"){
			mbw_set_param("board_action","write");
		}
		$select_query				= mbw_get_add_query(array("column"=>$column), array(array("field"=>"fn_pid","value"=>mbw_get_param("board_pid"))));
		$board_item				= mbw_get_board_item_query($select_query);

		if(mbw_get_param("board_action") == "modify" && mbw_get_board_option("fn_board_type")!="admin"){
			$editor_type		= mbw_get_board_item("fn_editor_type");
			if(!empty($editor_type) && $editor_type!=mbw_get_board_option("fn_editor_type")){
				mbw_set_board_option("fn_editor_type",$editor_type);
			}
		}		

		//게시물이 존재하는지 확인
		if(empty($board_item)){
			echo mbw_error_message("MSG_ITEM_NOT_EXIST");return;
		}
		//비밀글인지 확인(비밀글의 답변글은 비밀글 작성자가 비밀번호 없이 볼 수 있도록 설정)
		if(intval(mbw_get_board_item("fn_is_secret"))==1 && mbw_is_secret(array(mbw_get_board_item("fn_user_pid"),mbw_get_board_item("fn_parent_user_pid")),mbw_get_board_item("fn_passwd"))){
			require_once(MBW_SKIN_PATH."secret.php");return;
		//회원이 작성한 게시물을 본인이 아닌 다른 사람이 수정모드로 접근할 경우 차단
		}else if(($board_action=="modify" || $board_action=="copy") && intval(mbw_get_board_item("fn_user_pid"))!=0){
			if(!mbw_is_user_pid() && intval(mbw_get_board_option("fn_modify_level")) > $mb_user_level) return;
		}else if($board_action=="reply" &&  intval(mbw_get_board_option("fn_reply_level")) > $mb_user_level) return;

	}else{
		mbw_set_param("board_action","write");
	}
	if(mbw_get_param("board_action") == "reply") mbw_set_board_item("fn_title","[re]".mbw_get_board_item("fn_title"));

	if(mbw_is_login() && (mbw_get_param("board_action") == "write" || mbw_get_param("board_action") == "reply")) {
		if(!mbw_is_admin_page() || strpos(mbw_get_param("page"),'_users')===false){
			if(mbw_get_user("fn_user_email")!="") mbw_set_board_item("fn_email",mbw_get_user("fn_user_email"));
			if(mbw_get_user("fn_user_name")!="") mbw_set_board_item("fn_user_name",mbw_get_user("fn_user_name"));
		}
	}

	mbw_set_board_item("fn_passwd","");
?>
<script type="text/javascript">

function checkWriteData(){
	<?php		
		$editors				= mbw_get_editors();
		$script_html		= "";

		foreach($editors as $key => $value){
			if(!empty($script_html)) $script_html	= $script_html." else ";
			$script_html	= $script_html."if(jQuery('#editor_type').val()=='".$key."'){".$value["script"]."}";
		}
		echo $script_html;		
	?>	
}
function sendBoardWriteData(content){
	if(typeof(content)!=='undefined') 
		jQuery('#'+mb_options["board_name"]+'_form_board_write textarea[name=content]').val(content);	
	
	sendFormDataRequest(jQuery('#'+mb_options["board_name"]+'_form_board_write'), mb_urls["board_api"], sendBoardWriteDataHandler, sendBoardWriteDataErrorHandler);	
}
function sendBoardWriteDataHandler(response, state){
	if(response.state == "success"){
		if(response.board_action == "modify"){
			<?php echo 'moveURL("'.mbw_get_url(array("mode"=>"view")).'")'; ?>;
		}else{
			<?php
			if(mbw_get_option("write_next_page")=="write" || mbw_get_param("write_next_page")=="write"){		//글쓰기 폼 형태로 사용시 글작성 후 알림창 뛰우고 현재 페이지 Reload
				echo 'showAlertPopup({"message":"'.__MM('MSG_SEND_WRITE_SUCCESS').'"},function(){moveURL("reload");});';
			}else if(mbw_get_param("write_next_page")=="referer"){ //이전 페이지로 이동
				echo 'moveURL("referer");';
			}else if(mbw_get_option("write_next_url")!=""){
				echo 'moveURL("'.mbw_get_option("write_next_url").'");';			
			}else if(mbw_get_param("write_next_url")!=""){
				echo 'moveURL("'.mbw_validate_redirect(mbw_get_param("write_next_url")).'");';
			}else{		//글목록 페이지로 이동
				echo 'moveURL("'.mbw_get_url(array("board_pid"=>"","mode"=>"list","board_page"=>"1")).'");';
			}			
			?>
		}
	}else{
		showAlertPopup(response);
	}
}
function sendBoardWriteDataErrorHandler(e){
	//console.log(e);
}
 
</script>

<?php do_action('mbw_board_skin_header'); ?>
<form name="<?php echo $mb_board_name;?>_form_board_write" id="<?php echo $mb_board_name;?>_form_board_write" method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="return false;">
<?php echo mbw_create_nonce("form"); ?>
<input type="hidden" name="board_name" id="board_name" value="<?php echo $mb_board_name;?>" />
<input type="hidden" name="mode" id="mode" value="<?php echo mbw_get_param("mode");?>" />
<input type="hidden" name="upload_size" id="upload_size" value="<?php echo mbw_get_board_option("fn_upload_size");?>" />
<input type="hidden" name="search_field" id="search_field" value="<?php echo mbw_get_param("search_field");?>" />
<input type="hidden" name="search_text" id="search_text" value="<?php echo mbw_get_param("search_text");?>" />

<input type="hidden" name="board_page" id="board_page" value="<?php echo mbw_get_param("board_page");?>" />
<input type="hidden" name="board_action" id="board_action" value="<?php echo mbw_get_param("board_action");?>" />
<input type="hidden" name="editor_type" id="editor_type" value="<?php echo mbw_get_board_option("fn_editor_type");?>" />

<?php
if(mbw_get_param("board_action") == "modify"){
	$parent_pid				= mbw_get_board_item("fn_parent_pid");
	$parent_user_pid		= mbw_get_board_item("fn_parent_user_pid");
}else{
	$parent_pid				= mbw_get_param("parent_pid");
	$parent_user_pid		= mbw_get_param("parent_user_pid");
}

if($parent_pid=="") $parent_pid		= 0;
if($parent_user_pid=="") $parent_user_pid		= 0;
?>
<input type="hidden" name="parent_pid" id="parent_pid" value="<?php echo $parent_pid;?>" />
<input type="hidden" name="parent_user_pid" id="parent_user_pid" value="<?php echo $parent_user_pid;?>" />

<?php if(mbw_get_param("board_action") == "reply"){?>
	<input type="hidden" name="board_gid" id="board_gid" value="<?php echo mbw_get_board_item("fn_gid");?>" />
	<input type="hidden" name="board_reply" id="board_reply" value="<?php echo mbw_get_board_item("fn_reply");?>" />
	<input type="hidden" name="reply_depth" id="reply_depth" value="<?php echo mbw_get_board_item("fn_reply_depth");?>" />
	<input type="hidden" name="board_pid" id="board_pid" value="<?php echo mbw_get_param("board_pid");?>" />
<?php }

if(mbw_get_param("board_action") == "modify"){ ?>
	<input type="hidden" name="board_pid" id="board_pid" value="<?php echo mbw_get_param("board_pid");?>" />
<?php }else{
	if(mbw_get_param("board_action") == "reply") $calendar_date		= mbw_get_board_item("fn_calendar_date");
	else $calendar_date		= mbw_get_param("calendar_date");
?>
	<input type="hidden" name="calendar_date" id="calendar_date" value="<?php echo $calendar_date;?>" />
<?php }

if(mbw_is_login()) echo '<input type="password" autocomplete="off" style="display:none !important;">'; //로그인 상태에서 자동완성 기능 방지를 위해 추가 
?>

<div class="mb-style1">	
	<div class="main-style1" id="<?php echo $mb_board_name;?>_board_box">
		<div>
			<div class="pull-right">
				<?php if(intval(mbw_get_board_option("fn_use_secret")) == 1){?>			
					<label><input name="is_secret" type="checkbox" value="1" <?php if(mbw_is_login()) echo ' onclick="checkBoxDisplayID(this,\''.mbw_get_id_prefix().'tr_passwd\');"';  if((intval(mbw_get_board_item("fn_is_secret")) == 1) && (mbw_get_param("board_action") == "modify" || mbw_get_param("board_action") == "reply")) echo " checked";?> /><?php echo __MW("W_SECRET")?></label> 
				<?php }else if(intval(mbw_get_board_option("fn_use_secret")) == 2){
					$click_event		= ' onclick="return false;"';
					if(mbw_is_login() && mbw_get_param("board_action") == "modify") $click_event	= ' onclick="checkBoxDisplayID(this,\''.mbw_get_id_prefix().'tr_passwd\');"';  			
				?>			
					<label><input name="is_secret" type="checkbox" value="1"<?php echo $click_event; if(intval(mbw_get_board_item("fn_is_secret")) == 1 || mbw_get_param("board_action")!="modify") echo " checked";?>  /><?php echo __MW("W_SECRET")?></label> 
				<?php }
					if(intval(mbw_get_board_option("fn_use_notice")) == 1 && $mb_user_level>=mbw_get_option("admin_level")){
				?>
				<label><input name="is_notice" type="checkbox" value="1"<?php if(mbw_get_board_item("fn_is_notice") == 1) echo " checked";?> /><?php echo __MW("W_NOTICE")?></label>
				<?php }?>
			</div>
			<div class="clear"></div>
		</div>

		<?php
			foreach($write_model as $data){
				if(mbw_check_item($data)) mbw_get_write_template($data);
			}	
		?>
	</div>
	<?php do_action('mbw_board_skin_form'); ?>
	<?php if(mbw_get_option("use_write_button")){ ?>
	<div class="write-btn">
		<div class="btn-box-right" id="<?php echo $mb_board_name;?>_btn_box">
			<?php
				echo '<div class="btn-box-left" style="float:left;">';
				echo mbw_get_left_button("write");
				if(mbw_get_param("board_action")!="write"){
					echo mbw_get_btn_template(array("name"=>"Back","onclick"=>"moveURL('back')","class"=>"btn btn-default btn-back"));				
				}
				if(intval(mbw_get_board_option("fn_list_level")) <= $mb_user_level)
					echo mbw_get_btn_template(array("name"=>"List","href"=>mbw_get_url(array("board_pid"=>"","mode"=>"list")),"class"=>"btn btn-default btn-list"));
				echo '</div>';

				if(intval(mbw_get_board_option("fn_".mbw_get_param("board_action")."_level")) <= $mb_user_level || (mbw_get_param("board_action")=="modify" && mbw_is_user_pid())){
					echo mbw_get_btn_template(array("name"=>"Send_".ucfirst(mbw_get_param("board_action")),"onclick"=>"checkWriteData()","class"=>"btn btn-default btn-send-write"));
				}
				echo mbw_get_right_button("write");
				
			?>
		</div>
	</div>
	<?php } ?>
</div>

</form>
<?php do_action('mbw_board_skin_footer'); ?>



<script type="text/javascript">
<?php
if(mbw_get_param("board_action") != "modify" && intval(mbw_get_board_option("fn_use_secret")) == 2){
	echo 'checkBoxDisplayID(jQuery("input[name=\'is_secret\']"),"'.mbw_get_id_prefix().'tr_passwd");';
}

if(mbw_get_param("mode") == "write" && (mbw_get_param("board_action") == "modify" || mbw_get_param("board_action") == "reply")){
	echo 'mb_categorys["value1"]	= "'.mbw_get_board_item("fn_category1").'";';
	echo 'mb_categorys["value2"]	= "'.mbw_get_board_item("fn_category2").'";';
	echo 'mb_categorys["value3"]	= "'.mbw_get_board_item("fn_category3").'";';
}
?>
if(category_text!="" && isJsonType(category_text)) category_select(0);
</script>