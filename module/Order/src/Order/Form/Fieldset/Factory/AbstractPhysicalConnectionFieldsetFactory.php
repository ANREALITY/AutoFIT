<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\AbstractEndpoint;

class AbstractPhysicalConnectionFieldsetFactory implements AbstractFactoryInterface
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
    const NAME_PART_PHYSICAL_CONNECTION = 'PhysicalConnection';

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
    protected $connectionType;

    /**
     *
     * @var string
     */
    protected $role;

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
        $pattern = '^(' . preg_quote(self::NAMESPACE_FIELDSET . '\\') . self::NAME_PART_PHYSICAL_CONNECTION .
             '(?<connectionType>Ftgw|Cd)' . '(?<role>Source|Target)' . ')$';
        preg_match('/' . $pattern . '/i', $requestedName, $matches);

        if (! empty($matches['connectionType']) && ! empty($matches['role']) &&
             class_exists($requestedName . self::NAME_PART_FIEDLSET)) {
            $this->connectionType = $matches['connectionType'];
            $this->role = $matches['role'];
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
        $prototypeClassName = preg_replace('/(Source|Target)$/i', '', $fieldsetName);
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

        $properServiceNameDetector = $serviceLocator->getServiceLocator()->get(
            'Order\Utility\ProperServiceNameDetector');

        if (strcasecmp($this->connectionType, LogicalConnection::TYPE_CD) === 0) {
            $endpointSourceFieldsetServiceName = $properServiceNameDetector->getEndpointSourceFieldsetServiceName();
            $endpointTargetFieldsetServiceName = $properServiceNameDetector->getEndpointTargetFieldsetServiceName();
            $fieldset = new $fieldsetQualifiedClassName(null, [], $endpointSourceFieldsetServiceName,
                $endpointTargetFieldsetServiceName);
        } elseif (strcasecmp($this->connectionType, LogicalConnection::TYPE_FTGW) === 0) {
            if (strcasecmp($this->role, AbstractEndpoint::ROLE_SOURCE) === 0) {
                $endpointSourceFieldsetServiceName = $properServiceNameDetector->getEndpointSourceFieldsetServiceName();
                $fieldset = new $fieldsetQualifiedClassName(null, [], $endpointSourceFieldsetServiceName);
            } elseif (strcasecmp($this->role, AbstractEndpoint::ROLE_TARGET) === 0) {
                $endpointTargetFieldsetServiceName = $properServiceNameDetector->getEndpointTargetFieldsetServiceName();
                $fieldset = new $fieldsetQualifiedClassName(null, [], $endpointTargetFieldsetServiceName);
            }
        }
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new $prototypeQualifiedClassName();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
