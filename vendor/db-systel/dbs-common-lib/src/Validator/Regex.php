<?php
namespace DbSystel\Validator;

use Zend\Validator\Regex as ZendRegex;

class Regex extends ZendRegex
{

    /**
     * @var string
     */
    protected $patternUserFriendly;
    /**
     * @var string
     */
    protected $patternUserFriendlyNegative;

    public function __construct($pattern)
    {
        $this->setUpMesages($pattern);
        parent::__construct($pattern);
    }

    protected function setUpMesages($pattern)
    {
        $this->messageVariables['patternUserFriendly'] = 'patternUserFriendly';
        $this->messageVariables['patternUserFriendlyNegative'] = 'patternUserFriendlyNegative';
        if (array_key_exists('patternUserFriendly', $pattern)) {
            $this->patternUserFriendly = $pattern['patternUserFriendly'];
            $this->messageTemplates[self::NOT_MATCH] =
                'The input may only contain the following characters: %patternUserFriendly%.'
            ;
        }
        if (array_key_exists('patternUserFriendlyNegative', $pattern)) {
            $this->patternUserFriendlyNegative = $pattern['patternUserFriendlyNegative'];
            $this->messageTemplates[self::NOT_MATCH] =
                'The input may not contain the following characters: %patternUserFriendlyNegative%.'
            ;
        }
    }

}