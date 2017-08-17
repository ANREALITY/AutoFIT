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
     * @param number $id
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
     * @param AbstractEndpoint $endpoint
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
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
     * @param multitype:AccessConfig $accessConfigs
     */
    public function setAccessConfigs(array $accessConfigs)
    {
        $this->accessConfigs = $accessConfigs;

        return $this;
    }

    /**
     *
     * @return AccessConfig[] $accessConfigs
     */
    public function getAccessConfigs()
    {
        return $this->accessConfigs;
    }

}
