<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */
	
function action( &$c )
{
	// title
	$c->set("title",REGAP_STRING_USER_PASSWORD_TITLE);

	// js output
	$js = "/user_password.js";
	if(!js_output($js)) {
		trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
	}
}
?>
