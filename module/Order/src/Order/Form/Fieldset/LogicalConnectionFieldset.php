<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\LogicalConnection;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class LogicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('logical_connection', $options);

        $this->setHydrator(new ClassMethods())->setObject(new LogicalConnection());

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden'
        ));

        $this->add(
            array(
                'name' => 'type',
                'type' => 'text',
                'options' => array(
                    'label' => _('type')
                ),
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => LogicalConnection::TYPE_CD
                )
            ));
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
