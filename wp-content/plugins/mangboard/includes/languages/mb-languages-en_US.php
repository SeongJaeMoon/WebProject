<?php		
$mb_language_version	= "1.0.0";	

// 언어에 대한 수정요청은 아래 주소의 메일로 보내주시기 바랍니다.
// E-Mail : mangboard@gmail.com

//ERROR MESSAGE		
$mb_languages["MSG_ERROR"]	= "%s Error";	
$mb_languages["MSG_FIELD_EMPTY_ERROR1"]	= "Enter %s";  // %s is a specific character
$mb_languages["MSG_FIELD_EMPTY_ERROR2"]	= "Enter %s";	// Enter the name
$mb_languages["MSG_FILE_EMPTY_ERROR1"]	= "Upload %s";	
$mb_languages["MSG_FILE_EMPTY_ERROR2"]	=  "Upload %s";	
$mb_languages["MSG_PATTERN_ERROR"]	= "The value of '%s' is not valid";	
$mb_languages["MSG_UNIQUE_ERROR"]	= "'%s'<br> already exists";	
		
$mb_languages["MSG_FILTER_ERROR"]	= "'%s' cannot be used";	
$mb_languages["MSG_PERMISSION_ERROR"]	= "%s does not have authority";	// Access is not authorized. Writing is not authorized.
		
$mb_languages["MSG_EXIST_ERROR"]	= "%s does not exist";	
$mb_languages["MSG_EXIST_ERROR2"]	= "%s %s does not exist";	
$mb_languages["MSG_USE_ERROR"]	= "Available %s lacks";	
		
$mb_languages["MSG_UPLOAD_SIZE_ERROR"]	= "%sMB or more cannot be uploaded";	
$mb_languages["MSG_UPLOAD_EXT"]	= "Only %s file can be uploaded";	
$mb_languages["MSG_UPLOAD_EXT_ERROR"]	= "%s file cannot be uploaded";	
$mb_languages["MSG_MATCH_ERROR"]	= "%s does not match";	
$mb_languages["MSG_NONCE_MATCH_ERROR"]	= "A temporary error has occurred<br>Please refresh and try again later";	
		
		
$mb_languages["MSG_SEARCH_ERROR1"]	= "%s is not found";	
$mb_languages["MSG_SEARCH_ERROR2"]	= "%s is not found";	
		
$mb_languages["MSG_MOVE_SELECT_EMPTY"]	= "Select the items to move";	
$mb_languages["MSG_COPY_SELECT_EMPTY"]	= "Select the items to copy";	
$mb_languages["MSG_DELETE_SELECT_EMPTY"]	= "Select the items to delete";	
$mb_languages["MSG_DELETE_CONFIRM"]	= "Are you sure to delete?";	
$mb_languages["MSG_PASSWD_INPUT"]	= "Enter the password";	
		
$mb_languages["MSG_MULTI_DELETE_CONFIRM"]	= " items, Do you want to delete selected items?";  //three items..... At the beginning a number will be placed (the number will be decided in Java Script)	
$mb_languages["MSG_MULTI_MOVE_CONFIRM"]	= " items, Do you want to move selected items?";  //three items..... At the beginning a number will be placed (the number will be decided in Java Script)	
$mb_languages["MSG_MULTI_COPY_CONFIRM"]	= " items, Do you want to copy selected items?";  //three items..... At the beginning a number will be placed (the number will be decided in Java Script)	
		
$mb_languages["MSG_LIST_ITEM_EMPTY"]	= "No posting exists";	
$mb_languages["MSG_ITEM_NOT_EXIST"]	= "It has been deleted or does not exist";	
$mb_languages["MSG_USER_NOT_EXIST"]	= "The member's information does not exist";	
		
$mb_languages["MSG_PASSWORD_RESET"]	= "New password : ";	// To be before the password at the time of password initialization
		
		
$mb_languages["MSG_VOTE_PARTICIPATE_ERROR"]	= "You have already voted";	
$mb_languages["MSG_REQUIRE_LOGIN"]	= "Log in to use this function";	
$mb_languages["MSG_MOVE_LOGIN"]	= "Please wait while moving to the log in page";	
$mb_languages["MSG_MOVE_PREV"]	= "Please wait while moving to the previous page";	
$mb_languages["MSG_SEND_WRITE_SUCCESS"]	= "Register is completed";	
$mb_languages["MSG_SEND_MAIL_SUCCESS"]	= "The mail has successfully been sent";	
		
