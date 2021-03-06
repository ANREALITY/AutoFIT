<?php
namespace Order\Service;

use Base\DataObject\Draft;
use Base\DataObject\User;

interface DraftServiceInterface
{

    /**
     *
     * @param int $id
     * @return Draft
     */
    public function findOne($id);

    /**
     * @param User $user
     * @return Draft
     */
    public function findOneByUser(User $user);

    /**
     * @param Draft $draft
     * @return Draft
     */
    public function save(Draft $draft);

}
