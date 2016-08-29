<?php
namespace MasterData\Validator\Db;

use Zend\Validator\Exception;
use Zend\Validator\Db\AbstractDb;
use Zend\Db\Sql\Sql;
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
        self::ERROR_CD_SETTINGS_ALREADY_DEFINED => 'The ConnectDirect settings for this server already defined.'
    ];

    public function isValid($value)
    {
        $valid = parent::isValid($value);

        if (! $valid) {
            $this->error(self::ERROR_CD_SETTINGS_ALREADY_DEFINED);
        }

        return $valid;
    }

}
