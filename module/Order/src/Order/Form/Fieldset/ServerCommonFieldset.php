<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class ServerCommonFieldset extends AbstractServerFieldset
{

    public function init()
    {
        $this->add(
            [
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => _('server\'s node name'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-server-node-name'
                ]
            ]);
    }

}
