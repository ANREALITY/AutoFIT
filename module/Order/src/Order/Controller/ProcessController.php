<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use DbSystel\DataObject\FileTransferRequest;

class ProcessController extends AbstractActionController
{

    protected $orderForm = null;

    protected $fileTransferRequest = null;

    public function __construct(FormInterface $orderForm, FileTransferRequest $fileTransferRequest)
    {
        $this->orderForm = $orderForm;
        $this->fileTransferRequest = $fileTransferRequest;
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
                var_dump($this->fileTransferRequest);
                die('#################');
            }
        }
        
        return array(
            'form' => $this->orderForm
        );
    }
}

