<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractEndpointCdFieldset extends AbstractEndpointFieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        parent::init();
        
        $this->add(
            [
                'type' => 'text',
                'name' => 'contact_person',
                'options' => [
                    'label' => _('contact person'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'type' => 'radio',
                'name' => 'server_place',
                'options' => [
                    'label' => _('server place'),
                    'value_options' => [
                        'intranet' => _('intranet'),
                        'internet' => _('internet')
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'application',
                'type' => 'Order\Form\Fieldset\Application',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'customer',
                'type' => 'Order\Form\Fieldset\Customer',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'server',
                'type' => 'Order\Form\Fieldset\Server',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}
