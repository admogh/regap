<?php
/*-----------------------------------------------------------------------------
cheetan is licensed under the MIT license.
copyright (c) 2006 cheetan all right reserved.
http://php.cheetan.net/
-----------------------------------------------------------------------------*/
class CDBMysql extends CDBCommon
{
	function connect( $host, $user, $pswd, $db )
	{
		$connect = mysql_connect( $host, $user, $pswd );
		if( $connect )
		{
			mysql_select_db( $db, $connect );
		}
		return $connect;
	}
	
	
	function query( $query, $connect )
	{
		return mysql_query( $query, $connect );
	}
	
	
	function find( $query, $connect )
	{
		$ret	= array();
		if( $res = $this->query( $query, $connect ) )
		{
			while( $row = mysql_fetch_assoc( $res ) )
			{
				array_push( $ret, $row );
			}
		}
		
		return $ret;
	}
	
	
	function count( $query, $connect )
	{
		if( $res = $this->query( $query, $connect ) )
		{
			return mysql_num_rows( $res );
		}
		
		return 0;
	}
}
?>
