<?php
namespace FileTransferRequest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use FileTransferRequest\Service\FileTransferRequestServiceInterface;
use Zend\Form\FormInterface;
use FileTransferRequest\Form\DataPreparator\DataPreparator;

class EditController extends AbstractActionController
{

    protected $fileTransferRequestService = null;

    protected $fileTransferRequestForm = null;

    protected $dataPreparator = null;

    public function __construct(FileTransferRequestServiceInterface $fileTransferRequestService, 
        FormInterface $fileTransferRequestForm, DataPreparator $dataPreparator)
    {
        $this->fileTransferRequestService = $fileTransferRequestService;
        $this->fileTransferRequestForm = $fileTransferRequestForm;
        $this->dataPreparator = $dataPreparator;
    }

    public function createRequestAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $this->fileTransferRequestForm->setData($request->getPost());
            
            if ($this->fileTransferRequestForm->isValid()) {
                try {
                    
                    $preparedData = $this->dataPreparator->prepare($this->fileTransferRequestForm->getData());

                    // \Zend\Debug\Debug::dump($this->fileTransferRequestForm->getData());die();
                    
                    // $fieldsetData = $this->fileTransferRequestForm->getFieldsets()['billing-fieldset'];
                    // $this->fileTransferRequestService->saveFileTransferRequest($this->fileTransferRequestForm->getData());
                    
                    $this->fileTransferRequestService->saveFileTransferRequest($preparedData['fileTransferRequest']);
                    
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
