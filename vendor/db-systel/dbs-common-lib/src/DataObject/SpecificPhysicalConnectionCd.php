<?php
namespace DbSystel\DataObject;

class SpecificPhysicalConnectionCd extends AbstractSpecificPhysicalConnection
{

    /**
     *
     * @var boolean
     */
    protected $securePlus;

    /**
     *
     * @return the $securePlus
     */
    public function getSecurePlus()
    {
        return $this->securePlus;
    }

    /**
     *
     * @param boolean $securePlus            
     */
    public function setSecurePlus($securePlus)
    {
        $this->securePlus = $securePlus;
    }
}
