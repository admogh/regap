<?php
/**
 * configuration file partly behind regap_config.php
 * Notice, editing this file is not reflecting.
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */
// REGAP ADMIN OPTION
define("REGAP_FILE_UPLOAD_CONFIRM",TRUE);
define("REGAP_PAGE_EDIT_UPLOAD_AUTO_MKDIR",TRUE);
define("REGAP_TEMPLATE_UPLOAD_AUTO_MKDIR",TRUE);
define("REGAP_EDIT_TEMPLATE_UPLOAD_AUTO_MKDIR",TRUE);
define("REGAP_TEMPLATE_DELETE_REMOVE",TRUE);
define("REGAP_EDIT_TEMPLATE_DELETE_REMOVE",TRUE);
define("REGAP_EDIT_TEMPLATE_DELETE_REMOVE_TEMPLATE",TRUE);
//define("REGAP_PAGE_EDIT_RELEASE_AUTO_MKDIR",TRUE);
//define("REGAP_PAGE_RELEASE_AUTO_MKDIR",TRUE);
define("REGAP_PAGE_EDIT_DELETE_REMOVE",TRUE);
define("REGAP_PAGE_DELETE_REMOVE",TRUE);
define("REGAP_PAGE_LIST_PARENT_CHECK",TRUE);

define("REGAP_EDIT_DELETE_DISPLAY",TRUE);
//define("REGAP_EDIT_UPLOAD_OVER_WRITE",FALSE);

// for hash
define("REGAP_HASH_FOR_PASSWORD",REGAP_HASH_BASE);
define("REGAP_HASH_FOR_IDI",REGAP_HASH_BASE);

// regap db
//define("REGAP_DB_MYSQL_CHAR_SET", "ujis");

// dirs
define('REGAP_LIB_DIR', REGAP_APP_DIR. "/lib");
define('REGAP_CHEETAN_DIR', REGAP_LIB_DIR . "/cheetan");
define('REGAP_TEMPLATE_DIR', REGAP_APP_DIR . "/templates");

// error settings
define('REGAP_LOG',TRUE);
define('REGAP_LOG_FILE',"");	// absolute path

// template,edit_template
define("REGAP_DEFAULT_TEMPLATE_ID",1);
define("REGAP_DEFAULT_EDIT_TEMPLATE_ID",1);	// for template upload 
define("REGAP_DEFAULT_USER_LEVEL",((1 << 21) + ((1 << 21) - 1) + (1 << 28)) );

// js output
define("REGAP_JS_OUTPUT_FORCE", FALSE);

?>
