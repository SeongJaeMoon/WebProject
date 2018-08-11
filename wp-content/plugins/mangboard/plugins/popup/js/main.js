jQuery( document ).ready(function() {
	//팝업 태그를 body에 추가
	var popup_html	= "";
	popup_html		= popup_html+'<div class="mb-board">';
	popup_html		= popup_html+'<div class="pop-bg" id="mb_pop_bg" onclick="hidePopupAlert()"></div>';
	popup_html		= popup_html+'<div class="pop-main mb-'+mb_options["device_type"]+'" >';
		popup_html		= popup_html+'<div class="pop-html" id="mb_pop_html">';
			popup_html		= popup_html+'<div id="mb_pop_html_head"></div>';
			popup_html		= popup_html+'<div id="mb_pop_html_body"></div>';			
		popup_html		= popup_html+'</div>';
		popup_html		= popup_html+'<div class="pop pop-info radius-3" id="mb_pop_info">';
			popup_html		= popup_html+'<div id="mb_pop_info_head"></div>';
			popup_html		= popup_html+'<div id="mb_pop_info_body"></div>';
		popup_html		= popup_html+'</div>';
		popup_html		= popup_html+'<div class="pop pop-confirm radius-3" id="mb_pop_confirm">';
			popup_html		= popup_html+'<div class="pop-confirm-head" id="mb_pop_confirm_head"></div>';
			popup_html		= popup_html+'<div class="pop-confirm-body" id="mb_pop_confirm_body"></div>';
		popup_html		= popup_html+'</div>';
		popup_html		= popup_html+'<div class="pop pop-alert radius-3" id="mb_pop_alert">';
			popup_html		= popup_html+'<div class="pop-alert-head" id="mb_pop_alert_head"></div>';
			popup_html		= popup_html+'<div class="pop-alert-body" id="mb_pop_alert_body"></div>';			
		popup_html		= popup_html+'</div>';
		
	popup_html		= popup_html+'</div>';
	popup_html		= popup_html+'</div>';

     jQuery("body").append(popup_html);
}); 


var confirmCallbackSend;
var confirmCallbackCancel;
var alertCallbackSend;
var popupCallbackData;
var select_menu		= "";
var eventX				= 0;
var eventY				= 0;


function setPopupScrollEvent(){
	jQuery(window).on({
		'mousewheel': function(e){
			setPopupPosition("scroll");
		},'scroll': function(e){
			setPopupPosition("scroll");
		}
	})
}
function setPopupPosition(mode){
	if(typeof(mode)!=='undefined' && mode=="scroll" && jQuery("#mb_pop_bg").css('display')=='none') return;
	
	var popupObj			= jQuery("#mb_pop_confirm");
	popupObj.css('left',(jQuery(document).width()-popupObj.outerWidth())/2);
	popupObj.css('top',(jQuery(document).scrollTop()+(jQuery(window).height()-popupObj.outerHeight())/2)-20);

	popupObj		= jQuery("#mb_pop_alert");
	popupObj.css('left',(jQuery(document).width()-popupObj.outerWidth())/2);
	popupObj.css('top',(jQuery(document).scrollTop()+(jQuery(window).height()-popupObj.outerHeight())/2)-20);

	popupObj		= jQuery("#mb_pop_info");
	popupObj.css('left',(jQuery(document).width()-popupObj.outerWidth())/2);
	popupObj.css('top',(jQuery(document).scrollTop()+(jQuery(window).height()-popupObj.outerHeight())/2));

	popupObj		= jQuery("#mb_pop_html");
	popupObj.css('left',(jQuery(document).width()-popupObj.outerWidth())/2);
	popupObj.css('top',(jQuery(document).scrollTop()+(jQuery(window).height()-popupObj.outerHeight())/2));
}
setPopupScrollEvent();


