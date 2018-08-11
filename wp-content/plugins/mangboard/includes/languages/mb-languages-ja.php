<?php		
$mb_language_version	= "1.0.0";	

// 언어에 대한 수정요청은 아래 주소의 메일로 보내주시기 바랍니다.
// E-Mail : mangboard@gmail.com
				
//ERROR MESSAGE		
$mb_languages["MSG_ERROR"]	= "%s Error";	
$mb_languages["MSG_FIELD_EMPTY_ERROR1"]	= "%sを入力してください。";	// %s は特定文字が入る
$mb_languages["MSG_FIELD_EMPTY_ERROR2"]	= "%sを入力してください。";	//名前を入力してください。
$mb_languages["MSG_FILE_EMPTY_ERROR1"]	= "%sをアップロードしてください。";	
$mb_languages["MSG_FILE_EMPTY_ERROR2"]	= "%sをアップロードしてください。";	
$mb_languages["MSG_PATTERN_ERROR"]	= "'%s’値は不正な値です。";	
$mb_languages["MSG_UNIQUE_ERROR"]	= "'%s'<br>既に存在する%sです。";	
		
$mb_languages["MSG_FILTER_ERROR"]	= "'%s'使用できない単語です。";	
$mb_languages["MSG_PERMISSION_ERROR"]	= "%s権限がありません。";	//アクセス権限がありません。投稿作成権限がありません。
		
$mb_languages["MSG_EXIST_ERROR"]	= "%sが存在しません。";	
$mb_languages["MSG_EXIST_ERROR2"]	= "%s %sが存在しません。";	
$mb_languages["MSG_USE_ERROR"]	= "使用可能な%sが不足です。";	
		
$mb_languages["MSG_UPLOAD_SIZE_ERROR"]	= "%sMB以上はアップロードできません。";	
$mb_languages["MSG_UPLOAD_EXT"]	= "%sファイルのみアップロードできます。";	
$mb_languages["MSG_UPLOAD_EXT_ERROR"]	= "%sファイルはアップロードできません。";	
$mb_languages["MSG_MATCH_ERROR"]	= "%sが一致しません。";	
$mb_languages["MSG_NONCE_MATCH_ERROR"]	= "一時的な障害が発生しました。<br>新たに更新後やり直してください。";	
		
		
$mb_languages["MSG_SEARCH_ERROR1"]	= "%sが見つかりません。";	
$mb_languages["MSG_SEARCH_ERROR2"]	= "%sが見つかりません。";	
		
$mb_languages["MSG_MOVE_SELECT_EMPTY"]	= "移動する項目を選択してください。";	
$mb_languages["MSG_COPY_SELECT_EMPTY"]	= "コピーする項目を選択してください。";	
$mb_languages["MSG_DELETE_SELECT_EMPTY"]	= "削除する項目を選択してください。";	
$mb_languages["MSG_DELETE_CONFIRM"]	= "削除しますか？";	
$mb_languages["MSG_PASSWD_INPUT"]	= "パスワードを入力してください。";	
		
$mb_languages["MSG_MULTI_DELETE_CONFIRM"]	= "個の項目を削除しますか？";  //3項目を…前に数字が入る(数字はJAVAスクリプトで決まる)	
$mb_languages["MSG_MULTI_MOVE_CONFIRM"]	= "個の項目を移動しますか？";  //3項目を…前に数字が入る(数字はJAVAスクリプトで決まる)	
$mb_languages["MSG_MULTI_COPY_CONFIRM"]	= "個の項目をコピーしますか？";  //3項目を…前に数字が入る(数字はJAVAスクリプトで決まる)	
		
$mb_languages["MSG_LIST_ITEM_EMPTY"]	= "登録された掲示物がありません。";	
$mb_languages["MSG_ITEM_NOT_EXIST"]	= "削除または存在しない内容です。";	
$mb_languages["MSG_USER_NOT_EXIST"]	= "一致する会員情報が存在しません。";	
		
$mb_languages["MSG_PASSWORD_RESET"]	= "新しいパスワード：";	// パスワードを初期化時にパスワードの前に入る内容
		
		
$mb_languages["MSG_VOTE_PARTICIPATE_ERROR"]	= "既に投票に参加しました。";	
$mb_languages["MSG_REQUIRE_LOGIN"]	= "ログインが必要な機能です。";	
$mb_languages["MSG_MOVE_LOGIN"]	= "ログインページに移動します。";	
$mb_languages["MSG_MOVE_PREV"]	= "以前ページに移動します。";	
$mb_languages["MSG_SEND_WRITE_SUCCESS"]	= "正しく登録されました。";	
$mb_languages["MSG_SEND_MAIL_SUCCESS"]	= "メールを送信しました。";	
		
