<?php
$mb_language_version					= "1.0.0";

// 언어에 대한 수정요청은 아래 주소의 메일로 보내주시기 바랍니다.
// E-Mail : mangboard@gmail.com

//ERROR MESSAGE
$mb_languages["MSG_ERROR"]										= "%s Error";
$mb_languages["MSG_FIELD_EMPTY_ERROR1"]					= "%s를 입력해 주세요";
$mb_languages["MSG_FIELD_EMPTY_ERROR2"]					= "%s을 입력해 주세요";
$mb_languages["MSG_FILE_EMPTY_ERROR1"]					= "%s를 업로드 해주세요";
$mb_languages["MSG_FILE_EMPTY_ERROR2"]					= "%s을 업로드 해주세요";
$mb_languages["MSG_PATTERN_ERROR"]							= "'%s' 값이 정상적인 값이 아닙니다";
$mb_languages["MSG_UNIQUE_ERROR"]							= "'%s'<br>이미 존재하는 %s입니다";

$mb_languages["MSG_FILTER_ERROR"]							= "'%s' 사용할 수 없는 단어입니다";
$mb_languages["MSG_PERMISSION_ERROR"]					= "%s 권한이 없습니다";

$mb_languages["MSG_EXIST_ERROR"]								= "%s가 존재하지 않습니다";
$mb_languages["MSG_EXIST_ERROR2"]							= "%s %s이 존재하지 않습니다";
$mb_languages["MSG_USE_ERROR"]								= "사용 가능한 %s가 부족합니다";

$mb_languages["MSG_UPLOAD_SIZE_ERROR"]					= "%sMB 이상 업로드 할 수 없습니다";
$mb_languages["MSG_UPLOAD_EXT"]								= "%s 파일만 업로드 할 수 있습니다";
$mb_languages["MSG_UPLOAD_EXT_ERROR"]					= "%s 파일은 업로드 할 수 없습니다";
$mb_languages["MSG_MATCH_ERROR"]							= "%s가 일치하지 않습니다";
$mb_languages["MSG_NONCE_MATCH_ERROR"]				= "일시적인 장애가 발생했습니다<br>새로고침 후 다시 시도해 주세요";


$mb_languages["MSG_SEARCH_ERROR1"]						= "%s을 찾을 수 없습니다";
$mb_languages["MSG_SEARCH_ERROR2"]						= "%s를 찾을 수 없습니다";

$mb_languages["MSG_MOVE_SELECT_EMPTY"]					= "이동할 항목을 선택해 주세요";
$mb_languages["MSG_COPY_SELECT_EMPTY"]					= "복사할 항목을 선택해 주세요";
$mb_languages["MSG_DELETE_SELECT_EMPTY"]				= "삭제할 항목을 선택해 주세요";
$mb_languages["MSG_DELETE_CONFIRM"]						= "삭제하시겠습니까?";
$mb_languages["MSG_PASSWD_INPUT"]							= "비밀번호를 입력해 주세요";

$mb_languages["MSG_MULTI_DELETE_CONFIRM"]				= "개의 항목을 삭제하시겠습니까?";  //3개의 항목을... 앞에 숫자가 들어감 (숫자는 자바스크립트에서 정해짐)
$mb_languages["MSG_MULTI_MOVE_CONFIRM"]				= "개의 항목을 이동하시겠습니까?";  //3개의 항목을... 앞에 숫자가 들어감 (숫자는 자바스크립트에서 정해짐)
$mb_languages["MSG_MULTI_COPY_CONFIRM"]				= "개의 항목을 복사하시겠습니까?";  //3개의 항목을... 앞에 숫자가 들어감 (숫자는 자바스크립트에서 정해짐)

$mb_languages["MSG_LIST_ITEM_EMPTY"]						= "등록된 게시물이 없습니다";
$mb_languages["MSG_ITEM_NOT_EXIST"]							= "삭제되었거나 존재하지 않는 내용입니다";
$mb_languages["MSG_USER_NOT_EXIST"]						= "일치하는 회원정보가 존재하지 않습니다";

$mb_languages["MSG_PASSWORD_RESET"]						= "새로운 비밀번호 : ";		// 비밀번호 초기화시 비밀번호 앞에 들어갈 내용


$mb_languages["MSG_VOTE_PARTICIPATE_ERROR"]			= "이미 참여하셨습니다";
$mb_languages["MSG_REQUIRE_LOGIN"]							= "로그인이 필요한 기능입니다";
$mb_languages["MSG_MOVE_LOGIN"]								= "로그인 페이지로 이동합니다";
$mb_languages["MSG_MOVE_PREV"]								= "이전 페이지로 이동합니다";
$mb_languages["MSG_SEND_WRITE_SUCCESS"]				= "정상적으로 등록되었습니다";
$mb_languages["MSG_SEND_MAIL_SUCCESS"]					= "메일이 발송되었습니다";

