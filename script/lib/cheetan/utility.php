<?php
/**
 * regap utility function file
 *
 * @author      rabbits <rbtsgm at gmail.com>
 * @package     Regap1
 *
 */

function get_link($path)
{
	$path = substr($path, 1);
	
	return REGAP_URL.$path;
}

function make_li($id, $key, $val)
{
	$ret = '<li id="'.$id.'">'.$key."</li>";
	if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
		$ret .= "<br>";
	}
	$ret .= $val;

	return $ret;
}

function get_new_id(&$c, $table, $id)
{
	$sql = 'select '.$id.' from '.$table.' order by '.$id;
	$ret = $c->GetDriver()->get($sql);
	$new_id = 1;
	foreach($ret as $val) {
		if($val[$id]!=$new_id) {
			break;
		}
		$new_id++;
	}
	return $new_id;
}

function get_upload_max_filesize()
{
        $size = trim(ini_get('upload_max_filesize'));
        switch(strtolower($size[strlen($size)-1])) {
	        case 'g':
			$size *= 1024;
                case 'm':
		        $size *= 1024;
		case 'k':
		        $size *= 1024;
		        break;
		default:
		        break;
	}
	return $size;
}

function set_status(&$c, $kind, $message)
{
	if(!empty($message)) {
		$status = $c->get("status");
		if (empty($status)) {
			$status = array(); 
		}
		array_push($status, array("kind" => $kind, "message" => $message));
		$c->set("status",$status);
	}
}

function is_directory_exist(&$c, $path)	
{
	// db
	$query = 'select path from page_tbl where path like ?';
	$ret = $c->GetDriver()->get($query, array($path."/_%"));
	if($ret) {
		return $ret;	// return array
	}

	// file
	if(is_dir(REGAP_TOP_DIR . $path)) {
		return $path;
	}
	
	return FALSE;
}

function make_reg_where($str)
{
	switch (REGAP_DB) {
		case 'pgsql':
			$where = $str . " ~ ?";
			break;
		default:	// mysql
			$where = $str . ' REGEXP ?';
			break;
	}

	return $where;
}

function get_id(&$c, $name)
{
	$sql = 'select id from manage_tbl where name = ?';
	$ret = $c->GetDriver()->getOne($sql, array($name));
	if ($ret) {
		return $ret["id"];
	}

	return NULL;
}

function js_output($in, $out = "", $force = REGAP_JS_OUTPUT_FORCE)
{
	if ($out == "") $out = $in;

	$path = REGAP_JS_DIR.$out;
	if (file_exists($path) && !$force) {
		return TRUE;
	}

	if(!ob_start()) {
		return FALSE;
	}
	include(JSTEMPLATEDIR.$in);
	$output = ob_get_contents();
	ob_end_clean();

	$f = fopen($path, 'w');
	if (!$f) return FALSE;
	if (!fwrite($f, $output)) return FALSE;
	if (!fclose($f)) return FALSE;

	return TRUE;
}

function get_token()
{
	if(empty($_COOKIE[REGAP_COOKIE_IDI])) {
		trigger_error(regap_get_error_string(E_REGAP_GET_TOKEN), E_USER_ERROR);
	}
	return md5($_COOKIE[REGAP_COOKIE_IDI]);
}

function get_contents(&$c, $page_id, $escape = REGAP_CONTENTS_ESCAPE_DEFAULT_CHARSET )
{
	if ($page_id=="") {
		trigger_error(regap_get_error_string(E_REGAP_GET_CONTENTS),E_USER_ERROR);
	}
	$sql = 'select contents from contents_tbl where page_id = ?';
	$ret = $c->GetDriver()->get($sql, array($page_id));
	if (!$ret) {
		trigger_error(regap_get_error_string(E_REGAP_GET_CONTENTS),E_USER_ERROR);
	}
	if (count($ret)) {
		$ret = $ret[0];
		$jsphon = new Jsphon_Decoder();
		$arr = $jsphon->decode($ret['contents']);
		if (REGAP_CHARACTER_CODE=='EUC-JP') { 
			foreach($arr as $key => $val) {
				$arr[$key] = mb_convert_encoding($val, "EUC-JP", "auto");
			}
		}
		foreach($arr as $key => $val) {
			$str = "";
			for($i=0;$i<strlen($arr[$key]);$i++) {
				$char = mb_substr($arr[$key],$i,1);
				if(strchr($escape,$char)) {
					$str .= '&#' . trim(ord($char)).';';
				}
				else {
					$str .= $char;
				}
			}

			$arr[$key] = $str;
		}
	}
	else {
		$arr = array();
	}

	return $arr;
}

function get_page(&$c, $template_id = "", $id = "")
{
	$sql = 'select page_id, path, template_id, id from page_tbl ';
	if ($template_id!="" && $id!="") {
		// where id, template_id
		$sql .= 'where template_id = ? and id = ?';
		$arr = $c->GetDriver()->get($sql, array($template_id, $id));
	}
	else if ($template_id!="") {
		// where template_id
		$sql .= 'where template_id = ?';
		$arr = $c->GetDriver()->get($sql, array($template_id));
	}
	else if ($id!="") {
		// where id
		$sql .= 'where id = ?';
		$arr = $c->GetDriver()->get($sql, array($id));
	}
	else {
		// all
		$arr = $c->GetDriver()->get($sql);
	}

	return $arr;
}

function is_action_bit($action, $bit)
{
	$action_bit = $GLOBALS['g_arrActionSettings'][$action][ACTION_SETTINGS_BIT];
	
	if($action_bit && !($bit & $action_bit)) {
		return FALSE;
	}
	
	return TRUE;
}

function get_default_path(&$c, $dir = '/', $ext = '.html')
{
	$i=1;

	do {
		$path = $dir . $i++ . $ext;
		$sql = 'select * from page_tbl where path = ?';
		$ret = $c->GetDriver()->getOne($sql, array($path));
		$cnt = count($ret);
	} while(!empty($cnt));

	return $path;
}

?>
