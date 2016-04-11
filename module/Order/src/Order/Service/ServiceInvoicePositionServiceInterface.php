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
     * @param string $number
     * @param string $applicationTechnicalShortName
     * @param integer $environmentSeverity
     */
    public function findAllBasicByNumberApplicationAndEnvironment(string $number, string $applicationTechnicalShortName, int $environmentSeverity);

    /**
     *
     * @param string $number
     * @param string $applicationTechnicalShortName
     * @param integer $environmentSeverity
     */
    public function findAllPersonalByNumberApplicationAndEnvironment(string $number, string $applicationTechnicalShortName, int $environmentSeverity);

}
