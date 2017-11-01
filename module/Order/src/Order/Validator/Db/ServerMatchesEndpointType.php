<?php
namespace Order\Validator\Db;

use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Validator\Db\AbstractDb;

/**
 * Checks, the server matches to the given endpoint type.
 */
class ServerMatchesEndpointType extends AbstractDb
{

    /**
     * Error constants
     */
    const ERROR_SERVER_DOES_NOT_MATCH_ENDPOINT_TYPE = 'serverDoesNotMatchEndpointType';

    /** @var EntityManager */
    protected $entityManager;

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_SERVER_DOES_NOT_MATCH_ENDPOINT_TYPE => 'The server name does not match the endpoint type.'
    ];

    /**
     * 
     * @param array $options
     *  Options: array elements Fieldst to be validated.
     *  [endpoint_type]
     */
    public function __construct(EntityManager $entityManager, $options = null) {
        $options['table'] = null;
        $options['field'] = null;
        parent::__construct($options);
        $this->entityManager = $entityManager;
    }

    public function isValid($value)
    {
        $isValid = false;

        $sql = new Sql($this->getAdapter());
        $select = new Select();
        $select = $sql->select('server');
        // filtering by name
        $select->where(
            [
                'server.name = ?' => $value
            ]);
        // filtering by endpoint type
        $select->join('endpoint_type_server_type', 'endpoint_type_server_type.server_type_id = server.server_type_id', [],
            Select::JOIN_INNER);
        $select->join('endpoint_type', 'endpoint_type.id = endpoint_type_server_type.endpoint_type_id', [
            'endpoint_type_name' => 'name'
        ], Select::JOIN_INNER);
        $select->where->expression(
            'LOWER(endpoint_type.name) = LOWER(?)', $this->getOption('endpoint_type_name')
            );

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->count() > 0) {
            $isValid = true;
        }

        if (! $isValid) {
            $this->error($this->getMessageTemplates()[self::ERROR_SERVER_DOES_NOT_MATCH_ENDPOINT_TYPE]);
        }
        return $isValid;
    }

}
