<?php 
/*
Plugin Name: MangBoard 최근게시물
Plugin URI: http://www.mangboard.com
Description: MangBoard 최근게시물
Version: 1.1
Author: Hometory
Author URI: http://www.hometory.com
*/

/*
== 새로운 최근 게시물 위젯 추가하는 방법 ==
1. 아래의 숏코드 설정을 찾아 "mb_latest" 숏코드 이름을 원하는 이름으로 수정합니다 ("mb_latest" 이름은 숏코드로 사용할 이름이며, 25번째 줄에 있는 한곳만 수정합니다)
	- add_shortcode("mb_latest", 'mbw_create_latest_mb_basic'); 
	예) add_shortcode("mb_latest_blue", 'mbw_create_latest_mb_basic');
2. 현재 파일에 있는 "latest_mb_basic" 키워드를 전부 수정합니다 (폴더이름 포함)
    예) latest_mb_blue (latest_아이디_스킨특징)
3. "latest-basic" CSS 클래스를 찾아 수정합니다 (css/style.css 파일에 있는 CSS 클래스도 동일하게 수정합니다)

== 새로 추가된 최근 게시물 위젯 숏코드 사용예 ==
   수정전 : 
   [mb_latest name="board1" title="최근 게시물" list_size="5" style="width:300px"]
   [mb_latest name="board1" title="최근 게시물" list_size="5" style="width:300px" maxlength="20" search_field="user_name" search_text="시그망" category1="여행" list_head="true"]
   수정후 : 
   [mb_latest_blue name="board1" title="최근 게시물" list_size="5" style="width:300px"]
*/

//최근 게시물 Shortcode 등록
add_shortcode("mb_latest", 'mbw_create_latest_mb_basic');
if(!function_exists('mbw_create_latest_mb_basic')){
	function mbw_create_latest_mb_basic($args){
		if(!empty($args['echo'])){
			echo mbw_get_latest_mb_basic("shortcode",$args);
		}else{
			return mbw_get_latest_mb_basic("shortcode",$args);
		}
	}
}
if(!function_exists('mbw_latest_mb_basic_css')){
	function mbw_latest_mb_basic_css(){
		loadStyle(MBW_PLUGIN_URL."plugins/widgets/latest_mb_basic/css/style.css");
	}
}

