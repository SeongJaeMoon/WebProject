<?php		
$mb_language_version	= "1.0.0";	

// 언어에 대한 수정요청은 아래 주소의 메일로 보내주시기 바랍니다.
// E-Mail : mangboard@gmail.com		
		
//ERROR MESSAGE		
$mb_languages["MSG_ERROR"]	= "%s Error";	
$mb_languages["MSG_FIELD_EMPTY_ERROR1"]	= "请输入%s ";	// %s加入特定字符
$mb_languages["MSG_FIELD_EMPTY_ERROR2"]	= "请输入%s ";	//请输入姓名
$mb_languages["MSG_FILE_EMPTY_ERROR1"]	= "请上传%s ";	
$mb_languages["MSG_FILE_EMPTY_ERROR2"]	= "请上传%s ";	
$mb_languages["MSG_PATTERN_ERROR"]	= "'%s' 值不是正常值";	
$mb_languages["MSG_UNIQUE_ERROR"]	= "'%s'<br>是已经存在的%s ";	
		
$mb_languages["MSG_FILTER_ERROR"]	= "'%s'是无法使用的单词";	
$mb_languages["MSG_PERMISSION_ERROR"]	= "%s 没有权限";	//没有访问权限，没有文章撰写权限。
		
$mb_languages["MSG_EXIST_ERROR"]	= "%s不存在";	
$mb_languages["MSG_EXIST_ERROR2"]	= "%s %s不存在";	
$mb_languages["MSG_USE_ERROR"]	= "可使用的%s不足";	
		
$mb_languages["MSG_UPLOAD_SIZE_ERROR"]	= "%sMB以上无法上传";	
$mb_languages["MSG_UPLOAD_EXT"]	= "%s只能上传文件";	
$mb_languages["MSG_UPLOAD_EXT_ERROR"]	= "%s 无法上传文件";	
$mb_languages["MSG_MATCH_ERROR"]	= "%s不一致";	
$mb_languages["MSG_NONCE_MATCH_ERROR"]	= "发生了临时故障<br>请刷新后重试";	
		
		
$mb_languages["MSG_SEARCH_ERROR1"]	= "无法找到%s ";	
$mb_languages["MSG_SEARCH_ERROR2"]	= "无法找到%s ";	
		
$mb_languages["MSG_MOVE_SELECT_EMPTY"]	= "请选择拟移动的项目";	
$mb_languages["MSG_COPY_SELECT_EMPTY"]	= "请选择拟复制的项目";	
$mb_languages["MSG_DELETE_SELECT_EMPTY"]	= "请选择拟删除的项目";	
$mb_languages["MSG_DELETE_CONFIRM"]	= "要删除吗？ ";	
$mb_languages["MSG_PASSWD_INPUT"]	= "请输入密码";	
		
$mb_languages["MSG_MULTI_DELETE_CONFIRM"]	= "要删除 个项目吗？ ";  //在... 前加入3个项目数字(数字请在JavaScript中确定)	
$mb_languages["MSG_MULTI_MOVE_CONFIRM"]	= "要移动 个项目吗？";  //在... 前加入3个项目数字(数字请在JavaScript中确定)	
$mb_languages["MSG_MULTI_COPY_CONFIRM"]	= "要复制 个项目吗？ ";  //在... 前加入3个项目数字(数字请在JavaScript中确定)	
		
$mb_languages["MSG_LIST_ITEM_EMPTY"]	= "没有登记的告示";	
$mb_languages["MSG_ITEM_NOT_EXIST"]	= "是已被删除或不存在的内容";	
$mb_languages["MSG_USER_NOT_EXIST"]	= "一致的会员信息不存在";	
		
$mb_languages["MSG_PASSWORD_RESET"]	= "新密码 : ";	// 密码初始化时在密码前加入的内容
		
		
$mb_languages["MSG_VOTE_PARTICIPATE_ERROR"]	= "已经参与了投票";	
$mb_languages["MSG_REQUIRE_LOGIN"]	= "是需要登录的功能";	
$mb_languages["MSG_MOVE_LOGIN"]	= "移动到登录页面";	
$mb_languages["MSG_MOVE_PREV"]	= "移动到前一页";	
$mb_languages["MSG_SEND_WRITE_SUCCESS"]	= "正常登记了";	
$mb_languages["MSG_SEND_MAIL_SUCCESS"]	= "发送了邮件";	
		