$mb_languages["MSG_SECRET"]										= "비밀글입니다";
$mb_languages["MSG_SECRET_PASSWD_INPUT"]				= "비밀글입니다<br>비밀번호를 입력해 주세요";

$mb_languages["MSG_EMAIL_FILTER_ERROR"]					= "정상적인 이메일 주소가 아닙니다";
$mb_languages["MSG_NAME_FILTER_ERROR"]					= "사용할 수 없는 이름입니다";
$mb_languages["MSG_WORD_FILTER_ERROR"]					= "사용할 수 없는 단어입니다";
$mb_languages["MSG_CAPTCHA_INPUT"]						= "자동등록방지 숫자를 입력해 주세요";
$mb_languages["MSG_TAG_INPUT"]								= "태그는 쉼표로 구분해서 입력해 주세요";

$mb_languages["MSG_UPDATE_PERMISSION_ERROR"]		= "업데이트 권한이 없습니다";
$mb_languages["MSG_UPDATE_CONFIRM"]						= "업데이트 전에 추가 및 수정된 파일에 대한 백업을 확인해 주세요. 업데이트를 진행 하시겠습니까?";

$mb_languages["MSG_SELECTBOX"]								= "전체";



$mb_languages["MSG_BOARD_NAME_INPUT_CHECK"]	= "게시판 이름은 영문으로 시작하는 4~30자'영문','숫자','_' 조합이여야 합니다";
$mb_languages["MSG_BOARD_EXPLANATION_INPUT"]	= "게시판에 대한 간단한 설명을 입력합니다";

$mb_languages["MSG_BOARD_MODEL_SET"]	= "'models' 폴더에 있는 게시판 모델을 설정할 수 있으며,  'skin-model'은 skins/스킨/includes/skin-model.php 파일을 선택합니다";

$mb_languages["MSG_EDITOR_SELECT"]	= "글쓰기 화면에서 내용 입력시 사용할 에디터를 선택합니다";
$mb_languages["MSG_NUM_POST_ONE_PAGE"]	= "한페이지에서 보여줄 게시물 개수를 설정합니다";
$mb_languages["MSG_NUM_COMMENT_ONE_PAGE"]	= "한페이지에서 보여줄 댓글 개수를 설정합니다";
$mb_languages["MSG_PAGE_BLOCK_NUM_SET"]	= "페이지 블럭 개수를 설정합니다, 100으로 설정시 \"더보기\" 버튼 방식으로 변경됩니다";
$mb_languages["MSG_TITLE_BAR_LIST"]	= "게시물 목록에서 제목바 표시여부를 설정합니다";
$mb_languages["MSG_POST_ID_ENTER"]	= "망보드 Shortcode가 들어있는 워드프레스 Post ID를 입력합니다";
$mb_languages["MSG_BOARD_SET_CHANGE"]	= "게시판 연결은 기존에 생성한 게시판의 내용을 설정만 바꿔서 불러올 수 있는 기능입니다. '연결안함'을 선택할 경우 게시판 테이블을 새로 생성합니다";
$mb_languages["MSG_SHOW_CATEGORY"]	= "카테고리 데이타를 보여줄 방식을 선택합니다";

$mb_languages["MSG_BOARD_TOP_HTML"]	= "게시판 상단에 보여줄 HTML 태그를 입력합니다";
$mb_languages["MSG_BOARD_BOTTOM_HTML"]	= "게시판 하단에 보여줄 HTML 태그를 입력합니다";
$mb_languages["MSG_DEFAULT_FORM_ENTER"]	= "글쓰기에서 기본으로 보여줄 글쓰기 폼을 입력합니다";
$mb_languages["MSG_LIST_VIEW_AUTHORITY"]	= "게시물 목록을 볼 수 있는 권한을 설정합니다";
$mb_languages["MSG_SET_WRITE"]	= "글쓰기 권한을 설정합니다";
$mb_languages["MSG_SET_VIEW"]	= "글보기 권한을 설정합니다";
$mb_languages["MSG_SET_REPLY"]	= "답변 권한을 설정합니다";
$mb_languages["MSG_SET_COMMENT"]	= "댓글 권한을 설정합니다";
$mb_languages["MSG_AUTHORITY_MODIFY"]	= "다른 사용자가 작성한 글을 수정할 수 있는 권한을 설정합니다";
$mb_languages["MSG_AUTHORITY_SECRET_MSG"]	= "다른 사용자의 비밀글을 볼 수 있는 권한을 설정합니다";
$mb_languages["MSG_AUTHORITY_DELETE"]	= "다른 사용자의 게시물을 삭제할 수 있는 권한을 설정합니다";
$mb_languages["MSG_AUTHORITY_BOARD_ADMIN"]	= "게시물 복사, 이동 등 게시판을 관리 할 수 있는 권한을 설정합니다";
$mb_languages["MSG_POINT_WRITING"]	= "글작성시 지급할 포인트를 입력합니다";
$mb_languages["MSG_POINT_REPLY"]	= "답변 작성시 지급할 포인트를 입력합니다";
$mb_languages["MSG_POINT_COMMENT"]	= "댓글 작성시 지급할 포인트를 입력합니다";
$mb_languages["MSG_ENTER_SSL_PORT_NUM"]	= "SSL 포트번호를 입력합니다 (443 포트는 생략 가능)";
$mb_languages["MSG_ENTER_SSL_DOMAIN"]	= "SSL 도메인 주소를 입력합니다 (동일하면 생략 가능)";
$mb_languages["MSG_ADDRESS_CERTIFICATE"]	= "SSL 인증서가 설치되어 있을 경우 회원 관련 주소에 인증서를 적용합니다";

