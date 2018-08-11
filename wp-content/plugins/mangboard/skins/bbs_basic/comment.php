<?php		
	
	if(mbw_get_param("board_pid")!="")
		$comment_total_count				= intval(mbw_get_board_item("fn_comment_count"));
	else
		$comment_total_count		= $mdb->get_var(mbw_get_add_query(array("column"=>"count(*)","table"=>$mb_comment_table_name)));

	$comment_size						= intval(mbw_get_board_option("fn_comment_size"));
?>
<script type="text/javascript">
	var comment_action				= "";
	var send_action					= "";
	var comment_index				= 0;
	var comment_pid					= 0;
	var comment_page				= 0;
	var comment_temp				= 0;
	var comment_load				= false;
	var comment_size				= <?php echo $comment_size?>;
	var comment_page_total		= <?php echo $comment_total_count?>;
	
	function sendCommentDeleteHandler(args){
		var passwd		= jQuery("#mb_confirm_passwd").val();

		var data			= "board_name="+mb_options["board_name"]+"&parent_pid="+mb_options["pid"]+"&mode=comment";
		data				= data+"&board_action="+args.board_action+"&comment_pid="+args.pid+"&passwd="+passwd+"&comment_size="+comment_page;
		sendDataRequest(mb_urls["comment_api"], data, sendCommentDataHandler);
		comment_page		= 0;
	}

	function sendCommentData(action, pid, idx){
		if(typeof(idx)==='undefined') idx = "";
		if(typeof(pid)==='undefined') pid = "";

		send_action							= action;
		var data = jQuery('#'+mb_options["board_name"]+'_form_comment_'+action).serialize();
		data				= data+"&board_name="+mb_options["board_name"]+"&parent_pid="+mb_options["pid"]+"&mode=comment";
		if(action=="write"){
			data			= data+"&board_action="+action+"&comment_pid="+pid;
		}else if(action=="reply"){
			data			= data+"&board_action="+action+"&comment_pid="+comment_pid+"&comment_size="+(comment_page+1);
		}else if(action=="modify"){
			data			= data+"&board_action="+action+"&comment_pid="+comment_pid+"&comment_size="+(comment_page);
		}else{
			data			= data+"&board_action="+action+"&comment_pid="+pid+"&comment_size="+comment_page;
		}
		if(mb_options["search_field"]!="" && mb_options["search_text"]!=""){
			data		= data+"&search_field="+mb_options["search_field"]+"&search_text="+mb_options["search_text"];
		}
		
		sendDataRequest(mb_urls["comment_api"], data, sendCommentDataHandler);
		comment_temp		= comment_page;
		comment_page		= 0;
	}
	
	function sendCommentList(mode){
		if(comment_page<comment_page_total){
			var data			= "board_name="+mb_options["board_name"]+"&parent_pid="+mb_options["pid"]+"&mode=comment";
			data				= data+"&board_action=list&comment_page="+comment_page;

			if(mb_options["search_field"]!="" && mb_options["search_text"]!=""){
			data		= data+"&search_field="+mb_options["search_field"]+"&search_text="+mb_options["search_text"];
			}			
			if(mode=="init"){
				sendDataRequest2(mb_urls["comment_api"], data, sendCommentDataHandler);
			}else{
				sendDataRequest(mb_urls["comment_api"], data, sendCommentDataHandler);
			}			
		}		
	}
	function modifyCommentForm(response, state){
		if(response.state == "success"){			
			jQuery("#mb_comment_reply"+comment_index).html(response.data);			
		}else{
			showAlertPopup(response);
		}
	}

	function showCommentForm(action, pid, idx){
		var addHtml		= "";
		
		if(action=="delete"){
			showConfirmPopup("<?php echo __MM('MSG_DELETE_CONFIRM');?>", {"board_action":action,"pid":pid}, sendCommentDeleteHandler);
		}else if(action=="delete_passwd"){
			showConfirmPopup("<?php echo __MM('MSG_DELETE_CONFIRM').'<br>'.__MM('MSG_PASSWD_INPUT');?>", {"type":"passwd","board_action":"delete","pid":pid}, sendCommentDeleteHandler);
		}else if(action=="modify"){

			if(comment_index==idx && comment_action==action){
				jQuery("#mb_comment_reply"+comment_index).html("");
				comment_index		= 0;
				comment_pid			= 0;
				comment_action		= "";
			}else{	
				if(comment_index!=0) jQuery("#mb_comment_reply"+comment_index).html("");
				comment_index		= idx;
				comment_pid			= pid;
				comment_action		= action;
				var param	= "mode=comment&board_action=modify&board_name="+mb_options["board_name"]+"&comment_pid="+pid;					
				sendDataRequest(mb_urls["template_api"], param, modifyCommentForm);
			}
			
		}else if(action=="reply"){
			
			addHtml= '<div class="cmt-input-box">';
			addHtml=addHtml+ '<div class="cmt-input-head">';
			addHtml=addHtml+ '<form name="<?php echo $mb_board_name;?>_form_comment_reply" id="<?php echo $mb_board_name;?>_form_comment_reply" method="post" action="" onsubmit="return false;">';

			<?php		
				$comment_reply_data				= mbw_json_decode(mbw_get_model("comment_reply"));
				foreach($comment_reply_data as $data){
					if(mbw_check_item($data)) echo "addHtml=addHtml+'".mbw_get_comment_template($data,null,false,"reply")."';";
				}
			?>
			addHtml=addHtml+ '</form>';
			addHtml= addHtml+'</div>';				
			addHtml= addHtml+'<div class="comment-btn"><div class="btn-box-right">';
			addHtml= addHtml+<?php echo "'".mbw_get_btn_template(array("name"=>"Send_Comment_Reply","onclick"=>"sendCommentData(\'reply\')","class"=>"btn btn-default btn-cmt btn-reply"))."'" ?>;
			addHtml= addHtml+'</div></div>';
			addHtml= addHtml+'</div>';

			if(comment_index==idx && comment_action==action){
				jQuery("#mb_comment_reply"+comment_index).html("");
				comment_index		= 0;
				comment_pid			= 0;
				comment_action		= "";
			}else{	
				if(comment_index!=0) jQuery("#mb_comment_reply"+comment_index).html("");
				comment_index		= idx;
				comment_pid			= pid;
				comment_action		= action;
				jQuery("#mb_comment_reply"+comment_index).html(addHtml);			
			}
		}		
	}

	function sendCommentDataHandler(response, state){
				
		if(response.state == "success"){
			comment_index		= 0;
			comment_pid			= 0;
			comment_action		= "";

			jQuery(".cmt-input-box input[type='text']").val("");
			jQuery(".cmt-input-box input[type='password']").val("");
			jQuery(".cmt-input-box textarea").val("");

			if(send_action	=="write"){			
				jQuery("#mb_comment_write_box").html(jQuery("#mb_comment_write_box").html());
			}
			
			if(comment_load) hidePopupBox();
			comment_load		= true;

			var comment_items		= "";
			var comment_item		= "";
			var select_index			= comment_page+1;

			var fn_pid						= <?php echo "'".$mb_fields["select_comment"]["fn_pid"]."'";?>;
			var fn_parent_pid				= <?php echo "'".$mb_fields["select_comment"]["fn_parent_pid"]."'";?>;
			var fn_reply						= <?php echo "'".$mb_fields["select_comment"]["fn_reply"]."'";?>;
			var fn_is_secret				= <?php echo "'".$mb_fields["select_comment"]["fn_is_secret"]."'";?>;
									
			jQuery.each(response.data, function(key,value){
								
				if(parseInt(value[fn_reply])>0){
					reply_class		= ' cmt-reply-item';
					reply_sign		= '<img class="list-i-secret" alt="secret" src="<?php echo MBW_SKIN_URL;?>images/icon_reply_head.gif" /> ';
				} else {
					reply_class		= '';
					reply_sign		= '';
				}
				if(value[fn_is_secret]=="1"){
					reply_sign		= reply_sign+'<img class="list-i-secret" alt="secret" src="<?php echo MBW_SKIN_URL;?>images/icon_secret.gif" /> ';
				}

				comment_item	= '';
				comment_item	= comment_item+'<li id="mb_cmt'+value[fn_pid]+'" class="cmt-list-item'+reply_class+'">';

				<?php
					$comment_list_data				= mbw_json_decode(mbw_get_model("comment_list"));
					foreach($comment_list_data as $data){
						if(mbw_check_item($data)) echo "comment_item	= comment_item+'".mbw_get_comment_template($data,array("t_td"=>"p"),false,"list")."';";
					}
				?>

				comment_item	= comment_item+'<div class="btn-box-right">';

				<?php 
					echo "if(value['secret_type']!='lock'){";

						if(mbw_get_board_option("fn_use_comment_vote_good") == 1) 
							echo "if(reply_class=='') comment_item	= comment_item+'".mbw_get_btn_template(array("name"=>"Vote_Good","add_name"=>"('+value['".$mb_fields["select_comment"]["fn_vote_good_count"]."']+')","onclick"=>"sendCommentData(\'vote_good\','+value[fn_pid]+','+select_index+')","class"=>"btn btn-default  btn-cmt btn-vote-good"))."';" ;
						
						if(mbw_get_board_option("fn_use_comment_vote_bad") == 1)
							echo "if(reply_class=='') comment_item	= comment_item+'".mbw_get_btn_template(array("name"=>"Vote_Bad","add_name"=>"('+value['".$mb_fields["select_comment"]["fn_vote_bad_count"]."']+')","onclick"=>"sendCommentData(\'vote_bad\','+value[fn_pid]+','+select_index+')","class"=>"btn btn-default btn-cmt btn-vote-bad"))."';" ;		

						echo "if(value['mode']=='list'){";
							echo "comment_item	= comment_item+'".mbw_get_btn_template(array("name"=>"View","onclick"=>"moveViewPage('+value[fn_parent_pid]+',\'".mbw_get_param("board_name")."\',\'".mbw_get_param("page")."\')","class"=>"btn btn-default btn-cmt btn-modify"))."'; " ;
						echo "}";

						echo "if(value['delete_type']=='user'){";
							echo "comment_item	= comment_item+'".mbw_get_btn_template(array("name"=>"Delete","onclick"=>"showCommentForm(\'delete\','+value[fn_pid]+','+select_index+')","class"=>"btn btn-default btn-cmt btn-delete"))."'; " ;
						echo "}else if(value['delete_type']=='guest'){";
							echo "comment_item	= comment_item+'".mbw_get_btn_template(array("name"=>"Delete","onclick"=>"showCommentForm(\'delete_passwd\','+value[fn_pid]+','+select_index+')","class"=>"btn btn-default btn-cmt btn-delete"))."'; " ;
						echo "}";

						echo "if(value['modify_type']=='user' || value['modify_type']=='guest' ){";
							echo "comment_item	= comment_item+'".mbw_get_btn_template(array("name"=>"Modify","onclick"=>"showCommentForm(\'modify\','+value[fn_pid]+','+select_index+')","class"=>"btn btn-default btn-cmt btn-modify"))."'; " ;
						echo "}";						

						echo "if(reply_class=='' && (value['reply_type']=='user' || value['reply_type']=='guest')){";
							echo "comment_item	= comment_item+'".mbw_get_btn_template(array("name"=>"Comment_Reply","onclick"=>"showCommentForm(\'reply\','+value[fn_pid]+','+select_index+')","class"=>"btn btn-default btn-cmt btn-reply"))."';" ;
						echo "}";
						

					echo "}";
						
				?>

				comment_item	= comment_item+'</div><div id="mb_comment_reply'+select_index+'" class="cmt-reply-box" />';
				comment_item	= comment_item+'</li>';
				select_index		= select_index+1;
				comment_items	= comment_items+comment_item;
			});
			
			if(comment_page==0)
				jQuery("#comment_list_box").html(comment_items);
			else
				jQuery("#comment_list_box").append(comment_items);			
			
			comment_page				= select_index-1;
			comment_page_total		= parseInt(response.total_count);

			if(comment_page_total==0){
				jQuery("#comment_list_box").hide();				
			}else{
				jQuery("#comment_list_box").show();
			}
			jQuery(".cmt-count-box").show();
			jQuery("#mb_comment_totalcount").html(comment_page_total);			

			if(comment_page>=comment_page_total) jQuery("#comment_add_list").hide();
			else jQuery("#comment_add_list").show();
		}else{
			comment_page		= comment_temp;
			showAlertPopup(response);
		}
	}
