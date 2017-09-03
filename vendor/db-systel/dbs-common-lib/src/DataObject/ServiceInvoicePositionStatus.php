<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceInvoicePositionStatus
 */
class ServiceInvoicePositionStatus extends AbstractDataObject
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     *
     * @return ServiceInvoicePositionStatus
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}