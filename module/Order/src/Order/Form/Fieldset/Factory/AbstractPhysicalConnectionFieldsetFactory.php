<?php
namespace Order\Form\Fieldset\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\AbstractPhysicalConnection;

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
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $canCreateServiceWithName = false;

        $matches = [];
        $pattern = '^(' . preg_quote(self::NAMESPACE_FIELDSET . '\\') . self::NAME_PART_PHYSICAL_CONNECTION .
             '(?<connectionType>Ftgw|Cd)' . '(?<role>EndToEnd|EndToMiddle|MiddleToEnd)' . ')$';
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
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldsetName = str_replace(self::NAMESPACE_FIELDSET . '\\', '', $requestedName);
        $prototypeClassName = preg_replace('/()$/i', '', $fieldsetName);
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;
        $fieldsetQualifiedClassName = $requestedName . self::NAME_PART_FIEDLSET;

        $properServiceNameDetector = $container->get(
            'Order\Utility\ProperServiceNameDetector');

        if (strcasecmp($this->connectionType, LogicalConnection::TYPE_CD) === 0) {
            if (strcasecmp($this->role, str_replace('_', '', AbstractPhysicalConnection::ROLE_END_TO_END)) === 0) {
                $endpointSourceFieldsetServiceName = $properServiceNameDetector->getEndpointSourceFieldsetServiceName();
                $endpointTargetFieldsetServiceName = $properServiceNameDetector->getEndpointTargetFieldsetServiceName();
                $service = new $fieldsetQualifiedClassName(null, [], $endpointSourceFieldsetServiceName,
                    $endpointTargetFieldsetServiceName);
            }
        } elseif (strcasecmp($this->connectionType, LogicalConnection::TYPE_FTGW) === 0) {
            if (strcasecmp($this->role, str_replace('_', '', AbstractPhysicalConnection::ROLE_END_TO_MIDDLE)) === 0) {
                $endpointSourceFieldsetServiceName = $properServiceNameDetector->getEndpointSourceFieldsetServiceName();
                $service = new $fieldsetQualifiedClassName(null, [], $endpointSourceFieldsetServiceName);
            } elseif (strcasecmp($this->role, str_replace('_', '', AbstractPhysicalConnection::ROLE_MIDDLE_TO_END)) === 0) {
                $endpointTargetFieldsetServiceName = $properServiceNameDetector->getEndpointTargetFieldsetServiceName();
                $service = new $fieldsetQualifiedClassName(null, [], $endpointTargetFieldsetServiceName);
            }
        }
        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $service->setHydrator($hydrator);
        $prototype = new $prototypeQualifiedClassName();
        $service->setObject($prototype);

        return $service;
    }

}
