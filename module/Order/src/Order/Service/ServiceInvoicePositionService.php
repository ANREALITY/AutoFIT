<?php
namespace Order\Service;

use Order\Mapper\ServiceInvoicePositionMapperInterface;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\Article;

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
    public function findAllBasicForAutocomplete(string $number, string $applicationTechnicalShortName,
        int $environmentSeverity)
    {
        return $this->mapper->findAll(
            [
                [
                    'number' => $number,
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'environment_severity' => $environmentSeverity,
                    'article_type' => Article::TYPE_BASIC,
                    'active' => true
                ]
            ]);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllPersonalForAutocomplete(string $number, string $applicationTechnicalShortName,
        int $environmentSeverity)
    {
        return $this->mapper->findAll(
            [
                [
                    'number' => $number,
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'environment_severity' => $environmentSeverity,
                    'article_type' => Article::TYPE_PERSONAL,
                    'active' => true
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

}
