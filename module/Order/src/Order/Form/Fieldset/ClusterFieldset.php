<?php
namespace Order\Form\Fieldset;

use Base\DataObject\Cluster;
use DoctrineModule\Validator\ObjectExists;

class ClusterFieldset extends AbstractClusterFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('cluster', $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
            'attributes' => [
                'class' => 'field-cluster-id'
            ]
        ]);

        $this->add([
            'name' => 'virtual_node_name',
            'type' => 'text',
            'options' => [
                'label' => _('cluster\'s virtual node name'),
                'label_attributes' => [
                    'class' => 'col-md-12 required-conditionally'
                ]
            ],
            'attributes' => [
                'class' => 'form-control field-cluster-virtual-node-name'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'virtual_node_name' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => ObjectExists::class,
                        'options' => [
                            'object_repository' => $this->entityManager->getRepository(Cluster::class),
                            'fields' => 'virtualNodeName'
                        ]
                    ]
                ]
            ]
        ];
    }

}
