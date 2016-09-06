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
        'ExternalServer',
        'AccessConfig',
        'AccessConfigSet',
        'EndpointClusterConfig',
        'Cluster',
        'EndpointServerConfig',
        'FileParameter',
        'FileParameterSet',
        'Protocol',
        'ProtocolSet',
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
        $prototypeClassName = str_replace(self::NAMESPACE_FIELDSET . '\\', '', $requestedName);
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

        $service = new $fieldsetQualifiedClassName();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
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
