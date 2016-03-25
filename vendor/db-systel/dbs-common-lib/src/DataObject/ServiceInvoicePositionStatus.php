<?php
namespace DbSystel\DataObject;

class ServiceInvoicePositionStatus
{

    /**
     *
     * @var string
     */
    protected $name;

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

}