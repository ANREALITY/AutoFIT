<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\LogicalConnection;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class LogicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('logical_connection', $options);
    }

    public function init()
    {
        $this->setHydrator(new ClassMethods())->setObject(new LogicalConnection());
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        
        $this->add(
            [
                'name' => 'type',
                'type' => 'hidden',
                'options' => [
                    'label' => _('type')
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => LogicalConnection::TYPE_CD
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'type' => [
                'required' => true
            ]
        ];
    }
}
