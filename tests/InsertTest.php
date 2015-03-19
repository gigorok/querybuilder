<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

class InsertTest extends BaseTest
{
    function testReturning()
    {
        $this->getQueryBuilder()->insert()
            ->into('my_table')
            ->set('key1', 123)
            ->returning('*');

        $this->assertEquals(
            "INSERT INTO my_table (key1) VALUES (:key1) RETURNING *",
            $this->getQueryBuilder()->buildQuery()
        );
    }

    function testSetOneByOne()
    {
        $this->getQueryBuilder()->insert()
            ->into('my_table')
            ->set('key1', 123)
            ->set('key2', 'value')
            ->set('key3', null);

        $this->assertEquals(
            "INSERT INTO my_table (key1, key2, key3) VALUES (:key1, :key2, :key3)",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            [123, 'value', null],
            $this->getQueryBuilder()->buildValues()
        );
    }

    function testSetByArray()
    {
        $this->getQueryBuilder()->insert()
            ->into('my_table')
            ->columns([
                'key1' => 123,
                'key2' => 'value',
                'key3' => null
            ]);

        $this->assertEquals(
            "INSERT INTO my_table (key1, key2, key3) VALUES (:key1, :key2, :key3)",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            [123, 'value', null],
            $this->getQueryBuilder()->buildValues()
        );
    }

}