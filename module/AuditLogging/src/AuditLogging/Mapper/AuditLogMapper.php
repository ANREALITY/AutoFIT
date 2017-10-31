<?php
namespace AuditLogging\Mapper;

use DbSystel\DataObject\AuditLog;
use DbSystel\DataObject\AuditLogCluster;
use DbSystel\DataObject\AuditLogFileTransferRequest;
use DbSystel\DataObject\AuditLogServer;
use DbSystel\DataObject\User;
use DbSystel\Paginator\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Order\Mapper\AbstractMapper;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;

class AuditLogMapper extends AbstractMapper implements AuditLogMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = AuditLog::class;

    /**
     * @param $id
     * @return AuditLog
     */
    public function findOne($id)
    {
        $repository = $this->entityManager->getRepository(static::ENTITY_TYPE);
        $entity = $repository->find($id);
        /** @var AuditLog $entity */
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function findAllPaginated(array $criteria = [], $page = null, array $sorting = [])
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->entityManager->createQueryBuilder();
        if (! empty($criteria['change_number'])) {
            $queryBuilder->select('al')->from(AuditLogFileTransferRequest::class, 'al');
            $queryBuilder->join('al.fileTransferRequest', 'ftr');
        } else {
            $queryBuilder->select('al')->from(AuditLog::class, 'al');
        }
        foreach ($criteria as $key => $condition) {
            if (! empty($condition) && is_string($condition)) {
                if ($key === 'username') {
                    $queryBuilder
                        ->andWhere('u.username = :username')
                        ->setParameter('username', $condition);
                } elseif ($key === 'resource_type') {
                    $resourceTypeToClassMap = [
                        AuditLog::RESSOURCE_TYPE_ORDER => AuditLogFileTransferRequest::class,
                        AuditLog::RESSOURCE_TYPE_SERVER => AuditLogServer::class,
                        AuditLog::RESSOURCE_TYPE_CLUSTER => AuditLogCluster::class,
                    ];
                    $queryBuilder
                        ->andWhere($queryBuilder->expr()->isInstanceOf(
                            'al',
                            $resourceTypeToClassMap[$condition]
                        ))
                    ;
                } elseif ($key === 'change_number') {
                    $queryBuilder
                        ->andWhere('ftr.changeNumber = :changeNumber')
                        ->setParameter('changeNumber', $criteria['change_number'])
                    ;
                }
            }
        }
        foreach ($sorting as $key => $condition) {
            if (is_string($condition) && ! empty($condition)) {
                if ($key === 'datetime') {
                    $direction = strtoupper($condition) === 'ASC'
                        ? 'ASC' : 'DESC';
                    $queryBuilder->addOrderBy('al.datetime', $direction);
                }
            }
        }

        $queryBuilder->join('al.user', 'u');
        $query = $queryBuilder->getQuery();
        $paginator = new Paginator(new PaginatorAdapter(new ORMPaginator($query)));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($this->itemCountPerPage);
        return $paginator;
    }

    /**
     *
     * @param AuditLog $dataObject
     *
     * @return AuditLog
     * @throws \Exception
     */
    public function create(AuditLog $dataObject)
    {
        $currentUser = $this->entityManager->getRepository(User::class)->find(
            $dataObject->getUser()->getId()
        );
        $dataObject->setUser($currentUser);
        $this->entityManager->persist($dataObject);
        $this->entityManager->flush();
        return $dataObject;
    }

}