$mb_languages["MSG_SECRET"]	= "It is a secret message";	
$mb_languages["MSG_SECRET_PASSWD_INPUT"]	= "It is a secret message<br>Enter the password";	
		
$mb_languages["MSG_EMAIL_FILTER_ERROR"]	= "The email address is not valid";	
$mb_languages["MSG_NAME_FILTER_ERROR"]	= "The name is not valid";	
$mb_languages["MSG_WORD_FILTER_ERROR"]	= "The word is not valid";	
$mb_languages["MSG_CAPTCHA_INPUT"]	= "Enter the auto register prevention code";	
$mb_languages["MSG_TAG_INPUT"]	= "Enter a comma before tag";	
		
$mb_languages["MSG_UPDATE_PERMISSION_ERROR"]	= "You have no authority to update";	
$mb_languages["MSG_UPDATE_CONFIRM"]	= "Check if you have a back-up file on added or modified files before update. Do you want to continue to update?";	
		
$mb_languages["MSG_SELECTBOX"]	= "All";	

		

$mb_languages["MSG_BOARD_NAME_INPUT_CHECK"]	= "Name the board beginning with English letter in a combination of English letters, numbers and _ in 4~30 characters";
$mb_languages["MSG_BOARD_EXPLANATION_INPUT"]	= "Write a short explanation on the board";
$mb_languages["MSG_BOARD_MODEL_SET"]	= "You can set a board model in ‘models’ folder and select skins/skin/includes/skin-model.php file for ‘skin-model’";
$mb_languages["MSG_EDITOR_SELECT"]	= "Select an editor to use for contents input in the writing screen";
$mb_languages["MSG_NUM_POST_ONE_PAGE"]	= "Set the number of postings to be shown in one page";
$mb_languages["MSG_NUM_COMMENT_ONE_PAGE"]	= "Set the number of comments to be shown in one page";
$mb_languages["MSG_PAGE_BLOCK_NUM_SET"]	= "Set the number of page blocks. When it is set to 100, it will change to ‘Show More’ button type";
$mb_languages["MSG_TITLE_BAR_LIST"]	= "Set whether to show a title bar in the posting list";
$mb_languages["MSG_POST_ID_ENTER"]	= "Enter Wordpress Post ID that contains the Mangboard shortcode";
$mb_languages["MSG_BOARD_SET_CHANGE"]	= "Board connection function loads the contents of existing board with a changed setting. If you select ‘connect’, it creates a new board table";
$mb_languages["MSG_SHOW_CATEGORY"]	= "Select a method to show category data";
$mb_languages["MSG_BOARD_TOP_HTML"]	= "Enter HTML tag to be shown at the top of board";
$mb_languages["MSG_BOARD_BOTTOM_HTML"]	= "Enter HTML tag to be shown at the bottom of board";
$mb_languages["MSG_DEFAULT_FORM_ENTER"]	= "Enter a writing form to be shown as default in writing";
$mb_languages["MSG_LIST_VIEW_AUTHORITY"]	= "Set authority to view the list of postings";
$mb_languages["MSG_SET_WRITE"]	= "Set authority to write";
$mb_languages["MSG_SET_VIEW"]	= "Set authority to view writing";
$mb_languages["MSG_SET_REPLY"]	= "Set authority to reply";
$mb_languages["MSG_SET_COMMENT"]	= "Set authority to write comment";
$mb_languages["MSG_AUTHORITY_MODIFY"]	= "Set authority to modify the comments of other users";
$mb_languages["MSG_AUTHORITY_SECRET_MSG"]	= "Set authority to view the secret messages of other users";
$mb_languages["MSG_AUTHORITY_DELETE"]	= "Set authority to delete the postings of other users";
$mb_languages["MSG_AUTHORITY_BOARD_ADMIN"]	= "Set authority on board administration such as posting copy or move";
$mb_languages["MSG_POINT_WRITING"]	= "Enter an amount of points to be granted for writing";
$mb_languages["MSG_POINT_REPLY"]	= "Enter an amount of points to be granted for replying";
$mb_languages["MSG_POINT_COMMENT"]	= "Enter an amount of points to be granted for comment writing";
$mb_languages["MSG_ENTER_SSL_PORT_NUM"]	= "Enter SSL port number (443 port is skippable)";
$mb_languages["MSG_ENTER_SSL_DOMAIN"]	= "Enter SSL domain address";
$mb_languages["MSG_ADDRESS_CERTIFICATE"]	= "Apply SSL authentication certificate to users’ address if there is any installed";
$mb_languages["MSG_LOG_SAVE_SHOW"]	= "Save log-in log and show in Log Management Menu";
$mb_languages["MSG_POINT_LOG_SAVE_SHOW"]	= "Save point log and show in Log Management Menu";
$mb_languages["MSG_ERROR_LOG_SHOW"]	= "Save error log in DV and show in Log Management Menu";
$mb_languages["MSG_ID_INPUT_CHECK"]	= "Enter ID beginning with English letter in a combination of English letters, numbers and _ in 4~20 characters";
$mb_languages["MSG_NAME_INPUT_2MORE"]	= "Enter the name in two or more characters";
$mb_languages["MSG_PASSWORD_INPUT_4MORE"]	= "Enter the password in 4 or more characters";
$mb_languages["MSG_USER_SYNCED"]	= "users are synced";
$mb_languages["MSG_SYNC_NO_USERS"]	= "There is no users available for sync";
$mb_languages["MSG_NOT_REGIST_USER_LOAD"]	= "Load the Wordpress user data that is not registered in Manboard user data";
$mb_languages["MSG_NAME_UNUSABLE"]	= "The name is unusable";
$mb_languages["MSG_WORD_UNUSABLE"]	= "The word is unusable";


