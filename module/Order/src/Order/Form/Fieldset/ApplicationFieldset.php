<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\Adapter\AdapterInterface;

class ApplicationFieldset extends Fieldset implements InputFilterProviderInterface
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
                'name' => 'technical_short_name',
                'options' => [
                    'label' => _('application'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-application-number autocomplete-application'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'technical_short_name' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Zend\Validator\Db\RecordExists',
                        'options' => [
                            'table' => 'application',
                            'field' => 'technical_short_name',
                            'adapter' => $this->dbAdapter
                        ]
                    ]
                ]
            ]
        ];
    }

}
