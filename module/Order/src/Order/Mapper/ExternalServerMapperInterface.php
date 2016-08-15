<?php
namespace Order\Mapper;

use DbSystel\DataObject\ExternalServer;

interface ExternalServerMapperInterface
{

    /**
     *
     * @param int|string $name
     * @return ExternalServer
     * @throws \InvalidArgumentException
     */
    public function findOne($name);

    /**
     *
     * @return array|ExternalServer[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param ExternalServer $dataObject
     * @return ExternalServer
     * @throws \Exception
     */
    public function save(ExternalServer $dataObject);

    /**
     *
     * @param int $endpointId
     * @throws \Exception
     */
    public function deleteOneByEndpointId(int $endpointId);

}
