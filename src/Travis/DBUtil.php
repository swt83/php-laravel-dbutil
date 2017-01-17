<?php

namespace Travis;

class DBUtil
{
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

        // build table
        \Schema::connection($connection)->create($table, function($table) use($columns)
        {
            // always have id field
            $table->increments('id');

            // for each column...
            foreach ($columns as $column)
            {
                // get vars
                $type = $column['type'];
                $field = isset($column['field']) ? $column['field'] : null;
                $length = isset($column['length']) ? $column['length'] : null;

                // add column
                $table->$type($field, $length);

                // if index set...
                if (isset($column['index']))
                {
                    // if index true...
                    if ($column['index'])
                    {
                        // add index
                        $table->index($field);
                    }
                }
            }
        });
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
     * Get information about a column.
     *
     * @param   string  $table
     * @param   string  $connection
     * @return  array
     */
    public static function type($table, $column, $connection = null)
    {
        $columns = static::get_table_columns($table, $connection);

        // return
        return isset($columns[$column]) ? $columns[$column] : [];
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
        return array_keys(static::get_table_columns($table, $connection));
    }

    /**
     * Return list of columns from a table, with details.
     *
     * @param   string  $table
     * @param   string  $connection
     * @return  array
     */
    protected static function get_table_columns($table, $connection = null)
    {
        // query the pdo
        $result = \DB::connection($connection)->getPdo()->query('show columns from '.$table);

        // build array
        $columns = [];
        while ($row = $result->fetch(\PDO::FETCH_NUM))
        {
            // split to find type and length
            $parts1 = explode(' ', isset($row[1]) ? $row[1] : null);
            $parts2 = explode('(', $parts1[0]);
            $type = $parts2[0];
            $length = isset($parts2[1]) ? str_replace(')', '', $parts2[1]) : null;

            $columns[$row[0]] = [
                'type' => $type,
                'length' => $length,
                'null' => isset($row[2]) ? $row[2] === 'YES' : null,
                'key' => isset($row[3]) ? $row[3] : null,
                'default' => isset($row[4]) ? $row[4] : null,
                'extra' => isset($row[5]) ? $row[5] : null,
            ];
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
        while ($row = $result->fetch(\PDO::FETCH_NUM))
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
    public static function table_exists($table)
    {
        return in_array($table, static::tables());
    }
}
