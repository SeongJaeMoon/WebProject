<?php

add_action('wp_head', 'mbw_head',1);
if(!function_exists('mbw_head')){
	function mbw_head(){
		mbw_add_trace("mbw_head");
		mbw_head_meta();	
		mbw_analytics("today_visit");
	}
}
if(!function_exists('mbw_head_meta')){
	function mbw_head_meta(){
		if(mbw_get_trace("mbw_head_meta")==""){
			mbw_add_trace("mbw_head_meta");
			mbw_analytics("today_page_view");
			global $mstore,$mdb,$mb_admin_tables,$mb_fields,$mb_board_table_name;
			global $post;
			
			if(empty($mb_board_table_name)) $mb_board_table_name		= mbw_get_board_table_name(mbw_get_board_name());

			$title					= "";
			$image_path		= "";
			$description		= "";
			$keywords			= "";
			$author				= "";
			$tag					= "";
			$published_time	= "";
			$updated_time	= "";

			$site_name			= get_bloginfo('name');
			$page_url			= "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

			if(!empty($mb_fields["select_board"]) && mbw_get_param("mode")=="view"){
				$where_query		= $mdb->prepare(" WHERE ".$mb_fields["select_board"]["fn_pid"]."=%d", mbw_get_param("board_pid"));
				$select_field		= implode(",",array_values($mstore->get_board_select_fields(array("fn_title","fn_content","fn_image_path","fn_user_picture","fn_user_name","fn_tag","fn_reg_date","fn_modify_date"))));
				$board_item		= mbw_get_board_item_query("select ".$select_field." from ".$mb_board_table_name.$where_query." limit 1");
				
				if(!empty($board_item)){
					$title					= mbw_get_board_item("fn_title",false);
					$author				= mbw_get_board_item("fn_user_name",false);
					if(empty($title)) $title		= $author;
					$keywords			= mbw_get_board_item("fn_tag",false);
					$reg_date			= mbw_get_board_item("fn_reg_date",false);
					$modify_date		= mbw_get_board_item("fn_modify_date",false);
					$reg_time			= strtotime($reg_date);
					$published_time	= gmdate(DATE_ATOM, $reg_time);
					if(!empty($modify_date)){
						$modify_time		= strtotime($modify_date);					
						$updated_time	= gmdate(DATE_ATOM, $modify_time);
					}else{
						$modify_time		= "";
						$updated_time	= "";
					}

					if(mbw_get_board_item("fn_content",false)!=""){
						$description	= mbw_get_board_item("fn_content",false);
						if(mbw_get_board_item("fn_data_type")=="html") $description			= mbw_htmlspecialchars_decode($description);
					}
					if(mbw_get_board_item("fn_image_path")!="") 
						$image_path	= mbw_get_image_url("url",mbw_get_board_item("fn_image_path"));
					else if(mbw_get_board_item("fn_user_picture")!="") 
						$image_path	= mbw_get_image_url("url",mbw_get_board_item("fn_user_picture"));
				}
			}else{				
				$post_id			= 0;
				$post_content	= "";
				if(!empty($post->ID)) $post_id		= $post->ID;				
				if(!empty($post->post_content)){
					$post_content		= $post->post_content;
					$post_content		= preg_replace("/\[.*\]/s", "", $post_content); 
				}

				$seo				= mbw_get_seo_meta($post_id);
				$title				= $seo["mb_seo_title"];
				$description	= $seo["mb_seo_description"];
				$keywords		= $seo["mb_seo_keyword"];

				if(empty($title)) $title				= wp_title('', false);
				if(empty($title)) $title				= $site_name;
				if(empty($description)) {
					if(is_front_page()) $description		= get_bloginfo( 'description' );
					else if(is_singular() && !empty($post_content)) $description		= $post_content;
					else $description		= $title;
				}
				if(is_singular()){				
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
					if(!empty($large_image_url[0])) $image_path		= $large_image_url[0];
					//$author			= get_the_author_meta('display_name', $post->post_author);

					$published_time	= get_the_date( DATE_W3C );
					$updated_time	= get_the_modified_date( DATE_W3C );
				}
			}

			$title				= str_replace("\"", "'", strip_tags(html_entity_decode($title)));
			$title				= trim(str_replace("&nbsp;", " ", $title));
			$image_path	= trim(str_replace("\"", "'", $image_path));
			if(!empty($keywords)){ 
				$keywords		= str_replace("\"", "'", strip_tags(html_entity_decode($keywords)));
				$keywords		= trim(str_replace("&nbsp;", " ", $keywords));
			}
			
			if(!empty($description)){				
				$description	= preg_replace("/<script.*<\/script>/s", "", $description); 
				$description	= str_replace(array("\r\n","\n","&nbsp;"," ","  "), " ", strip_tags(mbw_htmlspecialchars_decode($description)));
				$description	= str_replace(array("  ","   ","    "), " ", $description);
				$description	= trim(str_replace("\"", "'", $description));

				if(!empty($description)){ 
					if(function_exists('mb_substr')) $description	= mb_substr($description, 0, 200, mbw_get_option("encoding"));
					else $description	= substr($description, 0, 200);
				}
			}		

			$page_url	= mbw_check_url(strip_tags($page_url));
			$script		= '<script type="text/javascript">';

			$script		.= 'var shareData				= {"url":"","title":"","image":"","content":""};';
			$script		.= 'shareData["url"]			= "'.$page_url.'";';
			$script		.= 'shareData["title"]			= "'.$title.'";';
			$script		.= 'shareData["image"]		= "'.$image_path.'";';	
			$script		.= 'shareData["content"]	= "'.$description.'";';

			if(mbw_get_option("use_seo")){
				echo '<!-- Mangboard SEO Start -->'.PHP_EOL;
				echo '<link rel="canonical" href="'.($page_url).'" />'.PHP_EOL;
				echo '<meta property="og:url" content="'.($page_url).'" />'.PHP_EOL;
				if(is_front_page()){
					echo '<meta property="og:type" content="website" />'.PHP_EOL;
				}else{
					echo '<meta property="og:type" content="article" />'.PHP_EOL;
				}
				if(!empty($title)){
					echo '<meta property="og:title" content="'.esc_attr($title).'" />'.PHP_EOL;
					echo '<meta name="title" content="'.esc_attr($title).'" />'.PHP_EOL;
					echo '<meta name="twitter:title" content="'.esc_attr($title).'" />'.PHP_EOL;
				}				
				if(!empty($description)){
					echo '<meta property="og:description" content="'.esc_attr($description).'" />'.PHP_EOL;
					echo '<meta property="description" content="'.esc_attr($description).'" />'.PHP_EOL;
					echo '<meta name="description" content="'.esc_attr($description).'" />'.PHP_EOL;
					echo '<meta name="twitter:card" content="summary" />'.PHP_EOL;
					echo '<meta name="twitter:description" content="'.esc_attr($description).'" />'.PHP_EOL;
				}
				if(!empty($image_path)){
					echo '<meta property="og:image" content="'.esc_attr($image_path).'" />'.PHP_EOL;
					echo '<meta name="twitter:image" content="'.esc_attr($image_path).'" />'.PHP_EOL;
				}
				if(!empty($keywords)){
					echo '<meta name="keywords" content="'.esc_attr($keywords).'" />'.PHP_EOL;
					if(!is_front_page()){ 
						$tags		= explode(',',$keywords);
						foreach ( $tags as $tag ) {
							echo '<meta property="article:tag" content="'.esc_attr($tag).'" />'.PHP_EOL;
						}
					}
				}
				if(!empty($author)){
					echo '<meta name="author" content="'.esc_attr($author).'" />'.PHP_EOL;
				}
				if(!empty($published_time)){
					echo '<meta property="article:published_time" content="'.esc_attr($published_time).'" />'.PHP_EOL;
				}
				if(!empty($updated_time) && $published_time!=$updated_time){
					echo '<meta property="article:modified_time" content="'.esc_attr($updated_time).'" />'.PHP_EOL;
					echo '<meta property="og:updated_time" content="'.esc_attr($updated_time).'" />'.PHP_EOL;
				}				
				echo '<meta property="og:locale" content="'.mbw_get_option("locale").'" />'.PHP_EOL;
				echo '<meta property="og:site_name" content="'.esc_attr($site_name).'" />'.PHP_EOL;
				echo '<!-- Mangboard SEO End -->'.PHP_EOL;
			}

			$mb_user_level	= mbw_get_user("fn_user_level");
			//복사 방지 스크립트		
			if(mbw_get_option("prevent_content_copy") && $mb_user_level<mbw_get_option("admin_level")){
				$script	.= mbw_get_prevent_content_copy();		
			}
			$script			.= '</script>';

			global $mb_scripts; 
			$mb_scripts[]		= $script;
			
			// 디비 버젼 체크
			global $mb_version,$mb_db_version;		
			/*
			if(mbw_get_option("db_version")!=$mb_db_version){
				if(is_file(MBW_PLUGIN_PATH."includes/install/update.php"))
					require(MBW_PLUGIN_PATH."includes/install/update.php");			
			}
			*/
			if(mbw_get_option("mb_version")!=$mb_version) mbw_update_option('mb_version',$mb_version);

			if($mstore->get_board_name()!="" && mbw_get_trace("mbw_check_shortcode")!="" && !empty($mb_fields["board_options"]["fn_post_id"])){
				$post_id		= mbw_get_board_option("fn_post_id");
				if(empty($post_id) && !empty($post->ID)) 
					$mdb->query($mdb->prepare("update ".$mb_admin_tables["board_options"]." set ".$mb_fields["board_options"]["fn_post_id"]."=%d where `".$mb_fields["board_options"]["fn_board_name2"]."`=%s", $post->ID,$mstore->get_board_name()));
			}
		}	
	}
}

