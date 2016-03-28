<?php
namespace Order\Form\Fieldset;

class ServiceInvoicePositionBasicFieldset extends AbstractServiceInvoicePositionFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('service_invoice_position_basic', $options);
    }

    public function init()
    {
        parent::init();

        $this->get('number')->setLabel('service invoice position (basic)');
        $this->get('number')->setAttribute('id', 'service-invoice-position-basic-number');
    }

}
