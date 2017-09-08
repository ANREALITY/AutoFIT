<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileTransferRequest;
use DbSystel\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use InvalidArgumentException;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class FileTransferRequestMapper extends AbstractMapper implements FileTransferRequestMapperInterface
{

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
     * @param $id
     * @return FileTransferRequest
     * @throws InvalidArgumentException
     */
    public function findOne($id)
    {
        $repository = $this->entityManager->getRepository(FileTransferRequest::class);
        $entity = $repository->find($id);
        if (! $entity) {
            throw new InvalidArgumentException("FileTransferRequest with given ID:{$id} not found.");
        }
        /** @var FileTransferRequest $entity */
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function findAll(array $criteria = [], $page = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('ftr')->from(FileTransferRequest::class, 'ftr');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('user_id', $condition)) {
                    $queryBuilder
                        ->where('ftr.user = :userId')
                        ->setParameter('userId', $condition['user_id'])
                    ;
                }
                if (array_key_exists('change_number', $condition)) {
                    $queryBuilder
                        ->where('ftr.changeNumber LIKE :changeNumber')
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
     *
     * @param FileTransferRequest $dataObject
     *
     * @return FileTransferRequest
     * @throws \Exception
     */
    public function save(FileTransferRequest $dataObject)
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
        $dataObject->setLogicalConnection($newLogicalConnection);
        $newUser = $this->userMapper->save($dataObject->getUser());
        $dataObject->setUser($newUser);
        // data from the recently persisted objects
        $data['logical_connection_id'] = $newLogicalConnection->getId();
        $data['user_id'] = $newUser->getId();

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
