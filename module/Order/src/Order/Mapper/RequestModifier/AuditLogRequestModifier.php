<?php
namespace Order\Mapper\RequestModifier;

use Zend\Db\Sql\Select;

class AuditLogRequestModifier
{

    const REQUEST_MODE_BASIC = 'basic';

    const REQUEST_MODE_REDUCED = 'reduced';

    const REQUEST_MODE_FULL = 'full';

}
