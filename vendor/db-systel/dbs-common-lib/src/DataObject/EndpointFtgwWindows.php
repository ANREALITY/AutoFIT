<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwWindows
 */
class EndpointFtgwWindows extends AbstractEndpoint
{

    /**
     * @var string
     */
    private $folder;

    /**
     * @var IncludeParameterSet
     */
    private $includeParameterSet;

    /**
     * @param string $folder
     * @return EndpointFtgwWindows
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     * @return EndpointFtgwWindows
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
