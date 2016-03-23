<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;

class LogicalConnectionCdMapper extends AbstractLogicalConnectionMapper
{

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, LogicalConnection $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);

        $this->type = LogicalConnection::TYPE_CD;
    }

}
