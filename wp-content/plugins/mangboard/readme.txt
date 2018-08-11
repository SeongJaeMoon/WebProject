=== Mang Board WP===
Contributors: kitae-park
Donate link: http://www.mangboard.com/donate/
Tags: board,mangboard,bbs,bulletin,gallery,image,calendar,seo,plugin,shortcode,social,korea,korean,kingkong,kboard,망보드,워드프레스게시판,한국형게시판,게시판
Requires at least: 4.0.0
Tested up to: 4.9.6
Requires PHP: 5.4
Stable tag: 1.5.7
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Mang Board is bulletin board (홈페이지 제작에 필요한 다양한 기능을 제공하는 한국형 게시판 플러그인입니다)

== Description ==

The plugin is available in English, Japanese(日本語), Chinese(中国語) and Korean(한국어).

**Mang Board WP란??**

* Mang Board WP는 워드프레스 게시판 형태로 제공되는 플러그인으로
자료실 게시판, 갤러리(Gallery) 게시판, 캘린더(Calendar) 게시판, 회원관리, 통계관리, 쇼핑몰, 
소셜로그인, 소셜공유, 검색엔진최적화(SEO) 등의 다양한 기능을 제공합니다.

**Mang Board 특징**

* 빠르게 변화하는 기술, 플랫폼에 보다 쉽게 대응할 수 있다
* 커스터마이징을 위한 게시판으로 구조를 쉽게 변형할 수 있다
* 데스크탑, 태블릿, 모바일 등 다양한 디바이스에 맞는 반응형웹 구축이 가능하다
* 플러그인 기능을 통해 다양한 기능을 추가할 수 있다
* 다국어 기능 및 보안 인증서(SSL) 기능을 지원한다
* 다른 한국형 게시판(kboard,kingkong board)과 혼합해서 사용이 가능하다

**Mang Board 기능**

* MB-BASIC: 자료실, 갤러리, 캘린더, 문의하기, 웹진, 자주묻는질문 게시판
* MB-BUSINESS: 회원가입, 소셜 로그인, 회원정보, 회원관리, 소셜 공유, 검색 최적화 
* MB-COMMERCE: 반응형 쇼핑몰, 오픈마켓, 포인트, 쿠폰, 상품관리, 카트, 주문, 결제

**Mang Board Support**

