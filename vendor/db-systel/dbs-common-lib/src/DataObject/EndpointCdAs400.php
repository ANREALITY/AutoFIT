<?php
namespace DbSystel\DataObject;

/**
 * Class EndpointCdAs400
 *
 * @package DbSystel\DataObject
 */
class EndpointCdAs400 extends AbstractEndpoint
{

    /**
     *
     * @var string
     */
    protected $username;

    /**
     *
     * @var string
     */
    protected $folder;

    /**
     *
     * @param string $username
     * @return EndpointCdAs400
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
     * @param string $folder
     * @return EndpointCdAs400
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

}
