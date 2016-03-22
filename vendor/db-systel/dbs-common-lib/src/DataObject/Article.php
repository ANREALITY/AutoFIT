<?php
namespace DbSystel\DataObject;

class Article
{

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
     * @return the $sku
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
     * @return the $description
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
     * @return the $type
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
     * @return the $productType
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     *
     * @param \DataObject\ProductType $productType            
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }
}