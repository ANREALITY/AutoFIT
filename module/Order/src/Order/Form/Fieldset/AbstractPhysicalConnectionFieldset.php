<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractPhysicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    /**
     *
     * @var string
     */
    protected $endpointSourceFieldsetServiceName;

    /**
     *
     * @var string
     */
    protected $endpointTargetFieldsetServiceName;

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName = null,
        string $endpointTargetFieldsetServiceName = null)
    {
        parent::__construct('physical_connection', $options);

        $this->endpointSourceFieldsetServiceName = $endpointSourceFieldsetServiceName;
        $this->endpointTargetFieldsetServiceName = $endpointTargetFieldsetServiceName;
    }

    public function init()
    {
        if ($this->endpointSourceFieldsetServiceName) {
            $this->add(
                [
                    'name' => 'endpoint_source',
                    'type' => $this->endpointSourceFieldsetServiceName,
                    'options' => []
                ]);
        }

        if ($this->endpointTargetFieldsetServiceName) {
            $this->add(
                [
                    'name' => 'endpoint_target',
                    'type' => $this->endpointTargetFieldsetServiceName,
                    'options' => []
                ]);
        }

        $this->add(
            [
                'name' => 'role',
                'type' => 'hidden',
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => $this->getConcreteRole()
                ]
            ]);

        $this->add(
            [
                'name' => 'type',
                'type' => 'hidden',
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => $this->getConcreteType()
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'secure_plus',
                'options' => [
                    'label' => _('Secure Plus'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'secure_plus' => [
                'required' => false
            ]
        ];
    }

    abstract protected function getConcreteType();

}
