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

}
