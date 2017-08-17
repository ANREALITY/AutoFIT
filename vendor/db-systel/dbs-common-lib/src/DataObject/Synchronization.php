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
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

        return $this;
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

        return $this;
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
     * @param integer $lastSync
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;

        return $this;
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