$mb_languages["MSG_LOG_SAVE_SHOW"]	= "로그인 로그를 저장하여  Log 관리 메뉴를 통해 확인 할 수 있습니다";
$mb_languages["MSG_POINT_LOG_SAVE_SHOW"]	= "포인트 로그를 저장하여 Log 관리 메뉴를 통해 확인 할 수 있습니다";
$mb_languages["MSG_ERROR_LOG_SHOW"]	= "에러 로그를 디비에 저장하여 Log 관리 메뉴를 통해 확인 할 수 있습니다";

$mb_languages["MSG_ID_INPUT_CHECK"]	= "아이디는 영문으로 시작하는 4~20자'영문','숫자','_' 조합이여야 합니다";

$mb_languages["MSG_NAME_INPUT_2MORE"]	= "이름은 최소 2자리 이상 입력하셔야 합니다";

$mb_languages["MSG_PASSWORD_INPUT_4MORE"]	= "비밀번호는 최소 4자리 이상 입력하셔야 합니다";

$mb_languages["MSG_USER_SYNCED"]	= "명의 회원이 동기화 되었습니다";

$mb_languages["MSG_SYNC_NO_USERS"]	= "동기화 가능한 회원이 존재하지 않습니다";

$mb_languages["MSG_NOT_REGIST_USER_LOAD"]	= "망보드 회원 데이타에 등록되지 않은 워드프레스 회원 데이타를 가져옵니다";

$mb_languages["MSG_NAME_UNUSABLE"]	= "사용할 수 없는 이름입니다";
$mb_languages["MSG_WORD_UNUSABLE"]	= "사용할 수 없는 단어입니다";

$mb_languages["MSG_COPY_MOUSE_PREVENT"]	= "마우스 우클릭 및 드래그 안되도록 설정(관리자 예외)";
$mb_languages["MSG_ADMIN_LEVEL_SET"]	= "관리자 레벨 설정(공지기능 사용 및 일부 제한 기능 예외됨)";
$mb_languages["MSG_USER_NAME_LEVEL_SET"]	= "회원 이름 옆에 레벨 표시";
$mb_languages["MSG_USER_NAME_PHOTO_SET"]	= "회원 이름 앞에 사진 표시";
$mb_languages["MSG_USER_NAME_POPUP_SET"]	= "회원 이름 클릭시 회원정보 팝업창 표시";
$mb_languages["MSG_LOGIN_POINT_SET"]	= "로그인 포인트 (미사용시 0으로 설정)";
$mb_languages["MSG_SING_UP_POINT_SET"]	= "회원 가입 포인트 (미사용시 0으로 설정)";
$mb_languages["MSG_FILE_UPLOAD_SIZE"]	= "파일 업로드 용량 (MB)";
$mb_languages["MSG_MAKE_IMAGE_SMALL_DESC"]	= "지정된 크기로 업로드 이미지의 축소된 비율의 이미지를 생성: 모델에서 (\"field\":\"fn_image_path\",\"size\":\"small\") 사이즈 지정 가능, small 이미지가 없으면 원본 이미지를 불러옴";
$mb_languages["MSG_MAKE_IMAGE_MIDDLE_DESC"]	= "지정된 크기로 업로드 이미지의 축소된 비율의 이미지를 생성: 모델에서 (\"field\":\"fn_image_path\",\"size\":\"middle\") 사이즈 지정 가능, middle 이미지가 없으면 원본 이미지를 불러옴";
$mb_languages["MSG_ACCESS_IP_ALLOW_DESC"]		= "접근 허용으로 등록된 IP가 1개 이상이면 접속 허용으로 등록된 IP만 접근이 가능해 집니다";


