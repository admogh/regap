<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

function action_page_release( &$c, $check )
{
	$_check = $check;
	$check = array();
	foreach($_check as $path) {
		$datas = is_directory_exist($c, $path);
		if (is_array($datas)) {
			// exist db
			foreach($datas as $val) {
				array_push($check,$val["path"]);
			}
		}
		else {
			// not exist db
			array_push($check,$path);
		}
	}
	$check = array_unique($check);

	foreach($check as $path) {
		$dir = REGAP_TOP_DIR . substr($path, 0, strlen($path) - strlen(strrchr($path, '/')));
		if (!is_dir($dir)) {
			if (!mkdir($dir,0777,TRUE)) {
				set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_PAGE_STATUS_RELEASE_MKDIR_WARNING);
				return;
			}
		}

		// template_path
		$sql = 'select page_id,template_id from page_tbl where path = ?';
		$ret = $c->GetDriver()->getOne($sql, array($path));
		if(count($ret)==0) continue;
		$page_id = $ret['page_id'];
		$template_id = $ret['template_id'];
		$sql = 'select template_path from template_tbl where template_id = ?';
		$ret = $c->GetDriver()->getOne($sql, array($template_id));
		$template_path = $ret["template_path"];
		// contents
		$sql = 'select contents from contents_tbl where page_id = ?';
		$ret = $c->GetDriver()->getOne($sql, array($page_id));
		$jsphon = new Jsphon_Decoder();
		$contents = $jsphon->decode($ret["contents"]);
		if (REGAP_CHARACTER_CODE=='EUC-JP') {
			foreach($contents as $key => $val) {
				$contents[$key] = mb_convert_encoding($val, "EUC-JP", "auto");
			}
		}
		if(!ob_start()) {
			trigger_error(regap_get_error_string(E_REGAP_PAGE_RELEASE_OB_START), E_USER_WARNING);
			set_status($c,REGAP_STATUS_KIND_WARNING,REGAP_STRING_PAGE_STATUS_RELEASE_OB_START);
			return;
		}
		//$data = array();
		//$data['contents'] = $contents;
		$include = REGAP_TEMPLATE_DIR.$template_path;
		if (!file_exists($include)) {
			ob_end_clean();
			set_status($c,REGAP_STATUS_KIND_WARNING,sprintf(REGAP_STRING_PAGE_STATUS_RELEASE_TEMPLATE_WARNING,$include));
			return;
		}
		include($include);
		$output = ob_get_contents();
		$obret = ob_end_clean();
		$f = fopen(REGAP_TOP_DIR . $path , 'w');
		if (!$f) {
			trigger_error(regap_get_error_string(E_REGAP_PAGE_RELEASE_FILE_OPEN,array(REGAP_TOP_DIR.$path)), E_USER_WARNING);	
			set_status($c, REGAP_STATUS_KIND_FAIL,REGAP_STRING_PAGE_STATUS_RELEASE_FAIL);
			return;
		}
		if (!fwrite($f, $output)) {
			trigger_error(regap_get_error_string(E_REGAP_PAGE_RELEASE_FILE_WRITE,array(REGAP_TOP_DIR.$path)), E_USER_WARNING);
			set_status($c, REGAP_STATUS_KIND_FAIL,REGAP_STRING_PAGE_STATUS_RELEASE_FAIL);
			return;
		}
		if (!fclose($f)) {
			trigger_error(regap_get_error_string(E_REGAP_PAGE_RELEASE_FILE_CLOSE,array(REGAP_TOP_DIR.$path)), E_USER_WARNING);
			set_status($c, REGAP_STATUS_KIND_FAIL,REGAP_STRING_PAGE_STATUS_RELEASE_FAIL);
			return;
		}

		$url = REGAP_URL . substr($path, 1);
		if(empty($status_message)) $status_message = REGAP_STRING_PAGE_STATUS_RELEASE_SUCCESS;
		$status_message .= "<br>" . sprintf('<a href="%s" target="_blank">%s</a>', $url, $url);
	}

	if (empty($status_message)) {
		set_status($c,REGAP_STATUS_KIND_INFO,REGAP_STRING_PAGE_STATUS_RELEASE_INFO);
	}
	else {
		set_status($c,REGAP_STATUS_KIND_SUCCESS,$status_message);
	}
}

