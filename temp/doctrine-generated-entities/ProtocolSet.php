<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProtocolSet
 *
 * @ORM\Table(name="protocol_set")
 * @ORM\Entity
 */
class ProtocolSet extends AbstractDataObject
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
