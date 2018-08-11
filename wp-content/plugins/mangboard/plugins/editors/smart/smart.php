<?php
$editor_type							= "S";
$editor_name							= "Smart Editor";
$mb_editors[$editor_type]			= array("type"=>$editor_type,"name"=>$editor_name,"script"=>"if(typeof(oEditors)!=='undefined'){ oEditors.getById['se_content'].exec('UPDATE_CONTENTS_FIELD', []);}; sendBoardWriteData();");

if(!function_exists('mbw_load_editor_s')){
	function mbw_load_editor_s(){		
		if(mbw_get_trace("mbw_load_editor_s")==""){
			mbw_add_trace("mbw_load_editor_s");
			wp_enqueue_script('smart-editor-js');
		}
	}
}
add_action('mbw_load_editor_'.$editor_type, 'mbw_load_editor_s',5); 
if(!function_exists('mbw_editor_smart_init')){
	function mbw_editor_smart_init(){
		if(mbw_get_vars("device_type")=="desktop"){
			wp_register_script('smart-editor-js', MBW_PLUGIN_URL.'plugins/editors/smart/js/service/HuskyEZCreator.js');
		}else{
			wp_register_script('smart-editor-js', MBW_PLUGIN_URL.'plugins/editors/smart/js/service/HuskyEZCreator_mobile.js');
		}
		
		if(mbw_get_board_option("fn_editor_type")=="S" && mbw_get_param("mode")=="write"){
			mbw_load_editor_s();			
		}
	}
}
add_action('wp_enqueue_scripts', 'mbw_editor_smart_init',5);
add_action('admin_enqueue_scripts', 'mbw_editor_smart_init',5);

if(!function_exists('mbw_editor_smart_template')){
	function mbw_editor_smart_template($action, $data){
		
		/*if(mbw_get_vars("device_type")=="mobile" || mbw_get_vars("device_type")=="tablet"){		
			if(function_exists('mbw_editor_ck_template')){
				mbw_editor_ck_template($action, $data);
				echo '<script type="text/javascript">setEditorType("C");</script>';
			}else{
				echo mbw_get_default_editor($data);
			}
		}else */{
			if(mbw_get_trace("mbw_load_editor_s")==""){
				mbw_load_editor_s();
			}
			$item_html		= "";
			mbw_set_board_option("fn_editor_type","S");
			if(empty($data["width"])) $data["width"]			= '100%';
			if(empty($data["height"])) $data["height"]		= '360px';

			
			$use_photo_upload			= "true";
			if(mbw_get_vars("device_type")!="desktop" && mbw_get_vars("use_editor_mobile_upload")=="false"){
				$use_photo_upload			= "false";
			}

			$locale			= mbw_get_option("locale");

			if($locale=='en_US' || $locale=='en') $editor_locale	= 'en_US';
			else if($locale=='ja') $editor_locale	= 'ja_JP';
			else if($locale=='zh_CN' || $locale=='zh') $editor_locale	= 'zh_CN';
			else if($locale=='zh_TW') $editor_locale	= 'zh_TW';
			else if($locale=='ko_KR' || $locale=='ko') $editor_locale	= 'ko_KR';
			else $editor_locale		= 'ko_KR';

			$editor_url		= mbw_check_url(MBW_HOME_URL);
			if(strpos($editor_url, '?') === false)	$editor_url		.= "/?";
			else $editor_url		.= "&";
			$editor_skin	= $editor_url."mb_ext=seditor&se_skin=SmartEditor2Skin_".$editor_locale."&se_locale=".$editor_locale;
			if(empty($data["value"])) $data["value"]	= '<p><span style="font-size: 10pt;line-height:1.6"><br></span></p>';

			$item_html		= "";
			$item_html		.= '<input type="hidden" name="'.mbw_set_form_name("data_type").'" id="data_type" value="html" />';
			$item_html		.= '<textarea'.$data["ext"].__STYLE("width:".$data["width"].";height:".$data["height"].";".$data["style"].";visibility:hidden;").' name="'.$data["item_name"].'" id="se_content" title="'.$data["name"].'">'.$data["value"].'</textarea>';
			$item_html		.= '<script type="text/javascript">if(typeof(oEditors)==="undefined"){var oEditors = [];};jQuery(document).ready(function(){nhn.husky.EZCreator.createInIFrame({oAppRef: oEditors,elPlaceHolder: "se_content",sSkinURI:"'.$editor_skin.'",fCreator:"createSEditor2",htParams:{bUseToolbar:true,bSkipXssFilter : true,I18N_LOCALE:"'.$editor_locale.'",bUsePhotoUpload:'.$use_photo_upload.',bUseVerticalResizer:true,bUseModeChanger:true,aAdditionalFontList:[["Noto Sans","Noto Sans KR"]]},fOnAppLoad : function(){/*oEditors.getById["se_content"].setDefaultFont("나눔고딕", 9);*/}});   });</script>';	
			echo $item_html;
		}
	}
}
add_action('mbw_editor_'.$editor_type, 'mbw_editor_smart_template',5,2); 

?>