<?php
namespace DbSystel\DataObject;

class Server
{

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
     * @param \DbSystel\DataObject\ServerType $serverType            
     */
    public function setServerType($serverType)
    {
        $this->serverType = $serverType;
    }
}