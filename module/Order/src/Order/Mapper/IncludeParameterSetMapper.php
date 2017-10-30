<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameterSet;
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

class IncludeParameterSetMapper extends AbstractMapper implements IncludeParameterSetMapperInterface
{

    /**
     *
     * @var IncludeParameterMapperInterface
     */
    protected $includeParameterMapper;

    /**
     *
     * @param IncludeParameterMapperInterface $includeParameterMapper
     */
    public function setIncludeParameterMapper(IncludeParameterMapperInterface $includeParameterMapper)
    {
        $this->includeParameterMapper = $includeParameterMapper;
    }

}
