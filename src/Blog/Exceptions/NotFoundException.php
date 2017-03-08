<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 3/8/17
 * Time: 1:56 PM
 */

namespace Blog\Exceptions;


class NotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Resource not found');
    }
}