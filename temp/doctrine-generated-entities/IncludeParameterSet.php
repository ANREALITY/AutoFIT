<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * IncludeParameterSet
 *
 * @ORM\Table(name="include_parameter_set")
 * @ORM\Entity
 */
class IncludeParameterSet
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
