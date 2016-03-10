<?php
namespace FileTransferRequest\Service;

use DbSystel\DataObject\AbstractEndpoint;

interface EndpointServiceInterface
{

    /**
     * Should return a set of all endpoint fileTransferRequests that we can iterate over.
     * Single entries of the array are supposed to be
     * implementing EndpointInterface
     *
     * @return array|EndpointInterface[]
     */
    public function findAllEndpoints();

    /**
     * Should return a single endpoint fileTransferRequest
     *
     * @param int $id
     *            Identifier of the Endpoint that should be returned
     * @return EndpointInterface
     */
    public function findEndpoint($id);

    /**
     * Should save a given implementation of the EndpointInterface and return it.
     * If it is an existing Endpoint the Endpoint
     * should be updated, if it's a new Endpoint it should be created.
     *
     * @param EndpointInterface $fileTransferRequest
     * @return EndpointInterface
     */
    public function saveEndpoint(AbstractEndpoint $endpoint);
}
