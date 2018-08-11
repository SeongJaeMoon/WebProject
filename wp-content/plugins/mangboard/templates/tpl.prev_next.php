<?php

if(!function_exists('mbw_get_prev_next_html')){
	function mbw_get_prev_next_html($data){
		global $mstore,$mdb;
		global $mb_fields,$mb_board_table_name;
		$prev_next_html	= '';
		
		$field_check			= false;		
		if(!empty($data["field"])){
			if(strpos($data["field"], 'fn_pid') !== false){
				$data["field"]		= $data["field"].",fn_pid";
			}
			$pn_fields				= explode(",",$data["field"]);			
			$pn_count				= count($pn_fields);
			$field_check			= true;
			for($i=0;$i<$pn_count;$i++){
				if(empty($mb_fields["select_board"][$pn_fields[$i]]))
					$field_check			= false;
			}
		}

		if($field_check){
			if(mbw_is_user_join()) $join_query		= "b.";
			else $join_query					= "";

			$where_query				= mbw_get_add_query("where_join");			
			$order_next_query		= mbw_get_add_query("order_join");

			$order_prev_query		= str_replace( "asc", "d2esc", $order_next_query );
			$order_prev_query		= str_replace( "desc", "asc", $order_prev_query );
			$order_prev_query		= str_replace( "d2esc", "desc", $order_prev_query );

			if($where_query==""){
				$where_query		= " WHERE ";				
			}else{
				$where_query		= $where_query." AND ";				
			}
			if(isset($mb_fields["select_board"]["fn_gid"]) && isset($mb_fields["select_board"]["fn_reply"]) && mbw_get_param("order_by")=="fn_pid"){
				$check_field1		= "fn_gid";
				$check_field2		= "fn_reply";
			}else{
				$check_field1		= mbw_get_param("order_by");
				$check_field2		= "fn_pid";
			}

			if(mbw_get_param("order_type")=="desc"){
				$check_sign1		= ">";
				$check_sign2		= "<";
			}else{
				$check_sign1		= "<";
				$check_sign2		= ">";
			}
			if($check_field2=="fn_reply"){
				$check_sign3		= "<";
				$check_sign4		= ">";
			}else{
				$check_sign3		= ">";
				$check_sign4		= "<";
			}

			if($check_field1==$check_field2){ //1차 단순 정렬일 경우
				$prev_add_query	= "((".$join_query.$mb_fields["select_board"][$check_field1].$check_sign1."'".mbw_get_board_item($check_field1,false)."'))";
				$next_add_query	= "((".$join_query.$mb_fields["select_board"][$check_field1].$check_sign2."'".mbw_get_board_item($check_field1,false)."'))";
			}else { //2차 정렬일 경우
				$prev_add_query	= "((".$join_query.$mb_fields["select_board"][$check_field1].$check_sign1."'".mbw_get_board_item($check_field1,false)."') or (".$join_query.$mb_fields["select_board"][$check_field1]."='".mbw_get_board_item($check_field1,false)."' AND ".$join_query.$mb_fields["select_board"][$check_field2].$check_sign3.mbw_get_board_item($check_field2,false)."))";
				$next_add_query	= "((".$join_query.$mb_fields["select_board"][$check_field1].$check_sign2."'".mbw_get_board_item($check_field1,false)."') or (".$join_query.$mb_fields["select_board"][$check_field1]."='".mbw_get_board_item($check_field1,false)."' AND ".$join_query.$mb_fields["select_board"][$check_field2].$check_sign4.mbw_get_board_item($check_field2,false)."))";
			}			

			$prev_html			= "";
			$next_html			= "";
			$current_html		= "";
			$title_text			= "";
			$prev_size			= intval(mbw_get_option("prev_next_size"));
			$next_size			= $prev_size;
			
			//현재 게시물의 페이지 재설정
			$prev_count		= $mdb->get_var("select count(*) from ".$mb_board_table_name.str_replace( $join_query, "", $where_query).str_replace( $join_query, "", $prev_add_query));
			$board_page		= ceil(($prev_count+1)/intval(mbw_get_board_option("fn_page_size")));
			mbw_set_param("board_page", $board_page);

			$select_query		= mbw_get_add_query(array("column"=>"*"));
			$prev_items		= $mdb->get_results($select_query.$where_query.$prev_add_query.$order_prev_query." limit ".$prev_size, ARRAY_A);
			$next_items		= $mdb->get_results($select_query.$where_query.$next_add_query.$order_next_query." limit ".$next_size, ARRAY_A);
						
			$secret_icon		= ' <img class="list-i-secret" alt="secret" src="'.MBW_SKIN_URL.'images/icon_secret.gif" /> ';
			$add_start_icon	= "";
			$add_end_icon	= "";

			foreach($prev_items as $prev_item){
				$prev_html		= $prev_html.'<tr>';
				$prev_html		= $prev_html.mbw_get_prev_next_template("prev",$data["field"],$prev_item,false);
				$prev_html		= $prev_html.'</tr>';				
			}
			$current_html		= $current_html.'<tr>';
			$current_html		= $current_html.mbw_get_prev_next_template("current",$data["field"],mbw_get_board_item(),false);
			$current_html		= $current_html.'</tr>';

			foreach($next_items as $next_item){
				$next_html		= $next_html.'<tr>';
				$next_html		= $next_html.mbw_get_prev_next_template("next",$data["field"],$next_item,false);
				$next_html		= $next_html.'</tr>';				
			}
			
			$prev_next_html	= $prev_next_html.'<div class="prev_next_style"><table cellspacing="0" cellpadding="0" border="0" class="table table-prev-next">';
			$prev_next_html	= $prev_next_html.'<colgroup>';
			$cols_width			= explode(",",$data["width"]);
			$count				= count($cols_width);
			for($i=0;$i<$count;$i++){
				if($cols_width[$i]!="" && $cols_width[$i]!="*")
					$prev_next_html	= $prev_next_html.'<col style="width:'.$cols_width[$i].'"/>';
				else
					$prev_next_html	= $prev_next_html.'<col />';
			}
			$prev_next_html	= $prev_next_html.'</colgroup><tbody>'.$prev_html.$current_html.$next_html.'</tbody>';
			$prev_next_html	= $prev_next_html.'</table></div>';
		}
		return $prev_next_html;
	}
}

