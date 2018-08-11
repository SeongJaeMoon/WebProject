<?php 
if(!defined('_MB_')) exit();
do_action('mbw_dashboard_init');
$dashboard_data		= array();
$mb_version			= mbw_get_option("mb_version");

function mbw_dashboard_plugin_update($version){
	if(empty($version)) return false;	
	$update_file		= download_url("http://demo.mangboard.com/update/mangboard.".$version.".zip");

	if(is_wp_error($update_file)){@unlink($update_file);echo '<script>alert("MangBoard '.$version.' download failed");moveURL("admin.php?page=mbw_dashboard");</script>';exit;}

	global $wp_filesystem;
	$path			= trailingslashit($wp_filesystem->find_folder(WP_CONTENT_DIR.'/plugins'));
	$unzipfile	= unzip_file( $update_file, $path);
   
	if($unzipfile){
		if(mbw_get_option("mb_version")!=$version) mbw_update_option('mb_version',$version);
		echo '<script>alert("MangBoard '.$version.' Update Completed");moveURL("admin.php?page=mbw_dashboard");</script>';
	}else{
		echo '<script>alert("MangBoard '.$version.' Update Failed");moveURL("admin.php?page=mbw_dashboard");</script>';exit;
	}  
	return true;
}

if(!empty($_GET["lang"]) && mbw_is_admin()){	
	update_option("mb_locale",$_GET["lang"]);
}

if(!empty($_GET["update_version"])){
	if(!current_user_can('activate_plugins')){
			echo '<script>alert("'.__MM('MSG_UPDATE_PERMISSION_ERROR').'");moveURL("admin.php?page=mbw_dashboard");</script>';
	}else{
		$update_version	= $_GET["update_version"];
		$url					= wp_nonce_url(admin_url("/admin.php?page=mbw_dashboard&update_version=".$update_version), 'mangboard-'.$update_version);
		if(($creds=request_filesystem_credentials($url))===false) return;
		if(!WP_Filesystem($creds)){request_filesystem_credentials($url);return;}

		if(version_compare($mb_version, $update_version, '<'))
			mbw_dashboard_plugin_update($update_version);
	}
}
$mb_locale				= mbw_get_option("locale");
$rss_url					= "http://demo.mangboard.com/dashboard_rss.php?v=".$mb_version."&lang=".$mb_locale."&site=".urlencode(MBW_SITE_URL);
if(function_exists('mbw_get_dps')) $rss_url	.= "&ps=".mbw_get_dps();
$rss						= fetch_feed($rss_url);
$latest_version			= '1.0.0';

