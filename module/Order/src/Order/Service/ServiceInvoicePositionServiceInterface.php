<?php
namespace Order\Service;

use Base\DataObject\AbstractServiceInvoicePosition;

interface ServiceInvoicePositionServiceInterface
{

    /**
     *
     * @param int $id
     *            Identifier of the ServiceInvoicePosition that should be returned
     * @return AbstractServiceInvoicePosition
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
     * @param string $number
     * @param string $applicationTechnicalShortName
     * @param integer $environmentSeverity
     * @param string $connectionType
     */
    public function findValidForOrder(
        string $number,
        string $applicationTechnicalShortName,
        int $environmentSeverity,
        string $connectionType,
        string $articleType
    );

    /**
     *
     * @param AbstractServiceInvoicePosition $serviceInvoicePosition
     * @return AbstractServiceInvoicePosition
     */
    public function saveOne(AbstractServiceInvoicePosition $serviceInvoicePositionRequest);

}
