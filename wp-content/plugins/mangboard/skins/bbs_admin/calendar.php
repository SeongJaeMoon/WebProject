<?php
	$list_model			= mbw_json_decode(mbw_get_model("list_calendar"));
	$list_data			= mbw_get_list_setup_data($list_model);
?>

<script type="text/javascript">
var openTarget;
var openPid		= 0;

function setCalendar(date,category1){
	select_date		= "";
	if(typeof(date)!=='undefined') select_date		= date;
	if(typeof(category1)=='undefined') category1		= mb_categorys["value1"];

	var data		= jQuery('#'+mb_options["board_name"]+'_form_board_search').serialize();

	if(typeof(category1)!=='undefined' && category1!=""){
		mb_categorys["value1"]		= category1;
		data		= data+"&category1="+encodeURIComponent(category1);
	}
	data			= data+"&board_action=load&calendar_date="+select_date+"&list_type="+mb_options["list_type"];
	
	sendDataRequest(mb_urls["template_api"], data, sendCalendarDataHandler);			
}

function sendCalendarDataHandler(response, state){		
	if(response.state == "success"){
		var calendar_nav		= "";
		calendar_nav	= calendar_nav+'<div class="calendar-lnb">';
		calendar_nav	= calendar_nav+'<span class="lnb-prev-year"><a href="javascript:;" onclick="setCalendar(\''+response.data["prev_year"]+'\')"><img src="<?php echo MBW_SKIN_URL;?>images/icon_arrow_left2.gif"></a></span><span class="lnb-prev-month"><a href="javascript:;" onclick="setCalendar(\''+response.data["prev_month"]+'\')"><img src="<?php echo MBW_SKIN_URL;?>images/icon_arrow_left.gif"></a></span>';
		calendar_nav	= calendar_nav+'<span class="calendar-date-text">'+response.data["year"]+'<span class="lnb-year-text"><?php echo __MM("W_YEAR");?></span>'+response.data["month"]+'<span class="lnb-month-text"><?php echo __MM("W_MONTH");?></span></span>';
		calendar_nav	= calendar_nav+'<span class="lnb-next-month"><a href="javascript:;" onclick="setCalendar(\''+response.data["next_month"]+'\')"><img src="<?php echo MBW_SKIN_URL;?>images/icon_arrow_right.gif"></a></span><span class="lnb-next-year"><a href="javascript:;" onclick="setCalendar(\''+response.data["next_year"]+'\')"><img src="<?php echo MBW_SKIN_URL;?>images/icon_arrow_right2.gif"></a></span>';
		calendar_nav	= calendar_nav+'<input type="hidden" name="mb_calendar_date" id="mb_calendar_date" value="'+response.data["year"]+"-"+response.data["month"]+'"></div>';
		
		var calendar_data		= '<div class="calendar-box">'+calendar_nav+response.data["start"]+response.data["thead"]+response.data["tbody"]+response.data["end"]+'</div>';
		jQuery('#'+mb_options["board_name"]+'_board_box').html(calendar_data);
	}else{
		showAlertPopup(response);
	}
}


function selectTabMenu(obj,category,name){
	jQuery('.tab-menu-on').removeClass("tab-menu-on").addClass("tab-menu-off");
	jQuery(obj).removeClass("tab-menu-off").addClass("tab-menu-on");
	setCalendar(jQuery("#mb_calendar_date").val(),category);
	//sendListTemplateData({"board_name":name,"category":category});
}

function sendSearchCalendarData(data){
	setCalendar(jQuery("#mb_calendar_date").val());
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
<div class="mb-style1 calendar-list">
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
				<select id="search_field" name="search_field" class="search-field margin-right-5"><?php echo $list_data["search"];?></select><input id="search_text" class="search-text" type="text" name="search_text" accesskey="s" value="<?php echo mbw_htmlspecialchars(mbw_get_param("search_text"));?>" onkeypress="checkEnterKey(sendSearchCalendarData);"/><input style="display:none !important;" type="text"/><?php echo mbw_get_btn_template(array("name"=>"Search","onclick"=>"sendSearchCalendarData()","class"=>"btn btn-default btn-search margin-left-5")); ?>
			</div>
			<?php } ?>
			<div class="clear"></div>
		</div>
		</form>

		<?php do_action('mbw_board_skin_header'); ?>
		<form name="<?php echo $mb_board_name;?>_form_board_list" id="<?php echo $mb_board_name;?>_form_board_list" method="post">		
		<input type="hidden" name="board_name" id="board_name" value="<?php echo $mb_board_name?>" />
		<input type="hidden" name="page_id" id="page_id" value="<?php echo mbw_get_param("page_id")?>" />
		<input type="hidden" name="list_type" id="list_type" value="<?php echo mbw_get_param("list_type")?>" />
		<input type="hidden" name="page" id="page" value="<?php echo mbw_get_param("page")?>" />
		<input type="hidden" name="mode" id="mode" value="list" />
		<input type="hidden" name="board_action" id="board_action" value="" />
		<input type="hidden" name="board_pid" id="board_pid" value="" />
		<?php echo mbw_create_nonce("form"); ?>

		<div class="main-style1" id="<?php echo $mb_board_name;?>_board_box"></div>

		<?php do_action('mbw_board_skin_form'); ?>
		<?php if(mbw_get_option("use_list_button")){ ?>
		<div class="list-btn">
			<div class="btn-box-right" id="<?php echo $mb_board_name;?>_btn_box">
				<?php				
					echo '<span class="btn-box-left" style="float:left;">';				
					echo mbw_get_left_button("list");
					if(mbw_get_param("search_text")!="")
						echo mbw_get_btn_template(array("name"=>"Back","href"=>mbw_get_url(array("board_pid"=>"","mode"=>"list","page_size"=>"","search_text"=>"")),"class"=>"btn btn-default btn-list"));
					echo '</span>';
					if(intval(mbw_get_board_option("fn_delete_level")) <= $mb_user_level)
						echo mbw_get_btn_template(array("name"=>"Delete","onclick"=>"showDeleteConfirm()","class"=>"btn btn-default btn-delete"));

					echo mbw_get_right_button("list");
				?>
			</div>
		</div>
		<?php } ?>

	</form>
	<?php do_action('mbw_board_skin_footer'); ?>
	
</div>
<script type="text/javascript"> jQuery( document ).ready(function(){ setCalendar(<?php echo '"'.mbw_get_param("calendar_date").'"';?>); });</script>










