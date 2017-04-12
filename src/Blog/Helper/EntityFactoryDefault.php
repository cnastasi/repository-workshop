<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:44 PM
 */

namespace Blog\Helper;


use Blog\Entity;
use Symfony\Component\Serializer\Serializer;

/**
 * Class EntityFactoryDefault
 *
 * @package Blog\Helper
 *
 * @internal
 */
class EntityFactoryDefault implements EntityFactory
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * EntityFactoryDefault constructor.
     *
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $class
     * @param array  $data
     *
     * @return Entity
     */
    public function create($class, array $data = [])
    {
        return $this->serializer->denormalize($data, $class);
    }
}