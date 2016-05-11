<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\AbstractEndpoint;

abstract class AbstractEndpointFieldset extends Fieldset implements InputFilterProviderInterface
{

    const CONTACT_PERCON_MAX_LENGTH = 50;

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
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
                    'class' => 'form-control',
                    'maxlength' => static::CONTACT_PERCON_MAX_LENGTH
                ]
            ]);

        $this->add(
            [
                'type' => 'radio',
                'name' => 'server_place',
                'options' => [
                    'label' => _('server place'),
                    'value_options' => [
                        [
                            'value' => Server::PLACE_INTERNAL,
                            'label' => _('internal'),
                            'selected' => true
                        ],
                        [
                            'value' => Server::PLACE_EXTERNAL,
                            'label' => _('external')
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'field-server-place'
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

        $this->add(
            [
                'name' => 'role',
                'type' => 'hidden',
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => $this->getConcreteRole()
                ]
            ]);

        $this->add(
            [
                'name' => 'type',
                'type' => 'hidden',
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => $this->getConcreteType()
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'contact_person' => [
                'filters' => [
                    [
                        'name' => 'Callback',
                        'options' => [
                            'callback' => function($value) {
                                return substr($value, 0, static::CONTACT_PERCON_MAX_LENGTH);
                            }
                        ]
                    ]
                ]
            ]
        ];
    }

    abstract protected function getConcreteRole();

    abstract protected function getConcreteType();

}
