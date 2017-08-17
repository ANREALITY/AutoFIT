<?php
namespace DbSystel\DataObject;

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
     * @param multitype:Protocol $protocols
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
