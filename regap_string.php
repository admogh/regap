<?php
/** 
 * regap define string file
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 *
 */
//require_once('regap/app/Regap_Error.php');

// startup
define("REGAP_STRING_STARTUP_INFO", "Regapのインストールを完了しました！");
define("REGAP_STRING_STARTUP_INFO2", "Regapはサイト構築・管理のための簡易CMSです。");
define("REGAP_STRING_STARTUP_INFO3", "<a href='%s'>管理画面</a>にログインして、ページを作ることができます。");
define("REGAP_STRING_STARTUP_INFO4", "Regapはユーザがよりカスタマイズを行えるように設計しています。詳細については、以下のサイトにアクセスしてみて下さい。");

// index
define("REGAP_STRING_INSTALL_TITLE", "Regapのインストール");
define("REGAP_STRING_INSTALL_SUBJECT", "Regapのインストール");
define("REGAP_STRING_INSTALL_ID", "ユーザID");
define("REGAP_STRING_INSTALL_PASSWORD", "ユーザパスワード");
define("REGAP_STRING_INSTALL_DB_KIND", "データベースの種類（mysql, pgsql, etc...）");
define("REGAP_STRING_INSTALL_DB_USER", "データベースのユーザ");
define("REGAP_STRING_INSTALL_DB_PASSWORD", "データベースのパスワード");
define("REGAP_STRING_INSTALL_DB_HOST", "データベースのホスト");
define("REGAP_STRING_INSTALL_DB_NAME", "データベースの名前");
define("REGAP_STRING_INSTALL_URL", "静的なコンテンツを出力するURL");
define("REGAP_STRING_INSTALL_TOP", "静的なコンテンツを出力するディレクトリ (ディレクトリの所有者をWebサーバを実行するユーザにするか、書き込み権限を与えて下さい）");
define("REGAP_STRING_INSTALL_APP", "内部的なスクリプトを配置するディレクトリ（より安全性を求める場合は、Webから直接アクセスできないようなディレクトリを指定して下さい）");
define("REGAP_STRING_INSTALL_INDEX", "トップページのファイル名");
define("REGAP_STRING_INSTALL_CSS_FILE", "共通のCSSファイルのパス (ディレクトリを指定する場合は所有者をWebサーバを実行するユーザにするか、書き込み権限を与えて下さい）。");
define("REGAP_STRING_INSTALL_CREATE", "作成");

