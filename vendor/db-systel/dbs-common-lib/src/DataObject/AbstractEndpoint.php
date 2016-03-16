<?php
namespace DbSystel\DataObject;

abstract class AbstractEndpoint
{

    /**
     *
     * @var Endpoint
     */
    protected $endpoint;

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
     * @param Endpoint $endpoint            
     */
    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }
}
