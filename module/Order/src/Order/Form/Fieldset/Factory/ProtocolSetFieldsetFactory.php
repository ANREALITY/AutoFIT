<?php
namespace Order\Form\Fieldset\Factory;

use DbSystel\DataObject\ProtocolSet;
use Order\Form\Fieldset\ProtocolSetForProtocolServerSourceFieldset;
use Order\Form\Fieldset\ProtocolSetForProtocolServerTargetFieldset;
use Order\Form\Fieldset\ProtocolSetForSelfServiceFieldset;
use Zend\ServiceManager\Exception\InvalidServiceException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Order\Form\Fieldset\ClusterFieldset;
use DbSystel\DataObject\Cluster;
use Interop\Container\ContainerInterface;

class ProtocolSetFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        switch ($requestedName) {
            case AbstractCommonFieldsetFactory::NAMESPACE_FIELDSET . '\\' . 'ProtocolSetForSelfService':
                $fieldset = new ProtocolSetForSelfServiceFieldset(null, []);
                break;
            case AbstractCommonFieldsetFactory::NAMESPACE_FIELDSET . '\\' . 'ProtocolSetForProtocolServerSource':
                $fieldset = new ProtocolSetForProtocolServerSourceFieldset(null, []);
                break;
            case AbstractCommonFieldsetFactory::NAMESPACE_FIELDSET . '\\' . 'ProtocolSetForProtocolServerTarget':
                $fieldset = new ProtocolSetForProtocolServerTargetFieldset(null, []);
                break;
            default:
                throw new InvalidServiceException('No ProtocolSet Fieldset for the "' . $requestedName . '" found.');
        }
        $hydrator = $container
            ->get('HydratorManager')
            ->get('DbSystel\Hydrator\ProtocolSetHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new ProtocolSet();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
