<?php
namespace Order\Form\Fieldset;

class ServiceInvoicePositionPersonalFieldset extends AbstractServiceInvoicePositionFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('service_invoice_position_personal', $options);
    }

    public function init()
    {
        parent::init();
        
        $this->setLabel(_('service invoice position (personal)'));
        
        $this->get('number')->setLabel('service invoice position (personal)');
    }
}
