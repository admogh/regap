<?php
/**
 * startup build 
 *
 * Creaing table and outputing regap_config.php(configuration file), index html file and common css file.
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 *
 */

// define schema
$schema = (isset($_SERVER['HTTPS']))? 'https' : 'http';

// exception
class RegapInitException extends exception
{
}

ini_set('session.save_path','./tmp');
session_start();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/install.css">
<?php
//require_once("./regap/app/Regap_Error.php");
require_once("regap_string.php");
$title = "<title>".REGAP_STRING_INIT_TITLE."</title>";
print($title);
?>
</head>

<body>

<?php
?>

<?php
require_once("regap_define.php");
try {	
	// init
	$output = "";
	
	$token_age = time() - $_SESSION['token_time'];
	if ($token_age <= REGAP_TOKEN_AGE
	    and (isset($_SESSION['token']) and $_POST['token'] == $_SESSION['token']))
	{
		$clean = array();
		
		// input filter
		// id
		if (strlen($_POST['id'])<=REGAP_ID_LEN && ereg(REGAP_ID_REGULAR_EXPRESSION, $_POST['id'])){
			$clean['id']=$_POST['id'];
		}
		else {
			$message = sprintf(REGAP_STRING_INIT_FILTER_ID, REGAP_ID_REGULAR_EXPRESSION);
			throw new RegapInitException($message);
		}
		// password
		if (strlen($_POST['password'])<=REGAP_PASSWORD_LEN && ereg(REGAP_PASSWORD_REGULAR_EXPRESSION, $_POST['password'])){
			$clean['password']=addcslashes($_POST['password'], REGAP_ADDCSLASHES_REGULAR_EXPRESSION);
		}
		else {
			$message = sprintf(REGAP_STRING_INIT_FILTER_PASSWORD, REGAP_PASSWORD_REGULAR_EXPRESSION);
			throw new RegapInitException($message);
		}
		// DB kind
		$clean['db_kind']=$_POST['db_kind'];
		// DB user
		//if (filter_var($_POST['db_user'])) {
			$clean['db_user']=$_POST['db_user'];
		//}
		//else {
		//	throw new RegapInitException("filtering DB user is failure.");
		//}
		// DB password
		//if (filter_var($_POST['db_password'])) {
			$clean['db_password']=$_POST['db_password'];
		//}
		//else {
		//	throw new RegapInitException("filtering DB password is failure.");
		//}
		// DB host
		//if (filter_var($_POST['db_host'])) {
			$clean['db_host']=$_POST['db_host'];
		//}
		//else {
		//	throw new RegapInitException("filtering DB host is failure.");
		//}
		// DB name
		//if (filter_var($_POST['db_name'])) {
			$clean['db_name']=$_POST['db_name'];
		//}
		//else {
		//	throw new RegapInitException("filtering DB name is failure.");
		//}
		// url
		//if ( filter_var($_POST['url'],FILTER_VALIDATE_URL) ) {
			/*
			for($i=-1;$i>=-1*strlen($_POST['url']);$i--) {
				if (substr($_POST['url'], $i, 1) != '/') {
					break;
				}
			}
			$clean['url'] = substr($_POST['url'], 0, strlen($_POST['url')+$i+1);
			if(substr($clean['url'], -1) != '/') {
				$clean['url'] .= '/';
			}
			*/
			$clean['url'] = $_POST['url'];
		//}
		//else {
		//	throw new RegapInitException("not URL format.");
		//}
		// top
		if ( is_dir($_POST['top']) ) {
			$clean['top']=$_POST['top'];
		}
		else {
			$message = sprintf(REGAP_STRING_INIT_FILTER_TOP, $_POST['top']);
			throw new RegapInitException($message);
		}
		// app
		if ( is_dir($_POST['app']) ) {
			$clean['app']=$_POST['app'];
		}
		else {
			$message = sprintf(REGAP_STRING_INIT_FILTER_APP, $_POST['app']);
			throw new RegapInitException($message);
		}

		// regap_config check
		//if (is_file("regap_config.php")) {
			//require_once("regap_config.php");

			$dsn = $clean['db_kind'].":dbname=".$clean['db_name'].";host=".$clean['db_host'];
			$pdo = new PDO($dsn, $clean['db_user'], $clean['db_password']);
			
			$hash_base = sprintf("%08d", rand(0,99999999));
			
			if ($pdo != null) {
				// manage_tbl
				$sql = 'create table manage_tbl ('.
					'id integer PRIMARY KEY,'.
					'name varchar('.REGAP_ID_LEN.') NOT NULL UNIQUE,'.
					'password varchar('.REGAP_PASSWORD_LEN.') NOT NULL,'.
					'level integer NOT NULL'.
					' ) ';
				if ( $clean['db_kind'] == 'mysql' ) {
					$sql .= 'type=innoDB';
				}
				$sql .= ';';
				$ret = $pdo->query($sql);
				if (!$ret) {
					$str = sprintf(REGAP_STRING_INIT_CREATE_TBL, "manage_tbl");
					throw new RegapInitException($str);
				}
				// id,password insert
				//$level = (1 << 31) + ((1 << 31)-);
				$level = -1;
				$sql = 'insert into manage_tbl values ( ?, ?, ?, ?);';
				$stmt = $pdo->prepare($sql);
				$ret = $stmt->execute(array(1, $clean['id'], md5($clean['id'].$hash_base.$clean['password']), $level));
				if (!$ret) {	
					throw new RegapInitException(REGAP_STRING_INIT_INSERT_ID_PASSWORD);
				}
			
				// edit_template_tbl
				$sql = 'create table edit_template_tbl ('.
					'edit_template_id integer PRIMARY KEY,'.
					'edit_template_name varchar('.REGAP_EDIT_TEMPLATE_NAME_LEN.'),'.
					'edit_template_path varchar('.REGAP_EDIT_TEMPLATE_PATH_LEN.') NOT NULL UNIQUE'.
					' ) ';
				if ( $clean['db_kind'] == 'mysql' ) {
					$sql .= 'type=innoDB';
				}
				$sql .= ';';
				$ret = $pdo->query($sql);
				if (!$ret) {
					$str = sprintf(REGAP_STRING_INIT_CREATE_TBL, "edit_template_tbl");
					throw new RegapInitException($str);
				}
				// default edit template insert
				$sql = 'insert into edit_template_tbl values ( ?, ?, ?);';
				$stmt = $pdo->prepare($sql);
				$edit_template_id = 1;
				$ret = $stmt->execute(array($edit_template_id, REGAP_STRING_INIT_EDIT_TEMPLATE_NAME, "/default.html"));	
				if (!$ret) {	
					throw new RegapInitException(REGAP_STRING_INIT_INSERT_EDIT_TEMPLATE);
				}

				// template_tbl
				$sql = 'create table template_tbl ('.
					'template_id integer PRIMARY KEY,'.
					'template_name varchar('.REGAP_TEMPLATE_NAME_LEN.'),'.
					'template_path varchar('.REGAP_TEMPLATE_PATH_LEN.') NOT NULL UNIQUE,'.
					'edit_template_id integer NOT NULL, FOREIGN KEY (edit_template_id) REFERENCES edit_template_tbl (edit_template_id)'.
					' ) ';
				if ( $clean['db_kind'] == 'mysql' ) {
					$sql .= 'type=innoDB';
				}
				$sql .= ';';
				$ret = $pdo->query($sql);
				if (!$ret) {
					$str = sprintf(REGAP_STRING_INIT_CREATE_TBL, "template_tbl");
					throw new RegapInitException($str);
				}
				// default template insert
				$sql = 'insert into template_tbl values ( ?, ?, ?, ?);';
				$stmt = $pdo->prepare($sql);
				$ret = $stmt->execute(array(1, REGAP_STRING_INIT_TEMPLATE_NAME, "/default.php", $edit_template_id));
//					'" . $clean['app'] . "'/templates/default.php'" . "');";
				if (!$ret) {	
					throw new RegapInitException(REGAP_STRING_INIT_INSERT_TEMPLATE);
				}

				// page_tbl
				$sql = 'create table page_tbl ('.
					'page_id integer PRIMARY KEY,'.
					'path varchar('.REGAP_PAGE_PATH_LEN.') NOT NULL UNIQUE,'.
					'template_id integer NOT NULL, FOREIGN KEY (template_id) REFERENCES template_tbl (template_id),'.
					'id integer NOT NULL, FOREIGN KEY (id) REFERENCES manage_tbl (id)'.
					' ) ';
				if ( $clean['db_kind'] == 'mysql' ) {
					$sql .= 'type=innoDB';
				}
				$sql .= ';';
				$ret = $pdo->query($sql);
				if (!$ret) {
					$str = sprintf(REGAP_STRING_INIT_CREATE_TBL, "page_tbl");
					throw new RegapInitException($str);
				}

				// contents_tbl
				$sql = 'create table contents_tbl ('.
					'page_id integer PRIMARY KEY, FOREIGN KEY (page_id) REFERENCES page_tbl (page_id),'.
					'contents text'.
					' ) ';
				if ( $clean['db_kind'] == 'mysql' ) {
					$sql .= 'type=innoDB';
				}
				$sql .= ';';
				$ret = $pdo->query($sql);
				if (!$ret) {
					$str = sprintf(REGAP_STRING_INIT_CREATE_TBL, "contents_tbl");
					throw new RegapInitException($str);
				}
			
				// done
				$output .= REGAP_STRING_INIT_CREATE_TBL_DONE . "<br>";
				$pdo = null;
			}
			else {
				throw new RegapInitException(REGAP_STRING_INIT_DB_CONNECT);
			}
			
			// config check
			//if ( file_exists("./regap_config.php") ) {
			if ( filesize("regap_config.php") > 0 ) {
				throw new RegapInitException(REGAP_STRING_INIT_REGAP_CONFIG_ALREADY_EXIST);
			}
			else {
				// puts
				$db_kind = 'define("REGAP_DB","'.$clean['db_kind'].'");';
				$db_user = 'define("REGAP_USER","'.$clean['db_user'].'");';
				$db_password = 'define("REGAP_PASS","'.$clean['db_password'].'");';
				$db_host = 'define("REGAP_HOST","'.$clean['db_host'].'");';
				$db_name = 'define("REGAP_NAME","'.$clean['db_name'].'");';
				$url = 'define("REGAP_URL","'.$clean['url'].'");';
				$top = 'define("REGAP_TOP_DIR","'.$clean['top'].'");';
				$app = 'define("REGAP_APP_DIR","'.$clean['app'].'");';
				$hash = 'define("REGAP_HASH_BASE", "'.$hash_base.'");';
				$puts = <<< EOD
<?php
// This file is regap configuration file to customize for user.

// DB KIND
$db_kind
// DB USER
$db_user
// DB PASSWORD
$db_password
// DB HOST
$db_host
// DB NAME
$db_name
// REGAP URL
$url
// REGAP TOP DIRECTORY FOR STATIC FILE OUTPUTED(the last '/' must not be added.)
$top
// REGAP APP DIRECTORY
$app
// REGAP HASH BASE(Never, you may edit:because can't login)
$hash
?>
EOD;
				// file write
				$fp = fopen("regap_config.php","w");
				if ($fp) {
					$fp2 = fopen("regap_config_etc.php","r");
					if ($fp2) {
					    fputs($fp,$puts);	
					    fputs($fp,"\n");
					    while (!feof($fp2)) {
					    	$buffer = fgets($fp2);
						fputs($fp,$buffer);
					    }
					    fclose($fp2);
					    $output .= sprintf(REGAP_STRING_INIT_OUTPUT_REGAP_CONFIG, `pwd`);
					}
					else {
					    throw new RegapInitException(REGAP_STRING_INIT_OPEN_REGAP_CONFIG_ETC);
					}
					
					fclose($fp);
				}
				else {
					throw new RegapInitException(REGAP_STRING_INIT_OPEN_REGAP_CONFIG);
				}
			}
	}
	else {
		throw new RegapInitException(REGAP_STRING_INIT_SESSION_ERROR);
	}
	
	// navigation
	$output .= '<p>';
	$output .= '<strong>' . REGAP_STRING_STARTUP_INFO . '</strong><br><br>';
	$output .= REGAP_STRING_STARTUP_INFO2 . '<br>' . sprintf(REGAP_STRING_STARTUP_INFO3,"./") . '<br><br>';
	$output .= REGAP_STRING_STARTUP_INFO4 . '<br>'
			. "<a href='http://rbts.no-ip.info/trac/regap1/'>http://rbts.no-ip.info/trac/regap1/</a>";
	$output .= '</p>';

	$subject = '<h1><img src="img/logo_dot.gif" alt="Regap"/></h1>' . "\n"
			. '<h1 id="success">' . REGAP_STRING_INIT_SUBJECT_SUCCESS. '</h1>' . "\n"
			. '<hr>';
}
catch (PDOException $e) {
	$output .= "<strong>".REGAP_STRING_INIT_PDO_ERROR."<br>&quot;".$e->getMessage()."&quot;</strong>" . '<br>'
			. '<br>' . '<a href="./install.php?' 
			. "id=" . $_REQUEST['id'] . "&"
			. "db_kind=" . $_REQUEST['db_kind'] . "&"
			. "db_user=" . $_REQUEST['db_user'] . "&"
			. "db_host=" . $_REQUEST['db_host'] . "&"
			. "db_name=" . $_REQUEST['db_name'] . "&"
			. "url=" . $_REQUEST['url'] . "&"
			. "top=" . $_REQUEST['top'] . "&"
			. "app=" . $_REQUEST['app']
			. '">' . REGAP_STRING_INIT_RETURN . '</a>';
	$subject = '<h1><img src="img/logo_error.gif" alt="Regap"/></h1>' . "\n"
			. '<h1 id="fail">' . REGAP_STRING_INIT_SUBJECT_FAIL . '</h1>' . "\n"
			. '<hr>';
}
catch (RegapInitException $e) {
	$output .= "<strong>".$e->getMessage().'</strong>' . '<br>'
			. '<br>' . '<a href="./install.php?' 
			. "id=" . $_REQUEST['id'] . "&"
			. "db_kind=" . $_REQUEST['db_kind'] . "&"
			. "db_user=" . $_REQUEST['db_user'] . "&"
			. "db_host=" . $_REQUEST['db_host'] . "&"
			. "db_name=" . $_REQUEST['db_name'] . "&"
			. "url=" . $_REQUEST['url'] . "&"
			. "top=" . $_REQUEST['top'] . "&"
			. "app=" . $_REQUEST['app']
			. '">' . REGAP_STRING_INIT_RETURN . '</a>';
	$subject = '<h1><img src="img/logo_error.gif" alt="Regap"/></h1>' . "\n"
			. '<h1 id="fail">' . REGAP_STRING_INIT_SUBJECT_FAIL . '</h1>' . "\n"
			. '<hr>';
}

print($subject.$output);
?>