$mb_languages["MSG_SECRET"]	= "是加密文";	
$mb_languages["MSG_SECRET_PASSWD_INPUT"]	= "是加密文<br>请输入密码";	
		
$mb_languages["MSG_EMAIL_FILTER_ERROR"]	= "不是正常的邮箱地址";	
$mb_languages["MSG_NAME_FILTER_ERROR"]	= "是无法使用的名称";	
$mb_languages["MSG_WORD_FILTER_ERROR"]	= "是无法使用的单词";	
$mb_languages["MSG_CAPTCHA_INPUT"]	= "请输入防止自动登记数字";	
$mb_languages["MSG_TAG_INPUT"]	= "标签请用逗号区分输入";	
		
$mb_languages["MSG_UPDATE_PERMISSION_ERROR"]	= "没有更新权限";	
$mb_languages["MSG_UPDATE_CONFIRM"]	= "更新前请确认对追加及修改的文件进行备份。要进行更新吗？ ";	
		
$mb_languages["MSG_SELECTBOX"]	= "全部";	
		
$mb_languages["MSG_BOARD_NAME_INPUT_CHECK"]	= "公告板名称应该是以英文开始的4~30个‘英文’、‘数字’、‘_’字符的组合";
$mb_languages["MSG_BOARD_EXPLANATION_INPUT"]	= "输入公告板";
$mb_languages["MSG_BOARD_MODEL_SET"]	= "可以设定‘models’文件夹中的公告板模型，并且‘skin-model’选择skins/皮肤/includes/skin-model.php文件。";
$mb_languages["MSG_EDITOR_SELECT"]	= "在写文章画面输入内容时选择拟使用的编辑器";
$mb_languages["MSG_NUM_POST_ONE_PAGE"]	= "设置一页上显示的告示数";
$mb_languages["MSG_NUM_COMMENT_ONE_PAGE"]	= "设置一页上显示的帖子数";
$mb_languages["MSG_PAGE_BLOCK_NUM_SET"]	= "设定页面区块个数，设定为100时，变更为‘查看更多’按钮方式";
$mb_languages["MSG_TITLE_BAR_LIST"]	= "设定告示目录上是否显示标题栏";
$mb_languages["MSG_POST_ID_ENTER"]	= "输入加入Mangboard Shortcode的WordPress Post ID";
$mb_languages["MSG_BOARD_SET_CHANGE"]	= "公告板链接是只设定目前生成的公告板的内容，可以进行改变载入的功能。选择‘不链接’时，新生成公告板表格";
$mb_languages["MSG_SHOW_CATEGORY"]	= "选择显示类别数据的方式";
$mb_languages["MSG_BOARD_TOP_HTML"]	= "输入公告板上端显示的HTML标签";
$mb_languages["MSG_BOARD_BOTTOM_HTML"]	= "输入公告板下端显示的HTML标签";
$mb_languages["MSG_DEFAULT_FORM_ENTER"]	= "输入写文章中目前显示的写文章格式";
$mb_languages["MSG_LIST_VIEW_AUTHORITY"]	= "设定可以查看告示目录的权限";
$mb_languages["MSG_SET_WRITE"]	= "设定写文章权限";
$mb_languages["MSG_SET_VIEW"]	= "设定文章查看权限";
$mb_languages["MSG_SET_REPLY"]	= "设定答复权限";
$mb_languages["MSG_SET_COMMENT"]	= "设定帖子权限";
$mb_languages["MSG_AUTHORITY_MODIFY"]	= "设定可以修改其他用户撰写的文章的权限";
$mb_languages["MSG_AUTHORITY_SECRET_MSG"]	= "设定可以查看其他用户的加密文的权限";
$mb_languages["MSG_AUTHORITY_DELETE"]	= "设定可以删除其他用户的告示的权限";
$mb_languages["MSG_AUTHORITY_BOARD_ADMIN"]	= "设定可以复制、移动告示等管理公告板的权限";
$mb_languages["MSG_POINT_WRITING"]	= "输入撰写文章时支付的积分";
$mb_languages["MSG_POINT_REPLY"]	= "输入撰写答复时支付的积分";
$mb_languages["MSG_POINT_COMMENT"]	= "输入撰写帖子时支付的积分";
$mb_languages["MSG_ENTER_SSL_PORT_NUM"]	= "输入SSL端口号（443端口可省略）";
$mb_languages["MSG_ENTER_SSL_DOMAIN"]	= "输入SSL域名地址";
$mb_languages["MSG_ADDRESS_CERTIFICATE"]	= "设置了SSL证书的情况，在会员相关地址上适用证书";
$mb_languages["MSG_LOG_SAVE_SHOW"]	= "可以保存登录记录，通过Log管理菜单确认";
$mb_languages["MSG_POINT_LOG_SAVE_SHOW"]	= "可以保存积分记录，通过Log管理菜单确认";
$mb_languages["MSG_ERROR_LOG_SHOW"]	= "可以把错误记录保存到DB上，通过Log管理菜单确认";
$mb_languages["MSG_ID_INPUT_CHECK"]	= "ID应该是以英文开始的4~20个‘英文’、‘数字’、‘_’字符的组合";
$mb_languages["MSG_NAME_INPUT_2MORE"]	= "姓名最少应输入2个字符以上";
$mb_languages["MSG_PASSWORD_INPUT_4MORE"]	= "密码最少应输入4个字符以上";
$mb_languages["MSG_USER_SYNCED"]	= "名会员同步化了。";
$mb_languages["MSG_SYNC_NO_USERS"]	= "可同步化的会员不存在";
$mb_languages["MSG_NOT_REGIST_USER_LOAD"]	= "载入Mangboard会员数据中未登记的WordPress会员数据";
$mb_languages["MSG_NAME_UNUSABLE"]	= "是无法使用的名称";
$mb_languages["MSG_WORD_UNUSABLE"]	= "是无法使用的单词";

