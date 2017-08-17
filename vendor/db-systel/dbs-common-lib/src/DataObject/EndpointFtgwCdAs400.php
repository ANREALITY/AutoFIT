<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwCdAs400
 */
class EndpointFtgwCdAs400 extends AbstractEndpoint
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
     * @return EndpointFtgwCdAs400
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
     * @return EndpointFtgwCdAs400
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
