# DBUtil for LaravelPHP #

When working w/ the DB class I found I couldn't do some simple DB management functions.  Something to do w/ how the DB class interacts w/ the PDO connection.  I made this class to handle the handful of misc management functions I need.

``DBUtil::truncate($table);`` Runs simple truncate query.
``DBUtil::optimize($table);`` Runs simple optimize query.
``DBUtil::columns($table);`` Returns array of available columns.
``DBUtil::tables();`` Returns array of available tables for connection.
``DBUtil::databases();`` Returns array of available databases.