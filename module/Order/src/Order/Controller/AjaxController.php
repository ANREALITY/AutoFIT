<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Order\Service\ApplicationService;

class AjaxController extends AbstractActionController
{

    protected $applicationService = null;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function provideApplicationsAction()
    {
        $request = $this->getRequest();
        $dataList = [];

        if (true || $request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            if (isset($data['technical_short_name']) && $data['technical_short_name'] != null) {
                $dataList = $this->applicationService->findAllByTechnicalShortName($data['technical_short_name']);
            }
        }

        return new JsonModel($dataList);
    }
}

