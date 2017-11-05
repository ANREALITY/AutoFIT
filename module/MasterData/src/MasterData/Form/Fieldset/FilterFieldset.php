<?php
namespace MasterData\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\ORM\EntityManager;

class FilterFieldset extends Fieldset implements InputFilterProviderInterface
{

    /** @var EntityManager */
    protected $entityManager;

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
                'name' => 'virtual_node_name',
                'type' => 'text',
                'options' => [
                    'label' => _('virtual node name'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control autocomplete-cluster-virtual-node-name'
                ]
            ]);

        $this->add(
            [
                'name' => 'server_name',
                'type' => 'text',
                'options' => [
                    'label' => _('server name'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control autocomplete-server-name'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return $inputFilterSpecification;
    }

}
