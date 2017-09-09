<?php
namespace Order\Service;

use Doctrine\ORM\Query;
use Order\Mapper\ServiceInvoicePositionMapperInterface;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\Article;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ProductType;

class ServiceInvoicePositionService extends AbstractService implements ServiceInvoicePositionServiceInterface
{

    /**
     *
     * @var ServiceInvoicePositionMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param ServiceInvoicePositionMapperInterface $mapper
     */
    public function __construct(ServiceInvoicePositionMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllBasicForAutocomplete(
        string $number,
        string $applicationTechnicalShortName,
        int $environmentSeverity,
        string $connectionType
    ) {
        return $this->mapper->findAll(
            [
                [
                    'number' => $number,
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'environment_severity' => $environmentSeverity,
                    'product_type_name' => $this->translateConnectionTypeToProductType($connectionType),
                    'article_type' => Article::TYPE_BASIC
                ]
            ],
            null,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllPersonalForAutocomplete(
        string $number,
        string $applicationTechnicalShortName,
        int $environmentSeverity,
        string $connectionType
    ) {
        return $this->mapper->findAll(
            [
                [
                    'number' => $number,
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'environment_severity' => $environmentSeverity,
                    'product_type_name' => $this->translateConnectionTypeToProductType($connectionType),
                    'article_type' => Article::TYPE_PERSONAL
                ]
            ],
            null,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     * @param string $number
     * @param string $applicationTechnicalShortName
     * @param int $environmentSeverity
     * @param string $connectionType
     * @param string $articleType
     * @return array|ServiceInvoicePosition[]
     */
    public function findValidForOrder(
        string $number,
        string $applicationTechnicalShortName,
        int $environmentSeverity,
        string $connectionType,
        string $articleType
    ) {
        return $this->mapper->findAll(
            [
                [
                    'number' => $number,
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'environment_severity' => $environmentSeverity,
                    'product_type_name' => $this->translateConnectionTypeToProductType($connectionType),
                    'article_type' => $articleType,
                    'active' => true,
                    'available' => true
                ]
            ]);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveOne(ServiceInvoicePosition $serviceInvoicePosition)
    {
        return $this->mapper->save($serviceInvoicePosition);
    }

    protected function translateConnectionTypeToProductType(string $connectionType)
    {
        $productType = null;
        if (strcasecmp($connectionType, LogicalConnection::TYPE_CD) === 0) {
            $productType = ProductType::NAME_CD;
        } elseif (strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0) {
            $productType = ProductType::NAME_FTGW;
        }
        return $productType;
    }

}
