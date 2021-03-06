<?php
namespace Order\Service;

use Doctrine\ORM\Query;
use Order\Mapper\AbstractMapper;
use Order\Mapper\EnvironmentMapperInterface;
use Base\DataObject\Environment;

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
    public function findAllForAutocomplete(string $applicationTechnicalShortName = null, string $name = null)
    {
        return $this->mapper->findAll(
            [
                [
                    'application_technical_short_name' => $applicationTechnicalShortName,
                    'name' => $name,
                    'with_invoice_positions_only' => false
                ]
            ],
            AbstractMapper::DEFAULT_QUERY_LIMIT,
            Query::HYDRATE_ARRAY
        );
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
