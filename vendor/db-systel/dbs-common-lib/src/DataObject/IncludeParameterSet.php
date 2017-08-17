<?php
namespace DbSystel\DataObject;

class IncludeParameterSet extends AbstractDataObject
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
     * @var IncludeParameter[]
     */
    protected $includeParameters;

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
     * @param multitype:IncludeParameter $includeParameters
     */
    public function setIncludeParameters(array $includeParameters)
    {
        $this->includeParameters = $includeParameters;
    }

    /**
     *
     * @return IncludeParameter[] $includeParameters
     */
    public function getIncludeParameters()
    {
        return $this->includeParameters;
    }

}
