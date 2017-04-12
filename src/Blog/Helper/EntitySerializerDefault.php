<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 10:05 PM
 */

namespace Blog\Helper;


use Blog\Entity;
use Symfony\Component\Serializer\Serializer;

/**
 * Class EntitySerializerDefault
 *
 * @package Blog\Helper
 */
class EntitySerializerDefault implements EntitySerializer
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * EntitySerializerDefault constructor.
     *
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Entity $entity
     *
     * @return array
     */
    public function serialize(Entity $entity)
    {
        return $this->serializer->normalize($entity, 'json');
    }
}