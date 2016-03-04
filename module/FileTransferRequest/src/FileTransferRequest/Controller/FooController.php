<?php

namespace FileTransferRequest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use FileTransferRequest\Service\FooService;
use DbSystel\DataObject\Customer;

class FooController extends AbstractActionController
{
    
    const INPUT_DATA = [
        'id' => 1,
        'name' => 'Hey Ho',
    ];

    protected $fooService = null;

    public function __construct(FooService $fooService)
    {
        $this->fooService = $fooService;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function barAction()
    {
        $customer = new Customer();
        $customer->setId(static::INPUT_DATA['id']);
        $customer->setName(static::INPUT_DATA['name']);
        $this->fooService->saveCustomer($customer);
        return new ViewModel();
    }


}