$mb_languages["MSG_COPY_MOUSE_PREVENT"]	= "Set to prevent mouse drag or right button clicking (except manager)";
$mb_languages["MSG_ADMIN_LEVEL_SET"]	= "Administrator’s level setting (except the use of notice function and other functions)";
$mb_languages["MSG_USER_NAME_LEVEL_SET"]	= "show the level beside the user’s name";
$mb_languages["MSG_USER_NAME_PHOTO_SET"]	= "show the photo before the user’s name";
$mb_languages["MSG_USER_NAME_POPUP_SET"]	= "click user’s name to show the user’s data in a pop-up window";
$mb_languages["MSG_LOGIN_POINT_SET"]	= "log-in point (set to 0 for nonuse)";

$mb_languages["MSG_SING_UP_POINT_SET"]	= "points for usership sign-up (set to 0 for nonuse)";
$mb_languages["MSG_FILE_UPLOAD_SIZE"]	= "file upload size";
$mb_languages["MSG_MAKE_IMAGE_SMALL_DESC"]	= "Minimize an upload image in a desired proportion : Adjust size in the model (\"field\":\"fn_image_path\",\"size\":\"small\"). Original image will be loaded in case of the absence of small image";
$mb_languages["MSG_MAKE_IMAGE_MIDDLE_DESC"]	= "Minimize an upload image in a desired proportion : Adjust size in the model (\"field\":\"fn_image_path\",\"size\":\"middle\"). Original image will be loaded in case of the absence of middle image";
$mb_languages["MSG_ACCESS_IP_ALLOW_DESC"]		= "";


		
		
//WORD		
$mb_languages["W_ID"]	= "ID";	
$mb_languages["W_PASSWORD"]	= "Password";	
$mb_languages["W_SECRET"]	= "Secret";	
$mb_languages["W_NOTICE"]	= "Notice";	
$mb_languages["W_SKIN"]	= "Skin";	
$mb_languages["W_SETUP"]	= "Setting";	
$mb_languages["W_DELETE"]	= "Delete";	
$mb_languages["W_TOTAL"]	= "Total";	
$mb_languages["W_ALL"]	= "All";	
$mb_languages["W_YEAR"]	= "Year";	
$mb_languages["W_MONTH"]	= "Month";	
		
		
$mb_languages["W_MANGBOARD"]	= "Mangboard";	
$mb_languages["W_HOMEPAGE"]	= "Homepage";	
$mb_languages["W_MANUAL"]	= "Manual";	
$mb_languages["W_TECH_SUPPORT"]	= "Technique support";	
$mb_languages["W_COMMUNITY"]	= "Community";	
		
		
$mb_languages["W_PID"]	= "No";	
$mb_languages["W_HIT"]	= "Hit";	
$mb_languages["W_DATE"]	= "Date";	
$mb_languages["W_EMAIL"]	= "Email";	
$mb_languages["W_IMAGE"]	= "Image";	
$mb_languages["W_TITLE"]	= "Title";	
$mb_languages["W_USER_NAME"]	= "Writer";	
$mb_languages["W_USER_NAME_PID"]	= "Writer [Pid]";
$mb_languages["W_WRITER"]	= "Writer";

