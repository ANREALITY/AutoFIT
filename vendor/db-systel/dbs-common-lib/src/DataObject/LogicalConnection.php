<?php
namespace DbSystel\DataObject;

class LogicalConnection
{

    const TYPE_CD = 'CD';

    const TYPE_FTGW = 'FTGW';

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var AbstractPhysicalConnection[] @relationshipInversion
     */
    protected $physicalConnections;

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @return the $physicalConnections
     */
    public function getPhysicalConnections()
    {
        return $this->physicalConnections;
    }

    /**
     *
     * @param AbstractPhysicalConnection[] $physicalConnections
     */
    public function setPhysicalConnections(array $physicalConnections)
    {
        $this->physicalConnections = $physicalConnections;
    }
}