$mb_languages["MSG_SECRET"]	= "秘密投稿です。";	
$mb_languages["MSG_SECRET_PASSWD_INPUT"]	= "秘密投稿です。<br>パスワードを入力してください。";	
		
$mb_languages["MSG_EMAIL_FILTER_ERROR"]	= "メールアドレスが不正です。";	
$mb_languages["MSG_NAME_FILTER_ERROR"]	= "使用できない名前です。";	
$mb_languages["MSG_WORD_FILTER_ERROR"]	= "使用できない単語です。";	
$mb_languages["MSG_CAPTCHA_INPUT"]	= "自動登録防止数字を入力してください。";	
$mb_languages["MSG_TAG_INPUT"]	= "タグはコンマで区分して入力してください。";	
		
$mb_languages["MSG_UPDATE_PERMISSION_ERROR"]	= "アップデート権限がありません。";	
$mb_languages["MSG_UPDATE_CONFIRM"]	= "アップデートの前に追加及び修正されたファイルに対するバックアップをご確認ください。アップデートを進行しますか？";	
		
$mb_languages["MSG_SELECTBOX"]	= "全体";	
		

$mb_languages["MSG_BOARD_NAME_INPUT_CHECK"]	= "掲示板名はローマ字で始まる4~30字の「アルファベット」、「数字」、「_」の組み合わせにしてください。";
$mb_languages["MSG_BOARD_EXPLANATION_INPUT"]	= "掲示板について簡単な説明を入力します。";
$mb_languages["MSG_BOARD_MODEL_SET"]	= "「models」フォルダーにある掲示板モデルを設定することができ、「skin-model」はskins/スキン/includes/skin-model.phpファイルを選択します。";
$mb_languages["MSG_EDITOR_SELECT"]	= "投稿を書き込む画面で内容を入力時に使用するエディターを選択します。";
$mb_languages["MSG_NUM_POST_ONE_PAGE"]	= "一ページで表示する投稿数を設定します。";
$mb_languages["MSG_NUM_COMMENT_ONE_PAGE"]	= "一ページで表示するコメント数を設定します。";
$mb_languages["MSG_PAGE_BLOCK_NUM_SET"]	= "ページブロック数を設定します。100で設定時「もっと見る」ボタン方式に変更されます。";
$mb_languages["MSG_TITLE_BAR_LIST"]	= "投稿リストで件名バーを表示するかどうかを設定します。";
$mb_languages["MSG_POST_ID_ENTER"]	= "Mangboard Shortcodeの入っているワードプレスのポストIDを入力します。";
$mb_languages["MSG_BOARD_SET_CHANGE"]	= "掲示板連結は既存に生成した掲示板の内容を設定のみ変えて読み取る機能です。「連結しない」を選択する場合、掲示板テーブルを新たに生成します。";
$mb_languages["MSG_SHOW_CATEGORY"]	= "カテゴリーデータを表示する方式を選択します。";

