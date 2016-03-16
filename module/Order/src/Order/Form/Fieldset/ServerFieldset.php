<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ServerFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->add(
            array(
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => _('server name'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ));
    }

    public function getInputFilterSpecification()
    {
        return [
        ];
    }
}
