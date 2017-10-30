<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgwEndToMiddle;
use DbSystel\DataObject\PhysicalConnectionCdEndToEnd;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\AbstractEndpoint;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use DbSystel\DataObject\EndpointCdAs400;
use DbSystel\DataObject\EndpointCdTandem;
use DbSystel\DataObject\EndpointCdLinuxUnix;
use DbSystel\DataObject\EndpointFtgwSelfService;
use DbSystel\DataObject\EndpointFtgwWindows;
use DbSystel\DataObject\EndpointCdWindows;
use DbSystel\DataObject\EndpointCdZos;
use DbSystel\DataObject\EndpointCdWindowsShare;
use DbSystel\DataObject\EndpointFtgwProtocolServer;
use DbSystel\DataObject\EndpointFtgwWindowsShare;
use DbSystel\DataObject\EndpointFtgwLinuxUnix;
use DbSystel\DataObject\EndpointFtgwCdZos;
use DbSystel\DataObject\EndpointFtgwCdTandem;
use DbSystel\DataObject\EndpointFtgwCdAs400;

class PhysicalConnectionMapper extends AbstractMapper implements PhysicalConnectionMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = PhysicalConnectionMapper::class;

    /**
     *
     * @param EndpointMapperInterface $endpointMapper
     */
    public function setEndpointMapper(EndpointMapperInterface $endpointMapper)
    {
        $this->endpointMapper = $endpointMapper;
    }

}
