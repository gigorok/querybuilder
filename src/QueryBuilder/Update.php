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
 * Class Update
 * @package QueryBuilder\QueryBuilder
 */
class Update extends Base
{
    /**
     * @var string
     */
    protected $table_name = null;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $where = [];

    /**
     * @param $table_name
     * @return self
     */
    function __construct($table_name)
    {
        $this->table_name = $table_name;

        return $this;
    }

    /**
     * @return string
     */
    protected function buildQuery()
    {
        return sprintf(
            "UPDATE %s SET %s%s",
            $this->table_name,
            implode(', ', array_map(function($prop) {
                return sprintf("%s = :%s", $prop, $prop);
            }, array_keys($this->parameters))),
            $this->buildWhere()

        );
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
        return array_merge(array_values($this->parameters), array_values($this->where));
    }
}