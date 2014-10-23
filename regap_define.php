<?php
/**
 * regap define file   
 *
 * This file should not be edit for user.
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */
//require_once("regap_config.php");

// CHARSET
define('REGAP_CHARACTER_CODE',"UTF-8");
//define('REGAP_CHARACTER_CODE',"EUC-JP");

// REGAP_DIR
define('REGAP_DIR', realpath(dirname(__FILE__)));
define('REGAP_JS_DIR', REGAP_DIR."/js");

// const value define
define("REGAP_ID_LEN",40);
define("REGAP_PASSWORD_LEN",40);
define("REGAP_TOKEN_AGE",600);
define("REGAP_TEMPLATE_NAME_LEN",255);
define("REGAP_TEMPLATE_PATH_LEN",255);
define("REGAP_EDIT_TEMPLATE_NAME_LEN",255);
define("REGAP_EDIT_TEMPLATE_PATH_LEN",255);
define("REGAP_PAGE_PATH_LEN",255);

define("REGAP_EDIT_INFO_PATH_SIZE", 50);

define("REGAP_EDIT_UPLOAD_DEST_SIZE", 40);
define("REGAP_EDIT_UPLOAD_SRC_SIZE", 40);

define("REGAP_TEMPLATE_TEMPLATE_NAME_SIZE", 40);

// table name
//define("REGAP_MANAGE_TBL","manage_tbl");
//define("REGAP_SITE_MAP_TBL","site_map_tbl");
//define("REGAP_BODY_TBL","body_tbl");

// for admin
$i = 0;
define("REGAP_LOGIN_MENU_HOME",$i++);
define("REGAP_LOGIN_MENU_PAGE",$i++);
define("REGAP_LOGIN_MENU_TEMPLATE",$i++);
define("REGAP_LOGIN_MENU_EDIT_TEMPLATE",$i++);
define("REGAP_LOGIN_MENU_USER",$i++);
define("REGAP_LOGIN_MENU_NUM",$i++);
$g_arrDefineLoginMenu = array(
	'home', 'page', 'template', 'edit_template', 'user'
);

// status
$i = 0;
define("REGAP_STATUS_KIND_SUCCESS",$i++);
define("REGAP_STATUS_KIND_FAIL",$i++);
define("REGAP_STATUS_KIND_INFO",$i++);
define("REGAP_STATUS_KIND_WARNING",$i++);
define("REGAP_STATUS_KIND_NUM",$i++);

// cookie
define("REGAP_COOKIE_ID","RegapID");
define("REGAP_COOKIE_IDI","RegapIDI");

// path regular expression
define("REGAP_PATH_REGULAR_EXPRESSION", "^(/[a-zA-Z0-9.\-]+)+$");
define("REGAP_PATH_DIR_REGULAR_EXPRESSION", "^/([a-zA-Z0-9\-]+/)*$");
// dir regular expression
define("REGAP_DIR_REGULAR_EXPRESSION", "^(/[a-zA-Z0-9_\-]+)+$");
// query regular expression(% and _ is except)
define("REGAP_ADDCSLASHES_REGULAR_EXPRESSION", "\0..\44\46..\57\72..\100\133..\136\140\173..\177");
// id regular expression
define("REGAP_ID_REGULAR_EXPRESSION", "^[a-zA-Z0-9\-]+$");
// password regular expression
define("REGAP_PASSWORD_REGULAR_EXPRESSION", "..*");
// template name regular expression
define("REGAP_TEMPLATE_NAME_REGULAR_EXPRESSION", '^[^{+<"&]+$');

// js regular expression
define("REGAP_FILE_UPLOAD_SRC_REGULAR_EXPRESSION", '^[^/{+<>&"]+$');	// cssxss
define("REGAP_FILE_UPLOAD_DEST_REGULAR_EXPRESSION", '^/([a-zA-Z0-9_\-]+/)*$');

define("REGAP_CONTENTS_PREFIX_NAME", 'contents_');
define("REGAP_CONTENTS_NAME_REGULAR_EXPRESSION", "^".REGAP_CONTENTS_PREFIX_NAME."[a-zA-Z0-9_]+$");

define("REGAP_CONTENTS_ESCAPE_DEFAULT_CHARSET", '{+"<>&' . "'");
?>
