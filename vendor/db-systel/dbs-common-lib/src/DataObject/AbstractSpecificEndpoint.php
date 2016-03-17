<?php
namespace DbSystel\DataObject;

abstract class AbstractSpecificEndpoint
{

    /**
     *
     * @var BasicEndpoint
     */
    protected $basicEndpoint;

    /**
     *
     * @return the $basicEndpoint
     */
    public function getBasicEndpoint()
    {
        return $this->basicEndpoint;
    }

    /**
     *
     * @param \DbSystel\DataObject\BasicEndpoint $basicEndpoint            
     */
    public function setBasicEndpoint($basicEndpoint)
    {
        $this->basicEndpoint = $basicEndpoint;
    }
}
