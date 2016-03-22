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
    protected $applicationMapper;

    /**
     *
     * @param ApplicationMapperInterface $applicationMapper            
     */
    public function __construct(ApplicationMapperInterface $applicationMapper)
    {
        $this->applicationMapper = $applicationMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAll()
    {
        return $this->applicationMapper->findAll($criteria);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findApplication($id)
    {
        return $this->applicationMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveApplication(Application $application)
    {
        return $this->applicationMapper->save($application);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllByTechnicalShortName(string $technicalShortName)
    {
        return $this->applicationMapper->findAll(
            [
                [
                    'technical_short_name' => $technicalShortName
                ]
            ]);
    }
}
