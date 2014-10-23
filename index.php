<?php
	require_once("regap_utility.php");
	require_once("regap_define.php");
// character encoding
ini_set('output_handler', 'mb_output_handler');
ini_set('mbstring.language', 'Japanese');
ini_set('mbstring.encoding_translation', 'On');
ini_set('mbstring.internal_encoding' , REGAP_CHARACTER_CODE);
ini_set('mbstring.http_input', 'auto');
ini_set('mbstring.http_output', REGAP_CHARACTER_CODE); 
// magic_quotes_gpc
if (ini_get('magic_quotes_gpc')) {
	$_GET = stripslashes_deep($_GET);
	$_POST = stripslashes_deep($_POST);
	$_COOKIE = stripslashes_deep($_COOKIE);
	$_REQUEST = stripslashes_deep($_REQUEST);
}
	require_once("regap_string.php");
	require_once("regap_error.php");
	require_once("regap_config.php");

// error settings
if (REGAP_LOG) {
        ini_set('log_errors', 'On');
        if (REGAP_LOG_FILE != "") {
                ini_set('error_log',REGAP_LOG_FILE);
	}
	$error_reporting = ini_get('error_reporting');
	if (!($error_reporting & E_USER_ERROR)) {
		$error_reporting |= E_USER_ERROR;
	}
        if (!($error_reporting & E_USER_WARNING)) {
                $error_reporting |= E_USER_WARNING;
        }
        if (!($error_reporting & E_USER_NOTICE)) {
                $error_reporting |= E_USER_NOTICE;
        }
        ini_set('error_reporting', $error_reporting);
}

	require_once( "regap_lib.php" );

	require_once( REGAP_CHEETAN_DIR . "/config.php" );
	require_once( CHEETANDIR . "/cheetan.php" );

?>
