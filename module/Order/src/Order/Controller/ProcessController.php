<?php

namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DbSystel\DataObject\FileTransferRequest;

class ProcessController extends AbstractActionController
{

    protected $fileTransferRequest = null;

    protected $fileTransferRequestService = null;

    protected $orderForm = null;

    protected $connectionType = null;

    protected $endpointSourceType = null;

    protected $endpointTargetType = null;

    protected $statusConfig = null;

    protected $authenticationService = null;

    protected $synchronizationService = null;

    public function __construct(\DbSystel\DataObject\FileTransferRequest $fileTransferRequest, \Order\Service\FileTransferRequestService $fileTransferRequestService)
    {
        $this->fileTransferRequest = $fileTransferRequest;
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    /**
     * @param FormInterface $orderForm
     */
    public function setOrderForm($orderForm)
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
     * @param string $statusConfig
     */
    public function setStatusConfig($statusConfig)
    {
        $this->statusConfig = $statusConfig;
    }

    /**
     * @param field_type $authenticationService
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param field_type $synchronizationService
     */
    public function setSynchronizationService($synchronizationService)
    {
        $this->synchronizationService = $synchronizationService;
    }

    public function startAction()
    {
        return [
            'connectionType' => $this->connectionType
        ];
    }

    public function createAction()
    {
        if ($this->isInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        $this->orderForm->bind($this->fileTransferRequest);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->orderForm->setData($request->getPost());
            if ($this->orderForm->isValid()) {
                $username = $this->authenticationService->getIdentity()['username'];
                $this->fileTransferRequest->getUser()->setUsername($username);
                $this->fileTransferRequestService->saveOne($this->fileTransferRequest);
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => 'created'
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

    public function editAction()
    {
        if ($this->isInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        if (! $this->isAllowedOperationForStatus('edit', $this->fileTransferRequest->getStatus())) {
            return $this->redirect()->toRoute('operation-denied-for-status', [
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
                $username = $this->authenticationService->getIdentity()['username'];
                $this->fileTransferRequest->getUser()->setUsername($username);
                $this->fileTransferRequestService->saveOne($this->fileTransferRequest);
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => 'edited'
                    ]);
            }
        }

        $id = $this->params()->fromRoute('id', null);
        $fileTransferRequests = $this->fileTransferRequestService->findAllWithBuldledData([], $id);
        $fileTransferRequest = $fileTransferRequests ? $fileTransferRequests[0] : null;

        return [
            'form' => $this->orderForm,
            'connectionType' => $this->connectionType,
            'endpointSourceType' => $this->endpointSourceType,
            'endpointTargetType' => $this->endpointTargetType,
            'fileTransferRequest' => $this->fileTransferRequest,
            'getHelperFieldsValuesFromObject' => $getHelperFieldsValuesFromObject
        ];
    }

    public function cancelAction()
    {
        if ($this->isInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        if (! $this->isAllowedOperationForStatus('cancel', $this->fileTransferRequest->getStatus())) {
            return $this->redirect()->toRoute('operation-denied-for-status', [
                'operation' => 'cancel',
                'status' => $this->fileTransferRequest->getStatus()
            ]);
        }

        $this->fileTransferRequest->setStatus(FileTransferRequest::STATUS_CANCELED);
        $this->fileTransferRequestService->saveOne($this->fileTransferRequest);

        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'canceled'
            ]
        );
    }

    public function createdAction()
    {
        return new ViewModel();
    }

    public function editedAction()
    {
        return new ViewModel();
    }

    public function canceledAction()
    {
        return new ViewModel();
    }

    public function showOrderAction()
    {
        $id = $this->params()->fromRoute('id', null);
        $fileTransferRequests = $this->fileTransferRequestService->findAllWithBuldledData([], $id);
        $fileTransferRequest = $fileTransferRequests ? $fileTransferRequests[0] : null;

        return new ViewModel([
            'fileTransferRequest' => $fileTransferRequest
        ]);
    }

    public function listMyOrdersAction()
    {
        $userId = ! empty($this->authenticationService->getIdentity()['id']) ? $this->authenticationService->getIdentity()['id'] : null;
        $fileTransferRequests = $this->fileTransferRequestService->findAllWithBuldledData(
            [
                [
                    'user_id' => $userId
                ]
            ]);

        return new ViewModel([
            'fileTransferRequests' => $fileTransferRequests
        ]);
    }

    public function listOrdersAction()
    {
        $fileTransferRequests = $this->fileTransferRequestService->findAllWithBuldledData();

        return new ViewModel([
            'fileTransferRequests' => $fileTransferRequests
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
        return new ViewModel([
            'operation' => $this->params()->fromRoute('operation'),
            'status' => $this->params()->fromRoute('status')
        ]);
    }

    protected function isInSync()
    {
        $isInSync = false;
        $synchronizations = $this->synchronizationService->findAll();
        foreach ($synchronizations as $synchronization) {
            if ($synchronization->getInProgress()) {
                $isInSync = true;
                break;
            }
        }
        return $isInSync;
    }

    protected function isAllowedOperationForStatus($operation, $status)
    {
        $isAllowed =
            $this->statusConfig
            && isset($this->statusConfig['order']['per_operation'][$operation])
            && is_array($this->statusConfig['order']['per_operation'][$operation])
            && in_array($status, $this->statusConfig['order']['per_operation'][$operation])
        ;
        return $isAllowed;
    }

}

