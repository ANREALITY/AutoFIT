<?php

namespace AuditLogging\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AuditLogging\Service\AuditLogServiceInterface;

class IndexController extends AbstractActionController
{

    /**
     * @var AuditLogServiceInterface
     */
    protected $auditLogService;

    public function __construct(AuditLogServiceInterface $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    public function listAction()
    {
        $page = $this->params()->fromRoute('page');
        $paginator = $this->auditLogService->findAllWithBuldledData([], null, $page);

        return new ViewModel([
            'paginator' => $paginator,
        ]);
    }

}