$mb_languages["W_CONTENT"]	= "Content";	
$mb_languages["W_TAG"]	= "Tag";	
$mb_languages["W_LEVEL"]	= "Level";	
$mb_languages["W_POINT"]	= "Point";	
$mb_languages["W_GROUP"]	= "Group";	
$mb_languages["W_MEMO"]	= "Memo";	
$mb_languages["W_FILE"]	= "File";	
$mb_languages["W_BOARD_FILE"]	= "Attachment";	
$mb_languages["W_DOWNLOAD"]	= "Download";	
$mb_languages["W_UPDATE"]	= "Update";	
$mb_languages["W_ADDRESS"]	= "Address";	
$mb_languages["W_RANK"]	= "Rank";	
$mb_languages["W_COUNT"]	= "Count";	
$mb_languages["W_TYPE"]	= "Type";	
$mb_languages["W_VALUE"]	= "Content";	
$mb_languages["W_SITE"]	= "Site";	
$mb_languages["W_VERSION"]	= "Version";	
$mb_languages["W_SESSION"]	= "Session";	
$mb_languages["W_ICON"]	= "Icon";	
$mb_languages["W_TEST"]	= "Test";	
$mb_languages["W_FREE"]	= "Free";	
$mb_languages["W_SEARCH"]	= "Search";	
		
$mb_languages["W_PREV"]	= "Prev";	
$mb_languages["W_NEXT"]	= "Next";	
		
$mb_languages["W_ADD"]	= "Register";	
$mb_languages["W_LIST"]	= "List";	
$mb_languages["W_VIEW"]	= "View";	
$mb_languages["W_WRITE"]	= "Write";	
$mb_languages["W_MODIFY"]	= "Modify";	
$mb_languages["W_REPLY"]	= "Reply";	
$mb_languages["W_REPLY_WRITE"]	= "Write Reply";	
$mb_languages["W_COMMENT_WRITE"]	= "Write Comment";	
$mb_languages["W_MOVE"]	= "Move";	
$mb_languages["W_COPY"]	= "Copy";	
$mb_languages["W_ACCESS"]	= "Access";	
		
$mb_languages["W_DASHBOARD"]	= "Dashboard";	
$mb_languages["W_BOARD"]	= "Board";	
$mb_languages["W_BOARD_INSERT"]	= "Add Board";	
$mb_languages["W_BOARD_ITEM"]	= "Postings";	
		
$mb_languages["W_BOARD_DATA"]	= "Basic";	
$mb_languages["W_BOARD_GALLERY"]	= "Gallery";	
$mb_languages["W_BOARD_CALENDAR"]	= "Callendar";	
$mb_languages["W_BOARD_WEBZINE"]	= "Webzine";	
$mb_languages["W_BOARD_LATESET"]	= "Recent Postings";	
$mb_languages["W_COMMENT_LATESET"]	= "Recent Comments";	
$mb_languages["W_REFERER_LATESET"]	= "Recent Inflow URL";	
$mb_languages["W_SUMMARY_STATISTICS"]	= "Statistics";	
$mb_languages["W_CURRENT_STATE"]	= "Status";	
		
$mb_languages["W_COMMENT"]	= "Comment";	
$mb_languages["W_CATEGORY"]	= "Category";	
$mb_languages["W_BOARD_VOTE_GOOD"]	= "Recommend the Posting";	
$mb_languages["W_BOARD_VOTE_BAD"]	= "Not Recommend the Posting";	
$mb_languages["W_COMMENT_VOTE_GOOD"]	= "Recommend Comment";	
$mb_languages["W_COMMENT_VOTE_BAD"]	= "Not Recommend Comment";	
		
$mb_languages["W_START_DATE"]	= "Start Date";	
$mb_languages["W_END_DATE"]	= "End Date";	
		