$mb_languages["MSG_BOARD_TOP_HTML"]	= "掲示板上段に表示するHTMLタグを入力します。";
$mb_languages["MSG_BOARD_BOTTOM_HTML"]	= "掲示板下段に表示するHTMLタグを入力します。";
$mb_languages["MSG_DEFAULT_FORM_ENTER"]	= "投稿を書き込む時に基本で表示する投稿フォームを入力します。";
$mb_languages["MSG_LIST_VIEW_AUTHORITY"]	= "投稿リストが見られる権限を設定します。";
$mb_languages["MSG_SET_WRITE"]	= "投稿を書き込む権限を設定します。";
$mb_languages["MSG_SET_VIEW"]	= "投稿を読み取る権限を設定します。";
$mb_languages["MSG_SET_REPLY"]	= "リプライ権限を設定します。";
$mb_languages["MSG_SET_COMMENT"]	= "コメント権限を設定します。";
$mb_languages["MSG_AUTHORITY_MODIFY"]	= "他のユーザーが作成した投稿を修正できる権限を設定します。";
$mb_languages["MSG_AUTHORITY_SECRET_MSG"]	= "他のユーザーの秘密投稿が見られる権限を設定します。";
$mb_languages["MSG_AUTHORITY_DELETE"]	= "他のユーザーの投稿を削除できる権限を設定します。";
$mb_languages["MSG_AUTHORITY_BOARD_ADMIN"]	= "投稿コピー、移動など掲示板を管理できる権限を設定します。";
$mb_languages["MSG_POINT_WRITING"]	= "投稿を作成時に与えるポイントを入力します。";
$mb_languages["MSG_POINT_REPLY"]	= "リプライを作成時に与えるポイントを入力します。";
$mb_languages["MSG_POINT_COMMENT"]	= "コメントを作成時に与えるポイントを入力します。";
$mb_languages["MSG_ENTER_SSL_PORT_NUM"]	= "SSLポート番号を入力します(443ポートは省略可能)";
$mb_languages["MSG_ENTER_SSL_DOMAIN"]	= "SSLドメインアドレスを入力します";
$mb_languages["MSG_ADDRESS_CERTIFICATE"]	= "SSL認定書がインストールされていない場合、会員関連アドレスに認定書を適用します。";
$mb_languages["MSG_LOG_SAVE_SHOW"]	= "ログインログを保存してログ管理メニューから確認することができます。";
$mb_languages["MSG_POINT_LOG_SAVE_SHOW"]	= "ポイントログを保存してログ管理メニューから確認することができます。";
$mb_languages["MSG_ERROR_LOG_SHOW"]	= "エラーログをDBに保存してログ管理メニューから確認することができます。";
$mb_languages["MSG_ID_INPUT_CHECK"]	= "IDはローマ字で始まる4~20字の「アルファベット」、「数字」、「_」の組み合わせにしてください。";
$mb_languages["MSG_NAME_INPUT_2MORE"]	= "名前は最小2桁以上を入力してください。";
$mb_languages["MSG_PASSWORD_INPUT_4MORE"]	= "パスワードは最小4桁以上を入力してください。";
$mb_languages["MSG_USER_SYNCED"]	= "人の会員を同期化しまいた。";
$mb_languages["MSG_SYNC_NO_USERS"]	= "同期化可能な会員は存在しません。";

$mb_languages["MSG_NOT_REGIST_USER_LOAD"]	= "Mangboard会員データに登録されていないワードプレス会員データを取り込みます。";
$mb_languages["MSG_NAME_UNUSABLE"]	= "使用できない名前です。";
$mb_languages["MSG_WORD_UNUSABLE"]	= "使用できない単語です。";

$mb_languages["MSG_COPY_MOUSE_PREVENT"]	= "マウス右クリック及びドラッグできないように設定(管理者は除く)";
$mb_languages["MSG_ADMIN_LEVEL_SET"]	= "管理者レベル設定(公知機能の使用及び一部制限機能は除く)";
$mb_languages["MSG_USER_NAME_LEVEL_SET"]	= "会員名の横にレベル表示";
$mb_languages["MSG_USER_NAME_PHOTO_SET"]	= "会員名の前に写真表示";
$mb_languages["MSG_USER_NAME_POPUP_SET"]	= "会員名をクリック時、会員情報ポップアップ表示";
$mb_languages["MSG_LOGIN_POINT_SET"]	= "ログインポイント(使用しない時は0に設定)";
$mb_languages["MSG_SING_UP_POINT_SET"]	= "会員登録ポイント(使用しない時は0に設定)";
$mb_languages["MSG_FILE_UPLOAD_SIZE"]	= "ファイルアップロード容量(MB)";
$mb_languages["MSG_MAKE_IMAGE_SMALL_DESC"]	= "指定されたサイズでアップロードイメージの縮小された比率のイメージを生成 : モデルで(\"field\":\"fn_image_path\",\"size\":\"small\")サイズ指定可能、smallイメージがなければ原本イメージを取り込む";
$mb_languages["MSG_MAKE_IMAGE_MIDDLE_DESC"]	= "指定されたサイズでアップロードイメージの縮小された比率のイメージを生成 : モデルで(\"field\":\"fn_image_path\",\"size\":\"middle\")サイズ指定可能、middleイメージがなければ原本イメージを取り込む";
$mb_languages["MSG_ACCESS_IP_ALLOW_DESC"]		= "";

		

		
//WORD		
$mb_languages["W_ID"]	= "ID";	
$mb_languages["W_PASSWORD"]	= "パスワード";	
$mb_languages["W_SECRET"]	= "秘密投稿";	
$mb_languages["W_NOTICE"]	= "公知";	
$mb_languages["W_SKIN"]	= "スキン";	
$mb_languages["W_SETUP"]	= "設定";	
$mb_languages["W_DELETE"]	= "削除";	
$mb_languages["W_TOTAL"]	= "全体";	
$mb_languages["W_ALL"]	= "全体";	
$mb_languages["W_YEAR"]	= "年";	
$mb_languages["W_MONTH"]	= "月";	
		
		
$mb_languages["W_MANGBOARD"]	= "Mangboard";	
$mb_languages["W_HOMEPAGE"]	= "ホームページ";	
$mb_languages["W_MANUAL"]	= "マニュアル";	
$mb_languages["W_TECH_SUPPORT"]	= "技術サポート";	
$mb_languages["W_COMMUNITY"]	= "コミュニティー";	
		
		
$mb_languages["W_PID"]	= "番号";	
$mb_languages["W_HIT"]	= "ヒット";	
$mb_languages["W_DATE"]	= "日付";	
$mb_languages["W_EMAIL"]	= "電子メール";	
$mb_languages["W_IMAGE"]	= "イメージ";	
$mb_languages["W_TITLE"]	= "件名";	
$mb_languages["W_USER_NAME"]	= "作成者";	
$mb_languages["W_USER_NAME_PID"]	= "作成者[Pid]";
$mb_languages["W_WRITER"]	= "作成者";
$mb_languages["W_CONTENT"]	= "内容";	
$mb_languages["W_TAG"]	= "タグ";	
$mb_languages["W_LEVEL"]	= "レベル";	
$mb_languages["W_POINT"]	= "ポイント";	
$mb_languages["W_GROUP"]	= "グループ";	
$mb_languages["W_MEMO"]	= "メモ";	
$mb_languages["W_FILE"]	= "ファイル";	
$mb_languages["W_BOARD_FILE"]	= "添付ファイル";	
$mb_languages["W_DOWNLOAD"]	= "ダウンロード";	
$mb_languages["W_UPDATE"]	= "アップデート";	
$mb_languages["W_ADDRESS"]	= "アドレス";	
$mb_languages["W_RANK"]	= "順位";	
$mb_languages["W_COUNT"]	= "個数";	
$mb_languages["W_TYPE"]	= "区分";	
$mb_languages["W_VALUE"]	= "内容";	
$mb_languages["W_SITE"]	= "サイト";	
$mb_languages["W_VERSION"]	= "バージョン";	
$mb_languages["W_SESSION"]	= "セッション";	
$mb_languages["W_ICON"]	= "アイコン";	
$mb_languages["W_TEST"]	= "テスト";	
$mb_languages["W_FREE"]	= "無料";	
$mb_languages["W_SEARCH"]	= "検索";	
		
