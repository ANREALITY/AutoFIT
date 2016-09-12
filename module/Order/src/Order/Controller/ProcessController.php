<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DbSystel\DataObject\FileTransferRequest;
use Order\Service\FileTransferRequestService;

class ProcessController extends AbstractActionController
{

    protected $fileTransferRequest;

    protected $fileTransferRequestService;

    protected $orderForm;

    protected $connectionType;

    protected $endpointSourceType;

    protected $endpointTargetType;

    public function __construct(FileTransferRequest $fileTransferRequest,
        FileTransferRequestService $fileTransferRequestService)
    {
        $this->fileTransferRequest = $fileTransferRequest;
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    /**
     *
     * @param FormInterface $orderForm
     */
    public function setOrderForm($orderForm)
    {
        $this->orderForm = $orderForm;
    }

    /**
     *
     * @param string $connectionType
     */
    public function setConnectionType($connectionType)
    {
        $this->connectionType = $connectionType;
    }

    /**
     *
     * @param string $endpointSourceType
     */
    public function setEndpointSourceType($endpointSourceType)
    {
        $this->endpointSourceType = $endpointSourceType;
    }

    /**
     *
     * @param string $endpointTargetType
     */
    public function setEndpointTargetType($endpointTargetType)
    {
        $this->endpointTargetType = $endpointTargetType;
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
        if ($this->IsInSync()) {
            return $this->redirect()->toRoute('sync-in-progress');
        }

        if (! $this->OrderStatusChecker()->isAllowedOperationForStatus('edit', $this->fileTransferRequest->getStatus())) {
            return $this->redirect()->toRoute('operation-denied-for-status',
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
                $this->fileTransferRequestService->saveOne($this->fileTransferRequest);
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => 'edited'
                    ]);
            }
        }

        $id = $this->params()->fromRoute('id', null);
        $paginator = $this->fileTransferRequestService->findAllWithBuldledData([], $id);
        $fileTransferRequests = $paginator->getCurrentItems();
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
        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => 'updateStatus',
                'operation' => $this->params('action'),
                'status' => FileTransferRequest::STATUS_CANCELED,
                'confirmationAction' => 'canceled',
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
            return $this->redirect()->toRoute('operation-denied-for-status',
                [
                    'operation' => $operation,
                    'status' => $this->fileTransferRequest->getStatus()
                ]);
        }

        $this->fileTransferRequest->setStatus($status);
        $this->fileTransferRequestService->saveOne($this->fileTransferRequest);

        return $this->forward()->dispatch('Order\Controller\Process',
            [
                'action' => $confirmationAction
            ]);
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

    public function acceptedAction()
    {
        return new ViewModel();
    }

    public function declinedAction()
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
        $paginator = $this->fileTransferRequestService->findAllWithBuldledData([], $id, null, false);
        $fileTransferRequests = $paginator->getCurrentItems();
        $fileTransferRequest = $fileTransferRequests ? $fileTransferRequests[0] : null;

        return new ViewModel([
            'fileTransferRequest' => $fileTransferRequest,
            'userId' => $this->IdentityParam('id'),
            'userRole' => $this->IdentityParam('role'),
        ]);
    }

    public function listMyOrdersAction()
    {
        $userId = $this->IdentityParam('id');
        $page = $this->params()->fromRoute('page');
        $paginator = $this->fileTransferRequestService->findAllWithBuldledData(
            [
                [
                    'user_id' => $userId
                ]
            ], null, $page);

        return new ViewModel([
            'userId' => $this->IdentityParam('id'),
            'userRole' => $this->IdentityParam('role'),
            'paginator' => $paginator,
        ]);
    }

    public function listOrdersAction()
    {
        $page = $this->params()->fromRoute('page');
        $paginator = $this->fileTransferRequestService->findAllWithBuldledData([], null, $page);

        return new ViewModel([
            'userId' => $this->IdentityParam('id'),
            'userRole' => $this->IdentityParam('role'),
            'paginator' => $paginator,
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

}

