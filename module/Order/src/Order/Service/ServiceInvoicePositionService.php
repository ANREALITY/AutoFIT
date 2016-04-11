<?php
namespace Order\Service;

use Order\Mapper\ServiceInvoicePositionMapperInterface;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\Article;

class ServiceInvoicePositionService implements ServiceInvoicePositionServiceInterface
{

    /**
     *
     * @var ServiceInvoicePositionMapperInterface
     */
    protected $serviceInvoicePositionMapper;

    /**
     *
     * @param ServiceInvoicePositionMapperInterface $serviceInvoicePositionMapper
     */
    public function __construct(ServiceInvoicePositionMapperInterface $serviceInvoicePositionMapper)
    {
        $this->serviceInvoicePositionMapper = $serviceInvoicePositionMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAll()
    {
        return $this->serviceInvoicePositionMapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findServiceInvoicePosition($id)
    {
        return $this->serviceInvoicePositionMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveServiceInvoicePosition(ServiceInvoicePosition $serviceInvoicePosition)
    {
        return $this->serviceInvoicePositionMapper->save($serviceInvoicePosition);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllBasicByNumberApplicationAndEnvironment(string $number, string $applicationTechnicalShortName, int $environmentSeverity)
    {
        return $this->serviceInvoicePositionMapper->findAll(
            [
                [
                    'number' => $number,
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'environment_severity' => $environmentSeverity,
                    'article_type' => Article::TYPE_BASIC
                ]
            ]);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllPersonalByNumberApplicationAndEnvironment(string $number, string $applicationTechnicalShortName, int $environmentSeverity)
    {
        return $this->serviceInvoicePositionMapper->findAll(
            [
                [
                    'number' => $number,
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'environment_severity' => $environmentSeverity,
                    'article_type' => Article::TYPE_PERSONAL
                ]
            ]);
    }

}