$mb_languages["W_PREV"]	= "前へ";	
$mb_languages["W_NEXT"]	= "次へ";	
		
$mb_languages["W_ADD"]	= "登録";	
$mb_languages["W_LIST"]	= "リスト";	
$mb_languages["W_VIEW"]	= "投稿表示";	
$mb_languages["W_WRITE"]	= "投稿作成";	
$mb_languages["W_MODIFY"]	= "修正";	
$mb_languages["W_REPLY"]	= "リプライ";	
$mb_languages["W_REPLY_WRITE"]	= "リプライ作成";	
$mb_languages["W_COMMENT_WRITE"]	= "コメント作成";	
$mb_languages["W_MOVE"]	= "移動";	
$mb_languages["W_COPY"]	= "コピー";	
$mb_languages["W_ACCESS"]	= "アクセス";	
		
$mb_languages["W_DASHBOARD"]	= "ダッシュボード";	
$mb_languages["W_BOARD"]	= "掲示板";	
$mb_languages["W_BOARD_INSERT"]	= "掲示板追加";	
$mb_languages["W_BOARD_ITEM"]	= "投稿文";	
		
$mb_languages["W_BOARD_DATA"]	= "資料室";	
$mb_languages["W_BOARD_GALLERY"]	= "ギャラリー";	
$mb_languages["W_BOARD_CALENDAR"]	= "カレンダー";	
$mb_languages["W_BOARD_WEBZINE"]	= "Webzine";	
$mb_languages["W_BOARD_LATESET"]	= "最近投稿文";	
$mb_languages["W_COMMENT_LATESET"]	= "最近コメント";	
$mb_languages["W_REFERER_LATESET"]	= "最近流入URL";	
$mb_languages["W_SUMMARY_STATISTICS"]	= "ミニ統計";	
$mb_languages["W_CURRENT_STATE"]	= "現況";	
		
$mb_languages["W_COMMENT"]	= "コメント";	
$mb_languages["W_CATEGORY"]	= "カテゴリー";	
$mb_languages["W_BOARD_VOTE_GOOD"]	= "投稿文推薦";	
$mb_languages["W_BOARD_VOTE_BAD"]	= "投稿文非推薦";	
$mb_languages["W_COMMENT_VOTE_GOOD"]	= "コメント推薦";	
$mb_languages["W_COMMENT_VOTE_BAD"]	= "コメント非推薦";	
		
