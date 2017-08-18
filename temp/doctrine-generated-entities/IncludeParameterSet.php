<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncludeParameterSet
 *
 * @ORM\Table(name="include_parameter_set")
 * @ORM\Entity
 */
class IncludeParameterSet extends AbstractDataObject
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
