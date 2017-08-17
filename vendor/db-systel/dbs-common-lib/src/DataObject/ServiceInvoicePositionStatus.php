<?php
namespace DbSystel\DataObject;

/**
 * Class ServiceInvoicePositionStatus
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
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

}