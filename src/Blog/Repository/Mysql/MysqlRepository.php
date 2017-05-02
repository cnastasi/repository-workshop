<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 4/11/17
 * Time: 9:26 PM
 */

namespace Blog\Repository\Mysql;


use Blog\Entity;
use Blog\Helper\EntityFactory;
use Blog\Helper\EntitySerializer;
use Blog\Helper\PropertyHelper;
use Blog\Repository\EntityRepository;
use Doctrine\Common\Collections\Criteria;
use PDO;

/**
 * Class MysqlRepository
 *
 * @package Blog\Repository\Mysql
 */
abstract class MysqlRepository implements EntityRepository
{

    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var EntitySerializer
     */
    private $entitySerializer;

    /**
     * @var EntityFactory
     */
    private $entityFactory;

    /**
     * MysqlRepository constructor.
     *
     * @param PDO              $connection
     * @param EntitySerializer $entitySerializer
     * @param EntityFactory    $entityFactory
     */
    public function __construct(PDO $connection, EntitySerializer $entitySerializer, EntityFactory $entityFactory)
    {
        $this->connection       = $connection;
        $this->entitySerializer = $entitySerializer;
        $this->entityFactory    = $entityFactory;
    }

    /**
     * @return string
     */
    abstract protected function getTable();

    /**
     * @return string
     */
    abstract protected function getEntity();

    /**
     * @param Entity $entity
     */
    public function save(Entity $entity)
    {
        if (is_a($entity, $this->getEntity())) {
            $data = $this->entitySerializer->serialize($entity);

            $query = $this->buildInsertQuery($data);

            $stmt = $this->connection->prepare($query);

            $stmt->execute($data);

            $id = $this->connection->lastInsertId();

            /** @noinspection PhpInternalEntityUsedInspection */
            PropertyHelper::setProperty($entity, 'id', $id);
        }
    }

    /**
     * @param $id
     *
     * @return Entity
     */
    public function get($id)
    {
        $where  = "id = :id";
        $values = ['id' => $id];

        $result = $this->getBy($where, $values);

        return array_shift($result);
    }

    /**
     * @return Entity[]
     */
    public function getAll()
    {
        return $this->getBy('1 = 1', []);
    }

    /**
     * @param array $data
     *
     * @return string
     */
    private function buildInsertQuery(array $data)
    {
        $query = "INSERT INTO posts (%s) VALUES (%s)";

        $keys         = array_keys($data);
        $query_keys   = implode(', ', $keys);
        $query_values = ':' . implode(', :', $keys);

        return sprintf($query, $query_keys, $query_values);
    }

    /**
     * @param string $where
     * @param array  $values
     *
     * @return array
     */
    protected function getBy($where, $values)
    {
        $query = "SELECT * FROM {$this->getTable()} WHERE {$where};";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($values);

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createEntity($row);
        }

        return $result;

    }

    /**
     * @param Entity $entity
     *
     * @return array
     */
    protected function serialize(Entity $entity)
    {
        return $this->entitySerializer->serialize($entity);
    }

    /**
     * @param array $data
     *
     * @return Entity
     */
    protected function createEntity(array $data)
    {
        return $this->entityFactory->create($this->getEntity(), $data);
    }
}