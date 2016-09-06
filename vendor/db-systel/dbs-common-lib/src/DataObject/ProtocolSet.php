<?php
namespace DbSystel\DataObject;

class ProtocolSet extends AbstractDataObject
{

    /**
     *
     * @var int
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
     * @return the $endpoint
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
     * @return the $protocols
     */
    public function getProtocols()
    {
        return $this->protocols;
    }

    /**
     *
     * @param multitype:Protocol $protocols
     */
    public function setProtocols(array $protocols)
    {
        $this->protocols = $protocols;
    }

}
