<?php

if(!function_exists('mbw_get_seo_meta')){
	function mbw_get_seo_meta($post_id=0){
		$seo				= array("mb_seo_title"=>"","mb_seo_description"=>"","mb_seo_keyword"=>"");
		if(!empty($post_id))
			$post_meta			= get_post_meta($post_id,'mb_post_seo',true);
		if(!empty($post_meta)) 
			$seo					= array_merge($seo, $post_meta);
		return $seo;
	}
}

?>