<?php
/*-----------------------------------------------------------------------------
cheetan is licensed under the MIT license.
copyright (c) 2006 cheetan all right reserved.
http://php.cheetan.net/
-----------------------------------------------------------------------------*/
class CDBPgsql extends CDBCommon
{
	function connect( $host, $user, $pswd, $db )
	{
		$connect	= pg_connect( "host=$host port=5432 dbname=$db user=$user password=$pswd" );
		return $connect;
	}
	
	
	function query( $query, $connect )
	{
		return pg_query( $connect, $query );
	}
	
	
	function find( $query, $connect )
	{
		$ret	= array();
		$rownum	= 0;
		if( $res = $this->query( $query, $connect ) )
		{
			while( $row = pg_fetch_array( $res, $rownum, PGSQL_ASSOC ) )
			{
				array_push( $ret, $row );
				$rownum++;
			}
		}
		
		return $ret;
	}
	
	
	function count( $query, $connect )
	{
		if( $res = $this->query( $query, $connect ) )
		{
			return pg_num_rows( $res );
		}
		
		return 0;
	}
}
?>