<?php
//require_once('../../../regap_define.php');
    
define('CHEETANDIR', REGAP_CHEETAN_DIR . "/cheetan");
define('ACTIONDIR', REGAP_CHEETAN_DIR . "/actions");
define('TEMPLATEDIR', REGAP_CHEETAN_DIR . "/templates");
define('JSTEMPLATEDIR', TEMPLATEDIR . "/js");
define('EDITTEMPLATEDIR', TEMPLATEDIR . "/edit");
define('MODELDIR', REGAP_CHEETAN_DIR . "/models");

define('ACTION_PARAM_NAME','a');
define('DEFAULT_ACTION','index');

// action info
$i = 0;
define('PRE_ACTION',$i++);
define('ACTION',$i++);
define('POST_ACTION',$i++);
define('ACTION_NUM',$i++);
$i = 0;
define('ACTION_DIR',$i++);
define('ACTION_FUNCTION',$i++);
$g_arrAction = array(
	PRE_ACTION 	=> array(ACTIONDIR . "/pre",	"pre_action"),	
	ACTION 		=> array(ACTIONDIR,	 	"action"),
	POST_ACTION	=> array(ACTIONDIR . "/post",	"post_action"),
);
// request, file, function, bit(range 0-32bit:'1 << 1' is 2bit)
$i = 0;
define('ACTION_SETTINGS_ACTION',$i++);
define('ACTION_SETTINGS_BIT',$i++);
define('ACTION_SETTINGS_FILE',$i++);
define('ACTION_SETTINGS_FUNCTION',$i++);
$i = 1;
$g_arrActionSettings = array(
	'index'		=> array('index',	0),
	'logout' 	=> array('logout',	0),
	'login' 	=> array('login',	1),	
	'home'		=> array('home',	1),
/*2*/	'page'		=> array('page',		1 << $i++),
	'page_release'	=> array('page_release',	1 << $i++,	array(ACTION => ACTIONDIR . "/page.php")),
	'page_delete'	=> array('page_delete',		1 << $i++,	array(ACTION => ACTIONDIR . "/page.php")),
	'page_remove'	=> array('page_remove',		1 << $i++,	array(ACTION => ACTIONDIR . "/page.php")),
/*6*/	'page_edit' 		=> array('page_edit',		1 << $i++),
	'page_edit_upload' 	=> array('page_edit_upload',	1 << $i++,	array(ACTION => ACTIONDIR . "/page_edit.php")),
	'page_edit_check'	=> array('page_edit_check',	1 << $i++,	array(ACTION => ACTIONDIR . "/page_edit.php")),
	'page_edit_release'	=> array('page_edit_release',	1 << $i++,	array(ACTION => ACTIONDIR . "/page_edit.php")),
	'page_edit_save'	=> array('page_edit_save',	1 << $i++,	array(ACTION => ACTIONDIR . "/page_edit.php")),
	'page_edit_delete'	=> array('page_edit_delete',	1 << $i++,	array(ACTION => ACTIONDIR . "/page_edit.php")),
	'page_edit_remove'	=> array('page_edit_remove',	1 << $i++,	array(ACTION => ACTIONDIR . "/page_edit.php")),
/*13*/	'template'			=> array('template',			1 << $i++),
	'template_upload'		=> array('template_upload',		1 << $i++,	array(ACTION => ACTIONDIR . "/template_upload.php")),
	'template_upload_upload'	=> array('template_upload_upload',	1 << $i++,	array(ACTION => ACTIONDIR . "/template.php")),
	'template_change'		=> array('template_change',		1 << $i++,	array(ACTION => ACTIONDIR . "/template.php")),
	'template_delete'		=> array('template_delete',		1 << $i++,	array(ACTION => ACTIONDIR . "/template.php")),
/*18*/	'edit_template'			=> array('edit_template',		1 << $i++),
	'edit_template_upload'		=> array('edit_template_upload',	1 << $i++,	array(ACTION => ACTIONDIR . "/edit_template_upload.php")),
	'edit_template_upload_upload'	=> array('edit_template_upload_upload',	1 << $i++,	array(ACTION => ACTIONDIR . "/edit_template.php")),
	'edit_template_change'		=> array('edit_template_change',	1 << $i++,	array(ACTION => ACTIONDIR . "/edit_template.php")),
	'edit_template_delete'		=> array('edit_template_delete', 	1 << $i++,	array(ACTION => ACTIONDIR . "/edit_template.php")),
/*23*/	'user'			=> array('user',			1 << $i++),	
	'user_change'		=> array('user_change',			1 << $i++,	array(ACTION => ACTIONDIR . "/user.php")),
	'user_delete'		=> array('user_delete',			1 << $i++,	array(ACTION => ACTIONDIR . "/user.php")),
	'user_add'		=> array('user_add',			1 << $i++,	array(ACTION => ACTIONDIR . "/user_add.php")),
	'user_add_add'		=> array('user_add_add',		1 << $i++,	array(ACTION => ACTIONDIR . "/user.php")),
	'user_password'		=> array('user_password',		1 << $i++,	array(ACTION => ACTIONDIR . "/user_password.php")),
/*29*/	'user_password_change'	=> array('user_password_change',	1 << $i++,	array(ACTION => ACTIONDIR . "/user.php")),
);

