<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\Server;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\ObjectExists;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractServerFieldset extends Fieldset implements InputFilterProviderInterface
{

    /** @var EntityManager */
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
                        'name' => ObjectExists::class,
                        'options' => [
                            'object_repository' => $this->entityManager->getRepository(Server::class),
                            'fields' => ['name']
                        ]
                    ]
                ]
            ]
        ];
    }

}
