<?php
namespace MasterData\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Order\Service\ServerService;

class ServerController extends AbstractActionController
{

    /**
     * 
     * @var ServerService
     */
    protected $serverService;

    public function __construct(ServerService $serverService)
    {
        $this->serverService = $serverService;
    }

    public function editAction()
    {
        return new ViewModel();
    }

}
