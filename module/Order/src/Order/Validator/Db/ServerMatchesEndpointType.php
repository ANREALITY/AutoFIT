<?php
namespace Order\Validator\Db;

use DbSystel\DataObject\Server;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Zend\Validator\AbstractValidator;

/**
 * Checks, the server matches to the given endpoint type.
 */
class ServerMatchesEndpointType extends AbstractValidator
{

    /**
     * Error constants
     */
    const ERROR_SERVER_DOES_NOT_MATCH_ENDPOINT_TYPE = 'serverDoesNotMatchEndpointType';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_SERVER_DOES_NOT_MATCH_ENDPOINT_TYPE => 'The server name does not match the endpoint type.'
    ];

    /** @var EntityManager */
    protected $entityManager;

    /**
     * ServerMatchesEndpointType constructor.
     *
     * @param array $options
     *  Options: array elements Fieldst to be validated.
     *  [endpoint_type]
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    /**
     * @param EntityManager $entityManager
     * @return $this
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function isValid($value)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(Server::class, 's');
        $queryBuilder->join('s.serverType', 'st');
        $queryBuilder->join('st.endpointTypes', 'et');
        $queryBuilder->andWhere('s.name = :serverName');
        $queryBuilder->andWhere(
            $queryBuilder->expr()->eq(
                'LOWER(et.name)', ':endpointTypeName'
            )
        );
        $queryBuilder->setParameter('serverName', $value);
        $queryBuilder->setParameter('endpointTypeName', strtolower($this->getOption('endpoint_type_name')));
        $query = $queryBuilder->getQuery();

        $result = $query->execute();

        $isValid = ! empty($result);

        if (! $isValid) {
            $this->error($this->getMessageTemplates()[self::ERROR_SERVER_DOES_NOT_MATCH_ENDPOINT_TYPE]);
        }

        return $isValid;
    }

}