$mb_languages["MSG_COPY_MOUSE_PREVENT"]	= "设定鼠标不能右击及拖动（管理员除外）";
$mb_languages["MSG_ADMIN_LEVEL_SET"]	= "管理员登记设定（公告功能使用及部分限制功能除外）";
$mb_languages["MSG_USER_NAME_LEVEL_SET"]	= "会员姓名旁边显示等级";
$mb_languages["MSG_USER_NAME_PHOTO_SET"]	= "会员姓名前显示照片";
$mb_languages["MSG_USER_NAME_POPUP_SET"]	= "点击会员姓名时显示会员信息弹窗";
$mb_languages["MSG_LOGIN_POINT_SET"]	= "登录积分（未使用时设定为0）";
$mb_languages["MSG_SING_UP_POINT_SET"]	= "会员加入积分（未使用时设定为0）";
$mb_languages["MSG_FILE_UPLOAD_SIZE"]	= "文件上传容量（MB）";
$mb_languages["MSG_MAKE_IMAGE_SMALL_DESC"]	= "按指定的尺寸生成上传图片的缩小比例的图片 : 可在模型中(\"field\":\"fn_image_path\",\"size\":\"small\")指定尺寸，如果没有small图片，则载入原图片";
$mb_languages["MSG_MAKE_IMAGE_MIDDLE_DESC"]	= "按指定的尺寸生成上传图片的缩小比例的图片 : 可在模型中(\"field\":\"fn_image_path\",\"size\":\"middle\")指定尺寸，如果没有small图片，则载入原图片";
$mb_languages["MSG_ACCESS_IP_ALLOW_DESC"]		= "";


		
//WORD		
$mb_languages["W_ID"]	= "ID";	
$mb_languages["W_PASSWORD"]	= "密码";	
$mb_languages["W_SECRET"]	= "加密文";	
$mb_languages["W_NOTICE"]	= "公告";	
$mb_languages["W_SKIN"]	= "皮肤";	
$mb_languages["W_SETUP"]	= "设定";	
$mb_languages["W_DELETE"]	= "删除";	
$mb_languages["W_TOTAL"]	= "全体";	
$mb_languages["W_ALL"]	= "全体";	
$mb_languages["W_YEAR"]	= "年";	
$mb_languages["W_MONTH"]	= "月";	
		
		
$mb_languages["W_MANGBOARD"]	= " Mangboard ";	
$mb_languages["W_HOMEPAGE"]	= "首页";	
$mb_languages["W_MANUAL"]	= "手册";	
$mb_languages["W_TECH_SUPPORT"]	= "技术支持";	
$mb_languages["W_COMMUNITY"]	= "社区";	
		
		
$mb_languages["W_PID"]	= "号码";	
$mb_languages["W_HIT"]	= "查询";	
$mb_languages["W_DATE"]	= "日期";	
$mb_languages["W_EMAIL"]	= "邮件";	
$mb_languages["W_IMAGE"]	= "图像";	
$mb_languages["W_TITLE"]	= "题目";	
$mb_languages["W_USER_NAME"]	= "拟订人";	
$mb_languages["W_USER_NAME_PID"]	= "拟订人[Pid]";
$mb_languages["W_WRITER"]	= "作者";
$mb_languages["W_CONTENT"]	= "内容";	
$mb_languages["W_TAG"]	= "标签";	
$mb_languages["W_LEVEL"]	= "等级";	
$mb_languages["W_POINT"]	= "积分";	
$mb_languages["W_GROUP"]	= "群组";	
$mb_languages["W_MEMO"]	= "备忘录";	
$mb_languages["W_FILE"]	= "文件";	
$mb_languages["W_BOARD_FILE"]	= "附件";	
$mb_languages["W_DOWNLOAD"]	= "下载";	
$mb_languages["W_UPDATE"]	= "更新";	
$mb_languages["W_ADDRESS"]	= "地址";	
$mb_languages["W_RANK"]	= "排名";	
$mb_languages["W_COUNT"]	= "个数";	
$mb_languages["W_TYPE"]	= "区分";	
$mb_languages["W_VALUE"]	= "内容";	
$mb_languages["W_SITE"]	= "站点";	
$mb_languages["W_VERSION"]	= "版本";	
$mb_languages["W_SESSION"]	= "会话";	
$mb_languages["W_ICON"]	= "图标";	
$mb_languages["W_TEST"]	= "测试";	
$mb_languages["W_FREE"]	= "免费";	
$mb_languages["W_SEARCH"]	= "搜索";	
		
