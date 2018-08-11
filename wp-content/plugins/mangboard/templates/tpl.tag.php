<?php
if(!function_exists('mbw_get_tag_template')){
	function mbw_get_tag_template($data){
		global $mb_tags;
		$template_tag	= "";
		if(empty($data["tag_id"])) $data["tag_id"]	= "";

		$template_html		= "";
		if($data["tag_name"]=="table"){
			$template_start	= '<table  cellspacing="0" cellpadding="0" border="0" id="'.$data["tag_id"].'" '.$data["ext"].__STYLE($data["style"]).'><caption>'.$data["name"].'</caption>';

			if(!empty($data["width"])){
				$template_start	.= '<colgroup>';
				$cols_width			= explode(",",$data["width"]);
				$cols_count		= count($cols_width);
				if($cols_count>1){
					for($i=0;$i<$cols_count;$i++){
						if($cols_width[$i]!="" && $cols_width[$i]!="*")
							$template_start	.= '<col style="width:'.$cols_width[$i].'"/>';
						else
							$template_start	.= '<col />';
					}
				}
				$template_start	.= '</colgroup>';
			}
			$template_start	.= '<tbody>';
			$template_end	= '</tbody></table>';
		}else if($data["tag_name"]=="script"){
			$template_html			= $data["text"];
			if(!empty($data["load"]) && $data["load"]=="ready") $template_html		= 'jQuery(document).ready(function(){'.$template_html.'});';
			$template_start	= '<script type="text/javascript">';
			$template_end		= '</script>';
		}else{
			if(empty($data["mode_type"]) && !empty($data["type"])){			
				$template_html		= mbw_get_item_template("tag",$data);
			}
			if(!empty($template_html))  $template_start	= '<'.$data["tag_name"].$data["td_class"].__STYLE($data["td_style"]).' id="'.$data["tag_id"].'">';
			else $template_start	= '<'.$data["tag_name"].$data["ext"].__STYLE($data["style"]).' id="'.$data["tag_id"].'">';			
			if(!empty($data["text"])) $template_start	.= $data["text"];
			$template_end	= '</'.$data["tag_name"].'>';
		}	
		

		$template_tag				= $template_start.$template_html.$template_end;
		if(isset($data["type"])){
			if($data["type"]=='start'){
				$template_tag		= $template_start.$template_html;
				array_push($mb_tags, $data["tag_name"]);
			}else if($data["type"]=='end'){
				$template_tag		= $template_end.$template_html;
				if(!empty($mb_tags)) array_pop($mb_tags);
			}else if($data["type"]=='start-end'){
				$template_tag		= $template_start.$template_html.$template_end;
			}else if($data["type"]=='end-start'){
				$template_tag		= $template_end.$template_start.$template_html;
			}
		}
		return $template_tag;
	}
}
?>