<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class AbstractCommonFieldsetFactory implements AbstractFactoryInterface
{

    const COMMON_FIELDSETS = [
        'Application',
        'Customer',
        'IncludeParameter',
        'Environment',
        'IncludeParameterSet',
        'Notification',
        'ExternalServer',
        'AccessConfig',
        'AccessConfigSet',
        'EndpointClusterConfig',
        'Cluster',
        'EndpointServerConfig',
        'FileParameter',
        'FileParameterSet',
        'ProtocolSetForSelfService',
        'ProtocolSetForProtocolServerSource',
        'ProtocolSetForProtocolServerTarget',
    ];

    /**
     *
     * @var string
     */
    const NAME_PART_FIEDLSET = 'Fieldset';

    /**
     *
     * @var string
     */
    const NAMESPACE_FIELDSET = 'Order\Form\Fieldset';

    /**
     *
     * @var string
     */
    const NAMESPACE_PROTOTYPE = 'DbSystel\DataObject';

    /**
     *
     * @var string
     */
    const NAMESPACE_HYDRATOR = 'DbSystel\Hydrator';

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
        $pattern = '^(' . preg_quote(self::NAMESPACE_FIELDSET . '\\') . '(' . implode('|', self::COMMON_FIELDSETS) . ')' .
             ')$';
        preg_match('/' . $pattern . '/', $requestedName, $matches);

        if (! empty($matches) && class_exists($requestedName . self::NAME_PART_FIEDLSET)) {
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
        $classNameRoot = str_ireplace([self::NAMESPACE_FIELDSET . '\\', 'Source', 'Target'], '', $requestedName);
        $prototypeClassName = $classNameRoot;
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

        $service = new $fieldsetQualifiedClassName();
        $hydratorManager = $serviceLocator->getServiceLocator()->get('HydratorManager');
        try {
            $hydrator = $hydratorManager->get(self::NAMESPACE_HYDRATOR . '\\' . $prototypeClassName . 'Hydrator');
        } catch (ServiceNotFoundException $e) {
            $hydrator = $hydratorManager->get('Zend\Hydrator\ClassMethods');
        }
        $service->setHydrator($hydrator);
        $prototype = new $prototypeQualifiedClassName();
        $service->setObject($prototype);

        if (method_exists($service, 'setDbAdapter')) {
            $dbAdapter = $serviceLocator->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $service->setDbAdapter($dbAdapter);
        }

        return $service;
    }

}
