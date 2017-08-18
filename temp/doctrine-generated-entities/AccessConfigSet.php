<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccessConfigSet
 *
 * @ORM\Table(name="access_config_set")
 * @ORM\Entity
 */
class AccessConfigSet extends AbstractDataObject
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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
