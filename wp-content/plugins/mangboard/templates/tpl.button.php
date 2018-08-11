<?php

if(!function_exists('mbw_get_btn_template')){

	function mbw_get_btn_template($data, $args=NULL){
		global $mb_words;
		$start_tag				= "<span>";
		$end_tag				= "</span>";
		$main_tag				= "";
		$btn_type				= "button";
		$btn_attribute			= "";
		$btn_name				= "";

		if(!empty($args["start"])) $start_tag			= $args["start"];
		if(!empty($args["end"])) $end_tag			= $args["end"];
		if(!empty($data["type"])) $btn_type			= $data["type"];
				
		if(!empty($data["name"])){
			if(isset($mb_words[$data["name"]])) 
				$btn_name		= __MW($mb_words[$data["name"]]);
			else $btn_name		= __MW($data["name"]);
			$main_tag		= $main_tag.$btn_name;
		}
		if(!empty($data["add_name"])){
			$main_tag		= $main_tag.$data["add_name"];
		}

		if(!empty($data['img'])){
			$main_tag		= '<img src="'.$data['img'].'" alt="'.$main_tag.'"';
			if(!empty($args['width'])) $main_tag		= $main_tag.' width="'.$args['width'].'"';
			if(!empty($args['height'])) $main_tag		= $main_tag.' height="'.$args['height'].'"';
			$main_tag		= $main_tag.' />';		
			$btn_type		= "a";
		}

		if($btn_type=="a"){
			$btn_attribute			= ' role="button"';
		}else if($btn_type=="button"){
			$btn_attribute			= ' type="button"';
		}

		$template_btn				= "<".$btn_type;	

		if(!empty($data['href'])){
			if($btn_type=="a"){
				$template_btn	.= ' href="'.$data['href'].'"';			
			}else if($btn_type=="button"){
				$template_btn	.= ' onclick="movePage(\''.$data['href'].'\');return false;"';
			}
		}else if(!empty($data['onclick'])){
			if($btn_type=="a"){
				$template_btn	= $template_btn.' href="javascript:;" onclick="'.$data['onclick'].';return false;"';
			}else{
				$template_btn	= $template_btn.' onclick="'.$data['onclick'].';return false;"';
			}			
		}

		if(!empty($data['title'])){
			if(strpos($data['title'], 'title=') === false){
				$template_btn	.= ' title="'.$data['title'].'"';
			}else{
				$template_btn	.= ' '.$data['title'].'';
			}		
		}
		if(!empty($data['class'])){
			if(strpos($data['class'], 'class=') === false){
				$template_btn	.= ' class="'.$data['class'].'"';
			}else{
				$template_btn	.= ' '.$data['class'].'';
			}		
		}

		if(!empty($data['style'])) $template_btn	.= ' style="'.$data['style'].'"';
		
		else $template_btn	.= ' title="'.$btn_name.'"';

		$template_btn				= $template_btn.$btn_attribute.'>'.$start_tag.$main_tag.$end_tag.'</'.$btn_type.'>';
		return $template_btn;
	}

}


?>