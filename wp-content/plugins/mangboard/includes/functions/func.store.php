<?php

if(!function_exists('mbw_set_board_items_query')){
	function mbw_set_board_items_query($query){
		global $mstore,$mdb;
		$mstore->set_board_items($mdb->get_results($query,ARRAY_A));
	}	
}
if(!function_exists('mbw_get_board_items_query')){
	function mbw_get_board_items_query($query){
		global $mstore,$mdb;
		$items		= $mdb->get_results($query,ARRAY_A);
		$mstore->set_board_items($items);
		return $items;
	}	
}
if(!function_exists('mbw_get_board_item_query')){
	function mbw_get_board_item_query($query){
		global $mstore,$mdb;
		$item		= $mdb->get_row($query,ARRAY_A);
		$mstore->set_board_item($item);
		return $item;
	}	
}
if(!function_exists('mbw_set_board_items')){
	function mbw_set_board_items($items){
		global $mstore;
		$mstore->set_board_items($items);
	}	
}

if(!function_exists('mbw_set_board_item')){
	function mbw_set_board_item($field,$value="",$index=1){
		global $mstore;
		$mstore->set_board_item($field,$value,$index);
	}	
}

if(!function_exists('mbw_get_board_items')){
	function mbw_get_board_items(){
		global $mstore;
		return $mstore->get_board_items();
	}	
}

if(!function_exists('mbw_get_board_item')){
	function mbw_get_board_item($field="",$filter=true){
		global $mstore;
		return $mstore->get_board_item($field,$filter);
	}	
}
if(!function_exists('mbw_set_comment_items_query')){
	function mbw_set_comment_items_query($query){
		global $mstore,$mdb;
		$mstore->set_comment_items($mdb->get_results($query,ARRAY_A));
	}	
}
if(!function_exists('mbw_set_comment_item_query')){
	function mbw_set_comment_item_query($query){
		global $mstore,$mdb;
		$mstore->set_comment_item($mdb->get_row($query,ARRAY_A));
	}	
}
if(!function_exists('mbw_set_comment_items')){
	function mbw_set_comment_items($items){
		global $mstore;
		$mstore->set_comment_items($items);
	}	
}

if(!function_exists('mbw_set_comment_item')){
	function mbw_set_comment_item($field,$value=""){
		global $mstore;
		$mstore->set_comment_item($field,$value);
	}	
}

if(!function_exists('mbw_get_comment_items')){
	function mbw_get_comment_items(){
		global $mstore;
		return $mstore->get_comment_items();
	}	
}

if(!function_exists('mbw_get_comment_item')){
	function mbw_get_comment_item($field="",$filter=true){
		global $mstore;
		return $mstore->get_comment_item($field,$filter);
	}	
}

if(!function_exists('mbw_init_board')){
	function mbw_init_board($name){
		global $mstore;
		$mstore->init_board($name);
	}	
}

if(!function_exists('mbw_get_model')){
	function mbw_get_model($key){
		global $mstore;
		return $mstore->get_model($key);
	}	
}
if(!function_exists('mbw_set_model')){
	function mbw_set_model($key,$value,$device=""){
		global $mstore;

		if(empty($device)){
			$mstore->set_model($key,$value,"desktop");
			$mstore->set_model($key,$value,"tablet");
			$mstore->set_model($key,$value,"mobile");
		}else{
			$mstore->set_model($key,$value,$device);
		}
		
	}	
}
if(!function_exists('mbw_set_models')){
	function mbw_set_models($data){
		global $mstore;
		$mstore->set_models($data);
	}	
}

if(!function_exists('mbw_set_vars')){
	function mbw_set_vars($key,$value){
		global $mb_vars;
		$mb_vars[$key]		= $value;
	}	
}
if(!function_exists('mbw_get_vars')){
	function mbw_get_vars($key){
		global $mb_vars;
		if(!empty($mb_vars[$key]))
			return $mb_vars[$key];
		else return "";
	}	
}




if(!function_exists('mbw_get_result_data')){
	function mbw_get_result_data($key){
		global $mstore;
		return $mstore->get_result_data($key);
	}	
}

if(!function_exists('mbw_set_result_data')){
	function mbw_set_result_data($value){
		global $mstore;
		$mstore->set_result_data($value);
	}	
}


if(!function_exists('mbw_add_trace')){
	function mbw_add_trace($name){
		global $mb_trace;
		$mb_trace[]		= $name;
	}	
}
if(!function_exists('mbw_get_trace')){
	function mbw_get_trace($name){
		global $mb_trace;
		foreach($mb_trace as $key => $value){
			if($name==$value) return $key;
		}
		return "";
	}	
}

if(!function_exists('mbw_set_param')){
	function mbw_set_param($key,$value){
		global $mstore;
		$mstore->set_param($key,$value);
	}	
}
if(!function_exists('mbw_get_param')){
	function mbw_get_param($key){
		global $mstore;
		return $mstore->get_param($key);
	}	
}
if(!function_exists('mbw_get_board_name')){
	function mbw_get_board_name(){
		global $mstore;
		return $mstore->get_board_name();
	}	
}

