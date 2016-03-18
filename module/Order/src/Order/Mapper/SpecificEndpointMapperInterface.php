<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractSpecificEndpoint;

interface SpecificEndpointMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return AbstractSpecificEndpoint
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|AbstractSpecificEndpoint[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param AbstractSpecificEndpoint $dataObject
     * @return AbstractSpecificEndpoint
     * @throws \Exception
     */
    public function save(AbstractSpecificEndpoint $dataObject);
}