//WORD
$mb_languages["W_ID"]						= "아이디";
$mb_languages["W_PASSWORD"]			= "비밀번호";
$mb_languages["W_SECRET"]					= "비밀글";
$mb_languages["W_NOTICE"]					= "공지";
$mb_languages["W_SKIN"]					= "스킨";
$mb_languages["W_SETUP"]					= "설정";
$mb_languages["W_DELETE"]					= "삭제";
$mb_languages["W_TOTAL"]					= "전체";
$mb_languages["W_ALL"]						= "전체";
$mb_languages["W_YEAR"]					= "년";
$mb_languages["W_MONTH"]				= "월";


$mb_languages["W_MANGBOARD"]		= "망보드";
$mb_languages["W_HOMEPAGE"]			= "홈페이지";
$mb_languages["W_MANUAL"]				= "매뉴얼";
$mb_languages["W_TECH_SUPPORT"]		= "기술지원";
$mb_languages["W_COMMUNITY"]			= "커뮤니티";


$mb_languages["W_PID"]						= "번호";
$mb_languages["W_HIT"]						= "조회";
$mb_languages["W_DATE"]					= "날짜";
$mb_languages["W_EMAIL"]					= "이메일";
$mb_languages["W_IMAGE"]					= "이미지";
$mb_languages["W_TITLE"]					= "제목";
$mb_languages["W_USER_NAME"]			= "회원 이름";
$mb_languages["W_USER_NAME_PID"]	= "회원 이름[Pid]";
$mb_languages["W_WRITER"]					= "작성자";
$mb_languages["W_CONTENT"]				= "내용";
$mb_languages["W_TAG"]						= "태그";
$mb_languages["W_LEVEL"]					= "레벨";
$mb_languages["W_POINT"]					= "포인트";
$mb_languages["W_GROUP"]					= "그룹";
$mb_languages["W_MEMO"]					= "메모";
$mb_languages["W_FILE"]						= "파일";
$mb_languages["W_BOARD_FILE"]			= "첨부파일";
$mb_languages["W_DOWNLOAD"]			= "다운로드";
$mb_languages["W_UPDATE"]				= "업데이트";
$mb_languages["W_ADDRESS"]				= "주소";
$mb_languages["W_RANK"]					= "순위";
$mb_languages["W_COUNT"]					= "개수";
$mb_languages["W_TYPE"]					= "구분";
$mb_languages["W_VALUE"]					= "내용";
$mb_languages["W_SITE"]						= "사이트";
$mb_languages["W_VERSION"]				= "버젼";
$mb_languages["W_SESSION"]				= "세션";
$mb_languages["W_ICON"]					= "아이콘";
$mb_languages["W_TEST"]						= "테스트";
$mb_languages["W_FREE"]						= "무료";
$mb_languages["W_SEARCH"]				= "검색";

$mb_languages["W_PREV"]					= "이전";
$mb_languages["W_NEXT"]					= "다음";

$mb_languages["W_ADD"]					= "등록";
$mb_languages["W_LIST"]						= "목록";
$mb_languages["W_VIEW"]					= "글보기";
$mb_languages["W_WRITE"]					= "글쓰기";
$mb_languages["W_MODIFY"]				= "수정";
$mb_languages["W_REPLY"]					= "답변";
$mb_languages["W_REPLY_WRITE"]			= "답변쓰기";
$mb_languages["W_COMMENT_WRITE"]	= "댓글 작성";
$mb_languages["W_MOVE"]						= "이동";
$mb_languages["W_COPY"]						= "복사";
$mb_languages["W_ACCESS"]					= "접근";

$mb_languages["W_DASHBOARD"]						= "대시보드";
$mb_languages["W_BOARD"]								= "게시판";
$mb_languages["W_BOARD_INSERT"]					= "게시판 추가";
$mb_languages["W_BOARD_ITEM"]						= "게시물";

$mb_languages["W_BOARD_DATA"]					= "자료실";
$mb_languages["W_BOARD_GALLERY"]				= "갤러리";
$mb_languages["W_BOARD_CALENDAR"]			= "캘린더";
$mb_languages["W_BOARD_WEBZINE"]				= "웹진";
$mb_languages["W_BOARD_LATESET"]				= "최근 게시물";
$mb_languages["W_COMMENT_LATESET"]			= "최근 댓글";
$mb_languages["W_REFERER_LATESET"]				= "최근 유입 URL";
$mb_languages["W_SUMMARY_STATISTICS"]		= "미니 통계";
$mb_languages["W_CURRENT_STATE"]					= "현황";