$mb_languages["W_START_DATE"]	= "開始日";	
$mb_languages["W_END_DATE"]	= "終了日";	
		
$mb_languages["W_BOARD_LINK_NONE"]	= "連結しない";	
$mb_languages["W_BOARD_LINK_INPUT"]	= "直接入力";	
		
		
		
$mb_languages["W_LOGIN"]	= "ログイン";	
$mb_languages["W_LOGOUT"]	= "ログアウト";	
$mb_languages["W_AUTO_LOGIN"]	= "自動ログイン";	
$mb_languages["W_USER"]	= "会員";	
$mb_languages["W_USER_PID"]		= "会員 [Pid]";
$mb_languages["W_USER_INFO"]	= "会員情報";	
$mb_languages["W_USER_JOIN"]	= "会員加入";	
$mb_languages["W_USER_INSERT"]	= "会員登録";	
$mb_languages["W_USER_LEVEL"]	= "会員レベル";	
$mb_languages["W_USER_MODIFY"]	= "修正する";	
$mb_languages["W_PASSWORD_LOST"]	= "パスワードを探す";	
$mb_languages["W_KCAPTCHA"]	= "自動登録防止";	
$mb_languages["W_CAPTCHA"]	= "自動登録防止";	
		
$mb_languages["W_CURRENCY"]	= "ウォン";	
$mb_languages["W_NUMBER_SUFFIX"]	= "個";	
		
$mb_languages["W_TODAY"]	= "今日";	
$mb_languages["W_YESTERDAY"]	= "昨日";	
$mb_languages["W_ONE_WEEK"]	= "1週間";	
$mb_languages["W_ONE_MONTH"]	= "1ヶ月";	
$mb_languages["W_THIS_MONTH"]	= "今月";	
$mb_languages["W_LAST_MONTH"]	= "先月";	
		
		
		
		
		
//ADMIN MENU		
$mb_languages["W_MENU_DASHBOARD"]	= "ダッシュボード";	
$mb_languages["W_MENU_BOARD"]	= "掲示板管理";	
$mb_languages["W_MENU_USER"]	= "会員管理";	
$mb_languages["W_MENU_FILE"]	= "ファイル管理";	
$mb_languages["W_MENU_OPTION"]	= "オプション設定";	
$mb_languages["W_MENU_COOKIE"]	= "クッキー管理";	
$mb_languages["W_MENU_ANALYTICS"]	= "統計管理";	
$mb_languages["W_MENU_H_EDITOR"]	= "ホームトリエディター";	
$mb_languages["W_MENU_REFERER"]	= "Referer管理";	
$mb_languages["W_MENU_LOG"]	= "Log管理";	
$mb_languages["W_MENU_ACCESSIP"]	= "接続IP管理";	
		
		
//USER MENU		
$mb_languages["W_USER_SEARCH"]	= "投稿文表示";	
$mb_languages["W_USER_INFO"]	= "会員情報";	
$mb_languages["W_USER_EMAIL"]	= "メール送信";	
$mb_languages["W_USER_HOMEPAGE"]	= "ホームページ";	
$mb_languages["W_USER_BLOG"]	= "ブログ";	
$mb_languages["W_USER_MESSAGE"]	= "メモ送信";	
		
		


$mb_languages["W_BOARD_NAME"]	= "掲示板名";
$mb_languages["W_BOARD_NAME_PID"]	= "掲示板名 [PID]";

