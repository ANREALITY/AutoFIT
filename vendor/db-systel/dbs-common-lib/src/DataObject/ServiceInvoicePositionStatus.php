<?php
namespace DbSystel\DataObject;

/**
 * ServiceInvoicePositionStatus
 *
 * @package DbSystel\DataObject
 */
class ServiceInvoicePositionStatus extends AbstractDataObject
{

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
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