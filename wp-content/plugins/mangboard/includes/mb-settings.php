<?php
if(!function_exists('mbw_get_require_path')){
	function mbw_get_require_path($dir_name,$type="dir"){
		if(strpos($type, 'theme_')===0) $path					= get_stylesheet_directory()."/".MBW_PLUGIN_DIR."/".$dir_name;
		else $path					= MBW_PLUGIN_PATH.$dir_name;				
		$require_path				= array();
		if(!is_dir($path)) return $require_path;

		$dir							= dir($path);
		if($type=="dir" || $type=="theme_dir"){
			while (false !== ($entry = $dir->read())){
				if(is_dir($path."/".$entry)){
					if(is_file($path."/".$entry."/".$entry.".php"))
						$require_path[]		= $path."/".$entry."/".$entry.".php";			
					else if(is_file($path."/".$entry."/index.php"))
						$require_path[]		= $path."/".$entry."/index.php";			
				}
			}
		}else if($type=="file" || $type=="theme_file"){
			while (false !== ($entry = $dir->read())){				
				if(is_file($path.$entry))
					$require_path[]		= $path.$entry;
			}
		}
		return $require_path;
	}
}
require(MBW_PLUGIN_PATH."includes/mb-version.php");
require(MBW_PLUGIN_PATH."includes/mb-config.php");
require(MBW_PLUGIN_PATH."includes/mb-fields.php");			
require(MBW_PLUGIN_PATH."includes/mb-options.php");

$http_user_agent		= "";
if(!empty($_SERVER['HTTP_USER_AGENT'])) $http_user_agent		= $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(iPad|Android 3.0|Xoom|SCH-I800|Playbook|Tablet|Kindle)/i', $http_user_agent,$matches)){
	$mb_vars["user_agent"]				= "t_".$matches[0];
	$mb_vars["device_type"]			= "tablet";
	$mb_vars["pagination_type"]		= "large";
}else if(preg_match('/(iPhone|iPad|iPod|Android|Opera Mini|Opera Mobi|SymbianOS|Windows CE|BlackBerry|UP.Browser|Silk|Nokia|SonyEricsson|webOS|PalmOS|Windows Phone|IEMobile|POLARIS|Mobile)/i', $http_user_agent,$matches)){
	$mb_vars["user_agent"]				= "m_".$matches[0];
	$mb_vars["device_type"]			= "mobile";
	$mb_vars["pagination_type"]		= "small";
}else if(preg_match('/(MSIE|Firefox|Safari|Chrome|Trident)/i', $http_user_agent,$matches)){
	$mb_vars["user_agent"]				= "d_".$matches[0];
	$mb_vars["device_type"]			= "desktop";	
	$mb_vars["pagination_type"]		= "large";
}else{
	if(!empty($http_user_agent)) $mb_vars["user_agent"]				= "d_".substr($http_user_agent,0,25);
	else $mb_vars["user_agent"]		= "d_n";
	$mb_vars["device_type"]			= "desktop";
	$mb_vars["pagination_type"]		= "large";
}

require_once(MBW_PLUGIN_PATH."includes/mb-actions.php");

if(is_file(MBW_PLUGIN_PATH."includes/languages/mb-languages-".$mb_options["locale"].".php")){
	require_once(MBW_PLUGIN_PATH."includes/languages/mb-languages-".$mb_options["locale"].".php");
}else if(is_file(MBW_PLUGIN_PATH."includes/languages/mb-languages.php")){
	require_once(MBW_PLUGIN_PATH."includes/languages/mb-languages.php");
}

// func directory files include
require_once(MBW_PLUGIN_PATH."includes/functions/func.util.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.store.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.template.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.admin.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.user.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.api.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.plugin.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.table.php");
require_once(MBW_PLUGIN_PATH."includes/functions/func.board.php");

require_once(MBW_PLUGIN_PATH."includes/class.db.php");					// DB Class
require_once(MBW_PLUGIN_PATH."includes/class.store.php");				// Store Class


