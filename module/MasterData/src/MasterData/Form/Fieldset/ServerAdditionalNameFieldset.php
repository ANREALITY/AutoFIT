<?php
namespace MasterData\Form\Fieldset;

use Zend\Form\Fieldset;
use Order\Form\Fieldset\AbstractServerFieldset;

class ServerAdditionalNameFieldset extends AbstractServerFieldset
{

    public function init()
    {
        parent::init();

        $this->get('name')
            ->setAttribute('required', 'required')
            ->setLabelAttributes(['class' => 'col-md-6'])
        ;

        $this->add(
            [
                'type' => 'text',
                'name' => 'virtual_node_name',
                'options' => [
                    'label' => _('server\'s virtual node name'),
                    'label_attributes' => [
                        'class' => 'col-md-6'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-server-virtual-node-name'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'name' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'MasterData\Validator\Db\ServerNotInUseForCd',
                        'options' => [
                            'table' => 'server',
                            'field' => 'name',
                            'adapter' => $this->dbAdapter,
                            'exclude' => 'NOT (node_name IS NULL AND virtual_node_name IS NULL)'
                        ],
                        
                    ]
                ]
            ],
            'virtual_node_name' => [
                'required' => true
            ]
        ];
        return array_merge_recursive(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

}
