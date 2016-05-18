<?php
namespace Authorization\Acl\Resource;

use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Mvc\Router\Http\RouteMatch;

class ParametrizedResource extends GenericResource
{

    /**
     * @var array Params. Here the RouteMatch#params.
     * @see RouteMatch
     */
    protected $params;

    public function __construct($resourceId, array $params = [])
    {
        parent::__construct($resourceId);
        $this->setParams($params);
    }

    /**
     *
     * @return the $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     *
     * @param multitype: $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

}
