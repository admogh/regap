<?php
/*-----------------------------------------------------------------------------
modified for Regap by rabbits.
http://stbr.no-ip.org/

PDO Data Base Driver for cheetan
v0.10 by takaofan
http://www.rainorshine.asia/
-----------------------------------------------------------------------------*/
class CDBPDO extends CDBCommon
{
	var $connect;
	var $stmt = null;

	function connect( $config )
	{
		$dsn = REGAP_DB.":dbname=".REGAP_NAME.";host=".REGAP_HOST;
		$connect = new PDO($dsn, REGAP_USER, REGAP_PASS);
		$this->connect = &$connect;
		return $connect;
	}
/*
	function query( $query, $connect )
	{
		$this->last_query	= $query;
		list($usec, $sec)	= explode( " ", microtime() );
		$time				= (float)$sec + (float)$usec;
		$res				= $connect->query($query, PDO::FETCH_ASSOC);
	    list($usec, $sec)	= explode( " ", microtime() );
		$this->query_time	= ( (float)$sec + (float)$usec ) - $time;
		if( $res )
		{
			if( $last_insert_id = $connect->lastInsertId() )
			{
				$this->last_insert_id	= $last_insert_id;
			}
			if( $affected = $res->rowCount() )
			{
				$this->affected_rows	= $affected;
			}
		}
		else
		{
			$this->last_error	= $connect->errorInfo();
		}
//		$this->_push_log();
		return $res;
	}
*/

	function query( $query )
	{
		$stmt = $this->connect->query($query);
		if(!$stmt) {
			trigger_error(regap_get_error_string(E_REGAP_PDO_QUERY, $this->connect->errorInfo()), E_USER_ERROR);
		}

		return $stmt;
		/*
		$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $ret;
		*/
	}

	function prepare( $query )
	{
		$stmt = $this->connect->prepare($query);
		if(!$stmt) {
			trigger_error(regap_get_error_string(E_REGAP_PDO_PREPARE, $this->connect->errorInfo()), E_USER_ERROR);
		}
		return $stmt;
	}

	function execute( $arr )
	{
		$ret = $this->stmt->execute($arr);
		if(!$ret) {
			trigger_error(regap_get_error_string(E_REGAP_PDO_EXECUTE, $this->stmt->errorInfo()), E_USER_ERROR);
		}
		return $ret;
//		return $this->stmt->columnCount();
	}

	function fetch( $mode = PDO::FETCH_ASSOC )
	{
		$arr = $this->stmt->fetchAll($mode);

		return $arr;
	}

	function getOne( $query, $arr )
	{
//	var_dump($query);
//	var_dump($arr);
		$this->stmt = $this->prepare($query);
		$ret = $this->stmt->execute($arr);
		if($ret) {
			$arr = $this->fetch();
			return $arr[0];
		}

		return null;
	}

	function get( $query, $arr = null )
	{
		$arr_ret = null;
		if ($arr) {
			$this->stmt = $this->prepare($query);
			$ret = $this->stmt->execute($arr);
			if($ret) {
				$arr_ret = $this->fetch();
			}
		}
		else {
			$stmt = $this->query($query);
			$arr_ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $arr_ret;
	}

	function set($query, $arr = null)
	{
		if ($arr) {
			$this->stmt = $this->prepare($query);
			$ret = $this->stmt->execute($arr);
		}
		else {
			$ret = $this->query($query);
		}

		if (!$ret) {
			trigger_error(regap_get_error_string(E_REGAP_PDO_EXECUTE, $this->stmt->errorInfo()), E_USER_WARNING);		
		}

		return $ret;	
	}
/*
	function find( $query, $connect )
	{
		$ret	= array();
		if( $res = $this->query( $query, $connect ) )
		{
			while( $row = $res->fetch() )
			{
				array_push( $ret, $row );
			}
		}
		return $ret;
	}
*/

	function count( $query, $connect )
	{
		if( $res = $this->query( $query, $connect ) )
		{
			return $res->rowCount();
		}

		return 0;
	}


	function field( $field )
	{
		return $field;
	}

	function value($value)
	{
		if ($value === null) return 'NULL';
		$value = $this->escape($value);
		return $value;
	}

	function escape( $str )
	{
		return $this->connect->quote( $str );
	}
}
?>
