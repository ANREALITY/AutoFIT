<?php
namespace DbSystel\DataObject;

class EndpointCdZos extends AbstractEndpoint
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
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param FileParameterSet $fileParameterSet
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet)
    {
        $this->fileParameterSet = $fileParameterSet;
    }

    /**
     *
     * @return FileParameterSet $fileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }

}