add_action('wp_loaded', 'mbw_loaded_head', 15);
if(!function_exists('mbw_loaded_head')){
	function mbw_loaded_head(){
		if(current_theme_supports('title-tag')){
			add_filter('document_title_parts','mbw_filter_header_title',15,1);
		}else{
			add_filter('wp_title','mbw_filter_header_title',15,1);
		}
	}
}
if(!function_exists('mbw_filter_header_title')){	
	function mbw_filter_header_title($w_title){
		if(!is_singular()) return $w_title;
		global $post,$mstore,$mdb,$mb_admin_tables,$mb_fields,$mb_board_table_name;
		if(empty($mb_board_table_name)) $mb_board_table_name		= mbw_get_board_table_name(mbw_get_board_name());		
		if(!empty($mb_fields["select_board"]) && mbw_get_param("mode")=="view" && mbw_get_param("board_pid")!=""){
			$where_query		= $mdb->prepare(" WHERE ".$mb_fields["select_board"]["fn_pid"]."=%d", mbw_get_param("board_pid"));		

			if(!mbw_is_admin_table($mb_board_table_name) && !empty($mb_fields["select_board"]["fn_title"])){
				$title			= $mdb->get_var("select ".$mb_fields["select_board"]["fn_title"]." from ".$mb_board_table_name.$where_query." limit 1");
				$title			= str_replace("\"", "'", strip_tags(html_entity_decode($title)));
				$title			= trim(str_replace("&nbsp;", " ", $title));
				if(is_array($w_title)){
					if(isset($w_title["title"])) $w_title["title"]		= $title." ";
				}else{
					$w_title		= $title." ";
				}
			}
		}
		return $w_title;
	}
}

