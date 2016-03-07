<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\EndpointCdTandem;

interface EndpointCdTandemMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return EndpointCdTandem
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|EndpointCdTandem[]
     */
    public function findAll();

    /**
     *
     * @param EndpointCdTandem $dataObject
     * @return EndpointCdTandem
     * @throws \Exception
     */
    public function save(EndpointCdTandem $dataObject);
}
