<?php

namespace Order\Controller;

use Base\DataObject\Draft;
use Base\DataObject\LogicalConnection;
use Order\Form\OrderSearch\OrderSearchForm;
use Order\Service\DraftServiceInterface;
use Order\Service\UserServiceInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Router\Http\RouteMatch;
use Zend\Router\Http\TreeRouteStack;
use Zend\Stdlib\Parameters;
use Zend\View\Model\ViewModel;
use Zend\Http\Response\Stream;
use Zend\Http\Headers;
use Base\DataObject\FileTransferRequest;
use Base\DataExport\DataExporter;
use Order\Service\FileTransferRequestService;
use Base\DataObject\AuditLog;
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
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * @var DraftServiceInterface
     */
    protected $draftService;

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

    public function __construct(
        FileTransferRequest $fileTransferRequest,
        FileTransferRequestServiceInterface $fileTransferRequestService,
        UserServiceInterface $userService,
        DraftServiceInterface $draftService
    ) {
        $this->fileTransferRequest = $fileTransferRequest;
        $this->fileTransferRequestService = $fileTransferRequestService;
        $this->userService = $userService;
        $this->draftService = $draftService;
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

    public function restoreAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $username = $this->IdentityParam('username');
        $currentUser = $this->userService->findOneByUsername($username);
        $draft = $this->draftService->findOneByUser($currentUser);
        if ($draft) {
            return $this->redirect()->toRoute('order/create', [
                'connectionType' => strtolower($draft->getConnectionType()),
                'endpointSourceType' => strtolower($draft->getEndpointSourceType()),
                'endpointTargetType' => strtolower($draft->getEndpointTargetType()),
                'restore' => 1
            ]);
        } else {
            $successAction = 'no-draft-available';
            return $this->forward()->dispatch('Order\Controller\Process',
                [
                    'action' => $successAction
                ]);
        }
    }

    public function createAction()
    {
        if ($this->IsInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        $this->orderForm->bind($this->fileTransferRequest);

        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->orderForm->setData($request->getPost());
            if(isset($request->getPost()->toArray()['store'])) {
                $formDataArray = $request->getPost()->toArray();
                unset($formDataArray['file_transfer_request']['id']);
                $formDataJson = json_encode($formDataArray, JSON_UNESCAPED_SLASHES);
                $draft = new Draft();
                $username = $this->IdentityParam('username');
                $currentUser = $this->userService->findOneByUsername($username);
                $draft
                    ->setUser($currentUser)
                    ->setConnectionType($this->connectionType)
                    ->setEndpointSourceType($this->endpointSourceType)
                    ->setEndpointTargetType($this->endpointTargetType)
                    ->setContent($formDataJson)
                ;
                $this->draftService->save($draft);
                $successAction = 'stored';
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => $successAction
                    ]);
            } else {
                if ($this->orderForm->isValid()) {
                    $username = $this->IdentityParam('username');
                    $this->fileTransferRequest->getUser()->setUsername($username);
                    $role = $this->IdentityParam('role');
                    $this->fileTransferRequest->getUser()->setRole($role);
                    if (isset($request->getPost()->toArray()['submit'])) {
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
        } elseif (! empty($request->getQuery()->toArray()['restore'])) {
            $this->enrichRequestWithDataFromDraft();
            $this->orderForm->setData($request->getPost());
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
            if(isset($request->getPost()->toArray()['store'])) {
                $formDataJson = json_encode($request->getPost(), JSON_UNESCAPED_SLASHES);
                $draft = new Draft();
                $username = $this->IdentityParam('username');
                $currentUser = $this->userService->findOneByUsername($username);
                $draft
                    ->setUser($currentUser)
                    ->setConnectionType($this->connectionType)
                    ->setEndpointSourceType($this->endpointSourceType)
                    ->setEndpointTargetType($this->endpointTargetType)
                    ->setContent($formDataJson)
                ;
                $this->draftService->save($draft);
                $successAction = 'stored';
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => $successAction
                    ]);
            } else {
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

    public function storedAction()
    {
        return new ViewModel();
    }

    public function noDraftAvailableAction()
    {
        return new ViewModel();
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
        $queryParams['connection_type'] = ! empty($queryParams['connection_type'])
            ? $queryParams['connection_type']
            : [LogicalConnection::TYPE_CD, LogicalConnection::TYPE_FTGW]
        ;
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

    /**
     * If the user has a Draft,
     * sets the request's method to POST and pass the draft's data as POST data.
     *
     * @return void
     */
    protected function enrichRequestWithDataFromDraft()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $username = $this->IdentityParam('username');
        $currentUser = $this->userService->findOneByUsername($username);
        $draft = $this->draftService->findOneByUser($currentUser);
        if ($draft) {
            $formDataJson = $draft->getContent();
            $formDataArray = json_decode($formDataJson, true);
            $parameters = new Parameters($formDataArray);
            $request->setPost($parameters);
            $request->setMethod(Request::METHOD_POST);
        }
    }

}
