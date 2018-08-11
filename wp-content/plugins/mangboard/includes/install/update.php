<?php
if(!function_exists('mbw_install_add_options')){
	function mbw_install_add_options($options,$name="mb_options"){
		$insert_prefix		= "INSERT INTO `".$name."` (`option_load`, `option_category`, `option_title`, `option_name`, `option_value`, `option_data`, `option_label`, `option_class`, `option_style`, `option_event`, `option_attribute`, `option_type`, `description`) VALUES ";
		mbw_install_insert_query($insert_prefix,$options,$name,"option_name");
	}
}

if(!function_exists('mbw_install_insert_query')){
	function mbw_install_insert_query($insert_prefix,$options,$name="",$filed=""){
		global $wpdb;
		if(!empty($name)){
			$rows		= $options;	
			foreach($rows as $key=>$value){
				$row_check			= 0;
				if(!empty($filed))
					$row_check		= intval($wpdb->get_var("SELECT count(*) from ".$name." where ".$filed."='".$key."'"));
				if($row_check==0){
					$query		= $insert_prefix.$value;
					@$wpdb->query($query);
				}
			}	
		}
	}
}



if(!function_exists('mbw_update_check')){
	function mbw_update_check(){
		global $mdb;
		global $mb_version,$mb_db_version;
		global $mb_admin_tables,$mb_table_prefix;

		$current_db_version		= mbw_get_option("db_version");
		if (version_compare($current_db_version, $mb_db_version, "<")){

			if(version_compare($current_db_version, '1.0.1', "<")){		//1.0.0 버젼 업데이트

				// options 테이블에 is_show 필드 추가
				$mdb->query("ALTER TABLE `".$mb_table_prefix."options` ADD COLUMN `is_show` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `option_sequence`");
				// boards 테이블에 post_id 필드 추가
				$mdb->query("ALTER TABLE `".$mb_table_prefix."boards` ADD COLUMN `post_id` BIGINT(20) NOT NULL DEFAULT '0' AFTER `mobile_skin_name`");
				// files 테이블에 table_name 필드 추가
				$mdb->query("ALTER TABLE `".$mb_table_prefix."files` ADD COLUMN `table_name` VARCHAR(100) NOT NULL DEFAULT '' AFTER `board_name`, ADD INDEX `table_name` (`table_name`)");

				$items						= $mdb->get_results("SELECT * FROM ".$mb_admin_tables["board_options"]." WHERE board_type='board'", ARRAY_A);
				// 게시판 테이블에 "file_count" 필드 추가
				foreach($items as $item){
					$mdb->query("ALTER TABLE `".$mb_table_prefix.$item["board_name"]."` ADD COLUMN `file_count` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `level`");					
				}

				//옵션 version 데이타 입력 (version 정보는 1.0.3 버젼부터 설치시 입력)
				$options_rows['mb_version']					= "('setup', 'board', '망보드 버젼', 'mb_version', '".$mb_version."', '', '', '', 'width:300px;', '', '', 'text_static', '')";
				$options_rows['db_version']					= "('setup', 'board', '디비 버젼', 'db_version', '".$mb_db_version."', '', '', '', 'width:300px;', '', '', 'text_static', '')";
				mbw_install_add_options($options_rows,$mb_admin_tables["options"]);
			}			
		}

		// DB 버젼 동일하게 수정
		mbw_update_option('db_version',$mb_db_version);
	}
}
mbw_update_check()
?>