<?php
namespace DbSystel\DataObject;

/**
 * EndpointFtgwCdTandem
 */
class EndpointFtgwCdTandem extends AbstractEndpoint
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
     * @return EndpointFtgwCdTandem
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
     * @return EndpointFtgwCdTandem
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
