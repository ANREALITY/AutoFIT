<?php
namespace DbSystel\DataObject;

/**
 * Class AccessConfigSet
 *
 * @package DbSystel\DataObject
 */
class AccessConfigSet extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var AbstractEndpoint
     */
    private $endpoint;

    /**
     * @var AccessConfig[]
     */
    private $accessConfigs;

    /**
     * @param integer $id
     * @return AccessConfigSet
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param AbstractEndpoint $endpoint
     * @return AccessConfigSet
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return AbstractEndpoint $endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param AccessConfig[] $accessConfigs
     * @return AccessConfigSet
     */
    public function setAccessConfigs(array $accessConfigs)
    {
        $this->accessConfigs = $accessConfigs;

        return $this;
    }

    /**
     * @return AccessConfig[] $accessConfigs
     */
    public function getAccessConfigs()
    {
        return $this->accessConfigs;
    }

}