$mb_languages["W_PREV"]	= "以前";	
$mb_languages["W_NEXT"]	= "以后";	
		
$mb_languages["W_ADD"]	= "注册";	
$mb_languages["W_LIST"]	= "目录";	
$mb_languages["W_VIEW"]	= "查看文章";	
$mb_languages["W_WRITE"]	= "写文章";	
$mb_languages["W_MODIFY"]	= "修改";	
$mb_languages["W_REPLY"]	= "答复";	
$mb_languages["W_REPLY_WRITE"]	= "写答复";	
$mb_languages["W_COMMENT_WRITE"]	= "写帖子";	
$mb_languages["W_MOVE"]	= "移动";	
$mb_languages["W_COPY"]	= "复制";	
$mb_languages["W_ACCESS"]	= "访问";	
		
$mb_languages["W_DASHBOARD"]	= "仪表板";	
$mb_languages["W_BOARD"]	= "公告板";	
$mb_languages["W_BOARD_INSERT"]	= "追加公告板";	
$mb_languages["W_BOARD_ITEM"]	= "告示";	
		
$mb_languages["W_BOARD_DATA"]	= "资料室";	
$mb_languages["W_BOARD_GALLERY"]	= "画廊";	
$mb_languages["W_BOARD_CALENDAR"]	= "日历";	
$mb_languages["W_BOARD_WEBZINE"]	= "网络杂志";	
$mb_languages["W_BOARD_LATESET"]	= "最近告示";	
$mb_languages["W_COMMENT_LATESET"]	= "最近帖子";	
$mb_languages["W_REFERER_LATESET"]	= "最近注入URL";	
$mb_languages["W_SUMMARY_STATISTICS"]	= "迷你统计";	
$mb_languages["W_CURRENT_STATE"]	= "现状";	
		
$mb_languages["W_COMMENT"]	= "帖子";	
$mb_languages["W_CATEGORY"]	= "类别";	
$mb_languages["W_BOARD_VOTE_GOOD"]	= "推荐告示";	
$mb_languages["W_BOARD_VOTE_BAD"]	= "不推荐告示";	
$mb_languages["W_COMMENT_VOTE_GOOD"]	= "推荐帖子";	
$mb_languages["W_COMMENT_VOTE_BAD"]	= "不推荐帖子";	
		
$mb_languages["W_START_DATE"]	= "开始日";	
$mb_languages["W_END_DATE"]	= "结束日";	
		
