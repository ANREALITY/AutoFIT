<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\Adapter\AdapterInterface;

abstract class AbstractServiceInvoicePositionFieldset extends Fieldset implements InputFilterProviderInterface
{

    /**
     * @var AdapterInterface
     */
    protected $dbAdapter;

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
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
                'type' => 'text',
                'name' => 'number',
                'options' => [
                    'label' => _('service invoice position number')
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'number' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Zend\Validator\Db\RecordExists',
                        'options' => [
                            'table' => 'service_invoice_position',
                            'field' => 'number',
                            'adapter' => $this->dbAdapter
                        ]
                    ]
                ]
            ]
        ];
    }

}
