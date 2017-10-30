<?php
namespace Order\Mapper;

use DbSystel\DataObject\ProtocolSet;
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
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use DbSystel\DataObject\Protocol;

class ProtocolSetMapper extends AbstractMapper implements ProtocolSetMapperInterface
{

    /**
     *
     * @var ProtocolMapperInterface
     */
    protected $protocolMapper;

    /**
     *
     * @param ProtocolMapperInterface $protocolMapper
     */
    public function setProtocolMapper(ProtocolMapperInterface $protocolMapper)
    {
        $this->protocolMapper = $protocolMapper;
    }

}
