<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractEndpoint;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Expression;
use DbSystel\DataObject\EndpointCdAs400;
use DbSystel\DataObject\EndpointCdTandem;
use DbSystel\DataObject\EndpointFtgwWindows;
use DbSystel\DataObject\EndpointFtgwSelfService;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\EndpointCdLinuxUnix;
use DbSystel\DataObject\EndpointCdZos;
use DbSystel\DataObject\EndpointCdWindows;
use DbSystel\DataObject\EndpointCdWindowsShare;
use DbSystel\DataObject\Protocol;
use Zend\Db\Sql\Select;
use DbSystel\DataObject\IncludeParameterSet;
use DbSystel\DataObject\ProtocolSet;
use DbSystel\DataObject\FileParameterSet;
use DbSystel\DataObject\AccessConfigSet;
use DbSystel\DataObject\EndpointFtgwProtocolServer;
use DbSystel\DataObject\EndpointFtgwWindowsShare;
use DbSystel\DataObject\EndpointFtgwLinuxUnix;
use DbSystel\DataObject\EndpointFtgwCdZos;
use DbSystel\DataObject\EndpointFtgwCdTandem;
use DbSystel\DataObject\EndpointFtgwCdAs400;
use DbSystel\DataObject\ProtocolSetForSelfService;
use DbSystel\DataObject\ProtocolSetForProtocolServer;

class EndpointMapper extends AbstractMapper implements EndpointMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = EndpointMapper::class;

    /**
     *
     * @var ExternalServerMapperInterface
     */
    protected $externalServerMapper;

    /**
     *
     * @var CustomerMapperInterface
     */
    protected $customerMapper;

    /**
     *
     * @var IncludeParameterSetMapperInterface
     */
    protected $includeParameterSetMapper;

    /**
     *
     * @var ProtocolSetMapperInterface
     */
    protected $protocolSetMapper;

    /**
     *
     * @var FileParameterSetMapperInterface
     */
    protected $fileParameterSetMapper;

    /**
     *
     * @var AccessConfigSetMapperInterface
     */
    protected $accessConfigSetMapper;

    /**
     *
     * @var ProtocolMapperInterface
     */
    protected $protocolMapper;

    /**
     *
     * @var EndpointClusterConfigMapperInterface
     */
    protected $endpointClusterConfigMapper;

    /**
     *
     * @param EndpointServerConfigMapperInterface $endpointServerConfigMapper
     */
    public function setEndpointServerConfigMapper(EndpointServerConfigMapperInterface $endpointServerConfigMapper)
    {
        $this->endpointServerConfigMapper = $endpointServerConfigMapper;
    }

    /**
     *
     * @param ExternalServerMapperInterface $externalServerMapper
     */
    public function setExternalServerMapper(ExternalServerMapperInterface $externalServerMapper)
    {
        $this->externalServerMapper = $externalServerMapper;
    }

    /**
     *
     * @param CustomerMapperInterface $customerMapper
     */
    public function setCustomerMapper(CustomerMapperInterface $customerMapper)
    {
        $this->customerMapper = $customerMapper;
    }

    /**
     *
     * @param IncludeParameterSetMapperInterface $includeParameterSetMapper
     */
    public function setIncludeParameterSetMapper(IncludeParameterSetMapperInterface $includeParameterSetMapper)
    {
        $this->includeParameterSetMapper = $includeParameterSetMapper;
    }

    /**
     *
     * @param ProtocolSetMapperInterface $protocolSetMapper
     */
    public function setProtocolSetMapper(ProtocolSetMapperInterface $protocolSetMapper)
    {
        $this->protocolSetMapper = $protocolSetMapper;
    }

    /**
     *
     * @param FileParameterSetMapperInterface $fileParameterSetMapper
     */
    public function setFileParameterSetMapper(FileParameterSetMapperInterface $fileParameterSetMapper)
    {
        $this->fileParameterSetMapper = $fileParameterSetMapper;
    }

    /**
     * @param AccessConfigSetMapperInterface $accessConfigSetMapper
     */
    public function setAccessConfigSetMapper(AccessConfigSetMapperInterface $accessConfigSetMapper)
    {
        $this->accessConfigSetMapper = $accessConfigSetMapper;
    }

    /**
     *
     * @param ProtocolMapperInterface $protocolMapper
     */
    public function setProtocolMapper(ProtocolMapperInterface $protocolMapper)
    {
        $this->protocolMapper = $protocolMapper;
    }

    /**
     *
     * @param EndpointClusterConfigMapperInterface $endpointClusterConfigMapper
     */
    public function setEndpointClusterConfigMapper(EndpointClusterConfigMapperInterface $endpointClusterConfigMapper)
    {
        $this->endpointClusterConfigMapper = $endpointClusterConfigMapper;
    }

}
