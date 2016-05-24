<?php
namespace Order\Mapper;

use DbSystel\DataObject\Protocol;

interface ProtocolMapperInterface
{

    /**
     *
     * @param int|string $name
     * @return Protocol
     * @throws \InvalidArgumentException
     */
    public function findOne($name);

    /**
     *
     * @return array|Protocol[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param Protocol $dataObject
     * @return Protocol
     * @throws \Exception
     */
    public function save(Protocol $dataObject);

}
