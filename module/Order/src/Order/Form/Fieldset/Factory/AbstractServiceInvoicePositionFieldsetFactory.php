<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

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
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $fieldsetName = str_replace(self::NAMESPACE_FIELDSET . '\\', '', $requestedName);
        $prototypeClassName = preg_replace('/(Basic|Personal)$/i', '', $fieldsetName);
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

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
