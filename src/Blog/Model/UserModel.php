<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 8:56 PM
 */

namespace Blog\Model;

use Blog\User;

/**
 * Class UserModel
 *
 * @package Blog\Model
 */
class UserModel implements User
{
    /** @var  int */
    private $id;

    /** @var string */
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}