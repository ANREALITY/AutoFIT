<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwCdZos
 */
class EndpointFtgwCdZos extends AbstractEndpoint
{

    /**
     * @var string
     */
    private $username;

    /**
     * @var FileParameterSet
     */
    private $fileParameterSet;

    /**
     * @param string $username
     * @return EndpointFtgwCdZos
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param FileParameterSet $fileParameterSet
     * @return EndpointFtgwCdZos
     */
    public function setFileParameterSet(FileParameterSet $fileParameterSet)
    {
        $this->fileParameterSet = $fileParameterSet;

        return $this;
    }

    /**
     * @return FileParameterSet $fileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }

}
