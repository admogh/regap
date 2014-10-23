/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

function uploadFileCheck(d, s, n) {
        var re_s = new RegExp('<?php print(REGAP_FILE_UPLOAD_SRC_REGULAR_EXPRESSION); ?>');
        var re_d = new RegExp('<?php print(REGAP_FILE_UPLOAD_DEST_REGULAR_EXPRESSION); ?>');
	var re_n = new RegExp('<?php print(REGAP_TEMPLATE_NAME_REGULAR_EXPRESSION); ?>');
        if (!s.match(re_s)) {
		alert('<?php print(sprintf(REGAP_STRING_UPLOAD_FILE_SRC_ALERT, REGAP_FILE_UPLOAD_SRC_REGULAR_EXPRESSION)); ?>');
	        return false;
	}
	if (!d.match(re_d)) {
	        alert('<?php print(sprintf(REGAP_STRING_UPLOAD_FILE_DEST_ALERT, REGAP_FILE_UPLOAD_DEST_REGULAR_EXPRESSION)); ?>');
	        return false;
	}
	if (!n.match(re_n)) {
		alert('<?php print(sprintf(REGAP_STRING_UPLOAD_FILE_TEMPLATE_NAME_ALERT, REGAP_TEMPLATE_NAME_REGULAR_EXPRESSION)); ?>');
		return false;
	}
	
	if(!opener || opener.closed) {
		$("form").attr('target','_blank');
	}
	else if(opener.top.name) {
		$("form").attr('target', opener.top.name);
	}
	else {
		opener.top.name = "";
		$("form").attr('target',opner.top.name);
	}

	$("form").submit();
	window.close();
	return false;
}

$(function(){
	$("input[@type=submit]").click(function(){
                var dest = $("input[@name=dest]").attr('value');
		var src = $("input[@name=user_file]").attr('value');
		var name = $("input[@name=name]").attr('value');
		if(uploadFileCheck(dest,src,name)) {
			return true;
		}
		return false;
	});
});


