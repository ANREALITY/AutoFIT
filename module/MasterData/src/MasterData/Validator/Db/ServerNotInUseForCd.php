<?php
namespace MasterData\Validator\Db;

use Zend\Validator\Db\NoRecordExists;

/**
 * Confirms a record does not exist in a table.
 */
class ServerNotInUseForCd extends NoRecordExists
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

    public function __construct($options = null) {
        $options['exclude'] = <<<SQL
        (
            NOT (
                (node_name IS NULL OR node_name = "") AND (virtual_node_name IS NULL OR virtual_node_name = "")
            ) OR (
                cluster_id IS NOT NULL
            )
        )
SQL;
        $options['table'] = 'server';
        $options['field'] = 'name';
        parent::__construct($options);
    }

    public function isValid($value)
    {
        $valid = parent::isValid($value);

        if (! $valid) {
            $this->error(self::ERROR_CD_SETTINGS_ALREADY_DEFINED);
        }

        return $valid;
    }

}