$mb_languages["W_COMMENT"]						= "댓글";
$mb_languages["W_CATEGORY"]						= "카테고리";
$mb_languages["W_BOARD_VOTE_GOOD"]			= "게시물 추천";
$mb_languages["W_BOARD_VOTE_BAD"]				= "게시물 비추천";
$mb_languages["W_COMMENT_VOTE_GOOD"]		= "댓글 추천";
$mb_languages["W_COMMENT_VOTE_BAD"]		= "댓글 비추천";

$mb_languages["W_START_DATE"]						= "시작일";
$mb_languages["W_END_DATE"]						= "종료일";

$mb_languages["W_BOARD_LINK_NONE"]			= "연결안함";
$mb_languages["W_BOARD_LINK_INPUT"]			= "직접입력";



$mb_languages["W_LOGIN"]						= "로그인";
$mb_languages["W_LOGOUT"]					= "로그아웃";
$mb_languages["W_AUTO_LOGIN"]				= "자동로그인";
$mb_languages["W_USER"]						= "회원";
$mb_languages["W_USER_PID"]					= "회원 [Pid]";
$mb_languages["W_USER_INFO"]				= "회원 정보";
$mb_languages["W_USER_JOIN"]				= "회원 가입";
$mb_languages["W_USER_INSERT"]				= "회원 등록";
$mb_languages["W_USER_LEVEL"]				= "회원 레벨";
$mb_languages["W_USER_MODIFY"]			= "수정하기";
$mb_languages["W_PASSWORD_LOST"]		= "비밀번호 찾기";
$mb_languages["W_KCAPTCHA"]				= "자동등록방지";
$mb_languages["W_CAPTCHA"]					= "자동등록방지";

$mb_languages["W_CURRENCY"]				= "원";
$mb_languages["W_NUMBER_SUFFIX"]		= "개";

$mb_languages["W_TODAY"]						= "오늘";
$mb_languages["W_YESTERDAY"]				= "어제";
$mb_languages["W_ONE_WEEK"]				= "1주일";
$mb_languages["W_ONE_MONTH"]				= "1개월";
$mb_languages["W_THIS_MONTH"]			= "이번달";
$mb_languages["W_LAST_MONTH"]			= "지난달";





//ADMIN MENU
$mb_languages["W_MENU_DASHBOARD"]	= "대시보드";
$mb_languages["W_MENU_BOARD"]			= "게시판 관리";
$mb_languages["W_MENU_USER"]				= "회원 관리";
$mb_languages["W_MENU_FILE"]				= "파일 관리";
$mb_languages["W_MENU_OPTION"]			= "옵션 설정";
$mb_languages["W_MENU_COOKIE"]			= "쿠키 관리";
$mb_languages["W_MENU_ANALYTICS"]		= "통계 관리";
$mb_languages["W_MENU_H_EDITOR"]		= "홈토리 에디터";
$mb_languages["W_MENU_REFERER"]			= "Referer 관리";
$mb_languages["W_MENU_LOG"]				= "Log 관리";
$mb_languages["W_MENU_ACCESSIP"]		= "접속 IP관리";


//USER MENU
$mb_languages["W_USER_SEARCH"]		= "게시물 보기";
$mb_languages["W_USER_INFO"]			= "회원 정보";
$mb_languages["W_USER_EMAIL"]			= "메일 보내기";
$mb_languages["W_USER_HOMEPAGE"]	= "홈페이지";
$mb_languages["W_USER_BLOG"]			= "블로그";
$mb_languages["W_USER_MESSAGE"]		= "쪽지 보내기";


