<?php
namespace DbSystel\DataObject;

class EndpointCdWindows extends AbstractEndpoint
{

    const TRANSMISSION_TYPE_TXT = 'txt';

    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     *
     * @var string
     */
    protected $folder;

    /**
     *
     * @var string
     */
    protected $transmissionType;

    /**
     *
     * @var IncludeParameterSet
     */
    protected $includeParameterSet;

    /**
     *
     * @param string $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     *
     * @return string $folder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     *
     * @param string $transmissionType
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;
    }

    /**
     *
     * @return string $transmissionType
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     *
     * @param IncludeParameterSet $includeParameterSet
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;
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
