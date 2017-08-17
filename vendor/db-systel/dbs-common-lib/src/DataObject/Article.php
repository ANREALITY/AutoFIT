<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 */
class Article extends AbstractDataObject
{

    const TYPE_BASIC = 'basic';

    const TYPE_PERSONAL = 'personal';

    const TYPE_ON_DEMAND = 'on-demand';

    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $type;

    /**
     * @var ProductType
     */
    private $productType;

    /**
     * @param string $sku
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
     * @return Article
     */
    public function setProductType(ProductType $productType)
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * @return ProductType $productType
     */
    public function getProductType()
    {
        return $this->productType;
    }

}