<?php
if(!function_exists('mbw_init_popup')){	
	function mbw_init_popup(){
		global $mb_vars;	
		loadScript(MBW_PLUGIN_URL."plugins/popup/js/main.js");

		if($mb_vars["device_type"]=="desktop"){
			loadStyle(MBW_PLUGIN_URL."plugins/popup/css/style.css");
		}else if($mb_vars["device_type"]=="tablet"){
			loadStyle(MBW_PLUGIN_URL."plugins/popup/css/style.css");
		}else if($mb_vars["device_type"]=="mobile"){
			loadStyle(MBW_PLUGIN_URL."plugins/popup/css/style.css");
		}	
	}
}
add_action('wp_enqueue_scripts', 'mbw_init_popup');
add_action('admin_enqueue_scripts', 'mbw_init_popup');
?>