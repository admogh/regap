<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */
	
function action_upload( &$c )
{
	// dest check
	$dest = $_POST['dest'];
	if (!ereg(REGAP_FILE_UPLOAD_DEST_REGULAR_EXPRESSION,$dest)) {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_UPLOAD_STATUS_FILE_DEST_FAIL);
		return;
	}
	// file check
	$file = $_FILES['user_file']['name'];
	if (!ereg(REGAP_FILE_UPLOAD_SRC_REGULAR_EXPRESSION,$file)) {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_UPLOAD_STATUS_FILE_SRC_FAIL);
		return;
	}
	// name
	$name = $_POST['name'];
        if (!ereg(REGAP_TEMPLATE_NAME_REGULAR_EXPRESSION,$file)) {
                set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_TEMPLATE_STATUS_NAME_WARNING);
                return;
        }
	
	$path = $dest . $file;

	// db set
	$template_id = get_new_id($c, "edit_template_tbl", "edit_template_id");
	$sql = 'insert into edit_template_tbl values (?, ?, ?);';
	$arr = array($template_id, $name, $path);
	$ret = $c->GetDriver()->set($sql, $arr);
	if (!$ret) {
		set_status($c, REGAP_STATUS_KIND_WARNING, REGAP_STRING_EDIT_TEMPLATE_STATUS_UPLOAD_WARNING);
		return;
	}

	// file upload
	$dir = EDITTEMPLATEDIR . substr($dest, 0, strlen($dest)-1);
	if (!is_dir($dir)) {
		if (REGAP_EDIT_TEMPLATE_UPLOAD_AUTO_MKDIR) {
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
	$uploadfile = $dir . '/' . $file;
        if (move_uploaded_file($_FILES['user_file']['tmp_name'], $uploadfile)) {
		set_status($c, REGAP_STATUS_KIND_SUCCESS,sprintf(REGAP_STRING_TEMPLATE_STATUS_UPLOAD_SUCCESS,$path));
		return;
	}
	else {
		set_status($c, REGAP_STATUS_KIND_FAIL, REGAP_STRING_UPLOAD_STATUS_FILE_FAIL);
		return;
	}
}

function action_change( &$c )
{
	foreach($_POST['edit_template'] as $key => $val) {
		$sql = 'update edit_template_tbl set edit_template_name = ? where edit_template_id = ?';
		$c->GetDriver()->set($sql, array($val["edit_template_name"], $key));
	}

	if(count($_POST['edit_template'])) {
		set_status($c, REGAP_STATUS_KIND_INFO,REGAP_STRING_EDIT_TEMPLATE_STATUS_CHANGE_INFO);
	}
}

function action_delete( &$c )
{
	$check = $_POST['check'];
	
	if(count($check)) {
		foreach($check as $key => $val) {
			if ($key == REGAP_DEFAULT_EDIT_TEMPLATE_ID) {
				if (empty($warning_message)) $warning_message = REGAP_STRING_EDIT_TEMPLATE_STATUS_DELETE_DEFAULT_ID_WARNING;
				continue;
			}

			$sql = 'select template_id,template_path from template_tbl where edit_template_id = ?';
			$ret = $c->GetDriver()->get($sql, array($key));
			if (count($ret)!=0) {
				foreach($ret as $val2) {
					$sql = 'select page_id, path from page_tbl where template_id = ?';
					$ret2 = $c->GetDriver()->get($sql, array($val2["template_id"]));
					if (count($ret2)!=0) {
						foreach($ret2 as $val3) {
							$sql = 'delete from contents_tbl where page_id = ?';
							$c->GetDriver()->set($sql, array($val3['page_id']));
							if(empty($page_message)) $page_message = REGAP_STRING_TEMPLATE_STATUS_DELETE_PAGE_SUCCESS;
							$page_message .= "<br>".$val3['path'];
						}
						$sql = 'delete from page_tbl where template_id = ?';
						$c->GetDriver()->set($sql, array($val2["template_id"]));
					}
					$sql = 'delete from template_tbl where template_id = ?';
					$c->GetDriver()->set($sql, array($val2["template_id"]));
					if (empty($template_message)) $template_message = REGAP_STRING_TEMPLATE_STATUS_DELETE_TEMPLATE_SUCCESS;
					$template_message .= "<br>".$val2["template_path"];
					if (REGAP_EDIT_TEMPLATE_DELETE_REMOVE_TEMPLATE) {
						$file = REGAP_TEMPLATE_DIR.$val2["template_path"];
						if (file_exists($file)) {
							if(unlink($file)) {
								if (empty($remove_message)) $remove_message = REGAP_STRING_TEMPLATE_STATUS_DELETE_REMOVE_SUCCESS;
								$remove_message .= "<br>".$file;
							}
							else {
								if (empty($unremove_message)) $unremove_message = REGAP_STRING_TEMPLATE_STATUS_DELETE_REMOVE_WARNING;
								$unremove_message .= "<br>".$file;
							}
						}
					}
				}
			}
                        $sql = 'delete from edit_template_tbl where edit_template_id = ?';
			$c->GetDriver()->set($sql, array($key)); 
			if(empty($edit_template_message)) $edit_template_message = REGAP_STRING_EDIT_TEMPLATE_STATUS_DELETE_EDIT_TEMPLATE_SUCCESS;
			$edit_template_message .= "<br>".$val;
			if (REGAP_EDIT_TEMPLATE_DELETE_REMOVE) {
				$file = EDITTEMPLATEDIR.$val;
				if (file_exists($file)) {
					if (unlink($file)) {
						if (empty($remove_message)) $remove_message = REGAP_STRING_TEMPLATE_STATUS_DELETE_REMOVE_SUCCESS;
						$remove_message .= "<br>".$file;
					}
					else {
						if (empty($unremove_message)) $unremove_message = REGAP_STRING_TEMPLATE_STATUS_DELETE_REMOVE_WARNING;
						$unremove_message .= "<br>".$file;
					}
				}
			}
		}
		set_status($c, REGAP_STATUS_KIND_WARNING,$warning_message);
		set_status($c, REGAP_STATUS_KIND_WARNING,$unremove_message);
		set_status($c, REGAP_STATUS_KIND_SUCCESS,$remove_message);
		set_status($c, REGAP_STATUS_KIND_SUCCESS,$page_message);
		set_status($c, REGAP_STATUS_KIND_SUCCESS,$template_message);
		set_status($c, REGAP_STATUS_KIND_SUCCESS,$edit_template_message);
	}
	else {
		set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_TEMPLATE_STATUS_DELETE_WARNING);	
	}
}

