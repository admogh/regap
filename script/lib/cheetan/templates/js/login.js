/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

$(function(){
	var strUA = "";
	strUA = navigator.userAgent.toLowerCase();
	if (strUA.indexOf("msie")!=-1){
		$.ajaxSetup({ ifModified: true });
	}
	enableExpandDir(null, $("#page-contents-list tr"),{action: 'inplace'});
	$("#page-menu-edit").click(function(){
		var template_path = $("select[@name=template] option:selected").val();
		this.href += '&template=' + template_path;
	});

	$("#all-select-field-value").click(function(){
		$("input[@type=checkbox]").attr('checked', true);
	});

	$("#all-reset-field-value").click(function(){
		$("input[@type=checkbox]").attr('checked', false);
	});

	$("input[@type=submit]").click(function(){
		switch ($(this).attr('name')) {
			case 'page_release':
				if (!confirm('<?php print(REGAP_STRING_LOGIN_ACTION_RELEASE_CONFIRM); ?>')) {
					return false;
				}
				break;
			case 'page_delete':
				if (!confirm('<?php print(REGAP_STRING_LOGIN_ACTION_DELETE_CONFIRM); ?>')) {
					return false;
				}
				break;
			case 'page_remove':
				if (!confirm('<?php print(REGAP_STRING_LOGIN_ACTION_REMOVE_CONFIRM); ?>')) {
					return false;
				}
				break;
			default:
				break;
		}

		$("form").attr('action',"<?php print(get_action_link()); ?>"+$(this).attr('name'));
		return true;
	});
});


