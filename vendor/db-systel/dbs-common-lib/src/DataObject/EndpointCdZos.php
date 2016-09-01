<?php
namespace DbSystel\DataObject;

class EndpointCdWindowsZos extends AbstractEndpoint
{

    /**
     *
     * @var string
     */
    protected $username;

    /**
     *
     * @var FileParameterSet
     */
    protected $fileParameterSet;

    /**
     *
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *
     * @return the $fileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }

    /**
     *
     * @param FileParameterSet $fileParameterSet
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet)
    {
        $this->fileParameterSet = $fileParameterSet;
    }

}