function action( &$c )
{
        $arr = getallheaders();
	foreach($arr as $key => $val) {
		$arr[strtolower($key)] = $val;
	}
	if (!empty($arr['x-requested-with'])) {
		if ( $arr['x-requested-with'] == 'XMLHttpRequest' ) {
			$sql = 'select template_path from template_tbl where edit_template_id = ?';
			$ret = $c->GetDriver()->get($sql, array($_GET["edit_template_id"]));
			$c->set("paths",$ret);
		        $c->SetTemplateFile(TEMPLATEDIR."/edit_template_template_path.html");
	                return;
		}
	}

        // subject
	$c->set("subject", $GLOBALS['g_arrStringLoginSubject'][REGAP_LOGIN_MENU_EDIT_TEMPLATE]);

        // js output
        $js = "/edit_template.js";
        if(!js_output($js)) {
	        trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
        }

	$action = $c->GetAction();
	if($action!='edit_template') {
		$c->SetTemplate('edit_template');
		// token check
		if (get_token()!=$_POST['token']) {
			set_status($c, REGAP_STATUS_KIND_WARNING,REGAP_STRING_TEMPLATE_STATUS_ACTION_WARNING);
			return;
		}

		if($action=='edit_template_upload_upload') {
			action_upload($c);
		}
		else if($action=='edit_template_change') {
			action_change($c);
		}
		else if($action=='edit_template_delete') {
			$check = $_POST['check'];
			action_delete($c, $check);
		}
	}

	// list set
	$sql = 'select edit_template_id, edit_template_name, edit_template_path from edit_template_tbl';
	$edit_template = $c->GetDriver()->get($sql);
	$c->set("list",$edit_template);
}
?>
