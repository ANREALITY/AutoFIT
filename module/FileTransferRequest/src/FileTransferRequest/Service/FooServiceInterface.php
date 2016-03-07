<?php
namespace FileTransferRequest\Service;

use DbSystel\DataObject\Customer;

interface FooServiceInterface
{

    /**
     * Should return a set of all fileTransferRequestRequest fileTransferRequests that we can iterate over.
     * Single entries of the array are supposed to be
     * implementing Customer
     *
     * @return array|Customer[]
     */
    public function findAllCustomers();

    /**
     * Should return a single customer
     *
     * @param int $id Identifier of the Customer that should be returned
     * @return Customer
     */
    public function findCustomer($id);

    /**
     * Should save a given implementation of the Customer and return it.
     * If it is an existing Customer the Customer
     * should be updated, if it's a new Customer it should be created.
     *
     * @param Customer $customer
     * @return Customer
     */
    public function saveCustomer(Customer $customer);
}
