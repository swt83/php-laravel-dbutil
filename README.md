# DBUtil

A Laravel PHP library for advanced database functions.

When working w/ the DB class I found I couldn't perform certain DB management functions.  Something to do w/ how the DB class interacts w/ the PDO connection.  I made this class to handle the handful of misc management functions I needed.

## Install

Normal install via Composer.

## Methods

* ``DBUtil::make($table, $columns, [$connection]);`` Build a new table.
* ``DBUtil::drop($table, [$connection]);`` Drop a table.
* ``DBUtil::truncate($table, [$connection]);`` Truncate a table.
* ``DBUtil::optimize($table, [$connection]);`` Optimize a table.
* ``DBUtil::columns($table, [$connection]);`` Returns array of available columns for table.
* ``DBUtil::type($table, $column, [$connection]);`` Returns array of information about a column.
* ``DBUtil::tables([$database], [$connection]);`` Returns array of available tables for database.
* ``DBUtil::databases([$connection]);`` Returns array of available databases.

## Limitations

I'm told this only works with MySQL databases.
