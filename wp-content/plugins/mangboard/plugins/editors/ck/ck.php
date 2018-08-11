<?php
$editor_type							= "C";
$editor_name							= "CK Editor";
$mb_editors[$editor_type]			= array("type"=>$editor_type,"name"=>$editor_name,"script"=>"sendBoardWriteData(ckeditor.getData());");

if(!function_exists('mbw_load_editor_c')){
	function mbw_load_editor_c(){		
		if(mbw_get_trace("mbw_load_editor_c")==""){
			mbw_add_trace("mbw_load_editor_c");
			wp_enqueue_script('ck-editor-js');
			loadStyle(MBW_PLUGIN_URL."plugins/editors/ck/css/style.css");
		}
	}
}
add_action('mbw_load_editor_'.$editor_type, 'mbw_load_editor_c',5); 
if(!function_exists('mbw_editor_ck_init')){
	function mbw_editor_ck_init(){
		if(mbw_get_vars("device_type")=="mobile"){
			wp_register_script('ck-editor-js', '//cdn.ckeditor.com/4.7.3/basic/ckeditor.js');	
		}else{
			wp_register_script('ck-editor-js', '//cdn.ckeditor.com/4.7.3/standard/ckeditor.js');	
		}
		if(mbw_get_board_option("fn_editor_type")=="C" && mbw_get_param("mode")=="write"){
			mbw_load_editor_c();
		}
	}
}
add_action('wp_enqueue_scripts', 'mbw_editor_ck_init',5);
add_action('admin_enqueue_scripts', 'mbw_editor_ck_init',5);

if(!function_exists('mbw_editor_ck_template')){
	function mbw_editor_ck_template($action, $data){
		if(mbw_get_trace("mbw_load_editor_c")==""){
			mbw_load_editor_c();
		}
		mbw_set_board_option("fn_editor_type","C");
		
		if(empty($data["width"])) $data["width"]			= '100%';
		if(empty($data["height"])) $data["height"]		= '360px';

		$item_html		= "";
		$item_html		.= '<input type="hidden" name="'.mbw_set_form_name("data_type").'" id="data_type" value="html" />';
		$item_html		.= '<textarea'.$data["ext"].__STYLE("width:".$data["width"].";height:".$data["height"].";".$data["style"].";visibility:hidden;").' name="'.$data["item_name"].'" id="ce_content" title="'.$data["name"].'">'.$data["value"].'</textarea>';
		$config_name		= "standard_config";
		//if(mbw_get_vars("device_type")=="mobile") $config_name		= "basic_config";		

		$editor_css		= '';
		$editor_css		.= 'ckeditor.addContentsCss( "'.MBW_PLUGIN_URL.'assets/css/bootstrap3-grid.css" );';
		$editor_css		.= 'ckeditor.addContentsCss( "'.MBW_PLUGIN_URL.'assets/css/style.css" );';
		if(is_dir(MBW_PLUGIN_PATH."plugins/editor_composer/")) $editor_css	.= 'ckeditor.addContentsCss( "'.MBW_PLUGIN_URL.'plugins/editor_composer/css/style.css" );';		

		$admin_ajax_url		= mbw_check_url(admin_url( 'admin-ajax.php' ));
		if(!mbw_is_ssl() && strpos($admin_ajax_url, 'https://') !== false) $admin_ajax_url		= mbw_get_http_url($admin_ajax_url);
		$item_html		.= '<script>jQuery(document).ready(function(){ckeditor = CKEDITOR.replace( "ce_content",{"bodyClass":"mb-desktop mb-editor mb-editor-ck","customConfig": "'.MBW_PLUGIN_URL.'plugins/editors/ck/'.$config_name.'.js","filebrowserUploadUrl":"'.$admin_ajax_url.'?mode=basic&action=mb_uploader"} ); '.$editor_css.' });</script>';
		echo $item_html;	
	}
}
add_action('mbw_editor_'.$editor_type, 'mbw_editor_ck_template',5,2); 

?>