<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use DbSystel\DataObject\FileTransferRequest;

class ProcessController extends AbstractActionController
{

    protected $orderForm = null;
    protected $fileTransferRequestPrototype = null;

    public function __construct(FormInterface $orderForm, FileTransferRequest $fileTransferRequestPrototype)
    {
        $this->orderForm = $orderForm;
        $this->fileTransferRequestPrototype = $fileTransferRequestPrototype;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {
        $this->orderForm->bind($this->fileTransferRequestPrototype);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->orderForm->setData($request->getPost());
            
            if ($this->orderForm->isValid()) {
                var_dump($this->fileTransferRequestPrototype);
            }
        }
        
        return array(
            'form' => $this->orderForm
        );
    }
}

