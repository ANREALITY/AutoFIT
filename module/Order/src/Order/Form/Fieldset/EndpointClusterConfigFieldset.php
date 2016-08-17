<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class EndpointClusterConfigFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('endpoint_cluster_config', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'cluster',
                'type' => 'Order\Form\Fieldset\Cluster',
                'options' => []
            ]);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
            'attributes' => [
                'class' => 'field-endpoint-cluster-config-id'
            ]
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
                'class' => 'form-control field-endpoint-cluster-config-dns-address'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
