<?php
namespace Order\View\Helper;

use Zend\View\Helper\AbstractHelper;

class OrderStatusChecker extends AbstractHelper
{

    protected $orderStatusConfig;

    public function __construct(array $orderStatusConfig = [])
    {
        $this->orderStatusConfig = $orderStatusConfig;
    }

    public function isAllowedOperationForStatus($operation, $status)
    {
        $isAllowed =
            isset($this->orderStatusConfig['per_operation'][$operation])
            && is_array($this->orderStatusConfig['per_operation'][$operation])
            && in_array($status, $this->orderStatusConfig['per_operation'][$operation])
        ;
        return $isAllowed;
    }

}