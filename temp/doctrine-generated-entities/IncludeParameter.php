<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncludeParameter
 *
 * @ORM\Table(name="include_parameter", indexes={@ORM\Index(name="fk_include_parameter_include_parameter_set_idx", columns={"include_parameter_set_id"})})
 * @ORM\Entity
 */
class IncludeParameter extends AbstractDataObject
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="expression", type="string", length=50, nullable=true)
     */
    private $expression;

    /**
     * @var IncludeParameterSet
     *
     * @ORM\ManyToOne(targetEntity="IncludeParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $includeParameterSet;



    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $expression
     *
     * @return IncludeParameter
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     *
     * @return IncludeParameter
     */
    public function setIncludeParameterSet(\IncludeParameterSet $includeParameterSet = null)
    {
        $this->includeParameterSet = $includeParameterSet;

        return $this;
    }

    /**
     * @return IncludeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }
}
