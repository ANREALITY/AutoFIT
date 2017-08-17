<?php
namespace DbSystel\DataObject;

class ServiceInvoicePositionStatus extends AbstractDataObject
{

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

}