// init
define("REGAP_STRING_INIT_TITLE", "Regapのインストール");
define("REGAP_STRING_INIT_SUBJECT_SUCCESS", "インストール成功！");
define("REGAP_STRING_INIT_SUBJECT_FAIL", "インストール失敗！");
define("REGAP_STRING_INIT_CREATE_TBL", "テーブルの作成&nbsp;&quot;<span style='color:#ff88ff;'>%s</span>&quot;&nbsp;で、エラーが発生しました。");
define("REGAP_STRING_INIT_INSERT_ID_PASSWORD", "初期ユーザ作成時にエラーが発生しました。");
define("REGAP_STRING_INIT_INSERT_TEMPLATE", "デフォルトテンプレート作成時にエラーが発生しました。");
define("REGAP_STRING_INIT_INSERT_EDIT_TEMPLATE", "デフォルト編集テンプレート作成時にエラーが発生しました。");
define("REGAP_STRING_INIT_CREATE_SITE_MAP_TBL", "In create site_map_tbl, query sql error.");
define("REGAP_STRING_INIT_CREATE_BODY_TBL", "In create body_tbl, query sql error.");
define("REGAP_STRING_INIT_FILTER_ID", "ユーザIDの長さは40バイト以下で、使用される文字は正規表現&nbsp;&quot;<span style='color:#ff88ff;'>%s</span>&quot;&nbsp;に従う必要があります。");
define("REGAP_STRING_INIT_FILTER_PASSWORD", "ユーザパスワードの長さは40バイト以下で、使用される文字は正規表現&nbsp;&quot;<span style='color:#ff88ff;'>%s</span>&quot;&nbsp;に従う必要があります。");
define("REGAP_STRING_INIT_FILTER_TOP", "静的なコンテンツを出力するディレクトリ&nbsp;&quot;<span style='color:#ff88ff;'>%s</span>&quot;&nbsp;が存在しません。");
define("REGAP_STRING_INIT_FILTER_APP", "内部的なスクリプトを配置するディレクトリ&nbsp;&quot;<span style='color:#ff88ff;'>%s</span>&quot;&nbsp;が存在しません。");
define("REGAP_STRING_INIT_CREATE_TBL_DONE", "Regapに必要なテーブルの作成を行いました。");
define("REGAP_STRING_INIT_DB_CONNECT", "データベースに接続できません");
define("REGAP_STRING_INIT_REGAP_CONFIG_ALREADY_EXIST", "&quot;regap_config.php&quot;&nbsp;が既に存在しています。");
define("REGAP_STRING_INIT_OUTPUT_REGAP_CONFIG", "設定ファイル&nbsp;&quot;regap_config.php&quot;&nbsp; を&quot;%s&quot;&nbsp;に出力しました。");
define("REGAP_STRING_INIT_OPEN_REGAP_CONFIG_ETC", "&quot;regap_config_etc.php&quot;を開くことができません。");
define("REGAP_STRING_INIT_OPEN_REGAP_CONFIG", "&quot;regap_config.php&quot;&nbsp;を開くことができません。");
define("REGAP_STRING_INIT_SESSION_ERROR", "セッションエラーです。");
define("REGAP_STRING_INIT_PDO_ERROR", "PDOの例外が発生しました。");

define("REGAP_STRING_INIT_TEMPLATE_NAME", "デフォルトテンプレート");
define("REGAP_STRING_INIT_EDIT_TEMPLATE_NAME", "デフォルト編集テンプレート");

define("REGAP_STRING_INIT_RETURN","戻る");

// index
define("REGAP_STRING_INDEX_SUBJECT","ログイン");
define("REGAP_STRING_INDEX_ID","ID");
define("REGAP_STRING_INDEX_PASSWORD","パスワード");
define("REGAP_STRING_INDEX_LOGIN","ログイン");
// index status
define("REGAP_STRING_INDEX_STATUS_ID_FAIL","IDが存在しません。");
define("REGAP_STRING_INDEX_STATUS_PASSWORD_FAIL","パスワードを入力してください。");
define("REGAP_STRING_INDEX_STATUS_LOGOUT_SUCCESS","ログアウトしました。");
define("REGAP_STRING_INDEX_STATUS_LOGIN_FAIL","ログインできませんでした。");

// home
define("REGAP_STRING_HOME_HELLO", 'ようこそ&nbsp;<b>%s</b>&nbspさん');
define("REGAP_STRING_HOME_LIST_PAGE","ページ作成");
define("REGAP_STRING_HOME_PAGE","新しくページを作成します。");
define("REGAP_STRING_HOME_LIST_TEMPLATE","テンプレートの追加");
define("REGAP_STRING_HOME_TEMPLATE","新しくテンプレートを追加します。");
define("REGAP_STRING_HOME_LIST_EDIT_TEMPLATE","編集テンプレートの追加");
define("REGAP_STRING_HOME_EDIT_TEMPLATE","新しく編集テンプレートを追加します。");
define("REGAP_STRING_HOME_LIST_PASSWORD","パスワードの変更");
define("REGAP_STRING_HOME_PASSWORD","パスワードを変更します。");