if(!function_exists('mbw_is_admin_table')){
	function mbw_is_admin_table($name){
		global $mstore;
		return $mstore->is_admin_table($name);
	}	
}

if(!function_exists('mbw_is_admin')){
	function mbw_is_admin(){
		global $mstore;
		return $mstore->is_admin();
	}	
}
if(!function_exists('mbw_is_admin_page')){
	function mbw_is_admin_page(){
		global $mstore;
		return $mstore->is_admin_page();
	}	
}
if(!function_exists('mbw_is_login')){
	function mbw_is_login(){
		global $mstore;
		return $mstore->is_login();
	}	
}

if(!function_exists('mbw_is_login_cookie')){
	function mbw_is_login_cookie(){
		global $mstore;
		return $mstore->is_login_cookie();
	}	
}


if(!function_exists('mbw_is_login')){
	function mbw_is_login(){
		global $mstore;
		return $mstore->is_login();
	}	
}

if(!function_exists('mbw_get_user')){
	function mbw_get_user($field){
		global $mstore;
		return $mstore->get_user($field);
	}
}

if(!function_exists('mbw_set_option')){
	function mbw_set_option($key,$value){
		global $mstore;
		$mstore->set_option($key,$value);
	}	
}
if(!function_exists('mbw_get_option')){
	function mbw_get_option($key){
		global $mstore;
		return $mstore->get_option($key);
	}	
}
if(!function_exists('mbw_update_option')){
	function mbw_update_option($key,$value){
		global $mdb,$mb_admin_tables,$mb_fields;
		$mdb->query($mdb->prepare("update ".$mb_admin_tables["options"]." set ".$mb_fields["options"]["fn_option_value"]."='".$value."' where `".$mb_fields["options"]["fn_option_name"]."`=%s", $key));
		mbw_options_meta_refresh();
	}
}
if(!function_exists('mbw_options_meta_refresh')){
	function mbw_options_meta_refresh(){
		if(mbw_is_admin()){
			global $mdb,$mb_fields,$mb_admin_tables,$mstore;
			$where_query			= "";
			$query_command	= "";
			$field						= $mb_fields["board_options"];

			$option_data			= $mdb->get_results("select ".$mb_fields["options"]["fn_option_name"].",".$mb_fields["options"]["fn_option_value"]." from ".$mb_admin_tables["options"], ARRAY_A);
			$encode_data			= (serialize($option_data));

			$meta_check			= intval($mdb->get_var(mbw_get_add_query(array("column"=>"count(*)","table"=>$mb_admin_tables["meta"]), array(array("field"=>$mb_fields["meta"]["fn_meta_table"],"value"=>'options'),array("field"=>$mb_fields["meta"]["fn_meta_key"],"value"=>'db_options')))));
			if($meta_check==0){
				$mdb->query($mdb->prepare("INSERT INTO ".$mb_admin_tables["meta"]." (".$mb_fields["meta"]["fn_meta_table"].",".$mb_fields["meta"]["fn_meta_key"].",".$mb_fields["meta"]["fn_meta_value"].") VALUES ('options','db_options',%s)",$encode_data));	
			}else{
				$mdb->query($mdb->prepare("UPDATE ".$mb_admin_tables["meta"]." set ".$mb_fields["meta"]["fn_meta_value"]."=%s where ".$mb_fields["meta"]["fn_meta_table"]."= 'options' and ".$mb_fields["meta"]["fn_meta_key"]."= 'db_options'",$encode_data));		
			}
		}
	}
}

if(!function_exists('mbw_set_board_languages')){
	function mbw_set_board_languages(){
		global $mstore;
		$mstore->set_board_languages();
	}	
}
if(!function_exists('mbw_set_board_meta')){
	function mbw_set_board_meta($command, $s_data,$w_data){
		global $mstore;
		$mstore->set_board_meta($command, $s_data,$w_data);
	}	
}
if(!function_exists('mbw_get_board_meta')){
	function mbw_get_board_meta($w_data,$column="*",$limit=1){
		global $mstore;
		return $mstore->get_board_meta($w_data,$column,$limit);
	}
}

if(!function_exists('mbw_set_db_options')){
	function mbw_set_db_options($key="",$category=""){
		global $mstore;
		$mstore->set_db_options($key,$category);
	}	
}


if(!function_exists('mbw_set_board_option')){
	function mbw_set_board_option($field,$value){
		global $mstore;
		$mstore->set_board_option($field,$value);
	}	
}
if(!function_exists('mbw_get_board_option')){
	function mbw_get_board_option($field){
		global $mstore;
		return mbw_htmlspecialchars_decode($mstore->get_board_option($field));
	}	
}

