<?php
namespace Order\Utility;

class ProperServiceNameDetector
{

    /**
     * @var array
     */
    protected $routerMatchParams;

    public function __construct(array $routerMatchParams)
    {
        $this->routerMatchParams = $routerMatchParams;
    }

    public function getPhysicalConnectionMapperServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $serviceName = 'Order\Mapper\PhysicalConnection' .
                 $this->routerMatchParams['connectionType'] . 'Mapper';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }
        
        return $serviceName;
    }

    public function getEndpointSourceMapperServiceName()
    {
        if (! empty($this->routerMatchParams['endpointSourceType'])) {
            $serviceName = 'Order\Mapper\Endpoint' .
                 $this->routerMatchParams['endpointSourceType'] . 'Mapper';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }
        
        return $serviceName;
    }

    public function getEndpointTargetMapperServiceName()
    {
        if (! empty($this->routerMatchParams['endpointTargetType'])) {
            $serviceName = 'Order\Mapper\Endpoint' .
                 $this->routerMatchParams['endpointTargetType'] . 'Mapper';
        } else {
            throw new \Exception('No target endpoint type defined!');
        }
        
        return $serviceName;
    }

    public function getPhysicalConnectionFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $physicalConnectionFieldsetServiceName = 'Order\Form\Fieldset\PhysicalConnection' .
                 $this->routerMatchParams['connectionType'];
        } else {
            throw new \Exception('No source endpoint type defined!');
        }
        
        return $physicalConnectionFieldsetServiceName;
    }

    public function getEndpointSourceFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['endpointSourceType'])) {
            $serviceName = 'Order\Form\Fieldset\Endpoint' .
                 $this->routerMatchParams['endpointSourceType'] . 'Source';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }
        
        return $serviceName;
    }

    public function getEndpointTargetFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['endpointTargetType'])) {
            $serviceName = 'Order\Form\Fieldset\Endpoint' .
                 $this->routerMatchParams['endpointTargetType'] . 'Target';
        } else {
            throw new \Exception('No target endpoint type defined!');
        }
        
        return $serviceName;
    }

}