// edit
define("REGAP_STRING_EDIT_SUBJECT", "ページ編集");
define("REGAP_STRING_EDIT_CONTENTS_FIELD_TITLE", "コンテンツ");
define("REGAP_STRING_EDIT_FILEUPLOAD_FIELD_TITLE", "ファイルアップロード");
define("REGAP_STRING_EDIT_TEMPLATE_FIELD_TITLE", "テンプレート");
define("REGAP_STRING_EDIT_INFO_ITEM_PATH", "出力パス");
define("REGAP_STRING_EDIT_INFO_ITEM_TEMPLATE", "テンプレート");
define("REGAP_STRING_EDIT_INFO_VALUE", "変更");
define("REGAP_STRING_EDIT_INFO_CONFIRM", "出力パス及びテンプレートを変更しますか？\\n（編集中のコンテンツの内容が失われます）");

define("REGAP_STRING_EDIT_DIRECTORY_TITLE", "静的なコンテンツを出力するディレクトリからのパスを指定してください");
define("REGAP_STRING_EDIT_ITEM_DIRECTORY", "ディレクトリ：");
define("REGAP_STRING_EDIT_ITEM_HEADER", "ヘッダ文字列：");
define("REGAP_STRING_EDIT_ITEM_SUBJECT", "タイトル：");
define("REGAP_STRING_EDIT_ITEM_BODY", "本文：");
define("REGAP_STRING_EDIT_ACTION_CHECK_VALUE", "確認");
define("REGAP_STRING_EDIT_ACTION_RELEASE_VALUE", "公開");
define("REGAP_STRING_EDIT_ACTION_SAVE_VALUE",   "保存");
define("REGAP_STRING_EDIT_ACTION_DELETE_VALUE", "削除");
define("REGAP_STRING_EDIT_BODY_UPLOAD_TITLE", "ファイルのアップロード");
define("REGAP_STRING_EDIT_RETURN", "戻る");
define("REGAP_STRING_EDIT_ACTION_REMOVE_VALUE", "ファイルの削除");

// edit status
define("REGAP_STRING_EDIT_STATUS_ACTION_FAIL", "ページ編集画面の操作に失敗しました。");
//define("REGAP_STRING_EDIT_STATUS_CHECK_FAIL",  "データの確認中にエラーが発生しました。入力が適切かどうか、またはログ及びデータの確認をして下さい。");
define("REGAP_STRING_EDIT_STATUS_CHECK_FAIL", "データの確認中にエラーが発生しました。<br>%s");
define("REGAP_STRING_EDIT_STATUS_CHECK_FAIL_COOKIE_NOT_FOUND_ID", "データの確認中にエラーが発生しました（IDを示すクッキーが存在しません）。");
define("REGAP_STRING_EDIT_STATUS_SAVE_SUCCESS",  "データの保存を行いました。");

define("REGAP_STRING_EDIT_STATUS_DELETE_FAIL", 'データの削除に失敗しました。完全または部分的に削除が失敗している可能性があります。ログまたはデータの確認をして下さい。');
define("REGAP_STRING_EDIT_STATUS_DELETE_SUCCESS", "データの削除を行いました。");
define("REGAP_STRING_EDIT_STATUS_DELETE_REMOVE_SUCCESS", "データ及びファイルの削除を行いました。<br>%s");
define("REGAP_STRING_EDIT_STATUS_DELETE_WARNING", "削除すべきデータが存在しません。");

define("REGAP_STRING_EDIT_STATUS_REMOVE_WARNING",  "ファイルの削除に失敗しました。データの確認をして下さい。<br>%s");
define("REGAP_STRING_EDIT_STATUS_REMOVE_SUCCESS", "以下のファイルを削除しました。<br>%s");
define("REGAP_STRING_EDIT_STATUS_REMOVE_INFO",	"ファイルが存在しません。");


