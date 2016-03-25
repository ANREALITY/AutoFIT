<?php
namespace Order\Service;

use Order\Mapper\ServiceInvoicePositionMapperInterface;
use DbSystel\DataObject\ServiceInvoicePosition;

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
    public function findAllByNumber(string $number)
    {
        return $this->serviceInvoicePositionMapper->findAll(
            [
                [
                    'number' => $number
                ]
            ]);
    }

}
