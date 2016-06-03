<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProcessController extends AbstractActionController
{

    protected $fileTransferRequest = null;

    protected $fileTransferRequestService = null;

    protected $orderForm = null;

    protected $connectionType;

    protected $endpointSourceType;

    protected $endpointTargetType;

    protected $authenticationService;

    public function __construct(\DbSystel\DataObject\FileTransferRequest $fileTransferRequest,
        \Order\Service\FileTransferRequestService $fileTransferRequestService)
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

    /**
     *
     * @param field_type $authenticationService
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function startAction()
    {
        return [
            'connectionType' => $this->connectionType
        ];
    }

    public function createAction()
    {
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
                        'action' => 'received'
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
        // $this->orderForm->bind($this->fileTransferRequest);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->orderForm->setData($request->getPost());
            if ($this->orderForm->isValid()) {
                $username = $this->authenticationService->getIdentity()['username'];
                $this->fileTransferRequest->getUser()->setUsername($username);
                $this->fileTransferRequestService->saveOne($this->fileTransferRequest);
                return $this->forward()->dispatch('Order\Controller\Process',
                    [
                        'action' => 'received'
                    ]);
            }
        }

        $id = $this->params()->fromRoute('id', null);
        $fileTransferRequests = $this->fileTransferRequestService->findAllWithBuldledData([], $id);
        $fileTransferRequest = $fileTransferRequests ? $fileTransferRequests[0] : null;

        $this->orderForm->bind($this->fileTransferRequest);

        return [
            'form' => $this->orderForm,
            'connectionType' => $this->connectionType,
            'endpointSourceType' => $this->endpointSourceType,
            'endpointTargetType' => $this->endpointTargetType,
            'fileTransferRequest' => $this->fileTransferRequest
        ];
    }

    public function receivedAction()
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

    public function listOrdersAction()
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

}