define("REGAP_STRING_EDIT_STATUS_ACTION_WARNING", "指定されたアクションが存在しません。");
define("REGAP_STRING_EDIT_STATUS_TEMPLATE_WARNING", "指定されたテンプレートが存在しません。");
define("REGAP_STRING_EDIT_STATUS_PATH_FAIL", "出力パスの形式が正しくありません。");
define("REGAP_STRING_EDIT_STATUS_PATH_WARNING", "不正なパス形式です。<br>%s");
define("REGAP_STRING_EDIT_STATUS_ID_WARNING", "IDが存在しません。");
define("REGAP_STRING_EDIT_STATUS_RELEASE_OB_START", "ファイルの出力に失敗しました。");
define("REGAP_STRING_EDIT_STATUS_RELEASE_TEMPLATE_WARNING","テンプレートが存在しません。");
define("REGAP_STRING_EDIT_STATUS_RELEASE_FAIL", "ファイルの出力に失敗しました。");
define("REGAP_STRING_EDIT_STATUS_RELEASE_WARNING", "ファイルの出力に失敗しました（ログ及びデータの確認をして下さい）。");
define("REGAP_STRING_EDIT_STATUS_RELEASE_SUCCESS", "ページを公開しました。<br><a href='%s' target='_blank'>%s</a>");
define("REGAP_STRING_EDIT_STATUS_MKDIR_FAIL", "ディレクトリの作成に失敗しました。");
define("REGAP_STRING_EDIT_STATUS_DIR_FAIL", "ディレクトリが存在しません。");
define("REGAP_STRING_EDIT_STATUS_EDIT_TEMPLATE_WARNING","編集テンプレートが存在しません。");
// edit submit
define("REGAP_STRING_EDIT_SUBMIT_RELEASE_CONFIRM", "ページを公開しますか?");
define("REGAP_STRING_EDIT_SUBMIT_DELETE_CONFIRM", "ページをデータベースから削除しますか?");
define("REGAP_STRING_EDIT_SUBMIT_REMOVE_CONFIRM", "ファイルを削除しますか?");

// upload
define("REGAP_STRING_UPLOAD_TOP_TITLE", "トップページのアップロード");
define("REGAP_STRING_UPLOAD_TOP_INFO", "トップページをアップロードして下さい。");
define("REGAP_STRING_UPLOAD_CSS_TITLE", "CSSファイルのアップロード");
define("REGAP_STRING_UPLOAD_CSS_INFO", "CSSファイルをアップロードして下さい。");
define("REGAP_STRING_UPLOAD_FILE_TITLE", "ファイルのアップロード");
define("REGAP_STRING_UPLOAD_FILE_INFO", "ファイルをアップロードして下さい。");
define("REGAP_STRING_UPLOAD_DIR_EXIST", "ディレクトリを作成しますか？");

define("REGAP_STRING_UPLOAD_FILE_SRC_ALERT", "アップロードファイルは正規表現「%s」に従う必要があります。");
define("REGAP_STRING_UPLOAD_FILE_DEST_ALERT", "アップロード先は正規表現「%s」に従う必要があります。");
define("REGAP_STRING_UPLOAD_FILE_TEMPLATE_NAME_ALERT", "テンプレート名は正規表現「%s」に従う必要があります。");
define("REGAP_STRING_UPLOAD_FILE_EDIT_TEMPLATE_NAME_ALERT", "編集テンプレート名は正規表現「%s」に従う必要があります。");

define("REGAP_STRING_UPLOAD_FILE_DEST_ITEM", "アップロード先");
define("REGAP_STRING_UPLOAD_FILE_SRC_ITEM", "ファイル");
define("REGAP_STRING_UPLOAD_SUBMIT_VALUE", "アップロード");
define("REGAP_STRING_UPLOAD_FILE_CONFIRM", "ファイルをアップロードしますか？");

define("REGAP_STRING_UPLOAD_STATUS_FILE_FAIL", "ファイルのアップロードに失敗しました（ログ及びデータの確認をして下さい）。");
define("REGAP_STRING_UPLOAD_STATUS_FILE_DEST_FAIL",  "ファイルのアップロードに失敗しました（アップロード先が正しくありません）");
define("REGAP_STRING_UPLOAD_STATUS_FILE_DIR_FAIL", "ファイルのアップロードに失敗しました（ディレクトリが存在しません）");
define("REGAP_STRING_UPLOAD_STATUS_FILE_SRC_FAIL", "ファイルのアップロードに失敗しました（ファイルの形式が正しくありません）");
define("REGAP_STRING_UPLOAD_STATUS_FILE_SUCCESS", "ファイルのアップロードを行いました。<br>%s");

