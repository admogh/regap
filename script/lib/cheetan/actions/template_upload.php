<?php
/**
 * regap action file(default action is 'index')
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */
	
function action( &$c )
{
	// title
	$c->set("title",REGAP_STRING_TEMPLATE_UPLOAD_TITLE);

	// edit_template
	$sql = 'select edit_template_id, edit_template_name from edit_template_tbl';
	$edit_template = $c->GetDriver()->get($sql);
	$c->set("edit_template",$edit_template);

	// js output
	$js = "/template_upload.js";
	if(!js_output($js)) {
		trigger_error(regap_get_error_string(E_REGAP_JS_OUTPUT,array($js)), E_USER_ERROR);
	}
}
?>
