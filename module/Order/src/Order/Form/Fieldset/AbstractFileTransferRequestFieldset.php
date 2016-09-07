<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Validator\Db\NoRecordExists;

abstract class AbstractFileTransferRequestFieldset extends Fieldset implements InputFilterProviderInterface
{

    const COMMENT_MAX_LENGTH = 140;

    /**
     *
     * @var AdapterInterface
     */
    protected $dbAdapter;

    public function __construct($name = null, $options = [])
    {
        parent::__construct('file_transfer_request', $options);
    }

    /**
     *
     * @param AdapterInterface $dbAdapter
     */
    public function setDbAdapter(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add(
            [
                'name' => 'change_number',
                'type' => 'text',
                'options' => [
                    'label' => _('change number'),
                    'label_attributes' => [
                        'class' => 'col-md-6'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'name' => 'user',
                'type' => 'Order\Form\Fieldset\User',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'logical_connection',
                'type' => 'Order\Form\Fieldset\LogicalConnection' . $this->getConcreteType(),
                'options' => []
            ]);

        $this->add(
            [
                'type' => 'Order\Form\Fieldset\ServiceInvoicePositionBasic',
                'name' => 'service_invoice_position_basic',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'application_technical_short_name',
                'type' => 'text',
                'options' => [
                    'label' => _('application'),
                    'label_attributes' => []
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control autocomplete-application',
                    'id' => 'order' . '-' . 'application-number'
                ]
            ]);

        $this->add(
            [
                'type' => 'Order\Form\Fieldset\ServiceInvoicePositionPersonal',
                'name' => 'service_invoice_position_personal',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'environment',
                'type' => 'Order\Form\Fieldset\Environment',
                'options' => []
            ]);

        $this->add(
            [
                'type' => 'textarea',
                'name' => 'comment',
                'options' => [
                    'label' => _('comment'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'maxlength' => static::COMMENT_MAX_LENGTH
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'change_number' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[A-Z][0-9]{8}$/',
                            'message' => _(
                                'Change numbers have the format 1 capital letter and 8 digits ("C12345678").')
                        ]
                    ],
                    [
                        'name' => 'Callback',
                        'options' => [
                            'callback' => function($value, $context = []) {
                                $return = true;
                                if (empty($context['id'])) {
                                    $noRecordExistsValidator = new NoRecordExists([
                                        'table' => 'file_transfer_request',
                                        'field' => 'change_number',
                                        'adapter' => $this->dbAdapter
                                    ]);
                                    $return = $noRecordExistsValidator->isValid($value);
                                }
                                return $return;
                            },
                        ],
                    ]
                ],
            ],
            'application_technical_short_name' => [
                'required' => true
            ],
            'comment' => [
                'filters' => [
                    [
                        'name' => 'Callback',
                        'options' => [
                            'callback' => function ($value) {
                                $lineBreaks = substr_count($value, PHP_EOL);
                                return substr($value, 0, static::COMMENT_MAX_LENGTH + $lineBreaks);
                            }
                        ]
                    ]
                ]
            ]
        ];
    }

    abstract protected function getConcreteType();

}
