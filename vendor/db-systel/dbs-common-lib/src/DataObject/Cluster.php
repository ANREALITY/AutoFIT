<?php
namespace DbSystel\DataObject;

class Cluster
{

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $address;

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

}