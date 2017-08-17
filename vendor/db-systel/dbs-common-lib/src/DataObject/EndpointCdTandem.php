<?php
namespace DbSystel\DataObject;

/**
 * Class EndpointCdTandem
 *
 * @package DbSystel\DataObject
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
     * @return string $username
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
     * @return string $folder
     */
    public function getFolder()
    {
        return $this->folder;
    }

}
