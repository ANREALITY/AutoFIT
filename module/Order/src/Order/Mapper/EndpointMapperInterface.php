<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractEndpoint;

interface EndpointMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return AbstractEndpoint
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|AbstractEndpoint[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param AbstractEndpoint $dataObject
     * @return AbstractEndpoint
     * @throws \Exception
     */
    public function save(AbstractEndpoint $dataObject);
}