if(!function_exists('mbw_get_latest_mb_basic')){
	function mbw_get_latest_mb_basic($mode,$data){		
		global $mdb,$mstore,$mb_admin_tables,$mb_fields;
		$title_max_length		= 20;
		if(!empty($data['maxlength'])) $title_max_length		= $data['maxlength'];
		else if($mode=="shortcode") $title_max_length		= 40;
		
		if(empty($data['name'])) return;
		else $name			= str_replace('"','',$data['name']);
		if(empty($data['post_id'])){
			$post_id				= $mdb->get_var("SELECT ".$mb_fields["board_options"]["fn_post_id"]." FROM ".$mb_admin_tables["board_options"]." where ".$mb_fields["board_options"]["fn_board_name2"]."='".$name."' limit 1");
		}else $post_id			= $data['post_id'];
		if(empty($data['list_size'])) $list_size			= "5";
        else $list_size			= $data['list_size'];
		if(empty($data['title'])) $title			= "";
        else $title			= $data['title'];

		if(empty($data['search_field'])) $search_field			= "";
        else $search_field			= $data['search_field'];
		if(!isset($data['search_text'])) $search_text			= "";
        else $search_text			= $data['search_text'];
		if(empty($data['category1'])) $category1			= "";
        else $category1			= $data['category1'];
		if(empty($data['category2'])) $category2			= "";
        else $category2			= $data['category2'];
		if(empty($data['category3'])) $category3			= "";
        else $category3			= $data['category3'];
		if(empty($data['class'])) $div_class			= "";
        else $div_class			= ' '.$data['class'];
		if(empty($data['style'])) $div_style			= "";
        else $div_style			= " style='".str_replace("'",'"',$data['style'])."'";

		//필요한 게시판 필드 이름 가져오기
		$select_field			= array("fn_pid","fn_title","fn_category1","fn_category2","fn_category3","fn_image_path","fn_reg_date");
		if(!empty($search_field) && $search_text!="") $select_field[]			= $search_field;
		$board_field			= $mstore->get_board_select_fields($select_field,$name);

		$latest_permalink		= get_permalink($post_id);
		if(strpos($latest_permalink, '?') === false)	$latest_permalink		= $latest_permalink."?";
		else 	$latest_permalink		= $latest_permalink."&";
		if(!empty($category1)) $latest_permalink		= $latest_permalink."category1=".$category1."&";			
		if(!empty($category2)) $latest_permalink		= $latest_permalink."category2=".$category2."&";			
		if(!empty($category3)) $latest_permalink		= $latest_permalink."category3=".$category3."&";			
		$latest_permalink		= $latest_permalink."vid=";
		
		$table_name				= mbw_get_table_name($name);

		$where_query				= "";
		$where_data				= array();
		if(!empty($category1)) $where_data[]		= $mdb->prepare($board_field["fn_category1"]."=%s",$category1); 
		if(!empty($category2)) $where_data[]		= $mdb->prepare($board_field["fn_category2"]."=%s",$category2); 
		if(!empty($category3)) $where_data[]		= $mdb->prepare($board_field["fn_category3"]."=%s",$category3); 
		if(!empty($search_field) && $search_text!="") $where_data[] = $mdb->prepare($search_field."=%s",$search_text);
		if(!empty($where_data)) $where_query				= " WHERE ".implode(" and ",$where_data);
		$latest_list		= $mdb->get_results("SELECT * FROM " . $table_name . $where_query." order by ".$board_field["fn_pid"]." DESC limit 0,".$list_size, ARRAY_A);


		$latest_html	= '<div class="mb-widget">';
		$latest_html	.= '<div'.$div_style.' class="mb-latest-basic mb-widget-'.$mode.$div_class.'">';
		if($mode!="sidebar" && !empty($title)) 
			$latest_html	.= '<div class="mb-latest-title"><a href="'.get_permalink($post_id).'" title="'.esc_attr($title).'">'.$title.'</a></div>';

		$latest_html	.= '<div class="mb-latest-box"><table  cellspacing="0" cellpadding="0" border="0" class="table table-latest">';
		$latest_html	.= '<colgroup><col style="width:100%" /></colgroup>';
		$latest_html	.= '<tbody>';

		if(!empty($latest_list)){
			foreach($latest_list as $latest_item){
				$post_title		= mbw_htmlspecialchars_decode($latest_item[$board_field["fn_title"]]);
				if(mb_strlen($post_title)>$title_max_length){
					$post_title		= mb_substr($post_title, 0, $title_max_length)."...";
				}
				$latest_html	.= '<tr><td class="mb-latest-item-title">';
				$latest_html	.= '<a href="'.$latest_permalink.$latest_item[$board_field["fn_pid"]].'" title="'.esc_attr($latest_item[$board_field["fn_title"]]).'"><span>'.mbw_htmlspecialchars($post_title).'</span>';
				
				//최신글 아이콘 표시
				$write_date			= strtotime( $latest_item[$board_field["fn_reg_date"]] );
				if(mbw_get_timestamp()-(60*60*48)<$write_date)
					$latest_html	.= ' <img class="list-i-new" alt="new" style="vertical-align:middle;" src="'.MBW_PLUGIN_URL.'skins/bbs_basic/images/icon_new.gif" />';
				$latest_html	.= '</a>';

				$latest_html	.= '</td></tr>';
			}
		}else{
			$latest_html	.= '<tr><td align="center" style="text-align:center;">'.__MM("MSG_LIST_ITEM_EMPTY").'</td></tr>';
		}

		$latest_html	.= "</tbody></table></div>";
		$latest_html	.= "</div></div>";
		return $latest_html;
	}
}


