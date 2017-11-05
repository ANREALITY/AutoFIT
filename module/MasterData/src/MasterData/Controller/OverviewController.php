<?php
namespace MasterData\Controller;

use MasterData\Form\ClusterForm;
use MasterData\Form\SearchForm;
use Order\Service\ClusterService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OverviewController extends AbstractActionController
{

    /**
     * 
     * @var ClusterService
     */
    protected $clusterService;

    /**
     * @var SearchForm
     */
    protected $searchForm;

    /**
     * 
     * @var ClusterForm
     */
    protected $clusterForm;

    public function __construct(ClusterService $clusterService)
    {
        $this->clusterService = $clusterService;
    }

    /**
     * @param FormInterface $searchForm
     */
    public function setSearchForm(FormInterface $searchForm)
    {
        $this->searchForm = $searchForm;
    }

    public function showAction()
    {
        $page = $this->params()->fromRoute('page');
        $criteria = is_array($this->params()->fromQuery('filter')) ? $this->params()->fromQuery('filter') : [];
        $paginator = $this->clusterService->findAllPaginated(
            $criteria,
            $page
        );

        $this->searchForm->setData($this->getRequest()->getQuery());

        return new ViewModel([
            'paginator' => $paginator,
            'query' => $this->params()->fromQuery(),
            'form' => $this->searchForm,
        ]);
    }

    public function createdAction()
    {
        return new ViewModel();
    }

}
