<?php
namespace DbSystel\DataObject;

/**
 * IncludeParameterSet
 */
class IncludeParameterSet extends AbstractDataObject
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
     * @var IncludeParameter[]
     */
    private $includeParameters;

    /**
     * @param integer $id
     * @return IncludeParameterSet
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
     * @return IncludeParameterSet
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
     * @param IncludeParameter[] $includeParameters
     * @return IncludeParameterSet
     */
    public function setIncludeParameters(array $includeParameters)
    {
        $this->includeParameters = $includeParameters;

        return $this;
    }

    /**
     * @return IncludeParameter[] $includeParameters
     */
    public function getIncludeParameters()
    {
        return $this->includeParameters;
    }

}