$mb_languages["W_BOARD_LINK_NONE"]	= "不链接";	
$mb_languages["W_BOARD_LINK_INPUT"]	= "直接输入";	
		
		
		
$mb_languages["W_LOGIN"]	= "登录";	
$mb_languages["W_LOGOUT"]	= "退出";	
$mb_languages["W_AUTO_LOGIN"]	= "自动登录";	
$mb_languages["W_USER"]	= "会员";	
$mb_languages["W_USER_PID"]		= "会员 [Pid]";
$mb_languages["W_USER_INFO"]	= "会员信息";	
$mb_languages["W_USER_JOIN"]	= "会员加入";	
$mb_languages["W_USER_INSERT"]	= "会员注册";	
$mb_languages["W_USER_LEVEL"]	= "会员等级";	
$mb_languages["W_USER_MODIFY"]	= "修改";	
$mb_languages["W_PASSWORD_LOST"]	= "查找密码";	
$mb_languages["W_KCAPTCHA"]	= "防止自动登记";	
$mb_languages["W_CAPTCHA"]	= "防止自动登记";	
		
$mb_languages["W_CURRENCY"]	= "韩元";	
$mb_languages["W_NUMBER_SUFFIX"]	= "个";	
		
$mb_languages["W_TODAY"]	= "今天";	
$mb_languages["W_YESTERDAY"]	= "昨天";	
$mb_languages["W_ONE_WEEK"]	= "1周";	
$mb_languages["W_ONE_MONTH"]	= "1个月";	
$mb_languages["W_THIS_MONTH"]	= "这个月";	
$mb_languages["W_LAST_MONTH"]	= "上个月";	
		
		
		
		
		
//ADMIN MENU		
$mb_languages["W_MENU_DASHBOARD"]	= "仪表板";	
$mb_languages["W_MENU_BOARD"]	= "公告板管理";	
$mb_languages["W_MENU_USER"]	= "会员管理";	
$mb_languages["W_MENU_FILE"]	= "文件管理";	
$mb_languages["W_MENU_OPTION"]	= "选项设定";	
$mb_languages["W_MENU_COOKIE"]	= " cookie管理";	
$mb_languages["W_MENU_ANALYTICS"]	= "统计管理";	
$mb_languages["W_MENU_H_EDITOR"]	= " Hometory编辑器";	
$mb_languages["W_MENU_REFERER"]	= "Referer管理";	
$mb_languages["W_MENU_LOG"]	= "Log管理";	
$mb_languages["W_MENU_ACCESSIP"]	= "访问IP管理";	
		
		
//USER MENU		
$mb_languages["W_USER_SEARCH"]	= "查看告示";	
$mb_languages["W_USER_INFO"]	= "会员信息";	
$mb_languages["W_USER_EMAIL"]	= "发送邮件";	
$mb_languages["W_USER_HOMEPAGE"]	= "首页";	
$mb_languages["W_USER_BLOG"]	= "博客";	
$mb_languages["W_USER_MESSAGE"]	= "发送消息";	
		
			
		

$mb_languages["W_BOARD_NAME"]	= "公告板名称";
$mb_languages["W_BOARD_NAME_PID"]	= "公告板名称 [PID]";

