<?php
/*-----------------------------------------------------------------------------
modified for Regap by rabbits.
copyright (c) 2009 rabbits software.

cheetan is licensed under the MIT license.
copyright (c) 2006 cheetan all right reserved.
http://php.cheetan.net/
-----------------------------------------------------------------------------*/
class CController extends CObject
{
	var $action = DEFAULT_ACTION;
	var $actionfile = array();	// ACTION_NUM(ACTION, PRE_ACTION, POST_ACTION)
	var $actionfile_ext = ".php";

	var	$template		= null;
	var $templatefile = null;
	var $templatefile_ext	= ".html";
	var $viewfile		= null;
	var $viewfile_ext	= ".html";
	var $variables		= array();
	var	$db;
	var $sanitize;
	var $s;
	var	$validate;
	var	$v;
	//	Model Array
	var $m				= array();
	var	$post			= array();
	var	$get			= array();
	var	$request		= array();
	var	$data			= array();

	var	$is_authentication = FALSE;
	var	$is_authority = FALSE;

	function CController()
	{
		$this->RequestHandle();
	}
	
	
	function AddModel( $path, $name = "" )
	{
		$cname	= basename( $path, ".php" );
		$cname	= strtolower( $cname );
		if( !$name )	$name = $cname;
		$cname	= "C" . ucfirst( $name );
		if( !file_exists( $path ) )
		{
			print "Model File $path is not exist.";
		}
		else
		{
			require_once( $path );
			eval( '$class = new ' . $cname . '();' );
			if( !$class->table )	$class->table = $name;
			$class->SetController( $this );
			$this->m[$name]	= $class;
			if( empty( $this->{$name} ) )	$this->{$name} = &$this->m[$name];
		}
	}
	
	function SetTemplate( $template )
	{
		$this->template = $template;
		$this->templatefile	= TEMPLATEDIR . "/" . $this->template . $this->templatefile_ext;
	}

	//function SetTemplateFile( $template, $ext = '.html' )
	function SetTemplateFile( $templatefile )
	{
		// $this->templatefile     = TEMPLATEDIR . "/" . $this->template . $this->templatefile_ext;
		$this->templatefile = $templatefile;
	}
	
	
	function SetViewFile( $viewfile )
	{
		$this->viewfile	= TEMPLATEDIR . "/" . $viewfile;
	}
	
	function SetAction( $action )
	{
		if (empty($GLOBALS['g_arrActionSettings'][$action])) {
			$action = DEFAULT_ACTION;
		}
		else {
			$action = $GLOBALS['g_arrActionSettings'][$action][ACTION_SETTINGS_ACTION];
		}

		// definition action
		if (!empty($GLOBALS['g_arrActionSettings'][$action][ACTION_SETTINGS_FILE][ACTION])) {
			if (file_exists($GLOBALS['g_arrActionSettings'][$action][ACTION_SETTINGS_FILE][ACTION])) {
				$this->action = $action;
			}
			else {
				$this->action = DEFAULT_ACTION;
			}
		}
		else {
			if (file_exists(ACTIONDIR . "/" . $action . $this->actionfile_ext)) {
				$this->action = $action;
			}
			else {
				$this->action = DEFAULT_ACTION;
			}
		}

		for($i=0;$i<ACTION_NUM;$i++) {
			$actionfile = "";
			if (!empty($GLOBALS['g_arrActionSettings'][$action][ACTION_SETTINGS_FILE][$i])) {
				//if (file_exists($GLOBALS['g_arrActionSettings'][$action][ACTION_SETTINGS_FILE][$i])) {
					$actionfile = $GLOBALS['g_arrActionSettings'][$action][ACTION_SETTINGS_FILE][$i];
				//}
			}
			
			// default settings
			if (empty($actionfile)) {
				$this->actionfile[$i] = $GLOBALS['g_arrAction'][$i][ACTION_DIR] . "/" . $this->action . $this->actionfile_ext;
			}
			else {
				$this->actionfile[$i] = $actionfile;
			}
		}

		$this->template = $this->action;
		$this->templatefile = TEMPLATEDIR . "/" . $this->template . $this->templatefile_ext;
		//print($this->template);
		//print($this->templatefile);
	}
	
	function SetActionFile( $actionfile, $action = ACTION )
	{
		$this->actionfile[$action] = $GLOBALS['g_arrAction'][$action][ACTION_DIR] . "/" . $actionfile;
	}

	function GetDriver( $kind = DBKIND_PDO )
	{
		return $this->db->driver[$kind];
	}

	function GetActionFile( $action = ACTION )
	{
		return $this->actionfile[$action];
	}

	function GetAction()
	{
		return $this->action;
	}

	function GetTemplate()
	{
		return $this->template;
	}

	function GetTemplateFile()
	{
		return $this->templatefile;
	}
	
	
	function GetViewFile()
	{
		if( $this->viewfile )
		{
			return $this->viewfile;
		}
		
		$pos	= strpos( SCRIPTFILE, "." );
		if( $pos === FALSE )	return SCRIPTFILE . $this->viewfile_ext;
		if( !$pos )				return $this->viewfile_ext;
		
		list( $title, $ext )	= explode( ".", SCRIPTFILE );
		return $title . $this->viewfile_ext;
	}
	
	
	function set( $name, $value )
	{
		$this->variables[$name]	= $value;
	}
	
	function get( $name )
	{
		if (!empty($this->variables[$name])) {
			return $this->variables[$name];
		}

		return null;
	}
	
	function setarray( $datas )
	{
		foreach( $datas as $key => $data )
		{
			$this->set( $key, $data );
		}
	}


	function redirect( $url, $is301 = FALSE )
	{
		if( $is301 )
		{
			header( "HTTP/1.1 301 Moved Permanently" );
		}
		header( "Location: " . $url );
		exit();
	}
	
	
	function RequestHandle()
	{
		if( count( $_GET ) )		$this->get = $_GET;
		if( count( $_POST ) )		$this->post = $_POST;
		if( count( $_REQUEST ) )	$this->request = $_REQUEST;
		$this->ModelItemHandle( $_GET );
		$this->ModelItemHandle( $_POST );
	}
	
	
	function ModelItemHandle( $requests )
	{
		foreach( $requests as $key => $request )
		{
			if( strpos( $key, "/" ) !== FALSE )
			{
				list( $model, $element )		= explode( "/", $key );
				$this->data[$model][$element]	= $request;
			}
		}
	}
	
	
	//function GetVariable($key = NULL)
	function GetVariable()
	{
		/*
		if($key) {
			if (array_key_exists($key, $this->variables)) {
				return $this->variables[$key];
			}
		}
		*/
		return $this->variables;
	}
	
	
	function GetDatabase()
	{
		return $this->db;
	}
	
	
	function SetDatabase( $db )
	{
		$this->db	= &$db;
	}


	function SetSanitize( $sanitize )
	{
		$this->sanitize	= $sanitize;
		$this->s		= &$this->sanitize;
	}


	function SetValidate( $validate )
	{
		$this->validate	= $validate;
		$this->v		= &$this->validate;
	}
}
?>
