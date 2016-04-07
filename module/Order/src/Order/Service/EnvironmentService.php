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
    protected $environmentMapper;

    /**
     *
     * @param EnvironmentMapperInterface $environmentMapper
     */
    public function __construct(EnvironmentMapperInterface $environmentMapper)
    {
        $this->environmentMapper = $environmentMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAll()
    {
        return $this->environmentMapper->findAll($criteria);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findEnvironment($id)
    {
        return $this->environmentMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveEnvironment(Environment $environment)
    {
        return $this->environmentMapper->save($environment);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllByApplicationAndName(string $applicationTechnicalShortName, string $name = null)
    {
        return $this->environmentMapper->findAll(
            [
                [
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'application_technical_short_name' => $name,
                ]
            ]);
    }
}
