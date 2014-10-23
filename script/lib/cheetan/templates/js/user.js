/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

$(function(){
        // window name
	window_name = "regap_user";
	for( i=0; i<16; i++ ) {
	    window_name += Math.floor(Math.random()*16).toString(16);
	}
	window.name = window_name; 

	$("#action-menu-change input[@type=submit]").click(function(){
		if (!confirm('<?php print(REGAP_STRING_TEMPLATE_ACTION_CHANGE_CONFIRM); ?>')) {
			return false;
		}
		$("form").attr('action',"<?php print(get_action_link()); ?>"+$(this).attr('name'));
	});

	$("#check-action-menu-delete input[@type=submit]").click(function(){
		if (!confirm('<?php print(REGAP_STRING_TEMPLATE_ACTION_DELETE_CONFIRM); ?>')) {
			return false;
		}
		var b = false;
		$("td.check input[@type=checkbox]").each(function(){
			if ($(this).attr('checked'))
				b = true;
		});
		if (!b) {
			alert('<?php print(REGAP_STRING_TEMPLATE_ACTION_DELETE_ALERT); ?>');
			return false;
		}

		$("form").attr('action',"<?php print(get_action_link()); ?>"+$(this).attr('name'));
	});

	$("th input[@type=checkbox]").click(function(){
		if ($(this).attr('checked')) {
			check = true;
		}
		else {
			check = false;
		}

		$("td.check input[@type=checkbox]").attr('checked', check);
	});

	$("#action-menu-upload a").click(function(){
		wn = windowOpen(325, 175, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_user_add_");
		$(this).attr('target',wn);
	});

	$("#action-menu-password-change a").click(function(){
                wn = windowOpen(375, 175, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_user_password_");
                $(this).attr('target',wn);
	});
});


