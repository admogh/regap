<?php
 /**  
 * startup
 *      
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1  
 */
//require_once('regap/app/Regap_Error.php');
require_once('regap_define.php');
require_once('regap_string.php');

ini_set('session.save_path','./tmp');
session_start();
session_unset();
session_destroy();
session_start();
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/install.css">
<title><?php print(REGAP_STRING_INSTALL_TITLE); ?></title>
</head>

<body>
<h1><a href="./"><img src="img/logo_install.gif" alt="Regap" style="border-style:none"/></a></h1>
<h1><?php print(REGAP_STRING_INSTALL_SUBJECT); ?></h1>
<hr>

<form action="regap_init.php" method="POST">
<input type="hidden" name="token" value="<?php echo $token; ?>">
<p>
<?php print(REGAP_STRING_INSTALL_ID); ?><br>
<input type="text" name="id" value="<?php print($_REQUEST['id']); ?>"><br>	
<?php print(REGAP_STRING_INSTALL_PASSWORD); ?><br>
<input type="password" name="password"><br>
</p>
	
<p>
<?php print(REGAP_STRING_INSTALL_DB_KIND); ?><br>
<?php
if (empty($_REQUEST['db_kind'])) {
	$db_kind = "mysql";
}
else {
	$db_kind = $_REQUEST['db_kind'];
}
print('<input type="text" name="db_kind" value="'.$db_kind.'"><br>');
?>

<?php print(REGAP_STRING_INSTALL_DB_USER); ?><br>
<input type="text" name="db_user" value="<?php print($_REQUEST['db_user']); ?>"><br>
<?php print(REGAP_STRING_INSTALL_DB_PASSWORD); ?><br>
<input type="password" name="db_password"><br>
<?php print(REGAP_STRING_INSTALL_DB_HOST); ?><br>
<?php
if (empty($_REQUEST['db_host'])) {
	$db_host = "localhost";
}
else {
	$db_host = $_REQUEST['db_host'];
}
print('<input type="text" name="db_host" value="'.$db_host.'"><br>');
?>
<?php print(REGAP_STRING_INSTALL_DB_NAME); ?><br>
<input type="text" name="db_name" value="<?php print($_REQUEST['db_name']); ?>"><br>
</p>

<p>
<?php print(REGAP_STRING_INSTALL_URL); ?><br>
<?php
if (empty($_REQUEST['url'])) {	
	$url = (isset($_SERVER['HTTPS']))? 'https' : 'http';
	$url .= '://' . $_SERVER["HTTP_HOST"] . '/regap/';
}
else {
	$url = $_REQUEST['url'];
}
print('<input type="text" name="url" value="' . $url . '" size="100">');
?>
<br>
<?php print(REGAP_STRING_INSTALL_TOP); ?><br>
<?php
if (empty($_REQUEST['top'])) {
	$top = "/home/hoge/html/regap";
}
else {
	$top = $_REQUEST['top'];
}
print('<input type="text" name="top" value="' . $top . '" size="100">');
?>
<br>
<?php print(REGAP_STRING_INSTALL_APP); ?><br>
<?php
if (empty($_REQUEST['app'])) {
	$app = realpath(dirname(__FILE__).'/script');
}
else {
	$app = $_REQUEST['app'];
}
print('<input type="text" name="app" value="' . $app . '" size="100">');
?>
<br>
</p>

<p>
<input type="submit" value="<?php print(REGAP_STRING_INSTALL_CREATE); ?>">
</p>
</form>

</body>
</html>
