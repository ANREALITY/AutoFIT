<?php
namespace DbSystel\DataObject;

class Synchronization extends AbstractDataObject
{

    const TYPE_APPLICATION = 'application';

    const TYPE_BILLING = 'billing';

    const TYPE_SERVER = 'server';

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var boolean
     */
    protected $inProgress;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var int
     */
    protected $lastSync;

    /**
     *
     * @return int $id
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
     * @return boolean $inProgress
     */
    public function getInProgress()
    {
        return $this->inProgress;
    }

    /**
     *
     * @param boolean $inProgress
     */
    public function setInProgress($inProgress)
    {
        $this->inProgress = $inProgress;
    }

    /**
     *
     * @return string $type
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
     * @return int $lastSync
     */
    public function getLastSync()
    {
        return $this->lastSync;
    }

    /**
     *
     * @param number $lastSync
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;
    }

}