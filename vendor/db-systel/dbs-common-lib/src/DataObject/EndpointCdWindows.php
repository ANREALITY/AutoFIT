<?php
namespace DbSystel\DataObject;

/**
 * EndpointCdWindows
 *
 * @package DbSystel\DataObject
 */
class EndpointCdWindows extends AbstractEndpoint
{

    const TRANSMISSION_TYPE_TXT = 'txt';

    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     * @var string
     */
    private $folder;

    /**
     * @var string
     */
    private $transmissionType;

    /**
     * @var IncludeParameterSet
     */
    private $includeParameterSet;

    /**
     * @param string $folder
     * @return EndpointCdWindows
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
     * @param string $transmissionType
     * @return EndpointCdWindows
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     * @return EndpointCdWindows
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
