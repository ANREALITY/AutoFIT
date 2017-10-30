<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgwMiddleToEnd;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\AbstractPhysicalConnection;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use DbSystel\DataObject\AbstractDataObject;
use DbSystel\DataObject\PhysicalConnectionCdEndToEnd;
use DbSystel\DataObject\PhysicalConnectionFtgwEndToMiddle;

class LogicalConnectionMapper extends AbstractMapper implements LogicalConnectionMapperInterface
{

    /**
     *
     * @var PhysicalConnectionMapperInterface
     */
    protected $physicalConnectionMapper;

    /**
     *
     * @var NotificationMapperInterface
     */
    protected $notificationMapper;

    /**
     *
     * @param PhysicalConnectionMapperInterface $physicalConnectionMapper
     */
    public function setPhysicalConnectionMapper(PhysicalConnectionMapperInterface $physicalConnectionMapper)
    {
        $this->physicalConnectionMapper = $physicalConnectionMapper;
    }

    /**
     *
     * @param NotificationMapperInterface $notificationMapper
     */
    public function setNotificationMapper(NotificationMapperInterface $notificationMapper)
    {
        $this->notificationMapper = $notificationMapper;
    }

}
