<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\Adapter\AdapterInterface;

class EnvironmentFieldset extends Fieldset implements InputFilterProviderInterface
{

    /**
     * @var AdapterInterface
     */
    protected $dbAdapter;

    public function __construct($name = null, $options = [])
    {
        parent::__construct('customer', $options);
    }

    /**
     * @param AdapterInterface $dbAdapter
     */
    public function setDbAdapter(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'severity',
                'type' => 'hidden',
                'options' => [
                    'label' => _('environment')
                ],
                'attributes' => [
                    'id' => 'order' . '-' . 'environment-severity'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => _('environment')
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'order' . '-' . 'environment-name'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'severity' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Zend\Validator\Db\RecordExists',
                        'options' => [
                            'table' => 'environment',
                            'field' => 'severity',
                            'adapter' => $this->dbAdapter
                        ]
                    ]
                ]
            ]
        ];
    }

}