if ( ! class_exists( 'mbw_latest_mb_basic', false ) ){

	if(!function_exists('register_latest_mb_basic')){
		function register_latest_mb_basic() {	
			register_widget( 'mbw_latest_mb_basic' );
		}
	}
	add_action( 'widgets_init', 'register_latest_mb_basic' );

	class mbw_latest_mb_basic extends WP_Widget {
		function __construct() {
			mbw_latest_mb_basic_css();
			$widget_ops = array('classname' => 'mbw_latest_mb_basic', 'description' => __('A Sidebar widget to display latest post entries in your sidebar.','mangboard') ); 
			parent::__construct('mbw_latest_mb_basic', __('MangBoard Latest Basic','mangboard'), $widget_ops);
		}

		function widget($args, $instance) {
			extract($args);
			echo $before_widget;
			$title				= apply_filters('widget_title', $instance['title'] ); 
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
			echo mbw_get_latest_mb_basic("sidebar",$instance);
			echo $after_widget;
		}

		 
		function form($instance) {
			global $wpdb;
			$defaults			= array( 'title' => '','list_size' => '5', 'maxlength' => '20', 'post_id' => '', 'name' => '', 'category1' => '' ); 
			$size_options		= array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15); 
			$instance			= wp_parse_args( (array) $instance, $defaults );
			$title					= strip_tags($instance['title']);
			$name				= strip_tags($instance['name']);
			$category1			= strip_tags($instance['category1']);
			$list_size				= strip_tags($instance['list_size']);
			$maxlength		= strip_tags($instance['maxlength']);
			$post_id				= strip_tags($instance['post_id']);

			if(empty($maxlength)) $maxlength	= "20";

			$mbw_list = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "posts where post_status='publish' and post_content like '%".MBW_SHORTCODE_BOARD." name=%' order by ID DESC");
			?>
			 
			<p><label><?php _e('Title','mangboard') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"  type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label><?php _e('Size','mangboard') ?>: 
			<select class="widefat" name="<?php echo $this->get_field_name('list_size'); ?>">
				<?php
				$list_size = count($size_options);
				$option_html			= "";
				for ($i = 0; $i < $list_size; $i++){
					$option_html		= $option_html.'<option value="'.$size_options[$i].'"';
					if ($instance['list_size'] == $size_options[$i]) $option_html		= $option_html.' selected="selected"'; 
					$option_html		= $option_html.'>'.$size_options[$i].'</option>';
				}
				echo $option_html;
				?>
			</select></label></p>

			<p><label><?php _e('Max Length','mangboard') ?>: <input class="widefat" name="<?php echo $this->get_field_name('maxlength'); ?>"  type="text" value="<?php echo esc_attr($maxlength); ?>" /></label></p>

			<p><label><?php _e('Target','mangboard') ?>: 
			<select class="widefat" name="<?php echo $this->get_field_name('post_id'); ?>" onchange='mb_latest_target_change(this);'>
				<?php
				$list_size = count($mbw_list);
				$option_html			= "";
				$board_names			= array();
				$title_max_length		= 13;
				
				for ($i = 0; $i < $list_size; $i++) {
					$post_content		= $mbw_list[$i]->post_content;
					$post_title			= $mbw_list[$i]->post_title;
					$index1				= strpos($post_content,"[".MBW_SHORTCODE_BOARD." name=")+15;
					$index2				= strpos($post_content,'"',$index1+1);				
					if($index2===false) $index2	= strpos($post_content," ",$index1);
					$board_name		= str_replace('"','',substr($post_content,$index1,$index2-$index1));				 

					if(mb_strlen($post_title)>$title_max_length){
						$post_title		= mb_substr($post_title, 0, $title_max_length)."...";
					}
					$post_title			= $post_title.' ['.$board_name.']';
					
					$option_html		= $option_html.'<option value="'.$mbw_list[$i]->ID.'"';
					if ($instance['post_id'] == $mbw_list[$i]->ID) $option_html		= $option_html.' selected="selected"'; 
					$option_html		= $option_html.'>'.$post_title.'</option>';

					if(empty($name)) $name		= $board_name;
					$board_names[]		= "'".$board_name."'";				
				}
				echo $option_html;
				?>
			</select></label></p>		

			<p><label><?php _e('Category','mangboard') ?>: <input class="widefat" name="<?php echo $this->get_field_name('category1'); ?>"  type="text" value="<?php echo esc_attr($category1); ?>" /></label></p>

			<input class="mb-latest-name" name="<?php echo $this->get_field_name('name'); ?>" readonly type="hidden" value="<?php echo esc_attr($name); ?>" />
			<script type='text/javascript'>
				function mb_latest_target_change(objTarget){
					var names		= new Array(<?php echo implode(",",$board_names);?>);
					jQuery(".mb-latest-name").val(names[objTarget.selectedIndex]);
				}
			</script>
			<?php
		}
	 
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title']			= strip_tags($new_instance['title']);
			$instance['name']			= strip_tags($new_instance['name']);
			$instance['category1']		= strip_tags($new_instance['category1']);
			$instance['list_size']		= strip_tags($new_instance['list_size']);
			$instance['maxlength']		= strip_tags($new_instance['maxlength']);
			$instance['post_id']		= strip_tags($new_instance['post_id']); 
			return $instance;
		}    
	}
}
?>