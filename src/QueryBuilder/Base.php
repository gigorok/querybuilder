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
     * @return string
     */
    abstract protected function buildQuery();

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
     * @param $string
     * @param int $parameter_type
     * @return string
     */
    protected function quote($string, $parameter_type = \PDO::PARAM_STR)
    {
        return is_null(QueryBuilder::$pdo) ? $string : QueryBuilder::$pdo->quote($string, $parameter_type);
    }

}