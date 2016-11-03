<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class ServerCommonFieldset extends AbstractServerFieldset
{

    public function init()
    {
        parent::init();

        $this->get('name')->setLabelAttributes([
            'class' => 'col-md-12 required-conditionally'
        ]);
    }

}