function showConfirmPopup(message,data,send,cancel) {	
	popupCallbackData				= data;
	confirmCallbackSend			= send;

	if(typeof(cancel)==='undefined') confirmCallbackCancel = hidePopupBox;
	else confirmCallbackCancel		= cancel;

	//위치 설정
	var pop_head		= '';
	var pop_body		= '';

	if(typeof(data)!=='undefined' && typeof(data.type)!=='undefined' && data.type=="passwd"){
		pop_head		= '<div class="pop-title pop-title-confirm" id="mb_pop_confirm_text">'+message+'</div>';
		pop_body			= pop_body+'<div id="mb_pop_form">';
			pop_body			= pop_body+'<form class="pop-form" action="javascript:sendConfirmCallbackData()" id="mb_confirm_form" method="post" name="mb_confirm_form"><div><input id="mb_confirm_passwd" name="passwd" class="pop-input-passwd" type="password" /></div></form>';

		pop_body			= pop_body+'</div>';		
	}else{
		pop_head		= '<div class="pop-title" id="mb_pop_confirm_text"><p class="pop-title-head">Message</p><p class="pop-title-message">'+message+'</p></div>';
	}
	pop_body			= pop_body+'<div class="btn-box-center">';
	pop_body			= pop_body+'<a href="javascript:;" id="mb_pop_confirm_cancel" onclick="cancelConfirmCallbackData()" class="btn btn-default btn-cancel margin-right-10"><span>'+mb_languages["btn_cancel"]+'</span></a>';
	pop_body			= pop_body+'<a href="javascript:;" id="mb_pop_confirm_ok" onclick="sendConfirmCallbackData()" class="btn btn-default btn-ok"><span>'+mb_languages["btn_ok"]+'</span></a>';
	pop_body			= pop_body+'</div>';

	if(typeof(data)!=='undefined'){
		if(typeof(data.head)!=='undefined')  pop_head		= data.head;
		if(typeof(data.body)!=='undefined')  pop_body		= data.body;
	}

	showPopupBox("Confirm",pop_head,pop_body);
}
function showAlertPopup(response,send){
	if(!response || typeof(response)==='undefined') return;

	var code						= "";
	var message				= "";
	var target_name			= "";
	
	if(typeof(send)==='undefined') alertCallbackSend			= null;
	else alertCallbackSend			= send;
	
	if(typeof(response.code)!=='undefined') code				= response.code;
	if(typeof(response.message)!=='undefined') message		= response.message;
	if(typeof(response.target_name)!=='undefined') target_name		= response.target_name;
	if(message=="") return;

	var pop_head		= '<div class="pop-title" id="mb_pop_alert_text"><p class="pop-title-head">Message</p><p class="pop-title-message">'+message+'</p></div>';
	var pop_body		= '';
	pop_body			= pop_body+'<div class="btn-box-center">';
	pop_body			= pop_body+'<a href="javascript:;"  id="mb_pop_alert_ok" onclick="showAlertCallback(\''+code+'\',\''+	target_name+'\')" class="btn btn-default btn-ok"><span>'+mb_languages["btn_ok"]+'</span></a>';
	pop_body			= pop_body+'</div>';
	showPopupBox("Alert",pop_head,pop_body);
}
function showPopupBox(type,head,body,data){
	initLoadingBox();
	var popupID		= "#mb_pop_confirm";	

	if(type=="Alert"){
		popupID		= "#mb_pop_alert";
		if(jQuery("#mb_pop_bg").css('display')=='none') jQuery("#mb_pop_confirm").hide();	

		setTimeout(function(){ jQuery(popupID).addClass("mb-ani-pop-open");	 }, 1);		
	}else if(type=="Info"){
		popupID		= "#mb_pop_info";
	}else if(type=="Confirm"){
		popupID		= "#mb_pop_confirm";
		setTimeout(function(){ jQuery(popupID).addClass("mb-ani-pop-open");	 }, 1);		
	}else if(type=="Html"){
		popupID		= "#mb_pop_html";
	}else{
		popupID		= "#mb_pop_alert";
		setTimeout(function(){ jQuery(popupID).addClass("mb-ani-pop-open");	 }, 1);		
	}
	if(typeof(data)==='undefined') data		= {};
	if(typeof(data.position)==='undefined') data.position = "center";
	if(typeof(data.bg)==='undefined') data.bg = true;
	if(typeof(data.eventX)==='undefined') data.eventX = 0;
	if(typeof(data.eventY)==='undefined') data.eventY = 0;
	
	jQuery(popupID+"_head").html(head);
	jQuery(popupID+"_body").html(body);	
	
	var adminbarHeight		= jQuery("#wpadminbar").height();
	if(adminbarHeight==null || typeof(adminbarHeight)==='undefined') adminbarHeight		= 0;

	if(data.position=="click"){
		jQuery(popupID).css("top",parseInt((data.eventY+jQuery(document).scrollTop()-adminbarHeight)/10)*10-7);
		jQuery(popupID).css("left",parseInt(data.eventX/10)*10+30);
	}else{
		setPopupPosition();
	}
	if(data.bg) showPopupBG();
	
	jQuery(popupID).show();	

	if(type=="Alert"){
		jQuery("#mb_pop_alert_ok").focus();
	}else if(type=="Confirm"){
		jQuery("#mb_confirm_passwd").focus();
	}
	
}

function initLoadingBox(){
	jQuery("#mb_pop_html_head").html("");
	jQuery("#mb_pop_html_body").html("");
}

function showLoadingBox(){
	showPopupBox("Html",'<img src="'+mb_urls["plugin"]+'assets/images/loader.gif" width="50px" height="50px" style="opacity: 0.7;filter: alpha(opacity=0.7);">','<span style="color:#fff;font-size:12px;">Loading</span>');
}
function hideLoadingBox(){
	initLoadingBox();
	if(jQuery("#mb_pop_alert").css('display')=='none' && jQuery("#mb_pop_confirm").css('display')=='none'){
		jQuery("#mb_pop_bg").hide();
	}
}

