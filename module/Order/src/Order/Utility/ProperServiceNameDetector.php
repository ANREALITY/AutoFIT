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

    public function getPhysicalConnectionEndToEndFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $physicalConnectionFieldsetServiceName = 'Order\Form\Fieldset\PhysicalConnection' .
                 $this->routerMatchParams['connectionType'] . 'EndToEnd';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }
        
        return $physicalConnectionFieldsetServiceName;
    }

    public function getphysicalConnectionEndToMiddleFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $physicalConnectionFieldsetServiceName = 'Order\Form\Fieldset\PhysicalConnection' .
                 $this->routerMatchParams['connectionType'] . 'EndToMiddle';
        } else {
            throw new \Exception('No source endpoint type defined!');
        }
        
        return $physicalConnectionFieldsetServiceName;
    }

    public function getPhysicalConnectionMiddleToEndFieldsetServiceName()
    {
        if (! empty($this->routerMatchParams['connectionType'])) {
            $physicalConnectionFieldsetServiceName = 'Order\Form\Fieldset\PhysicalConnection' .
                 $this->routerMatchParams['connectionType'] . 'MiddleToEnd';
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
