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

        $this->get('number')->setLabel(_('service invoice position (basic)'));
        $this->get('number')->setAttribute('id', 'order-service-invoice-position-basic-number');
    }

}
