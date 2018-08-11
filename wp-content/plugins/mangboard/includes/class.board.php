<?php
class MangBoard
{
	public function __construct($db=NULL,$mstore=NULL){
	}
	
	public function get_board_panel($args=NULL){
		mbw_add_trace("board->get_board_panel");
		global $mdb,$mstore;
		global $mb_admin_tables,$mb_board_table_name,$mb_comment_table_name;
		global $mb_fields,$mb_api_urls;
		global $mb_vars,$mb_board_name,$mb_words,$mb_languages;
		
		$mb_board_name	= mbw_get_board_name();
		$mb_user_level		= mbw_get_user("fn_user_level");

		if(mbw_get_param("mode")==""){
			if(!empty($args['mode'])){
				mbw_set_param("mode", $args['mode']);
				if($args['mode']=="write") mbw_load_editor_plugin();
			}else mbw_set_param("mode", "list");
			if(!empty($args['board_action'])) mbw_set_param("board_action", $args['board_action']);
			else if(!empty($args['action'])) mbw_set_param("board_action", $args['action']);
			if(!empty($args['board_pid'])) mbw_set_param("board_pid", $args['board_pid']);			
		}
		if(!isset($_GET["category1"]) && mbw_get_param("category1")==""){
			if(!empty($args['category1'])) mbw_set_param("category1", $args['category1']);
			if(!empty($args['category2'])) mbw_set_param("category2", $args['category2']);
			if(!empty($args['category3'])) mbw_set_param("category3", $args['category3']);
			mbw_set_category_params();
		}

		$board_mode			= mbw_get_param("mode");
		if(mbw_get_param($board_mode."_type")=="" && !empty($args[$board_mode.'_type'])) mbw_set_param($board_mode."_type", $args[$board_mode.'_type']);

		if($board_mode=="logout"){
			echo mbw_get_move_script("logout");
		}else{

			if(empty($args['style'])) $board_style			= "";
			else $board_style			= ' style="'.str_replace('"',"'",$args['style']).'"';

			$file_path["base"]			= MBW_SKIN_PATH;
			$file_path["prefix"]		= "";
			$file_path["mode"]		= $board_mode;

			if(has_filter("mf_board_skin_path")) 
				$file_path		= apply_filters("mf_board_skin_path",$file_path);
			
			echo '<div class="mb-'.$mb_vars["device_type"].'">';
			echo '<div id="'.$mb_board_name.'_board" class="mb-board"'.$board_style.'>';
				if(mbw_get_param("list_type")=="") mbw_set_param("list_type", $mstore->get_list_type());
				require($file_path["base"]."_header.php");
				do_action('mbw_board_header');
				echo mbw_get_board_option("fn_board_header");				

				if(mbw_get_param($board_mode."_type")!="" && is_file($file_path["base"].$file_path["prefix"].mbw_get_param($board_mode."_type").".php")){
					require($file_path["base"].$file_path["prefix"].mbw_get_param($board_mode."_type").".php");
				}else if(is_file($file_path["base"].$file_path["prefix"].$file_path["mode"].".php"))
					require($file_path["base"].$file_path["prefix"].$file_path["mode"].".php");
								
				require($file_path["base"]."_footer.php");
				do_action('mbw_board_footer');
				echo mbw_get_board_option("fn_board_footer");

			echo '</div>';
			echo '</div>';
		}
	}
}
?>