// remove
define("REGAP_STRING_REMOVE_TITLE", "ファイルの削除");
define("REGAP_STRING_REMOVE_INFO", "削除するファイルを選択して下さい。");
define("REGAP_STRING_REMOVE_SUBMIT_VALUE", "削除");
define("REGAP_STRING_REMOVE_CONFIRM", "選択したファイルを削除しますか？");
define("REGAP_STRING_REMOVE_NOTHING", "削除すべきファイルがありませんでした。");

// login
$g_arrStringLoginSubject = array(
	"ダッシュボード", "ページ管理", 'テンプレート管理', '編集テンプレート管理', 'ユーザ管理'
);
// login info
define("REGAP_STRING_LOGIN_NAV_ID", "<b>%s</b>&nbsp;でログイン中");
define("REGAP_STRING_LOGIN_NAV_LOGOUT", "ログアウト");
// login menu
$g_arrStringLoginMenu = array(
	"ホーム", "ページ", "テンプレート", '編集テンプレート', 'ユーザ'
);
// login status
define("REGAP_STRING_LOGIN_STATUS_LEVEL_WARNING", "権限がありません。");
define("REGAP_STRING_LOGIN_STATUS_ID_WARNING", "IDが存在しません。");
// login menu
define("REGAP_STRING_LOGIN_PAGE_MENU_EDIT", "新規作成");
// login action
define("REGAP_STRING_PAGE_RELEASE_VALUE", "公開");
define("REGAP_STRING_PAGE_DELETE_VALUE", "削除");
define("REGAP_STRING_PAGE_REMOVE_VALUE", "ファイルの削除");
define("REGAP_STRING_PAGE_ALL_SELECT_VALUE","全て選択");
define("REGAP_STRING_PAGE_ALL_RESET_VALUE","全て解除");

define("REGAP_STRING_LOGIN_ACTION_RELEASE_CONFIRM", "選択したデータを公開しますか?\\n（データベースにないファイルは無視されます）");
define("REGAP_STRING_LOGIN_ACTION_DELETE_CONFIRM", "選択したデータを削除しますか?");
define("REGAP_STRING_LOGIN_ACTION_REMOVE_CONFIRM", "選択したファイルを削除しますか?");
// login contents
define("REGAP_STRING_LOGIN_CONTENTS_TREE_NEW", "新規作成");

// page
define("REGAP_STRING_PAGE_LIST_EXPAND","展開する");
define("REGAP_STRING_PAGE_LIST_FOLD","たたむ");
define("REGAP_STRING_PAGE_LIST_HEAD_PATH","パス");
define("REGAP_STRING_PAGE_LIST_HEAD_DB","データベース");
define("REGAP_STRING_PAGE_LIST_HEAD_FILE","ファイル");
define("REGAP_STRING_PAGE_LIST_HEAD_DB_TITLE","データベースに存在するかどうか");
define("REGAP_STRING_PAGE_LIST_HEAD_FILE_TITLE","ファイルとして存在するかどうか");

define("REGAP_STRING_PAGE_STATUS_LIST_INFO", "データ及びファイルが存在しません。");
define("REGAP_STRING_PAGE_STATUS_ACTION_WARNING", "アクションを実行できませんでした。");
define("REGAP_STRING_PAGE_STATUS_RELEASE_MKDIR_WARNING", "ディレクトリを作成できませんでした。");
define("REGAP_STRING_PAGE_STATUS_RELEASE_OB_START", "データの公開に失敗しました。");
define("REGAP_STRING_PAGE_STATUS_RELEASE_TEMPLATE_WARNING","テンプレートが存在しません。<br>（%s）");
define("REGAP_STRING_PAGE_STATUS_RELEASE_FAIL",  'データの公開中にエラーが発生しました。完全または部分的に公開が失敗している可能性があります。ログまたはデータの確認をして下さい。');
define("REGAP_STRING_PAGE_STATUS_RELEASE_SUCCESS", "以下のページを公開しました。");
define("REGAP_STRING_PAGE_STATUS_RELEASE_INFO", "公開すべきデータが存在しませんでした。");

