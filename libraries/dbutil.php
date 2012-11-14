<?php

/**
 * A LaravelPHP Package for DB management functions.
 *
 * @package    DBUtil
 * @author     Scott Travis <scott.w.travis@gmail.com>
 * @link       http://github.com/swt83/laravel-dbutil
 * @license    MIT License
 */

class DBUtil
{
	/**
	 * Truncate a table.
	 *
	 * @param	string	$table
	 */
	public static function truncate($table)
	{
		return DB::query('truncate '.$table);
	}
	
	/**
	 * Optimize a table.
	 *
	 * @param	string	$table
	 */
	public static function optimize($table)
	{
		return DB::query('optimize table '.$table);
	}
	
	/**
	 * Build array of tables columns.
	 *
	 * @param	string	$table
	 * @param	string	$connection
	 */
	public static function columns($table, $connection = null)
	{
		// query the pdo
		$result = DB::connection($connection)->pdo->query('show columns from '.$table);
		
		// build array
		$columns = array();
		while ($row = $result->fetch(PDO::FETCH_NUM))
		{
			$columns[] = $row[0];
		}
		
		// return
		return $columns;
	}
	
	/**
	 * Build array of database tables.
	 *
	 * @param	string	$connection
	 */
	public static function tables($database = null, $connection = null)
	{
		// capture pdo
		$pdo = DB::connection($connection)->pdo;
	
		// use default database
		if ($database === null)
		{
			$result = $pdo->query('show tables');
		}
		
		// use custom database
		else
		{
			$result = $pdo->query('show tables from '.$database);
		}
		
		// build array
		$tables = array();
		while ($row = $result->fetch(PDO::FETCH_NUM))
		{
			$tables[] = $row[0];
		}
		
		// return
		return $tables;
	}
	
	/**
	 * Build array of databases.
	 *
	 * @param	string	$connection
	 */
	public static function databases($connection = null)
	{
		// query the pdo
		$result = DB::connection($connection)->pdo->query('show databases');
		
		// build array
		$db = array();
		while ($row = $result->fetch(PDO::FETCH_NUM))
		{
			$db[] = $row[0];
		}
		
		// return
		return $db;
	}
}