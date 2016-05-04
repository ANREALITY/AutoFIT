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

    public function __construct(array $routerMatchParams, array $requestQuery, array $requestPost)
    {
        $this->routerMatchParams = $routerMatchParams;
        $this->requestQuery = $requestQuery;
        $this->requestPost = $requestPost;
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

    public function getConnectionType()
    {
        return ! empty($this->routerMatchParams['connectionType']) ? $this->routerMatchParams['connectionType'] : null;
    }

    public function getEndpointSourceType()
    {
        return ! empty($this->routerMatchParams['endpointSourceType']) ? $this->routerMatchParams['endpointSourceType'] : null;
    }

    public function getEndpointTargetType()
    {
        return ! empty($this->routerMatchParams['endpointTargetType']) ? $this->routerMatchParams['endpointTargetType'] : null;
    }

}
