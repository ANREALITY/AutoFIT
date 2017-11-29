<?php
namespace Order\Controller;

use Order\Service\FileTransferRequestServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OwnershipController extends AbstractActionController
{

    /**
     * @var FileTransferRequestServiceInterface
     */
    protected $fileTransferRequestService;

    public function __construct(FileTransferRequestServiceInterface $fileTransferRequestService)
    {
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    public function createAction()
    {
        $orderId = $this->params()->fromRoute('orderId', null);

        return new ViewModel([
            'orderId' => $orderId
        ]);
    }

    public function recallAction()
    {
        $orderId = $this->params()->fromRoute('orderId', null);

        return new ViewModel([
            'orderId' => $orderId
        ]);
    }

    public function acceptAction()
    {
        $orderId = $this->params()->fromRoute('orderId', null);

        return new ViewModel([
            'orderId' => $orderId
        ]);
    }

    public function declineAction()
    {
        $orderId = $this->params()->fromRoute('orderId', null);

        return new ViewModel([
            'orderId' => $orderId
        ]);
    }

    public function showAction()
    {
        $orderId = $this->params()->fromRoute('orderId', null);

        return new ViewModel([
            'orderId' => $orderId
        ]);
    }

    public function listAction()
    {
        return new ViewModel([
            'paginator' => 'PAGINATOR',
        ]);
    }

    public function createdAction()
    {
        return new ViewModel();
    }

    public function recalledAction()
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

}
