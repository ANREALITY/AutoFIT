<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointFtgwAwsS3
 *
 * @ORM\Table(name="endpoint_ftgw_aws_s3")
 * @ORM\Entity
 */
class EndpointFtgwAwsS3 extends AbstractEndpoint
{

    /**
     * @var string
     *
     * @ORM\Column(name="bucket_name", type="string", length=50, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $bucketName;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $folder;

    /**
     * @param string $bucketName
     *
     * @return EndpointFtgwAwsS3
     */
    public function setBucketName($bucketName)
    {
        $this->bucketName = $bucketName;

        return $this;
    }

    /**
     * @return string
     */
    public function getBucketName()
    {
        return $this->bucketName;
    }

    /**
     * @param string $folder
     *
     * @return EndpointFtgwAwsS3
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

}
