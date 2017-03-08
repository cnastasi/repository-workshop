<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 3/8/17
 * Time: 1:54 PM
 */

namespace Blog\Exceptions;


/**
 * Class EmptyTitleException
 *
 * @package Blog\Exceptions
 */
class EmptyTitleException extends \Exception
{
    /**
     * EmptyTitleException constructor.
     */
    public function __construct()
    {
        parent::__construct('Empty title');
    }
}