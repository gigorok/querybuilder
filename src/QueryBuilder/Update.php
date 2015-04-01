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
     * @var array
     */
    protected $parameters = [];

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
            $this->tableName(),
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
     * @return array
     */
    function getPlaceholdersValues()
    {
        return array_merge(array_values($this->parameters), array_values($this->where));
    }
}