require_once('utility.php');

function get_action_link($action = "")	// dare leave
{
	$str = 'index.php?' . ACTION_PARAM_NAME . '=' . $action;
	return $str;
}

function is_session()
{
	return false;
}

function config_database( &$db )
{
	$db->add( "", REGAP_HOST, REGAP_USER, REGAP_PASS, REGAP_NAME );
}


function config_models( &$controller )
{
	$controller->AddModel( MODELDIR . "/manage_tbl.php" );
	$controller->AddModel( MODELDIR . "/template_tbl.php" );
	$controller->AddModel( MODELDIR . "/edit_template_tbl.php" );
	$controller->AddModel( MODELDIR . "/page_tbl.php" );
	$controller->AddModel( MODELDIR . "/contents_tbl.php" );
}

function is_secure( &$c )
{
	/*
	if ($_REQUEST[ACTION_PARAM_NAME] == 'index') {
		return false;
	}
	*/

	return true;	// 'index' action is irregular.
}

function check_secure( &$c )
{
	if (!empty($_COOKIE[REGAP_COOKIE_ID])) {
		$query = 'select password from manage_tbl where name = ?;';
		$ret = $c->GetDriver()->getOne($query, array($_COOKIE[REGAP_COOKIE_ID]));

		if (!$ret) {
			// error		
			trigger_error(regap_get_error_string(E_REGAP_ID_NON_EXISTS), E_USER_WARNING);
			set_status($c, REGAP_STATUS_KIND_FAIL,REGAP_STRING_INDEX_STATUS_ID_FAIL);
			/*
			if ($c->GetAction() != DEFAULT_ACTION)
				$c->redirect(get_action_link(DEFAULT_ACTION));
			*/
			setcookie(REGAP_COOKIE_ID, '', time()-60);
			setcookie(REGAP_COOKIE_IDI, '', time()-60);
			return FALSE;
		}
		else {
			if ($_COOKIE[REGAP_COOKIE_IDI] == md5($ret["password"].REGAP_HASH_FOR_IDI.$_COOKIE[REGAP_COOKIE_ID])) {
				$c->is_authentication = TRUE;
				if ($c->GetAction() == DEFAULT_ACTION) {
					$c->SetAction("home");
				}
				return TRUE;
			}
			else {
				/*
				if ( ($c->GetAction() != DEFAULT_ACTION) && ($c->GetAction() != 'login') ) {
					$c->redirect(get_action_link(DEFAULT_ACTION));
				}
				*/
				setcookie(REGAP_COOKIE_ID, '', time()-60);
				setcookie(REGAP_COOKIE_IDI, '', time()-60);
				return FALSE;
			}
		}
	}
	else {
		/*
		if ( ($c->GetAction() != DEFAULT_ACTION) && ($c->GetAction() != 'login') )
			$c->redirect(get_action_link(DEFAULT_ACTION));
		*/
		return FALSE;
	}

	return FALSE;
}

function config_controller( &$controller )
{
	// level check and action common set
	//if ($controller->GetAction() != DEFAULT_ACTION)

	if ($GLOBALS['g_arrActionSettings'][$controller->GetAction()][ACTION_SETTINGS_BIT] != 0)		// excpet index,logout
	{
		$query = 'select level from manage_tbl where name = ?;';
		// var_dump($controller->db->driver);
		$id = (empty($_POST['id']))? $_COOKIE[REGAP_COOKIE_ID] : $_POST['id'];
		$ret = $controller->GetDriver()->getOne($query, array($id));

		// for common info
		$controller->set("id", $id);    // may use 'index' template.
		if (!$ret) {
			//trigger_error(regap_get_error_string(E_REGAP_ID_NON_EXISTS), E_USER_WARNING);
			$controller->SetTemplate("index");
			set_status($controller,REGAP_STATUS_KIND_WARNING,REGAP_STRING_LOGIN_STATUS_ID_WARNING);
			return FALSE;
		}
		else if ( !is_action_bit($controller->GetAction(), $ret["level"]) ) {
			if ($controller->GetAction() == 'login'
				|| $controller->is_authentication == FALSE ) {
				$controller->SetTemplate("index");
			}
			else {
				$controller->SetTemplate("home");
			}
			set_status($controller,REGAP_STATUS_KIND_WARNING,REGAP_STRING_LOGIN_STATUS_LEVEL_WARNING);
			return FALSE;
		}
	}
	else
	{
		if (!empty($_COOKIE[REGAP_COOKIE_ID]))
			$controller->set("id", $_COOKIE[REGAP_COOKIE_ID]);
	}
	$controller->is_authority = TRUE;
	return TRUE;
}

?>
