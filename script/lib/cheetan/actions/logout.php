<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */
	
function action( &$c )
{
	if ($c->is_authentication) {
		setcookie(REGAP_COOKIE_ID, '', time()-60);
		setcookie(REGAP_COOKIE_IDI, '', time()-60);
		set_status($c, REGAP_STATUS_KIND_SUCCESS, REGAP_STRING_INDEX_STATUS_LOGOUT_SUCCESS);
		$c->SetTemplate('index');
	}
}
?>
