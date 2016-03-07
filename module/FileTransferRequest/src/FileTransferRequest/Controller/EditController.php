<?php

namespace FileTransferRequest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use FileTransferRequest\Service\FileTransferRequestServiceInterface;

class EditController extends AbstractActionController
{

    protected $fileTransferRequestService = null;

    protected $fileTransferRequestForm = null;

    public function __construct(FileTransferRequestServiceInterface $fileTransferRequestService, \Zend\Form\FormInterface $fileTransferRequestForm)
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
