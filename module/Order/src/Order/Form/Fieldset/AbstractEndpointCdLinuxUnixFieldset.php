<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\AbstractEndpoint;

abstract class AbstractEndpointCdLinuxUnixFieldset extends AbstractEndpointFieldset implements InputFilterProviderInterface
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
                    'label' => _('username'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'folder',
                'options' => [
                    'label' => _('folder'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'name' => 'servers',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('multiple servers'),
                    'count' => 5,
                    'should_create_template' => true,
                    'template_placeholder' => '__placeholder__',
                    'allow_add' => true,
                    'target_element' => [
                        'type' => 'Order\Form\Fieldset\Server',
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'service_address',
                'options' => [
                    'label' => _('service address (IP / server name)'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
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

    protected function getConcreteType()
    {
        return AbstractEndpoint::TYPE_CD_LINUX_UNIX;
    }

}
