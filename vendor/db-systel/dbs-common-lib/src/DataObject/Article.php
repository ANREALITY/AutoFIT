<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(
 *     name="article",
 *     indexes={@ORM\Index(name="fk_article_product_type_idx", columns={"product_type_name"})
 * })
 * @ORM\Entity
 */
class Article extends AbstractDataObject
{

    /** @var string */
    const TYPE_BASIC = 'basic';
    /** @var string */
    const TYPE_PERSONAL = 'personal';
    /** @var string */
    const TYPE_ON_DEMAND = 'on-demand';

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=16, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var ProductType
     *
     * @ORM\ManyToOne(targetEntity="ProductType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_type_name", referencedColumnName="name")
     * })
     */
    private $productType;

    /**
     * @param string $sku
     *
     * @return Article
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $type
     *
     * @return Article
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ProductType $productType
     *
     * @return Article
     */
    public function setProductType(ProductType $productType)
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * @return ProductType
     */
    public function getProductType()
    {
        return $this->productType;
    }

}