define("REGAP_STRING_PAGE_STATUS_DELETE_FAIL", 'データの削除に失敗しました。完全または部分的に削除が失敗している可能性があります。ログまたはデータの確認をして下さい。');
define("REGAP_STRING_PAGE_STATUS_DELETE_SUCCESS", "以下のデータを削除しました。");
define("REGAP_STRING_PAGE_STATUS_DELETE_REMOVE_SUCCESS", "データ及びファイルの削除を行いました。<br>%s");
define("REGAP_STRING_PAGE_STATUS_DELETE_WARNING", "削除すべきデータが存在しません。");
define("REGAP_STRING_PAGE_STATUS_DELETE_INFO", "削除すべきデータが存在しませんでした。");
define("REGAP_STRING_PAGE_STATUS_REMOVE_WARNING",  "以下のファイルの削除に失敗しました。データを確認して下さい。");
define("REGAP_STRING_PAGE_STATUS_REMOVE_SUCCESS", "以下のファイルを削除しました。");
define("REGAP_STRING_PAGE_STATUS_REMOVE_INFO", "削除すべきファイルが存在しませんでした。");

// template
define("REGAP_STRING_TEMPLATE_MENU_UPLOAD","追加");
define("REGAP_STRING_TEMPLATE_MENU_CHANGE_VALUE","変更");
define("REGAP_STRING_TEMPLATE_MENU_CHECK","チェックしたデータを");
define("REGAP_STRING_TEMPLATE_MENU_CHECK_DELETE_VALUE","削除");

define("REGAP_STRING_TEMPLATE_LIST_HEAD_ID","ID");
define("REGAP_STRING_TEMPLATE_LIST_HEAD_TEMPLATE_NAME","テンプレート名");
define("REGAP_STRING_TEMPLATE_LIST_HEAD_TEMPLATE_PATH","テンプレートパス");
define("REGAP_STRING_TEMPLATE_LIST_HEAD_PATH","出力パス");
define("REGAP_STRING_TEMPLATE_LIST_HEAD_EDIT_TEMPLATE_NAME","編集テンプレート名");
define("REGAP_STRING_TEMPLATE_LIST_HEAD_EDIT_TEMPLATE_PATH","編集テンプレートパス");
define("REGAP_STRING_TEMPLATE_LIST_EXPAND","展開する");
define("REGAP_STRING_TEMPLATE_LIST_FOLD","たたむ");

define("REGAP_STRING_TEMPLATE_ACTION_CHANGE_CONFIRM","入力した内容に変更しますか?");
define("REGAP_STRING_TEMPLATE_ACTION_DELETE_CONFIRM","チェックしたデータを削除しますか?\\n（対象となるページは全て削除されます）");
define("REGAP_STRING_TEMPLATE_ACTION_DELETE_ALERT", "チェックされているデータがありません。");

// template upload
define("REGAP_STRING_TEMPLATE_UPLOAD_SUBMIT_VALUE","アップロード");
define("REGAP_STRING_TEMPLATE_UPLOAD_TITLE","テンプレートの追加");
define("REGAP_STRING_TEMPLATE_UPLOAD_TEMPLATE_PATH","テンプレートパス");
define("REGAP_STRING_TEMPLATE_UPLOAD_TEMPLATE_NAME","テンプレート名");
define("REGAP_STRING_TEMPLATE_UPLOAD_EDIT_TEMPLATE","編集テンプレート");

