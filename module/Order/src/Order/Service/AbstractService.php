<?php
namespace Order\Service;

use Order\Mapper\AbstractMapper;

class AbstractService
{

    /**
     *
     * @var AbstractMapper
     */
    protected $mapper;

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findOne($id)
    {
        return $this->mapper->find($id);
    }

}