$mb_languages["W_BOARD_NAME"]	= "게시판 이름";
$mb_languages["W_BOARD_NAME_PID"]	= "게시판 이름 [PID]";
$mb_languages["W_SKIN_MODEL"]	= "스킨/모델";
$mb_languages["W_AUTHORITY"]	= "권한";
$mb_languages["W_STATUS_POSTINGS"]	= "게시물 현황";
$mb_languages["W_SETTING"]	= "설정";
$mb_languages["W_BOARD_SETTING"]	= "게시판 설정";
$mb_languages["W_VIEW_MSG"]	= "글보기";
$mb_languages["W_EXPLANATION_BOARD"]	= "게시판 설명";
$mb_languages["W_SKIN_NAME"]	= "스킨 이름";
$mb_languages["W_MODEL_NAME"]	= "모델 이름";
$mb_languages["W_EDITOR_SETTING"]	= "에디터 설정";
$mb_languages["W_LIST_COUNT"]	= "목록 개수";
$mb_languages["W_COMMENT_COUNT"]	= "댓글 개수";
$mb_languages["W_PAGE_BLOCK_COUNT"]	= "페이지 블럭 개수";
$mb_languages["W_SHOW_TITLE_BAR"]	= "목록 제목바 표시";
$mb_languages["W_COMMENT_FUNCTION"]	= "댓글 기능";
$mb_languages["W_NOTIFI_FUNCTION"]	= "공지 기능";
$mb_languages["W_SECRET_FUNCTION"]	= "비밀글 기능";
$mb_languages["W_USE_SECRET_LABEL"]	= "사용(선택),사용(필수),사용안함";
$mb_languages["W_WORDPRESS_POSTID"]	= "워드프레스 Post ID";
$mb_languages["W_CONNECT_BOARD"]	= "게시판 연결";
$mb_languages["W_CATEGORY_FUNCTION"]	= "카테고리 기능";
$mb_languages["W_TAP_MENU_REFRESH"]	= "탭메뉴 (탭메뉴 클릭시 새로고침)";
$mb_languages["W_TAP_MENU_AJAX"]	= "탭메뉴 (탭메뉴 클릭시 AJAX 방식으로 데이타 불러옴)";
$mb_languages["W_SELECT_CATEGORY_CLICK"]	= "SELECT (검색 버튼 클릭시에만 카테고리 적용)";
$mb_languages["W_SELECT_CATEGORY_REFRESH"]	= "SELECT (카테고리 변경시 새로고침)";
$mb_languages["W_SELECT_CATEGORY_AJAX"]	= "SELECT (카테고리 변경시 AJAX 방식으로 데이타 불러옴)";
$mb_languages["W_CATEGORY_DATA"]	= "카테고리 데이타";
$mb_languages["W_BOARD_TOP_TEXT"]	= "게시판 상단 내용";
$mb_languages["W_BOARD_BOTTOM_TEXT"]	= "게시판 하단 내용";
$mb_languages["W_WRITING_FORM"]	= "글쓰기 폼";
$mb_languages["W_RECOM_SET"]	= "추천/비추천 기능 설정";
$mb_languages["W_BOARD_RECOM"]	= "게시판 추천 기능";
$mb_languages["W_BOARD_NON_RECOM"]	= "게시판 비추천 기능";
$mb_languages["W_COMMENT_RECOM"]	= "댓글 추천 기능";
$mb_languages["W_COMMENT_NON_RECOM"]	= "댓글 비추천 기능";
$mb_languages["W_BOARD_AUTHORITY_SET"]	= "게시판 권한 설정 (0:비회원, 1~10:회원, 10:관리자)";
$mb_languages["W_AUTHORITY_LIST"]	= "목록 권한";
$mb_languages["W_AUTHORITY_WRITE"]	= "글쓰기 권한";
$mb_languages["W_AUTHORITY_VIEW"]	= "글보기 권한";
$mb_languages["W_AUTHORITY_REPLAY"]	= "답변 권한";
$mb_languages["W_AUTHORITY_COMMENT"]	= "댓글 권한";
$mb_languages["W_AUTHORITY_MODIFY"]	= "수정 권한";
$mb_languages["W_AUTHORITY_SECRET"]	= "비밀글 권한";
$mb_languages["W_AUTHORITY_DELETE"]	= "삭제 권한";
$mb_languages["W_AUTHORITY_ADMIN"]	= "관리 권한";
$mb_languages["W_POINT_SET"]		= "포인트 설정";
$mb_languages["W_READ_POINT"]	= "읽기 포인트";
$mb_languages["W_WRITE_POINT"]	= "쓰기 포인트";
$mb_languages["W_REPLY_POINT"]	= "답변 포인트";
$mb_languages["W_COMMENT_POINT"]	= "댓글 포인트";
$mb_languages["W_BOARD_TYPE"]	= "게시판 타입";
$mb_languages["W_CATEGORY1_DISTING_COMMA"]	= "1단(쉼표로 구분)";
$mb_languages["W_CATEGORY2_JSON_TYPE"]	= "2~3단 (JSON 타입)";



$mb_languages["W_MANGBOARD_VERSION"]	= "망보드 버전";

$mb_languages["W_DB_VERSION"]	= "디비 버전";

$mb_languages["W_ADMIN_EMAIL"]	= "관리자 이메일";

$mb_languages["W_GOOGLE_ANALYTICS_ID"]	= "구글 Analytics ID";

$mb_languages["W_NAVER_ANALYTICS_ID"]	= "네이버 Analytics ID";

$mb_languages["W_COPY_PREVENTION"]	= "콘텐츠 복사 방지";



