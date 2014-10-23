<?php
/*-----------------------------------------------------------------------------
cheetan is licensed under the MIT license.
copyright (c) 2006 cheetan all right reserved.
http://php.cheetan.net/
-----------------------------------------------------------------------------*/
class CModel extends CObject
{
	var	$id				= "id";
	var	$name			= "";
	var $table			= "";
	var	$db;
	var	$controler;
	var $validatefunc	= array();
	var $validatemsg	= array();
	var $validateresult	= array();
	
	
	function SetController( &$controller )
	{
		$this->controller	= &$controller;
		$this->SetDatabase( $controller->GetDatabase() );
	}
	
	
	function SetDatabase( &$db )
	{
		$this->db	= $db;
	}
	
	
	function query( $query )
	{
		$this->db->query( $query, $this->name );
	}
	
	
	function findquery( $query, $condition = "", $order = "", $limit = "", $group = "" )
	{
		return $this->db->findquery( $query, $condition, $order, $limit, $group, $this->name );
	}


	function find( $condition = "", $order = "", $limit = "", $group = "" )
	{
		return $this->db->findall( $this->table, $condition, $order, $limit, $group, $this->name );
	}
	
	
	function findone( $condition = "", $order = "" )
	{
		$result	= $this->find( $condition, $order, 1 );
		if( count( $result ) )	return $result[0];
		return FALSE;
	}
	
	
	function findby( $field, $value, $order = "", $limit = "" )
	{
		$condition	= $this->db->CreateCondition( $field, $value, $this->name );
		return $this->find( $condition, $order, $limit );
	}
	
	
	function findoneby( $field, $value, $order = "" )
	{
		$condition	= $this->db->CreateCondition( $field, $value, $this->name );
		return $this->findone( $condition, $order );
	}
	
	
	function getcount( $condition = "", $limit = "" )
	{
		return $this->db->getcount( $this->table, $condition, $limit, $this->name );
	}


	function insert( $datas )
	{
		return $this->db->insert( $this->table, $datas, $this->name );
	}


	function updateby( $datas, $condition )
	{
		return $this->db->update( $this->table, $datas, $condition, $this->name );
	}
	
	
	function update( $datas )
	{
		if( array_key_exists( $this->id, $datas ) )
		{
			$copy		= array_slice( $datas, 0 );
			unset( $copy[$this->id] );
			$condition	= $this->db->CreateCondition( $this->id, $datas[$this->id], $this->name );
			return $this->updateby( $datas, $condition );
		}
		
		return FALSE;
	}


	function del( $condition )
	{
		return $this->db->del( $this->table, $condition, $this->name );
	}
	
	
	function validate( $datas )
	{
		$ret		= TRUE;
		$validater	= &$this->controller->validate;
		foreach( $datas as $key => $data )
		{
			if( array_key_exists( $key, $this->validatefunc ) )
			{
				$func	= $this->validatefunc[$key];
				if( method_exists( $validater, $func ) )
				{
					$this->validateresult[$key]	= $validater->$func( $data );
					if( !$this->validateresult[$key] )
					{
						$ret	= FALSE;
					}
				}
			}
		}
		
		return $ret;
	}
	
	
	function validatemsg( $datas )
	{
		$ret		= "";
		$validater	= &$this->controller->validate;
		foreach( $datas as $key => $data )
		{
			if( array_key_exists( $key, $this->validatefunc ) )
			{
				$func	= $this->validatefunc[$key];
				if( method_exists( $validater, $func ) )
				{
					$this->validateresult[$key]	= $validater->$func( $data );
					if( !$this->validateresult[$key] && array_key_exists( $key, $this->validatemsg ) )
					{
						$ret	.= $this->validatemsg[$key];
					}
				}
			}
		}
		
		return $ret;
	}
	
	
	function GetValidateError()
	{
		return $this->validateresult;
	}
	
	
	function to_datetime( $time = "" )
	{
		if( !$time )	$time = time();
		return date( "Y-m-d H:i:s", $time );
	}
}
?>
