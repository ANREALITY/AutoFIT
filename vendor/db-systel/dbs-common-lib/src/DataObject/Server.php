<?php
namespace DbSystel\DataObject;

class Server
{

    const PLACE_INTERNAL = 'internal';

    const PLACE_EXTERNAL = 'external';

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var ServerType
     */
    protected $serverType;

    /**
     *
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name            
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return the $serverType
     */
    public function getServerType()
    {
        return $this->serverType;
    }

    /**
     *
     * @param ServerType $serverType            
     */
    public function setServerType($serverType)
    {
        $this->serverType = $serverType;
    }

}