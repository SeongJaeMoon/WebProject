<?php
//PHP안티웹셸 환경인지 확인
if(!empty($_GET["board_action"] && $_GET["board_action"]=="img")){
	echo "success";exit;
}

$session = @session_id();
if(empty($session)) @session_start();
if(!empty($_GET["mode"])){
	$mode		= $_GET["mode"];
	if(!empty($_GET["board_action"]))
		$mode		= $mode."_".$_GET["board_action"];
}else
	$mode		= "mb";

require(dirname(__FILE__).'/class.kcaptcha.php');
$captcha = new KCAPTCHA();

$_SESSION[$mode.'_captcha_keystring']	= $captcha->getKeyString();
$_SESSION[$mode.'_captcha_time']		= time();

?>