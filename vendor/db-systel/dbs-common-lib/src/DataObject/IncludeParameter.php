<?php
namespace DbSystel\DataObject;

/**
 * Class IncludeParameter
 *
 * @package DbSystel\DataObject
 */
class IncludeParameter extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $expression;

    /**
     *
     * @var IncludeParameterSet
     */
    protected $includeParameterSet;

    /**
     *
     * @param integer $id
     * @return IncludeParameter
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @param string $expression
     * @return IncludeParameter
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     *
     * @return string $expression
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     *
     * @param IncludeParameterSet $includeParameterSet
     * @return IncludeParameter
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;

        return $this;
    }

    /**
     *
     * @return IncludeParameterSet $includeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }

}
