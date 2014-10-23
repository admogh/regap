<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

function action_page_edit_delete( &$c, $path )
{
	$sql = 'select page_id from page_tbl where path = ?';
	$ret = $c->GetDriver()->get($sql, array($path));
	if (count($ret)==0) {
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_STATUS_DELETE_WARNING);
		return;
	}
	$page_id = $ret[0]["page_id"];

	// contents_tbl
	$sql = 'delete from contents_tbl where page_id = ?';
	$c->GetDriver()->set($sql, array($page_id));
	// page_tbl
	$sql = 'delete from page_tbl where page_id = ?';
	$c->GetDriver()->set($sql, array($page_id));
	
	set_status($c, REGAP_STATUS_KIND_SUCCESS, REGAP_STRING_EDIT_STATUS_DELETE_SUCCESS);
	if (REGAP_PAGE_EDIT_DELETE_REMOVE) {
		$url = action_page_edit_remove($c, $path);
		if($url) {
			set_status($c, REGAP_STATUS_KIND_SUCCESS, sprintf(REGAP_STRING_EDIT_STATUS_REMOVE_SUCCESS,$url));
			//set_status($c, REGAP_STATUS_KIND_SUCCESS, sprintf(REGAP_STRING_EDIT_STATUS_DELETE_REMOVE_SUCCESS,$url));
		}
	}
}

function action_page_edit_remove( &$c, $path )
{
	$file = REGAP_TOP_DIR.$path;
	$url = REGAP_URL.substr($path,1);
	if (file_exists($file)) {
		if (unlink($file)) {
			return $url;
		}
		else {
			set_status($c, REGAP_STATUS_KIND_WARNING, sprintf(REGAP_STRING_EDIT_STATUS_REMOVE_WARNING,$file));
		}
	}
	else {
		set_status($c, REGAP_STATUS_KIND_INFO, REGAP_STRING_EDIT_STATUS_REMOVE_INFO);
	}

	return NULL;
}

function action_page_edit_check( &$c, $template_path, $contents )
{
}

function action_page_edit_save( &$c, $path, $template_id, $template_path, $contents )
{

	// page_tbl insert or update
	if (!ereg(REGAP_PATH_REGULAR_EXPRESSION, $path)) {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_EDIT_STATUS_PATH_FAIL);
		return FALSE;
	}

	$id = get_id($c, $_COOKIE[REGAP_COOKIE_ID]);
	if (!$id) {
		trigger_error(regap_get_error_string(E_REGAP_PAGE_EDIT_ID), E_USER_WARNING);
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_STATUS_ID_WARNING);
		return FALSE;
	}

	$sql = 'select page_id from page_tbl where path = ?';
        $ret = $c->GetDriver()->getOne($sql, array($path));
        if ($ret) {
		// update
                $page_id = $ret["page_id"];
		$sql = 'update page_tbl set template_id = ?, id = ? where page_id = ?';
		$c->GetDriver()->set($sql, array($template_id, $id, $page_id));
		$sql = 'update contents_tbl set contents = ? where page_id = ?';
		$jsphon = new Jsphon_Encoder();
		if (REGAP_CHARACTER_CODE=='EUC-JP') {
			foreach($contents as $key => $val) {
				$contents[$key] = mb_convert_encoding($val, "UTF-8", "EUC-JP");
			}
		}
		$json = $jsphon->encode($contents);
		$c->GetDriver()->set($sql, array($json, $page_id));
        }
	else {
		// insert
		$page_id = get_new_id($c, "page_tbl","page_id");
		$sql = 'insert into page_tbl values (?, ?, ?, ?);';
		$arr = array($page_id, $path, $template_id, $id);
		$c->GetDriver()->set($sql, $arr);
		$sql = 'insert into contents_tbl values (?, ?);';
		$jsphon = new Jsphon_Encoder();
		if (REGAP_CHARACTER_CODE=='EUC-JP') {
			foreach($contents as $key => $val) {
				$contents[$key] = mb_convert_encoding($val, "UTF-8", "EUC-JP");
			}
		}
		$json = $jsphon->encode($contents);
		//var_dump(mb_detect_encoding($json));
		//$json = mb_convert_encoding($json, "EUC-JP", "auto");
		$c->GetDriver()->set($sql, array($page_id, $json));
	}

	return TRUE;
}

function action_page_edit_release( &$c, $path, $template_id, $template_path, $contents )
{
	if (!action_page_edit_save($c, $path, $template_id,  $template_path, $contents)) return;

        $dir = REGAP_TOP_DIR . substr($path, 0, strlen($path) - strlen(strrchr($path, '/')));
        if (!is_dir($dir)) {
//                if (REGAP_PAGE_EDIT_RELEASE_AUTO_MKDIR) {
		if (TRUE) {
                        if (!mkdir($dir,0777,TRUE)) {
				set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_EDIT_STATUS_MKDIR_FAIL);
				return;
		  	}
		}	
                else {
			set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_EDIT_STATUS_DIR_FAIL);
                        return;
	        }
	}
