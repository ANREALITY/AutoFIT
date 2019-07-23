<?php
namespace MasterData\Validator\Db;

use Base\DataObject\Server;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Zend\Validator\AbstractValidator;

/**
 * Confirms a record does not exist in a table.
 */
class ServerNotInUseForCd extends AbstractValidator
{

    /**
     * Error constants
     */
    const ERROR_CD_SETTINGS_ALREADY_DEFINED = 'cdSettingsAlreadyDefined';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_CD_SETTINGS_ALREADY_DEFINED => 'The Connect:Direct settings for this server already defined.'
    ];

    /** @var EntityManager */
    protected $entityManager;

    public function __construct($options = null) {
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
        $queryBuilder->andWhere('s.name = :serverName');
        $queryBuilder->andWhere(
            $queryBuilder->expr()->isNull('s.cluster')
        );
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->isNull('s.nodeName'),
                $queryBuilder->expr()->eq('s.nodeName', "''")
            )
        );
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->isNull('s.virtualNodeName'),
                $queryBuilder->expr()->eq('s.virtualNodeName', "''")
            )
        );
        $queryBuilder->setParameter('serverName', $value);
        $query = $queryBuilder->getQuery();

        $result = $query->execute();

        $isValid = ! empty($result);

        if (! $isValid) {
            $this->error(self::ERROR_CD_SETTINGS_ALREADY_DEFINED);
        }

        return $isValid;
    }

}
