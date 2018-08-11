<?php
//스킨 설정 파일

//default list type (list,gallery,calendar) : 처음에 불러올 리스트 파일명과 동일
if(empty($_GET["list_type"])){
	$list_type					= "list";
	$this->set_list_type($list_type);
}else{
	$list_type					= $_GET["list_type"];
}


// 게시판 아이템 필터 적용 (모든 아이템에 적용)
if(!function_exists('mbw_board_skin_init')){
	function mbw_board_skin_init(){

		if(mbw_get_param("mode")=="list"){
			$list_type		= mbw_get_param("list_type");
			if($list_type=="list"){

			}else if($list_type=="gallery"){
				mbw_set_board_where(array("field"=>"fn_image_path", "value"=>"", "sign"=>"!="));		//이미지가 없는 글 제외
				mbw_set_board_where(array("field"=>"fn_is_secret", "value"=>"0", "sign"=>"="));			//비밀글 제외
			}else if($list_type=="calendar"){

			}
		}else if(mbw_get_param("mode")=="view"){
		}else if(mbw_get_param("mode")=="write"){
		}
	}
}
add_action('mbw_board_header', 'mbw_board_skin_init');


loadScript(MBW_SKIN_URL."js/common.js");
loadStyle(MBW_SKIN_URL."css/style.css");


?>