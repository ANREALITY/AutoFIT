<?php
namespace DbSystel\DataObject;

class Article extends AbstractDataObject
{

    const TYPE_BASIC = 'basic';

    const TYPE_PERSONAL = 'personal';

    const TYPE_ON_DEMAND = 'on-demand';

    /**
     *
     * @var string
     */
    protected $sku;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var ProductType
     */
    protected $productType;

    /**
     *
     * @return string $sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     *
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @return ProductType $productType
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     *
     * @param ProductType $productType
     */
    public function setProductType(ProductType $productType)
    {
        $this->productType = $productType;
    }

}