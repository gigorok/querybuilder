<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

class DeleteTest extends \BaseTest
{
    function testDelete()
    {
        $this->getQueryBuilder()->delete('my_table')
            ->where([
                'key3' => '444',
                'key1' => null
            ]);

        $this->assertEquals(
            "DELETE FROM my_table WHERE key3 = :wkey3 AND key1 IS NULL",
            $this->getQueryBuilder()->buildQuery()
        );

        $this->assertEquals(
            ['444'],
            $this->getQueryBuilder()->buildValues()
        );

    }

}