function showPopupBG(){
	hideInfoBox();
	jQuery('#mb_pop_bg').height(jQuery(document).height());	
	jQuery("#mb_pop_bg").show();
}

function getUserMenu(uid,pid){
	var menu_options		= "*";
	
	if(select_menu==uid+"_"+pid){
		select_menu		= "";
		hideInfoBox();
	}else{		
		sendUserMenu(uid,menu_options,event);
		select_menu		= uid+"_"+pid;
	}
}
function showUserMenu(data){		
	var menu_head		= data["head"];
	var menu_body		= "";
	var menu_foot			= data["foot"];

	menu_head				= menu_head+'<div class="pop-info-head">'+data["user"]["name"]+'</div>';
	menu_body				= '<ul class="pop-info-body list-unstyled">';	

	if(data["body"].length>0){
		jQuery.each(data["body"], function(key,value){
			menu_body		= menu_body+'<li>'+value+'</li>';
		});
		menu_body		= menu_body+'</ul>';
		showPopupBox("Info","",('<div class="pop-user-menu">'+menu_head+menu_body+menu_foot+"</div>"),{"position":"click","bg":false,"eventX":eventX,"eventY":eventY});
	}
}


function sendUserMenu(uid,option,event){
	if(typeof(event)!=='undefined'){
		eventX		= event.clientX;
		eventY		= event.clientY;
	}
	if(option=="*") option	= "search,info,email,homepage,blog";

	var param	= "board_name="+mb_options["board_name"]+"&option="+option+"&list_type="+mb_options["list_type"]+"&page="+mb_options["page"];	
	if(jQuery('#'+mb_options["board_name"]+'_form_board_search')) param		+= "&"+jQuery('#'+mb_options["board_name"]+'_form_board_search').serialize();
	param	+= "&mode=user&board_action=menu"+"&pid="+uid;		

	sendDataRequest(mb_urls["template_api"], param, sendUserMenuHandler);
}
function sendUserMenuHandler(response, state){		
	if(response.state == "success"){
		showUserMenu(response.data);
	}else{
		showAlertPopup(response);
	}
}



function hideInfoBox() {
	jQuery("#mb_pop_info").hide();
}

function hidePopupBox() {	
	confirmCallbackSend		= null;
	jQuery(".input-focus").removeClass("input-focus");
	jQuery("#mb_pop_info").hide();
	jQuery("#mb_pop_html").hide();	
	jQuery("#mb_pop_confirm").hide();
	jQuery("#mb_pop_confirm").removeClass("mb-ani-pop-open");
	jQuery("#mb_pop_alert").removeClass("mb-ani-pop-open");
	jQuery("#mb_pop_bg").hide();
}


function showAlertCallback(code,target_name) {
	hidePopupAlert(code,target_name);
	sendAlertCallbackData();	
}

function hidePopupAlert(code,target_name) {
	if(typeof(code)!=='undefined' && code!=='undefined'){
		if(confirmCallbackSend) jQuery("#mb_pop_confirm").show();		

		if(code.substr(0,2)=="12"){	//입력 관련 에러일 경우 포커스 설정
			
			var target;
			if(jQuery("#mb_pop_confirm").css('display')!='none'){
				if(target_name!="")
					target		= jQuery("#mb_confirm_form").find("input[name="+target_name+"]");
			}else{
				target		= document.getElementsByName(target_name);
			}
			jQuery(".input-focus").removeClass("input-focus");

			if(typeof(target)!=='undefined'){
				jQuery(target).addClass("input-focus");
				jQuery(target).focus();
			}
		}
	}else{
		jQuery(".input-focus").focus();
	}
	
	jQuery("#mb_pop_alert").hide();
	jQuery("#mb_pop_alert").removeClass("mb-ani-pop-open");
	jQuery("#mb_pop_html").hide();
	jQuery("#mb_pop_info").hide();
	if(jQuery("#mb_pop_confirm").css('display')=='none'){
		jQuery("#mb_pop_bg").hide();
		initLoadingBox();
	}
}
function sendAlertCallbackData() {	
	if(alertCallbackSend) alertCallbackSend();
	else alertCallbackSend		= null;
}
function sendConfirmCallbackData() {	
	showLoadingBox();
	jQuery("#mb_pop_confirm").hide();
	if(confirmCallbackSend) confirmCallbackSend(popupCallbackData);
	else confirmCallbackSend		= null;
}
function cancelConfirmCallbackData() {	
	confirmCallbackSend		= null;
	if(confirmCallbackCancel) confirmCallbackCancel();
	else confirmCallbackCancel		= null;
}