</script>

<div class="cmt-style1">
	<fieldset>
		<div style="width:100%;min-height:32px;">
			<p class='cmt-count-box bold' style="display:none;">
				<?php echo __MW("W_COMMENT")?><span class="cmt-count"> [<span class="cmt-count-num" id='mb_comment_totalcount'><?php echo $comment_total_count;?></span>]</span>
			</p>	
		</div>
		<?php if((intval(mbw_get_board_option("fn_comment_level"))==1 || intval(mbw_get_board_option("fn_comment_level")) <= $mb_user_level) && mbw_get_param("board_pid")!=""){ ?>
		<div id="mb_comment_write_box" class="cmt-input-box">
			<div class="cmt-input-head">
				<form name="<?php echo $mb_board_name;?>_form_comment_write" id="<?php echo $mb_board_name;?>_form_comment_write" method="post" action="" onsubmit="return false;">
					<?php
						$comment_write_data				= mbw_json_decode(mbw_get_model("comment_write"));
						foreach($comment_write_data as $data){
							if(mbw_check_item($data)) mbw_get_comment_template($data,null,true,"write");
						}
					?>
				</form>
			</div>
			<div class="comment-btn">
				<div class="btn-box-right">
					<?php
						echo mbw_get_btn_template(array("name"=>"Send_Comment_Write","onclick"=>"sendCommentData('write')","class"=>"btn btn-default"));
					?>	
				</div>
			</div>
		</div>
		
		<?php } ?>		
		<ul id='comment_list_box' class='cmt-list-box list-unstyled' style="display:none;"></ul>		
	</fieldset>	
</div>
<?php
	echo '<div id="comment_add_list" class="cmt-add-list" style="display:none;">'.mbw_get_btn_template(array("name"=>"More","onclick"=>"sendCommentList()","class"=>"btn btn-default btn-more"))."</div>";
	if($comment_total_count>0)
		echo '<script type="text/javascript"> jQuery( document ).ready(function(){ sendCommentList("init"); });</script>';
?>
