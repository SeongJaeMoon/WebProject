<?php
$mb_locale			= get_locale();
$mb_uri				= '';
if(!empty($_SERVER["HTTP_HOST"]) && !empty($_SERVER["REQUEST_URI"])) $mb_uri	= $_SERVER["HTTP_HOST"].strtolower($_SERVER["REQUEST_URI"]);
$mb_home_url	= str_replace(array("http://","https://"), "", MBW_HOME_URL);
$mb_uri				= str_replace($mb_home_url, "", $mb_uri);

if(!empty($_GET["lang"])) $mb_locale	= preg_replace("/[^0-9a-zA-Z_,-]/u", '', $_GET["lang"]);
else if(strpos($mb_uri, '/en/')===0) $mb_locale	= 'en_US';
else if(strpos($mb_uri, '/ko/')===0 || strpos($mb_uri, '/kr/')===0) $mb_locale	= 'ko_KR';
else if(strpos($mb_uri, '/zh/')===0 || strpos($mb_uri, '/ch/')===0) $mb_locale	= 'zh_CN';
else if(strpos($mb_uri, '/ja/')===0 || strpos($mb_uri, '/jp/')===0) $mb_locale	= 'ja';
else if(get_option("mb_locale")!="") $mb_locale	= get_option("mb_locale");

//설정 데이타
$mb_options				= array("locale"=>$mb_locale,		//ko_KR, en_US   (DB에서 설정 불가)
										"wp_multi_language"=>0,	//워드프레스에서 제공하는 다국어 기능 사용 : admin-ko_KR.mo 와 같은 언어 파일이 있어야 적용됨  (DB에서 설정 불가)
										"cookie_expire"=>(60*60*24),
										"date_format"=>"Y-m-d",	// 날짜 년-월-일 포맷 (수정 금지)
										"time_format"=>"H:i:s",		// 시간 시간:분:초 포맷 (수정 금지)
										"mb_version"=>"1.7.1",	
										"db_version"=>"1.0.4",
										"encoding"=>"UTF-8",

										//모델 파일에서 수정하는 옵션 : start
										"wp_post_id"=>0,
										"use_form_session"=>0,
										"use_list_pagination"=>1,
										"use_list_button"=>1,
										"use_write_button"=>1,
										"use_view_button"=>1,
										"use_view_comment"=>1,
										"use_view_prev_next"=>1,
										"write_next_page"=>"list",				// 글쓰기 이후에 이동할 페이지 : list(글목록), wirte(등록 알림 팝업창, Reload)
										//모델 파일에서 수정하는 옵션 : end
										
										//디비, 파일에서 수정하는 옵션 : start
										"user_mode"=>"WP",
										"use_seo"=>1,		// 검색 엔진 최적화(SEO)
										"kcaptcha_image_url"=>"",
										"kcaptcha_mode"=>"2",	// 자동등록방지 기능 사용안함 0, 텍스트 1, 이미지 2, 모듈방식 이미지 3
										"prev_next_size"=>1,		// 이전,다음글 리스트 표시 개수

										"editor_mode"=>1,			// 에디터 기능 사용 1, 사용안함 0 (mangboard/plugins/editors 폴더)
										"plugin_mode"=>1,			// 플러그인  기능 사용 1, 사용안함 0 (mangboard/plugins 폴더)
										"widget_mode"=>1,			// 위젯 기능 사용 1, 사용안함 0 (mangboard/plugins/widgets 폴더)

										"admin_email"=>"",	
										"user_login_point"=>"0",	// 로그인 포인트 (미사용시 0으로 설정)
										"user_join_point"=>"0",	// 회원 가입 포인트 (미사용시 0으로 설정)										
										
										"show_user_picture"=>1,
										"show_user_level"=>1,
										"show_name_popup"=>1,										
										
										"upload_file_size"=>2,		// 파일 업로드 용량 MB

										"referer_log"=>1,				// Referer 로그 사용 1, 사용안함 0																	
										"login_log"=>1,				// 로그인 로그 사용 1, 사용안함 0
										"point_log"=>1,				// 포인트 로그 사용 1, 사용안함 0
										"error_log"=>0,				// 에러 로그 사용 1, 사용안함 0 
										"google_analytics_id"=>"",	// 구글 통계 ID 설정
										"naver_analytics_id"=>"",	// 네이버 통계 ID 설정

										"prevent_content_copy"=>0,	// 복사 방지 코드 사용
										"resize_responsive"=>1,				// 반응형 코드 사용

										"ssl_mode"=>0,					//ssl 인증서 설치 여부 (1 or 0)   :    user 플러그인 관련 주소(로그인,회원정보 등)만 적용됨
										"ssl_domain"=>"",					//ssl 도메인 주소 (www.mangboard.com)
										"ssl_port"=>"443",					//ssl 포트
										

										"make_img_small_size"=>"480",			//지정된 크기로 업로드 이미지의 축소된 비율의 이미지를 생성 : 모델에서 ("field":"fn_image_path","size":"small") 사이즈 지정 가능, small 이미지가 없으면 원본 이미지를 불러옴
										"make_img_middle_size"=>0,			// 0 또는 "" 설정될 경우 이미지를 생성하지 않음

										"manager_level"=>7,
										"admin_level"=>10	// 관리자 레벨 설정(필터, 업로드 용량, 복사 방지 등 일부 제한기능 예외 적용됨)
										);
?>