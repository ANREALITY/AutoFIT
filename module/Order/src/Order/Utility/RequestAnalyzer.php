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

    public function __construct(array $routerMatchParams, array $requestQuery, array $requestPost,
        string $orderControllerName = null, string $orderEditActionName = null)
    {
        $this->routerMatchParams = $routerMatchParams;
        $this->requestQuery = $requestQuery;
        $this->requestPost = $requestPost;
        $this->orderControllerName = 'Order\Controller\Process';
        $this->orderEditActionName = 'edit';
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

        $allParamsCorrectForOrderEdit = count(array_intersect($paramsIdentifyingEditRequest, $this->routerMatchParams)) ===
             count($paramsIdentifyingEditRequest);

        return $allParamsCorrectForOrderEdit;
    }

}
