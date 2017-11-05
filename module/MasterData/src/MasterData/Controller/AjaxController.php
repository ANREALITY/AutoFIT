<?php
namespace MasterData\Controller;

use Order\Service\ClusterServiceInterface;
use Order\Service\ServerServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class AjaxController extends AbstractActionController
{

    /**
     *
     * @var ServerServiceInterface
     */
    protected $serverService;

    /**
     *
     * @var ClusterServiceInterface
     */
    protected $clusterService;

    public function __construct(
        ServerServiceInterface $serverService,
        ClusterServiceInterface $clusterService
    ) {
        $this->serverService = $serverService;
        $this->clusterService = $clusterService;
    }

    public function provideClustersAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $data['virtual_node_name'] = isset($data['virtual_node_name']) ? $data['virtual_node_name'] : null;
            $dataList = $this->clusterService->findAllForAutocomplete($data['virtual_node_name']);
        } else {
            $dataList = [];
        }

        return new JsonModel($dataList);
    }

    public function provideServersAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $dataList = $this->serverService->findAllHavingClusterForAutocomplete($data['name']);
            $dataList = array_column($dataList, 'name');
        }

        return new JsonModel($dataList);
    }

}
