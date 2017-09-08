<?php
namespace AuditLogging\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Order\Service\UserServiceInterface;
use Order\Service\FileTransferRequestServiceInterface;

class AjaxController extends AbstractActionController
{

    /**
     *
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     *
     * @var FileTransferRequestServiceInterface
     */
    protected $fileTransferRequestService;

    public function __construct(UserServiceInterface $userService,
        FileTransferRequestServiceInterface $fileTransferRequestService)
    {
        $this->userService = $userService;
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    public function provideUsersAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $username = isset($data['username']) ? $data['username'] : null;
            $dataList = $this->userService->findAllForAutocomplete($data['username'])->toArray();
            $dataList = array_column($dataList, 'username');
        }

        return new JsonModel($dataList);
    }

    public function provideFileTransferRequestsAction()
    {
        $request = $this->getRequest();
        $dataList = ['error' => 'Acces only for AJAX requests!'];

        if ($request->isXmlHttpRequest()) {
            $data = $request->getQuery('data');
            $changeNumber = isset($data['change_number']) ? $data['change_number'] : null;

            $result = $this->fileTransferRequestService->findAllForAutocomplete($changeNumber);
            $dataList = array_column($result, 'changeNumber');
        }


        return new JsonModel($dataList);
    }

}
