<?php
namespace FileTransferRequest\Service;

use DbSystel\DataObject\AbstractPhysicalConnection;

interface PhysicalConnectionServiceInterface
{

    /**
     * Should return a set of all fileTransferRequestRequest fileTransferRequests that we can iterate over.
     * Single entries of the array are supposed to be
     * implementing PhysicalConnectionInterface
     *
     * @return array|PhysicalConnectionInterface[]
     */
    public function findAllPhysicalConnections();

    /**
     * Should return a single fileTransferRequestRequest fileTransferRequest
     *
     * @param int $id
     *            Identifier of the PhysicalConnection that should be returned
     * @return PhysicalConnectionInterface
     */
    public function findPhysicalConnection($id);

    /**
     * Should save a given implementation of the PhysicalConnectionInterface and return it.
     * If it is an existing PhysicalConnection the PhysicalConnection
     * should be updated, if it's a new PhysicalConnection it should be created.
     *
     * @param PhysicalConnectionInterface $fileTransferRequest
     * @return PhysicalConnectionInterface
     */
    public function savePhysicalConnection(AbstractPhysicalConnection $fileTransferRequestRequest);
}
