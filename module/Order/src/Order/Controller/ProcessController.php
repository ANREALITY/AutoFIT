<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use DbSystel\DataObject\FileTransferRequest;
use Order\Service\FileTransferRequestService;

class ProcessController extends AbstractActionController
{

    protected $fileTransferRequest = null;

    protected $fileTransferRequestService = null;

    protected $orderForm = null;

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

    public function startAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {
        $this->orderForm->bind($this->fileTransferRequest);
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $this->orderForm->setData($request->getPost());
            if ($this->orderForm->isValid()) {
                
                // It's just a temporary fake. @todo make it dynamic!
                $this->fileTransferRequest->getUser()->setUsername($_SESSION['username']);
                
                $this->fileTransferRequestService->saveFileTransferRequest($this->fileTransferRequest);
            }
        }
        
        return [
            'form' => $this->orderForm,
            'connectionType' => $this->connectionType,
            'endpointSourceType' => $this->endpointSourceType,
            'endpointTargetType' => $this->endpointTargetType,
        ];
    }

    public function listOrdersAction()
    {
        $fileTransferRequests = $this->fileTransferRequestService->findAllWithBuldledData();
        
        return new ViewModel([
            'fileTransferRequests' => $fileTransferRequests
        ]);
    }

}