//var_dump($contents);
//var_dump(REGAP_TOP_DIR. $path);
	if(!ob_start()) {
		trigger_error(regap_get_error_string(E_REGAP_PAGE_EDIT_RELEASE_OB_START), E_USER_WARNING);
		set_status($c, REGAP_STAUTS_KIND_WARNING, REGAP_STRING_EDIT_STATUS_RELEASE_OB_START);
		return;
	}
	//$data = array();
	//$data['contents'] = $contents;
	$include = REGAP_TEMPLATE_DIR.$template_path;
	if (!file_exists($include)) {
		ob_end_clean();
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_STATUS_RELEASE_TEMPLATE_WARNING);
		return;
	}
	include(REGAP_TEMPLATE_DIR . $template_path);

	$output = ob_get_contents();
	ob_end_clean();

	$f = fopen(REGAP_TOP_DIR . $path, 'w');
	if (!$f) {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_EDIT_STATUS_RELEASE_FAIL);
		return;
	}
	if (!fwrite($f, $output)) {
		trigger_error(regap_get_error_string(E_REGAP_PAGE_EDIT_RELEASE_FILE_WRITE,array(REGAP_TOP_DIR.$path)), E_USER_WARNING);
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_STATUS_RELEASE_WARNING);
		return;
	}
	if (!fclose($f)) {
		trigger_error(regap_get_error_string(E_REGAP_PAGE_EDIT_RELEASE_FILE_CLOSE,array(REGAP_TOP_DIR.$path)), E_USER_WARNING);
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_STATUS_RELEASE_WARNING);
		return;
	}

	$url = REGAP_URL . substr($path, 1);
	set_status($c, REGAP_STATUS_KIND_SUCCESS,sprintf(REGAP_STRING_EDIT_STATUS_RELEASE_SUCCESS, $url, $url));
	return;
}

function action_page_edit_upload( &$c, $dest )
{
	// file upload(dir check + mkdir)
	if (!ereg(REGAP_FILE_UPLOAD_DEST_REGULAR_EXPRESSION,$dest)) {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_UPLOAD_STATUS_FILE_DEST_FAIL);
		return;
	}

	$dir = REGAP_TOP_DIR . substr($dest, 0, strlen($dest)-1);
	if (!is_dir($dir)) {
		if (REGAP_PAGE_EDIT_UPLOAD_AUTO_MKDIR) {
			if (!mkdir($dir,0777,TRUE)) {
				set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_UPLOAD_STATUS_FILE_FAIL);
				return;
			}
		}
		else {
			set_status($c, REGAP_STATUS_KIND_FAIL,REGAP_STRING_UPLOAD_STATUS_FILE_DIR_FAIL);
			return;
		}
	}
	$file = $_FILES['user_file']['name'];
	if (!ereg(REGAP_FILE_UPLOAD_SRC_REGULAR_EXPRESSION,$file)) {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_UPLOAD_STATUS_FILE_SRC_FAIL);
		return;
	}

	$uploadfile = $dir . '/' . $file;
        if (move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile)) {
		$url = REGAP_URL . substr($dest, 1, strlen($dest)-1) . $file;
		set_status($c, REGAP_STATUS_KIND_SUCCESS,sprintf(REGAP_STRING_UPLOAD_STATUS_FILE_SUCCESS,'<a href="'.$url.'">'.$url.'</a>'));
		return;
	}
	else {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_UPLOAD_STATUS_FILE_FAIL);
		return;
	}
}

