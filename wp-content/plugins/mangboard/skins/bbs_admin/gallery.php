<?php
	//반응형 클래스
	$responsive_class		= "col-432";		//col-432, col-543, col-555, col-444, col-421, col-333
	//갤러리 모델 설정
	$gallery_model		= mbw_get_model("list_gallery");
	if(empty($gallery_model)) $gallery_model		= '{"field":"fn_image_path","name":"이미지","width":"100%","height":"90px","type":"img_ratio","class":"img","link":"view","td_class":"gallery-item-img","search":"false"},{"field":"fn_title","name":"제목","width":"","type":"title_checkbox","maxlength":"10","maxtext":"..","td_class":"gallery-title"},{"field":"fn_content","name":"내용","type":"search"},{"field":"fn_reg_date","name":"날짜","width":"115px","type":"gallery_date","td_class":"gallery-date"},{"field":"fn_user_name","name":"작성자","width":"115px","td_class":"gallery-name"}';
	$list_model			= mbw_json_decode($gallery_model);
	$list_data			= mbw_get_list_setup_data($list_model);

	$select_query		= mbw_get_add_query(array("column"=>"*"), "where", "order")." limit ".$list_data["page_start"].", ".$list_data["page_size"];
	$board_items		= mbw_get_board_items_query($select_query);

?>


<script type="text/javascript">
function selectTabMenu(obj,category,name){
	jQuery('.tab-menu-on').removeClass("tab-menu-on").addClass("tab-menu-off");
	jQuery(obj).removeClass("tab-menu-off").addClass("tab-menu-on");
	sendListTemplateData({"board_name":name,"category":category});
}


function sendSearchData(data){
	var search_url					= mb_urls["search"];
	var params						= jQuery('#'+mb_options["board_name"]+'_form_board_search').serialize();

	if(typeof(data)!=='undefined') params					= params+"&"+data;		
	if(params.indexOf('category1')!=-1 && search_url.indexOf('category1')!=-1) {
		search_url		= search_url.replace("category1","category_old");
	}
	search_url						= search_url+"&"+params;
	moveURL(search_url);
}


function showDeleteConfirm(){	
	var check_count	= jQuery("input[name='check_array[]']:checked").length;
	if(check_count > 0) {
		showConfirmPopup(check_count+"<?php echo __MM('MSG_MULTI_DELETE_CONFIRM')?>", {"board_action":"multi_delete"}, sendBoardListData);
	}else{
		showAlertPopup({"code":"1000","message":"<?php echo __MM('MSG_DELETE_SELECT_EMPTY')?>"});
	}
}


function showMoveConfirm(type){	
	var check_count	= jQuery("input[name='check_array[]']:checked").length;
	if(check_count > 0) {
		if(type=="multi_copy"){
			showConfirmPopup(check_count+"<?php echo __MM('MSG_MULTI_COPY_CONFIRM')?>", {"board_action":type}, sendBoardListData);
		}else if(type=="multi_move"){
			showConfirmPopup(check_count+"<?php echo __MM('MSG_MULTI_MOVE_CONFIRM')?>", {"board_action":type}, sendBoardListData);
		}		
	}else{
		if(type=="multi_copy"){
			showAlertPopup({"code":"1000","message":"<?php echo __MM('MSG_COPY_SELECT_EMPTY')?>"});
		}else if(type=="multi_move"){
			showAlertPopup({"code":"1000","message":"<?php echo __MM('MSG_MOVE_SELECT_EMPTY')?>"});
		}
	}
}

function sendBoardListData(args){	
	if(args.board_action=="multi_modify"){
		jQuery('#'+mb_options["board_name"]+'_form_board_list input[name=board_pid]').val(args.board_pid);
	}

	jQuery('#'+mb_options["board_name"]+'_form_board_list input[name=board_action]').val(args.board_action);
	sendFormDataRequest(jQuery('#'+mb_options["board_name"]+'_form_board_list'), mb_urls["board_api"], sendBoardListDataHandler);
}

function sendBoardListDataHandler(response, state)
{
	if(response.state == "success"){
		if(typeof(response.message)!=='undefined' && response.message!="") 
			alert(response.message);
		window.location.reload();
	}else{			
		showAlertPopup(response);
	}
}
</script>

