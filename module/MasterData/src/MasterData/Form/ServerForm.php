<?php
namespace MasterData\Form;

use Zend\Form\Form;

class ServerForm extends Form
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('edit_server');
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add(
            [
                'name' => 'server',
                'type' => 'MasterData\Form\Fieldset\ServerAdditionalName',
                'options' => [
                    'use_as_base_fieldset' => true
                ]
            ]);

        $this->add(
            [
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => _('update server'),
                    'class' => 'btn btn-default'
                ]
            ]);
    }

}
