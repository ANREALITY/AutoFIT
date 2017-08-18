<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Cluster
 *
 * @ORM\Table(name="cluster", uniqueConstraints={@ORM\UniqueConstraint(name="virtual_node_name_UNIQUE", columns={"virtual_node_name"})})
 * @ORM\Entity
 */
class Cluster
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
     * @ORM\Column(name="virtual_node_name", type="string", length=50, nullable=true)
     */
    private $virtualNodeName;



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
     * Set virtualNodeName
     *
     * @param string $virtualNodeName
     *
     * @return Cluster
     */
    public function setVirtualNodeName($virtualNodeName)
    {
        $this->virtualNodeName = $virtualNodeName;

        return $this;
    }

    /**
     * Get virtualNodeName
     *
     * @return string
     */
    public function getVirtualNodeName()
    {
        return $this->virtualNodeName;
    }
}
