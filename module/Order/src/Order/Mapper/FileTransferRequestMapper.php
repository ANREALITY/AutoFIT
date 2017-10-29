<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\User;
use DbSystel\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class FileTransferRequestMapper extends AbstractMapper implements FileTransferRequestMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = FileTransferRequest::class;

    /**
     *
     * @var LogicalConnectionMapperInterface
     */
    protected $logicalConnectionMapper;

    /**
     *
     * @var UserMapperInterface
     */
    protected $userMapper;

    /**
     *
     * @param LogicalConnectionMapperInterface $logicalConnectionMapper
     */
    public function setLogicalConnectionMapper(LogicalConnectionMapperInterface $logicalConnectionMapper)
    {
        $this->logicalConnectionMapper = $logicalConnectionMapper;
    }

    /**
     *
     * @param UserMapperInterface $userMapper
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     * @inheritdoc
     */
    public function findAllPaginated(array $criteria = [], $page = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('ftr')->from(static::ENTITY_TYPE, 'ftr');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('user_id', $condition)) {
                    $queryBuilder
                        ->andWhere('ftr.user = :userId')
                        ->setParameter('userId', $condition['user_id'])
                    ;
                }
                if (array_key_exists('change_number', $condition)) {
                    $queryBuilder
                        ->andWhere('ftr.changeNumber LIKE :changeNumber')
                        ->setParameter('changeNumber', '%' . $condition['change_number'] . '%')
                    ;
                }
            }
        }

        $query = $queryBuilder->getQuery();

        $paginator = new Paginator(new PaginatorAdapter(new ORMPaginator($query)));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($this->itemCountPerPage);

        return $paginator;
    }

    /**
     * @inheritdoc
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('ftr')->from(static::ENTITY_TYPE, 'ftr');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('change_number', $condition)) {
                    $queryBuilder
                        ->where('ftr.changeNumber LIKE :changeNumber')
                        ->setParameter('changeNumber', '%' . $condition['change_number'] . '%')
                    ;
                }
            }
        }

        $queryBuilder->setMaxResults($limit ?: null);

        $query = $queryBuilder->getQuery();
        $result = $query->execute(null, $hydrationMode);

        return $result;
    }

    public function save(FileTransferRequest $dataObject)
    {
        $this->persistOrder($dataObject);
        $this->persistEndpoints($dataObject);

        $this->entityManager->persist($dataObject);
        $this->entityManager->flush();

        return $dataObject;
    }

    private function persistOrder(FileTransferRequest $dataObject)
    {
        // saving service invoice positions
        $serviceInvoicePositionBasic = $this->entityManager->getRepository(ServiceInvoicePosition::class)->find(
            $dataObject->getServiceInvoicePositionBasic()->getNumber()
        );
        $serviceInvoicePositionPersonal = $this->entityManager->getRepository(ServiceInvoicePosition::class)->find(
            $dataObject->getServiceInvoicePositionPersonal()->getNumber()
        );
        $dataObject->setServiceInvoicePositionBasic($serviceInvoicePositionBasic);
        $dataObject->setServiceInvoicePositionPersonal($serviceInvoicePositionPersonal);
        // saving user
        $user = $this->entityManager->getRepository(User::class)->findOneBy(
            ['username' => $dataObject->getUser()->getUsername()]
        );
        if ($user) {
            $dataObject->setUser($user);
        } else {
            $this->entityManager->persist($dataObject->getUser());
        }
    }

    private function persistEndpoints(FileTransferRequest $dataObject)
    {
        $connectionType = $dataObject->getLogicalConnection()->getType();
        if ($connectionType == LogicalConnection::TYPE_CD) {
            $endpointSource = $dataObject->getLogicalConnection()->getPhysicalConnectionEndToEnd()->getEndpointSource();
            $endpointTarget = $dataObject->getLogicalConnection()->getPhysicalConnectionEndToEnd()->getEndpointTarget();
        } else {
            $endpointSource = $dataObject->getLogicalConnection()->getPhysicalConnectionEndToMiddle()->getEndpointSource();
            $endpointTarget = $dataObject->getLogicalConnection()->getPhysicalConnectionMiddleToEnd()->getEndpointTarget();
        }

        $this->prepareEndpointsApplications($endpointSource, $endpointTarget);
        $this->prepareEndpointsExternalServers($endpointSource, $endpointTarget);
        $this->prepareEndpointsEndpointServerConfigs($endpointSource, $endpointTarget);
    }

    private function prepareEndpointsApplications(AbstractEndpoint $endpointSource, AbstractEndpoint $endpointTarget)
    {
        $endpointSourceApplication = $this->entityManager->getRepository(Application::class)->find(
            $endpointSource->getApplication()->getTechnicalShortName()
        );
        if ($endpointSourceApplication) {
            $endpointSource->setApplication($endpointSourceApplication);
        } else {
            $endpointSource->setApplication(null);
        }
        $endpointTargetApplication = $this->entityManager->getRepository(Application::class)->find(
            $endpointTarget->getApplication()->getTechnicalShortName()
        );
        $endpointTarget->setApplication($endpointTargetApplication);
    }

    private function prepareEndpointsExternalServers(AbstractEndpoint $endpointSource, AbstractEndpoint $endpointTarget)
    {
        if(! $endpointSource->getExternalServer() || ! $endpointSource->getExternalServer()->getName()) {
            if ($endpointSource->getExternalServer()) {
                $this->entityManager->remove($endpointSource->getExternalServer());
            }
            $endpointSource->setExternalServer(null);
        }
        if(! $endpointTarget->getExternalServer() || ! $endpointTarget->getExternalServer()->getName()) {
            if ($endpointTarget->getExternalServer()) {
                $this->entityManager->remove($endpointTarget->getExternalServer());
            }
            $endpointTarget->setExternalServer(null);
        }
    }

    private function prepareEndpointsEndpointServerConfigs(AbstractEndpoint $endpointSource, AbstractEndpoint $endpointTarget)
    {
        $endpointSourceServer = $endpointSource->getEndpointServerConfig()->getServer();
        $newEndpointSourceServer = null;
        if ($endpointSourceServer) {
            $this->entityManager->detach($endpointSourceServer);
            $newEndpointSourceServer = $this->entityManager->getRepository(Server::class)->find(
                $endpointSourceServer->getName()
            );
        }
        $endpointSource->getEndpointServerConfig()->setServer($newEndpointSourceServer);
        $endpointTargetServer = $endpointTarget->getEndpointServerConfig()->getServer();
        $newEndpointTargetServer = null;
        if ($endpointTargetServer) {
            $this->entityManager->detach($endpointTargetServer);
            $newEndpointTargetServer = $this->entityManager->getRepository(Server::class)->find(
                $endpointTargetServer->getName()
            );
        }
        $endpointTarget->getEndpointServerConfig()->setServer($newEndpointTargetServer);
    }

    /**
     *
     * @param FileTransferRequest $dataObject
     *
     * @return FileTransferRequest
     * @throws \Exception
     */
    public function saveDataObject(FileTransferRequest $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['id'] = $dataObject->getId();
        $data['change_number'] = $dataObject->getChangeNumber();
        $data['service_invoice_position_basic_number'] = $dataObject->getServiceInvoicePositionBasic()->getNumber();
        $data['service_invoice_position_personal_number'] = $dataObject->getServiceInvoicePositionPersonal()->getNumber();
        if ($dataObject->getStatus()) {
            $data['status'] = $dataObject->getStatus();
        }
        $data['comment'] = $dataObject->getComment();
        // creating sub-objects
        // $newFoo = $this->fooMapper->save($dataObject->getFoo());
        $newLogicalConnection = $this->logicalConnectionMapper->save($dataObject->getLogicalConnection());
        $newUser = $this->userMapper->save($dataObject->getUser());
        // data from the recently persisted objects
        $data['logical_connection_id'] = $newLogicalConnection->getId();
        $data['user_id'] = $newUser->getId();

        $dataObject->setLogicalConnection($newLogicalConnection);
        $dataObject->setUser($newUser);

        if (! $data['id']) {
            $action = new Insert('file_transfer_request');
            unset($data['id']);
            $action->values($data);
        } else {
            $action = new Update('file_transfer_request');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            unset($data['change_number']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
