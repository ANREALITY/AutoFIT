<?php
namespace Order\Mapper;

use DbSystel\DataObject\Environment;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class EnvironmentMapper extends AbstractMapper implements EnvironmentMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = Environment::class;

    /**
     *
     * @return Environment[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('e')->from(static::ENTITY_TYPE, 'e');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('name', $condition)) {
                    $queryBuilder
                        ->andWhere('e.name LIKE :name')
                        ->setParameter('name', '%' . $condition['name'] . '%')
                    ;
                }
                if (array_key_exists('application_technical_short_name', $condition)) {
                    $queryBuilder->join('e.serviceInvoices', 'si');
                    $queryBuilder->join('si.application', 'a');
                    $queryBuilder
                        ->andWhere('a.technicalShortName = :technicalShortName')
                        ->setParameter('technicalShortName', $condition['application_technical_short_name'])
                    ;
                    $queryBuilder->distinct();
                }
            }
        }

        $queryBuilder->setMaxResults($limit ?: null);

        $query = $queryBuilder->getQuery();
        $result = $query->execute(null, $hydrationMode);

        return $result;
    }

}
