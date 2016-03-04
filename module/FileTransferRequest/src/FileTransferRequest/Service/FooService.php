<?php
namespace FileTransferRequest\Service;

use FileTransferRequest\Mapper\CustomerMapperInterface;
use DbSystel\DataObject\Customer;

class FooService implements FooServiceInterface
{

    /**
     *
     * @var CustomerMapperInterface
     */
    protected $customerMapper;

    /**
     *
     * @param CustomerMapperInterface $customerMapper            
     */
    public function __construct(CustomerMapperInterface $customerMapper)
    {
        $this->customerMapper = $customerMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllCustomers()
    {
        return $this->customerMapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findCustomer($id)
    {
        return $this->customerMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveCustomer(Customer $customer)
    {
        return $this->customerMapper->save($customer);
    }
}
