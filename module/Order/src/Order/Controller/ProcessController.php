<?php

namespace Order\Controller;

use Order\Form\OrderSearch\OrderSearchForm;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Router\Http\RouteMatch;
use Zend\Router\Http\TreeRouteStack;
use Zend\Stdlib\Parameters;
use Zend\View\Model\ViewModel;
use Zend\Http\Response\Stream;
use Zend\Http\Headers;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataExport\DataExporter;
use Order\Service\FileTransferRequestService;
use DbSystel\DataObject\AuditLog;
use Order\Service\FileTransferRequestServiceInterface;
use Order\Form\OrderForm;
use Zend\Form\FormInterface;

class ProcessController extends AbstractActionController
{

    /**
     * @var FileTransferRequest
     */
    protected $fileTransferRequest;

    /**
     * @var FileTransferRequestServiceInterface
     */
    protected $fileTransferRequestService;

    /**
     * @var OrderForm
     */
    protected $orderForm;

    /**
     * @var string
     */
    protected $connectionType;

    /**
     * @var string
     */
    protected $endpointSourceType;

    /**
     * @var string
     */
    protected $endpointTargetType;

    /**
     * @var DataExporter
     */
    protected $dataExporter;

    /**
     * @var string
     */
    protected $exportFolder;

    /**
     * @var OrderSearchForm
     */
    protected $orderSearchForm;

    public function __construct(FileTransferRequest $fileTransferRequest, FileTransferRequestServiceInterface $fileTransferRequestService)
    {
        $this->fileTransferRequest = $fileTransferRequest;
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    /**
     * @param FormInterface $orderForm
     */
    public function setOrderForm(FormInterface $orderForm)
    {
        $this->orderForm = $orderForm;
    }

    /**
     * @param string $connectionType
     */
    public function setConnectionType($connectionType)
    {
        $this->connectionType = $connectionType;
    }

    /**
     * @param string $endpointSourceType
     */
    public function setEndpointSourceType($endpointSourceType)
    {
        $this->endpointSourceType = $endpointSourceType;
    }

    /**
     * @param string $endpointTargetType
     */
    public function setEndpointTargetType($endpointTargetType)
    {
        $this->endpointTargetType = $endpointTargetType;
    }

    /**
     * @param DataExporter $dataExporter
     */
    public function setDataExporter(DataExporter $dataExporter)
    {
        $this->dataExporter = $dataExporter;
    }

    /**
     * @param string $exportFolder
     */
    public function setExportFolder(string $exportFolder)
    {
        $this->exportFolder = $exportFolder;
    }

    /**
     * @param FormInterface $orderSearchForm
     */
    public function setOrderSearchForm(FormInterface $orderSearchForm)
    {
        $this->orderSearchForm = $orderSearchForm;
    }

    public function startAction()
    {
        return [
            'connectionType' => $this->connectionType
        ];
    }

    public function createAction()
    {
        if ($this->IsInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        $this->orderForm->bind($this->fileTransferRequest);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->orderForm->setData($request->getPost());
            if ($this->orderForm->isValid()) {
                $username = $this->IdentityParam('username');
                $this->fileTransferRequest->getUser()->setUsername($username);
                $role = $this->IdentityParam('role');
                $this->fileTransferRequest->getUser()->setRole($role);
                if(isset($request->getPost()->toArray()['submit'])) {
                    $status = FileTransferRequest::STATUS_PENDING;
                    $successAction = 'submitted';
                } else {
                    $status = FileTransferRequest::STATUS_EDIT;
                    $successAction = 'saved';
                }
                $this->fileTransferRequest->setStatus($status);
                $this->fileTransferRequest = $this->fileTransferRequestService->saveOne($this->fileTransferRequest);
                $this->AuditLogger()->log(AuditLog::RESSOURCE_TYPE_ORDER, $this->fileTransferRequest->getId(), AuditLog::ACTION_ORDER_CREATED);
                if ($this->fileTransferRequest->getStatus() === FileTransferRequest::STATUS_PENDING) {
                    $this->AuditLogger()->log(AuditLog::RESSOURCE_TYPE_ORDER, $this->fileTransferRequest->getId(), AuditLog::ACTION_ORDER_SUBMITTED);
                }
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => $successAction
                    ]);
            }
        }

