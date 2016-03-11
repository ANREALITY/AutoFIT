<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\User;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('user', $options);
    }

    public function init()
    {
        $this->setHydrator(new ClassMethods())->setObject(new User());
        
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden'
        ));
        
        $this->add(
            array(
                'name' => 'username',
                'type' => 'text',
                'options' => array(
                    'label' => _('username')
                ),
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'form-control'
                )
            ));
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
