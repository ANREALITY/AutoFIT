<?php
namespace Base\Validator;

class WindowsDomainUserName extends Regex
{

    protected function setUpMesages($pattern)
    {
        parent::setUpMesages($pattern);
        $this->messageTemplates[self::NOT_MATCH] .=
            ' ' . 'The username needs to contain the domain, e.g.: BKU\MaxMustermann.'
        ;
    }

}