$mb_languages["W_ADMIN_LEVEL"]	= "관리자 레벨";



$mb_languages["W_USER_LEVEL_DISPLAY"]	= "회원 레벨 표시";

$mb_languages["W_USER_THUMBNAILS"]	= "회원 썸네일 표시";
$mb_languages["W_THUMBNAIL"]			= "썸네일";
$mb_languages["W_SHOW_USER_POP"]	= "회원 팝업창 표시";
$mb_languages["W_LOGIN_POINT"]	= "회원 로그인 포인트";

$mb_languages["W_SING_UP_POINT"]	= "회원 가입 포인트";


$mb_languages["W_SSL_PORT_NUM"]	= "SSL 포트번호";
$mb_languages["W_SSL_DOMAIN"]	= "SSL 도메인주소";
$mb_languages["W_SSL_CERTIFICATE"]	= "SSL 인증서";
$mb_languages["W_UPLOAD_SIZE"]	= "업로드 파일 용량";
$mb_languages["W_IMAGE_SIZE_SMALL"]	= "이미지 크기(Small)";
$mb_languages["W_IMAGE_SIZE_MIDDLE"]	= "이미지 크기(Middle)";

$mb_languages["W_LOGIN_LOG"]	= "로그인 로그";
$mb_languages["W_POINT_LOG"]	= "포인트 로그";

$mb_languages["W_ERROR_LOG"]	= "에러 로그";




$mb_languages["W_NAME"]	= "이름";

$mb_languages["W_SING_UP"]	= "가입";

$mb_languages["W_LAST_ACCESS_DATE"]	= "최종 접속일";
$mb_languages["W_MODIFICATION"]	= "수정";

$mb_languages["W_STATUS_MESSAGE"]	= "상태 메시지";
$mb_languages["W_STATUS"]	= "상태";

$mb_languages["W_COIN"]	= "코인";

$mb_languages["W_DATE_OF_BIRTH"]	= "생년월일";

$mb_languages["W_MOBILE"]	= "핸드폰";
$mb_languages["W_PHOTO"]	= "사진";

$mb_languages["W_MESSENGER"]	= "메신져";

$mb_languages["W_HOMEPAGE"]	= "홈페이지";
$mb_languages["W_BLOG"]	= "블로그";
$mb_languages["W_HOME_ADDRESS"]	= "집 주소";

$mb_languages["W_HOME_NUMBER"]	= "집 전화";

$mb_languages["W_ACCEPT_EMAIL"]	= "이메일 허용";

$mb_languages["W_ACCEPT_MESSAGE"]	= "쪽지 허용";

$mb_languages["W_LOGIN_COUNT"]	= "로그인수";

$mb_languages["W_WRITE_COUNT"]	= "글쓰기수";
$mb_languages["W_REPLY_COUNT"]	= "답변수";

$mb_languages["W_MAIL_AUTHENTICATION"]	= "메일 인증";

$mb_languages["W_SING_TIME"]	= "가입 시간";

$mb_languages["W_USER_MEMO"]	= "회원 메모";

$mb_languages["W_ADMIN_MEMO"]	= "관리자 메모";

$mb_languages["W_ADIT_USER_INFO"]	= "회원 정보 편집";

$mb_languages["W_WP_USER_SYNC"]	= "워드프레스 회원 동기화";

$mb_languages["W_ATTACHMENT"]	= "첨부파일";



$mb_languages["W_FILE1"]	= "파일1";
$mb_languages["W_FILE2"]	= "파일2";
$mb_languages["W_OPERATOR"]	= "운영자";

$mb_languages["W_TYPE"]	= "구 분";

$mb_languages["W_OPTION_NAME"]	= "옵션 이름";

$mb_languages["W_OPTION_VALUE"]	= "옵션 값";

$mb_languages["W_INPUT_TYPE"]	= "INPUT 타입";

$mb_languages["W_INPUT_OPTION_NAME"]	= "INPUT 옵션 이름";

$mb_languages["W_INPUT_OPTION"]	= "INPUT 옵션 값";

$mb_languages["W_INPUT_STYLE_SET"]	= "INPUT Style 설정";

$mb_languages["W_INPUT_CLASS_SET"]	= "INPUT Class 설정";

$mb_languages["W_INPUT_EVENT_SET"]	= "INPUT Event 설정";

$mb_languages["W_INPUT_ATTRIBUTE_SET"]	= "INPUT Attribute 설정";

$mb_languages["W_EXPLANATION_OPTIONS"]	= "옵션 설명";

$mb_languages["W_INPUT_OPTION_SET"]	= "옵션 입력을 받을 Input 태그 설정 (text,select,textarea,radiobox)";

