<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 3/8/17
 * Time: 1:55 PM
 */

namespace Blog\Exceptions;


class EmptyContentException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Empty content');
    }
}