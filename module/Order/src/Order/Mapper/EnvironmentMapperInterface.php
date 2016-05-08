<?php
namespace Order\Mapper;

use DbSystel\DataObject\Environment;

interface EnvironmentMapperInterface
{

    /**
     *
     * @param int|string $severity
     * @return Environment
     * @throws \InvalidArgumentException
     */
    public function findOne($severity);

    /**
     *
     * @return array|Environment[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param Environment $dataObject
     * @return ServiceInvoicePosition
     * @throws \Exception
     */
    public function save(Environment $dataObject);

}
