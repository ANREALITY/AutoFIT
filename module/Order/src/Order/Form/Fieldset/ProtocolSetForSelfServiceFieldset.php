<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class ProtocolSetForSelfServiceFieldset extends AbstractProtocolSetFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('protocol_set', ['label' => _('protocols')]);
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'MultiCheckbox',
                'name' => 'protocols',
                'options' => [
                    'label' => _('protocols'),
                    'label_attributes' => [
                        'class' => 'col-md-1 protocol-field'
                    ],
                    'value_options' => $this->getValueOptions()
                ]
            ]);
    }

}