add_action('wp_footer', 'mbw_footer',15);
if(!function_exists('mbw_footer')){	
	function mbw_footer(){
		mbw_add_trace("mbw_footer");	
		if(mbw_get_option("google_analytics_id")!=""){
			echo '<script type="text/javascript">(function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)		})(window,document,"script","//www.google-analytics.com/analytics.js","ga");ga("create", "'.mbw_get_option("google_analytics_id").'", "auto");ga("send", "pageview");</script>';
		}	
		if(mbw_get_option("naver_analytics_id")!=""){
			echo '<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> <script type="text/javascript"> if(!wcs_add) var wcs_add = {}; wcs_add["wa"] = "'.mbw_get_option("naver_analytics_id").'"; wcs_do(); </script>';
		}
		mbw_footer_scripts();
	}
}
add_action('admin_footer', 'mbw_footer_scripts',15);
if(!function_exists('mbw_footer_scripts')){	
	function mbw_footer_scripts(){
		global $mb_api_urls;
		$script		= '<script type="text/javascript">';
		$script		.= 'if(typeof(mb_urls)==="undefined"){var mb_urls = [];}; ';
		foreach($mb_api_urls as $key => $value){
			$script		.= 'mb_urls["'.$key.'"]			= "'.$mb_api_urls[$key].'";';
		}	
		$script		.= '</script>';
		echo $script;
	}
}
add_action('wp_logout', 'mbw_wp_logout',16);
if(!function_exists('mbw_wp_logout')){
	function mbw_wp_logout(){	
		mbw_add_trace("mbw_wp_logout");
	}
}
add_filter('query_vars','mbw_plugin_add_trigger');
if(!function_exists('mbw_plugin_add_trigger')){
	function mbw_plugin_add_trigger($vars) {
		$vars[] = 'mb_trigger';
		$vars[] = 'mb_user';
		$vars[] = 'mb_ext';
		return $vars;
	}
}
add_action('template_redirect', 'mbw_plugin_trigger_check');
if(!function_exists('mbw_plugin_trigger_check')){	
	function mbw_plugin_trigger_check() {
		$mb_trigger	= get_query_var('mb_trigger');
		$mb_ext			= get_query_var('mb_ext');
		if($mb_trigger == "rss") {
			if(is_file(MBW_PLUGIN_PATH."includes/mb-rss.php"))
				require(MBW_PLUGIN_PATH."includes/mb-rss.php");
			exit;
		}else if($mb_trigger == "rss2") {
			if(is_file(MBW_PLUGIN_PATH."includes/mb-rss2.php"))
				require(MBW_PLUGIN_PATH."includes/mb-rss2.php");
			exit;
		}else if($mb_trigger == "rss3") {
			if(is_file(MBW_PLUGIN_PATH."includes/mb-rss3.php"))
				require(MBW_PLUGIN_PATH."includes/mb-rss3.php");
			exit;
		}else if($mb_trigger == "file") {
			$file_type		= "application/octet-stream";
			if(mbw_get_param("file_type")!="") $file_type	= mbw_get_param("file_type");
			header("Content-type: ".$file_type);
			header("Content-charset=UTF-8");
			header("Content-Disposition: attachment; filename=".urlencode(mbw_get_param("file_name")));
			echo '<html><head><meta http-equiv="Content-Type" content="'.$file_type.'; charset=UTF-8"></head><body>';
			echo mbw_get_param("file_content");
			echo '</body></html>';
			exit;
		}else if((get_query_var('mb_user')) == "logout") {
			$logout_redirect_to		= home_url();
			if(has_filter('mf_user_logout_redirect_to')) 
				$logout_redirect_to		= apply_filters("mf_user_logout_redirect_to",$logout_redirect_to);
			mbw_logout();
			header('Location: '.$logout_redirect_to);
			exit;
		}else if($mb_ext == "file") {
			include(MBW_PLUGIN_PATH."includes/mb-file.php");
			exit;
		}else if($mb_ext == "seditor" && mbw_get_param("se_skin")!="") {
			$skin_name		= mbw_value_filter(mbw_get_param("se_skin"));
			include(MBW_PLUGIN_PATH."plugins/editors/smart/".$skin_name.".php");
			exit;
		}else if($mb_ext == "heditor" && mbw_get_param("se_skin")!="") {
			$skin_name		= mbw_value_filter(mbw_get_param("se_skin"));
			include(MBW_PLUGIN_PATH."plugins/editors/hometory_smart/".$skin_name.".php");
			exit;
		}else if($mb_ext == "seditor_uploader") {
			include(MBW_PLUGIN_PATH."plugins/editors/smart/sample/photo_uploader/photo_uploader.php");
			exit;
		}else if($mb_ext == "seditor_callback") {
			include(MBW_PLUGIN_PATH."plugins/editors/smart/sample/photo_uploader/callback.php");
			exit;
		}else if($mb_ext == "captcha" && mbw_get_option("kcaptcha_image_path")!="") {
			include(mbw_get_option("kcaptcha_image_path"));
			exit;
		}
	}
}
add_action( 'wp_ajax_mb_board', 'mbw_api_callback' );
add_action( 'wp_ajax_mb_comment', 'mbw_api_callback' );
add_action( 'wp_ajax_mb_user', 'mbw_api_callback' );
add_action( 'wp_ajax_mb_heditor', 'mbw_api_callback' );
add_action( 'wp_ajax_mb_template', 'mbw_api_callback' );
add_action( 'wp_ajax_mb_commerce', 'mbw_api_callback' );
add_action( 'wp_ajax_mb_uploader', 'mbw_api_callback' );
add_action( 'wp_ajax_mb_custom', 'mbw_api_callback' );

