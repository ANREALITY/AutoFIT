<?php
namespace Order\Form\Fieldset;

use Doctrine\ORM\EntityManager;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractClusterFieldset extends Fieldset implements InputFilterProviderInterface
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
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
