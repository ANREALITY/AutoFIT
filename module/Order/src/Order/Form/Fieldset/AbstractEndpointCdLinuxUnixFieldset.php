<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Base\DataObject\AbstractEndpoint;

abstract class AbstractEndpointCdLinuxUnixFieldset extends AbstractEndpointFieldset implements
    InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('LinuxUnix'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'text',
                'name' => 'username',
                'options' => [
                    'label' => _('application user'),
                    'label_attributes' => [
                        'class' => 'col-md-12 required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-application-user'
                ]
            ]);

        $this->add(
            [
                'type' => 'radio',
                'name' => 'server_toggle',
                'options' => [
                    'label' => _('server variant'),
                    'value_options' => [
                        [
                            'value' => 'single_server',
                            'label' => _('single server (s. basic settings)'),
                            'selected' => true
                        ],
                        [
                            'value' => 'multiple_servers',
                            'label' => _('multiple servers')
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'toggle-server'
                ]
            ]);

        $this->add(
            [
                'name' => 'endpoint_cluster_config',
                'type' => 'Order\Form\Fieldset\EndpointClusterConfig',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'username' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'max' => 8
                        ]
                    ],
                ]
            ],
            'server_toggle' => [
                'required' => true
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteType()
    {
        return AbstractEndpoint::TYPE_CD_LINUX_UNIX;
    }

}
