<?php
namespace Order\Utility;

class RequestAnalyzer
{

    /**
     *
     * @var array
     */
    protected $routerMatchParams;

    /**
     *
     * @var array
     */
    protected $requestQuery;

    /**
     *
     * @var array
     */
    protected $requestPost;

    /**
     *
     * @var string
     */
    protected $orderControllerName;

    /**
     *
     * @var string
     */
    protected $orderEditActionName;

    /**
     *
     * @var string
     */
    protected $orderStatusChangingActions;

    public function __construct(array $routerMatchParams, array $requestQuery, array $requestPost,
        string $orderControllerName = null, string $orderEditActionName = null, array $orderStatusChangingActions = [])
    {
        $this->routerMatchParams = $routerMatchParams;
        $this->requestQuery = $requestQuery;
        $this->requestPost = $requestPost;
        $this->orderControllerName = $orderControllerName;
        $this->orderEditActionName = $orderEditActionName;
        $this->orderStatusChangingActions = $orderStatusChangingActions;
    }

    public function isStartRequest()
    {
        $paramsNeededForStart = [
            'connectionType'
        ];

        $allParamsForStartGiven = count(array_intersect($paramsNeededForStart, array_keys($this->routerMatchParams))) ===
             count($paramsNeededForStart);

        return $allParamsForStartGiven;
    }

    public function isOrderRequest()
    {
        $paramsNeededForOrderForm = [
            'connectionType',
            'endpointSourceType',
            'endpointTargetType'
        ];

        $allParamsForOrderFormGiven = count(
            array_intersect($paramsNeededForOrderForm, array_keys($this->routerMatchParams))) ===
             count($paramsNeededForOrderForm);

        return $allParamsForOrderFormGiven;
    }

    public function isOrderEditRequest()
    {
        $paramsIdentifyingEditRequest = [
            'controller' => $this->orderControllerName,
            'action' => $this->orderEditActionName
        ];

        $allParamsCorrectForOrderEdit = count(array_intersect_assoc($paramsIdentifyingEditRequest, $this->routerMatchParams)) ===
             count($paramsIdentifyingEditRequest);

        return $allParamsCorrectForOrderEdit;
    }

    public function isOrderStatusChangingRequest()
    {
        $allParamsCorrectForOrderCancel = false;

        if (isset($this->routerMatchParams['controller']) && isset($this->routerMatchParams['action'])
            && $this->routerMatchParams['controller'] === $this->orderControllerName
            && in_array($this->routerMatchParams['action'], $this->orderStatusChangingActions)) {
            $allParamsCorrectForOrderCancel = true;
        }

        return $allParamsCorrectForOrderCancel;
    }

    public function isRestoreRequest()
    {
        $isRestoreRequest =
            $this->isOrderRequest()
            && ! empty($this->requestQuery['restore'])
        ;
        return $isRestoreRequest;
    }

}
