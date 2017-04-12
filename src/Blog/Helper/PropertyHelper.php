<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 1/11/17
 * Time: 6:17 PM
 */

namespace Blog\Helper;


/**
 * Class PropertyHelper
 *
 * @package Logotel\Core\Helper
 */
class PropertyHelper
{
    /**
     * @param $object
     * @param $property
     * @param $value
     *
     * @internal
     */
    public static function setProperty($object, $property, $value) {

        $setter = \Closure::bind(function ($object) use ($property, $value) {
            $object->{$property}= $value;
        }, null, get_class($object));

        $setter($object);
    }

}