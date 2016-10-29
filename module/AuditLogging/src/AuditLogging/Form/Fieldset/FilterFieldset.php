<?php
namespace AuditLogging\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\AuditLog;

class FilterFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {

        $this->add(
            [
                'name' => 'username',
                'type' => 'text',
                'options' => [
                    'label' => _('username'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'name' => 'change_number',
                'type' => 'text',
                'options' => [
                    'label' => _('change number'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'type' => 'select',
                'name' => 'resource_type',
                'options' => [
                    'label' => _('resource type'),
                    'value_options' => [
                        [
                            'value' => '',
                            'label' => _('all resource types'),
                            'selected' => true
                        ],
                        [
                            'value' => AuditLog::RESSOURCE_TYPE_ORDER,
                            'label' => _('orders'),
                            'selected' => false
                        ],
                        [
                            'value' => AuditLog::RESSOURCE_TYPE_SERVER,
                            'label' => _('servers'),
                            'selected' => false
                        ],
                        [
                            'value' => AuditLog::RESSOURCE_TYPE_CLUSTER,
                            'label' => _('clusters'),
                            'selected' => false
                        ],
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return $inputFilterSpecification;
    }

}
