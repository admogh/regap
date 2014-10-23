<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php
	if (REGAP_CHARACTER_CODE=='EUC-JP') $charset = 'EUC-JP';
	else $charset = 'utf-8';
?>
<meta http-equiv="Content-Type" content="text/html; charset=<?php print($charset); ?>">
<title><?php print($contents['title']); ?></title>
</head>
<body>
<?php print($contents['body']); ?>
</body>
</html>
