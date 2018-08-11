<?php

if(!function_exists('mbw_get_tooltip_template')){
	function mbw_get_tooltip_template($data){
		if(is_array($data)){
			if(empty($data["class"])) $data["class"]				= "tooltip";
			else $data["class"]				= "mb-tooltip ".$data["class"];
			if(empty($data["text"])) return;

			if(empty($data["img"])){
				return ' <span class="'.$data["class"].'" title="'.htmlspecialchars($data["text"]).'">[?]</span>';
			}else{
				return ' <img class="'.$data["class"].'" src="'.$data["img"].'" title="'.htmlspecialchars($data["text"]).'"/>';
			}
		}else if(is_string($data)){
			return ' <span class="mb-tooltip" title="'.htmlspecialchars($data).'">[?]</span>';
		}
	}
}


?>