$mb_languages["W_BOARD_LINK_NONE"]	= "Not Link";	
$mb_languages["W_BOARD_LINK_INPUT"]	= "Directly Input";	
		
		
		
$mb_languages["W_LOGIN"]	= "Login";	
$mb_languages["W_LOGOUT"]	= "Log Out";	
$mb_languages["W_AUTO_LOGIN"]	= "Automatic Login";	
$mb_languages["W_USER"]	= "User";	
$mb_languages["W_USER_PID"]					= "User [Pid]";
$mb_languages["W_USER_INFO"]	= "User's Information";	
$mb_languages["W_USER_JOIN"]	= "Join";	
$mb_languages["W_USER_INSERT"]	= "Register User";	
$mb_languages["W_USER_LEVEL"]	= "User Level";	
$mb_languages["W_USER_MODIFY"]	= "Modify";	
$mb_languages["W_PASSWORD_LOST"]	= "Find Password";	
$mb_languages["W_KCAPTCHA"]	= "Captcha Code";
$mb_languages["W_CAPTCHA"]	= "Captcha Code";
		
$mb_languages["W_CURRENCY"]	= "Won";	
$mb_languages["W_NUMBER_SUFFIX"]	= "Quantity";	
		
$mb_languages["W_TODAY"]	= "Today";	
$mb_languages["W_YESTERDAY"]	= "Yesterday";	
$mb_languages["W_ONE_WEEK"]	= "1 Week";	
$mb_languages["W_ONE_MONTH"]	= "1 Month";	
$mb_languages["W_THIS_MONTH"]	= "This Month";	
$mb_languages["W_LAST_MONTH"]	= "Last Month";	
		
		
		
		
		
//ADMIN MENU		
$mb_languages["W_MENU_DASHBOARD"]	= "Dashboard";	
$mb_languages["W_MENU_BOARD"]	= "Board Setting";	
$mb_languages["W_MENU_USER"]	= "Users";
$mb_languages["W_MENU_FILE"]	= "Files";	
$mb_languages["W_MENU_OPTION"]	= "Option Setting";	
$mb_languages["W_MENU_COOKIE"]	= "Cookie";	
$mb_languages["W_MENU_ANALYTICS"]	= "Statistics";	
$mb_languages["W_MENU_H_EDITOR"]	= "HometoryEditor";	
$mb_languages["W_MENU_REFERER"]	= "Referers";	
$mb_languages["W_MENU_LOG"]	= "Logs";	
$mb_languages["W_MENU_ACCESSIP"]	= "Access IP";	
		
		
//USER MENU		
$mb_languages["W_USER_SEARCH"]	= "View Postings";	
$mb_languages["W_USER_INFO"]	= "User Information";	
$mb_languages["W_USER_EMAIL"]	= "Send Mail";	
$mb_languages["W_USER_HOMEPAGE"]	= "Homepage";	
$mb_languages["W_USER_BLOG"]	= "Blog";	
$mb_languages["W_USER_MESSAGE"]	= "Send Messages";	
				

$mb_languages["W_BOARD_NAME"]	= "Name of Board";
$mb_languages["W_BOARD_NAME_PID"]	= "Name of Board [PID]";

$mb_languages["W_SKIN_MODEL"]	= "Skin/Model";

$mb_languages["W_AUTHORITY"]	= "Authority";

$mb_languages["W_STATUS_POSTINGS"]	= "Status";
$mb_languages["W_SETTING"]	= "Setting";

$mb_languages["W_BOARD_SETTING"]	= "Board Setting";

$mb_languages["W_VIEW_MSG"]	= "View Messages";

$mb_languages["W_EXPLANATION_BOARD"]	= "Explanation on Board";

$mb_languages["W_SKIN_NAME"]	= "Name of Skin";

$mb_languages["W_MODEL_NAME"]	= "Model Name";

$mb_languages["W_EDITOR_SETTING"]	= "Editor Setting";

$mb_languages["W_LIST_COUNT"]	= "Number of Lists";

$mb_languages["W_COMMENT_COUNT"]	= "Number of Comment";

$mb_languages["W_PAGE_BLOCK_COUNT"]	= "Number of page blocks";

$mb_languages["W_SHOW_TITLE_BAR"]	= "Show a list title bar";

$mb_languages["W_COMMENT_FUNCTION"]	= "Comment Function";

