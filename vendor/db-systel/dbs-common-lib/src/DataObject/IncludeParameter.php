<?php
namespace DbSystel\DataObject;

class IncludeParameter
{

    /**
     *
     * @var int
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
    protected $ncludeParameterSet;

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
     * @return the $expression
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     *
     * @param string $expression
     */
    public function setExpression(string $expression)
    {
        $this->expression = $expression;
    }

    /**
     *
     * @return the $ncludeParameterSet
     */
    public function getNcludeParameterSet()
    {
        return $this->ncludeParameterSet;
    }

    /**
     *
     * @param IncludeParameterSet $ncludeParameterSet
     */
    public function setNcludeParameterSet(IncludeParameterSet $ncludeParameterSet)
    {
        $this->ncludeParameterSet = $ncludeParameterSet;
    }

}
