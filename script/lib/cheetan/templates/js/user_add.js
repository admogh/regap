/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

function uploadFileCheck(n,p) {
        var re_n = new RegExp('<?php print(REGAP_ID_REGULAR_EXPRESSION); ?>');
        var re_p = new RegExp('<?php print(REGAP_PASSWORD_REGULAR_EXPRESSION); ?>');
        if (!n.match(re_n)) {
		alert('<?php print(sprintf(REGAP_STRING_USER_ADD_ID_ALERT, REGAP_ID_REGULAR_EXPRESSION)); ?>');
	        return false;
	}
	if (!p.match(re_p)) {
	        alert('<?php print(sprintf(REGAP_STRING_USER_ADD_PASSWORD_ALERT, REGAP_PASSWORD_REGULAR_EXPRESSION)); ?>');
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
                var name = $("input[@name=name]").attr('value');
		var password = $("input[@name=password]").attr('value');
		if(uploadFileCheck(name,password)) {
			return true;
		}
		return false;
	});
});


