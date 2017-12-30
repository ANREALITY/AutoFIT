<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Article
 *
 * @ORM\Table(
 *     name="article",
 *     indexes={
 *         @ORM\Index(name="fk_article_product_type_idx", columns={"product_type_name"})
 *     }
 * )
 * @ORM\Entity(readOnly=true)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "basic" = "ArticleBasic",
 *     "personal" = "ArticlePersonal",
 *     "on-demand" = "ArticleOnDemand"
 * })
 */
abstract class Article extends AbstractDataObject
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
     *
     * @Groups({"export"})
     */
    protected $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=true)
     */
    protected $description;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var ProductType
     *
     * @ORM\ManyToOne(targetEntity="ProductType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_type_name", referencedColumnName="name")
     * })
     */
    protected $productType;

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
        $type = $this->type ?: null;
        switch(get_class($this)) {
            case ArticleBasic::class:
                $type = self::TYPE_BASIC;
                break;
            case ArticlePersonal::class:
                $type = self::TYPE_PERSONAL;
                break;
            case ArticleOnDemand::class:
                $type = self::TYPE_ON_DEMAND;
                break;
        }
        return $type;
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
