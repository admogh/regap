<?php
/*-----------------------------------------------------------------------------
modified for Regap by rabbits.
copyright (c) 2009 rabbits software.

cheetan is licensed under the MIT license.
copyright (c) 2006 cheetan all right reserved.
http://php.cheetan.net/
-----------------------------------------------------------------------------*/
class CDispatch extends CObject
{
	function dispatch( &$data )
	{
		$db			= new CDatabase();
		if( function_exists( "config_database" ) )
		{
			config_database( $db );
		}
		$db->connect();
	
		$sanitize	= new CSanitize();
		$validate	= new CValidate();
		$controller	= new CController();
		$controller->SetDatabase( $db );
		$controller->SetSanitize( $sanitize );
		$controller->SetValidate( $validate );
		if( function_exists( "config_models" ) )
		{
			config_models( $controller );
		}
		if (empty($_REQUEST[ACTION_PARAM_NAME])) $ra = "";
		else $ra = $_REQUEST[ACTION_PARAM_NAME];
		$controller->SetAction( $ra );

		$ret = $this->_check_secure( $controller );
		if (!$ret && $controller->GetAction() != 'login') {	// except only 'login'
			$controller->SetAction('index');
		}

		/*
		if( function_exists( "config_controller" ) )
		{
		*/
			for($i=0;$i<ACTION_NUM;$i++) {
				//print($controller->actionfile[$i]."<br>");
				if (file_exists($controller->actionfile[$i])) {
					include_once($controller->actionfile[$i]);
				}
			}
			if (config_controller( $controller ))
			{
				for($i=0;$i<ACTION_NUM;$i++) {
					if (empty($GLOBALS['g_arrActionSettings'][$controller->GetAction()][ACTION_SETTINGS_FUNCTION][$i])) {
						$function = $GLOBALS['g_arrAction'][$i][ACTION_FUNCTION];
						//print("a($i):$function<br>");
						if( function_exists( $function ) ) {
							$function( $controller );
						}
					}
					else {
						$function = $GLOBALS['g_arrActionSettings'][$controller->GetAction()][ACTION_SETTINGS_FUNCTION][$i];
						//print("b:$function<br>");
						if ( function_exists($function) ) {
							$function( $controller );	
						}
					}
				}
			}
		/*
		}
		*/

		$template	= $controller->GetTemplateFile();
		$viewfile	= $controller->GetViewFile();
		$variable	= $controller->GetVariable();

		$view		= new CView($controller);
		$view->SetFile( $template, $viewfile );
		$view->SetVariable( $variable );
		$view->SetSanitize( $sanitize );
		$view->display();

		$data		= $variable;
	}


	function _check_secure( $controller )
	{
		if( function_exists( "is_secure" ) )
		{
			if( is_secure( $controller ) )
			{
				if( function_exists( "check_secure" ) )
				{
					return check_secure( $controller );
				}
			}
		}

		return FALSE;
	}
}
?>
