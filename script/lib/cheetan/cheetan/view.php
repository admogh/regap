<?php
/*-----------------------------------------------------------------------------
cheetan is licensed under the MIT license.
copyright (c) 2006 cheetan all right reserved.
http://php.cheetan.net/
-----------------------------------------------------------------------------*/
class CView extends CObject
{
	var	$template;
	var	$viewfile;
	var $variables;
	var $sanitize;
	var $controller;
	
	function CView(&$c)
	{
		$this->controller = $c;
	}

	function SetFile( $template, $viewfile )
	{
		$this->template		= $template;
		$this->viewfile		= $viewfile;
	}
	
	
	function SetVariable( $variable )
	{
		$this->variables		= $variable;
	}


	function SetSanitize( $sanitize )
	{
		$this->sanitize			= $sanitize;
	}
	
	
	function display()
	{
		if( $this->template )
		{
			$this->_display_template();
		}
		else
		{
			$this->content();
		}
	}
	
	
	function content()
	{
		if( file_exists( $this->viewfile ) )
		{
			$data		= $this->variables;
			$sanitize	= $this->sanitize;
			$s			= $this->sanitize;
			require_once( $this->viewfile );
		}
	}
	
	
	function _display_template()
	{
		if( file_exists( $this->template ) )
		{
			$data		= $this->variables;
			if (empty($this->variables['contents'])) {
				$contents = "";
			}
			else {
				$contents	= $this->variables['contents'];
			}

			$sanitize	= $this->sanitize;
			$s			= $this->sanitize;
			$c = $this->controller;
			require_once( $this->template );
		}
		else
		{
			print "Template '$this->template' is not exist.";
		}
	}
	
	
}
?>
