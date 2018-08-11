<?php
if(!function_exists('mbw_create_query')){
	function mbw_create_query($name, $schema){
		global $wpdb;
		$query		= sprintf('CREATE TABLE IF NOT EXISTS %s %s ;', $name, $schema);
		@$wpdb->query($query);
	}
}
if(!function_exists('mbw_drop_query')){
	function mbw_drop_query($name){
		global $wpdb;
		$query		= sprintf('DROP TABLE %s;', $name);
		@$wpdb->query($query);
	}
}
if(!function_exists('mbw_create_board_table')){
	function mbw_create_board_table($name,$schema=null){
		mbw_add_trace("mbw_create_board_table");

		if(!empty($name)){
			if(empty($schema)){
				require(MBW_PLUGIN_PATH."includes/install/schema/mb-schema.php");
				$schema		= $mb_schema;
			}
			mbw_create_query(mbw_get_table_name($name,"board","create"),$schema["board"]);
			mbw_create_query(mbw_get_table_name($name,"comment","create"),$schema["comment"]);
		}
	}
}

if(!function_exists('mbw_create_plugin_table')){
	function mbw_create_plugin_table($name,$schema=null){
		if(!empty($name)){
			mbw_add_trace("mbw_create_plugin_table");
			mbw_create_query(mbw_get_table_name($name,"board","create"),$schema["board"]);
		}
	}
}

?>