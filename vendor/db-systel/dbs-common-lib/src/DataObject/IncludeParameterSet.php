<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @var ArrayCollection
     */
    private $includeParameters;

    public function __construct()
    {
        $this->includeParameters = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return IncludeParameterSet
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
     * @return IncludeParameterSet
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
     * @param ArrayCollection $includeParameters
     *
     * @return IncludeParameterSet
     */
    public function setIncludeParameters(array $includeParameters)
    {
        $this->includeParameters = $includeParameters;

        return $this;
    }

    /**
     * @return ArrayCollection $includeParameters
     */
    public function getIncludeParameters()
    {
        return $this->includeParameters;
    }

    /**
     * @param IncludeParameter $includeParameter
     * @return IncludeParameterSet
     */
    public function addIncludeParameter(IncludeParameter $includeParameter)
    {
        $this->includeParameters->add($includeParameter);
        return $this;
    }

    /**
     * @param IncludeParameter $includeParameter
     * @return IncludeParameterSet
     */
    public function removeIncludeParameter(IncludeParameter $includeParameter)
    {
        $this->includeParameters->removeElement($includeParameter);
        return $this;
    }

}
