<?php
/**
 * regap utility
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 *
 */

function stripslashes_deep($value)
{
	$value = is_array($value) ?
		array_map('stripslashes_deep', $value) :
		stripslashes($value);
	return $value;
}

?>
