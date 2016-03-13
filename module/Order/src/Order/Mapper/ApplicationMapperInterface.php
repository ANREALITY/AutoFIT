<?php
namespace Order\Mapper;

use DbSystel\DataObject\Application;

interface ApplicationMapperInterface
{

    /**
     *
     * @param int|string $technicalShortName
     * @return Application
     * @throws \InvalidArgumentException
     */
    public function find($technicalShortName);

    /**
     *
     * @return array|Application[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param Application $dataObject
     * @return ServiceInvoicePosition
     * @throws \Exception
     */
    public function save(Application $dataObject);
}
