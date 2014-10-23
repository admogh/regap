/** js for regap common routine
 *
 * new window open 
 * 
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

// window open
function windowOpen(width, height, features, prefix){

    if (width) {
     if (window.screen.width > width)
      features+=", left="+(window.screen.width-width)/2;
     else width=window.screen.width;
      features+=", width="+width;
    }
    if (height) {
      if (window.screen.height > height)
       features+=", top="+(window.screen.height-height)/2;
      else height=window.screen.height;
       features+=", height="+height;
    }
    
    _window_name = prefix;
    for( i=0; i<16; i++ ) {
        _window_name += Math.floor(Math.random()*16).toString(16);
    }
    window.open("about:blank",_window_name,features);
    
    return _window_name;
/*
    form_name.target = _window_name;
    form_name.method = "post";
    //form_name.action = action;
    form_name.submit();
*/
}

// change password
function changePassword(form_name){
	document.getElementById("account_action").name = "action_inputchangepassword";
	windowOpen(form_name, 350, 125, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_change_password_");
//	windowOpen(form_name, 350, 125, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_change_password_", "index.php?=action_inputchangepassword=true");
}

// new account
function newAccount(form_name){
	document.getElementById("account_action").name = "action_inputnewaccount";
	windowOpen(form_name, 350, 125, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_new_account_");
//	windowOpen(form_name, 350, 125, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_new_account_", "index.php?action_inputnewaccount=true");
}

// file remove
function removeFile(form_name){
//	alert(document.getElementById("action").name);
	document.getElementById("action").name = "action_inputremove";
	windowOpen(form_name, 350, 125, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_remove_");
}

// file upload
function uploadFile(form_name, kind){
//	alert(document.getElementById("action").name);
	windowOpen(form_name, 350, 125, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_upload_");
}
