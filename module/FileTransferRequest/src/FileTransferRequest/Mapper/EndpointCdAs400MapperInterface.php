<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\EndpointCdAs400;

interface EndpointCdAs400MapperInterface
{

    /**
     *
     * @param int|string $id
     * @return EndpointCdAs400
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|EndpointCdAs400[]
     */
    public function findAll();

    /**
     *
     * @param EndpointCdAs400 $dataObject
     * @return EndpointCdAs400
     * @throws \Exception
     */
    public function save(EndpointCdAs400 $dataObject);
}
