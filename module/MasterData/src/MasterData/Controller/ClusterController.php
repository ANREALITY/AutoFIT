<?php
namespace MasterData\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DbSystel\DataObject\Cluster;
use Order\Service\ClusterService;
use MasterData\Form\ClusterForm;
use DbSystel\DataObject\AuditLog;

class ClusterController extends AbstractActionController
{

    /**
     *
     * @var Cluster
     */
    protected $cluster;

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

    public function __construct(Cluster $cluster, ClusterService $clusterService)
    {
        $this->cluster = $cluster;
        $this->clusterService = $clusterService;
    }

    /**
     *
     * @param FormInterface $clusterForm
     */
    public function setClusterForm($clusterForm)
    {
        $this->clusterForm = $clusterForm;
    }

    public function createAction()
    {
        if ($this->IsInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        $this->clusterForm->bind($this->cluster);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->clusterForm->setData($request->getPost());
            if ($this->clusterForm->isValid()) {
                $this->cluster = $this->clusterService->saveOne($this->cluster);
                $this->AuditLogger()->log(AuditLog::RESSOURCE_TYPE_CLUSTER, $this->cluster->getId(), AuditLog::ACTION_CLUSTER_CREATED);
                return $this->forward()->dispatch('MasterData\Controller\Cluster',
                    [
                        'action' => 'created'
                    ]);
            }
        }

        return [
            'form' => $this->clusterForm
        ];
    }

    public function createdAction()
    {
        return new ViewModel();
    }

}
