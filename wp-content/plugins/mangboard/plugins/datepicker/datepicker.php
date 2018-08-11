<?php
if(!function_exists('mbw_init_datepicker')){	
	function mbw_init_datepicker(){
		loadScript(MBW_PLUGIN_URL."plugins/datepicker/js/datepicker.js");
	}
}
add_action('wp_enqueue_scripts', 'mbw_init_datepicker');
add_action('admin_enqueue_scripts', 'mbw_init_datepicker');
?>