<?php
namespace DbSystel\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Checks, whether at least one of the given elements is set.
 */
class MinOneNotEmpty extends AbstractValidator
{

    /**
     * Error constants
     */
    const ERROR_ALL_VALIDATED_FIELDS_EMPTY = 'allValidatedFieldsEmpty';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = [
        self::ERROR_ALL_VALIDATED_FIELDS_EMPTY => 'All the validated fields are empty.'
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
        $isValid = empty($elements);
        foreach ($elements as $element) {
            if ($element->getValue() !== null && $element->getValue() !== '') {
                $isValid = true;
                break;
            }
        }
        if (! $isValid) {
            $this->error($this->getMessageTemplates()[self::ERROR_ALL_VALIDATED_FIELDS_EMPTY]);
        }
        return $isValid;
    }

}
