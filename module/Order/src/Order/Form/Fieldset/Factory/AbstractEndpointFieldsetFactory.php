<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class AbstractEndpointFieldsetFactory implements AbstractFactoryInterface
{

    /**
     *
     * @var string
     */
    const NAME_PART_FIEDLSET = 'Fieldset';

    /**
     *
     * @var string
     */
    const NAME_PART_ENDPOINT = 'Endpoint';

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
        $pattern = '^(' . preg_quote(self::NAMESPACE_FIELDSET . '\\') . self::NAME_PART_ENDPOINT . '[a-zA-Z0-9]*' .
             '(Source|Target)' . ')$';
        preg_match('/' . $pattern . '/i', $requestedName, $matches);

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
        $fieldsetName = str_replace(self::NAMESPACE_FIELDSET . '\\', '', $requestedName);
        $prototypeClassName = preg_replace('/(Source|Target)$/i', '', $fieldsetName);
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

        $service = new $fieldsetQualifiedClassName();
        $hydratorManager = $container->getServiceLocator()->get('HydratorManager');
        try {
            $hydrator = $hydratorManager->get(self::NAMESPACE_HYDRATOR . '\\' . $prototypeClassName . 'Hydrator');
        } catch (ServiceNotFoundException $e) {
            $hydrator = $hydratorManager->get('Zend\Hydrator\ClassMethods');
        }
        $service->setHydrator($hydrator);
        $prototype = new $prototypeQualifiedClassName();
        $service->setObject($prototype);

        return $service;
    }

}
