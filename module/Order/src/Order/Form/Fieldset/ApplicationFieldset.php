<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ApplicationFieldset extends Fieldset implements InputFilterProviderInterface
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
                'name' => 'technical_short_name',
                'options' => [
                    'label' => _('application'),
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
        return [];
    }
}