add_action( 'wp_ajax_skin_mb_board', 'mbw_api_callback' );
add_action( 'wp_ajax_skin_mb_comment', 'mbw_api_callback' );
add_action( 'wp_ajax_skin_mb_user', 'mbw_api_callback' );
add_action( 'wp_ajax_skin_mb_heditor', 'mbw_api_callback' );
add_action( 'wp_ajax_skin_mb_template', 'mbw_api_callback' );
add_action( 'wp_ajax_skin_mb_commerce', 'mbw_api_callback' );
add_action( 'wp_ajax_skin_mb_custom', 'mbw_api_callback' );

add_action( 'wp_ajax_nopriv_mb_board', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_mb_comment', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_mb_user', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_mb_heditor', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_mb_template', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_mb_commerce', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_mb_uploader', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_mb_custom', 'mbw_api_callback' );

add_action( 'wp_ajax_nopriv_skin_mb_board', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_skin_mb_comment', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_skin_mb_user', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_skin_mb_heditor', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_skin_mb_template', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_skin_mb_commerce', 'mbw_api_callback' );
add_action( 'wp_ajax_nopriv_skin_mb_custom', 'mbw_api_callback' );

if(!function_exists('mbw_api_callback')){
	function mbw_api_callback() {
		mbw_add_trace("mbw_api_callback");
		global $mdb,$mstore,$mb_fields,$mb_request_mode,$mb_languages,$send_data;
		global $mb_admin_tables,$mb_board_table_name,$mb_comment_table_name;
		$action		= mbw_get_param("action");
		$file_name		= str_replace( "_", "-", $action).".php";

		if($action=="mb_uploader"){
			if(is_file(MBW_PLUGIN_PATH."includes/".$file_name))
				require_once(MBW_PLUGIN_PATH."includes/".$file_name);
		}else if(strpos($action, 'skin')===0){
			$file_name		= str_replace( "skin-", "", $file_name);
			if(is_file(MBW_SKIN_PATH."api/".$file_name))
				require_once(MBW_SKIN_PATH."api/".$file_name);
		}else{
			if(is_file(MBW_PLUGIN_PATH."api/".$file_name))
				require_once(MBW_PLUGIN_PATH."api/".$file_name);
		}	
	}
}

//최근 게시물 데이타 저장
if(!function_exists('mbw_latest_api_body')){
	function mbw_latest_api_body(){	
		global $mdb,$mb_fields,$mb_admin_tables,$mstore;
		global $mb_board_table_name,$mb_comment_table_name;
		$where_query			= "";
		$query_command	= "";

		if(mbw_get_param("board_action")=="write" || mbw_get_param("board_action")=="reply"){
			$option_name		= "";
			$board_pid			= 0;
			$data					= array();
			$latest_data			= array();

			$board_name					= mbw_get_param("board_name");
			$data["title"]					= "";
			$data["time"]					= mbw_get_timestamp();
			$data["post_id"]				= $mdb->get_var($mdb->prepare("SELECT ".$mb_fields["board_options"]["fn_post_id"]." FROM ".$mb_admin_tables["board_options"]." where ".$mb_fields["board_options"]["fn_board_name2"]."=%s limit 1",$board_name));		
			
			if(mbw_get_param("mode")=="comment"){
				$option_name				= "mb_latest_comment_data";
				$data["parent_pid"]		= intval(mbw_get_param("parent_pid"));
				$data["pid"]				= intval(mbw_get_param("comment_pid"));
				$data["table"]				= $mb_comment_table_name;
				$data["name"]				= $board_name;
			}else if(mbw_get_param("mode")=="write"){		
				$option_name				= "mb_latest_board_data";			
				$data["pid"]				= intval(mbw_get_param("board_pid"));
				$data["table"]				= $mb_board_table_name;
				$data["name"]				= $board_name;
				if(mbw_is_admin_table($mb_board_table_name)) return;
			}
			if(!empty($option_name)){
				$latest_data		= get_option($option_name);
				if($latest_data === false || empty($latest_data) ||  !is_array($latest_data)) $latest_data				= array();		
				
				//삭제되서 중복된 데이타가 있으면 제거하기
				foreach($latest_data as $key=>$value){				
					if($value["table"]==$data["table"] && $value["pid"]==$data["pid"]){
						unset($latest_data[$key]);
					}
				}
				$latest_data[]		= $data;
				if(count($latest_data)>20) array_shift($latest_data);
				update_option($option_name,$latest_data);
			}
		}	
	}
}
if(!function_exists('mbw_board_skin_search_add_value')){
	function mbw_board_skin_search_add_value(){	
		if(mbw_get_param('idx')!=""){
			echo '<input type="hidden" name="idx" value="'.mbw_get_param('idx').'" />';
		}
	}
}
add_action('mbw_board_skin_search', 'mbw_board_skin_search_add_value',5);
add_action('mbw_board_skin_footer', 'mbw_set_form_session',5);
add_action('mbw_board_api_body', 'mbw_latest_api_body',5);
add_action('mbw_comment_api_body', 'mbw_latest_api_body',5); 
//Shortcode Action 등록

add_shortcode("mb_image", 'mbw_create_image_panel');
if(!function_exists('mbw_create_image_panel')){
	function mbw_create_image_panel($args, $content=""){
		if(!empty($content)) $args["content"]		= $content;
		$data					= mbw_init_item_data("image",$args);	
		$image_html		= "";
	
		if(!empty($data["align"]))
			$image_html	= $image_html.'<div style="text-align:'.$data["align"].';">';
		else 
			$image_html	= $image_html.'<div>';
		$image_html	= $image_html.mbw_get_input_template("image",$data);
		$image_html	= $image_html.'</div>';
		return $image_html;		
	}
}
add_shortcode("mb_extension", 'mbw_create_extension_panel');
if(!function_exists('mbw_create_extension_panel')){
	function mbw_create_extension_panel($args, $content=""){
		if(!empty($content)) $args["content"]		= $content;
		$extension		=  mbw_get_extension_template($args);		
		if(!empty($extension)){
			return $extension;			
		} else return "";
	}
}


/*
//WP Super Cache 플러그인 사용시 게시물,댓글 작성시에 캐시 초기화
function mbw_super_cache_clear_cache(){
	$clear_action			= array("write","modify","reply","delete","multi_modify","multi_delete","vote_good","vote_bad");	
	if(in_array(mbw_get_param("board_action"), $clear_action)){
		if(function_exists('wp_cache_clear_cache')) wp_cache_clear_cache();
	}
}
if(defined('WP_CACHE') && WP_CACHE){
	add_action('mbw_comment_api_body', 'mbw_super_cache_clear_cache',10); 
	add_action('mbw_board_api_body', 'mbw_super_cache_clear_cache',10); 
}
*/
?>