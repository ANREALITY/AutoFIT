<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity
 */
class Application
{
    /**
     * @var string
     *
     * @ORM\Column(name="technical_short_name", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $technicalShortName;

    /**
     * @var string
     *
     * @ORM\Column(name="technical_id", type="string", length=10, nullable=true)
     */
    private $technicalId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;



    /**
     * Get technicalShortName
     *
     * @return string
     */
    public function getTechnicalShortName()
    {
        return $this->technicalShortName;
    }

    /**
     * Set technicalId
     *
     * @param string $technicalId
     *
     * @return Application
     */
    public function setTechnicalId($technicalId)
    {
        $this->technicalId = $technicalId;

        return $this;
    }

    /**
     * Get technicalId
     *
     * @return string
     */
    public function getTechnicalId()
    {
        return $this->technicalId;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Application
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Application
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
