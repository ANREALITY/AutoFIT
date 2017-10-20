<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * IncludeParameterSet
 *
 * @ORM\Table(name="include_parameter_set")
 * @ORM\Entity
 */
class IncludeParameterSet extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var AbstractEndpoint
     */
    protected $endpoint;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="IncludeParameter", mappedBy="includeParameterSet", orphanRemoval=true)
     *
     * @Groups({"export"})
     */
    protected $includeParameters;

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
    public function setIncludeParameters($includeParameters)
    {
        $this->removeIncludeParametersNotInList($includeParameters);
        $this->includeParameters = new ArrayCollection([]);
        /** @var IncludeParameter $includeParameter */
        foreach ($includeParameters as $includeParameter) {
            $this->addIncludeParameter($includeParameter);
        }
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
        $includeParameter->setIncludeParameterSet(null);
        return $this;
    }

    /**
     * @param $includeParameters
     * @return void
     */
    private function removeIncludeParametersNotInList($includeParameters)
    {
        if (is_array($includeParameters)) {
            $includeParameters = new ArrayCollection($includeParameters);
        }
        foreach ($this->getIncludeParameters() as $includeParameter) {
            if ($includeParameters->indexOf($includeParameter) === false) {
                $this->removeIncludeParameter($includeParameter);
            }
        }
    }

}
