<?php
namespace DbSystel\Validator;

use Zend\Validator\Regex as ZendRegex;

class Regex extends ZendRegex
{

    /**
     * @var string
     */
    protected $patternUserFriendly;

    public function __construct($pattern)
    {
        $this->messageVariables['patternUserFriendly'] = 'patternUserFriendly';
        $this->messageTemplates[self::NOT_MATCH] =
            'The input may only contain the following characters: %patternUserFriendly%.'
        ;
        parent::__construct($pattern);
        if (array_key_exists('patternUserFriendly', $pattern)) {
            $this->patternUserFriendly = $pattern['patternUserFriendly'];
        }
    }

}