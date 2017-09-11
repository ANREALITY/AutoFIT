<?php
namespace Order\Mapper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractMapperFactory implements AbstractFactoryInterface
{

    /**
     *
     * @var string
     */
    const NAME_PART_MAPPER = 'Mapper';

    /**
     *
     * @var string
     */
    const NAMESPACE_MAPPER = 'Order\Mapper';

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
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $canCreateServiceWithName = false;

        $matches = [];
        $pattern = '[a-zA-z0-9]+' . self::NAME_PART_MAPPER . '$';
        preg_match('/' . $pattern . '/', $requestedName, $matches);

        if (! empty($matches[0]) && $matches[0] === $requestedName &&
             strpos($requestedName, self::NAMESPACE_MAPPER) === 0 && class_exists($requestedName)) {
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
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $service = new $requestedName(
            $container->get('Zend\Db\Adapter\Adapter'),
            null,
            $entityManager
        );

        return $service;
    }

}
