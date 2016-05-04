<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\AbstractEndpoint;
use Zend\Form\View\Helper\FormMultiCheckbox;
use DbSystel\DataObject\Protocol;
use DbSystel\DataObject\EndpointFtgwSelfService;

abstract class AbstractEndpointFtgwSelfServiceFieldset extends AbstractEndpointFieldset implements
    InputFilterProviderInterface
{

    const PROTOCOLS_DUMMY_VALUE = 0;

    const PROTOCOLS_DUMMY_LABEL = 'dummy';

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Self-Service'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'multi_checkbox',
                'name' => 'protocols',
                'options' => [
                    'label' => _('protocols'),
                    'label_attributes' => [
                        'class' => 'col-md-1 protocol-field'
                    ],
                    'value_options' => $this->getValueOptions(),
                    'selected' => static::PROTOCOLS_DUMMY_VALUE
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'ftgw_username',
                'options' => [
                    'label' => _('FTWG user'),
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
                'type' => 'text',
                'name' => 'mailbox',
                'options' => [
                    'label' => _('mailbox'),
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
                'name' => 'connection_type',
                'options' => [
                    'label' => _('connection type'),
                    'value_options' => [
                        [
                            'value' => EndpointFtgwSelfService::CONNECTION_TYPE_INTERNAL,
                            'label' => _('internal'),
                            'selected' => true
                        ],
                        [
                            'value' => EndpointFtgwSelfService::CONNECTION_TYPE_EXTERNAL,
                            'label' => _('external')
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'protocols' => []
        ];
    }

    protected function getConcreteType()
    {
        return AbstractEndpoint::TYPE_FTGW_SELF_SERVICE;
    }

    protected function getValueOptions()
    {
        $valueOptions = [];
        foreach (Protocol::PROTOCOLS as $key => $value) {
            $valueOptions[] = [
                'value' => $key,
                'label' => $value
            ];
        }
        $valueOptions[] = [
            'value' => static::PROTOCOLS_DUMMY_VALUE,
            'label' => static::PROTOCOLS_DUMMY_LABEL,
            'selected' => true,
            'label_attributes' => [
                'class' => 'checkboxdummy'
            ]
        ];
        return $valueOptions;
    }

}
