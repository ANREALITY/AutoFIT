<?php
namespace MasterData\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DbSystel\DataObject\Cluster;
use Order\Service\ClusterService;
use MasterData\Form\ClusterForm;
use DbSystel\DataObject\AuditLog;

class OverviewController extends AbstractActionController
{

    /**
     * 
     * @var ClusterService
     */
    protected $clusterService;

    /**
     * 
     * @var ClusterForm
     */
    protected $clusterForm;

    public function __construct(ClusterService $clusterService)
    {
        $this->clusterService = $clusterService;
    }

    public function showAction()
    {
        $page = $this->params()->fromRoute('page');
        $paginator = $this->clusterService->findAllPaginated(
            [],
            $page
        );

        return new ViewModel([
            'paginator' => $paginator,
            'query' => $this->params()->fromQuery(),
        ]);
    }

    public function createdAction()
    {
        return new ViewModel();
    }

}
