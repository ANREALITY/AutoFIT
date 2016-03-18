<?php
namespace Order\Mapper;

use DbSystel\DataObject\BasicEndpoint;

interface BasicEndpointMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return BasicEndpoint
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|BasicEndpoint[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param BasicEndpoint $dataObject
     * @return BasicEndpoint
     * @throws \Exception
     */
    public function save(BasicEndpoint $dataObject);
}
