<?php
namespace Order\Form\Fieldset\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractServiceInvoicePositionFieldsetFactory implements AbstractFactoryInterface
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
    const NAME_PART_SERVICE_INVOICE_POSITION = 'ServiceInvoicePosition';

    /**
     *
     * @var string
     */
    const NAMESPACE_FIELDSET = 'Order\Form\Fieldset';

    /**
     *
     * @var string
     */
    const NAMESPACE_PROTOTYPE = 'Base\DataObject';

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
        $pattern = '^(' . preg_quote(self::NAMESPACE_FIELDSET . '\\') . self::NAME_PART_SERVICE_INVOICE_POSITION .
             '[a-zA-Z0-9]*' . '(Basic|Personal)' . ')$';
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
        $prototypeClassName = $fieldsetName;
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

        $service = new $fieldsetQualifiedClassName();
        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $service->setHydrator($hydrator);
        $prototype = new $prototypeQualifiedClassName();
        $service->setObject($prototype);

        return $service;
    }

}
