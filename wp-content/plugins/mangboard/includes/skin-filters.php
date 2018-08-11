<?php
$mb_filter_version					= "1.0.0";

// 템플릿 아이템 필터 적용 (템플릿을 통해 보여지는 아이템만 적용되는 필터)
if(!function_exists('mbw_filter_template_item')){
	function mbw_filter_template_item($item){
		global $mstore,$mb_fields;
		//검색어 키워드 Highlight 효과 설정
		if($item["field"]=="fn_title" && mbw_get_param("search_field")=="fn_title" && mbw_get_param("search_text")!="" && mbw_get_param('mode')!='write'){
			$item["value"]		= mbw_search_text_highlight(mbw_htmlspecialchars(str_replace("'", "", mbw_get_param("search_text"))),$item["value"],'<span style="background-color:#FFFF66; color:#FF0000;">\1</span>');
		}
		return $item;
	}
}
add_filter('mf_template_item', 'mbw_filter_template_item',5,1); 


// 게시판 아이템 필터 적용 (모든 아이템에 적용되는 필터)
if(!function_exists('mbw_filter_board_item')){
	function mbw_filter_board_item($item,$data=null){
		global $mstore,$mb_fields;

		if(empty($data)) return $item;

		if($item["field"]=="fn_user_name"){	//USER NAME  FILTER
			if(mbw_get_param("mode")=="write"){
				return $item;
			}

			$ip_address			= "";
			if(!empty($data["ip"])) $ip_address			= $data["ip"];

			if(!empty($data["user_pid"])){
				$item["value"]		= mbw_get_btn_template(array("name"=>$item["value"],"onclick"=>"getUserMenu('".$data["user_pid"]."','".$data[$mb_fields["board"]["fn_pid"]]."')","title"=>$item["value"]." **".substr($ip_address,2,-2)."**","class"=>"btn-user-info","type"=>"a"));
			}else{
				$item["value"]		= mbw_get_btn_template(array("name"=>$item["value"],"title"=>$item["value"]." **".substr($ip_address,2,-2)."**","class"=>"btn-user-info","type"=>"span"));
			}

			if(mbw_get_option("show_user_picture") && !empty($mb_fields["users"]["fn_user_picture"]) && !empty($data[$mb_fields["users"]["fn_user_picture"]])){
				$img_path			= $data[$mb_fields["users"]["fn_user_picture"]];
				if($img_path!="" && strpos($img_path,'http')!==0){
					//$img_path		= mbw_get_image_url("path",$img_path)."&size=small";
					$img_path		= mbw_get_image_url("url_small",$img_path);
				}

				if(!empty($img_path)){
					if(mbw_get_param("mode")!="list" || mbw_get_param("list_type")!="gallery"){		//갤러리 리스트가 아닐경우에만 회원 썸네일 표시
						$add_icon1			= '<img class="mb-user-small-picture radius-3" style="vertical-align:middle;max-width:20px;max-height:20px;" src="'.$img_path.'" /> ';
						if(!empty($data["user_pid"])) $add_icon1	= '<a href="javascript:;" onclick="getUserMenu(\''.$data["user_pid"].'\',\''.$data[$mb_fields["board"]["fn_pid"]].'\');return false;" class="btn-user-picture" role="button">'.$add_icon1.'</a>';
						$item["value"]				= $add_icon1.$item["value"];
					}
				}			
			}
			if($item["type"]!="comment"){
				if(mbw_get_option("show_user_level") && !empty($mb_fields["users"]["fn_user_level"]) && !empty($data[$mb_fields["users"]["fn_user_level"]])){
					$level_item		= mbw_get_level_item($data[$mb_fields["users"]["fn_user_level"]]);
					$item["value"]			= $item["value"].$level_item;
				}
			}

		}else if($item["field"]=="fn_content"){		//CONTENT FILTER
			if(!empty($mb_fields["select_board"]["fn_data_type"]) && !empty($data[$mb_fields["select_board"]["fn_data_type"]]) && ($data[$mb_fields["select_board"]["fn_data_type"]]=="html") || mbw_get_board_option("fn_editor_type")=="H"){
				//html 에디터로 작성된 글만 디코드
				$item["value"]			= mbw_htmlspecialchars_decode($item["value"]);
				if((mbw_get_param("mode")=="list" || mbw_get_param("mode")=="view") && function_exists('mbw_replace_image_url')) $item["value"]			= mbw_replace_image_url($item["value"]);
			}else if($item["type"]!="comment" && mbw_get_param("mode")!="write"){
				$item["value"]			= nl2br($item["value"]);
			}

			if(!empty($mb_fields["select_board"]["fn_editor_type"]) && !empty($data[$mb_fields["select_board"]["fn_editor_type"]]) && $data[$mb_fields["select_board"]["fn_editor_type"]]=="W"){
				//워드프레스 에디터에서 작성된 게시물에만 shortcode 허용
				//$item["value"]				= do_shortcode($item["value"]);
			}

	/*     wordpress-https 플러그인 기능에 포함되어 있어 주석처리  */
	//		if(mbw_get_option("ssl_mode")){
	//			//SSL 주소 매칭
	//			$parse_url					= parse_url("http://".$_SERVER['HTTP_HOST']);
	//			if(mbw_is_ssl()){	//Https 프로토콜 접속일 경우 http => https로 교체
	//				$search_text		= "http://".$parse_url["host"];
	//				$replace_text		= "https://".$parse_url["host"];
	//				if(mbw_get_option("ssl_port")!="" && mbw_get_option("ssl_port")!="443")
	//					$replace_text		.= ":".mbw_get_option("ssl_port");
	//				$item["value"]		= str_replace($search_text,$replace_text,$item["value"]);
	//			}else{		//Http 프로토콜 접속일 경우 https => http로 교체
	//				$search_text		= "https://".$parse_url["host"];
	//				if(mbw_get_option("ssl_port")!="" && mbw_get_option("ssl_port")!="443")
	//					$search_text		.= ":".mbw_get_option("ssl_port");
	//				$replace_text		= "http://".$parse_url["host"];
	//				$item["value"]		= str_replace($search_text,$replace_text,$item["value"]);
	//			}
	//		}
			if(function_exists('make_clickable')){		// URL주소에 <a> 태그 링크 설정
				if($item["type"]=="comment"){
					$item["value"]			= str_replace("&#039;", "'", $item["value"]);
					$item["value"]			= str_replace("&quot;", '"', $item["value"]);
				}
				if((!empty($data["editor_type"]) && $data["editor_type"]!="S") || $item["type"]=="comment"){
					$item["value"]			= make_clickable($item["value"]);
				}
			}

		}else if($item["field"]=="fn_title"){			//TITLE  FILTER
		}
		
		return $item;
	}
}
add_filter('mf_board_item', 'mbw_filter_board_item',1,2); 



?>