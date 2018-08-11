<?php
if(!defined('_MB_')) exit();
header( 'Content-type: text/xml' );
$board_items		= array();
$size					= 50;
if(!empty($_GET["size"])) $size		= intval($_GET["size"]);

if(mbw_get_board_name()!="" && intval(mbw_get_board_option("fn_list_level"))==0 && mbw_get_board_option("fn_board_type")=="board"){
	mbw_set_board_where(array("field"=>"fn_is_secret", "value"=>"0", "sign"=>"="));
	$select_query		= mbw_get_add_query(array("column"=>"*","join"=>"none"), "where", "order")." limit 0,".$size;
	$board_items		= mbw_get_board_items_query($select_query);
}
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/"
	xmlns:activity="http://activitystrea.ms/spec/1.0/" >
	<channel>
		<title><?php echo bloginfo_rss('name');?></title>
		<link><?php echo bloginfo_rss('url');?></link>
		<description><?php bloginfo_rss('description') ?></description>
		<language><?php bloginfo_rss( 'language' ); ?></language>
		<generator>WordPress Mangboard</generator>
		<pubDate><?php echo gmdate(DATE_RSS, mbw_get_timestamp())?></pubDate>
<?php foreach($board_items as $item){
			mbw_set_board_item($item); 			
			if(intval(mbw_get_board_option("fn_view_level"))==0) $content		= mbw_get_board_item('fn_content');
			else $content		= "";			
?>
		<item>
			<author><![CDATA[<?php echo mbw_get_board_item('fn_user_name',false);?>]]></author>
			<category><![CDATA[<?php echo mbw_get_board_item('fn_category1',false);?>]]></category>
			<title><![CDATA[<?php echo mbw_htmlspecialchars_decode(mbw_get_board_item('fn_title',false));?>]]></title>
			<link><![CDATA[<?php echo mbw_get_url(array('vid'=>mbw_get_board_item('fn_pid')),get_permalink(mbw_get_board_option("fn_post_id")),"");?>]]></link>
			<guid><![CDATA[<?php echo mbw_get_url(array('vid'=>mbw_get_board_item('fn_pid')),get_permalink(mbw_get_board_option("fn_post_id")),"");?>]]></guid>

			<description><![CDATA[<?php echo $content;?>]]></description>			

			<pubDate><?php echo gmdate(DATE_RSS, strtotime(mbw_get_board_item('fn_reg_date',false)))?></pubDate>
			<tag><![CDATA[<?php echo mbw_get_board_item('fn_tag');?>]]></tag>
		</item>
<?php }?>
	</channel>
</rss>