<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\Application;
use DbSystel\DataObject\FileTransferRequest;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use DoctrineModule\Validator\ObjectExists;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractFileTransferRequestFieldset extends Fieldset implements InputFilterProviderInterface
{

    const COMMENT_MAX_LENGTH = 140;

    /** @var EntityManager */
    protected $entityManager;

    public function __construct($name = null, $options = [])
    {
        parent::__construct('file_transfer_request', $options);
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add(
            [
                'name' => 'application_technical_short_name',
                'type' => 'text',
                'options' => [
                    'label' => _('application according to TransICT'),
                    'label_attributes' => [
                        'class' => 'required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control autocomplete-application',
                    'id' => 'order-application-number'
                ]
            ]);

        $this->add(
            [
                'name' => 'environment',
                'type' => 'Order\Form\Fieldset\Environment',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'change_number',
                'type' => 'text',
                'options' => [
                    'label' => _('change number'),
                    'label_attributes' => [
                        'class' => 'col-md-6 required'
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
                'type' => 'Order\Form\Fieldset\LogicalConnection' . ucfirst(strtolower($this->getConcreteType())),
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
                'type' => 'Order\Form\Fieldset\ServiceInvoicePositionPersonal',
                'name' => 'service_invoice_position_personal',
                'options' => []
            ]);

        $this->add(
            [
                'type' => 'textarea',
                'name' => 'comment',
                'options' => [
                    'label' => null,
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
                            'pattern' => '/^[A-Z][0-9]{8}(\.[1-9])?$/',
                            'message' => _(
                                'Change numbers have the format 1 capital letter and 8 digits ("C12345678"). Additionally a sub-number can be specified ("C12345678.1").')
                        ]
                    ],
                    [
                        'name' => 'Callback',
                        'options' => [
                            'callback' => function($value, $context = []) {
                                $return = true;
                                if (empty($context['id'])) {
                                    $noRecordExistsValidator = new NoObjectExists([
                                        'object_repository' => $this->entityManager->getRepository(FileTransferRequest::class),
                                        'fields' => 'changeNumber'
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
                'required' => true,
                'validators' => [
                    [
                        'name' => ObjectExists::class,
                        'options' => [
                            'object_repository' => $this->entityManager->getRepository(Application::class),
                            'fields' => 'technicalShortName'
                        ]
                    ]
                ],
            ],
            'comment' => [
                'required' => false,
                'filters' => [
                    [
                        'name' => 'Callback',
                        'options' => [
                            'callback' => function ($value) {
                                $lineBreaks = substr_count($value, PHP_EOL);
                                mb_internal_encoding('UTF-8');
                                return mb_substr($value, 0, static::COMMENT_MAX_LENGTH + $lineBreaks);
                            }
                        ]
                    ]
                ]
            ]
        ];
    }

    abstract protected function getConcreteType();

}
