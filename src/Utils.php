<?php
/**
 * querybuilder
 *
 * @author Igor Gonchar <gigorok@gmail.com>
 * @copyright 2015 Igor Gonchar
 */

namespace QueryBuilder;

/**
 * Class Utils
 * @package QueryBuilder
 */
class Utils
{
    /**
     * @access static
     * @param $param
     * @return array
     */
    public static function arrayWrap($param)
    {
        return is_array($param) ? $param : [$param];
    }
}
