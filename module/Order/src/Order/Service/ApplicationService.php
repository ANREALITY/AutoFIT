<?php
namespace Order\Service;

use Doctrine\ORM\Query;
use Order\Mapper\AbstractMapper;
use Order\Mapper\ApplicationMapperInterface;
use DbSystel\DataObject\Application;

class ApplicationService extends AbstractService implements ApplicationServiceInterface
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
    public function findAllForAutocomplete(string $technicalShortName)
    {
        return $this->mapper->findAll(
            [
                [
                    'technical_short_name' => $technicalShortName,
                    'active' => true,
                    'with_invoice_positions_only' => false
                ]
            ],
            AbstractMapper::DEFAULT_QUERY_LIMIT,
            Query::HYDRATE_ARRAY
        );
    }

}
