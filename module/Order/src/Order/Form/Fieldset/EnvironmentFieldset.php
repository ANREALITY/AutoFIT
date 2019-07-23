<?php
namespace Order\Form\Fieldset;

use Base\DataObject\Environment;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\ObjectExists;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class EnvironmentFieldset extends Fieldset implements InputFilterProviderInterface
{

    /** @var EntityManager */
    protected $entityManager;

    public function __construct($name = null, $options = [])
    {
        parent::__construct('customer', $options);
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
        $this->add(
            [
                'name' => 'severity',
                'type' => 'hidden',
                'options' => [
                    'label' => _('environment')
                ],
                'attributes' => [
                    'id' => 'order-environment-severity'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => _('environment'),
                    'label_attributes' => [
                        'class' => 'required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'id' => 'order-environment-name'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'severity' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => ObjectExists::class,
                        'options' => [
                            'object_repository' => $this->entityManager->getRepository(Environment::class),
                            'fields' => 'severity'
                        ]
                    ]
                ]
            ]
        ];
    }

}
