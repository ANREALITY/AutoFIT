<?php

namespace AuditLogging\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AuditLogging\Service\AuditLogServiceInterface;
use Zend\Form\FormInterface;

class IndexController extends AbstractActionController
{

    /**
     * @var AuditLogForm
     */
    protected $auditLogForm;

    /**
     * @var AuditLogServiceInterface
     */
    protected $auditLogService;

    public function __construct(AuditLogServiceInterface $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    /**
     * @param FormInterface $auditLogForm
     */
    public function setAuditLogForm(FormInterface $auditLogForm)
    {
        $this->auditLogForm = $auditLogForm;
    }

    public function listAction()
    {
        $page = $this->params()->fromQuery('submit') === null ? $this->params()->fromRoute('page') : 1;
        $criteria = is_array($this->params()->fromQuery('filter')) ? $this->params()->fromQuery('filter') : [];
        $sorting = is_array($this->params()->fromQuery('sort')) ? $this->params()->fromQuery('sort') : [];
        $paginator = $this->auditLogService->findAll($criteria, $page, $sorting);

        $this->auditLogForm->setData($this->getRequest()->getQuery());

        $queryParams = $this->params()->fromQuery();
        unset($queryParams['submit']);

        return new ViewModel([
            'paginator' => $paginator,
            'query' => $queryParams,
            'form' => $this->auditLogForm
        ]);
    }

}

