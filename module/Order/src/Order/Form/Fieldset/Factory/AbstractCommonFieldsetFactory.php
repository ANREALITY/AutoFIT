<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

class AbstractCommonFieldsetFactory implements AbstractFactoryInterface
{

    const COMMON_FIELDSETS = [
        'Application',
        'Customer',
        'IncludeParameter',
        'Environment',
        'IncludeParameterSet',
        'Notification',
        'Server'
    ];

    protected $classNamePartFieldset = 'Fieldset';

    protected $namespaceFieldset = 'Order\Form\Fieldset';

    protected $namespacePrototype = 'DbSystel\DataObject';

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractFactoryInterface::canCreateServiceWithName()
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $canCreateServiceWithName = false;

        $matches = [];
        $pattern = '^(' . preg_quote($this->namespaceFieldset . '\\') . '(' . implode('|', self::COMMON_FIELDSETS) . ')' . ')$';
        preg_match('/' . $pattern . '/', $requestedName, $matches);

        if (!empty($matches) && class_exists($requestedName . 'Fieldset')) {
            $canCreateServiceWithName = true;
        }

        return $canCreateServiceWithName;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractFactoryInterface::createServiceWithName()
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $prototypeClassName = str_replace($this->namespaceFieldset . '\\', '', $requestedName);
        $prototypeQualifiedClassName = $this->namespacePrototype . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . 'Fieldset';

        $fieldset = new $fieldsetQualifiedClassName();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new $prototypeQualifiedClassName();
        $fieldset->setObject($prototype);
        
        return $fieldset;
        
    }

}
