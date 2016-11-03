<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\Adapter\AdapterInterface;

abstract class AbstractServerFieldset extends Fieldset implements InputFilterProviderInterface
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
                'name' => 'name',
                'options' => [
                    'label' => _('server name'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control input-server autocomplete-server'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Zend\Validator\Db\RecordExists',
                        'options' => [
                            'table' => 'server',
                            'field' => 'name',
                            'adapter' => $this->dbAdapter
                        ]
                    ]
                ]
            ]
        ];
    }

}