$mb_languages["W_NOTIFI_FUNCTION"]	= "Notification Function";

$mb_languages["W_SECRET_FUNCTION"]	= "Secret message function";

$mb_languages["W_USE_SECRET_LABEL"]	= "Use(selective), Use(essential), Nonuse";

$mb_languages["W_WORDPRESS_POSTID"]	= "Wordpress Post ID";

$mb_languages["W_CONNECT_BOARD"]	= "Connect Board";

$mb_languages["W_CATEGORY_FUNCTION"]	= "Category Function";

$mb_languages["W_TAP_MENU_REFRESH"]	= "Tap Menu(click tap menu to refresh)";

$mb_languages["W_TAP_MENU_AJAX"]	= "Tap Menu(click tap menu to load data in AJAX type)";

$mb_languages["W_SELECT_CATEGORY_CLICK"]	= "SELECT(applied to category when search button is clicked only)";

$mb_languages["W_SELECT_CATEGORY_REFRESH"]	= "SELECT(change category to refresh)";
$mb_languages["W_SELECT_CATEGORY_AJAX"]	= "SELECT(change category to load data in AJAX type)";

$mb_languages["W_CATEGORY_DATA"]	= "Category Data";

$mb_languages["W_BOARD_TOP_TEXT"]	= "Contents at the top of board";

$mb_languages["W_BOARD_BOTTOM_TEXT"]	= "Contents at the bottom of board";

$mb_languages["W_WRITING_FORM"]	= "Writing Form";

$mb_languages["W_RECOM_SET"]	= "Like / Not Like Button setting";

$mb_languages["W_BOARD_RECOM"]	= "Board - Like Button";

$mb_languages["W_BOARD_NON_RECOM"]	= "Board - Not Like Button";

$mb_languages["W_COMMENT_RECOM"]	= "Comment - Like Button";

$mb_languages["W_COMMENT_NON_RECOM"]	= "Comment - Not Like Button";

$mb_languages["W_BOARD_AUTHORITY_SET"]	= "Board authority setting (0: nonuser, 1~10: user, 10: administrator)";

$mb_languages["W_AUTHORITY_LIST"]	= "Authority on List";

$mb_languages["W_AUTHORITY_WRITE"]	= "Authority to Write";

$mb_languages["W_AUTHORITY_VIEW"]	= "Authority to view messages";

$mb_languages["W_AUTHORITY_REPLAY"]	= "Authority to Reply";

$mb_languages["W_AUTHORITY_COMMENT"]	= "Authority to write comment";

$mb_languages["W_AUTHORITY_MODIFY"]	= "Authority to Modify";

$mb_languages["W_AUTHORITY_SECRET"]	= "Authority on secret messages";

$mb_languages["W_AUTHORITY_DELETE"]	= "Authority to Delete";

$mb_languages["W_AUTHORITY_ADMIN"]	= "Administration Authority";

$mb_languages["W_POINT_SET"]	= "Point Setting";

$mb_languages["W_READ_POINT"]	= "Reading Point";

$mb_languages["W_WRITE_POINT"]	= "Writing Point";

$mb_languages["W_REPLY_POINT"]	= "Reply Point";

$mb_languages["W_COMMENT_POINT"]	= "Comment Point";

$mb_languages["W_BOARD_TYPE"]	= "Board Type";
$mb_languages["W_CATEGORY1_DISTING_COMMA"]	= "Part 1 (distinguished by comma)";

$mb_languages["W_CATEGORY2_JSON_TYPE"]	= "Part 2~3 (JSON type)";

$mb_languages["W_MANGBOARD_VERSION"]	= "Mangboard Version";

$mb_languages["W_DB_VERSION"]	= "DB Version";

$mb_languages["W_ADMIN_EMAIL"]	= "Administrator’s E-mail";

$mb_languages["W_GOOGLE_ANALYTICS_ID"]	= "Google Analytics ID";

$mb_languages["W_NAVER_ANALYTICS_ID"]	= "Naver Analytics ID";

