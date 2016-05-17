<?php
namespace Order\Service;

use DbSystel\DataObject\User;

interface UserServiceInterface
{

    /**
     *
     * @param string $username
     *            Identifier of the User that should be returned
     * @return User
     */
    public function findOneByUsername(string $username);

}