if(!empty($rss)){
	$item								= $rss->get_items( 0, 1 );
	$dashboard_charset			= get_option('blog_charset');		
	$dashboard_title				= @html_entity_decode( $rss->get_title(), ENT_QUOTES, $dashboard_charset );	
	if(!empty($item[0])) $dashboard_desc				= @html_entity_decode( $item[0]->get_description(), ENT_QUOTES, $dashboard_charset );
	$latest_version					= $rss->get_description();
	
	foreach ( $rss->get_items( 0, 10 ) as $item ) {
		$data						= array();
		$data["link"]			= @html_entity_decode( $item->get_link(), ENT_QUOTES, $dashboard_charset );	
		$data["title"]			= esc_html( trim( strip_tags( $item->get_title() ) ) );
		//$data["desc"]			= @html_entity_decode( $item->get_description(), ENT_QUOTES, $dashboard_charset );
		$dashboard_data[]	= $data;
	}
	$rss->__destruct();
	unset($rss);
}
?>
<script type="text/javascript">
function mbw_update_confirm(){		
	if(confirm("<?php echo __MM('MSG_UPDATE_CONFIRM'); ?>")){
		moveURL("admin.php?page=mbw_dashboard&update_version=<?php echo $latest_version; ?>");	
	}	
}
function mbw_dsahboard_language(){
	var objSelect	= document.getElementById("mb_site_locale");
	var lang			= objSelect.options[objSelect.selectedIndex].value;
	moveURL("admin.php?page=mbw_dashboard&lang="+lang);
}
</script>
<style type="text/css">
.mb-dash {margin-top:10px;}
.mb-dash table {border-collapse: collapse;table-layout: fixed;word-break: break-all;min-height:209px;}
.mb-dash table td{padding:1px 2px 0px;border:1px solid #eee;font-size:13px;}
.mb-dash table th{background-color:#F6F6F6;border:1px solid #eee;}
.mb-dash .text-left{text-align:left;padding-left:8px !important;}
.mb-dash .mb-dash-title{font-size: 21px;margin: 0;line-height: 1.2em;display: block;font-weight: 600;float:left;padding:2px 30px 0 0;}
.mb-dash .mb-dash-panel-title{font-size: 16px;padding: 10px 0 0;margin: 0;line-height: 2.1em;display: block;font-weight: 600;}
.mb-dash .mb-dash-box-title{font-size: 14px;padding: 8px 12px;margin: 0;line-height: 1.4em;border-bottom: 1px solid #eee;display: block;font-weight: 600;}
.mb-dash .welcome-panel{margin:0px 0 0px;padding: 12px 0px 0;box-shadow:none; }
.mb-dash .welcome-panel-content{margin-left:13px;max-width:1500px;}
.mb-dash .mb-dash-box{border: 1px solid #e5e5e5;border-top:none;box-shadow: 0 1px 1px rgba(0,0,0,.04);background: #fff;}
</style>
<?php do_action('mbw_dashboard_header'); ?>

<?php if(!empty($dashboard_title)) echo "<div>".$dashboard_title."</div>"; ?>		
<div id="wpbody" role="main" class="mb-dash">
<div id="wpbody-content" aria-label="Main Contents" tabindex="0" style="overflow: hidden;">

	<div id="welcome-panel" class="welcome-panel">
	<div class="welcome-panel-content">
		
		<div>
			<div class="mb-dash-title"><?php echo __MW('W_MANGBOARD').' '.__MW('W_DASHBOARD');?></div>
			<div style="float:left;width:500px;">
				<div class="button"><a href="http://www.mangboard.com/?lang=<?php echo $mb_locale;?>" target="_blank"><?php echo __MW('W_HOMEPAGE'); ?></a></div>
				<div class="button"><a href="http://www.mangboard.com/manual/?lang=<?php echo $mb_locale;?>" target="_blank"><?php echo __MW('W_MANUAL'); ?></a></div>
				<div class="button"><a href="http://www.mangboard.com/tech_support/?lang=<?php echo $mb_locale;?>" target="_blank"><?php echo __MW('W_TECH_SUPPORT'); ?></a></div>				
			</div>
			<div class="clear"></div>
		</div>
		
		
		<p class="about-description"></p>
		<div class="welcome-panel-column-container">
			<div class="welcome-panel-column">
				<div class="mb-dash-panel-title"><?php echo __MW('W_SUMMARY_STATISTICS'); ?></div>			
				<div style="text-align:center;width:90%;">
					<?php
					$today_date	= date("Y-m-d", mbw_get_timestamp());
					$items			= $mdb->get_results("select * from `".$mb_admin_tables["analytics"]."` where ".$mb_fields["analytics"]["fn_date"]."<='".$today_date."' order by ".$mb_fields["analytics"]["fn_pid"]." desc limit 0,2",ARRAY_A);
					if(count($items)==1) $items[]	= array("today_page_view"=>0,"today_write"=>0,"today_comment"=>0,"today_join"=>0,"today_upload"=>0,"today_visit"=>0,"total_visit"=>0,"today_reply"=>0);
					echo '<table cellspacing="0" cellpadding="0" style="width:100%;">';
					echo '<colgroup><col style="40%"><col style="width:30%"><col style="width:30%"></colgroup>';
					echo '<thead><tr><th scope="col">'.__MW('W_TYPE').'</th><th scope="col">'.__MW('W_YESTERDAY').'</th><th scope="col">'.__MW('W_TODAY').'</th></tr></thead>';
					echo '<tbody>';
					echo '<tr><td>'.__MW('W_TODAY_PAGE_VIEW').'</td><td>'.$items[1]["today_page_view"].'</td><td>'.$items[0]["today_page_view"].'</td></tr>';
					echo '<tr><td>'.__MW('W_TODAY_WRITE').'</td><td>'.(intval($items[1]["today_write"])+intval($items[1]["today_reply"])).'</td><td>'.(intval($items[0]["today_write"])+intval($items[0]["today_reply"])).'</td></tr>';
					echo '<tr><td>'.__MW('W_TODAY_COMMENT').'</td><td>'.$items[1]["today_comment"].'</td><td>'.$items[0]["today_comment"].'</td></tr>';
					echo '<tr><td>'.__MW('W_TODAY_JOIN').'</td><td>'.$items[1]["today_join"].'</td><td>'.$items[0]["today_join"].'</td></tr>';
					echo '<tr><td>'.__MW('W_TODAY_UPLOAD').'</td><td>'.$items[1]["today_upload"].'</td><td>'.$items[0]["today_upload"].'</td></tr>';
					echo '<tr><td>'.__MW('W_TODAY_VISIT').'</td><td>'.$items[1]["today_visit"].'</td><td>'.$items[0]["today_visit"].'</td></tr>';
					echo '</tbody></table>';

					?>
				</div>
				<div style="padding:6px 0px;"></div>
			</div>
			<div class="welcome-panel-column welcome-panel-last">
				<div class="mb-dash-panel-title"><?php echo __MW('W_REFERER_LATESET'); ?><span style="font-size:12px;color:#999;"> (<?php echo __MW('W_ONE_WEEK'); ?>)</span></div>				
				<div style="text-align:center;width:90%;">
					<?php
					$search_date		= date("Y-m-d H:i:s", (mbw_get_timestamp()-(60*60*24*7)));
					$field			= $mb_fields["referers"]["fn_referer_host"];
					$url_items	= $mdb->get_results("select ".$field.", count(".$field.") from ".$mb_admin_tables["referers"]." where ".$mb_fields["referers"]["fn_reg_date"].">'".$search_date."' and ".$field."!='' group by ".$field." order by count(".$field.") desc limit 6",ARRAY_A);
					echo '<table cellspacing="0" cellpadding="0" style="width:100%;">';
					echo '<colgroup><col style="15%"><col style="width:65%"><col style="width:20%"></colgroup>';
					echo '<thead><tr><th scope="col">'.__MW('W_RANK').'</th><th scope="col">URL</th><th scope="col">'.__MW('W_SESSION').'</th></tr></thead>';
					echo '<tbody>';				
					$rank		= 1;
					foreach($url_items as $item){
						echo '<tr><td>'.$rank.'</td><td class="text-left">'.$item[$field].'</td><td>'.$item["count(".$field.")"].'</td></tr>';
						$rank++;
					}					
					echo '</tbody></table>';
					?>
				</div>
				<div style="padding:6px 0px;"></div>
			</div>
			<div class="welcome-panel-column">
				<div class="mb-dash-panel-title"><?php echo __MW('W_MANGBOARD').' '.__MW('W_CURRENT_STATE');?></div>
				<div style="text-align:center;width:90%;">
					<?php					
					echo '<table cellspacing="0" cellpadding="0" style="width:100%;">';
					echo '<colgroup><col style="38%"><col style="width:62%"></colgroup>';
					echo '<thead><tr><th scope="col">'.__MW('W_TYPE').'</th><th scope="col">'.__MW('W_VALUE').'</th></tr></thead>';
					echo '<tbody>';				
					
					$update_button		= '';
					if(version_compare($mb_version, $latest_version, '<'))
						$update_button		= '=&gt;<div class="button"><a href="javascript:;" onclick="mbw_update_confirm();return false;">'.$latest_version.' '.__MW('W_UPDATE').'</a></div>';
					else $update_button		= '(DB:'.mbw_get_option("db_version").') ';
					echo '<tr><td>'.__MW('W_MANGBOARD_VERSION').'</td><td>'.$mb_version.' '.$update_button.'</td></tr>';
					echo '<tr><td>'.__MW('W_PHP_VERSION').'</td><td>'.phpversion()." (Upload Max: ".ini_get("upload_max_filesize").", Post: ".ini_get("post_max_size").')</td></tr>';
					
					include(MBW_PLUGIN_PATH."templates/mtpl.input.php");
					$data					= array("type"=>"select","ext"=>"","style"=>"");
					$data["value"]		= $mb_locale;
					if($data["value"]!='ko_KR' && $data["value"]!='ja' && $data["value"]!='zh_CN') $data["value"]		= 'en_US';
					$data["data"]		= "en_US,ko_KR,zh_CN,ja";
					$data["label"]		= "English,Korean,Chinese,Japanese";
					$data["item_id"]	= "mb_site_locale";
					$data["ext"]		= " onchange=\"mbw_dsahboard_language();\"";

					$lang_html		= mbw_get_input_template("admin",$data);
					echo '<tr><td>'.__MW('W_SITE_LOCALE').'</td><td>'.$lang_html.'</td></tr>';

					echo '<tr><td>'.__MW('W_TOTAL_USER').'</td><td>'.$mdb->get_var("SELECT count(*) FROM ".$mb_admin_tables["users"]).'</td></tr>';
					echo '<tr><td>'.__MW('W_TOTAL_FILE').'</td><td>'.$mdb->get_var("SELECT count(*) FROM ".$mb_admin_tables["files"]).'</td></tr>';
					echo '<tr><td>'.__MW('W_TOTAL_VISIT').'</td><td>'.$items[0]["total_visit"].'</td></tr>';					
					echo '</tbody></table>';

					?>
				</div>
				<div style="padding:6px 0px;"></div>				
			</div>
		</div>
	</div>
	</div>
	<?php
		if(!empty($dashboard_desc)) echo $dashboard_desc;
		$index		= 1; 
		$maxlength= 50;
	?>
	<div id="dashboard-widgets-wrap"><div id="dashboard-widgets" class="metabox-holder">
		
		<!-- 최근 글 리스트 -->
		<div id="postbox-container-<?php echo $index;?>" class="postbox-container">
		<div id="box<?php echo $index;?>-sortables" class="meta-box-sortables ui-sortable"><div id="dashboard_primary" class="postbox ">
			<div class="handlediv" title=""><br></div>
			<div class="mb-dash-box-title  ui-sortable-handle"><span><?php echo __MW('W_BOARD_LATESET'); ?></span></div>
			<div class="inside">				
				<div class="rss-widget">
					<ul>
					<?php 
					$option_name				= "mb_latest_board_data";			
					$latest_data					= get_option($option_name);
					if(!empty($latest_data) && is_array($latest_data)) $latest_data		= array_reverse($latest_data);
					$is_admin_page			= mbw_is_admin_page();

					if(!empty($latest_data)){
						$list_size						= 10;
						$list_index					= 0;
						foreach($latest_data as $data){						
							$item		= array_merge( array("title"=>"","post_id"=>"","parent_pid"=>"","pid"=>"","table"=>"","name"=>"","time"=>""), $data);
							if($is_admin_page){
								$url		= "admin.php?page=mbw_board_options&board_name=".$item["name"]."&mode=view&board_pid=".$item["pid"];
							}else {
								$latest_permalink		= get_permalink($item["post_id"]);
								if(strpos($latest_permalink, '?') === false)	$latest_permalink		= $latest_permalink."?";
								else 	$latest_permalink		= $latest_permalink."&";
								$url		= $latest_permalink."mode=view&board_pid=".$item["pid"];
							}
							if(!mbw_is_admin_table($item["table"])){
								$title		= $mdb->get_var($mdb->prepare("SELECT ".$mb_fields["board"]["fn_title"]." FROM ".$item["table"]." where ".$mb_fields["board"]["fn_pid"]."=%d limit 1",$item["pid"]));		
								if(mb_strlen($title)>$maxlength) $title		= mb_substr($title, 0,$maxlength)."...";
								if(!empty($title)){ 
									echo '<li><a class="rsswidget" href="'.$url.'">'.$title.'</a> <span class="rss-date">'.date( "Y-m-d H:i:s", $item["time"]	 ).'</span></li>';
									$list_index++;
								}
							}							
							if($list_index>=$list_size) break;
						}
					}
					?>
					</ul>
				</div>
			</div>
		</div></div>
		</div>

		<?php $index++;	?>
		<!-- 최근 댓글 리스트 -->
		<div id="postbox-container-<?php echo $index;?>" class="postbox-container">
		<div id="box<?php echo $index;?>-sortables" class="meta-box-sortables ui-sortable"><div id="dashboard_primary" class="postbox ">
			<div class="handlediv" title=""><br></div>
			<div class="mb-dash-box-title ui-sortable-handle"><span><?php echo __MW('W_COMMENT_LATESET'); ?></span></div>
			<div class="inside">				
				<div class="rss-widget">
					<ul>
					<?php 
					$option_name				= "mb_latest_comment_data";			
					$latest_data					= get_option($option_name);
					if(!empty($latest_data) && is_array($latest_data)) $latest_data		= array_reverse($latest_data);
					$is_admin_page			= mbw_is_admin_page();
					if(!empty($latest_data)){
						$list_size						= 10;
						$list_index					= 0;
						foreach($latest_data as $data){						
							$item		= array_merge( array("title"=>"","post_id"=>"","parent_pid"=>"","pid"=>"","table"=>"","name"=>"","time"=>""), $data);
							if($is_admin_page){
								$url		= "admin.php?page=mbw_board_options&board_name=".$item["name"]."&mode=view&board_pid=".$item["parent_pid"];
							}else {							
								$latest_permalink		= get_permalink($item["post_id"]);
								if(strpos($latest_permalink, '?') === false)	$latest_permalink		= $latest_permalink."?";
								else 	$latest_permalink		= $latest_permalink."&";
								$url		= $latest_permalink."mode=view&board_pid=".$item["parent_pid"];
							}
							$title		= $mdb->get_var($mdb->prepare("SELECT ".$mb_fields["comment"]["fn_content"]." FROM ".$item["table"]." where ".$mb_fields["comment"]["fn_pid"]."=%d limit 1",$item["pid"]));		
							if(mb_strlen($title)>$maxlength) $title		= mb_substr($title, 0,$maxlength)."...";
							if(!empty($title)){
								echo '<li><a class="rsswidget" href="'.$url.'">'.$title.'</a> <span class="rss-date">'.date( "Y-m-d H:i:s", $item["time"]	 ).'</span></li>';
								$list_index++;
							}
							if($list_index>=$list_size) break;
						}
					}
					?>
					</ul>
				</div>
			</div>
		</div></div>
		</div>

	<!-- 망보드 RSS -->	
	<?php if(!empty($dashboard_data)){ $index++;foreach($dashboard_data  as $data){	?>
		<!-- widget1 start -->
		<div id="postbox-container-<?php echo $index;?>" class="postbox-container">
		<div id="box<?php echo $index;?>-sortables" class="meta-box-sortables ui-sortable"><div id="dashboard_primary" class="postbox ">
			<div class="handlediv" title=""><br></div>
			<div class="mb-dash-box-title ui-sortable-handle"><span><?php echo $data["title"];?></span></div>
			<div class="inside">				
				<div class="rss-widget">
					<?php $default_args = array( 'show_author' => 0, 'show_date' => 1, 'show_summary' => 0 ); wp_widget_rss_output(trim($data["link"]),$default_args); ?>
				</div>
			</div>
		</div></div>
		</div>
		<!-- widget1 end -->
	<?php $index++; }}?>

	<?php do_action('mbw_dashboard_widget'); ?>


	</div></div><!-- dashboard-widgets-wrap -->

<div class="clear"></div></div><!-- wpbody-content -->
<div class="clear"></div></div>

<?php do_action('mbw_dashboard_footer'); ?>