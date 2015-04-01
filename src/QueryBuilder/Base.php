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
 * Class Base
 * @package QueryBuilder\QueryBuilder
 */
abstract class Base
{
    /**
     * @var string|null
     */
    protected $table_name = null;

    /**
     * @var array
     */
    protected $where = [];

    /**
     * @return string
     */
    abstract protected function buildQuery();

    /**
     * @return string
     */
    protected function tableName()
    {
        return $this->table_name;
    }

    /**
     * @return string
     */
    function getSqlString()
    {
        return $this->buildQuery();
    }

    /**
     * @return array
     */
    function getPlaceholdersValues()
    {
        return [];
    }

    /**
     * @param $filters []
     * @return $this
     */
    function where($filters)
    {
        $this->where = array_merge($this->where, $filters);

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
}