<?php
namespace Order\Service;

use Base\DataObject\Draft;
use Base\DataObject\User;
use Order\Mapper\DraftMapperInterface;

class DraftService extends AbstractService implements DraftServiceInterface
{

    /** @var DraftMapperInterface */
    protected $mapper;

    /**
     * DraftService constructor.
     *
     * @param DraftMapperInterface $mapper
     */
    public function __construct(DraftMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param User $user
     * @return Draft
     */
    public function findOneByUser(User $user)
    {
        return $this->mapper->findOneByUser($user);
    }

    /**
     * Currently the user may have only one draft.
     * That's why on saving the check is run, whether the user already has a draft.
     * If so, the draft (or actually all user's drafts) will be removed
     * and replaced by the new one.
     *
     * @param Draft $draft
     * @return Draft
     */
    public function save(Draft $draft)
    {
        if (! $draft->getId()) {
            $this->mapper->removeAllByUser($draft->getUser());
        }
        return $this->mapper->save($draft);
    }

}
