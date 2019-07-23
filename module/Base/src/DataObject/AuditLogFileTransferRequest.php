<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Base\Annotation\Export;

/**
 * AuditLogFileTransferRequest
 *
 * @ORM\Table(name="audit_log")
 * @ORM\Entity
 */
class AuditLogFileTransferRequest extends AuditLog
{

    /**
     * @var FileTransferRequest
     *
     * @ORM\ManyToOne(targetEntity="FileTransferRequest")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     */
    protected $fileTransferRequest;

    /**
     * @param FileTransferRequest $fileTransferRequest
     *
     * @return AuditLogFileTransferRequest
     */
    public function setFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        $this->fileTransferRequest = $fileTransferRequest;
        return $this;
    }

    /**
     * @return FileTransferRequest
     */
    public function getFileTransferRequest()
    {
        return $this->fileTransferRequest;
    }

}
