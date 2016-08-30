<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class ClusterCreateFieldset extends AbstractClusterFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('cluster', $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'virtual_node_name',
            'type' => 'text',
            'options' => [
                'label' => _('cluster\'s virtual node name'),
                'label_attributes' => [
                    'class' => 'col-md-12'
                ]
            ],
            'attributes' => [
                'required' => 'required',
                'class' => 'form-control field-cluster-virtual-node-name'
            ]
        ]);

        $this->add(
            [
                'name' => 'servers',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('servers'),
                    'count' => 1,
                    'should_create_template' => true,
                    'template_placeholder' => '__index__',
                    'allow_add' => true,
                    'target_element' => [
                        'type' => 'Order\Form\Fieldset\ServerListItem'
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12 fieldset-multiple-servers'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'add_server',
                'type' => 'button',
                'options' => [
                    'label' => _('+')
                ],
                'attributes' => [
                    'class' => 'btn btn-default',
                    'id' => 'add-cluster-server-button',
                    'value' => _('add a server')
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'virtual_node_name' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Zend\Validator\Db\NoRecordExists',
                        'options' => [
                            'table' => 'cluster',
                            'field' => 'virtual_node_name',
                            'adapter' => $this->dbAdapter
                        ]
                    ]
                ]
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

}
