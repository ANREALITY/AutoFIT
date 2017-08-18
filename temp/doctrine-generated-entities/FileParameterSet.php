<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * FileParameterSet
 *
 * @ORM\Table(name="file_parameter_set")
 * @ORM\Entity
 */
class FileParameterSet extends AbstractDataObject
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
