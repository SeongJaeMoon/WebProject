<?php
/**
 * Uninstall plugin
 */

// If uninstall not called from WordPress exit
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}


//실수에 의한 삭제를 방지하기 위해서는 아래 true 코드를 false 로 수정하거나 
//Uninstall.php 파일을 삭제하시기 바랍니다
//"true" 삭제 실행, "false" 삭제 방지
if(true)
{
	global $wpdb;	
	define("MBW_PLUGIN_PATH", plugin_dir_path(__FILE__));
	$upload_dir = wp_upload_dir();
	define("MBW_UPLOAD_PATH", $upload_dir['basedir']."/mangboard/");


	require(MBW_PLUGIN_PATH."includes/mb-config.php");

	//게시판 테이블 삭제
	$items						= $wpdb->get_results("SELECT * FROM ".$mb_admin_tables["board_options"]." WHERE table_link='' and board_type!='admin'", ARRAY_A);
	foreach($items as $item){
		@$wpdb->query( "DROP TABLE IF EXISTS " . $mb_table_prefix.$item["board_name"]);
		if($item["board_type"]=="board"){
			@$wpdb->query( "DROP TABLE IF EXISTS " . $mb_table_prefix.$item["board_name"].$mb_table_comment_suffix);
		}
	}

	//관리자 테이블 삭제
	foreach($mb_admin_tables as $key=>$value){
		@$wpdb->query( "DROP TABLE IF EXISTS " . $mb_admin_tables[$key]);
	}	
	delete_option('mb_user_synchronize_index');
	delete_option('mb_latest_board_data');
	delete_option('mb_latest_comment_data');

	//업로드 파일 삭제
	if(is_dir(MBW_UPLOAD_PATH)){
		$rm = "rm -rf ".MBW_UPLOAD_PATH;
		exec($rm);
	}
}
?>