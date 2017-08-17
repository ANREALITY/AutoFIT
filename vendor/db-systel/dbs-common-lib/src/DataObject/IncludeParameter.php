<?php
namespace DbSystel\DataObject;

/**
 * IncludeParameter
 */
class IncludeParameter extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $expression;

    /**
     * @var IncludeParameterSet
     */
    private $includeParameterSet;

    /**
     * @param integer $id
     * @return IncludeParameter
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
     * @param string $expression
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
     * @return IncludeParameter
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;

        return $this;
    }

    /**
     * @return IncludeParameterSet $includeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }

}
