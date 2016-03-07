<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\Endpoint;

interface EndpointMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return Endpoint
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|Endpoint[]
     */
    public function findAll();

    /**
     *
     * @param Endpoint $dataObject
     * @return Endpoint
     * @throws \Exception
     */
    public function save(Endpoint $dataObject);
}
