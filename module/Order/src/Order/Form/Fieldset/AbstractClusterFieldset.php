<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\Adapter\AdapterInterface;

abstract class AbstractClusterFieldset extends Fieldset implements InputFilterProviderInterface
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
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
