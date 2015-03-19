<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

class SelectTest extends \BaseTest
{
    function testSelectAll()
    {
        $this->getQueryBuilder()->select()
            ->from('my_table');

        $this->assertEquals(
            "SELECT * FROM my_table",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEmpty(
            $this->getQueryBuilder()->buildValues()
        );
    }

    function testSelectWhere()
    {
        $this->getQueryBuilder()->select('id')
            ->from('my_table')
            ->where('key1', null);

        $this->assertEquals(
            "SELECT id FROM my_table WHERE key1 IS NULL",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEmpty(
            $this->getQueryBuilder()->buildValues()
        );
    }

    function testSelect()
    {
        $this->getQueryBuilder()->select(['*'])
            ->from('my_table')
            ->where('key3', '444')
            ->where('key1', null)
            ->orderBy('key2', 'DESC')
            ->limit(5)
            ->offset(12);

        $this->assertEquals(
            "SELECT * FROM my_table WHERE key3 = :wkey3 AND key1 IS NULL ORDER BY key2 DESC LIMIT 5 OFFSET 12",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            ['444'],
            $this->getQueryBuilder()->buildValues()
        );

    }

}