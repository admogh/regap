/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

function uploadFileCheck(o,n) {
        var re = new RegExp('<?php print(REGAP_PASSWORD_REGULAR_EXPRESSION); ?>');
        if (!n.match(re)) {
		alert('<?php print(sprintf(REGAP_STRING_USER_PASSWORD_PASSWORD_ALERT, REGAP_PASSWORD_REGULAR_EXPRESSION)); ?>');
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
                var old_p = $("input[@name=old]").attr('value');
		var new_p = $("input[@name=new]").attr('value');
		if(uploadFileCheck(old_p,new_p)) {
			return true;
		}
		return false;
	});
});


