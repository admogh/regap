<?php
/*-----------------------------------------------------------------------------
modified for Regap by rabbits.
copyright (c) 2009 rabbits software.

cheetan is licensed under the MIT license.
copyright (c) 2006 cheetan all right reserved.
http://php.cheetan.net/
-----------------------------------------------------------------------------*/
define( "DBKIND_PDO", "0" );

class CDatabaseConfig extends CObject
{
	var	$host;
	var	$user;
	var $pswd;
	var	$db;
	var $kind;
}


class CDatabase extends CObject
{
	var	$config			= array();
	var $connect		= array();
	var	$driver			= array();
	var $class			= array( "CDBPDO"
					//		, "CDBMysql"
					//		, "CDBPgsql"
					//		, "CDBTextsql"
						);
	
	
	function add( $name, $host, $user, $pswd, $db, $kind = DBKIND_PDO )
	{
		$config	= new CDatabaseConfig();
		$config->host			= $host;
		$config->user			= $user;
		$config->pswd			= $pswd;
		$config->db				= $db;
		$config->kind			= $kind;
		if( empty( $this->driver[$kind] ) )
		{
			$str	= '$this->driver[$kind] = new ' . $this->class[$kind] . '();';
			eval( $str );
		}
		$this->config[$name]	= $config;
	}
	
	
	function connect()
	{
		foreach( $this->config as $name => $config )
		{
			$connect	= $this->driver[$config->kind]->connect( $config->host, $config->user, $config->pswd, $config->db );
			if( !$connect )
			{
				print "Failed connect to $name.<br>";
			}
			$this->connect[$name] = $connect;
		}
	}
	
	
	function query( $query, $name = "" )
	{
		$ret	= $this->driver[$this->config[$name]->kind]->query( $query, $this->connect[$name] );
		if( !$ret )
		{
			print "[DBERR] $query<BR>";
		}
		
		return $ret;
	}
	
	
	function GetFindQuery( $query, $condition = "", $order = "", $limit = "", $group = "" )
	{
		return $this->driver[$this->config[$name]->kind]->GetFindQuery( $query, $condition, $order, $limit, $group );
	}
	
	
	function findquery( $query, $condition = "", $order = "", $limit = "", $group = "", $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->findquery( $this->connect[$name], $query, $condition, $order, $limit, $group );
	}
	
	
	function findall( $table, $condition = "", $order = "", $limit = "", $group = "", $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->findall( $this->connect[$name], $table, $condition, $order, $limit, $group );
	}
	
	
	function find( $query, $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->find( $query, $this->connect[$name] );
	}
	
	
	function count( $query, $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->count( $query, $this->connect[$name] );
	}
	
	
	function insert( $table, $datas, $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->insert( $table, $datas, $this->connect[$name] );
	}
	
	
	function getcount( $table, $condition = "", $limit = "", $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->getcount( $this->connect[$name], $table, $condition, $limit );
	}
	
	
	function update( $table, $datas, $condition, $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->update( $table, $datas, $condition, $this->connect[$name] );
	}
	
	
	function del( $table, $condition, $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->del( $table, $condition, $this->connect[$name] );
	}
	
	
	function CreateCondition( $field, $value, $name = "" )
	{
		return $this->driver[$this->config[$name]->kind]->CreateCondition( $field, $value );
	}
}
?>
