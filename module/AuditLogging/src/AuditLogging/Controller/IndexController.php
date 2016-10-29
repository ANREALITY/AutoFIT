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
        $page = $this->params()->fromRoute('page');
        $criteria = is_array($this->params()->fromQuery('filter')) ? $this->params()->fromQuery('filter') : [];
        $sorting = is_array($this->params()->fromQuery('sort')) ? $this->params()->fromQuery('sort') : [];
        $paginator = $this->auditLogService->findAllWithBuldledData($criteria, null, $page, null, $sorting);

        $this->auditLogForm->setData($this->getRequest()->getQuery());

        return new ViewModel([
            'paginator' => $paginator,
            'query' => $this->params()->fromQuery(),
            'form' => $this->auditLogForm
        ]);
    }

}

