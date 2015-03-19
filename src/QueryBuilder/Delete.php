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
 * Class Delete
 * @package QueryBuilder\QueryBuilder
 */
class Delete extends Base
{
    /**
     * @var string
     */
    protected $table_name = null;

    /**
     * @var array
     */
    protected $where = [];

    /**
     * @param $table_name string|null
     * @return Delete
     */
    function __construct($table_name = null)
    {
        return $this->from($table_name);
    }

    /**
     * @param $table_name
     * @return $this
     */
    function from($table_name)
    {
        $this->table_name = $table_name;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    function where($key, $value)
    {
        $this->where[$key] = $value;

        return $this;
    }

    /**
     * @return string
     */
    protected function buildQuery()
    {
        return sprintf(
            "DELETE FROM %s%s",
            $this->table_name,
            $this->buildWhere()
        );
    }

    /**
     * @return string
     */
    protected function buildWhere()
    {
        return count($this->where) > 0 ? " WHERE " . implode(' AND ', array_map(function($prop) {
                if(is_null($this->where[$prop])) {
                    unset($this->where[$prop]);
                    return sprintf("%s IS NULL", $prop);
                } else {
                    return sprintf("%s = :w%s", $prop, $prop);
                }
            }, array_keys($this->where))) : '';
    }

    /**
     * @return array
     */
    function getPlaceholdersValues()
    {
        return array_values($this->where);
    }
}