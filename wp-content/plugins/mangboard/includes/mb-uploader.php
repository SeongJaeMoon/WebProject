<?php
define("MBW_REQUEST_MODE", "API");
if(!defined('_MB_')) exit();

$mode			= "";
if(isset($_REQUEST["mode"])) $mode		= $_REQUEST["mode"];

$file_name			= "";
$file_url				= "";
$file_ext				= "";

$uploadPath		= MBW_UPLOAD_PATH;
$error_check		= false;
$datePath			= date("Y/m/d/",mbw_get_timestamp());
$file_pid				= "";

if($mode=="html5"){
	$sFileInfo = '';
	$headers = array();	 
	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		} 
	}
	if(!empty($headers)){
		$upload_data				= mbw_file_upload(array("board_name"=>"N","table_name"=>"N","board_pid"=>"0","type"=>"editor"),$headers);
		$file_name					= $upload_data["name"];

		if(!empty($upload_data["path"])){
			$sFileInfo .= "&bNewLine=true";
			$sFileInfo .= "&sFileName=".rawurlencode($file_name);
			$sFileInfo .= "&sFileURL=".rawurlencode(mbw_get_image_url("path",$upload_data["path"]));
			echo $sFileInfo;
		}else{
			echo "NOTALLOW_".$file_name;
		}
	}
}else if($mode=="flash"){
	if(!empty($_FILES["Filedata"]) && mbw_check_api_file("editor")) {
		$upload_data	= mbw_file_upload(array("board_name"=>"N","table_name"=>"N","board_pid"=>"0","type"=>"editor"));
		$file_name		= $upload_data["name"];

		if($mstore->get_result_data("state")=="error"){
			echo mbw_data_encode($mstore->result_data);
		}else if(!empty($upload_data["path"])){
			$file_data					= array();
			$file_data["name"]		= $file_name;
			$file_data["url"]			= mbw_get_image_url("url",$upload_data["path"]);

			$mstore->set_result_data(array("data"=>$file_data));
			echo mbw_data_encode($mstore->get_result_datas(array("state"=>"success")));	
		}else echo mbw_data_encode($mstore->result_data);
	}else if($mstore->get_result_data("state")=="error"){
		echo mbw_data_encode($mstore->result_data);
	}
}else if($mode=="plugin"){
	do_action('mbw_uploader_plugin');
}else{
	if((!empty($_FILES["Filedata"]) || !empty($_FILES["upload"]))&& mbw_check_api_file("editor")) { 		
		$upload_data	= mbw_file_upload(array("board_name"=>"N","table_name"=>"N","board_pid"=>"0","type"=>"editor"));
		$file_name		= $upload_data["name"];		
		if(!empty($upload_data["path"])){
			if(!empty($_FILES["upload"]) && !empty($_REQUEST['CKEditorFuncNum'])){
				$funcNum		= mbw_get_param('CKEditorFuncNum');
				$url				= mbw_get_image_url("path",$upload_data["path"]);
				$message		= '';
				echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(".$funcNum.", '$url', '$message');</script>";
			}else{
				$url = $_REQUEST["callback"].'&callback_func='.$_REQUEST["callback_func"];			
				$url .= "&bNewLine=true";
				$url .= "&sFileName=".rawurlencode($file_name);
				$url .= "&sFileURL=".rawurlencode(mbw_get_image_url("path",$upload_data["path"]));
				header('Location: '. $url);
			}
		}else echo $mstore->get_result_data("message");
	}else if($mstore->get_result_data("state")=="error"){
		echo $mstore->get_result_data("message");
	}	
}
exit;
?>