$mb_languages["W_INPUT_SELECT_RADIO"]	= "INPUT 타입이 select, radiobox 일 경우에만 사용";

$mb_languages["W_INPUT_STYLE_SET_DESC"]	= "옵션 INPUT 타입에 Style 설정";

$mb_languages["W_INPUT_CLASS_SET_DESC"]	= "옵션 INPUT 타입에 Class 설정";

$mb_languages["W_INPUT_EVENT_SET_DESC"]	= "옵션 INPUT 타입에 Event 설정";

$mb_languages["W_INPUT_ATTRIBUTE_SET_DESC"]	= "옵션 INPUT 타입에 Attribute 설정";





$mb_languages["W_ON"]						= "사용";
$mb_languages["W_OFF"]						= "사용안함";
$mb_languages["W_ON_OFF"]					= "사용,사용안함";
$mb_languages["W_CAPTCHA_ON_OFF"]		= "사용안함,사용(Text),사용(Image),";

$mb_languages["W_USE_SECRET_LABEL"]	= "사용(선택),사용(필수),사용안함";


$mb_languages["W_DENY_ALLOW"]			= "접근 차단,접근 허용";
$mb_languages["W_DESCRIPTION"]			= "설명";
$mb_languages["W_REGDATE"]				= "등록일";
$mb_languages["W_BOARD_PID"]				= "게시판 번호";


$mb_languages["W_USER_REGDATE"]		= "회원/등록일";
$mb_languages["W_JOIN_LAST_DATE"]		= "가입/최종 접속일";
$mb_languages["W_SEO"]						= "검색 엔진 최적화(SEO)";


$mb_languages["W_TODAY_JOIN"]				= "가입자 수";
$mb_languages["W_TODAY_WRITE"]			= "게시물 수";
$mb_languages["W_TODAY_REPLY"]			= "답글 수";
$mb_languages["W_TODAY_COMMENT"]		= "댓글 수";
$mb_languages["W_TODAY_UPLOAD"]		= "업로드 수";
$mb_languages["W_TODAY_PAGE_VIEW"]	= "페이지 뷰";
$mb_languages["W_TODAY_VISIT"]				= "방문 횟수";
$mb_languages["W_CUMULATE_VISIT"]		= "누적 방문 횟수";

$mb_languages["W_PHP_VERSION"]			= "PHP 버전";
$mb_languages["W_SITE_LOCALE"]				= "사용 언어";
$mb_languages["W_TOTAL_USER"]				= "전체 회원";
$mb_languages["W_TOTAL_FILE"]				= "전체 파일";
$mb_languages["W_TOTAL_VISIT"]				= "전체 방문";




//BUTTON
$mb_words["List"]						= "목록";
$mb_words["Write"]						= "글쓰기";
$mb_words["View"]						= "글보기";
$mb_words["Modify"]					= "수정";
$mb_words["Send_Write"]				= "확인";			//글쓰기 화면 전송 버튼
$mb_words["Send_Modify"]			= "확인";			//수정 화면 전송 버튼
$mb_words["Send_Reply"]				= "확인";			//답변 화면 전송 버튼

$mb_words["Comment_Reply"]				= "답글";
$mb_words["Send_Comment_Write"]		= "댓글 등록";			
$mb_words["Send_Comment_Modify"]	= "댓글 수정";			
$mb_words["Send_Comment_Reply"]		= "답글 등록";			

$mb_words["Move"]						= "이동";
$mb_words["Copy"]						= "복사";
$mb_words["All"]							= "전체";

$mb_words["Today"]					= "오늘";
$mb_words["Week"]						= "1주일";
$mb_words["Month"]					= "1개월";
$mb_words["Last_Month"]				= "지난달";


$mb_words["Reply"]						= "답변";
$mb_words["Delete"]					= "삭제";
$mb_words["Search"]					= "검색";
$mb_words["Comment"]				= "댓글";
$mb_words["Vote_Good"]				= "추천";
$mb_words["Vote_Bad"]				= "비추천";
$mb_words["Input"]						= "입력";
$mb_words["OK"]						= "확인";
$mb_words["Cancel"]					= "취소";
$mb_words["Setup"]						= "설정";
$mb_words["More"]						= "더보기";
$mb_words["Back"]						= "뒤로";

$mb_words["Login"]						= "로그인";
$mb_words["Find_Password"]			= "비밀번호 찾기";
$mb_words["Join"]						= "회원가입";

$mb_words["First"]						= "처음";
$mb_words["Prev"]						= "이전";
$mb_words["Next"]						= "다음";
$mb_words["Last"]						= "맨끝";



?>