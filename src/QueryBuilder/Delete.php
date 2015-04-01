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
     * @return string
     */
    protected function buildQuery()
    {
        return sprintf(
            "DELETE FROM %s%s",
            $this->tableName(),
            $this->buildWhere()
        );
    }

    /**
     * @return array
     */
    function getPlaceholdersValues()
    {
        return array_values($this->where);
    }
}