$mb_languages["W_SKIN_MODEL"]	= "スキン/モデル";
$mb_languages["W_AUTHORITY"]	= "権限";
$mb_languages["W_STATUS_POSTINGS"]	= "掲示物現況";
$mb_languages["W_SETTING"]	= "設定";
$mb_languages["W_BOARD_SETTING"]	= "掲示板設定";
$mb_languages["W_VIEW_MSG"]	= "投稿を読む";
$mb_languages["W_EXPLANATION_BOARD"]	= "掲示板説明";
$mb_languages["W_SKIN_NAME"]	= "スキン名";
$mb_languages["W_MODEL_NAME"]	= "モデル名";
$mb_languages["W_EDITOR_SETTING"]	= "エディター設定";
$mb_languages["W_LIST_COUNT"]	= "リスト数";
$mb_languages["W_COMMENT_COUNT"]	= "コメント数";
$mb_languages["W_PAGE_BLOCK_COUNT"]	= "ページブロック数";
$mb_languages["W_SHOW_TITLE_BAR"]	= "リスト件名バー表示";
$mb_languages["W_COMMENT_FUNCTION"]	= "コメント機能";
$mb_languages["W_NOTIFI_FUNCTION"]	= "公知機能";
$mb_languages["W_SECRET_FUNCTION"]	= "秘密投稿機能";
$mb_languages["W_USE_SECRET_LABEL"]	= "使用(選択),使用(必須),使用しない";
$mb_languages["W_WORDPRESS_POSTID"]	= "ワードプレスポストID";
$mb_languages["W_CONNECT_BOARD"]	= "掲示板連結";
$mb_languages["W_CATEGORY_FUNCTION"]	= "カテゴリー機能";
$mb_languages["W_TAP_MENU_REFRESH"]	= "タブメニュー(タブメニューをクリック時、新たに更新)";
$mb_languages["W_TAP_MENU_AJAX"]	= "タブメニュー(タブメニューをクリック時、AJAX方式でデータを取り込む)";
$mb_languages["W_SELECT_CATEGORY_CLICK"]	= "SELECT(検索ボタンをクリック時のみカテゴリー適用)";
$mb_languages["W_SELECT_CATEGORY_REFRESH"]	= "SELECT(カテゴリーを変更時、新たに更新)";
$mb_languages["W_SELECT_CATEGORY_AJAX"]	= "SELECT(カテゴリーを変更時、AJAX方式でデータを取り込む)";
$mb_languages["W_CATEGORY_DATA"]	= "カテゴリーデータ";
$mb_languages["W_BOARD_TOP_TEXT"]	= "掲示板上段内容";
$mb_languages["W_BOARD_BOTTOM_TEXT"]	= "掲示板下段内容";
$mb_languages["W_WRITING_FORM"]	= "投稿フォーム";
$mb_languages["W_RECOM_SET"]	= "推薦/非推薦機能設定";
$mb_languages["W_BOARD_RECOM"]	= "掲示板推薦機能";
$mb_languages["W_BOARD_NON_RECOM"]	= "掲示板非推薦機能";
$mb_languages["W_COMMENT_RECOM"]	= "コメント推薦機能";
$mb_languages["W_COMMENT_NON_RECOM"]	= "コメント非推薦機能";
$mb_languages["W_BOARD_AUTHORITY_SET"]	= "掲示板権限設定(0:非会員、1~10：会員、10:管理者)";
$mb_languages["W_AUTHORITY_LIST"]	= "リスト権限";
$mb_languages["W_AUTHORITY_WRITE"]	= "投稿権限";
$mb_languages["W_AUTHORITY_VIEW"]	= "投稿を読む権限";
$mb_languages["W_AUTHORITY_REPLAY"]	= "リプライ権限";
$mb_languages["W_AUTHORITY_COMMENT"]	= "コメント権限";
$mb_languages["W_AUTHORITY_MODIFY"]	= "修正権限";
$mb_languages["W_AUTHORITY_SECRET"]	= "秘密投稿権限";
$mb_languages["W_AUTHORITY_DELETE"]	= "削除権限";
$mb_languages["W_AUTHORITY_ADMIN"]	= "管理権限";
$mb_languages["W_POINT_SET"]	= "ポイント設定";
$mb_languages["W_READ_POINT"]	= "読み取りポイント";
$mb_languages["W_WRITE_POINT"]	= "書き込みポイント";
$mb_languages["W_REPLY_POINT"]	= "リプライポイント";
$mb_languages["W_COMMENT_POINT"]	= "コメントポイント";
$mb_languages["W_BOARD_TYPE"]	= "掲示板タイプ";
$mb_languages["W_CATEGORY1_DISTING_COMMA"]	= "1段(コンマで区分)";
$mb_languages["W_CATEGORY2_JSON_TYPE"]	= "2~3段(JSONタイプ)";

$mb_languages["W_MANGBOARD_VERSION"]	= "Mangboardバージョン";
$mb_languages["W_DB_VERSION"]	= "DBバージョン";
$mb_languages["W_ADMIN_EMAIL"]	= "管理者メール";
$mb_languages["W_GOOGLE_ANALYTICS_ID"]	= "Google Analytics ID";
$mb_languages["W_NAVER_ANALYTICS_ID"]	= "Naver Analytics ID";
$mb_languages["W_COPY_PREVENTION"]	= "コンテンツコピー防止";
$mb_languages["W_ADMIN_LEVEL"]	= "管理者レベル";
$mb_languages["W_USER_LEVEL_DISPLAY"]	= "会員レベル表示";
$mb_languages["W_USER_THUMBNAILS"]	= "会員サムネール表示";
$mb_languages["W_THUMBNAIL"]		= "サムネール";
$mb_languages["W_SHOW_USER_POP"]	= "会員ポップアップ画面表示";
$mb_languages["W_LOGIN_POINT"]	= "会員ログインポイント";
$mb_languages["W_SING_UP_POINT"]	= "会員登録ポイント";

