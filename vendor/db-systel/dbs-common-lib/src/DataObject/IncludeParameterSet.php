<?php
namespace DbSystel\DataObject;

class IncludeParameterSet
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
     * @var IncludeParameter[]
     */
    protected $includeParameters;

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
     * @return the $includeParameters
     */
    public function getIncludeParameters()
    {
        return $this->includeParameters;
    }

    /**
     *
     * @param multitype:IncludeParameter $includeParameters            
     */
    public function setIncludeParameters(array $includeParameters)
    {
        $this->includeParameters = $includeParameters;
    }

}