$mb_languages["W_COPY_PREVENTION"]	= "Contents Copy Prevention";
$mb_languages["W_ADMIN_LEVEL"]	= "Administrator’s Level";
$mb_languages["W_USER_LEVEL_DISPLAY"]	= "User’s level display";
$mb_languages["W_USER_THUMBNAILS"]	= "Show thumbnails of users";
$mb_languages["W_THUMBNAIL"]		= "Thumbnail";
$mb_languages["W_SHOW_USER_POP"]	= "Show user’s pop-up window";
$mb_languages["W_LOGIN_POINT"]	= "User log-in point";
$mb_languages["W_SING_UP_POINT"]	= "Points for usership sign-up";

$mb_languages["W_SSL_PORT_NUM"]	= "SSL port number";
$mb_languages["W_SSL_DOMAIN"]	= "SSL domain address";
$mb_languages["W_SSL_CERTIFICATE"]	= "SSL authentication certificate";
$mb_languages["W_UPLOAD_SIZE"]	= "Upload file size";



$mb_languages["W_IMAGE_SIZE_SMALL"]	= "Image Size (Small)";

$mb_languages["W_IMAGE_SIZE_MIDDLE"]	= "image size (Middle)";



$mb_languages["W_LOGIN_LOG"]	= "Login Log";

$mb_languages["W_POINT_LOG"]	= "Point Log";

$mb_languages["W_ERROR_LOG"]	= "Error Log";
$mb_languages["W_NAME"]	= "Name";

$mb_languages["W_SING_UP"]	= "Sign Up";

$mb_languages["W_LAST_ACCESS_DATE"]	= "Last access date";

$mb_languages["W_MODIFICATION"]	= "Modify";

$mb_languages["W_STATUS_MESSAGE"]	= "Status Message";
$mb_languages["W_STATUS"]	= "Status";

$mb_languages["W_COIN"]	= "Coin";

$mb_languages["W_DATE_OF_BIRTH"]	= "Date of Birth";

$mb_languages["W_MOBILE"]	= "Mobile Phone";

$mb_languages["W_PHOTO"]	= "Photo";

$mb_languages["W_MESSENGER"]	= "Messenger";

$mb_languages["W_HOMEPAGE"]	= "Website";

$mb_languages["W_BLOG"]	= "Blog";

$mb_languages["W_HOME_ADDRESS"]	= "Home Address";

$mb_languages["W_HOME_NUMBER"]	= "Home Number";

$mb_languages["W_ACCEPT_EMAIL"]	= "Accept Email";

$mb_languages["W_ACCEPT_MESSAGE"]	= "Accept Message";

$mb_languages["W_LOGIN_COUNT"]	= "Log-In Time";

$mb_languages["W_WRITE_COUNT"]	= "Number of Writing";

$mb_languages["W_REPLY_COUNT"]	= "Number of Response";

$mb_languages["W_MAIL_AUTHENTICATION"]	= "Mail Authentication";

$mb_languages["W_SING_TIME"]	= "Sing Up Time";

$mb_languages["W_USER_MEMO"]	= "User’s Memo";

$mb_languages["W_ADMIN_MEMO"]	= "Administrator’s Memo";

$mb_languages["W_ADIT_USER_INFO"]	= "Edit user’s information";

$mb_languages["W_WP_USER_SYNC"]	= "Wordpress user sync";

$mb_languages["W_ATTACHMENT"]	= "Attachment";

$mb_languages["W_FILE1"]	= "File 1";

$mb_languages["W_FILE2"]	= "File 2";

$mb_languages["W_OPERATOR"]	= "Operator";

$mb_languages["W_TYPE"]	= "Type";

$mb_languages["W_OPTION_NAME"]	= "Option Name";

$mb_languages["W_OPTION_VALUE"]	= "Option Value";

$mb_languages["W_INPUT_TYPE"]	= "Input Type";

$mb_languages["W_INPUT_OPTION_NAME"]	= "Input option name";

$mb_languages["W_INPUT_OPTION"]	= "Input option value";

$mb_languages["W_INPUT_STYLE_SET"]	= "Input style setting";

$mb_languages["W_INPUT_CLASS_SET"]	= "Input class setting";

$mb_languages["W_INPUT_EVENT_SET"]	= "Input event setting";

$mb_languages["W_INPUT_ATTRIBUTE_SET"]	= "Input attribute setting";

$mb_languages["W_EXPLANATION_OPTIONS"]	= "Explanation on options";

$mb_languages["W_INPUT_OPTION_SET"]	= "Set input tag for option input (text,select,textarea,radiobox)";