if(!function_exists('mbw_set_category_field')){
	function mbw_set_category_field($key,$value){
		global $mstore;
		$mstore->set_category_field($key,$value);
	}	
}
if(!function_exists('mbw_set_category_fields')){
	function mbw_set_category_fields($params){
		global $mstore;
		$mstore->set_category_fields($params);
	}	
}
if(!function_exists('mbw_get_category_fields')){
	function mbw_get_category_fields(){
		global $mstore;
		return $mstore->get_category_fields();
	}	
}
if(!function_exists('mbw_set_board_fields')){
	function mbw_set_board_fields($fields){
		global $mstore;
		$mstore->set_board_fields($fields);
	}
}


if(!function_exists('mbw_set_filter')){
	function mbw_set_filter($key,$value){
		global $mstore;
		$mstore->set_filter($key,$value);
	}	
}
if(!function_exists('mbw_get_filter')){
	function mbw_get_filter($key){
		global $mstore;
		return $mstore->get_filter($key);
	}	
}

if(!function_exists('mbw_set_pattern')){
	function mbw_set_pattern($key,$value){
		global $mstore;
		$mstore->set_pattern($key,$value);
	}	
}
if(!function_exists('mbw_get_pattern')){
	function mbw_get_pattern($key){
		global $mstore;
		return $mstore->get_pattern($key);
	}	
}
if(!function_exists('mbw_set_messages')){
	function mbw_set_messages($value){
		global $mstore;
		$mstore->set_messages($value);
	}	
}
if(!function_exists('mbw_set_message')){
	function mbw_set_message($key,$value){
		global $mstore;
		$mstore->set_message($key,$value);
	}	
}
if(!function_exists('mbw_get_message')){
	function mbw_get_message($key){
		global $mstore;
		return $mstore->get_message($key);
	}	
}

if(!function_exists('mbw_get_timestamp')){
	function mbw_get_timestamp(){
		return current_time('timestamp');
	}	
}

if(!function_exists('mbw_get_current_time')){
	function mbw_get_current_time(){
		global $mstore;
		return $mstore->get_current_time();
	}	
}
if(!function_exists('mbw_get_current_date')){
	function mbw_get_current_date(){
		global $mstore;
		return $mstore->get_current_date();
	}	
}

if(!function_exists('mbw_get_access_token')){
	function mbw_get_access_token(){
		global $mstore;
		return $mstore->get_cookie("mb_access_token");
	}	
}

if(!function_exists('mbw_get_login_cookie')){
	function mbw_get_login_cookie(){
		global $mstore;
		return $mstore->get_login_cookie();
	}	
}

if(!function_exists('mbw_get_cookie')){
	function mbw_get_cookie($key){
		global $mstore;
		return $mstore->get_cookie($key);
	}	
}


if(!function_exists('mbw_get_item_index')){
	function mbw_get_item_index(){
		global $mstore;
		return $mstore->get_item_index();
	}	
}

if(!function_exists('mbw_set_cookie')){
	function mbw_set_cookie($name,$value,$expire=0,$path="/",$domain="",$secure=false,$httponly=true){		
		global $mstore;
		if(mbw_get_option("ssl_mode")) $secure		= is_ssl();
		$mstore->set_cookie($name,$value);
		@setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}
}
if(!function_exists('mbw_init_board_where')){
	function mbw_init_board_where(){
		global $mstore;
		$mstore->init_board_where();
	}	
}
if(!function_exists('mbw_set_board_where')){
	function mbw_set_board_where($data){
		global $mstore;
		$mstore->set_board_where($data);
	}	
}
if(!function_exists('mbw_set_board_order')){
	function mbw_set_board_order($data){
		global $mstore;
		$mstore->set_board_order($data);
	}	
}


if(!function_exists('mbw_add_left_button')){
	function mbw_add_left_button($key,$value){
		global $mstore;
		$mstore->add_left_button($key,$value);
	}	
}
if(!function_exists('mbw_add_left_buttons')){
	function mbw_add_left_buttons($params){
		global $mstore;
		$mstore->add_left_buttons($params);
	}	
}
if(!function_exists('mbw_get_left_button')){
	function mbw_get_left_button($key){
		global $mstore;
		return $mstore->get_left_button($key);
	}	
}

if(!function_exists('mbw_add_right_button')){
	function mbw_add_right_button($key,$value){
		global $mstore;
		$mstore->add_right_button($key,$value);
	}	
}
if(!function_exists('mbw_add_right_buttons')){
	function mbw_add_right_buttons($params){
		global $mstore;
		$mstore->add_right_buttons($params);
	}	
}
if(!function_exists('mbw_get_right_button')){
	function mbw_get_right_button($key){
		global $mstore;
		return $mstore->get_right_button($key);
	}	
}

if(!function_exists('mbw_is_user_pid')){
	function mbw_is_user_pid($mode="equal"){
		global $mstore;
		return $mstore->is_user_pid($mode);
	}	
}
if(!function_exists('mbw_is_ssl')){
	function mbw_is_ssl(){
		global $mstore;
		return $mstore->get_auth_secure();
	}	
}

if(!function_exists('mbw_get_add_query')){
	function mbw_get_add_query($sData,$wData=null,$oData=null){
		global $mstore;
		return $mstore->get_add_query($sData,$wData,$oData);
	}	
}


?>