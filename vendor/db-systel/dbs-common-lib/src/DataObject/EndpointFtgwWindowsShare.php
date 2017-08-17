<?php
namespace DbSystel\DataObject;

/**
 * Class EndpointFtgwWindowsShare
 *
 * @package DbSystel\DataObject
 */
class EndpointFtgwWindowsShare extends AbstractEndpoint
{

    /**
     *
     * @var string
     */
    private $sharename;

    /**
     *
     * @var string
     */
    private $folder;

    /**
     *
     * @var IncludeParameterSet
     */
    private $includeParameterSet;

    /**
     *
     * @var AccessConfigSet
     */
    private $accessConfigSet;

    /**
     *
     * @param string $sharename
     * @return EndpointFtgwWindowsShare
     */
    public function setSharename($sharename)
    {
        $this->sharename = $sharename;

        return $this;
    }

    /**
     *
     * @return string $sharename
     */
    public function getSharename()
    {
        return $this->sharename;
    }

    /**
     *
     * @param string $folder
     * @return EndpointFtgwWindowsShare
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
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
     * @param IncludeParameterSet $includeParameterSet
     * @return EndpointFtgwWindowsShare
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

    /**
     *
     * @param AccessConfigSet $accessConfigSet
     * @return EndpointFtgwWindowsShare
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet)
    {
        $this->accessConfigSet = $accessConfigSet;

        return $this;
    }

    /**
     *
     * @return AccessConfigSet $accessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

}
