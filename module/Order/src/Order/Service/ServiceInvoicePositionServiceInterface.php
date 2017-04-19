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
     * @param string $connectionType
     */
    public function findAllBasicForAutocomplete(string $number, string $applicationTechnicalShortName,
        int $environmentSeverity, string $connectionType);

    /**
     *
     * @param string $number
     * @param string $applicationTechnicalShortName
     * @param integer $environmentSeverity
     * @param string $connectionType
     */
    public function findAllPersonalForAutocomplete(string $number,
        string $applicationTechnicalShortName, int $environmentSeverity, string $connectionType);

    /**
     *
     * @param ServiceInvoicePosition $serviceInvoicePosition
     * @return ServiceInvoicePosition
     */
    public function saveOne(ServiceInvoicePosition $serviceInvoicePositionRequest);

}
