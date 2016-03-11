<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\User;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('user', $options);
    }

    public function init()
    {
        $this->setHydrator(new ClassMethods())->setObject(new User());
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        
        $this->add(
            [
                'name' => 'username',
                'type' => 'text',
                'options' => [
                    'label' => _('username')
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'username' => [
                'required' => true
            ]
        ];
    }
}
