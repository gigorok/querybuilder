<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

class UpdateTest extends \BaseTest
{
    function testUpdateQuery()
    {
        $this->getQueryBuilder()->update('my_table')
            ->set('key2', 'value')
            ->set('key1', 123)
            ->set('key3', '456')
            ->where(['key3' => '444', 'key1' => null]);

        $this->assertEquals(
            "UPDATE my_table SET key2 = :key2, key1 = :key1, key3 = :key3 WHERE key3 = :wkey3 AND key1 IS NULL",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            ['value', 123, '456', '444'],
            $this->getQueryBuilder()->buildValues()
        );

        ####################

        $this->getQueryBuilder()->update('my_table')
            ->set('key1', 123)
            ->set('key3', null)
            ->where(['key3' => '444']);

        $this->assertEquals(
            "UPDATE my_table SET key1 = :key1, key3 = :key3 WHERE key3 = :wkey3",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            [123, null, '444'],
            $this->getQueryBuilder()->buildValues()
        );

        ####################

        $this->getQueryBuilder()->update('my_table')
            ->set('key3', null);

        $this->assertEquals(
            "UPDATE my_table SET key3 = :key3",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            [null],
            $this->getQueryBuilder()->buildValues()
        );

        ####################

        $this->getQueryBuilder()->update('my_table')
            ->set('key3', null)
            ->where(['key1' => null]);

        $this->assertEquals(
            "UPDATE my_table SET key3 = :key3 WHERE key1 IS NULL",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            [null],
            $this->getQueryBuilder()->buildValues()
        );
    }

}