<?php
namespace Base\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Checks, whether at most one of the given elements is set.
 */
class MaxOneNotEmpty extends AbstractValidator
{

    /**
     * Error constants
     */
    const ERROR_MORE_THAN_ONE_SET = 'moreThanOneSet';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_MORE_THAN_ONE_SET => 'More than one of the validated fields is set.'
    ];

    /**
     * 
     * @param array $options
     *  Options: array elements Fieldst to be validated.
     */
    public function __construct($options = null) {
        parent::__construct($options);
    }

    public function isValid($value)
    {
        $elements = $this->getOption('elements') ?: [];
        $isValid = true;
        $numberOfSetElements = 0;
        foreach ($elements as $element) {
            if ($element->getValue() !== null && $element->getValue() !== '') {
                $numberOfSetElements++;
                if ($numberOfSetElements > 1) {
                    $isValid = false;
                    break;
                }
            }
        }
        if (! $isValid) {
            $this->error($this->getMessageTemplates()[self::ERROR_MORE_THAN_ONE_SET]);
        }
        return $isValid;
    }

}
