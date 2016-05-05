<?php
namespace Order\Service;

use Order\Mapper\EnvironmentMapperInterface;
use DbSystel\DataObject\Environment;

class EnvironmentService extends AbstractService implements EnvironmentServiceInterface
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
    public function findOne($id)
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
