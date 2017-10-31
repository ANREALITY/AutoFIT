<?php
namespace Order\Form\Fieldset\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

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
//        'ProtocolSetForSelfService',
//        'ProtocolSetForProtocolServerSource',
//        'ProtocolSetForProtocolServerTarget',
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
    public function canCreate(ContainerInterface $container, $requestedName)
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
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $classNameRoot = str_ireplace([self::NAMESPACE_FIELDSET . '\\', 'Source', 'Target'], '', $requestedName);
        $prototypeClassName = $classNameRoot;
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;

        if (
            strpos($prototypeClassName, 'ProtocolSetForProtocolServer') !== false
            || strpos($prototypeClassName, 'ProtocolSetForSelfService') !== false
        ) {
            $prototypeClassName = 'ProtocolSet';
        }

        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

        $service = new $fieldsetQualifiedClassName();
        $hydratorManager = $container->get('HydratorManager');
        try {
            $hydrator = $hydratorManager->get(self::NAMESPACE_HYDRATOR . '\\' . $prototypeClassName . 'Hydrator');
        } catch (ServiceNotFoundException $e) {
            $hydrator = $hydratorManager->get('Zend\Hydrator\ClassMethods');
        }
        $service->setHydrator($hydrator);
        $prototype = new $prototypeQualifiedClassName();
        $service->setObject($prototype);

        if (method_exists($service, 'setEntityManager')) {
            $entityManager = $container->get('doctrine.entitymanager.orm_default');
            $service->setEntityManager($entityManager);
        }

        return $service;
    }

}
