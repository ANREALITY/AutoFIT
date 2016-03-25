<?php
namespace Order\Service;

use DbSystel\DataObject\ServiceInvoicePosition;

interface ServiceInvoicePositionServiceInterface
{

    /**
     *
     * @return array|ServiceInvoicePosition[]
     */
    public function findAll();

    /**
     *
     * @param int $id
     *            Identifier of the ServiceInvoicePosition that should be returned
     * @return ServiceInvoicePosition
     */
    public function findServiceInvoicePosition($id);

    /**
     *
     * @param ServiceInvoicePosition $serviceInvoicePosition
     * @return ServiceInvoicePosition
     */
    public function saveServiceInvoicePosition(ServiceInvoicePosition $serviceInvoicePositionRequest);

    /**
     *
     * @param string $name
     */
    public function findAllByNumber(string $name);

}