if(!function_exists('mbw_get_prev_next_template')){
	function mbw_get_prev_next_template($mode,$fields,$data,$echo=true){
		global $mb_fields,$mb_languages;

		$template_start		= '';
		$template_end			= '';
		$pn_fields				= explode(",",$fields);
		$pn_count				= count($pn_fields);
		$secret_icon			= ' <img class="list-i-secret" alt="secret" src="'.MBW_SKIN_URL.'images/icon_secret.gif" /> ';

		if($mode=="prev") $name		= $mb_languages["W_PREV"];
		else if($mode=="next") $name		= $mb_languages["W_NEXT"];
		else $name		= "-";

		$template_start	.= '<th scope="row"><span>'.$name.'</span></th>';
		for($i=0;$i<$pn_count;$i++){	

			$item_name	= str_replace('fn_','',$pn_fields[$i]);
			$template_start	.= '<td class="pn_'.$item_name.'">';
			
			$filter_item		= apply_filters("mf_board_item", array("value"=>$data[$mb_fields["select_board"][$pn_fields[$i]]],"field"=>$pn_fields[$i],"type"=>"prev_next"), $data);
			$item_value	= $filter_item["value"];

			if($pn_fields[$i]=="fn_title"){
				$add_start_icon	= "";
				$add_end_icon	= "";	
				if(!empty($mb_fields["select_board"]["fn_is_secret"]) && intval($data[$mb_fields["select_board"]["fn_is_secret"]])==1)
					$add_start_icon		= $secret_icon;

				$template_start	.= '<a href="'.mbw_get_url(array('board_pid'=>$data[$mb_fields["select_board"]["fn_pid"]],'mode'=>'view')).'"><span>'.$add_start_icon.$item_value.$add_end_icon.'</span></a>';
			}else if($pn_fields[$i]=="fn_reg_date"){
				$template_start	.= '<span>'.substr($item_value,0,10).'</span>';
			}else{
				$template_start	.= '<span>'.$item_value.'</span>';
			}
			$template_start	.= '</td>';
		}

		$template_start	.= $template_end;
		if($echo) echo $template_start;
		else return $template_start;
	}
}


?>