$mb_languages["W_SKIN_MODEL"]	= "皮肤/模型";
$mb_languages["W_AUTHORITY"]	= "权限";
$mb_languages["W_STATUS_POSTINGS"]	= "告示现状";
$mb_languages["W_SETTING"]	= "设定";
$mb_languages["W_BOARD_SETTING"]	= "公告板设定";
$mb_languages["W_VIEW_MSG"]	= "查看文章";
$mb_languages["W_EXPLANATION_BOARD"]	= "公告板说明";
$mb_languages["W_SKIN_NAME"]	= "皮肤名称";
$mb_languages["W_MODEL_NAME"]	= "模型名称";
$mb_languages["W_EDITOR_SETTING"]	= "编辑器设定";
$mb_languages["W_LIST_COUNT"]	= "目录个数";
$mb_languages["W_COMMENT_COUNT"]	= "帖子个数";
$mb_languages["W_PAGE_BLOCK_COUNT"]	= "页面区块个数";
$mb_languages["W_SHOW_TITLE_BAR"]	= "目录标题栏显示";
$mb_languages["W_COMMENT_FUNCTION"]	= "帖子功能";
$mb_languages["W_NOTIFI_FUNCTION"]	= "公告功能";
$mb_languages["W_SECRET_FUNCTION"]	= "加密文功能";
$mb_languages["W_USE_SECRET_LABEL"]	= "使用（可选）,使用（必需）,不使用";
$mb_languages["W_WORDPRESS_POSTID"]	= "WordPress Post ID";
$mb_languages["W_CONNECT_BOARD"]	= "链接公告板";
$mb_languages["W_CATEGORY_FUNCTION"]	= "类别功能";
$mb_languages["W_TAP_MENU_REFRESH"]	= "TabMenu（点击TabMenu时刷新）";
$mb_languages["W_TAP_MENU_AJAX"]	= "TabMenu（点击TabMenu时以AJAX方式载入数据）";
$mb_languages["W_SELECT_CATEGORY_CLICK"]	= "SELECT（点击搜索按钮时适用类别）";
$mb_languages["W_SELECT_CATEGORY_REFRESH"]	= "SELECT（变更类别时刷新）";
$mb_languages["W_SELECT_CATEGORY_AJAX"]	= "SELECT（变更类别时以AJAX方式注入数据）";
$mb_languages["W_CATEGORY_DATA"]	= "类别数据";
$mb_languages["W_BOARD_TOP_TEXT"]	= "公告板上端内容";
$mb_languages["W_BOARD_BOTTOM_TEXT"]	= "公告板下端内容";
$mb_languages["W_WRITING_FORM"]	= "写文章格式";
$mb_languages["W_RECOM_SET"]	= "推荐/不推荐功能设定";
$mb_languages["W_BOARD_RECOM"]	= "公告板推荐功能";
$mb_languages["W_BOARD_NON_RECOM"]	= "公告板不推荐功能";
$mb_languages["W_COMMENT_RECOM"]	= "帖子推荐功能";
$mb_languages["W_COMMENT_NON_RECOM"]	= "帖子不推荐功能";
$mb_languages["W_BOARD_AUTHORITY_SET"]	= "公告板权限设定（0：非会员，1~10：会员，10：管理员）";
$mb_languages["W_AUTHORITY_LIST"]	= "目录权限";
$mb_languages["W_AUTHORITY_WRITE"]	= "写文章权限";
$mb_languages["W_AUTHORITY_VIEW"]	= "查看文章权限";
$mb_languages["W_AUTHORITY_REPLAY"]	= "答复权限";
$mb_languages["W_AUTHORITY_COMMENT"]	= "帖子权限";
$mb_languages["W_AUTHORITY_MODIFY"]	= "修改权限";
$mb_languages["W_AUTHORITY_SECRET"]	= "加密文权限";
$mb_languages["W_AUTHORITY_DELETE"]	= "删除权限";
$mb_languages["W_AUTHORITY_ADMIN"]	= "管理权限";
$mb_languages["W_POINT_SET"]	= "积分设定";
$mb_languages["W_READ_POINT"]	= "阅读积分";
$mb_languages["W_WRITE_POINT"]	= "写作积分";
$mb_languages["W_REPLY_POINT"]	= "答复积分";
$mb_languages["W_COMMENT_POINT"]	= "帖子积分";
$mb_languages["W_BOARD_TYPE"]	= "公告板类型";
$mb_languages["W_CATEGORY1_DISTING_COMMA"]	= "1段（用逗号区分";
$mb_languages["W_CATEGORY2_JSON_TYPE"]	= "2~3段（JSON型）";


$mb_languages["W_MANGBOARD_VERSION"]	= "Mangboard版本";
$mb_languages["W_DB_VERSION"]	= "DB版本";
$mb_languages["W_ADMIN_EMAIL"]	= "管理员邮件";
$mb_languages["W_GOOGLE_ANALYTICS_ID"]	= "谷歌Analytics ID";
$mb_languages["W_NAVER_ANALYTICS_ID"]	= "Naver Analytics ID";
$mb_languages["W_COPY_PREVENTION"]	= "防止复制内容";
$mb_languages["W_ADMIN_LEVEL"]	= "管理员登记";
$mb_languages["W_USER_LEVEL_DISPLAY"]	= "会员等级显示";
$mb_languages["W_USER_THUMBNAILS"]	= "会员缩略图显示";
$mb_languages["W_THUMBNAIL"]		= "缩略图";
$mb_languages["W_SHOW_USER_POP"]	= "会员弹窗显示";
$mb_languages["W_LOGIN_POINT"]	= "会员登录积分";
$mb_languages["W_SING_UP_POINT"]	= "会员加入积分";

