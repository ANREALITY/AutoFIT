<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProtocolSet
 */
class ProtocolSet extends AbstractDataObject
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
     * @var Protocol[]
     */
    private $protocols;

    /**
     * @param integer $id
     *
     * @return ProtocolSet
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param AbstractEndpoint $endpoint
     *
     * @return ProtocolSet
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return AbstractEndpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param Protocol[] $protocols
     *
     * @return ProtocolSet
     */
    public function setProtocols(array $protocols)
    {
        $this->protocols = $protocols;

        return $this;
    }

    /**
     * @return Protocol[] $protocols
     */
    public function getProtocols()
    {
        return $this->protocols;
    }

}
