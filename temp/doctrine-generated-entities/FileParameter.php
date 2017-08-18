<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * FileParameter
 *
 * @ORM\Table(name="file_parameter", indexes={@ORM\Index(name="fk_file_parameter_file_parameter_set_idx", columns={"file_parameter_set_id"})})
 * @ORM\Entity
 */
class FileParameter extends AbstractDataObject
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=50, nullable=true)
     */
    private $filename;

    /**
     * @var integer
     *
     * @ORM\Column(name="record_length", type="integer", nullable=true)
     */
    private $recordLength;

    /**
     * @var string
     *
     * @ORM\Column(name="blocking", type="string", nullable=true)
     */
    private $blocking;

    /**
     * @var integer
     *
     * @ORM\Column(name="block_size", type="integer", nullable=true)
     */
    private $blockSize;

    /**
     * @var FileParameterSet
     *
     * @ORM\ManyToOne(targetEntity="FileParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $fileParameterSet;



    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $filename
     *
     * @return FileParameter
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param integer $recordLength
     *
     * @return FileParameter
     */
    public function setRecordLength($recordLength)
    {
        $this->recordLength = $recordLength;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRecordLength()
    {
        return $this->recordLength;
    }

    /**
     * @param string $blocking
     *
     * @return FileParameter
     */
    public function setBlocking($blocking)
    {
        $this->blocking = $blocking;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlocking()
    {
        return $this->blocking;
    }

    /**
     * @param integer $blockSize
     *
     * @return FileParameter
     */
    public function setBlockSize($blockSize)
    {
        $this->blockSize = $blockSize;

        return $this;
    }

    /**
     * @return integer
     */
    public function getBlockSize()
    {
        return $this->blockSize;
    }

    /**
     * @param FileParameterSet $fileParameterSet
     *
     * @return FileParameter
     */
    public function setFileParameterSet(\FileParameterSet $fileParameterSet = null)
    {
        $this->fileParameterSet = $fileParameterSet;

        return $this;
    }

    /**
     * @return FileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }
}
