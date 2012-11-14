# DBUtil for LaravelPHP #

When working w/ the DB class I found I couldn't perform certain DB management functions.  Something to do w/ how the DB class interacts w/ the PDO connection.  I made this class to handle the handful of misc management functions I needed.

## Methods ##

* ``DBUtil::truncate($table);`` Runs simple truncate on table.
* ``DBUtil::optimize($table);`` Runs simple optimize on table.
* ``DBUtil::columns($table, [$connection]);`` Returns array of available columns for table.
* ``DBUtil::tables([$database], [$connection]);`` Returns array of available tables for database.
* ``DBUtil::databases([$connection]);`` Returns array of available databases.

## Limitations ##

I'm told this only works with MySQL databases.