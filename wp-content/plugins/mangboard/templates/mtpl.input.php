<?php
// Input 태그 템플릿
if(!function_exists('mbw_get_input_template')){
	function mbw_get_input_template($mode, $data){
		global $mdb,$mstore,$mb_languages,$mb_fields;
		$template_start		= '';
		$item_type			= $data["type"];
		if(!isset($data["item_id"])) $data["item_id"]	= "";
		if(!isset($data["item_name"])) $data["item_name"]	= "";
		if(!isset($data["value"])) $data["value"]	= "";
		if(!empty($data["item_id"])) $t_id	= ' id="'.$data["item_id"].'"';
		else $t_id		= "";

		if(strpos($item_type,'file')===0){
			if($item_type=='file_download'){
				$file_data			= $mstore->get_board_files(mbw_get_board_item("fn_pid"));
				global $mb_fields;
				if(!empty($file_data)){
					foreach($file_data as $file){
						$file_size		= mbw_set_format($file[$mb_fields["files"]["fn_file_size"]],"file_size");							
						$template_start	.= '<a href="javascript:;"'.$data["ext"].__STYLE($data["style"]).' title="Download : '.$file[$mb_fields["files"]["fn_download_count"]].'" onclick="sendBoardFileData('.$file[$mb_fields["files"]["fn_pid"]].',\''.$file[$mb_fields["files"]["fn_file_name"]].'\');return false;"><span>'.$file[$mb_fields["files"]["fn_file_name"]].' <span class="file-size">('.$file_size.')</span></span></a>';
					}
				}
			}else if(strpos($item_type,'file_singular')===0){

				$img_path			= $data["value"];
				if($img_path!="" && strpos($img_path,'http')!==0){
					$img_path		= mbw_get_image_url("url_small",$img_path);
				}

				if(empty($data["img_width"])) $data["img_width"]			= "50px";
				if(empty($data["img_height"])) $data["img_height"]		= $data["img_width"];
				if(!empty($img_path)){
					$template_start	= '<a href="'.$img_path.'" target="_blank"><img'.$data["ext"].__STYLE("max-width:".$data["img_width"].";max-height:".$data["img_height"].";margin-right:10px !important;").' src="'.$img_path.'" /></a>';
				}

				if($item_type=='file_singular_upload'){
					$upload_type		= ' accept="image/*"';
					$template_start	.= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' '.$upload_type.' type="file"/>';
					if(!empty($data["value"])) $template_start	.= '<input type="hidden" name="'.$data["item_name"].'" value="'.$data["value"].'" />';
				}
			}else{
				//수정 모드에서 업로드 파일이 있을 경우 삭제버튼 표시
				if(mbw_get_param("board_action")=="modify"){
					$file			= $mstore->get_board_file(mbw_get_board_item("fn_pid"));					
					if($item_type=='file_image' && !empty($file[$mb_fields["files"]["fn_file_type"]]) && strpos($file[$mb_fields["files"]["fn_file_type"]],"image/")!==0){
						$mstore->add_board_file($file);
						$file			= $mstore->get_board_file(mbw_get_board_item("fn_pid"));					
						if($item_type=='file_image' && !empty($file[$mb_fields["files"]["fn_file_type"]]) &&  strpos($file[$mb_fields["files"]["fn_file_type"]],"image/")!==0){
							$mstore->add_board_file($file);
							$file			= null;
						}
					}	

					if(!empty($file)){
						$template_start	= '<input'.$data["ext"].__STYLE($data["style"]).' name="'.mbw_set_form_name("file_delete_pid[]").'"'.$t_id.' value="'.$file[$mb_fields["files"]["fn_pid"]].'" title="'.$file[$mb_fields["files"]["fn_file_name"]].'" type="checkbox"/>';
						$template_start	.= '<label>['.$mb_languages["W_DELETE"].'] <span>'.$file[$mb_fields["files"]["fn_file_name"]].'</span></label>';
						$template_start	.= '<input name="'.mbw_set_form_name("file_list_pid[]").'" id="'.$data["item_id"].'_pid" value="'.($file[$mb_fields["files"]["fn_pid"]]).'" type="hidden" />';

						if(!empty($data["sequence"])){
							if($data["sequence"]=="number")
								$template_start	.= ' <input style="width:45px !important;height:28px !important;text-align:center;font-size:12px;" maxlength="4" name="'.mbw_set_form_name("file_list_sequence[]").'" value="'.($file[$mb_fields["files"]["fn_file_sequence"]]).'" type="number" onkeydown="return inputOnlyNumber(event)" />';
						}
					}
				}
				if(empty($template_start)){
					$file_type		= '';
					if($item_type=='file_image') $file_type		= ' accept="image/*"';
					else if($item_type=='file_camera') $file_type		= ' capture="camera"';
					$template_start	= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="'.$data["value"].'"'.$file_type.' type="file"/>';
				}
			}
		}else if(strpos($item_type,'img')===0){
			if(!empty($data["value"])){
				$img_url			= "";
				$img_link		= "";
				$img_size		= "";
				$file_name		= "";

				if(!empty($data["size"])){
					$img_size			= $data["size"];
					$data["size"]		= "&size=".$data["size"];
				} else $data["size"]		= "";
				if(empty($data["width"])) $data["width"]			= "50px";
				if(empty($data["height"])) $data["height"]		= $data["width"];

				$file_attr					= "";
				if(strpos($data["value"],'http')===0){
					$img_url			= $data["value"];
					$img_link		= $data["value"];
				}else if(mbw_is_image_file($data["value"])){
					
					if(!empty($data["value"])) {
						$file_name		= $data["value"];
						$index1			= strpos($file_name,"_")+1;
						$file_name		= substr($file_name,$index1,strlen($file_name)-$index1);
					}
					$img_link	= mbw_get_image_url("url",$data["value"]);
					//$img_url		= mbw_get_image_url("path",$data["value"]).$data["size"];
					if(!empty($img_size)) $img_url		= mbw_get_image_url("url_".$img_size,$data["value"]);
					else $img_url		= mbw_get_image_url("url",$data["value"]);					
				}

				if(!empty($img_url)){
					if(!empty($file_name)){
						if(empty($data["alt"])) $file_attr			= $file_attr.' alt="'.$file_name.'"';
						//if(empty($data["title"])) $file_attr			= $file_attr.' title="'.$file_name.'"';
					}

					if($item_type=='img'){						
						$template_start	= '<img'.$data["ext"].__STYLE("width:".$data["width"].";height:".$data["height"].";".$data["style"]).' src="'.$img_url.'"'.$file_attr.' />';
					}else if($item_type=='img_link'){
						$template_start	= '<a href="'.$img_link.'" target="_blank"><img'.$data["ext"].__STYLE("width:".$data["width"].";height:".$data["height"].";".$data["style"]).' src="'.$img_url.'"'.$file_attr.' /></a>';
					}else if($item_type=='img_ratio'){
						$template_start	= '<img'.$data["ext"].__STYLE("max-width:".$data["width"].";max-height:".$data["height"].";".$data["style"]).' src="'.$img_url.'"'.$file_attr.'/>';
					}else if($item_type=='img_masonry'){
						$template_start	= '<img'.$data["ext"].__STYLE("width:".$data["width"].";min-height:".$data["height"].";".$data["style"]).' src="'.$img_url.'"'.$file_attr.'/>';
					}else if($item_type=='img_ratio_link'){
						$template_start	= '<a href="'.$img_link.'" target="_blank"><img'.$data["ext"].__STYLE("max-width:".$data["width"].";max-height:".$data["height"].";".$data["style"]).' src="'.$img_url.'"'.$file_attr.'/></a>';
					}else if($item_type=='img_bg'){
						if(empty($data["background-size"])) $data["background-size"] = "cover";
						if(empty($data["background-position"])) $data["background-position"] = "center center";
						if(empty($data["background-repeat"])) $data["background-repeat"] = "no-repeat";
						$template_start	= '<div'.$data["ext"].__STYLE("max-width:".$data["width"].";width:".$data["width"].";height:".$data["height"].";margin:0 auto;background-image:url(".$img_url.");background-position:".$data["background-position"].";background-size:".$data["background-size"].";background-repeat:".$data["background-repeat"].";".$data["style"]).' ></div>';
					}
				}
			}else{
				if(empty($data["width"])) $data["width"]			= "50px";
				if(empty($data["height"])) $data["height"]		= $data["width"];

				$template_start	= '<div'.__STYLE("width:".$data["width"].";height:".$data["height"].";display:table;").' class=""><div style="display:table-cell;vertical-align:middle;">No image</div></div>';
			}
		}else if(strpos($item_type,'text')===0){
			if($item_type!='textarea'){
				if($data["value"]!="" && (strpos($data["value"],"'")!==false || strpos($data["value"],'"')!==false))
					$data["value"]			= mbw_htmlspecialchars($data["value"]);
			}
			$add_attribute		= "";

			if($item_type=='textarea'){
				if(empty($data["width"])) $data["width"]	= "100%";
				if(empty($data["height"])) $data["height"]	= "60px";

				if(!empty($data["maxlength"])) 
					$add_attribute	.= ' maxlength="'.intval($data["maxlength"]).'"';

				$template_start	= '<textarea'.$data["ext"].__STYLE("width:".$data["width"].";height:".$data["height"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.$add_attribute.'>'.$data["value"].'</textarea>';
			}else if($item_type=='text_static'){
				$template_start	= '<span>'.$data["value"].'</span><input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="'.($data["value"]).'" type="hidden" />';
			}else{
				$add_attribute		= "";
				if($item_type=='text_readonly') $add_attribute		= $add_attribute." readonly";				
				else if($item_type=='text_calendar'){
					if($mode=="write" && mbw_get_param("board_action")=="write"){
						if(empty($data["value"])) $data["value"]		= mbw_get_current_date();
					}
					wp_enqueue_style('jquery-ui-css');
				}

				if(!empty($data["maxlength"])) 
					$add_attribute	= $add_attribute.' maxlength="'.intval($data["maxlength"]).'"';

				$data["value"]				= str_replace("'",'"',$data["value"]);
				if(empty($data["width"])) $data["width"]			= "90%";
				$template_start	= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="'.($data["value"]).'" type="text"'.$add_attribute.' />';
			}				

		}else if($item_type=='button'){
			$template_start	= mbw_get_btn_template($data);
		}else if($item_type=='password'){
			if(empty($data["width"])) $data["width"]			= "90%";
			$template_start	= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="" autocomplete="off" type="password" />';

		}else if($item_type=='hidden'){
			if($data["value"]!="" && (strpos($data["value"],"'")!==false || strpos($data["value"],'"')!==false))
					$data["value"]			= mbw_htmlspecialchars($data["value"]);

			$template_start	= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="'.($data["value"]).'" type="hidden" />';		
		
		//html5
		}else if($item_type=='url' || $item_type=='tel' || $item_type=='search' || $item_type=='email' || $item_type=='color'){
			$template_start	= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="'.$data["value"].'" type="'.$item_type.'" />';
		}else if($item_type=='datetime-local' || $item_type=='time' || $item_type=='week' || $item_type=='date' || $item_type=='month'){
			$template_start	= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="'.$data["value"].'" type="'.$item_type.'" />';

		}else if($item_type=='number' || $item_type=='range'){
			if(empty($data["min"])) $data["min"]			= "0";
			if(empty($data["max"])) $data["max"]			= "100";
			if(empty($data["step"])) $data["step"]			= "1";				
			$template_start	= '<input'.$data["ext"].__STYLE("width:".$data["width"].";".$data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.' value="'.$data["value"].'" type="'.$item_type.'"  min="'.$data["min"].'" max="'.$data["max"].'" step="'.$data["step"].'" />';

		}else if(strpos($item_type,'checkbox')===0){
			$delimiter			= ",";
			if(isset($data["delimiter"])) $delimiter		= $data["delimiter"];

			$t_value				= explode($delimiter,$data["value"]);
			$t_label				= explode($delimiter,$data["label"]);
			$count				= count($t_label);
			$i						= 0;
			$i_name				= mbw_set_form_name($data["item_name"]);
			$t_name				= $i_name;
			if($count>1) $t_name	= $t_name."[]";
			$template_start	.= '<input name="'.$i_name.'" value="0" type="hidden" />';
			for($i;$i<$count;$i++){
				if(!isset($t_label[$i])) $t_label[$i]		= "";

				if(isset($t_value[0]) && intval($t_value[0])==($i+1)){
					array_shift($t_value);
					$checked		= ' checked ';
				}else $checked		= '';

				$template_start	.= '<label for="'.$data["item_id"].($i+1).'"><input'.$data["ext"].__STYLE($data["style"]).' type="checkbox" name="'.$t_name.'" id="'.$data["item_id"].($i+1).'" value="'.($i+1).'" '.$checked.' />'.$t_label[$i].'</label>';
			}
			
		}else if(strpos($item_type,'radio')===0){
			$delimiter			= ",";
			if(isset($data["delimiter"])) $delimiter		= $data["delimiter"];
			$t_data				= explode($delimiter,$data["data"]);
			$t_label				= explode($delimiter,$data["label"]);
			$count				= count($t_data);
			$i						= 0;
			for($i;$i<$count;$i++){
				if(!isset($t_data[$i])) $t_data[$i]		= "";
				if(!isset($t_label[$i])) $t_label[$i]		= "";

				if($t_data[$i]==$data["value"]){
					$checked		= ' checked ';					
				}else $checked		= '';

				$template_start	.= '<label for="'.$data["item_id"].($i+1).'"><input'.$data["ext"].__STYLE($data["style"]).' type="radio" name="'.mbw_set_form_name($data["item_name"]).'" id="'.$data["item_id"].($i+1).'" value="'.$t_data[$i].'" '.$checked.' />'.$t_label[$i].'</label>';
			}
		}else if(strpos($item_type,'select')===0){
			if(!empty($data["width"])) $data["style"]		= "width:".$data["width"]." !important;".$data["style"];
			if(!isset($data["label"]) && isset($data["data"])) $data["label"]		= $data["data"];
			if(!isset($data["data"]) && isset($data["label"])) $data["data"]		= $data["label"];			
			$delimiter			= ",";
			if(isset($data["delimiter"])) $delimiter		= $data["delimiter"];
			$t_data				= explode($delimiter,$data["data"]);
			$t_label				= explode($delimiter,$data["label"]);			
			$template_start	= '<select'.$data["ext"].__STYLE($data["style"]).' name="'.mbw_set_form_name($data["item_name"]).'"'.$t_id.'>';
			$item_check		= false;
			$count				= count($t_data);

			for($i=0;$i<$count;$i++){
				if(!isset($t_data[$i])) $t_data[$i]			= "";
				if(!isset($t_label[$i])) $t_label[$i]			= "";

				$o_data		= ' value="'.$t_data[$i].'"';
				if(strpos($t_data[$i],'select-disabled-')===0){
					$o_data		= str_replace('select-disabled-','',$o_data);
					$o_data		.= ' disabled';
				}
				if($t_data[$i]==$data["value"]){
					$o_data				.= ' selected';					
					$item_check		= true;
				}
				$template_start	.= '<option'.$o_data.'>'.$t_label[$i].'</option>';
			}
			if($data["value"]!="" && !$item_check)
				$template_start	.= '<option value="'.$data["value"].'" selected>'.$data["value"].'</option>';
			$template_start	.= '</select>';

		}else if(strpos($item_type,'scheme_link')===0){
			if($item_type=="scheme_link_tel"){
				$template_start	.= '<a href="tel:'.$data["value"].'"><span>'.$data["value"].'</span></a>';
			}else if($item_type=="scheme_link_mail"){
				$template_start	.= '<a href="mailto:'.$data["value"].'"><span>'.$data["value"].'</span></a>';
			}else{
				$scheme		= str_replace("scheme_link_", "", $item_type);
				$template_start	.= '<a href="'.$scheme.':'.$data["value"].'"><span>'.$data["value"].'</span></a>';
			}

		}else if($item_type=='url_link'){
			$link_url		= $data["value"];
			if(strpos($link_url, '//') === false && strpos($link_url, '?') === false && strpos($link_url, 'http') !== 0) $link_url	= "http://".$link_url;
			$template_start	= make_clickable($link_url);
			if(!empty($data["link_target"])) $template_start	= str_replace('<a','<a target="'.$data["link_target"].'"',$template_start);			
		}else if($item_type=='tag_link'){
			if(!empty($data["value"])){
				$tag_html	= '';
				$tag			= explode(',',$data["value"]);				
				$link_url		= get_permalink();
				if(strpos($link_url, '?') === false)	$link_url		.= "?";
				else $link_url		.= "&";
				foreach($tag as $value){
					$tag_html	.= '<a href="'.$link_url.'stag='.urlencode($value).'" title="'.$value.'" class="mb-tag-item"><span>#'.$value.'</span></a>';
				}
				$template_start	= $tag_html;
			}			
		}else if($item_type=='empty'){
			$template_start	= "";
		}else if($item_type=='static' || $item_type=='view'){
			$template_start	= nl2br($data["value"]);
		}else{
			$template_start	= nl2br($data["value"]);
		}		

		return $template_start;
	}
}
?>