$mb_languages["W_SSL_PORT_NUM"]	= "SSLポート番号";
$mb_languages["W_SSL_DOMAIN"]	= "SSLドメインアドレス";
$mb_languages["W_SSL_CERTIFICATE"]	= "SSL認定書";
$mb_languages["W_UPLOAD_SIZE"]	= "アップロードファイル容量";


$mb_languages["W_IMAGE_SIZE_SMALL"]	= "イメージサイズ(Small)";
$mb_languages["W_IMAGE_SIZE_MIDDLE"]	= "イメージサイズ(Middle)";

$mb_languages["W_LOGIN_LOG"]	= "ログインログ";

$mb_languages["W_POINT_LOG"]	= "ポイントログ";
$mb_languages["W_ERROR_LOG"]	= "エラーログ";


$mb_languages["W_NAME"]	= "名前";

$mb_languages["W_SING_UP"]	= "登録";
$mb_languages["W_LAST_ACCESS_DATE"]	= "最終接続日";
$mb_languages["W_MODIFICATION"]	= "修正";
$mb_languages["W_STATUS_MESSAGE"]	= "状態メッセージ";
$mb_languages["W_STATUS"]	= "状態";
$mb_languages["W_COIN"]	= "コイン";
$mb_languages["W_DATE_OF_BIRTH"]	= "生年月日";
$mb_languages["W_MOBILE"]	= "携帯電話";
$mb_languages["W_PHOTO"]	= "写真";
$mb_languages["W_MESSENGER"]	= "メッセンジャー";
$mb_languages["W_HOMEPAGE"]	= "ホームページ";
$mb_languages["W_BLOG"]	= "ブログ";
$mb_languages["W_HOME_ADDRESS"]	= "自宅住所";
$mb_languages["W_HOME_NUMBER"]	= "自宅電話";
$mb_languages["W_ACCEPT_EMAIL"]	= "電子メール許容";
$mb_languages["W_ACCEPT_MESSAGE"]	= "メモ送信許容";
$mb_languages["W_LOGIN_COUNT"]	= "ログイン数";
$mb_languages["W_WRITE_COUNT"]	= "投稿作成数";
$mb_languages["W_REPLY_COUNT"]	= "リプライ数";
$mb_languages["W_MAIL_AUTHENTICATION"]	= "メール認証";
$mb_languages["W_SING_TIME"]	= "登録時間";
$mb_languages["W_USER_MEMO"]	= "会員メモ";
$mb_languages["W_ADMIN_MEMO"]	= "管理者メモ";
$mb_languages["W_ADIT_USER_INFO"]	= "会員情報編集";


$mb_languages["W_WP_USER_SYNC"]	= "ワードプレス会員同期化";
$mb_languages["W_ATTACHMENT"]	= "添付ファイル";

$mb_languages["W_FILE1"]	= "ファイル1";
$mb_languages["W_FILE2"]	= "ファイル2";
$mb_languages["W_OPERATOR"]	= "運営者";
$mb_languages["W_TYPE"]	= "区分";
$mb_languages["W_OPTION_NAME"]	= "オプション名";
$mb_languages["W_OPTION_VALUE"]	= "オプション値";
$mb_languages["W_INPUT_TYPE"]	= "INPUTタイプ";
$mb_languages["W_INPUT_OPTION_NAME"]	= "INPUTオプション名";
$mb_languages["W_INPUT_OPTION"]	= "INPUTオプション値";
$mb_languages["W_INPUT_STYLE_SET"]	= "INPUTスタイル設定";
$mb_languages["W_INPUT_CLASS_SET"]	= "INPUTクラス設定";
$mb_languages["W_INPUT_EVENT_SET"]	= "INPUTイベント設定";
$mb_languages["W_INPUT_ATTRIBUTE_SET"]	= "INPUTアトリビュート設定";
$mb_languages["W_EXPLANATION_OPTIONS"]	= "オプション説明";
$mb_languages["W_INPUT_OPTION_SET"]	= "オプション入力を受けるINPUTタグ設定 (text,select,textarea,radiobox)";
$mb_languages["W_INPUT_SELECT_RADIO"]	= "INPUTタイプがselect、radioboxである場合のみ使用";
$mb_languages["W_INPUT_STYLE_SET_DESC"]	= "オプションINPUTタイプにスタイル設定";
$mb_languages["W_INPUT_CLASS_SET_DESC"]	= "オプションINPUTタイプにクラス設定";
$mb_languages["W_INPUT_EVENT_SET_DESC"]	= "オプションINPUTタイプにイベント設定";
$mb_languages["W_INPUT_ATTRIBUTE_SET_DESC"]	= "オプションINPUTタイプにアトリビュート設定";

