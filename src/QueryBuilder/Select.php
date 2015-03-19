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
 * Class Select
 * @package QueryBuilder\QueryBuilder
 */
class Select extends Base
{
    /**
     * @var string
     */
    protected $table_name = null;

    /**
     * @var array
     */
    protected $fields = ['*'];

    /**
     * @var array
     */
    protected $where = [];

    /**
     * @var null|string
     */
    protected $order_by_field = null;

    /**
     * @var string
     */
    protected $order_by_dir = 'ASC';

    /**
     * @var null|int
     */
    protected $limit = null;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @param array $fields
     * @return Select
     */
    function __construct($fields = ['*'])
    {
        $this->fields = $fields;

        return $this;
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
     * @param $field
     * @param string $dir
     * @return $this
     */
    function orderBy($field, $dir = 'ASC')
    {
        $this->order_by_field = $field;
        $this->order_by_dir = $dir;

        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param $offset
     * @return $this
     */
    function offset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return string
     */
    protected function buildQuery()
    {
        return sprintf(
            "SELECT %s FROM %s%s%s%s",
            $this->buildSelect(),
            $this->table_name,
            $this->buildWhere(),
            $this->buildOrder(),
            $this->buildLimit()
        );
    }

    /**
     * @return string
     */
    protected function buildSelect()
    {
        return implode(', ', $this->fields);
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
     * @return string
     */
    protected function buildOrder()
    {
        return is_null($this->order_by_field) ? "" : sprintf(" ORDER BY %s %s", $this->order_by_field, $this->order_by_dir);
    }

    /**
     * @return string
     */
    protected function buildLimit()
    {
        return is_null($this->limit) ? "" : sprintf(" LIMIT %d OFFSET %d", $this->limit, $this->offset);
    }

    /**
     * @return array
     */
    function getPlaceholdersValues()
    {
        return array_values($this->where);
    }
}