* Homepage: [https://www.mangboard.com](https://www.mangboard.com)
* Store: [https://www.mangboard.com/store/](https://www.mangboard.com/store/)
* Demo: [http://demo.mangboard.com](http://demo.mangboard.com)
* Manual: [http://www.mangboard.com/manual/](http://www.mangboard.com/manual/)

== Installation ==

**Mang Board Installation (English)**

* Upload the entire "mangboard" folder to the "/wp-content/plugins/" directory.
* Activate the plugin through the 'Plugins' menu in WordPress.


**Mang Board Installation (Korean)**

* 플러그인 압축파일을 다운로드 받아 워드프레스 “/wp-content/plugins” 폴더에 업로드 합니다
* “/wp-content/plugins/mangboard” 폴더가 보이시면 워드프레스 설치된 플러그인 목록에 나타납니다
* 워드프레스 관리자 화면에서 “플러그인>설치된 플러그인” 목록에서 “Mang Board WP” 플러그인을 찾아 활성화 버튼을 클릭합니다
* 왼쪽에 있는 워드프레스 관리자 메뉴에서 “Mang Board” 메뉴가 보이시면 설치가 정상적으로 완료 되었습니다


== Frequently Asked Questions ==

= Mang Board License =

* Licensed under the GPLv2 license (http://www.gnu.org/licenses/gpl-2.0.html)

= Mang Board Minimum Requirements =

* PHP version 5.4.0 or greater (PHP 7.0 or greater is recommended)
* MySQL version 5.0 or greater (MySQL 5.6 or greater is recommended, UTF-8)
* WordPress 4.0 or greater

= Mang Board 게시판을 추가하려면 어떻게 해야 하나요? =

*  “Mangboard>게시판 관리” 메뉴를 클릭하고 “게시판 추가” 버튼을 클릭합니다
*  게시판 이름을 입력하고 기타 게시판 옵션들을 설정하고 “확인” 버튼을 클릭해서 게시판을 추가 합니다 ( 게시판 이름만 필수 입력 )
*  게시판 목록에 추가된 게시판의 이름과 워드프레스 페이지에 추가할 수 있는 Shortcode 가 나타납니다
*  원하는 형태의 Shortcode를 복사한 다음 관리자 메뉴 “페이지>새 페이지 추가” 메뉴를 클릭합니다
*  페이지 제목을 입력하고 복사한 Shortcode를 에디터 텍스트 영역에 복사한 다음 “공개하기” 버튼을 클릭하면 망보드 게시판이 워드프레스 페이지에 등록됩니다
*  등록된 페이지를 홈페이지 메뉴에 추가합니다

= Mang Board User Level =

* Nonmember : Level 0
* Member : Level 1~10
* Admin : Level 10


== Screenshots == 

1. Mang Board > Board
2. Mang Board > Gallery
3. Mang Board > Calendar
4. Mang Board > Webzine
5. Mang Board > Frequently Asked Questions
6. Mang Board > Form

== Upgrade Notice ==

= 1.7.0 =
안정화 작업 및 업데이트 버전 분리

== Changelog ==

= 1.7.1 =
* Elementor Page Builder 플러그인 충돌문제 수정
* Page Builder by SiteOrigin 플러그인 충돌문제 수정
* Admin Menu Tree Page View 플러그인 충돌문제 수정

= 1.7.0 =
* [PHP 5.4 이하] 이미지 첨부 게시물 수정 안되는 버그 수정
* 테마 호환성 향상을 위한 자바스크립트 로딩방식 개선
* 숏코드에서 category1 속성 적용되지 않는 버그 수정 
  [mb_board name="board1" style="" category1="카테고리"]

= 1.6.9 =
* 일부 다국어 플러그인 사용시 스마트 에디터 로딩안되는 버그 수정
* 워드프레스 4.9.6 버전에서 안정성 개선을 위한 코드 추가
* 웹진 스킨 비밀글 사용시 요약글 표시 안되도록 수정
* 로그아웃 안되는 버그 수정

= 1.6.8 =
* 갤러리 스킨 수정시 삭제된 대표이미지 변경되지 않는 버그 수정
* 원격 스팸 게시물 차단 기능 수정
* 업로드 가능 확장자 추가 (txt,gz,dwg,wav,wmv,mpg,mpeg,svg)
* 일부환경에서 글작성 버튼 안눌러지는 버그 수정

= 1.6.7 =
* 일부환경에서 글작성 버튼 안눌러지는 버그 수정
* 최적화 및 안정성 개선을 위한 코드 추가

= 1.6.6 =
* 글보기 화면에 태그 링크 기능 추가
* CK에디터에서 파일 업로드 안되는 버그 수정
* 옵션설정에 Referer 사용/사용안함 설정 기능 추가
* 게시판 연결 기능 사용시 SEO 출력 버그 수정
* minor bug 수정

= 1.6.5 =
* 검색 엔진 최적화(SEO) 기능 수정
* 일부 설치환경에서 AJAX 통신 안되는 버그 수정
* 로그인 쿠키시간 갱신 버그 수정 (비즈니스 MB-USER 모드만 해당)
* 모델링 및 템플릿 확장 기능 수정 (substr 속성 추가:모델링 매뉴얼 참조)
* minor bug 수정

= 1.6.4 =
* LOG 관리 기능에 IP 표시 기능 추가
* 최근 게시물 위젯 new 표시 기능 추가
* 게시판 연결 기능 숏코드 표시 기능 추가
* 데이타 로딩 아이콘 수정 (GIF 배경 삭제)
* 금지어 단어 삭제 (18년)
* minor bug 수정

= 1.6.3 =
* 일부환경에서 게시판 테이블 생성되지 않는 버그 수정

= 1.6.2 =
* Cafe24 - PHP 안티웹셸 보안 환경에서 업데이트 이후에 로딩 길어지는 버그 수정

= 1.6.1 =
* 일부환경에서 utf8mb4 호환성 문제 때문에 디비 테이블 생성되지 않는 버그 수정

= 1.6.0 =
* 언어설정이 한국어(ko_KR)가 아니면 CK 에디터를 기본 에디터로 설정
* 모바일 이모티콘 지원을 위한 디비 설정 수정(utf8->utf8mb4 : 새로 추가하는 게시판부터 적용)
* CK 에디터 4.6.2 => 4.7.2 버전 업데이트
* minor bug 수정

= 1.4.9 =
* 일부 계정에서 자동등록방지 이미지 나타나지 않는 버그 수정
* 보안 기능 및 SSL 설정 기능 수정

= 1.4.8 =
* PHP안티웹셸(카페24) 환경 지원을 위한 플러그인 구조 변경(스마트에디터,자동등록방지,파일)

= 1.4.7 =
* 게시물 바로가기 파라미터(vid) 추가 (http://홈페이지/board/?vid=글번호)
* PHP GD 라이브러리를 지원하지 않는 계정에서 썸네일을 생성하지 못해 업로드(이미지) 안되는 버그 수정
* 다국어 기능 수정

= 1.4.6 =
* 다국어 기능 개선 및 언어 추가 (영어,중국어,일본어)
* 망보드 대시보드에서 언어(영어,중국어,일본어,한국어) 변경 기능 추가
* 파일 업로드 버그 수정 (에디터 이미지 업로드 플러그인만 해당)
