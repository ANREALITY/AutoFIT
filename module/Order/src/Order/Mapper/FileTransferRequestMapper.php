<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Cluster;
use DbSystel\DataObject\EndpointCdLinuxUnix;
use DbSystel\DataObject\EndpointFtgwLinuxUnix;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\User;
use DbSystel\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;

class FileTransferRequestMapper extends AbstractMapper implements FileTransferRequestMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = FileTransferRequest::class;

    /**
     * @inheritdoc
     */
    public function findAllPaginated(array $criteria = [], $page = null, array $sorting = [])
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('ftr')->from(static::ENTITY_TYPE, 'ftr');

        foreach ($criteria as $key => $condition) {
            if ($key === 'user_id') {
                $queryBuilder
                    ->andWhere('ftr.user = :userId')
                    ->setParameter('userId', $condition)
                ;
            }
            if ($key === 'username' && $condition) {
                $queryBuilder
                    ->join('ftr.user', 'u')
                    ->andWhere('u.username = :username')
                    ->setParameter('username', $condition)
                ;
            }
            if ($key === 'change_number' && $condition) {
                $queryBuilder
                    ->andWhere('ftr.changeNumber LIKE :changeNumber')
                    ->setParameter('changeNumber', '%' . $condition . '%')
                ;
            }
            if ($key === 'application_technical_short_name' && $condition) {
                $queryBuilder
                    // JOINing of the serviceInvoicePositionPersonal would also be possible.
                    ->join('ftr.serviceInvoicePositionBasic', 'sip')
                    ->join('sip.serviceInvoice', 'si')
                    ->join('si.application', 'a')
                    ->where('a.technicalShortName = :technicalShortName')
                    ->setParameter('technicalShortName', $condition)
                ;
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

        foreach ($criteria as $key => $condition) {
            if ($key === 'change_number') {
                $queryBuilder
                    ->where('ftr.changeNumber LIKE :changeNumber')
                    ->setParameter('changeNumber', '%' . $condition . '%')
                ;
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

        $this->prepareEndpointApplications($endpointSource, $endpointTarget);
        $this->prepareEndpointExternalServers($endpointSource, $endpointTarget);
        $this->prepareEndpointEndpointServerConfigs($endpointSource, $endpointTarget);
        $this->prepareEndpointEndpointClusterConfigs($endpointSource, $endpointTarget);
    }

    private function prepareEndpointApplications(AbstractEndpoint $endpointSource, AbstractEndpoint $endpointTarget)
    {
        $endpointSourceApplication = $endpointSource->getApplication()
            ? $this->entityManager->getRepository(Application::class)->find(
                $endpointSource->getApplication()->getTechnicalShortName()
            )
            : null
        ;
        if ($endpointSourceApplication) {
            $endpointSource->setApplication($endpointSourceApplication);
        } else {
            $endpointSource->setApplication(null);
        }
        $endpointTargetApplication = $endpointTarget->getApplication()
            ? $this->entityManager->getRepository(Application::class)->find(
                $endpointTarget->getApplication()->getTechnicalShortName()
            )
            : null
        ;
        $endpointTarget->setApplication($endpointTargetApplication);
    }

    private function prepareEndpointExternalServers(AbstractEndpoint $endpointSource, AbstractEndpoint $endpointTarget)
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

    private function prepareEndpointEndpointServerConfigs(AbstractEndpoint $endpointSource, AbstractEndpoint $endpointTarget)
    {
        $endpointSourceServer = $endpointSource->getEndpointServerConfig()->getServer();
        $newEndpointSourceServer = null;
        if ($endpointSourceServer) {
            // The detach(...) has to be made here. Otherwise Doctrine tries to INSERT.
            // Exception: "A new entity was found through the relationship..."
            $this->entityManager->detach($endpointSourceServer);
            $newEndpointSourceServer = $this->entityManager->getRepository(Server::class)->find(
                $endpointSourceServer->getName()
            );
        }
        $endpointSource->getEndpointServerConfig()->setServer($newEndpointSourceServer);
        $endpointTargetServer = $endpointTarget->getEndpointServerConfig()->getServer();
        $newEndpointTargetServer = null;
        if ($endpointTargetServer) {
            // The detach(...) has to be made here. Otherwise Doctrine tries to INSERT.
            // Exception: "A new entity was found through the relationship..."
            $this->entityManager->detach($endpointTargetServer);
            $newEndpointTargetServer = $this->entityManager->getRepository(Server::class)->find(
                $endpointTargetServer->getName()
            );
        }
        $endpointTarget->getEndpointServerConfig()->setServer($newEndpointTargetServer);
    }

    private function prepareEndpointEndpointClusterConfigs(AbstractEndpoint $endpointSource, AbstractEndpoint $endpointTarget)
    {
        if ($endpointSource instanceof EndpointCdLinuxUnix || $endpointSource instanceof EndpointFtgwLinuxUnix) {
            /** @var EndpointCdLinuxUnix|EndpointFtgwLinuxUnix $endpointSource */
            $endpointSourceCluster = $endpointSource->getEndpointClusterConfig()->getCluster();
            $newEndpointSourceCluster = null;
            if ($endpointSourceCluster) {
                // The detach(...) has to be made here. Otherwise Doctrine tries to INSERT.
                // Exception: "A new entity was found through the relationship..."
                $this->entityManager->detach($endpointSourceCluster);
                $newEndpointSourceCluster = $this->entityManager->getRepository(Cluster::class)->find(
                    $endpointSource->getEndpointClusterConfig()->getCluster()->getId()
                );
            }
            $endpointSource->getEndpointClusterConfig()->setCluster($newEndpointSourceCluster);
        }
        if ($endpointTarget instanceof EndpointCdLinuxUnix || $endpointTarget instanceof EndpointFtgwLinuxUnix) {
            /** @var EndpointCdLinuxUnix|EndpointFtgwLinuxUnix $endpointTarget */
            $endpointTargetCluster = $endpointTarget->getEndpointClusterConfig()->getCluster();
            $newEndpointTargetCluster = null;
            if ($endpointTargetCluster) {
                // The detach(...) has to be made here. Otherwise Doctrine tries to INSERT.
                // Exception: "A new entity was found through the relationship..."
                $this->entityManager->detach($endpointTargetCluster);
                $newEndpointTargetCluster = $this->entityManager->getRepository(Cluster::class)->find(
                    $endpointTarget->getEndpointClusterConfig()->getCluster()->getId()
                );
            }
            $endpointTarget->getEndpointClusterConfig()->setCluster($newEndpointTargetCluster);
        }
    }

}
