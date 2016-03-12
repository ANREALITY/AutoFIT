<?php
namespace Order\Mapper;

use DbSystel\DataObject\User;

interface UserMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return User
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|User[]
     */
    public function findAll();

    /**
     *
     * @param User $dataObject
     * @return User
     * @throws \Exception
     */
    public function save(User $dataObject);
}