function action_page_edit( &$c )
{
 	if (!empty($_REQUEST['path'])) {
		if (ereg(REGAP_PATH_REGULAR_EXPRESSION, $_REQUEST['path'])) {
	 		$sql = 'select page_id, template_id from page_tbl where path = ?';
	 		$path = $_REQUEST['path'];
			$ret = $c->GetDriver()->getOne($sql, array($path));
			if (count($ret)) {
				$page_id = $ret['page_id'];
				$template_id = $ret['template_id'];
	
				// contents(json) data set
				$sql = 'select contents from contents_tbl where page_id = ?';
				$ret = $c->GetDriver()->getOne($sql, array($page_id));
				if (!$ret) {
					trigger_error(regap_get_error_string(E_REGAP_GET_CONTENTS),E_USER_ERROR);
				}
				$jsphon = new Jsphon_Decoder();
				$arr = $jsphon->decode($ret['contents']);
				if (REGAP_CHARACTER_CODE=='EUC-JP') {
					foreach($arr as $key => $val) {
						$arr[$key] = mb_convert_encoding($val, "EUC-JP", "auto");
						$str = "";
						for($i=0;$i<strlen($arr[$key]);$i++) {
							$char = mb_substr($arr[$key],$i,1);
							if(strchr(REGAP_CONTENTS_ESCAPE_DEFAULT_CHARSET,$char)) {
								$str .= '&#' . trim(ord($char)). ';';
							}
							else {
								$str .= $char;
							}
						}

						$arr[$key] = $str;
					}
				}
				$c->set('contents', $arr);	// array
			}
			else if (is_directory_exist($c, $path)) {
				$path = get_default_path($c, $_REQUEST['path'] . "/");
			}
		}
		else if (ereg(REGAP_PATH_DIR_REGULAR_EXPRESSION, $_REQUEST['path'])) {	// /hoge/
			$path = get_default_path($c, $_REQUEST['path']);
		}
	}
	
	// path
	if (empty($path)) {
		$path = get_default_path($c);
	}
	$c->set('path', $path);
	
	// dest
	$dest = substr($path, 0, strlen($path) - (strlen(strrchr($path, "/")) - 1));
	$c->set('dest', $dest);

	// template_id
	if (!empty($_REQUEST['template'])) 	// not priority to DB
		unset($template_id);

	if (empty($template_id)) {
		if (!empty($_REQUEST['template'])) {
			$template_path = $_REQUEST['template'];
			$sql = 'select template_id, template_path, template_name, edit_template_id from template_tbl';
			$templates = $c->GetDriver()->get($sql);
			$c->set('templates', $templates);
			foreach($templates as $val) {
				if ($val['template_path'] == $template_path) {
	                                $c->set('template_name', $val['template_name']);
	                                $c->set('template_path', $val['template_path']);
	                                $edit_template_id = $val['edit_template_id'];
					break;
				}
			}
		}
		if (empty($edit_template_id)) {
			$template_id = REGAP_DEFAULT_TEMPLATE_ID;
		}
	}
	// template
	if (empty($edit_template_id)) {
		if (empty($templates)) {
			$sql = 'select template_id, template_name, template_path, edit_template_id from template_tbl';
			$templates = $c->GetDriver()->get($sql);
			$c->set('templates', $templates);
		}
		for($i=0;$i<count($templates);$i++) {
			if ($templates[$i]['template_id'] == $template_id) {
				$c->set('template_name', $templates[$i]['template_name']);
				$c->set('template_path', $templates[$i]['template_path']);
				$edit_template_id = $templates[$i]['edit_template_id'];
				break;
			}
		}
	}
	// edit_template_path
	$sql = 'select edit_template_path from edit_template_tbl where edit_template_id = ?';
	$ret = $c->GetDriver()->getOne($sql, array($edit_template_id));
	if (!$ret) {
		trigger_error(regap_get_error_string(E_REGAP_GET_EDIT_TEMPLATE_PATH), E_USER_ERROR);
	}
	if (file_exists(EDITTEMPLATEDIR.$ret['edit_template_path'])) {
		$c->set('edit_template_path', $ret['edit_template_path']);
	}
	else {
		set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_EDIT_STATUS_EDIT_TEMPLATE_WARNING);
	}
}

