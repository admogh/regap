/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

function uploadFileCheck(d, s) {
	var re_s = new RegExp('<?php print(REGAP_FILE_UPLOAD_SRC_REGULAR_EXPRESSION); ?>');
	var re_d = new RegExp('<?php print(REGAP_FILE_UPLOAD_DEST_REGULAR_EXPRESSION); ?>');
	if (!s.match(re_s)) {
		alert('<?php print(sprintf(REGAP_STRING_UPLOAD_FILE_SRC_ALERT, REGAP_FILE_UPLOAD_SRC_REGULAR_EXPRESSION)); ?>');
		return false;
	}
	if (!d.match(re_d)) {
		alert('<?php print(sprintf(REGAP_STRING_UPLOAD_FILE_DEST_ALERT, REGAP_FILE_UPLOAD_DEST_REGULAR_EXPRESSION)); ?>');
		return false;	
	}

return true;
}

function uploadFilePre(action)
{
	$("form").attr("action","<?php print(get_action_link()); ?>"+action);
	$("form").attr("target","_self");
	$("form").attr("enctype","multipart/form-data");
	$("#contents").children().each(function(){
		var fix = $(this).attr('name');
		fix = $("input[@name=edit_contents_prefix]").attr('value') + fix;
		$(this).attr('name',fix);
	});
	document.getElementById('edit-form').encoding = "multipart/form-data";
}

$(function(){
	$("input[@type=submit][@name!=page_edit_upload]").click(function(){
		switch ($(this).attr('name')) {
			case 'page_edit_release':
				if (!confirm('<?php print(REGAP_STRING_EDIT_SUBMIT_RELEASE_CONFIRM); ?>')) {
					return false;
				}
				break;
			case 'page_edit_delete':
				if (!confirm('<?php print(REGAP_STRING_EDIT_SUBMIT_DELETE_CONFIRM); ?>')) {
					return false;
				}
				break;
			case 'page_edit_remove':
				if (!confirm('<?php print(REGAP_STRING_EDIT_SUBMIT_REMOVE_CONFIRM); ?>')) {
					return false;
				}
				break;
			default:
				break;
		}

		$("form").attr('enctype',"");
		document.getElementById('edit-form').encoding = "application/x-www-form-urlencoded";
		$("form").attr('action',"<?php print(get_action_link()); ?>"+$(this).attr('name'));
		if ($("input[@name=edit_contents_prefix]").attr('value') != "") {
			$("#contents").children().each(function(){
				var fix =$(this).attr('name');
				fix = $("input[@name=edit_contents_prefix]").attr('value') + fix;
				$(this).attr('name',fix);
			});
		}
		if ($(this).attr('name') == 'page_edit_check') {
			$("form").attr("target","_blank");
		}
		else {
			$("form").attr("target","_self");
		}
		$("input[@name=edit_contents_prefix]").attr('value',"");	// for blank

		return true;
	});

	$("input[@name=page_edit_upload]").click(function(){
		var dest = $("input[@name=dest]").attr('value');
		var src = $("input[@name=user_file]").attr('value');
		<?php
			if (REGAP_FILE_UPLOAD_CONFIRM) {
		?>
				if(confirm("<?php print(REGAP_STRING_UPLOAD_FILE_CONFIRM); ?>")) {
					if (uploadFileCheck(dest, src)) {
						uploadFilePre($(this).attr("name"));
								return true;
					}
					else {
						return false;
					}
				}
				else {
					return false;
				}
		<?php
			}
			else {
		?>
			if (uploadFileCheck(dest, src)) {
				uploadFilePre($(this).attr("name"));
				return true;
			}
			else {
				return false;
			}
		<?php
			}
		?>
	});

	$("#info-field-value").click(function(){
		if (confirm("<?php print(REGAP_STRING_EDIT_INFO_CONFIRM); ?>")) {
			location.href="<?php print(get_action_link('page_edit')); ?>&path=" + $("input[@name=path-new]").val() + "&template=" + $("select[@name=template-new]").val();
		}
	});

	$(".parts-edit-icon").click(function(){
		$(this).parent().next().children().removeAttr("disabled");
		$("#info-field-value").removeAttr("disabled");
	});
});

