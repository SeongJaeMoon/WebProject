<?php

if(!function_exists('mbw_get_pagination_template')){
	function mbw_get_pagination_template($data){
		global $mstore,$mdb;

		do_action('mbw_pagination_template_header');

		$total_count		= 0;
		if(isset($data["total_count"])) $total_count				= intval($data["total_count"]);

		if(isset($data["page_size"]))
			$page_size					= intval($data["page_size"]);
		else{
			if(mbw_get_param("page_size")!=""){		
				$page_size			= intval(mbw_get_param("page_size"));
			}else{
				$page_size			= intval(mbw_get_board_option("fn_page_size"));
			}
		}
		
		if(isset($data["page_type"])) $page_type			= ($data["page_type"]);
		else if(mbw_get_param("page_type")!="")
			$page_type			= mbw_get_param("page_type");
		else $page_type		= "";

		$link_type			= "href";
		if($page_type=="ajax") $link_type			= "onclick";

		if(isset($data["block_size"]))
			$block_size					= intval($data["block_size"]);
		else{
			if(mbw_get_param("block_size")!=""){		
				$block_size			= intval(mbw_get_param("block_size"));
			}else{
				$block_size			= intval(mbw_get_board_option("fn_block_size"));
				if($block_size>=100){
					mbw_set_vars("pagination_type","more");
					$block_size		= 1;
				}
			}
		}
		if($block_size==0) return;

		if(isset($data["board_page"]))
			$board_page					= intval($data["board_page"]);
		else{
			if(mbw_get_param("board_page")!="") $board_page			= intval(mbw_get_param("board_page"));
			else $board_page			= 1;
		}

		if(!empty($data["board_name"])) $board_name			= $data["board_name"];
		else $board_name		= (mbw_get_param("board_name"));	

		
		if($total_count==0){
			$total_count		= $mdb->get_var($mstore->get_add_query(array("column"=>"count(*)"), "where"));	
		}

		$template_page			= "";
		$board_block		= floor(($board_page - 1) / $block_size) + 1;

		$total_page			= ceil($total_count / $page_size);
		$total_block		= floor(($total_page - 1) / $block_size) + 1;

		$block_first			= floor(($board_page - 1) / $block_size) * $block_size + 1;
		$block_last 			= min($total_page, $board_block * $block_size);
		
		if($board_page > $total_page){
			$board_page		= $total_page;
			mbw_set_param("board_page", $board_page);
		}

		if($total_count > 0){
			do_action('mbw_pagination_template_body');

			if(mbw_get_vars("pagination_type")=="large"){
				//리스트 페이지 네비게이션

				$page_class		= array("prev"=>"","pprev"=>"","next"=>"","nnext"=>"");
				$page_link		= array("prev"=>"","pprev"=>"","next"=>"","nnext"=>"");

				if($board_page == 1) $page_link["pprev"] = "";			
				else{
					if($link_type=="href"){
						$page_link["pprev"] = mbw_get_url(array("board_pid"=>"","board_page"=>"1"));
					}else if($link_type=="onclick"){
						$page_link["pprev"] = "sendListTemplateData({'board_name':'".$board_name."','page':'1','page_type':'ajax'})";
					}
				}
				
				if($board_block == 1) $page_link["prev"] = "";
				else {
					if($link_type=="href"){
						$page_link["prev"] = mbw_get_url(array("board_pid"=>"","board_page"=>$block_first-$block_size));
					}else if($link_type=="onclick"){
						$page_link["prev"] = "sendListTemplateData({'board_name':'".$board_name."','page':'".($block_first-$block_size)."','page_type':'ajax'})";
					}
				}
				$link_page	= "";
				$first_class	= "";		

				for($i = $block_first; $i <= $block_last; $i++){
					if($i==$block_first) $first_class		= " first";
					else $first_class		= "";

					if($i == $board_page){
						$link_page .= '<td class="btn-page active"><a class="btn-page-num'.$first_class.'">'.$i.'</a></td>' ;
					}else{
						if($link_type=="href"){
							$link_page .= '<td class="btn-page"><a class="btn-page-num'.$first_class.'" '.$link_type.'="'.mbw_get_url(array("board_pid"=>"","board_page"=>$i)).'">'.$i.'</a></td>';
						}else if($link_type=="onclick"){
							$link_page .= '<td class="btn-page"><a class="btn-page-num'.$first_class.'" '.$link_type."=\"sendListTemplateData({'board_name':'".$board_name."','page':'".$i."','page_type':'ajax'})\">".$i.'</a></td>';
						}				
						//sendListTemplateData({'board_name':$board_name,'page':$i})					
					}
				}
				if($board_block == $total_block) $page_link["next"] = "";
				else {
					if($link_type=="href"){
						$page_link["next"] = mbw_get_url(array("board_pid"=>"","board_page"=>$block_first+$block_size));
					}else if($link_type=="onclick"){
						$page_link["next"] = "sendListTemplateData({'board_name':'".$board_name."','page':'".($block_first+$block_size)."','page_type':'ajax'})";
					}				
				}
				
				if($board_page == $total_page) $page_link["nnext"] = "";
				else {
					if($link_type=="href"){
						$page_link["nnext"] = mbw_get_url(array("board_pid"=>"","board_page"=>$total_page));
					}else if($link_type=="onclick"){
						$page_link["nnext"] = "sendListTemplateData({'board_name':'".$board_name."','page':'".$total_page."','page_type':'ajax'})";
					}				
				}

				foreach($page_link as $key =>$value){
					if(empty($value)) $page_class[$key]		= ' class="page_arrow disable"';
					else $page_class[$key]		= ' class="page_arrow"';
				}
							
				$template_page	.= '<div class="pagination-large"><table cellspacing="0" cellpadding="0" border="0" class="table table-page" align="center"><tbody><tr>';
				$template_page	.= '<td'.$page_class["pprev"].'>'.mbw_get_btn_template(array("name"=>"First",$link_type=>$page_link["pprev"],"img"=>MBW_SKIN_URL."images/btn_paging_pprev.gif","class"=>"btn-start")).'</td>';
				$template_page	.= '<td'.$page_class["prev"].'>'.mbw_get_btn_template(array("name"=>"Prev",$link_type=>$page_link["prev"],"img"=>MBW_SKIN_URL."images/btn_paging_prev.gif","class"=>"btn-prev")).'</td>';
				$template_page	.= $link_page;
				$template_page	.= '<td'.$page_class["next"].'>'.mbw_get_btn_template(array("name"=>"Next",$link_type=>$page_link["next"],"img"=>MBW_SKIN_URL."images/btn_paging_next.gif","class"=>"btn-next")).'</td>';
				$template_page	.= '<td'.$page_class["nnext"].'>'.mbw_get_btn_template(array("name"=>"Last",$link_type=>$page_link["nnext"],"img"=>MBW_SKIN_URL."images/btn_paging_nnext.gif","class"=>"btn-end")).'</td>';
				$template_page	.= '</tr></tbody></table></div>';
			

			}else if(mbw_get_vars("pagination_type")=="small"){


				$page_link		= array("prev"=>"","next"=>"");
				if($link_type=="href"){
					$page_link["prev"] = mbw_get_url(array("board_pid"=>"","board_page"=>$board_page-1));
					$page_link["next"] = mbw_get_url(array("board_pid"=>"","board_page"=>$board_page+1));
				}else if($link_type=="onclick"){
					$page_link["prev"] = "sendListTemplateData({'board_name':'".$board_name."','page':'".($board_page-1)."','page_type':'ajax'})";
					$page_link["next"] = "sendListTemplateData({'board_name':'".$board_name."','page':'".($board_page+1)."','page_type':'ajax'})";
				}				

				$template_page	.= '<div class="btn-box-center pagination-small" style="">';
				if($board_page!=1) $template_page	.= ''.mbw_get_btn_template(array("name"=>"Prev",$link_type=>$page_link["prev"],"class"=>"btn btn-default")).'';
				$template_page	.= '<span class="page-num" style="">'.((($board_page-1)*$page_size)+1)." - ".((($board_page-1)*$page_size)+$page_size).'</span>';

				if($total_page>$board_page) $template_page	.= ''.mbw_get_btn_template(array("name"=>"Next",$link_type=>$page_link["next"],"class"=>"btn btn-default")).'';
				$template_page	.= '</div>';

			}else if(mbw_get_vars("pagination_type")=="more"){
				if($total_page>$board_page){
					$template_page	.= '<div id="board_add_list" class="board-add-list">'.mbw_get_btn_template(array("name"=>"More","onclick"=>"sendListTemplateData({'board_name':'".$board_name."','page':'".($board_page+1)."','page_type':'ajax','mode':'append'})","class"=>"btn btn-default btn-more")).'</div>';

				}else{
					$template_page		= "";
				}
			}else if(mbw_get_vars("pagination_type")=="bootstrap"){

				$page_class		= array("prev"=>"","pprev"=>"","next"=>"","nnext"=>"");
				$page_link		= array("prev"=>"","pprev"=>"","next"=>"","nnext"=>"");

				if($board_page == 1) $page_link["pprev"] = "";			
				else $page_link["pprev"] = mbw_get_url(array("board_pid"=>"","board_page"=>"1"));
						
				if($board_block == 1) $page_link["prev"] = "";
				else $page_link["prev"] = mbw_get_url(array("board_pid"=>"","board_page"=>$block_first-$block_size));
				$link_page	= "";
				$first_class	= "";

				for($i = $block_first; $i <= $block_last; $i++){
					if($i==$block_first) $first_class		= " first";
					else $first_class		= "";

					if($i == $board_page){
						$link_page .= '<li class="active"><a class="btn-page-num'.$first_class.'">'.$i.'</a></li>' ;
					}else{
						$link_page .= '<li><a class="btn-page-num'.$first_class.'" href="'.mbw_get_url(array("board_pid"=>"","board_page"=>$i)).'">'.$i.'</a></li>';
					}
				}
				if($board_block == $total_block) $page_link["next"] = "";
				else $page_link["next"] = mbw_get_url(array("board_pid"=>"","board_page"=>$block_first+$block_size));
				
				if($board_page == $total_page) $page_link["nnext"] = "";
				else $page_link["nnext"] = mbw_get_url(array("board_pid"=>"","board_page"=>$total_page));
				
				foreach($page_link as $key =>$value){
					if(empty($page_link[$key])) $page_class[$key]		= ' class="disable"';
				}

				$template_page	.= '<nav><ul class="pagination">';
				$template_page	.= '<li'.$page_class["pprev"].'>'.mbw_get_btn_template(array("name"=>"First","href"=>$page_link["pprev"],"img"=>MBW_SKIN_URL."images/btn_paging_pprev.gif","class"=>"btn-start")).'</li>';
				$template_page	.= '<li'.$page_class["prev"].'>'.mbw_get_btn_template(array("name"=>"Prev","href"=>$page_link["prev"],"img"=>MBW_SKIN_URL."images/btn_paging_prev.gif","class"=>"btn-prev")).'</li>';
				$template_page	.= $link_page;
				$template_page	.= '<li'.$page_class["next"].'>'.mbw_get_btn_template(array("name"=>"Next","href"=>$page_link["next"],"img"=>MBW_SKIN_URL."images/btn_paging_next.gif","class"=>"btn-next")).'</li>';
				$template_page	.= '<li'.$page_class["nnext"].'>'.mbw_get_btn_template(array("name"=>"Last".$total_count,"href"=>$page_link["nnext"],"img"=>MBW_SKIN_URL."images/btn_paging_nnext.gif","class"=>"btn-end")).'</li>';
				$template_page	.= '</ul><nav>';
			}
		}
		do_action('mbw_pagination_template_footer');
		return $template_page;
	}
}


?>