// template status
define("REGAP_STRING_TEMPLATE_STATUS_ACTION_WARNING","アクションを実行できませんでした。");
define("REGAP_STRING_TEMPLATE_STATUS_UPLOAD_SUCCESS","テンプレートを追加しました。<br>%s");
define("REGAP_STRING_TEMPLATE_STATUS_CHANGE_INFO","テンプレートの内容を変更しました。");
define("REGAP_STRING_TEMPLATE_STATUS_DELETE_PAGE_SUCCESS","以下のページを削除しました。");
define("REGAP_STRING_TEMPLATE_STATUS_DELETE_TEMPLATE_SUCCESS","以下のテンプレートを削除しました。");
define("REGAP_STRING_TEMPLATE_STATUS_DELETE_REMOVE_SUCCESS","以下のファイルを削除しました。");
define("REGAP_STRING_TEMPLATE_STATUS_DELETE_REMOVE_WARNING",  "以下のファイルの削除に失敗しました。データの確認をして下さい。");
define("REGAP_STRING_TEMPLATE_STATUS_NAME_WARNING","テンプレート名が正しくありません。");
define("REGAP_STRING_TEMPLATE_STATUS_UPLOAD_WARNING","テンプレートの追加に失敗しました。ログ及びデータを確認してください。");
define("REGAP_STRING_TEMPLATE_STATUS_DELETE_WARNING","削除すべきデータがありません。");
define("REGAP_STRING_TEMPLATE_STATUS_DELETE_DEFAULT_TEMPLATE_ID_WARNING","デフォルトテンプレートは削除できません。");

// edit_template
define("REGAP_STRING_EDIT_TEMPLATE_MENU_UPLOAD","追加");
define("REGAP_STRING_EDIT_TEMPLATE_MENU_CHANGE_VALUE","変更");
define("REGAP_STRING_EDIT_TEMPLATE_MENU_DELETE_VALUE","削除");
define("REGAP_STRING_EDIT_TEMPLATE_LIST_HEAD_ID","ID");
define("REGAP_STRING_EDIT_TEMPLATE_LIST_HEAD_NAME","編集テンプレート名");
define("REGAP_STRING_EDIT_TEMPLATE_LIST_HEAD_PATH","編集テンプレートパス");
define("REGAP_STRING_EDIT_TEMPLATE_LIST_HEAD_TEMPLATE_PATH","対象テンプレートパス");
define("REGAP_STRING_EDIT_TEMPLATE_ACTION_DELETE_CONFIRM","チェックしたデータを削除しますか?\\n（対象となるテンプレート及びページは全て削除されます）"); 
// edit_template upload
define("REGAP_STRING_EDIT_TEMPLATE_UPLOAD_SUBMIT_VALUE","アップロード");
define("REGAP_STRING_EDIT_TEMPLATE_UPLOAD_TITLE","編集テンプレートの追加");
define("REGAP_STRING_EDIT_TEMPLATE_UPLOAD_TEMPLATE_PATH","編集テンプレートパス");
define("REGAP_STRING_EDIT_TEMPLATE_UPLOAD_TEMPLATE_NAME","編集テンプレート名");
// edit_template status
define("REGAP_STRING_EDIT_TEMPLATE_STATUS_DELETE_EDIT_TEMPLATE_SUCCESS","以下の編集テンプレートを削除しました。");
define("REGAP_STRING_EDIT_TEMPLATE_STATUS_CHANGE_INFO","編集テンプレートの内容を変更しました。");
define("REGAP_STRING_EDIT_TEMPLATE_STATUS_NAME_WARNING","編集テンプレート名が正しくありません。"); 
define("REGAP_STRING_EDIT_TEMPLATE_STATUS_UPLOAD_WARNING","編集テンプレートの追加に失敗しました。ログ及びデータを確認してください。");
define("REGAP_STRING_EDIT_TEMPLATE_STATUS_DELETE_DEFAULT_ID_WARNING","デフォルト編集テンプレートは削除できません。");

