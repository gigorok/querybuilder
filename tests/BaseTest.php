<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \QueryBuilder\QueryBuilder
     */
    protected $query_builder = null;

    function setUp()
    {
        parent::setUp();

        $this->query_builder = new \QueryBuilder\QueryBuilder();
    }

    /**
     * @return \QueryBuilder\QueryBuilder
     */
    protected function getQueryBuilder()
    {
        return $this->query_builder;
    }

}