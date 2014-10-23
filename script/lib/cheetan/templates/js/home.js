/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

$(function(){
        // window name
	window_name = "regap_home";
	for( i=0; i<16; i++ ) {
	    window_name += Math.floor(Math.random()*16).toString(16);
	}
	window.name = window_name; 

	$("#home-menu-template a").click(function(){
		wn = windowOpen(425, 300, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_template_upload_");
		$(this).attr('target',wn);
	});
	$("#home-menu-edit-template a").click(function(){
		wn = windowOpen(400, 250, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_template_upload_");
		$(this).attr('target',wn);
	});
	$("#home-menu-password a ").click(function(){
		wn = windowOpen(375, 175, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_user_password_");
		$(this).attr('target',wn);
	});
});


