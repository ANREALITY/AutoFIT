<?php
namespace DbSystel\DataObject;

/**
 * EndpointCdWindowsShare
 */
class EndpointCdWindowsShare extends AbstractEndpoint
{

    const TRANSMISSION_TYPE_TXT = 'txt';

    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     * @var string
     */
    private $sharename;

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
     * @var AccessConfigSet
     */
    private $accessConfigSet;

    /**
     * @param string $sharename
     * @return EndpointCdWindowsShare
     */
    public function setSharename($sharename)
    {
        $this->sharename = $sharename;

        return $this;
    }

    /**
     * @return string
     */
    public function getSharename()
    {
        return $this->sharename;
    }

    /**
     * @param string $folder
     * @return EndpointCdWindowsShare
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
     * @return EndpointCdWindowsShare
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
     * @return EndpointCdWindowsShare
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

    /**
     * @param AccessConfigSet $accessConfigSet
     * @return EndpointCdWindowsShare
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet)
    {
        $this->accessConfigSet = $accessConfigSet;

        return $this;
    }

    /**
     * @return AccessConfigSet $accessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

}