$mb_languages["W_INPUT_SELECT_RADIO"]	= "Use only if the input type is select or radiobox";

$mb_languages["W_INPUT_STYLE_SET_DESC"]	= "Set style of option input type";

$mb_languages["W_INPUT_CLASS_SET_DESC"]	= "Set class of option input type";

$mb_languages["W_INPUT_EVENT_SET_DESC"]	= "Set event of option input type";

$mb_languages["W_INPUT_ATTRIBUTE_SET_DESC"]	= "Set attribute of option input type";


$mb_languages["W_ON"]							= "On";
$mb_languages["W_OFF"]							= "Off";
$mb_languages["W_ON_OFF"]					= "On,Off";
$mb_languages["W_CAPTCHA_ON_OFF"]		= "Off,On(Text),On(Image),";
$mb_languages["W_DENY_ALLOW"]			= "Access Interruption,Allowing Access";
$mb_languages["W_DESCRIPTION"]			= "Description";
$mb_languages["W_REGDATE"]					= "Registration Date";
$mb_languages["W_BOARD_PID"]				= "Board Pid";


$mb_languages["W_USER_REGDATE"]			= "User/Registration Date";
$mb_languages["W_JOIN_LAST_DATE"]		= "Join/Last Access Date";
$mb_languages["W_SEO"]							= "Search Engine Optimization";

$mb_languages["W_TODAY_JOIN"]				= "Join";
$mb_languages["W_TODAY_WRITE"]			= "Write";
$mb_languages["W_TODAY_REPLY"]			= "Reply";
$mb_languages["W_TODAY_COMMENT"]		= "Comment";
$mb_languages["W_TODAY_UPLOAD"]		= "Upload";
$mb_languages["W_TODAY_PAGE_VIEW"]	= "PageView";
$mb_languages["W_TODAY_VISIT"]				= "Visit";
$mb_languages["W_CUMULATE_VISIT"]		= "Total Visits";

$mb_languages["W_PHP_VERSION"]			= "PHP Version";
$mb_languages["W_SITE_LOCALE"]				= "Language";
$mb_languages["W_TOTAL_USER"]				= "Total Members";
$mb_languages["W_TOTAL_FILE"]				= "Total Files";
$mb_languages["W_TOTAL_VISIT"]				= "Total Visits";




		
//BUTTON		
$mb_words["List"]	= "List";	
$mb_words["Write"]	= "Write";	
$mb_words["View"]	= "View";	
$mb_words["Modify"]	= "Modify";	
$mb_words["Send_Write"]	= "Submit";	// send button in 'write' page
$mb_words["Send_Modify"]	= "Submit";	// send button in 'modify' page
$mb_words["Send_Reply"]	= "Submit";	// send button in 'reply' page
		
$mb_words["Comment_Reply"]	= "Reply";	
$mb_words["Send_Comment_Write"]	= "Comment Write";	
$mb_words["Send_Comment_Modify"]	= "Comment Modify";	
$mb_words["Send_Comment_Reply"]	= "Comment Reply";	
		
$mb_words["Move"]	= "Move";	
$mb_words["Copy"]	= "Copy";	
$mb_words["All"]	= "All";	
		
$mb_words["Today"]	= "Today";	
$mb_words["Week"]	= "1 Week";	
$mb_words["Month"]	= "1 Month";	
$mb_words["Last_Month"]	= "Last Month";	
		
		
$mb_words["Reply"]	= "Reply";	
$mb_words["Delete"]	= "Delete";	
$mb_words["Search"]	= "Search";	
$mb_words["Comment"]	= "Comment";	
$mb_words["Vote_Good"]	= "Like";	
$mb_words["Vote_Bad"]	= "Not Like";	
$mb_words["Input"]	= "Input";	
$mb_words["OK"]	= "Ok";	
$mb_words["Cancel"]	= "Cancel";	
$mb_words["Setup"]	= "Setting";	
$mb_words["More"]	= "More";	
$mb_words["Back"]	= "Go Back";	
		
$mb_words["Login"]	= "Login";	
$mb_words["Find_Password"]	= "Find Password";	
$mb_words["Join"]	= "Join";	
		
$mb_words["First"]	= "First";	
$mb_words["Prev"]	= "Prev";	
$mb_words["Next"]	= "Next";	
$mb_words["Last"]	= "Last";	

		

?>