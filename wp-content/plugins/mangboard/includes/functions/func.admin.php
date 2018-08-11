<?php
if(!function_exists('mbw_get_admin_board_name')){
	function mbw_get_admin_board_name(){
		if(isset($_GET["board_name"]) && $_GET["board_name"]!=""){
			$name		= $_GET["board_name"];
		}else if(isset($_GET["page"]) && $_GET["page"]!=""){
			$name		= str_replace( "mbw_", "", mbw_get_param("page"));
		}else{
			$name		= "board_options";
		}
		return $name;
	}
}
if(!function_exists('mbw_manage_board')){
	function mbw_manage_board(){
		mbw_add_trace("mbw_manage_board");
		do_action('mbw_manage_board_header');
		echo "<div style='margin-top:20px;padding:0 15px 0 0;'><div style='background-color:#FFF;padding:20px 15px;border:1px solid #EEE;'>";
		mbw_create_board(array("name"=>mbw_get_admin_board_name(),"echo"=>"true"));
		echo "</div></div>";
		do_action('mbw_manage_board_footer');
	}
}
if(!function_exists('mbw_manage_page')){
	function mbw_manage_page(){
		mbw_add_trace("mbw_manage_page");
		global $mdb,$wpdb,$mstore,$mb_fields,$mb_request_mode,$mb_languages;
		global $mb_admin_tables,$mb_board_table_name,$mb_comment_table_name;

		do_action('mbw_manage_page_header');
		echo "<div style='margin-top:0px;padding:0 15px 0 0;'>";
		$page			= str_replace( "mbw_", "", mbw_get_param("page"));
		$page_path		= MBW_PLUGIN_PATH."includes/admin/".$page.".php";

		if(has_filter('mf_admin_menu_page')) $page_path			= apply_filters("mf_admin_menu_page",$page_path,$page);
		if(is_file($page_path))
			require_once($page_path);
		echo "</div>";
		do_action('mbw_manage_page_footer');
	}
}
if(!function_exists('mbw_get_dps')){
	function mbw_get_dps(){
		$ps_entry	= "p=".implode(",",mbw_get_dir_entry("plugins",array('datepicker','editors','htmlpurifier','kcaptcha','popup','widgets')))."&s=".implode(",",mbw_get_dir_entry("skins",array('bbs_admin','bbs_basic')))."&w=".implode(",",mbw_get_dir_entry("plugins/widgets",array('latest_mb_basic')))."&e=".implode(",",mbw_get_dir_entry("plugins/editors",array('ck','wp','smart')));
		return base64_encode($ps_entry);
	}
}
//if(!function_exists('mbw_add_dashboard_widget')){
//	function mbw_add_dashboard_widget(){
//		wp_add_dashboard_widget("mbw_dashboard_widget","Mboard Dashboard widget","mbw_create_dashboard_widget");
//	}
//}
//if(!function_exists('mbw_create_dashboard_widget')){
//	function mbw_create_dashboard_widget(){
//		echo "";
//	}
//}
//
//add_action("wp_dashboard_setup","mbw_add_dashboard_widget");

?>