<div class="mb-style1 gallery-list">
	<form name="<?php echo $mb_board_name;?>_form_board_search" id="<?php echo $mb_board_name;?>_form_board_search" method="post">
	<input type="hidden" name="board_name" value="<?php echo $mb_board_name?>" />
	<input type="hidden" name="page_id" value="<?php echo mbw_get_param("page_id")?>" />
	<input type="hidden" name="order_by" value="<?php echo mbw_get_param("order_by")?>" />
	<input type="hidden" name="order_type" value="<?php echo mbw_get_param("order_type")?>" />
	<?php do_action('mbw_board_skin_search'); ?>
	
	<div class="list-head">

		<?php
		echo '<div class="mb-category">';			
			echo mbw_get_category_template(mbw_get_board_option("fn_category_type"),mbw_get_board_option("fn_category_data"));
		echo '</div>';	
		?>

		<?php if(intval(mbw_get_board_option("fn_use_list_search"))==1){ ?>
		<div class="list-search">
			<select id="search_field" name="search_field" class="search-field  margin-right-5"><?php echo $list_data["search"];?></select><input id="search_text" class="search-text" type="text" name="search_text" accesskey="s" value="<?php echo mbw_htmlspecialchars(mbw_get_param("search_text"));?>" onkeypress="checkEnterKey(sendSearchData);"/><input style="display:none !important;" type="text"/><?php echo mbw_get_btn_template(array("name"=>"Search","onclick"=>"sendSearchData()","class"=>"btn btn-default btn-search margin-left-5")); ?>
		</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
	</form> 	
	<?php do_action('mbw_board_skin_header'); ?>
	<form name="<?php echo $mb_board_name;?>_form_board_list" id="<?php echo $mb_board_name;?>_form_board_list" method="post">	
	<input type="hidden" name="board_name" id="board_name" value="<?php echo $mb_board_name;?>" />
	<input type="hidden" name="page_id" id="page_id" value="<?php echo mbw_get_param("page_id")?>" />
	<input type="hidden" name="list_type" id="list_type" value="<?php echo mbw_get_param("list_type");?>" />
	<input type="hidden" name="page" id="page" value="<?php echo mbw_get_param("page")?>" />
	<input type="hidden" name="mode" id="mode" value="list" />
	<input type="hidden" name="board_action" id="board_action" value="" />
	<input type="hidden" name="board_pid" id="board_pid" value="" />
	<input type="hidden" name="responsive_class" id="responsive_class" value="<?php echo $responsive_class;?>" />

	<?php echo mbw_create_nonce("form"); ?>

	<div class="main-style1" id="<?php echo $mb_board_name;?>_board_box">		
		<?php
			echo '<div class="gallery-list-head"></div>';
			echo '<div class="gallery-list-body" id="'.$mb_board_name.'_board_body">';
			if($list_data["total_count"] > 0){
				$load_count		= count($board_items);
				if(!empty($board_items)){
					foreach($board_items as $item){
						mbw_set_board_item($item);
						$category_item_class		= mbw_get_category_item_class(mbw_get_board_item("fn_category1"));
						echo '<div class="gallery-item-box '.$category_item_class.' '.$responsive_class.'" style=""><div class="gallery-item-wrap">';
						foreach($list_model as $data){	
							if(mbw_check_item($data)){
								mbw_get_list_template($data,array("t_td"=>"div"));
							}
						}
						echo '</div></div>';					
					}
				}
			}else{
				echo '<div style="text-align:center;padding:20px !important;">'.__MM("MSG_LIST_ITEM_EMPTY")."</div>";
			}			

			echo '</div><div class="clear"></div>';
			echo '<div class="gallery-list-foot"></div>';
			
		?>			
	</div>
	<?php do_action('mbw_board_skin_form'); ?>
	<?php if(mbw_get_option("use_list_button")){ ?>
	<div class="list-btn">
		<div class="btn-box-right" id="<?php echo $mb_board_name;?>_btn_box">
			<?php				
				echo '<span class="btn-box-left" style="float:left;">';				
				echo mbw_get_left_button("list");
				echo '</span>';
				if(intval(mbw_get_board_option("fn_delete_level")) <= $mb_user_level)
					echo mbw_get_btn_template(array("name"=>"Delete","onclick"=>"showDeleteConfirm()","class"=>"btn btn-default btn-delete"));

				if(intval(mbw_get_board_option("fn_write_level"))==1 || intval(mbw_get_board_option("fn_write_level")) <= $mb_user_level)
					echo mbw_get_btn_template(array("name"=>"Write","type"=>"button","href"=>mbw_get_url(array("board_pid"=>"","mode"=>"write","board_action"=>"write")),"class"=>"btn btn-default btn-write"));

				echo mbw_get_right_button("list");
			?>
		</div>
	</div>
	<?php } ?>
	</form>
	<?php do_action('mbw_board_skin_footer'); ?>
	

	<?php
	if(mbw_get_option("use_list_pagination")){
		if($list_data["total_count"] > 0){
			echo '<div id="'.$mb_board_name.'_pagination_box" class="pagination-box">'.mbw_get_pagination_template(array("total_count"=>$list_data["total_count"])).'</div>';
			//AJAX 방식으로 URL 이동없이 페이지 전환하려면 아래 코드 사용
			//echo '<div id="'.$mb_board_name.'_pagination_box" class="pagination-box">'.mbw_get_pagination_template(array("total_count"=>$list_data["total_count"],"page_type"=>"ajax")).'</div>';
		}
	}
	?>
		
</div>