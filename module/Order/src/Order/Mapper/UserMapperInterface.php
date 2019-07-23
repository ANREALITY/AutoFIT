<?php
namespace Order\Mapper;

use Base\DataObject\User;

interface UserMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return User
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @param string $username
     * @return User
     * @throws \InvalidArgumentException
     */
    public function findOneByUsername(string $username);

    /**
     * @param array $criteria
     * @param int|null $limit
     * @param int|null $hydrationMode
     * @return array
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

    /**
     * @param User $dataObject
     * @return User
     */
    public function save(User $dataObject);

}
