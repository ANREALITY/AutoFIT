<?php
namespace DbSystel\DataObject;

/**
 * Class ProtocolSet
 *
 * @package DbSystel\DataObject
 */
class ProtocolSet extends AbstractDataObject
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
     * @var Protocol[]
     */
    protected $protocols;

    /**
     *
     * @param integer $id
     * @return ProtocolSet
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
     * @return ProtocolSet
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
     * @param Protocol[] $protocols
     * @return ProtocolSet
     */
    public function setProtocols(array $protocols)
    {
        $this->protocols = $protocols;

        return $this;
    }

    /**
     *
     * @return Protocol[] $protocols
     */
    public function getProtocols()
    {
        return $this->protocols;
    }

}