        return [
            'form' => $this->orderForm,
            'connectionType' => $this->connectionType,
            'endpointSourceType' => $this->endpointSourceType,
            'endpointTargetType' => $this->endpointTargetType
        ];
    }

    public function startEditingAction()
    {
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_EDIT,
                'confirmationAction' => 'editingStarted',
                'auditLogAction' => AuditLog::ACTION_ORDER_EDITING_STARTED
            ]);
    }

    public function editAction()
    {
        if ($this->IsInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        if (! $this->OrderStatusChecker()->isAllowedOperationForStatus('edit', $this->fileTransferRequest->getStatus())) {
            return $this->redirect()->toRoute('order/operation-denied-for-status',
                [
                    'operation' => 'edit',
                    'status' => $this->fileTransferRequest->getStatus()
                ]);
        }

        $this->orderForm->bind($this->fileTransferRequest);

        $request = $this->getRequest();

        $getHelperFieldsValuesFromObject = true;

        if ($request->isPost()) {
            $getHelperFieldsValuesFromObject = false;
            $this->orderForm->setData($request->getPost());
            if ($this->orderForm->isValid()) {
                $username = $this->IdentityParam('username');
                $this->fileTransferRequest->getUser()->setUsername($username);
                $role = $this->IdentityParam('role');
                $this->fileTransferRequest->getUser()->setRole($role);
                if(isset($request->getPost()->toArray()['submit'])) {
                    $status = FileTransferRequest::STATUS_PENDING;
                    $successAction = 'submitted';
                } else {
                    $status = FileTransferRequest::STATUS_EDIT;
                    $successAction = 'updated';
                }
                $this->fileTransferRequest->setStatus($status);
                $this->fileTransferRequest = $this->fileTransferRequestService->saveOne($this->fileTransferRequest);
                $this->AuditLogger()->log(AuditLog::RESSOURCE_TYPE_ORDER, $this->fileTransferRequest->getId(), AuditLog::ACTION_ORDER_UPDATED);
                if ($this->fileTransferRequest->getStatus() === FileTransferRequest::STATUS_PENDING) {
                    $this->AuditLogger()->log(AuditLog::RESSOURCE_TYPE_ORDER, $this->fileTransferRequest->getId(), AuditLog::ACTION_ORDER_SUBMITTED);
                }
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => $successAction
                    ]);
            }
        }

        $id = $this->params()->fromRoute('id', null);
        $fileTransferRequest = $this->fileTransferRequestService->findOne($id);

        return [
            'form' => $this->orderForm,
            'connectionType' => $this->connectionType,
            'endpointSourceType' => $this->endpointSourceType,
            'endpointTargetType' => $this->endpointTargetType,
            'fileTransferRequest' => $this->fileTransferRequest,
            'getHelperFieldsValuesFromObject' => $getHelperFieldsValuesFromObject
        ];
    }

    public function submitAction()
    {
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_PENDING,
                'confirmationAction' => 'submitted',
                'auditLogAction' => AuditLog::ACTION_ORDER_SUBMITTED
            ]);
    }

    public function cancelAction()
    {
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_CANCELED,
                'confirmationAction' => 'canceled',
                'auditLogAction' => AuditLog::ACTION_ORDER_CANCELED
            ]);
    }

    public function acceptAction()
    {
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_ACCEPTED,
                'confirmationAction' => 'accepted',
                'auditLogAction' => AuditLog::ACTION_ORDER_ACCEPTED
            ]);
    }

    public function declineAction()
    {
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_DECLINED,
                'confirmationAction' => 'declined',
                'auditLogAction' => AuditLog::ACTION_ORDER_DECLINED
            ]);
    }

    public function startCheckingAction()
    {
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_CHECK,
                'confirmationAction' => 'checkingStarted',
                'auditLogAction' => AuditLog::ACTION_ORDER_CHECKING_STARTED
            ]);
    }

    public function completeAction()
    {
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_COMPLETED,
                'confirmationAction' => 'completed',
                'auditLogAction' => AuditLog::ACTION_ORDER_COMPLETED
            ]);
    }

    public function updateStatusAction()
    {
        if ($this->IsInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        $operation = $this->params('operation');
        $status = $this->params('status');
        $confirmationAction = $this->params('confirmationAction');

        if (! $this->OrderStatusChecker()->isAllowedOperationForStatus($operation,
            $this->fileTransferRequest->getStatus())) {
            return $this->redirect()->toRoute('order/operation-denied-for-status',
                [
                    'operation' => $operation,
                    'status' => $this->fileTransferRequest->getStatus()
                ]);
        }

        $this->fileTransferRequest->setStatus($status);
        $this->fileTransferRequestService->saveOne($this->fileTransferRequest);

        if ($this->params('auditLogAction')) {
            $this->AuditLogger()->log(AuditLog::RESSOURCE_TYPE_ORDER, $this->fileTransferRequest->getId(), $this->params('auditLogAction'));
        }

        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => $confirmationAction
            ]);
    }

    public function savedAction()
    {
        return new ViewModel();
    }

    public function editingStartedAction()
    {
        return new ViewModel();
    }

    public function updatedAction()
    {
        return new ViewModel();
    }

    public function submittedAction()
    {
        return new ViewModel();
    }

    public function canceledAction()
    {
        return new ViewModel();
    }

    public function acceptedAction()
    {
        return new ViewModel();
    }

    public function declinedAction()
    {
        return new ViewModel();
    }

    public function checkingStartedAction()
    {
        return new ViewModel();
    }

    public function completedAction()
    {
        return new ViewModel();
    }

    public function showOrderAction()
    {
        $id = $this->params()->fromRoute('id', null);
        try {
            $fileTransferRequest = $this->fileTransferRequestService->findOne($id);
        } catch (\InvalidArgumentException $exception) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return;
        }

        return new ViewModel([
            'fileTransferRequest' => $fileTransferRequest,
            'userId' => $this->IdentityParam('id'),
            'userRole' => $this->IdentityParam('role'),
        ]);
    }

    public function listMyOrdersAction()
    {
        $page = $this->params()->fromQuery('submit') === null ? $this->params()->fromRoute('page') : 1;
        $criteria = is_array($this->params()->fromQuery('filter')) ? $this->params()->fromQuery('filter') : [];
        $criteria['username'] = $this->IdentityParam('username');
        $criteria['environment_severity'] = isset($criteria['environment']['severity'])
            ? $criteria['environment']['severity']
            : null
        ;
        unset($criteria['environment']);
        $criteria['server_name'] = isset($criteria['server']['name'])
            ? $criteria['server']['name']
            : null
        ;
        unset($criteria['server']);
        $sorting = is_array($this->params()->fromQuery('sort')) ? $this->params()->fromQuery('sort') : [];
        $paginator = $this->fileTransferRequestService->findAll($criteria, $page, $sorting);

        $this->orderSearchForm->setData($this->getRequest()->getQuery());

        $queryParams = $this->params()->fromQuery();
        unset($queryParams['submit']);
        $queryParams['filter']['username'] = $this->IdentityParam('username');

        return new ViewModel([
            'userId' => $this->IdentityParam('id'),
            'userRole' => $this->IdentityParam('role'),
            'paginator' => $paginator,
            'query' => $queryParams,
            'form' => $this->orderSearchForm,
        ]);
    }

    public function listOrdersAction()
    {
        $page = $this->params()->fromQuery('submit') === null ? $this->params()->fromRoute('page') : 1;
        $criteria = is_array($this->params()->fromQuery('filter')) ? $this->params()->fromQuery('filter') : [];
        $criteria['environment_severity'] = isset($criteria['environment']['severity'])
            ? $criteria['environment']['severity']
            : null
        ;
        unset($criteria['environment']);
        $criteria['server_name'] = isset($criteria['server']['name'])
            ? $criteria['server']['name']
            : null
        ;
        unset($criteria['server']);
        $sorting = is_array($this->params()->fromQuery('sort')) ? $this->params()->fromQuery('sort') : [];
        $paginator = $this->fileTransferRequestService->findAll($criteria, $page, $sorting);

        $this->orderSearchForm->setData($this->getRequest()->getQuery());

        $queryParams = $this->params()->fromQuery();
        unset($queryParams['submit']);

        return new ViewModel([
            'userId' => $this->IdentityParam('id'),
            'userRole' => $this->IdentityParam('role'),
            'paginator' => $paginator,
            'query' => $queryParams,
            'form' => $this->orderSearchForm,
        ]);
    }

    public function syncInProgressAction()
    {
        return new ViewModel();
    }

    public function operationDeniedForStatusAction()
    {
        $operation = $this->params()->fromRoute('operation');
        $status = $this->params()->fromRoute('status');
        return new ViewModel(
            [
                'operation' => $this->params()->fromRoute('operation'),
                'status' => $this->params()->fromRoute('status')
            ]);
    }

    public function exportOrderAction()
    {
        $id = $this->params()->fromRoute('id', null);
        $format = $this->params()->fromQuery('format', null);
        $fileTransferRequest = $this->fileTransferRequestService->findOne($id);

        $folder = $this->exportFolder;
        $response = $this->performExport($fileTransferRequest, $id, $format, $folder);

        $this->AuditLogger()->log(AuditLog::RESSOURCE_TYPE_ORDER, $fileTransferRequest->getId(), AuditLog::ACTION_ORDER_EXPORTED);

        return $response;
    }

    protected function performExport(FileTransferRequest $fileTransferRequest, $id, $format, $folder)
    {
        $exportResult = $format === DataExporter::EXPORT_FORMAT_JSON
            ? $this->dataExporter->exportToJson($fileTransferRequest)
            : $this->dataExporter->exportToXml($fileTransferRequest)
        ;
        $fileName = $folder . '/' . 'order_' . $id . '.' . $format;
        $file = fopen($fileName, 'w');
        fwrite($file, $exportResult);
        $file = fopen($fileName, 'r');
        $response = new Stream();
        $response->setStream($file);
        $response->setStatusCode(200);
        $response->setStreamName(basename($fileName));

        $headers = new Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($fileName) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($fileName)
        ));
        $response->setHeaders($headers);

        return $response;
    }

}
