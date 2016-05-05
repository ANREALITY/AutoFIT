<?php
namespace Order\Service;

use DbSystel\DataObject\ServiceInvoicePosition;

interface ServiceInvoicePositionServiceInterface
{
    /**
     *
     * @param int $id
     *            Identifier of the ServiceInvoicePosition that should be returned
     * @return ServiceInvoicePosition
     */
    public function findOne($id);

    /**
     *
     * @param string $number
     * @param string $applicationTechnicalShortName
     * @param integer $environmentSeverity
     */
    public function findAllBasicByNumberApplicationAndEnvironment(string $number, string $applicationTechnicalShortName,
        int $environmentSeverity);

    /**
     *
     * @param string $number
     * @param string $applicationTechnicalShortName
     * @param integer $environmentSeverity
     */
    public function findAllPersonalByNumberApplicationAndEnvironment(string $number,
        string $applicationTechnicalShortName, int $environmentSeverity);

    /**
     *
     * @param ServiceInvoicePosition $serviceInvoicePosition
     * @return ServiceInvoicePosition
     */
    public function saveOne(ServiceInvoicePosition $serviceInvoicePositionRequest);

}
