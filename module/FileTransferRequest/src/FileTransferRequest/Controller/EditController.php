<?php
namespace FileTransferRequest\Controller;

use FileTransferRequest\Service\FileTransferRequestService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EditController extends AbstractActionController
{

    protected $fileTransferRequestService;

    protected $fileTransferRequestForm;

    public function __construct(FileTransferRequestService $fileTransferRequestService, FormInterface $fileTransferRequestForm)
    {
        $this->fileTransferRequestService = $fileTransferRequestService;
        $this->fileTransferRequestForm = $fileTransferRequestForm;
    }

    public function createRequestAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $this->fileTransferRequestForm->setData($request->getPost());
            
            if ($this->fileTransferRequestForm->isValid()) {
                try {
                    
                    // \Zend\Debug\Debug::dump($this->fileTransferRequestForm->getData());die();

                    // $fieldsetData = $this->fileTransferRequestForm->getFieldsets()['billing-fieldset'];
                    $test = $this->fileTransferRequestForm->getData();
                    $this->fileTransferRequestService->saveFileTransferRequest($this->fileTransferRequestForm->getData());
                    
                    return $this->redirect()->toRoute('file-transfer-request');
                } catch (\Exception $e) {
                    // Some DB Error happened, log it and let the user know
                }
            }
        }
        
        return new ViewModel(array(
            'form' => $this->fileTransferRequestForm
        ));
    }
}