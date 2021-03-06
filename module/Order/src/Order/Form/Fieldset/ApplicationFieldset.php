<?php
namespace Order\Form\Fieldset;

use Base\DataObject\Application;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\ObjectExists;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ApplicationFieldset extends Fieldset implements InputFilterProviderInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
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
                        'name' => ObjectExists::class,
                        'options' => [
                            'object_repository' => $this->entityManager->getRepository(Application::class),
                            'fields' => ['technicalShortName'],
                        ]
                    ]
                ]
            ]
        ];
    }

}
