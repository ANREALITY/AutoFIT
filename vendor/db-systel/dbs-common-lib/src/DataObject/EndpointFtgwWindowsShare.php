<?php
namespace DbSystel\DataObject;

class EndpointFtgwWindowsShare extends AbstractEndpoint
{

    /**
     *
     * @var string
     */
    protected $sharename;

    /**
     *
     * @var string
     */
    protected $folder;

    /**
     *
     * @var IncludeParameterSet
     */
    protected $includeParameterSet;

    /**
     *
     * @var AccessConfigSet
     */
    protected $accessConfigSet;

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
     * @param string $sharename
     */
    public function setSharename($sharename)
    {
        $this->sharename = $sharename;
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
     * @param string $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
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
     * @param IncludeParameterSet $includeParameterSet
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;
    }

    /**
     *
     * @return AccessConfigSet $accessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

    /**
     *
     * @param AccessConfigSet $accessConfigSet
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet)
    {
        $this->accessConfigSet = $accessConfigSet;
    }

}
