<?php
namespace Order\Service;

use Order\Mapper\EnvironmentMapperInterface;
use DbSystel\DataObject\Environment;

class EnvironmentService implements EnvironmentServiceInterface
{

    /**
     *
     * @var EnvironmentMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param EnvironmentMapperInterface $mapper
     */
    public function __construct(EnvironmentMapperInterface $mapper)
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
    public function findEnvironment($id)
    {
        return $this->mapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveEnvironment(Environment $environment)
    {
        return $this->mapper->save($environment);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllByApplicationAndName(string $applicationTechnicalShortName, string $name = null)
    {
        return $this->mapper->findAll(
            [
                [
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'name' => $name
                ]
            ]);
    }

}
