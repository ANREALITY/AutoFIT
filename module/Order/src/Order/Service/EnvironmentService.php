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
    public function findAllByApplicationAndName(string $applicationTechnicalShortName, string $name = null)
    {
        return $this->mapper->findAll(
            [
                [
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'name' => $name,
                    'with_invoice_positions_only' => true
                ]
            ]);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveOne(Environment $environment)
    {
        return $this->mapper->save($environment);
    }

}