$mb_languages["W_SSL_PORT_NUM"]	= "SSL端口号";
$mb_languages["W_SSL_DOMAIN"]	= "SSL域名地址";
$mb_languages["W_SSL_CERTIFICATE"]	= "SSL证书";
$mb_languages["W_UPLOAD_SIZE"]	= "上传文件容量";

$mb_languages["W_IMAGE_SIZE_SMALL"]	= "图片尺寸(Small)";
$mb_languages["W_IMAGE_SIZE_MIDDLE"]	= "图片尺寸(Middle)";


$mb_languages["W_LOGIN_LOG"]	= "登录记录";
$mb_languages["W_POINT_LOG"]	= "积分记录";
$mb_languages["W_ERROR_LOG"]	= "错误记录";


$mb_languages["W_NAME"]	= "姓名";

$mb_languages["W_SING_UP"]	= "加入";
$mb_languages["W_LAST_ACCESS_DATE"]	= "最后访问日";
$mb_languages["W_MODIFICATION"]	= "修改";
$mb_languages["W_STATUS_MESSAGE"]	= "状态信息";
$mb_languages["W_STATUS"]	= "状态";
$mb_languages["W_COIN"]	= "coin";
$mb_languages["W_DATE_OF_BIRTH"]	= "出生年月日";
$mb_languages["W_MOBILE"]	= "手机";
$mb_languages["W_PHOTO"]	= "照片";
$mb_languages["W_MESSENGER"]	= "信使";
$mb_languages["W_HOMEPAGE"]	= "首页";
$mb_languages["W_BLOG"]	= "博客";
$mb_languages["W_HOME_ADDRESS"]	= "家庭地址";
$mb_languages["W_HOME_NUMBER"]	= "家庭电话";
$mb_languages["W_ACCEPT_EMAIL"]	= "允许邮件";
$mb_languages["W_ACCEPT_MESSAGE"]	= "允许消息";
$mb_languages["W_LOGIN_COUNT"]	= "登录数";
$mb_languages["W_WRITE_COUNT"]	= "写文章数";
$mb_languages["W_REPLY_COUNT"]	= "答复数";
$mb_languages["W_MAIL_AUTHENTICATION"]	= "邮件认证";
$mb_languages["W_SING_TIME"]	= "加入时间";
$mb_languages["W_USER_MEMO"]	= "会员备忘录";
$mb_languages["W_ADMIN_MEMO"]	= "管理员备忘录";
$mb_languages["W_ADIT_USER_INFO"]	= "编辑会员信息";
$mb_languages["W_WP_USER_SYNC"]	= "WordPress会员同步化";
$mb_languages["W_ATTACHMENT"]	= "附件";

$mb_languages["W_FILE1"]	= "文件1";
$mb_languages["W_FILE2"]	= "文件2";
$mb_languages["W_OPERATOR"]	= "运营者";
$mb_languages["W_TYPE"]	= "区分";
$mb_languages["W_OPTION_NAME"]	= "选项名称";
$mb_languages["W_OPTION_VALUE"]	= "选项值";
$mb_languages["W_INPUT_TYPE"]	= "INPUT类型";
$mb_languages["W_INPUT_OPTION_NAME"]	= "INPUT选项名称";
$mb_languages["W_INPUT_OPTION"]	= "INPUT选项值";
$mb_languages["W_INPUT_STYLE_SET"]	= "INPUT Style设定";
$mb_languages["W_INPUT_CLASS_SET"]	= "INPUT Class设定";
$mb_languages["W_INPUT_EVENT_SET"]	= "INPUT Event设定";
$mb_languages["W_INPUT_ATTRIBUTE_SET"]	= "INPUT Attribute设定";
$mb_languages["W_EXPLANATION_OPTIONS"]	= "选项说明";
$mb_languages["W_INPUT_OPTION_SET"]	= "接受选项输入的Input标签设定 (text,select,textarea,radiobox)";
$mb_languages["W_INPUT_SELECT_RADIO"]	= "INPUT类型只在select,radiobox的情况下使用";
$mb_languages["W_INPUT_STYLE_SET_DESC"]	= "在选项INPUT类型中设定Style";
$mb_languages["W_INPUT_CLASS_SET_DESC"]	= "在选项INPUT类型中设定Class";
$mb_languages["W_INPUT_EVENT_SET_DESC"]	= "在选项INPUT类型中设定Event";
$mb_languages["W_INPUT_ATTRIBUTE_SET_DESC"]	= "在选项INPUT类型中设定Attribute";





