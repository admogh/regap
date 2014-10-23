<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */
	
function action_password_change( &$c )
{
	// old check
	$old = $_POST['old'];
	$sql = 'select password from manage_tbl where name = ?';
	$ret = $c->GetDriver()->getOne($sql, array($_COOKIE[REGAP_COOKIE_ID]));
	if($ret["password"] != md5($_COOKIE[REGAP_COOKIE_ID].REGAP_HASH_FOR_PASSWORD.$old)) {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_USER_STATUS_OLD_PASSWORD_FAIL);
		return;
	}

	// new check
	$new = $_POST['new'];
	if (!ereg(REGAP_PASSWORD_REGULAR_EXPRESSION,$new)) {
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_USER_STATUS_PASSWORD_WARNING);
		return;
	}
	
	// db set
	$password = md5($_COOKIE[REGAP_COOKIE_ID].REGAP_HASH_FOR_PASSWORD.$new);
	$sql = 'update manage_tbl set password = ? where name = ?';
	$ret = $c->GetDriver()->set($sql, array($password, $_COOKIE[REGAP_COOKIE_ID]));
	if (!$ret) {
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_USER_STATUS_PASSWORD_CHANGE_WARNING);
		return;
	}
	setcookie(REGAP_COOKIE_IDI, md5(md5($_COOKIE[REGAP_COOKIE_ID].REGAP_HASH_FOR_PASSWORD.$new).REGAP_HASH_FOR_IDI.$_COOKIE[REGAP_COOKIE_ID]));
	set_status($c, REGAP_STATUS_KIND_SUCCESS,REGAP_STRING_USER_STATUS_PASSWORD_CHANGE_SUCCESS);
}

function action_add( &$c )
{
	// name
	$name = $_POST['name'];
	if (!ereg(REGAP_ID_REGULAR_EXPRESSION,$name)) {
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_USER_STATUS_NAME_WARNING);
		return;
	}
	$password = $_POST['password'];
	if (!ereg(REGAP_PASSWORD_REGULAR_EXPRESSION,$password)) {
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_USER_STATUS_PASSWORD_WARNING);
		return;
	}
	
	// db set
	$id = get_new_id($c, "manage_tbl", "id");
	$sql = 'insert into manage_tbl values (?, ?, ?, ?);';	// id, name, password, level
	$password = md5($name.REGAP_HASH_PASSWORD.$password);
	$level = REGAP_DEFAULT_USER_LEVEL;
	$arr = array($id, $name, $password, $level);
	$ret = $c->GetDriver()->set($sql, $arr);
	if (!$ret) {
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_USER_STATUS_ADD_WARNING);
		return;
	}

	set_status($c, REGAP_STATUS_KIND_SUCCESS,sprintf(REGAP_STRING_USER_STATUS_ADD_SUCCESS,$name));
}

function action_change( &$c )
{
	foreach($_POST['manage'] as $key => $val) {	// key is id	
		$sql = 'select name,level from manage_tbl where id = ?';
		$ret = $c->GetDriver()->getOne($sql,array($key));
		$name = $ret["name"];
		if($name==$_COOKIE[REGAP_COOKIE_ID]) {
			if (empty($fail_message)) $fail_message = REGAP_STRING_USER_STATUS_CHANGE_FAIL;
			continue;
		}
		$level = 0;
		foreach($val as $key2 => $val2) {
			if ($val2) {
				$level += (1 << $key2);
			}
		}

		$sql = 'update manage_tbl set level = ? where id = ?';
		$ret = $c->GetDriver()->set($sql, array($level, $key));
		if ($ret) {
			if (empty($info_message)) $info_message = sprintf(REGAP_STRING_USER_STATUS_CHANGE_INFO,$name);
			else $info_message .= "<br>" . sprintf(REGAP_STRING_USER_STATUS_CHANGE_INFO,$name);
		}
		else {
			if (empty($warning_message)) $warning_message = REGAP_STRING_USER_STATUS_CHANGE_WARNING;
		}
	}

	set_status($c, REGAP_STATUS_KIND_WARNING,$warning_message);
	//set_status($c, REGAP_STATUS_KIND_FAIL,$fail_message);
	set_status($c, REGAP_STATUS_KIND_INFO,$fail_message);
	set_status($c, REGAP_STATUS_KIND_INFO,$info_message);
}

function action_delete( &$c )
{
	$check = $_POST['check'];
	
	if(count($check)) {
		foreach($check as $key => $val) {	// key is id, val is name
			if ($val == $_COOKIE[REGAP_COOKIE_ID]) {
				if(empty($fail_message)) $fail_message = REGAP_STRING_USER_STATUS_DELETE_ID_FAIL;
				continue;
			}
			$sql = 'select id, name from manage_tbl where id = ?';
			$ret = $c->GetDriver()->get($sql, array($key));
			$sql = 'select page_id,path from page_tbl where id = ?';
			$ret_page = $c->GetDriver()->get($sql, array($key));
			if (count($ret_page)!=0) {
				foreach($ret_page as $val2) {
					$sql = 'delete from contents_tbl where page_id = ?';
					$c->GetDriver()->set($sql, array($val2['page_id']));
					if(empty($page_message)) $page_message = REGAP_STRING_USER_STATUS_DELETE_PAGE_SUCCESS;
					$page_message .= "<br>".$val2['path'];
				}
				$sql = 'delete from page_tbl where id = ?';
				$c->GetDriver()->set($sql, array($key));
			}
			$sql = 'delete from manage_tbl where id = ?';
			$c->GetDriver()->set($sql, array($key));
			if (empty($user_message)) $user_message = REGAP_STRING_USER_STATUS_DELETE_USER_SUCCESS;
			$user_message .= "<br>".$val;
		}
		set_status($c, REGAP_STATUS_KIND_FAIL,$fail_message);
		set_status($c, REGAP_STATUS_KIND_SUCCESS,$page_message);
		set_status($c, REGAP_STATUS_KIND_SUCCESS,$user_message);
	}
	else {
		set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_TEMPLATE_STATUS_DELETE_WARNING);
	}
}

function action( &$c )
{
        // subject
	$c->set("subject", $GLOBALS['g_arrStringLoginSubject'][REGAP_LOGIN_MENU_USER]);

        // js output
        $js = "/user.js";
        if(!js_output($js)) {
	        trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
        }

	$action = $c->GetAction();
	if($action!='user') {
		$c->SetTemplate('user');
		// token check
		if (get_token()!=$_POST['token']) {
			set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_USER_STATUS_ACTION_WARNING);
			return;
		}

		if($action=='user_add_add') {
			action_add($c);
		}
		else if($action=='user_password_change') {
			action_password_change($c);
		}
		else if($action=='user_change') {
			action_change($c);
		}
		else if($action=='user_delete') {
			$check = $_POST['check'];
			action_delete($c, $check);
		}
	}

	// list set
	$sql = 'select id, name, level from manage_tbl';
	$manage = $c->GetDriver()->get($sql);
	$c->set("list",$manage);
	// action set
	$arr = array();
	foreach($GLOBALS['g_arrActionSettings'] as $val) {
		if ( $val[ACTION_SETTINGS_BIT]!=0 ) {
			$bit = log($val[ACTION_SETTINGS_BIT],2);
			if (empty($arr[$bit])) {
				$arr[$bit] = $val[ACTION_SETTINGS_ACTION];
			}
			else {
				$arr[$bit] .= "/".$val[ACTION_SETTINGS_ACTION];
			}
		}
	}
	$c->set("action", $arr);
}
?>
