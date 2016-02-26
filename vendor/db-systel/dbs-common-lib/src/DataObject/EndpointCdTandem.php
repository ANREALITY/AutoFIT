<?php
namespace DbSystel\DataObject;

class EndpointCdTandem extends Endpoint
{

    /**
     *
     * @var string
     */
    protected $user;

    /**
     *
     * @var string
     */
    protected $folder;

    /**
     *
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param string $user            
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     *
     * @return the $folder
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
}
