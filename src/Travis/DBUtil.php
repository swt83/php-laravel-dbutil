<?php

namespace Travis;

class DBUtil {

    /**
     * Make a table.
     *
     * @param   string  $table
     * @param   array   $columns
     * @return  void
     */
    public static function make($table, $columns, $connection = null)
    {
        // check exists
        if (static::exists($table))
        {
            // error
            trigger_error('Table already exists.');

            // return
            return false;
        }

        // Laravel provides a mechanism for building tables,
        // but only in the context of migrations which are run
        // at the command line.  The following is a makeshift
        // way of achieving the same thing using the same methods.

        // NOTE: I don't know how to make this work w/ a custom
        // connection.  Only working w/ default connection.

        $db = new \Laravel\Database\Schema\Table($table);
        $db->create();

        // for each column...
        foreach ($columns as $column)
        {
            // The makeup of the $columns array is to define
            // each field w/ the name as the key, and the
            // value containing both a type and a length.

            $type = $column['type'];
            $field = isset($column['field']) ? $column['field'] : null;
            $length = isset($column['length']) ? $column['length'] : null;

            // add to schema
            $db->$type($field, $length);

            // if index...
            if (isset($column['index']))
            {
                if ($column['index'] == true)
                {
                    $db->index($field);
                }
            }
        }

        // execute
        \Schema::execute($db);
    }

    /**
     * Drop a table.
     *
     * @param   string  $table
     * @return  void
     */
    public static function drop($table, $connection = null)
    {
        \DB::connection($connection)->getPdo()->query('drop table '.$table);
    }

    /**
     * Truncate a table.
     *
     * @param   string  $table
     * @return  void
     */
    public static function truncate($table, $connection = null)
    {
        \DB::connection($connection)->getPdo()->query('truncate '.$table);
    }

    /**
     * Optimize a table.
     *
     * @param   string  $table
     * @return  void
     */
    public static function optimize($table, $connection = null)
    {
        \DB::connection($connection)->getPdo()->query('optimize table '.$table);
    }

    /**
     * Get array of tables columns.
     *
     * @param   string  $table
     * @param   string  $connection
     * @return  array
     */
    public static function columns($table, $connection = null)
    {
        // query the pdo
        $result = \DB::connection($connection)->getPdo()->query('show columns from '.$table);

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
     * Get array of database tables.
     *
     * @param   string  $connection
     * @return  array
     */
    public static function tables($connection = null)
    {
        // capture pdo
        $pdo = \DB::connection($connection)->getPdo();

        // run query
        $result = $pdo->query('show tables');

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
     * Check if table exists.
     *
     * @param   string  $table
     * @return  boolean
     */
    public static function exists($table)
    {
        return in_array($table, static::tables());
    }

}