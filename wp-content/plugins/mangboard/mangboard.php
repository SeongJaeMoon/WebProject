<?php
/**
 * Plugin Name: MangBoard WP
 * Plugin URI: http://www.mangboard.com/
 * Description: MangBoard WP는 Wordpress에서 게시판을 생성/관리 할 수 있는 기능을 제공합니다
 * Version: 1.5.7
 * Author: Hometory
 * Author URI: http://www.hometory.com/
 */

if(!function_exists( 'add_filter' )) return;
define("_MB_", true);

$site_url		= site_url();
define("MBW_SITE_URL", $site_url);
define("MBW_HOME_URL", home_url());
$auth_site_url		= str_replace(array("http://","https://"), "", MBW_HOME_URL);
if(strpos($auth_site_url, ':') !== false)	$auth_site_url	= substr($auth_site_url,0,strpos($auth_site_url, ':'));
define("MBW_AUTH_SITE_URL", $auth_site_url);
define("MBW_CONTENT_URL", content_url());
define("MBW_PLUGIN_URL", plugins_url('', __FILE__)."/");

define("MBW_PLUGIN_DIR", "mangboard");
define("MBW_UPLOAD_PATH", WP_CONTENT_DIR."/uploads/mangboard/");
define("MBW_LOG_PATH", WP_CONTENT_DIR."/uploads/mangboard/log/");
define("MBW_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("MBW_PLUGIN_FILE", __FILE__);


define("MBW_SECURE_AUTH_COOKIE", "mb_sec_".md5(MBW_AUTH_SITE_URL));
define("MBW_AUTH_COOKIE", "mb_".md5(MBW_AUTH_SITE_URL));
define("MBW_SHORTCODE_BOARD", "mb_board");
define("MBW_QUERY_LOG", false);
define("MBW_PARAM_LOG", false);


require_once(MBW_PLUGIN_PATH."includes/mb-settings.php");
if(empty($mstore)) return;

if(!function_exists('mbw_init')){
	function mbw_init(){	
		mbw_add_trace("mbw_init");
		global $mb_options;
		global $mstore,$mb_vars;			
		if(function_exists ('load_plugin_textdomain')){
			if($mb_options["wp_multi_language"])
				load_plugin_textdomain ('mangboard', false, MBW_PLUGIN_PATH . '/includes/languages/');
		}
		mbw_set_params();
		if(mbw_get_access_token()==""){
			mbw_generate_access_token();
			if($mstore->is_login_cookie()) mbw_refresh_auth_cookie();
		}
		global $current_user;
		if(get_current_user_id()!=0){
			if(!$mstore->is_login_cookie()){
				mbw_generate_auth_cookie($current_user->data->user_login,"WP");
			}else if(!mbw_validate_auth_cookie()){
				mbw_clear_auth_cookie();
				mbw_generate_auth_cookie($current_user->data->user_login,"WP");
			}
		}else if($mstore->is_login_cookie()){
			if(mbw_validate_auth_cookie()){
				$cookie					= $mstore->get_login_cookie();
				$cookie_elements		= explode('|', $cookie);
				list($user_id, $expiration, $hmac, $user_mode) = $cookie_elements;
				mbw_set_wp_user_data($user_id);
				if($user_mode=="WP") mbw_logout("MB",false);
			}else{
				mbw_clear_auth_cookie();
			}
		}
		mbw_is_permission_level();
		if(is_admin() && !empty($_GET["page"])){
			$page_name		= $_GET["page"];
			if(strpos($page_name, 'mbw_')===0 && $page_name!="mbw_dashboard" && $page_name!="mbw_commerce_dashboard" && $page_name!="mbw_commerce_category"){
				$mstore->set_board_options(mbw_get_admin_board_name());
			}
		}
	}
}
add_action('init', 'mbw_init', 0);

// 사용자 javascript  파일 호출
if(!function_exists('mbw_load_scripts')){
	function mbw_load_scripts(){
		global $mb_scripts,$mb_styles; 
		$mb_scripts[]		= mbw_init_javascript();
		$mb_styles[]		= mbw_init_style();		
		if(mbw_get_trace("mbw_print_scripts")!="" && !empty($mb_scripts)){
			mbw_print_scripts();
		}
	}
}
add_action('wp_enqueue_scripts', 'mbw_load_scripts',1);
add_action('admin_enqueue_scripts', 'mbw_load_scripts',1);
add_action('wp_print_scripts', 'mbw_print_scripts',3);
add_action('wp_footer', 'mbw_print_scripts',1);



// 관리자 메뉴설정
if(!function_exists('mbw_create_board_menu')){
	function mbw_create_board_menu(){
		$index		= 31;
		while(!empty($GLOBALS['menu'][$index])) $index++;
		add_menu_page('MangBoard', 'MangBoard', 'administrator', 'mbw_dashboard', 'mbw_manage_page', plugins_url(MBW_PLUGIN_DIR.'/assets/images/favicon.png'), $index);
		add_submenu_page('mbw_dashboard', __MW('W_MENU_DASHBOARD'), __MW('W_MENU_DASHBOARD'), 'administrator', 'mbw_dashboard', 'mbw_manage_page');
		add_submenu_page('mbw_dashboard', __MW('W_MENU_BOARD'), __MW('W_MENU_BOARD'), 'administrator', 'mbw_board_options', 'mbw_manage_board');
		add_submenu_page('mbw_dashboard', __MW('W_MENU_USER'), __MW('W_MENU_USER'), 'administrator', 'mbw_users', 'mbw_manage_board');
		add_submenu_page('mbw_dashboard', __MW('W_MENU_OPTION'), __MW('W_MENU_OPTION'), 'administrator', 'mbw_options', 'mbw_manage_board');	
		add_submenu_page('mbw_dashboard', __MW('W_MENU_FILE'), __MW('W_MENU_FILE'), 'administrator', 'mbw_files', 'mbw_manage_board');	
		add_submenu_page('mbw_dashboard', __MW('W_MENU_ANALYTICS'), __MW('W_MENU_ANALYTICS'), 'administrator', 'mbw_analytics', 'mbw_manage_board');	
		add_submenu_page('mbw_dashboard', __MW('W_MENU_REFERER'), __MW('W_MENU_REFERER'), 'administrator', 'mbw_referers', 'mbw_manage_board');
		add_submenu_page('mbw_dashboard', __MW('W_MENU_LOG'), __MW('W_MENU_LOG'), 'administrator', 'mbw_logs', 'mbw_manage_board');
	}
}
add_action('admin_menu', 'mbw_create_board_menu',31);
if(!function_exists('mbw_create_board')){
	function mbw_create_board($args, $content=""){
		mbw_add_trace("mbw_create_board");

		global $mdb,$mstore;
		if(!empty($content)) $args["content"]		= $content;
		
		if(!isset($args['name'])){
			mbw_error_message("MSG_SEARCH_ERROR2", "ShortCode","1000");
		}else{
			if(mbw_get_param("board_name")!="" && $args['name']!=mbw_get_param("board_name")){
				return;
			}
			mbw_set_board_params($args);
		}			
		
		if(empty($args['echo'])) ob_start();
		do_action('mbw_create_board_header',$args);
		echo '<div class="clear"></div>';
		if(mbw_get_result_data("state")=="error"){
			mbw_echo_error_message();
		}else{	
			$MangBoard		= new MangBoard($mdb,$mstore);
			$MangBoard->get_board_panel($args);	
		}
		do_action('mbw_create_board_footer',$args);	
		if(empty($args['echo'])) return ob_get_clean();
	}
}
if(!function_exists('mbw_check_shortcode')){
	function mbw_check_shortcode($posts){
		if(empty($posts) || mbw_get_trace("mbw_head")!="") return $posts;
		else if(is_admin() && count($posts)!=1) return $posts;
		mbw_add_trace("mbw_check_shortcode");

		global $mstore;	
		global $mb_board_name;

		foreach($posts as $post){	
			if(strpos($post->post_content, '['.MBW_SHORTCODE_BOARD." name=") !== false){
				$post_content			= $post->post_content;
				$index1					= strpos($post_content,'['.MBW_SHORTCODE_BOARD." name=")+16;
				$index2					= strpos($post_content,"\"",$index1);
				$board_name			= trim(substr($post_content,$index1,$index2-$index1));
				if(!empty($board_name) && empty($mb_board_name)){
					$mb_board_name		= $board_name;
					mbw_init_board($mb_board_name);
				}
			}
			do_action('mbw_shortcode', $post->post_content);
		}
		if(mbw_get_trace("mbw_is_permission_level")=="") mbw_is_permission_level();	
		return $posts;
	}
}
add_shortcode(MBW_SHORTCODE_BOARD, 'mbw_create_board');
add_filter('the_posts', 'mbw_check_shortcode');
?>