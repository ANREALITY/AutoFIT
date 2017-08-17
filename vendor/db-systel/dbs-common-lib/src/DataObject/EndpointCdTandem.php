<?php
namespace DbSystel\DataObject;

/**
 * EndpointCdTandem
 */
class EndpointCdTandem extends AbstractEndpoint
{

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $folder;

    /**
     * @param string $username
     * @return EndpointCdTandem
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
     * @param string $folder
     * @return EndpointCdTandem
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

}
