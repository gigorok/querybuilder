<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

namespace QueryBuilder\QueryBuilder;

use QueryBuilder\QueryBuilder;

/**
 * Class Insert
 * @package QueryBuilder\QueryBuilder
 */
class Insert extends Base
{
    /**
     * @var string
     */
    protected $table_name = null;

    /**
     * @var string
     */
    protected $returning_column = null;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @param $table_name string|null
     * @return Insert
     */
    function __construct($table_name = null)
    {
        return $this->into($table_name);
    }

    /**
     * @param $table_name
     * @return $this
     */
    function into($table_name)
    {
        $this->table_name = $table_name;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    function set($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @param $columns array
     * @return $this
     */
    function columns($columns)
    {
        foreach ($columns as $column => $value) {
            $this->set($column, $value);
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function buildQuery()
    {
        return sprintf(
            "INSERT INTO %s (%s) VALUES (%s)%s",
            $this->table_name,
            implode(', ', array_keys($this->parameters)),
            implode(', ', array_map(function($el) {
                return sprintf(":%s", $el);
            }, array_keys($this->parameters))),
            $this->returning_column ? sprintf(" RETURNING %s", $this->returning_column) : ""
        );
    }

    /**
     * @return array
     */
    function getPlaceholdersValues()
    {
        return array_values($this->parameters);
    }

    /**
     * @param $column
     * @return $this
     */
    function returning($column)
    {
        $this->returning_column = $column;

        return $this;
    }
}