// user
define("REGAP_STRING_USER_MENU_ADD","作成");
define("REGAP_STRING_USER_MENU_CHANGE_VALUE","変更");
define("REGAP_STRING_USER_MENU_DELETE_VALUE","削除");
define("REGAP_STRING_USER_CHANGE_PASSWORD_VALUE","パスワードの変更");

define("REGAP_STRING_USER_LIST_HEAD_ID","ID");
define("REGAP_STRING_USER_LIST_HEAD_WORK","操作");
define("REGAP_STRING_USER_LIST_HEAD_ACTION","アクション実行権限");
define("REGAP_STRING_USER_LIST_WORK_PASSWORD","パスワードの変更");

// user add
define("REGAP_STRING_USER_ADD_TITLE","ユーザの追加");
define("REGAP_STRING_USER_ADD_ID","ID");
define("REGAP_STRING_USER_ADD_PASSWORD","パスワード");
define("REGAP_STRING_USER_ADD_EDIT_TEMPLATE","編集テンプレート");
define("REGAP_STRING_USER_ADD_SUBMIT_VALUE","作成");
define("REGAP_STRING_USER_ADD_ID_ALERT", "IDは正規表現「%s」に従う必要があります。");
define("REGAP_STRING_USER_ADD_PASSWORD_ALERT", "パスワードは正規表現「%s」に従う必要があります。");
// user password
define("REGAP_STRING_USER_PASSWORD_TITLE","パスワードの変更");
define("REGAP_STRING_USER_PASSWORD_OLD","古いパスワード");
define("REGAP_STRING_USER_PASSWORD_NEW","新しいパスワード");
define("REGAP_STRING_USER_PASSWORD_SUBMIT_VALUE","変更");
define("REGAP_STRING_USER_PASSWORD_PASSWORD_ALERT", "パスワードは正規表現「%s」に従う必要があります。");

// user status
define("REGAP_STRING_USER_STATUS_ACTION_WARNING","アクションを実行できませんでした。"); 
define("REGAP_STRING_USER_STATUS_ADD_SUCCESS","ユーザを追加しました。<br>%s");
define("REGAP_STRING_USER_STATUS_CHANGE_INFO","%s&nbsp;の内容を変更しました。");
define("REGAP_STRING_USER_STATUS_DELETE_PAGE_SUCCESS","以下のページを削除しました。");
define("REGAP_STRING_USER_STATUS_DELETE_USER_SUCCESS","以下のユーザを削除しました。");
define("REGAP_STRING_USER_STATUS_DELETE_ID_FAIL","自分のIDは削除できません。");
define("REGAP_STRING_USER_STATUS_DELETE_REMOVE_SUCCESS","以下のファイルを削除しました。");
define("REGAP_STRING_USER_STATUS_DELETE_REMOVE_WARNING",  "以下のファイルの削除に失敗しました。データの確認をして下さい。");
define("REGAP_STRING_USER_STATUS_NAME_WARNING","ユーザ名が正しくありません。");
define("REGAP_STRING_USER_STATUS_PASSWORD_WARNING","パスワードが正しくありません。");
define("REGAP_STRING_USER_STATUS_ADD_WARNING","ユーザの追加に失敗しました。ログ及びデータを確認してください。");
define("REGAP_STRING_USER_STATUS_OLD_PASSWORD_FAIL","古いパスワードが正しくありません。");
define("REGAP_STRING_USER_STATUS_PASSWORD_CHANGE_WARNING","パスワードの変更に失敗しました．ログを確認してください。");
define("REGAP_STRING_USER_STATUS_PASSWORD_CHANGE_SUCCESS","パスワードを変更しました。");
define("REGAP_STRING_USER_STATUS_CHANGE_FAIL","自分のIDの権限変更はできません。");
define("REGAP_STRING_USER_STATUS_CHANGE_WARNING","ユーザ情報の変更に失敗しました。ログ及びデータを確認してください。");

?>