//플러그인 활성화일 경우 설치파일 불러옴
if(is_admin() && !empty($_REQUEST["action"])){
	if($_REQUEST["action"]=="activate"){
		require(MBW_PLUGIN_PATH."includes/install/basic-install.php");
		$require_files		= mbw_get_require_path("includes/install/plugins/","file");
		if(!empty($require_files)){
			foreach($require_files  as $value){
				require_once($value);
			}
		}
		return;
	}else if($_REQUEST["action"]=="deactivate"){
		if(!empty($_REQUEST["plugin"]) && strpos($_REQUEST["plugin"], 'mangboard')!==false){
			delete_option('mb_user_synchronize_index');
			delete_option('mb_security_mode');
			@setcookie(MBW_AUTH_COOKIE, "", 0, "/", "",is_ssl(),true);
			@setcookie(MBW_SECURE_AUTH_COOKIE, "", 0, "/", "",is_ssl(),true);
		}
	}
}

if(empty($wpdb)) return;
$mdb					= new DBConnect($wpdb);
$mstore					= new MStore($mdb,$mb_options);
$mstore->set_messages($mb_languages);

if(!mbw_is_admin_page()){
	if($mstore->table_exists($mb_admin_tables["access_ip"])){
		mbw_is_access_ip($_SERVER["REMOTE_ADDR"]);		//접근 허용한 IP인지 검사
	}
}
$require_files		= mbw_get_require_path("plugins/");

if(!empty($require_files)){
	foreach($require_files  as $value){
		require_once($value);
	}
}
 

if((defined("MBW_REQUEST_MODE") && (MBW_REQUEST_MODE=="API")) || !empty($_REQUEST["action"])){
	// Api mode	
	error_reporting(0);
	@ini_set('display_errors',0);
	$mb_request_mode			= "API";
	mbw_set_params();
	mbw_check_request_size();	
	mbw_is_permission_level();	
}
require_once(MBW_PLUGIN_PATH."includes/class.board.php");			// Board Class
if(!empty($_REQUEST["mb_ext"])) { error_reporting(0); @ini_set('display_errors',0);}

$require_files		= array();
if(mbw_get_option("editor_mode") && $mb_request_mode=="Frontend"){
	$require_files		= array_merge($require_files,mbw_get_require_path("plugins/editors/"));
}
if(mbw_get_option("widget_mode") && ($mb_request_mode=="Frontend" || mbw_get_param("widget-id")!="")){
	$require_files		= array_merge($require_files,mbw_get_require_path("plugins/widgets/"));
}

if(!empty($require_files)){
	foreach($require_files  as $value){
		require_once($value);
	}
}

//PHP 안티웹셸 환경인지 체크하기
if(empty($_COOKIE['mb_security_mode'])){	
	if(get_option('mb_security_mode')!=''){
		mbw_set_cookie("mb_security_mode", intval(get_option('mb_security_mode')));
	}else{
		//$_REQUEST["mode"] 로 확인해야 값이 넘어옴 - mbw_get_param("mode") 함수 사용금지
		$mode		= '';
		if(!empty($_REQUEST["mode"])){
			$mode		= $_REQUEST["mode"];
		}	
		if($mode!="check"){
			if(function_exists('curl_init')){
				mbw_set_cookie("mb_security_mode", 1);			
				$kcaptcha_url		= mbw_get_option("kcaptcha_image_url").'?mode=check&board_action=img';
				$curl_handle		= curl_init();   
				curl_setopt($curl_handle, CURLOPT_URL, $kcaptcha_url); 
				curl_setopt($curl_handle, CURLOPT_HEADER, 0);
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				$response = trim(curl_exec($curl_handle)); 	
				if($response==="success") $security_mode		= 2;
				else{		
					$kcaptcha_url		= MBW_HOME_URL.'/?mb_ext=captcha&mode=check&board_action=img';
					$curl_handle		= curl_init();   
					curl_setopt($curl_handle, CURLOPT_URL, $kcaptcha_url);
					curl_setopt($curl_handle, CURLOPT_HEADER, 0);
					curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
					$response = (curl_exec($curl_handle)); 
					if($response!==trim($response)) $security_mode	= 1;
					else $security_mode	= 3;
				}
				curl_close($curl_handle);
			}else{
				$security_mode		= 2;
			}
			update_option('mb_security_mode',$security_mode);
			mbw_set_cookie("mb_security_mode", $security_mode);			
		}
	}
}
if(MBW_PARAM_LOG) log_trace("ALL_REQUEST");
?>