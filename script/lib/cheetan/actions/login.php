<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

function action( &$c )
{
	if (!$c->is_authentication) {	
		// before login
		$query = 'select password from manage_tbl where name = ?;';
		$ret = $c->GetDriver()->getOne($query, array($_POST['id']));
		if (!$ret) {
	                $c->SetTemplate("index");
			set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_INDEX_STATUS_PASSWORD_FAIL);
			return;
		}
		else {
			if ( $ret['password'] == md5($_POST['id'].REGAP_HASH_FOR_PASSWORD.$_POST['password']) ) {
				setcookie(REGAP_COOKIE_ID, $_POST['id']);
				setcookie(REGAP_COOKIE_IDI, md5(md5($_POST['id'].REGAP_HASH_FOR_PASSWORD.$_POST['password']).REGAP_HASH_FOR_IDI.$_POST['id']));
				$c->is_authentication = TRUE;
			}
			else {
				$c->SetTemplate("index");
				set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_INDEX_STATUS_LOGIN_FAIL);
				return;
			}
		}
	}
	
	if ($c->is_authentication) {
        	$c->SetTemplate("home");
	        $c->set("subject", $GLOBALS['g_arrStringLoginSubject'][REGAP_LOGIN_MENU_HOME]);
		// matometai
		$js = "/home.js";
		if (!js_output($js)) {
			trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
		}

		$li = array();
		array_push($li, make_li("home-menu-page", '<a href="'.get_action_link('page_edit').'">'.REGAP_STRING_HOME_LIST_PAGE.'</a>', REGAP_STRING_HOME_PAGE."<br><br>"));
		array_push($li, make_li("home-menu-template", '<a href="'.get_action_link('template_upload').'">'.REGAP_STRING_HOME_LIST_TEMPLATE.'</a>', REGAP_STRING_HOME_TEMPLATE."<br><br>"));
		array_push($li, make_li("home-menu-edit-template", '<a href="'.get_action_link('edit_template_upload').'">'.REGAP_STRING_HOME_LIST_EDIT_TEMPLATE.'</a>', REGAP_STRING_HOME_EDIT_TEMPLATE."<br><br>"));
		array_push($li, make_li("home-menu-password", '<a href="'.get_action_link('user_password').'">'.REGAP_STRING_HOME_LIST_PASSWORD.'</a>', REGAP_STRING_HOME_PASSWORD."<br><br>"));
		$c->set("home_menu",$li);
	}
	else {
		// safety
		$c->SetTemplate("index");
	}
}
?>
