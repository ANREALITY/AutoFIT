<?php
namespace DbSystel\DataObject;

/**
 * Class EndpointCdZos
 *
 * @package DbSystel\DataObject
 */
class EndpointCdZos extends AbstractEndpoint
{

    /**
     *
     * @var string
     */
    private $username;

    /**
     *
     * @var FileParameterSet
     */
    private $fileParameterSet;

    /**
     *
     * @param string $username
     * @return EndpointCdZos
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
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
     * @return EndpointCdZos
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet)
    {
        $this->fileParameterSet = $fileParameterSet;

        return $this;
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