$mb_languages["W_ON"]						= "使用できる";
$mb_languages["W_OFF"]						= "を無効にする";
$mb_languages["W_ON_OFF"]					= "使用できる,を無効にする";
$mb_languages["W_CAPTCHA_ON_OFF"]		= "を無効にする,使用できる(Text),使用できる(Image),";
$mb_languages["W_DENY_ALLOW"]			= "アクセスブロック,アクセス許可";
$mb_languages["W_DESCRIPTION"]			= "説明";
$mb_languages["W_REGDATE"]				= "登録日";
$mb_languages["W_BOARD_PID"]				= "掲示板番号";


$mb_languages["W_USER_REGDATE"]		= "会員/登録日";
$mb_languages["W_JOIN_LAST_DATE"]		= "登録/最終アクセス日";
$mb_languages["W_SEO"]						= "検索エンジン最適化";

$mb_languages["W_TODAY_JOIN"]				= "登録した人の数";
$mb_languages["W_TODAY_WRITE"]			= "投稿本数";
$mb_languages["W_TODAY_REPLY"]			= "返信本数";
$mb_languages["W_TODAY_COMMENT"]		= "コメント本数";
$mb_languages["W_TODAY_UPLOAD"]		= "アップロード本数";
$mb_languages["W_TODAY_PAGE_VIEW"]	= "ヒット";
$mb_languages["W_TODAY_VISIT"]				= "訪問回数";
$mb_languages["W_CUMULATE_VISIT"]		= "累積ヒット";

$mb_languages["W_PHP_VERSION"]			= "PHP バージョン";
$mb_languages["W_SITE_LOCALE"]				= "言語";
$mb_languages["W_TOTAL_USER"]				= "全会員";
$mb_languages["W_TOTAL_FILE"]				= "ファイル全体";
$mb_languages["W_TOTAL_VISIT"]				= "全訪問";




//BUTTON		
$mb_words["List"]	= "リスト";	
$mb_words["Write"]	= "投稿作成";	
$mb_words["View"]	= "投稿表示";	
$mb_words["Modify"]	= "修正";	
$mb_words["Send_Write"]	= "Submit";	//作成画面送信ボタン
$mb_words["Send_Modify"]	= "Submit";	//修正画面送信ボタン
$mb_words["Send_Reply"]	= "Submit";	//リプライ画面送信ボタン
		
$mb_words["Comment_Reply"]	= "リプライ";	
$mb_words["Send_Comment_Write"]	= "コメント登録";	
$mb_words["Send_Comment_Modify"]	= "コメント修正";	
$mb_words["Send_Comment_Reply"]	= "リプライ登録";	
		
$mb_words["Move"]	= "移動";	
$mb_words["Copy"]	= "コピー";	
$mb_words["All"]	= "全体";	
		
$mb_words["Today"]	= "今日";	
$mb_words["Week"]	= "1週間";	
$mb_words["Month"]	= "1ヶ月";	
$mb_words["Last_Month"]	= "先月";	
		
		
$mb_words["Reply"]	= "リプライ";	
$mb_words["Delete"]	= "削除";	
$mb_words["Search"]	= "検索";	
$mb_words["Comment"]	= "コメント";	
$mb_words["Vote_Good"]	= "推薦";	
$mb_words["Vote_Bad"]	= "非推薦";	
$mb_words["Input"]	= "入力";	
$mb_words["OK"]	= "OK";	
$mb_words["Cancel"]	= "キャンセル";	
$mb_words["Setup"]	= "設定";	
$mb_words["More"]	= "もっと見る";	
$mb_words["Back"]	= "前へ";	
		
$mb_words["Login"]	= "ログイン";	
$mb_words["Find_Password"]	= "パスワードを探す";	
$mb_words["Join"]	= "会員加入";	
		
$mb_words["First"]	= "最初へ";	
$mb_words["Prev"]	= "前へ";	
$mb_words["Next"]	= "次へ";	
$mb_words["Last"]	= "最後へ";	

		

?>