<?php
namespace Order\Mapper;

use DbSystel\DataObject\Draft;
use DbSystel\DataObject\User;

interface DraftMapperInterface
{

    /**
     *
     * @param User $user
     * @return Draft
     */
    public function findOneByUser(User $user);

    /**
     *
     * @param Draft $dataObject
     * @return Draft
     * @throws \Exception
     */
    public function save(Draft $dataObject);

    /**
     * @param User $user
     * @return void
     */
    public function removeAllByUser(User $user);

}
