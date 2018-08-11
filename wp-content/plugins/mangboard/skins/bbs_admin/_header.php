<script type="text/javascript">

<?php
//반응형 스크립트
if(mbw_get_option("resize_responsive")){			
	echo mbw_get_resize_responsive(mbw_get_vars("device_type"));
}
$category_text							= str_replace("\r\n", "",mbw_get_board_option("fn_category_data"));
echo "var category_text				= '".str_replace("'", '"', trim($category_text))."';";
echo 'mb_categorys["value1"]	= "'.mbw_get_param("category1").'";';
echo 'mb_categorys["value2"]	= "'.mbw_get_param("category2").'";';
echo 'mb_categorys["value3"]	= "'.mbw_get_param("category3").'";';	 

echo 'mb_urls["base"]						= "'.MBW_PLUGIN_URL.'";';
echo 'mb_urls["image"]						= "'.mbw_get_image_url().'";';
echo 'mb_urls["file"]							= "'.mbw_get_image_url().'";';
echo 'mb_urls["search"]						= "'.mbw_get_url( array("board_pid"=>"","mode"=>"list","list_type"=>"","board_page"=>"","board_name"=>"","search_field"=>"","search_text"=>"","order_by"=>"","order_type"=>"") ).'";';

echo 'mb_options["device_type"]		= "'.mbw_get_vars("device_type").'";';
echo 'mb_options["mode"]				= "'.mbw_get_param("mode").'";';
echo 'mb_options["board_action"]				= "'.mbw_get_param("board_action").'";';
echo 'mb_options["board_name"]		= "'.mbw_get_param("board_name").'";';
echo 'mb_options["board_type"]			= "'.mbw_get_board_option("fn_board_type").'";';
echo 'mb_options["table_prefix"]			= "'.mbw_get_id_prefix().'";';
echo 'mb_options["pid"]					= "'.mbw_get_param("board_pid").'";';
echo 'mb_options["nonce"]				= "'.mbw_create_nonce("param").'";';
echo 'mb_options["list_type"]				= "'.mbw_get_param("list_type").'";';

echo 'mb_options["search_field"]		= "'.mbw_get_param("search_field").'";';
echo 'mb_options["search_text"]			= "'.mbw_get_param("search_text").'";';

echo 'mb_languages["selectbox1"]		= "'.__MM("MSG_SELECTBOX").'";';
echo 'mb_languages["selectbox2"]		= "'.__MM("MSG_SELECTBOX").'";';
echo 'mb_languages["selectbox3"]		= "'.__MM("MSG_SELECTBOX").'";';

?>

var category_data				= "";
try {
	if(isJsonType(category_text)){
		category_data			= JSON.parse(category_text);
	}
}catch(e) {}


</script>