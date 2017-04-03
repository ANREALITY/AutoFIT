<?php
namespace Order\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\LogicalConnection;

class OrderTypeDetector extends AbstractHelper
{

    public function __invoke()
    {
        return $this;
    }
    
    public function detectConnectionType(FileTransferRequest $order)
    {
        $logicalConnection = $order->getLogicalConnection();
        $type = $logicalConnection->getType();
        return $type;
    }

    public function detectEndpointSourceType(FileTransferRequest $order)
    {
        $endpoint = $this->detectEndpointSource($order);
        $type = $endpoint->getType();
        return $type;
    }

    public function detectEndpointTargetType(FileTransferRequest $order)
    {
        $endpoint = $this->detectEndpointTarget($order);
        $type = $endpoint->getType();
        return $type;
    }

    /**
     * @param FileTransferRequest $order
     * @return AbstractEndpoint
     */
    protected function detectEndpointSource(FileTransferRequest $order)
    {
        if (strcasecmp($this->detectConnectionType($order), LogicalConnection::TYPE_CD) === 0) {
            $endpoint = $order->getLogicalConnection()->getPhysicalConnectionEndToEnd()->getEndpointSource();
        } elseif (strcasecmp($this->detectConnectionType($order), LogicalConnection::TYPE_FTGW) === 0) {
            $endpoint = $order->getLogicalConnection()->getPhysicalConnectionEndToMiddle()->getEndpointSource();
        }
        return $endpoint;
    }

    /**
     * @param FileTransferRequest $order
     * @return AbstractEndpoint
     */
    protected function detectEndpointTarget(FileTransferRequest $order)
    {
        if (strcasecmp($this->detectConnectionType($order), LogicalConnection::TYPE_CD) === 0) {
            $endpoint = $order->getLogicalConnection()->getPhysicalConnectionEndToEnd()->getEndpointTarget();
        } elseif (strcasecmp($this->detectConnectionType($order), LogicalConnection::TYPE_FTGW) === 0) {
            $endpoint = $order->getLogicalConnection()->getPhysicalConnectionMiddleToEnd()->getEndpointTarget();
        }
        return $endpoint;
    }

}