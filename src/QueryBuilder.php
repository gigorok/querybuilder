<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

namespace QueryBuilder;

/**
 * Class QueryBuilder
 * @package QueryBuilder
 */
class QueryBuilder
{
    const QUERY_TYPE_INSERT = "insert";
    const QUERY_TYPE_UPDATE = "update";
    const QUERY_TYPE_DELETE = "delete";
    const QUERY_TYPE_SELECT = "select";

    /**
     * @var string
     */
    protected $query_type = self::QUERY_TYPE_SELECT;

    /**
     * @var \QueryBuilder\QueryBuilder\Base
     */
    protected $query = null;

    /**
     * @return string
     */
    function getQueryType()
    {
        return $this->query_type;
    }

    /**
     * @param null|string $table_name
     * @return QueryBuilder\Insert
     */
    function insert($table_name = null)
    {
        $this->query_type = self::QUERY_TYPE_INSERT;

        return $this->query = new QueryBuilder\Insert($table_name);
    }

    /**
     * @param $table_name string
     * @return QueryBuilder\Update
     */
    function update($table_name)
    {
        $this->query_type = self::QUERY_TYPE_UPDATE;

        return $this->query = new QueryBuilder\Update($table_name);
    }

    /**
     * @param $table_name string|null
     * @return QueryBuilder\Delete
     */
    function delete($table_name = null)
    {
        $this->query_type = self::QUERY_TYPE_DELETE;

        return $this->query = new QueryBuilder\Delete($table_name);
    }

    /**
     * @param $fields array|string
     * @return QueryBuilder\Select
     */
    function select($fields = ['*'])
    {
        $this->query_type = self::QUERY_TYPE_SELECT;

        return $this->query = new QueryBuilder\Select(Utils::arrayWrap($fields));
    }

    /**
     * @return string
     */
    function buildQuery()
    {
        return $this->query->getSqlString();
    }

    /**
     * @return array
     */
    function buildValues()
    {
        return $this->query->getPlaceholdersValues();
    }
}