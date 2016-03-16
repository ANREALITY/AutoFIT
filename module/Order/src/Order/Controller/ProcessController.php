<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use DbSystel\DataObject\FileTransferRequest;
use Order\Service\FileTransferRequestService;

class ProcessController extends AbstractActionController
{

    protected $orderForm = null;

    protected $fileTransferRequest = null;

    protected $fileTransferRequestService = null;

    public function __construct(FormInterface $orderForm, FileTransferRequest $fileTransferRequest,
        FileTransferRequestService $fileTransferRequestService)
    {
        $this->orderForm = $orderForm;
        $this->fileTransferRequest = $fileTransferRequest;
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    public function indexAction()
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

                // It's just a temporary fake - make it dynamic!
                $this->fileTransferRequest->getUser()->setUsername('foobar');

                $this->fileTransferRequestService->saveFileTransferRequest($this->fileTransferRequest);
            }
        }

        return [
            'form' => $this->orderForm
        ];
    }

    public function listOrdersAction()
    {
        $fileTransferRequests = $this->fileTransferRequestService->findAll()->toArray();

        return new ViewModel([
            'fileTransferRequests' => $fileTransferRequests
        ]);
    }
}

