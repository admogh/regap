<?php
/**
 * regap define error code and message file
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 *
 */

$i = 0; 
$g_arrStringError = array();

$i++; define('E_REGAP_ID_NON_EXISTS',$i); $g_arrStringError[$i] = "IDが存在しません。";
$i++; define('E_REGAP_PDO_PREPARE',$i); $g_arrStringError[$i] = "PDOのプリペアード処理でエラーが発生しました（%s:%s:%s）。";
$i++; define('E_REGAP_PDO_QUERY',$i); $g_arrStringError[$i] = "PDOのクエリ実行でエラーが発生しました（%s:%s:%s）。";
$i++; define('E_REGAP_GET_CONTENTS',$i); $g_arrStringError[$i] = "コンテンツデータを取得できませんでした。";
//$i++; define('E_REGAP_EDIT_SELECT_FROM_TEMPLATE_TBL,$i); $g_arrStringError[$i] = "編集アクションでテンプレートテーブルからのデータが取得できませんでした。";
$i++; define('E_REGAP_GET_EDIT_TEMPLATE_PATH',$i); $g_arrStringError[$i] = "編集テンプレートテーブルの編集テンプレートパスが取得できませんでした。";
$i++; define('E_REGAP_GET_TOKEN',$i); $g_arrStringError[$i] = "クッキーが存在しません。";
$i++; define('E_REGAP_JS_OUTPUT',$i); $g_arrStringError[$i] = 'JavaScriptファイルの出力に失敗しました（%s）。';
$i++; define('E_REGAP_PAGE_EDIT_ACTION',$i); $g_arrStringError[$i] = '指定されたアクションがNULLか存在しません（%s）。';
$i++; define('E_REGAP_PAGE_EDIT_TEMPLATE_PATH',$i); $g_arrStringError[$i] = 'テンプレートが存在しません（%s）。';
$i++; define('E_REGAP_PDO_EXECUTE', $i); $g_arrStringError[$i] = "PDOのプリペアード実行でエラーが発生しました（%s:%s:%s）。";
$i++; define('E_REGAP_PAGE_EDIT_ID',$i); $g_arrStringError[$i] = "IDが存在しません。";
$i++; define('E_REGAP_PAGE_EDIT_RELEASE_OB_START',$i); $g_arrStringError[$i] = "バッファリングを開始できません。";
$i++; define('E_REGAP_PAGE_EDIT_RELEASE_FILE_WRITE',$i); $g_arrStringError[$i] = "ファイルの書き込みに失敗しました（%s）。";
$i++; define('E_REGAP_PAGE_EDIT_RELEASE_FILE_CLOSE',$i); $g_arrStringError[$i] = "ファイルのクローズに失敗しました（%s）。";
$i++; define('E_REGAP_PAGE_RELEASE_OB_START',$i); $g_arrStringError[$i] = "バッファリングを開始できません。";
$i++; define('E_REGAP_PAGE_RELEASE_FILE_OPEN',$i); $g_arrStringError[$i] = "ファイルを開くことができません（%s）";
$i++; define('E_REGAP_PAGE_RELEASE_FILE_WRITE',$i); $g_arrStringError[$i] = "ファイルの書き込みに失敗しました（%s）。";
$i++; define('E_REGAP_PAGE_RELEASE_FILE_CLOSE',$i); $g_arrStringError[$i] = "ファイルのクローズに失敗しました（%s）。";

function regap_get_error_string($code, $arr = null)
{
	if ($arr) {
		$message = vsprintf($GLOBALS['g_arrStringError'][$code], $arr);
	}
	else {
		$message = $GLOBALS['g_arrStringError'][$code];
	}

	$str = "[Regap:" . $code . "] " . $message;
	return $str;
}

?>
