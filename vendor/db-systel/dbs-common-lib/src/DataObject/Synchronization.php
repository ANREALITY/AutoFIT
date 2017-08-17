<?php
namespace DbSystel\DataObject;

class Synchronization extends AbstractDataObject
{

    const TYPE_APPLICATION = 'application';

    const TYPE_BILLING = 'billing';

    const TYPE_SERVER = 'server';

    /**
     *
     * @var integer
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
     * @var integer
     */
    protected $lastSync;

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
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
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
     * @return boolean $inProgress
     */
    public function getInProgress()
    {
        return $this->inProgress;
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
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param number $lastSync
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;
    }

    /**
     *
     * @return integer $lastSync
     */
    public function getLastSync()
    {
        return $this->lastSync;
    }

}