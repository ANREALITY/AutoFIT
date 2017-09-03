<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductType
 *
 * @ORM\Table(name="product_type")
 * @ORM\Entity(readOnly=true)
 */
class ProductType extends AbstractDataObject
{

    /** @var string */
    const NAME_CD = 'cd';
    /** @var string */
    const NAME_FTGW = 'fgw';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=12, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="long_name", type="string", length=64, nullable=true)
     */
    protected $longName;

    /**
     * @param string $name
     *
     * @return ProductType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $longName
     *
     * @return ProductType
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }

}