function action( &$c )
{
	// js output
	$js = "/edit.js";
	if(!js_output($js)) {
		trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
	}
	// subject
	$c->set("subject", REGAP_STRING_EDIT_SUBJECT);

	if ($c->GetAction() == 'page_edit') {
		action_page_edit($c);
	}
	else {
		// contents set
		$contents = array();
		//var_dump($_POST);
		foreach($_POST as $key => $val) {
			if (ereg(REGAP_CONTENTS_NAME_REGULAR_EXPRESSION,$key)) {
				$contents[substr($key,strlen(REGAP_CONTENTS_PREFIX_NAME))] = $val;
			}
		}
		//var_dump($contents);
		$contents_escape = array();
		foreach($contents as $key => $val) {
			$str = "";
			for($i=0;$i<strlen($val);$i++) {
				$char = mb_substr($val,$i,1);
				if(strchr(REGAP_CONTENTS_ESCAPE_DEFAULT_CHARSET,$char)) {
					$str .= '&#' . trim(ord($char)) . ';';
				}
				else {
					$str .= $char;
				}
			}

			$contents_escape[$key] = $str;
		}
		//$c->set('contents',$contents);
		$c->set('contents',$contents_escape);
		// template_path
		$template_path = $_POST['template_path'];
		$c->set('template_path', $template_path);
	
		// dest
		$dest = $_POST['dest'];
		$c->set('dest', $dest);
		// templates
	        $sql = 'select template_path, template_name from template_tbl';
		$templates = $c->GetDriver()->get($sql);
	        $c->set('templates', $templates);
		// template_name
		$c->set('template_name', $_POST['template_name']);
		// edit_template_path
		if (file_exists(EDITTEMPLATEDIR.$_POST['edit_template_path'])) {
			$c->set('edit_template_path', $_POST['edit_template_path']);
		}
		else {
			set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_EDIT_STATUS_EDIT_TEMPLATE_WARNING); 
		}
		// path
		$path = $_POST['path'];
		if (is_directory_exist($c, $path) || ereg(REGAP_PATH_DIR_REGULAR_EXPRESSION, $path)) {
			set_status($c, REGAP_STATUS_KIND_WARNING, sprintf(REGAP_STRING_EDIT_STATUS_PATH_WARNING,$path));
			$c->set('path', $path);
			return;
		}
		$c->set('path', $path);

		// token check
		if (get_token()!=$_POST['token']) {
			set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_EDIT_STATUS_ACTION_FAIL);
			return;
		}

		if ($c->GetAction() == 'page_edit_check') {
			// $c->SetTemplate(REGAP_TEMPLATE_DIR.$template_path);
			//$c->SetTemplateFile(REGAP_TEMPLATE_DIR.$template_path);
			// action_page_edit_check
			ob_start();
			include(REGAP_TEMPLATE_DIR.$template_path);
			$output = ob_get_contents();
			ob_end_clean();
			/*
			$output2 = mb_ereg_replace('>',">\n",$output);
			$output = "";
			foreach( mb_split("\n",$output2) as $val) {
				$str = "";
				if (mb_eregi('src=.(((([^:]*)*(:+[^/][^:]*)*)*)*(:+[^/][^:]*)*)*',$val,$str)) {
					$str = $str[0];
					if (strstr($str,"'")) {
						$output .= mb_eregi_replace("src='", "src='".REGAP_URL, $val); 
					}
					else if (strstr($str,'"')) {
						$output .= mb_eregi_replace('src="', 'src="'.REGAP_URL, $val);
					}
				}
				else if (mb_eregi('href=.(((([^:]*)*(:+[^/][^:]*)*)*)*(:+[^/][^:]*)*)*"',$val,$str)) {
					$str = $str[0];
					if (strstr($str,"'")) {
						$output .= mb_eregi_replace("href='", "href='".REGAP_URL, $val);
					}
					else if (strstr($str,'"')) {
						$output .= mb_eregi_replace('href="', 'href="'.REGAP_URL, $val);
					}
				}
				else {
					$output .= $val;
				}
			}
			*/
			$output = mb_eregi_replace("<head>",'<head><base href="'.REGAP_URL.'">',$output);
			print($output);
			exit();
		}
		else {
			$c->SetTemplate("page_edit");
			
			$sql = 'select template_path, template_id from template_tbl where template_path = ?';
			$ret = $c->GetDriver()->getOne($sql, array($template_path));
			if (!$ret) {
			        trigger_error(regap_get_error_string(E_REGAP_PAGE_EDIT_TEMPLATE_PATH,array($template_path)), E_USER_WARNING);
				set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_EDIT_STATUS_TEMPLATE_WARNING);
				return;
			}
			$template_id = $ret["template_id"];
	
			switch($c->GetAction()) {
				case 'page_edit_upload':
					action_page_edit_upload($c, $dest);
					break;
				case 'page_edit_save':
					if (action_page_edit_save($c, $path, $template_id, $template_path, $contents)) {
						set_status($c, REGAP_STATUS_KIND_SUCCESS, REGAP_STRING_EDIT_STATUS_SAVE_SUCCESS);
					}
					break;
				case 'page_edit_release':	// save and release
					action_page_edit_release($c, $path, $template_id, $template_path, $contents);
					break;
				case 'page_edit_delete':
					action_page_edit_delete($c, $path);
					if (REGAP_EDIT_DELETE_DISPLAY) {
						$c->set("contents","");
					}
					break;
				case 'page_edit_remove':
					$url = action_page_edit_remove($c, $path);
					if ($url) {
						set_status($c, REGAP_STATUS_KIND_SUCCESS, sprintf(REGAP_STRING_EDIT_STATUS_REMOVE_SUCCESS,$url));
					}
					break;
				default:
					trigger_error(regap_get_error_string(E_REGAP_PAGE_EDIT_ACTION,array($c->GetAction())), E_USER_WARNING);
					set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_STATUS_ACTION_WARNING);
					break;
			}
		}
	}
}
?>