function action_page_delete( &$c, $check )
{
	$_check = $check;
	$check = array();
	foreach($_check as $path) {
		$datas = is_directory_exist($c, $path);
		if (is_array($datas)) {
			// exist db
			foreach($datas as $val) {
				array_push($check,$val["path"]);
			}
		}
		else {
			// not exist db
			array_push($check,$path);
		}
	}
	$check = array_unique($check);

	foreach($check as $path) {
		$sql = 'select page_id from page_tbl where path =?';
		$ret = $c->GetDriver()->get($sql, array($path));
		if (count($ret)==0) continue;	// delete between remove difference
		$page_id = $ret[0]["page_id"];

		// contents_tbl
		$sql = 'delete from contents_tbl where page_id = ?';
		$c->GetDriver()->set($sql, array($page_id));
		// page_tbl
		$sql = 'delete from page_tbl where page_id = ?';
		$c->GetDriver()->set($sql, array($page_id));

		if(empty($success)) $success = REGAP_STRING_PAGE_STATUS_DELETE_SUCCESS;
		$success .= "<br>".$path;
	}	

	if(!empty($success)) set_status($c,REGAP_STAUTS_KIND_SUCCESS,$success);
	$status = $c->get("status");
	if(empty($status)) {
		set_status($c,REGAP_STATUS_KIND_INFO,REGAP_STRING_PAGE_STATUS_DELETE_INFO);
	}
	if (REGAP_PAGE_DELETE_REMOVE) {
		action_page_remove( $c, $check );
			// while remove action's target is all check, delete action's target is file existing database.
	}
}

function action_page_remove( &$c, $check ) 
{
	foreach($check as $path) {
		$file = REGAP_TOP_DIR.$path;
		$url = REGAP_URL.substr($path,1);
		if (file_exists($file)) {
			$rm = 'rm -rf '.$file;
			if (trim(exec($rm)) == "") {
				if(empty($success)) $success = REGAP_STRING_PAGE_STATUS_REMOVE_SUCCESS;
				$success .= "<br>".$url;
			}
			else {
				if(empty($warning)) $warning = REGAP_STRING_PAGE_STATUS_REMOVE_WARNING;
				$warning .= "<br>".$url;
			}
		}
	}

	if(!empty($success)) set_status($c, REGAP_STATUS_KIND_SUCCESS,$success);
	if(!empty($warning)) set_status($c, REGAP_STATUS_KIND_WARNING,$warning);
	$status = $c->get("status");
	if(empty($status)) {
		set_status($c,REGAP_STATUS_KIND_INFO,REGAP_STRING_PAGE_STATUS_REMOVE_INFO);
	}
}

