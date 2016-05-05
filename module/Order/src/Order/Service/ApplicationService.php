<?php
namespace Order\Service;

use Order\Mapper\ApplicationMapperInterface;
use DbSystel\DataObject\Application;

class ApplicationService implements ApplicationServiceInterface
{

    /**
     *
     * @var ApplicationMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param ApplicationMapperInterface $mapper
     */
    public function __construct(ApplicationMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAll()
    {
        return $this->mapper->findAll($criteria);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findApplication($id)
    {
        return $this->mapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveApplication(Application $application)
    {
        return $this->mapper->save($application);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllByTechnicalShortName(string $technicalShortName)
    {
        return $this->mapper->findAll(
            [
                [
                    'technical_short_name' => $technicalShortName
                ]
            ]);
    }

}
