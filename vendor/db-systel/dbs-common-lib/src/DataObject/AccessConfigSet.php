<?php
namespace DbSystel\DataObject;

class AccessConfigSet extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var AbstractEndpoint
     */
    protected $endpoint;

    /**
     *
     * @var AccessConfig[]
     */
    protected $accessConfigs;

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
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return AbstractEndpoint $endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     *
     * @param AbstractEndpoint $endpoint
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     *
     * @return AccessConfig[] $accessConfigs
     */
    public function getAccessConfigs()
    {
        return $this->accessConfigs;
    }

    /**
     *
     * @param multitype:AccessConfig $accessConfigs
     */
    public function setAccessConfigs(array $accessConfigs)
    {
        $this->accessConfigs = $accessConfigs;
    }

}