function _action_list( &$c, $path ) {
	// files decision
	$list = array();
	$query = "select path from page_tbl where path like ?";	//  . make_reg_where("path");
	//$reg = "^".$path."[a-zA-Z0-9.\-]+$";
	//$ret = $c->GetDriver()->get($query, array('%'.$path.'_%%'));
	$ret = $c->GetDriver()->get($query, array($path.'_%'));
	foreach($ret as $val) {
		$arr = array();
		if (strchr(substr($val["path"],strlen($path)),"/")) {
			$new_path = substr($val["path"],0,strlen($val["path"]) - strlen(strchr(substr($val["path"],strlen($path)),"/")));
			// same dir possibilities
			for($i=0;$i<count($list);$i++) 
				if ($list[$i]['path'] == $new_path) break;
			if($i<count($list)) {
				continue;
			}
			
			$arr['path'] = $new_path;
			$arr['db_dir'] = TRUE;
			array_push($list, $arr);
			continue;
		}
		$arr['path'] = $val["path"];
		$arr['db_file'] = TRUE;
		array_push($list, $arr);
	}
	$dir = REGAP_TOP_DIR . substr($path, 0, strlen($path)-1);
	$exec = 'ls '.$dir;
	exec($exec, $files);
	foreach($files as $val) {
		$file = $path . $val;
		for($i=0;$i<count($list);$i++) {
			if ($list[$i]["path"] == $file) {
				if (is_dir(REGAP_TOP_DIR.$file)) {
					$list[$i]["dir"] = TRUE;
					$list[$i]["link"] = REGAP_URL . substr($file, 1) . "/";
				}
				else {
					$list[$i]["file"] = TRUE;
					$list[$i]["link"] = REGAP_URL . substr($file, 1);
				}
				break;
			}
		}
		if ($i<count($list)) continue;
		$arr = array();
		$arr['path'] = $file;
		if (is_dir(REGAP_TOP_DIR.$file)) {
			$arr['dir'] = TRUE;
			$arr['link'] = REGAP_URL . substr($file, 1). "/";
		}
		else if(file_exists(REGAP_TOP_DIR.$file)) {
			$arr['file'] = TRUE;
			$arr['link'] = REGAP_URL . substr($file, 1);
		}
		array_push($list, $arr);
	}

	// sort
	if (!empty($list)) {
		$d = array();
		$f = array();
		foreach($list as $val) {
			if ($val["db_dir"] || $val["dir"]) {
				array_push($d, $val);
			}
			else if ($val["db_file"] || $val["file"]) {
				array_push($f, $val);
			}
		}
		// sorting d
		$dir_path = array();
		foreach($d as $key => $row) {
			$dir_path[$key] = $row["path"];
		}
		array_multisort($dir_path, SORT_ASC, $d);
		// sorting f
		$file_path = array();
		foreach($f as $key => $row) {
			$file_path[$key] = $row["path"];
		}
		array_multisort($file_path, SORT_ASC, $f);

		$list = array_merge($d, $f);
	}
	return $list;

}

function action( &$c )
{
	// path decision
	$path = (empty($_REQUEST['path']))? '/' : $_REQUEST['path'];
	if (!ereg(REGAP_PATH_DIR_REGULAR_EXPRESSION, $path)) {
		$c->redirect(get_action_link('page_edit') . "&path=" . $path);
	}

	$arr = getallheaders();
	foreach($arr as $key => $val) {
		$arr[strtolower($key)] = $val;
	}
	if (!empty($arr['x-requested-with'])) {
	if ( $arr['x-requested-with'] == 'XMLHttpRequest' ) {	// for IE
		$c->SetTemplateFile(TEMPLATEDIR."/page_list.html");
		$c->set('list', _action_list($c, $path));
		return;
	}
	}

	// path
	$c->set("path", $path);

	// subject
	$c->set("subject", $GLOBALS['g_arrStringLoginSubject'][REGAP_LOGIN_MENU_PAGE]);

	// js output
	$js = "/login.js";
	if(!js_output($js)) {
		trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
	}
	$js = "/expand_dir.js";
	if(!js_output($js)) {
		trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
	}

	// for new edit
	$query = 'select template_path,template_name from template_tbl';
	$ret = $c->GetDriver()->get($query);
	$c->set("template",$ret);

	// make path_link
	$sp = split('/',$path);
	$path_link = '<a href="'.get_action_link('page').'&path=/">/</a>';
	$link = "/";
	for($i=1;$i<=count($sp)-2;$i++) {
		$link .= $sp[$i] . "/";
		$path_link .= '&nbsp;<a href="' . get_action_link('page') . '&path=' . $link . '">' . $sp[$i] . "/" . '</a>';
	}
	$c->set("path_link", $path_link);
	
	$action = $c->GetAction();
	if ($action!='page') {
		$c->SetTemplate('page');
		// token check
		if (get_token()!=$_POST['token']) {
			set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_PAGE_STATUS_ACTION_WARNING);
			return;
		}

		$check = $_POST['check'];
		sort($check);
		$f = "action_".$action;
		$f($c, $check);
	}
	$list = _action_list($c, $path);
	if(empty($list)) {
		set_status($c,REGAP_STATUS_KIND_INFO,REGAP_STRING_PAGE_STATUS_LIST_INFO);
	}
	$c->set('list', $list);
}

?>
