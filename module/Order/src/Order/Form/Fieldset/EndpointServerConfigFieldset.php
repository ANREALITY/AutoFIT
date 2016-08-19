<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class EndpointServerConfigFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('endpoint_server_config', $options);
    }

    public function init()
    {

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
            'attributes' => [
                'class' => 'field-endpoint-server-config-id'
            ]
        ]);

        $this->add(
            [
                'name' => 'server',
                'type' => 'Order\Form\Fieldset\ServerCommon',
                'options' => []
            ]);

        $this->add([
            'name' => 'dns_address',
            'type' => 'text',
            'options' => [
                'label' => _('DNS address'),
                'label_attributes' => [
                    'class' => 'col-md-12'
                ]
            ],
            'attributes' => [
                'class' => 'form-control field-endpoint-server-config-dns-address'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
