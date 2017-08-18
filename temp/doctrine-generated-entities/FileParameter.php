<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * FileParameter
 *
 * @ORM\Table(name="file_parameter", indexes={@ORM\Index(name="fk_file_parameter_file_parameter_set_idx", columns={"file_parameter_set_id"})})
 * @ORM\Entity
 */
class FileParameter
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
     * @var \FileParameterSet
     *
     * @ORM\ManyToOne(targetEntity="FileParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file_parameter_set_id", referencedColumnName="id")
     * })
     */
    private $fileParameterSet;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filename
     *
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
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set recordLength
     *
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
     * Get recordLength
     *
     * @return integer
     */
    public function getRecordLength()
    {
        return $this->recordLength;
    }

    /**
     * Set blocking
     *
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
     * Get blocking
     *
     * @return string
     */
    public function getBlocking()
    {
        return $this->blocking;
    }

    /**
     * Set blockSize
     *
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
     * Get blockSize
     *
     * @return integer
     */
    public function getBlockSize()
    {
        return $this->blockSize;
    }

    /**
     * Set fileParameterSet
     *
     * @param \FileParameterSet $fileParameterSet
     *
     * @return FileParameter
     */
    public function setFileParameterSet(\FileParameterSet $fileParameterSet = null)
    {
        $this->fileParameterSet = $fileParameterSet;

        return $this;
    }

    /**
     * Get fileParameterSet
     *
     * @return \FileParameterSet
     */
    public function getFileParameterSet()
    {
        return $this->fileParameterSet;
    }
}
