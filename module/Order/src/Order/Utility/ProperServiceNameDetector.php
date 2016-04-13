<?php
namespace Order\Utility;

class ProperServiceNameDetector
{

    /**
     *
     * @var array
     */
    protected $routerMatchParams;

    public function __construct(array $routerMatchParams)
    {
        $this->routerMatchParams = $routerMatchParams;
    }

    public function getLogicalConnectionMapperServiceName()
    {
        return 'Order\Mapper\LogicalConnectionMapper';
    }

    public function getPhysicalConnectionMapperServiceName()
    {
        return 'Order\Mapper\PhysicalConnectionMapper';
    }

    public function getEndpointSourceMapperServiceName()
    {
        return 'Order\Mapper\EndpointMapper';
    }

    public function getEndpointTargetMapperServiceName()
    {
        return 'Order\Mapper\EndpointMapper';
    }

    public function getPhysicalConnectionSourceFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $physicalConnectionFieldsetServiceName = 'Order\Form\Fieldset\PhysicalConnection' .
                 $this->routerMatchParams['connectionType'] . 'Source';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }

        return $physicalConnectionFieldsetServiceName;
    }

    public function getPhysicalConnectionTargetFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $physicalConnectionFieldsetServiceName = 'Order\Form\Fieldset\PhysicalConnection' .
                 $this->routerMatchParams['connectionType'] . 'Target';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }

        return $physicalConnectionFieldsetServiceName;
    }

    public function getEndpointSourceFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['endpointSourceType'])) {
            $serviceName = 'Order\Form\Fieldset\Endpoint' . $this->routerMatchParams['endpointSourceType'] . 'Source';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }

        return $serviceName;
    }

    public function getEndpointTargetFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['endpointTargetType'])) {
            $serviceName = 'Order\Form\Fieldset\Endpoint' . $this->routerMatchParams['endpointTargetType'] . 'Target';
        } else {
            throw new \Exception('No target endpoint type defined!');
        }

        return $serviceName;
    }

    public function getFileTransferRequestFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $serviceName = 'Order\Form\Fieldset\FileTransferRequest' . $this->routerMatchParams['connectionType'];
        } else {
            throw new \Exception('No connection type defined!');
        }

        return $serviceName;
    }

}
