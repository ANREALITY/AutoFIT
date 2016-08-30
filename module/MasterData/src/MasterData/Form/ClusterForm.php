<?php
namespace MasterData\Form;

use Zend\Form\Form;

class ClusterForm extends Form
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('create_cluster');
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add(
            [
                'name' => 'cluster',
                'type' => 'Order\Form\Fieldset\ClusterCreate',
                'options' => [
                    'use_as_base_fieldset' => true
                ]
            ]);

        $this->add(
            [
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => _('create cluster'),
                    'class' => 'btn btn-default'
                ]
            ]);
    }

}