//추가된 단어
$mb_languages["W_ON"]						= "使用";
$mb_languages["W_OFF"]						= "禁用";
$mb_languages["W_ON_OFF"]					= "使用,禁用";
$mb_languages["W_CAPTCHA_ON_OFF"]		= "禁用,使用(Text),使用(Image),";
$mb_languages["W_DENY_ALLOW"]			= "截击,允许";
$mb_languages["W_DESCRIPTION"]			= "说明";
$mb_languages["W_REGDATE"]				= "登记日";
$mb_languages["W_BOARD_PID"]				= "公告编号";


$mb_languages["W_USER_REGDATE"]		= "成员/注册日期";
$mb_languages["W_JOIN_LAST_DATE"]		= "报名/最后访问日期";
$mb_languages["W_SEO"]						= "搜索引擎优化(SEO)";



$mb_languages["W_TODAY_JOIN"]				= "成员计数";
$mb_languages["W_TODAY_WRITE"]			= "帖子数";
$mb_languages["W_TODAY_REPLY"]			= "回复数";
$mb_languages["W_TODAY_COMMENT"]		= "评论";
$mb_languages["W_TODAY_UPLOAD"]		= "上传次数";
$mb_languages["W_TODAY_PAGE_VIEW"]	= "浏览量";
$mb_languages["W_TODAY_VISIT"]				= "访问数";
$mb_languages["W_CUMULATE_VISIT"]		= "访问的累计数";

$mb_languages["W_PHP_VERSION"]			= "PHP 版本";
$mb_languages["W_SITE_LOCALE"]				= "口语";
$mb_languages["W_TOTAL_USER"]				= "正式会员";
$mb_languages["W_TOTAL_FILE"]				= "全部文件";
$mb_languages["W_TOTAL_VISIT"]				= "总访问次数";



//BUTTON		
$mb_words["List"]	= "目录";	
$mb_words["Write"]	= "写文章";	
$mb_words["View"]	= "查看文章";	
$mb_words["Modify"]	= "修改";	
$mb_words["Send_Write"]	= "确认";	//写文章页面传送按钮
$mb_words["Send_Modify"]	= "确认";	//修改页面传送按钮
$mb_words["Send_Reply"]	= "确认";	//答复页面传送按钮
		
$mb_words["Comment_Reply"]	= "回复";	
$mb_words["Send_Comment_Write"]	= "帖子登记";	
$mb_words["Send_Comment_Modify"]	= "帖子修改";	
$mb_words["Send_Comment_Reply"]	= "回复登记";	
		
$mb_words["Move"]	= "移动";	
$mb_words["Copy"]	= "复制";	
$mb_words["All"]	= "全部";	
		
$mb_words["Today"]	= "今天";	
$mb_words["Week"]	= "1周";	
$mb_words["Month"]	= "1个月";	
$mb_words["Last_Month"]	= "上个月";	
		
		
$mb_words["Reply"]	= "答复";	
$mb_words["Delete"]	= "删除";	
$mb_words["Search"]	= "搜索";	
$mb_words["Comment"]	= "帖子";	
$mb_words["Vote_Good"]	= "推荐";	
$mb_words["Vote_Bad"]	= "不推荐";	
$mb_words["Input"]	= "输入";	
$mb_words["OK"]	= "确认";	
$mb_words["Cancel"]	= "取消";	
$mb_words["Setup"]	= "设定";	
$mb_words["More"]	= "查看更多";	
$mb_words["Back"]	= "后退";	
		
$mb_words["Login"]	= "登录";	
$mb_words["Find_Password"]	= "查找密码";	
$mb_words["Join"]	= "会员加入";	
		
$mb_words["First"]	= "开始";	
$mb_words["Prev"]	= "以前";	
$mb_words["Next"]	= "以后";	
$mb_words["Last"]	= "最后";	
		



?>